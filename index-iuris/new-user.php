<?php
$pageTitle="Index Iuris create user";
include("header.php")?>

<?php if (!isset($_POST['user'])) : ?>
<script>
function onSubmitForm(formID){
	if (document.getElementById('password1').value != document.getElementById('password2').value){
		alert ('Passwords must match');
	}
	else {
		document.getElementById('formID').submit;
	}
}
</script>
<div id="login-container">
<form action="new-user.php" id="update-form" method="post" onSubmit="onSubmitForm('');return false;">
<label>Username:</label><input type="text" name="user"><br>
<label>Password:</label><input type="password" name="pass" id="password1">
<label>Confirm password:</label><input type="password" name="pass2" id="password2">
<input type="submit">
</form>

</div>

<?php else : ?>
<?php
$dbCon = mysqli_connect($database_host,$database_username,$database_password,$database_database);
if (!$dbCon) {
	die('Could not connect: ' . mysql_error());
}

$username=$_POST['user'];
$password_hash = password_hash($_POST['pass'],PASSWORD_DEFAULT);

$query = "SELECT 1 FROM users WHERE username='$username'";

$result = mysqli_query($dbCon, $query);
if ($result->num_rows==1){
	$query = "UPDATE users SET password_hash='$password_hash' WHERE username='$username'";
	$action = 'update';
}
else {
	$query = "INSERT INTO users (username,password_hash) VALUES ('$username','$password_hash');";
	$action = 'create';
}

if (mysqli_query($dbCon, $query)){
	echo 'User '.$action.'d successfully!<br><a href="login.php">Click to log in</a>';
}
else {
	echo "Error: " . $query . "<br>" . mysqli_error($dbCon);
}
$dbCon->close();

//echo $_POST['user'].'<br>'.$_POST['pass'];
?>
<?php endif;
include("footer.php");
?>