<?php
/**
 * @file index.php
 * Prints the home pagae.
 */
$title = "Logout";
require "includes/header.php";
?>
<?php
$_SESSION['logged-in'] = false; 
?>
<div id="login-container">
<h2>Logged out successfully. Click <a href="index.php">here</a> to continue</h2>
</div>



</body>


</html>