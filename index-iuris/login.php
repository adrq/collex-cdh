<?php 
$pageTitle="Index Iuris login";
include("header.php")?>

<?php if (!isset($_POST['user'])) : ?>

<div id="login-container">
<form action="login.php" method="post">
<label>Username:</label><input type="text" name="user"><br>
<label>Password:</label><input type="password" name="pass">
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

$query = "SELECT password_hash FROM users WHERE username='$username'";

$result = mysqli_query($dbCon, $query);
$password_hash;

if ($result->num_rows==1){
	$row = $result->fetch_assoc();
	$password_hash = $row[password_hash];
}
else {
	echo "ERROR";
}

$dbCon->close();

if (password_verify($_POST['pass'], $password_hash)) : ?>
<?php
$_SESSION['logged-in'] = true; 
$_SESSION['username'] = $username;
?>
<div id="login-container">
<script type="text/javascript">
<!--
window.location = "../index-iuris/index.php"
//-->
</script>
<h2>Logged in successfully. Click <a href="index.php">here</a> to continue</h2>

</div>


<?php else:?>

<div id="login-container">
<h2>Unable to log in, please try again.</h2>
<form action="login.php" method="post">
<label>Username:</label><input type="text" name="user"><br>
<label>Password:</label><input type="password" name="pass">
<input type="submit">
</form>

</div>



<?php endif;?>

<?php endif;
include("footer.php");
?>