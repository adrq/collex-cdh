<?php
/**
 * @file index.php
 * view submission
 */
$title = "Edit submission";
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
	
	//print $_GET['id'];
	$statement = $mysqli->prepare("SELECT custom_namespace, rdf_about, archive, title, type, url, origin, provenance, place_of_composition, shelfmark, freeculture, full_text_url, full_text_plain, is_full_text, image_url, source, metadata_xml_url, metadata_html_url, text_divisions, language, ocr, thumbnail_url, notes, file_format, date_created, date_updated, user_id FROM objects WHERE id = ? LIMIT 1");
	$statement->bind_param("s", $_GET['id']);
	$statement->execute();
		
	if ($result = $statement->get_result()){
		
		if ($row = $result->fetch_assoc()){
			
			if($row['user_id'] == $_SESSION['user_id']){
				foreach ($row as $key => $value){
					?>
					<p><?php print $key?>: <?php print $value?></p>		
					<?php
				}
			}
			else {
				print "You do not have permission to view this record.";
			}			
		}
		else {
			print "Unable to find record.";
		}
	}
	else {
		print "Unable to find record.";
	}
	
	
	
	?>
	
  </div>
</div>

<?php require "includes/footer.php"; ?>
