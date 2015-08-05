<?php
/**
 * @file login.php
 * Prints the login page.
 *
 * 7/28/15 - Lichen has PHP v.5.3.3 installed whereas the local machines have PHP v.5.5.x.
 * Since this is the case, some changes had to be made.
 *
 * Replace hash("sha512", {String}) with password_verify()
 */

$dialog = isset($_GET["dialog"]) ? $_GET["dialog"] : "";
if (isset($_POST["username"], $_POST["password"])) {
  require_once "includes/config.php";
  global $mysqli;

  $username = $mysqli->real_escape_string($_POST["username"]);
  $password = hash("sha512", $_POST["password"]);

  $statement = $mysqli->prepare("SELECT id, password_hash, user_role FROM users WHERE username = ?");
  $statement->bind_param("s", $username);
  $statement->execute();
  $statement->store_result();
  $statement->bind_result($id, $pass, $role);

  if ($statement->num_rows == 1) {
    $statement->fetch();
    if ($pass == $password) {
      $_SESSION["user_id"]   = $id;
      $_SESSION["username"]  = $username;
      $_SESSION["logged-in"] = true;
      $_SESSION["user_role"] = $role;

      header("Location: account");
    } else {
      $dialog = "Please try your password again.";
    } // if ($pass == $password)
  } else {
    $dialog = "This username does not exist.";
  } // if ($statement->num_rows == 1)
} // if (isset($_POST["username"], $_POST["password"]))

if (isset($_POST["username"]) && !isset($_POST["password"])) {
  require_once "includes/userFunctions.php";

  $dialog = sendPasswordReset($_POST["username"]);
}

if (isset($_POST["email"])) {

}

// I literally made these up.
if (isset($_GET["error"])) {
  switch ($_GET["error"]) {
    case 4:
      $dialog = "Expired ID";
      break;
    case 5:
      $dialog = "Invalid Username";
      break;
    case 7:
      $dialog = "Error resetting password.";
      break;
    case 12:
      $dialog = "Invalid ID";
      break;
  }
}

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
        <?php if ($dialog == "This username does not exist."): ?>
          <a href="register">Do you need to register?</a>
        <?php endif; ?>
      <?php endif; ?>

      <?php if (isset($_GET["forgot"]) && $_GET["forgot"] == "password"): ?>
        <p class="lead">Password Retrieval</p>
      <?php elseif (isset($_GET["forgot"]) && $_GET["forgot"] == "username"): ?>
        <p class="lead">Username Retrieval</p>
      <?php endif; ?>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-6 center-block">
      <form class="form-horizontal" action="<?php print htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
        <fieldset>
          <?php if (isset($_GET["forgot"]) && $_GET["forgot"] == "password"): ?>
            <section class="form-group">
              <label for="username" class="col-xs-4 control-label">Username</label>
              <div class="col-xs-8">
                <input type="text" class="form-control" id="username" name="username" autofocus="">
              </div>
            </section>

            <section class="form-group">
              <div class="col-xs-12">
                <button type="submit" class="btn btn-default pull-right">Submit</button>
              </div>
            </section>
          <?php elseif (isset($_GET["forgot"]) && $_GET["forgot"] == "username"): ?>
            <section class="form-group">
              <label for="email" class="col-xs-4 control-label">Email</label>
              <div class="col-xs-8">
                <input type="email" class="form-control" id="email" name="email">
              </div>
            </section>

            <section class="form-group">
              <div class="col-xs-12">
                <button type="submit" class="btn btn-default pull-right">Submit</button>
              </div>
            </section>
          <?php else: ?>
            <section class="form-group">
              <label for="username" class="col-xs-4 control-label">Username</label>
              <div class="col-xs-8">
                <input type="text" class="form-control" id="username" name="username" autofocus="">
              </div>
            </section>

            <section class="form-group">
              <label for="password" class="col-xs-4 control-label">Password</label>
              <div class="col-xs-8">
                <input type="password" class="form-control" id="password" name="password">
              </div>
            </section>

            <section class="form-group">
              <div class="col-xs-4 text-right">
                <a href="login?forgot=password" style="display: block; margin-top: 11px;">Forgot your password?</a>
              </div>
              <div class="col-xs-8">
                <button type="submit" class="btn btn-primary pull-right">Login</button>
              </div>
            </section>
          <?php endif; ?>
        </fieldset>
      </form>
    </div>
  </div>
</div>

<?php require "includes/footer.php"; ?>
