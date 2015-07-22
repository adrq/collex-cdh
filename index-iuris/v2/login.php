<?php
/**
 * @file login.php
 * Prints the login page.
 */
$title = "Login";
require "includes/header.php";
?>
<div class="container">
  <div class="row page-header">
    <div class="col-xs-6 center-block">
      <?php if (!isset($_POST["username"])): ?>
        <form class="form-horizontal" action="<?php print htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
          <legend>Login</legend>
          <fieldset>
            <div class="form-group">
              <label for="username" class="col-xs-2 control-label">Username</label>
              <div class="col-xs-10">
                <input type="text" class="form-control" id="username" name="username">
              </div>
            </div>

            <div class="form-group">
              <label for="password" class="col-xs-2 control-label">Password</label>
              <div class="col-xs-10">
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
      <?php
      else:
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_BASE);

        if ($mysqli->connect_error) {
          exit("<h2 class='text-danger'>Database connection error. (" . $mysqli->connect_errno . ")</h2>");
        }

        $username = $mysqli->real_escape_string($_POST["username"]);
        $password = $mysqli->real_escape_string($_POST["password"]);

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

            //header("Location: index"); Need to change this to JS to redirect. Headers already sent
            print "Logged in successfully. Click <a href='./'>here</a> to continue.";
          } else { ?>
            <h2>Unable to log in, please try again.</h2>
            <form class="form-horizontal" action="<?php print htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
              <legend>Login</legend>
              <fieldset>
                <div class="form-group">
                  <label for="username" class="col-xs-2 control-label">Username</label>
                  <div class="col-xs-10">
                    <input type="text" class="form-control" id="username" name="username">
                  </div>
                </div>

                <div class="form-group">
                  <label for="password" class="col-xs-2 control-label">Password</label>
                  <div class="col-xs-10">
                    <input type="password" class="form-control" id="password" name="password">
                  </div>
                </div>
              </fieldset>
            </form>
            <?php
            } // if (password_verify($password, $pass))
          } else {
            print "error. this sucks.";
          } // if ($statement->num_rows == 1)

          $mysqli->close();
        endif;
        ?>
    </div>
  </div>
</div>

<?php require "includes/footer.php"; ?>
