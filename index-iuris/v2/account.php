<?php
/**
 * @file account.php
 * Displays user account details
 */
$title = "Account";
$loginRequired = true;
require "includes/header.php";
?>

<div class="container">
  <div class="row page-header">
    <div class="col-xs-12">
    <h1>View account details</h1>
    </div>
  </div>
  
  <?php if(isset($_GET["action"]) && $_GET["action"]=="update") :  ?>
  <form class="form-horizontal" action="<?php print htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
          <legend>Update password</legend>
          <fieldset>
            <div class="form-group">
              <label for="username" class="col-xs-4 control-label">Username</label>
              <label class="col-xs-4 control-label"><?php print $_SESSION["username"]?></label>
            </div>

			<div class="form-group">
              <label for="oldPassword" class="col-xs-4 control-label">Old password</label>
              <div class="col-xs-4">
                <input type="password" class="form-control" id="oldPassword" name="oldPassword">
              </div>
            </div>
            
            <div class="form-group">
              <label for="password1" class="col-xs-4 control-label">Password</label>
              <div class="col-xs-4">
                <input type="password" class="form-control" id="password1" name="password1">
              </div>
            </div>

            <div class="form-group">
              <label for="password2" class="col-xs-4 control-label">Confirm Password</label>
              <div class="col-xs-4">
                <input type="password" class="form-control" id="password2" name="password2">
              </div>
            </div>
            
            <div class="form-group">
            <label class="col-xs-4 control-label"></label>
            <input type="hidden" name="action" value="update-password">
              <div class="col-xs-4">
                <button type="submit" class="btn btn-primary col-xs-8">Update password</button>
              </div>
            </div>
          </fieldset>
  </form>
  
  <?php elseif (isset($_POST["action"])) :
  global $mysqli;
  $username  = $_SESSION["username"];
  $oldPassword  = $mysqli->real_escape_string($_POST["oldPassword"]);
  $password1 = $mysqli->real_escape_string($_POST["password1"]);
  $password2 = $mysqli->real_escape_string($_POST["password2"]);
  $password;
  
  if (strcmp($password1, $password2) !== 0) {
  	exit("<h3 class='text-danger'>Passwords do not match.</h3>");
  } else {
  	// 7/28/15 - Add the following when PHP v5.5.x is installed on Lichen:
  	// $password = password_hash($password1, PASSWORD_DEFAULT);
  
  	// 7/28/15 - Remove the following when PHP v5.5.x is installed on Lichen:
  	$newPasswordHash = hash("sha512", $password1);
  	$password = hash("sha512", $oldPassword);
  }
  
  $statement = $mysqli->prepare("SELECT password_hash FROM users WHERE id = ? LIMIT 1");
  $statement->bind_param("s", $_SESSION["user_id"]);
  $statement->execute();
  $statement->store_result();
  $statement->bind_result($oldPasswordHash);
  $register;
  $action = "";
  
  
  if ($statement->fetch()) {
  	if (strcmp($password, $oldPasswordHash) ==0){
  		$register = $mysqli->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
  		$register->bind_param("ss", $newPasswordHash, $_SESSION["user_id"]);
  		$register->execute();
  		$register->store_result();
  		$action = "updated";
  	}
  	else {
  		print "<script>alert('Old password incorrect'); window.location='account';</script>";
  	}
  	
  } else {
  	print "<h3 class='text-danger'>There was an error trying to update user account.</h3>";
  }
  
  
  
  if ($register->errno) {
  	print "<h3 class='text-danger'>There was an error trying to register. (" . $register->errno . ")</h3>";
  } else {
  	print "<h3>User " . $action . " successfully!</h3>";
  }
  
  ?>
  <?php else:?>
  <div class="row">
    <div class="col-xs-9">
      <h3>User name: <?php print $_SESSION["username"]?></h3>
      <h4>User ID: <?php print $_SESSION["user_id"]?></h4>
      <h4>Role: <?php print $_SESSION["user_role"]?></h4>
    </div>
    <div class="col-xs-3 text-right">
      <h4><a href="account?action=update">Change password</a></h4>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
    </div>
  </div>
  <?php endif;?>
  
</div>

<?php require "includes/footer.php"; ?>