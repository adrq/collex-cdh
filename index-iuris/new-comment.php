<?php session_start();
include("config.php");
//TODO: create error page
if ($_SESSION['logged-in']==true) {
	$comment_text = $_POST['comment_text'];
	$comment_text = htmlspecialchars($comment_text); //get rid of any markup for security
	
	$user_id = $_SESSION['user_id'];
		
	$dbCon = mysqli_connect($database_host,$database_username,$database_password,$database_database);
	if (!$dbCon) {
		die('Could not connect: ' . mysql_error());
	}
	$query = "INSERT INTO constitution_comments (comment_text,date_submitted,user_id) VALUES ('".mysqli_real_escape_string($dbCon,$comment_text)."',NOW(),'".$user_id."');";
	if (mysqli_query($dbCon, $query)): ?>
<?php 
$pageTitle="Index Iuris comment submission";
include("header.php")?>
<div id="login-container">
<script type="text/javascript">
<!--
window.location = "../index-iuris/governance.php"
//-->
</script>
<h2>Comment submitted successfully. Click <a href="governance.php">here</a> to continue</h2>
</div>
<?php include("footer.php")?>
	
	<?php else:?>
	<?php echo "Error: " . $query . "<br>" . mysqli_error($dbCon);
	endif;
}
else {
	$pageTitle="Index Iuris comment submission";
	include("header.php")?>

	<div id="login-container">
	<form action="login.php" method="post">
	<label>Username:</label><input type="text" name="user"><br>
	<label>Password:</label><input type="password" name="pass">
	<input type="submit">
	</form>
	
	</div>
<?php include("footer.php");
}
?>