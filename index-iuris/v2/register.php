<?php
/**
 * @file register.php
 * Prints out the registration page.
 *
 * 7/28/15 - Lichen has PHP v.5.3.3 installed whereas the local machines have PHP v.5.5.x.
 * Since this is the case, some changes had to be made.
 */

$dialog = "";
if (isset($_POST["username"], $_POST["password1"], $_POST["password2"], $_POST["g-recaptcha-response"])) {
  require_once "includes/config.php";

  $captcha  = $_POST["g-recaptcha-response"];
  $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . CAPTCHA_SECRET_KEY . "&response=" . $captcha));
  if ($response->success != 1) {
    if ($response->{"error-codes"}[0] == "missing-input-response") {
      $dialog = "The CAPTCHA response is missing.";
    } else if ($response->{"error-codes"}[0] == "invalid-input-response") {
      $dialog = "The CAPTCHA response is invalid or malformed.";
    } else {
      $dialog = "Something went wrong while trying to validate the CAPTCHA. Please try again.";
    }
  }

  global $mysqli;
  $username  = $mysqli->real_escape_string($_POST["username"]);
  $password1 = $mysqli->real_escape_string($_POST["password1"]);
  $password2 = $mysqli->real_escape_string($_POST["password2"]);

  if (strcmp($password1, $password2) === 0) {
    $password = hash("sha512", $password1);

    $statement = $mysqli->prepare("SELECT 1 FROM users WHERE username = ?");
    $statement->bind_param("s", $username);
    $statement->execute();
    $statement->store_result();

    if ($statement->num_rows == 1) {
      $dialog = "This user already exists.";
    } else {
      $register = $mysqli->prepare("INSERT INTO users (username, password_hash, user_role) VALUES (?, ?, 'contributor')");
      $register->bind_param("ss", $username, $password);
      $register->execute();
      $register->store_result();

      if ($register->errno) {
        $dialog = "There was an error trying to get you registered. (" . $register->errno . ") - " . $register->error;
      } else {
        $_SESSION["user_id"]   = $register->insert_id;
        $_SESSION["username"]  = $username;
        $_SESSION["logged-in"] = true;
        $_SESSION["user_role"] = "contributor";

        header("Location: account");
      } // if ($register->errno)
    } // if ($statement->num_rows == 1)
  } else {
    $dialog = "Your passwords do not match.";
  } // if (strcmp($password1, $password2) === 0)
} // if (isset($_POST["username"], $_POST["password1"], $_POST["password2"]))

$title = "Register";
$loginRequired = false;
require "includes/header.php";
?>
<div class="container">
  <div class="row page-header">
    <div class="col-xs-12">
      <h1>Register</h1>
      <?php if ($dialog !== ""): ?>
        <p class="lead text-danger text-center"><?php print $dialog; ?></p>
      <?php endif; ?>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-6 center-block">
      <form class="form-horizontal" action="<?php print htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
        <fieldset>
          <section class="form-group">
            <label for="username" class="col-xs-4 control-label">Username</label>
            <div class="col-xs-8">
              <input type="text" class="form-control" id="username" name="username" autofocus="">
            </div>
          </section>

          <section class="form-group">
            <label for="password1" class="col-xs-4 control-label">Password</label>
            <div class="col-xs-8">
              <input type="password" class="form-control" id="password1" name="password1">
            </div>
          </section>

          <section class="form-group">
            <label for="password2" class="col-xs-4 control-label">Confirm Password</label>
            <div class="col-xs-8">
              <input type="password" class="form-control" id="password2" name="password2">
            </div>
          </section>

          <section class="form-group">
            <div class="col-xs-8 pull-right">
              <div class="g-recaptcha" data-sitekey="6LcrxgkTAAAAAKZk3YRaQzfxOB4qlJ1fyCRxXk8q"></div>
            </div>
          </section>

          <section class="form-group">
            <div class="col-xs-3 pull-right">
              <button type="submit" class="btn btn-primary col-xs-12">Register</button>
            </div>
          </section>
        </fieldset>
      </form>
    </div>
  </div>
</div>

<?php require "includes/footer.php"; ?>
