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
	
	
	$statement = $mysqli->prepare("SELECT id, url, title, archive, type FROM objects WHERE user_id = ?");
	$statement->bind_param("s", $_SESSION['user_id']);
	$statement->execute();
	$statement->store_result();
	$statement->bind_result($id, $url, $title, $archive, $type);
	
	if ($statement->num_rows > 0){
		while ($statement->fetch()){ //TODO: add some sort of pagination if there are many submisions per user
			?>
			<div class="submission" style="border-bottom: 1px solid black;">
				<h3><?php print $title?></h3>
				<p><strong>URL: </strong><?php print $url?></p>
				<p><strong>Archive: </strong><?php print $url?></p>
				<p><strong>Type: </strong><?php print $url?></p>
				<p><strong>Object ID: </strong><?php print $url?></p>
				<a href="#">View object</a> - <a href="#">Edit object</a>
			</div>
			<?php 
		}
	}
	else {
		print "You have not made any submissions yet.";
	}
	
	
	
	?>
	
  </div>
</div>

<?php require "includes/footer.php"; ?>
