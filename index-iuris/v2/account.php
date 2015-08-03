<?php
/**
 * @file account.php
 * Displays user account details
 */

$dialog = "";
if (isset($_POST["action"])) {
  require_once "includes/config.php";
  global $mysqli;

  $oldPass   = $mysqli->real_escape_string($_POST["oldPassword"]);
  $password1 = $mysqli->real_escape_string($_POST["password1"]);
  $password2 = $mysqli->real_escape_string($_POST["password2"]);

  if (strcmp($password1, $password2) === 0) {
    $oldPassHash = hash("sha512", $oldPass);
    $newPassHash = hash("sha512", $password1);

    $statement = $mysqli->prepare("SELECT password_hash FROM users WHERE id = ? LIMIT 1");
    $statement->bind_param("i", $_SESSION["user_id"]);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result($databasePass);

    if ($statement->fetch()) {
      if (strcmp($oldPassHash, $databasePass) === 0) {
        $updater = $mysqli->prepare("UPDATE users SET password_hash = ? WHERE id = ? LIMIT 1");
        $updater->bind_param("si", $newPassHash, $_SESSION["user_id"]);
        $updater->execute();
        $updater->store_result();

        if ($updater->error) {
          $dialog = "There was an error trying to update your password. (" . $updater->errno . ") - " . $updater->error;
        } else {
          $dialog = "Your password has been successfully updated.";
        } // if ($updater->error)
      } else {
        $dialog = "The old password does not match.";
      } // if (strcmp($oldPassHash, $databasePass) === 0)
    } else {
      $dialog = "There was an error accessing your account. (" . $statement->errno . ") - " . $statement->error;
    } // if ($statement->fetch())
  } else {
    $dialog = "Your passwords do not match.";
  } // if (strcmp($password1, $password2) === 0)
} // if (isset($_POST["action"]))

$title = "Account";
$loginRequired = true;
require "includes/header.php";
?>

<div class="container">
  <div class="row page-header">
    <div class="col-xs-12">
      <h1>Account Details</h1>
      <?php if ($dialog !== ""): ?>
        <p class="lead text-danger text-center"><?php print $dialog; ?></p>
      <?php endif; ?>
      <?php if (isset($_GET["action"]) && $_GET["action"] == "update"): ?>
        <p class="lead">Update your password.</p>
      <?php endif; ?>
    </div>
  </div>

  <div class="row">

    <?php if (isset($_GET["action"]) && $_GET["action"] == "update"): ?>
      <div class="col-xs-6">
        <form class="form-horizontal" action="<?php print htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" id="accountUpdate">
          <fieldset>
            <section class="form-group">
              <label for="old" class="col-xs-4 control-label">Old Password</label>
              <div class="col-xs-8">
                <input type="password" class="form-control" id="old" name="oldPassword" required="">
              </div>
            </section>

            <section class="form-group">
              <label for="password1" class="col-xs-4 control-label">Password</label>
              <div class="col-xs-8">
                <input type="password" class="form-control" id="password1" name="password1" required="">
              </div>
            </section>

            <section class="form-group">
              <label for="password2" class="col-xs-4 control-label">Confirm Password</label>
              <div class="col-xs-8">
                <input type="password" class="form-control" id="password2" name="password2" required="">
              </div>
            </section>

            <section class="form-group">
              <input type="hidden" name="action" value="">
              <div class="col-xs-8 pull-right">
                <button type="submit" class="btn btn-success">Update password</button>
              </section>
            </div>
          </fieldset>
        </form>
      </div>
    <?php else: ?>
      <div class="col-xs-4">
        <div class="panel panel-default">
          <div class="panel-heading">Username</div>
          <div class="panel-body"><?php print $_SESSION["username"]; ?></div>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="panel panel-default">
          <div class="panel-heading">Password</div>
          <div class="panel-body"><a href="account?action=update">Change Password</a></div>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="panel panel-default">
          <div class="panel-heading">Role</div>
          <div class="panel-body"><?php print $_SESSION["user_role"]; ?></div>
        </div>
      </div>
    <?php endif;?>

  </div>
</div>

<?php require "includes/footer.php"; ?>
