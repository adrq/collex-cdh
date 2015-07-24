<?php
/**
 * @file index.php
 * view submissions
 */
$title = "View submissions";
$loginRequired = true;
require "includes/header.php";
?>

<div class="container">
  <div class="row">
	
	<?php 
	
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_BASE);
	
	if ($mysqli->connect_error) {
		exit("<h2 class='text-danger'>Database connection error. (" . $mysqli->connect_errno . ")</h2>");
	}
	
	
	$statement = $mysqli->prepare("SELECT (id, url, title, archive, type) FROM objects WHERE user_id = ?");
	$statement->bind_param("s", $_POST['user_id']);
	$statement->execute();
	$statement->store_result();
	$statement->bind_result($id, $url, $title, $archive, $type);
	
	if ($statement->num_rows > 0){
		while ($statement->fetch()){
			?>
			<div class="submission">
				
			</div>
			<?php 
		}
	}
	
	
	
	?>
	
  </div>
</div>

<?php require "includes/footer.php"; ?>
