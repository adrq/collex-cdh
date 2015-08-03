<?php
/**
 * @file login.php
 * Prints the login page.
 *
 * 7/28/15 - Lichen has PHP v.5.3.3 installed whereas the local machines have PHP v.5.5.x.
 * Since this is the case, some changes had to be made.
 */

$dialog = "";
if (isset($_POST["username"], $_POST["password"])) {
  require_once "includes/config.php";
  global $mysqli;

  $username = $mysqli->real_escape_string($_POST["username"]);
  $password = $mysqli->real_escape_string($_POST["password"]);

  $statement = $mysqli->prepare("SELECT id, password_hash, user_role FROM users WHERE username = ?");
  $statement->bind_param("s", $username);
  $statement->execute();
  $statement->store_result();
  $statement->bind_result($id, $pass, $role);

  if ($statement->num_rows == 1) {
    $statement->fetch();

    // 7/28/15 - Add the following when PHP v5.5.x is installed on Lichen:
    // if (password_verify($password, $pass)) {

    // 7/28/15 - Remove the following when PHP v5.5.x is installed on Lichen:
    $password = hash("sha512", $password);
    if ($pass == $password) {
      $_SESSION["user_id"]   = $id;
      $_SESSION["username"]  = $username;
      $_SESSION["logged-in"] = true;
      $_SESSION["user_role"] = $role;

      header("Location: account");
    } else {
      $dialog = "Please try your password again.";
    } // if (password_verify($password, $pass))
  } else {
    $dialog = "This username does not exist.";
  } // if ($statement->num_rows == 1)
} // if (isset($_POST["username"], $_POST["password"]))

$title = "Login";
$loginRequired = false;
require "includes/header.php";
?>

<div class="container">
  <div class="row page-header">
    <div class="col-xs-12">
      <h1>Login</h1>
      <?php if ($dialog !== ""): ?>
        <p class="lead text-danger text-center"><?php print $dialog; ?></p>
      <?php endif; ?>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-6 center-block">
      <form class="form-horizontal" action="<?php print htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
        <fieldset>
          <div class="form-group">
            <label for="username" class="col-xs-4 control-label">Username</label>
            <div class="col-xs-8">
              <input type="text" class="form-control" id="username" name="username" autofocus="">
            </div>
          </div>

          <div class="form-group">
            <label for="password" class="col-xs-4 control-label">Password</label>
            <div class="col-xs-8">
              <input type="password" class="form-control" id="password" name="password">
            </div>
          </div>

          <div class="form-group">
            <div class="col-xs-2 pull-right">
              <button type="submit" class="btn btn-primary col-xs-12">Login</button>
            </div>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>

<?php require "includes/footer.php"; ?>
