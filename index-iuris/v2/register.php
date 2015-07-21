<?php
/**
 * @file register.php
 * Prints out the registration page.
 */
$title = "Register";
require "includes/header.php";
?>
<div class="container">
  <div class="row page-header">
    <div class="col-xs-6 center-block">
      <?php if (!isset($_POST["username"])): ?>
        <form class="form-horizontal" action="<?php print htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
          <legend>Register</legend>
          <fieldset>
            <div class="form-group">
              <label for="username" class="col-xs-2 control-label">Username</label>
              <div class="col-xs-10">
                <input type="text" class="form-control" id="username" name="username">
              </div>
            </div>

            <div class="form-group">
              <label for="password1" class="col-xs-2 control-label">Password</label>
              <div class="col-xs-10">
                <input type="password" class="form-control" id="password1" name="password1">
              </div>
            </div>

            <div class="form-group">
              <label for="password2" class="col-xs-2 control-label">Password, Again</label>
              <div class="col-xs-10">
                <input type="password" class="form-control" id="password2" name="password2">
              </div>
            </div>

            <div class="form-group">
              <div class="col-xs-2">
                <button type="submit" class="btn btn-primary col-xs-12">Register</button>
              </div>
            </div>
          </fieldset>
        </form>
      <?php
      else:
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_BASE);

        if ($mysqli->connect_error) {
          exit("<h2 class='text-danger'>Database connection error. (" . $mysqli->connect_errno . ")</h2>");
        }

        $username  = $mysqli->real_escape_string($_POST["username"]);
        $password  = "";
        $password1 = $mysqli->real_escape_string($_POST["password1"]);
        $password2 = $mysqli->real_escape_string($_POST["password2"]);

        if (strcmp($password1, $password2) !== 0) {
          exit("<h3 class='text-danger'>Passwords do not match.</h3>");
        } else {
          $password = password_hash($password1, PASSWORD_DEFAULT);
        }

        $statement = $mysqli->prepare("SELECT 1 FROM users WHERE username = ?");
        $statement->bind_param("s", $username);
        $statement->execute();
        $statement->store_results();

        $register;
        $action = "";

        if ($statement->num_rows == 1) {
          $register = $mysqli->prepare("UPDATE users SET password_hash = ? WHERE username = ?");
          $register->bind_param("ss", $password, $username);
          $action = "updated";
        } else {
          $register = $mysqli->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
          $register->bind_param("ss", $username, $password);
          $action = "created";
        }

        $register->execute();
        $register->store_results();

        if ($register->errno) {
          print "<h3 class='text-danger'>There was an error trying to register. (" . $register->errno . ")</h3>";
        } else {
          print "<h3>User " . $action . " successfully! <a href='login'>Login</a></h3>";
        }

        $mysqli->close();
      endif;
      ?>
    </div>
  </div>
</div>

<?php require "includes/footer.php"; ?>