<?php
/**
 * @file userFunctions.php
 * Functionalities used throughout the website focused mainly on the user.
 */

// Assure that the config file is imported prior.
require_once "config.php";

// Assure error reporting is on.
error_reporting(E_ALL);
ini_set("display_errors", "On");

/**
 * Registers a user.
 *
 * @param {String} $username
 * @param {String} $password1: The 1st password confirmation.
 * @param {String} $password2: The 2nd password confirmation.
 * @param {String} $email
 * @param {String} $captcha: The CAPTCHA value.
 */
function register($username, $password1, $password2, $email, $captcha) {
  global $mysqli;
  $email     = $mysqli->real_escape_string(trim($email));
  $username  = $mysqli->real_escape_string(trim($username));
  $password1 = $mysqli->real_escape_string(trim($password1));
  $password2 = $mysqli->real_escape_string(trim($password2));
  $response  = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . CAPTCHA_SECRET_KEY . "&response=" . $captcha));

  if ($response->success != 1) {
    if ($response->{"error-codes"}[0] == "missing-input-response") {
      return "The CAPTCHA response is missing.";
    } else if ($response->{"error-codes"}[0] == "invalid-input-response") {
      return "The CAPTCHA response is invalid or malformed.";
    } else {
      return "Something went wrong while trying to validate the CAPTCHA. Please try again.";
    }
  } // if ($response->success != 1)

  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $statement = $mysqli->prepare("SELECT 1 FROM users WHERE email = ?");
    $statement->bind_param("s", $email);
    $statement->execute();
    $statement->store_result();

    if ($statement->num_rows == 1) {
      return "This email address is already in use.";
    }
  } else {
    return "Please enter in a valid email.";
  } // if (filter_var($email, FILTER_VALIDATE_EMAIL))

  if (strcmp($password1, $password2) === 0) {
    $password  = hash("sha512", $password1);
    $statement = $mysqli->prepare("SELECT 1 FROM users WHERE username = ?");
    $statement->bind_param("s", $username);
    $statement->execute();
    $statement->store_result();

    if ($statement->num_rows == 1) {
      return "This username is already in use.";
    }

    $statement = $mysqli->prepare("INSERT INTO users (username, password_hash, user_role, email, email_verify) VALUES (?, ?, 'contributor', ?, 0)");
    $statement->bind_param("sss", $username, $password, $email);
    $statement->execute();
    $statement->store_result();

    if ($statement->error) {
      return "There was an error trying to get you registered. (" . $statement->errno . ") - " . $statement->error;
    } else {
      $_SESSION["user_id"]   = $statement->insert_id;
      $_SESSION["username"]  = $username;
      $_SESSION["logged-in"] = true;
      $_SESSION["user_role"] = "contributor";

      sendEmailVerification($email);

      return "Success";
    }
  } else {
    return "Your passwords do not match.";
  } // if (strcmp($password1, $password2) === 0)
} // function register($username, $password1, $password2, $email, $captcha)

/**
 * Sends off a email verification.
 *
 * @param {String} $email: The receiving email.
 * @return {Boolean}
 */
function sendEmailVerification($email) {
  $verify = ROOT_FOLDER . "verify?id=" . bin2hex(mcrypt_encrypt(MCRYPT_BLOWFISH, MD5_KEY, base_convert($_SESSION["user_id"], 10, 36), "ecb"));

  $message  = "Hello " . $_SESSION["username"] . ",<br><br>";
  $message .= "Welcome to Index Iuris!<br><br>";
  $message .= "We would like for you to verify your email address. This email address will only be used for password recovery.<br><br>";
  $message .= "Please visit <a href='" . $verify . "'>this verification link</a> or copy the following link into your browser to verify your email address.<br><br>";
  $message .= $verify . "<br><br>";
  $message .= "Thank you,<br>The Index Iuris Team";

  $headers  = "From: cdh@sc.edu \r\n";
  $headers .= "Reply-To: cdh@sc.edu \r\n";
  $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
  $headers .= "MIME-Version: 1.0 \r\n";
  $headers .= "Content-Type: text/html; charset=UTF-8";

  return mail($email, "Email Verification", $message, $headers);
}

/**
 * Updates a user's email address.
 *
 * @param {String} $oldEmail: The old email address.
 * @param {String} $newEmail: The new email address.
 * @return {String}
 */
function updateEmail($oldEmail, $newEmail) {
  global $mysqli;

  // Assure the emails have been escaped.
  $oldEmail = $mysqli->real_escape_string(trim($oldEmail));
  $newEmail = $mysqli->real_escape_string(trim($newEmail));

  // Assure new email does not exist.
  $statement = $mysqli->prepare("SELECT 1 FROM users WHERE email = ?");
  $statement->bind_param("s", $newEmail);
  $statement->execute();
  $statement->store_result();

  if ($statement->num_rows == 1) {
    return "This email address is already in use.";
  }

  // Assure the old email is correct.
  $statement = $mysqli->prepare("SELECT 1 FROM users WHERE id = ? AND email = ?");
  $statement->bind_param("is", $_SESSION["user_id"], $oldEmail);
  $statement->execute();
  $statement->store_result();

  if ($statement->num_rows === 0) {
    return "Incorrect old email address.";
  }

  // Update new email address.
  $statement = $mysqli->prepare("UPDATE users SET email = ?, email_verify = FALSE WHERE id = ? LIMIT 1");
  $statement->bind_param("si", $newEmail, $_SESSION["user_id"]);
  $statement->execute();
  $statement->store_result();

  sendEmailVerification($newEmail);

  return $statement->affected_rows > 0 ? "Email address updated successfully. Verification sent." : "Failed to update your email address.";
}

/**
 * Update a user's password.
 *
 * @param {String} $oldPassword: The old password.
 * @param {String} $newPassword: The new password.
 * @return {String}
 */
function updatePassword($oldPassword, $newPassword) {
  global $mysqli;

  // Note: We do not have to escape the passwords due to the fact that
  // they will be hashed prior to touching the database.

  // Hash the passwords.
  $oldPassword = hash("sha512", trim($oldPassword));
  $newPassword = hash("sha512", trim($newPassword));

  // Assure the old password is correct.
  $statement = $mysqli->prepare("SELECT password_hash FROM users WHERE id = ? LIMIT 1");
  $statement->bind_param("i", $_SESSION["user_id"]);
  $statement->execute();
  $statement->store_result();
  $statement->bind_result($storedPass);
  $statement->fetch();

  if (strcmp($storedPass, $oldPassword) !== 0) {
    return "Incorrect old password.";
  }

  // Update new password.
  $statement = $mysqli->prepare("UPDATE users SET password_hash = ? WHERE id = ? LIMIT 1");
  $statement->bind_param("si", $newPassword, $_SESSION["user_id"]);
  $statement->execute();
  $statement->store_result();

  return $statement->affected_rows > 0 ? "Password updated successfully." : "Failed to update your password.";
}