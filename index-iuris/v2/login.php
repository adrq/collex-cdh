<?php
/**
 * @file login.php
 * Prints the login page.
 */
$title = "Login";
$loginRequired = false;
require "includes/header.php";

$loginValid   = true;
$loginMessage = "";

if (isset($_POST["username"], $_POST["password"])) {
  global $mysqli;
  $username = trim($_POST["username"]);
  $password = trim($_POST["password"]);

  $statement = $mysqli->prepare("SELECT id, password_hash FROM users WHERE username = ?");
  $statement->bind_param("s", $username);
  $statement->execute();
  $statement->store_result();
  $statement->bind_result($id, $pass);

  if ($statement->num_rows == 1) {
    $statement->fetch();

    if (password_verify($password, $pass)) {
      $_SESSION["user_id"]   = $id;
      $_SESSION["username"]  = $username;
      $_SESSION["logged-in"] = true;

      ?><script>window.location = "index";</script><?php
    } else {
      $loginValid   = false;
      $loginMessage = "- Please try again.";
    } // if (password_verify($password, $pass))
  } else {
    $loginValid   = false;
    $loginMessage = "- This username does not exist.";
  } // if ($statement->num_rows == 1)
} // if (isset($_POST["username"], $_POST["password"]))
?>

<div class="container">
  <div class="row page-header">
    <div class="col-xs-6 center-block">
      <form class="form-horizontal" action="<?php print htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
        <legend>Login <?php print $loginValid ? "" : $loginMessage; ?></legend>
        <fieldset>
          <div class="form-group">
            <label for="username" class="col-xs-4 control-label">Username</label>
            <div class="col-xs-8 <?php print $loginValid ? '' : 'has-error'; ?>">
              <input type="text" class="form-control" id="username" name="username">
            </div>
          </div>

          <div class="form-group">
            <label for="password" class="col-xs-4 control-label">Password</label>
            <div class="col-xs-8 <?php print $loginValid ? '' : 'has-error'; ?>">
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
