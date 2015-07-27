<?php
/**
 * @file index.php
 * edit submission
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
				?>
				<div class="row">
					<div class="col-xs-12">
						<?php foreach ($row as $key=>$value): 
						$type = $objectsTableInputTypes[$key];
						switch ($type){
							case "text": ?>
								<div class="form-group">
          					      <label for="<?php print $key?>" class="control-label col-xs-2"><?php print $objectsTableColumDisplayNames[$key]?></label>
             					   <div>
            				      	<input type="text" class="form-control" name="<?php print $key?>" id="<?php print $key?>" value="<?php print $value?>">
        					       </div>
           						</div><hr>
							
							<?php 
							break;
							case "textarea": ?>
								<div class="form-group">
          					      <label for="<?php print $key?>" class="control-label col-xs-2"><?php print $objectsTableColumDisplayNames[$key]?></label>
             					   <div>
            				      		<textarea class="form-control" name="<?php print $key?>" id="<?php print $key?> rows="4"></textarea>
        					       </div>
           						</div><hr>
							<?php 
							break;
							case "radio": ?>
								<div class="form-group">
           					    	<label class="control-label"><?php print $objectsTableColumDisplayNames[$key]?></label>
             						<div>
              					    	<div class="radio">
              					        	<label><input type="radio" name="<?php print $key?>" value="true" <?php if ($value == "true") print "checked=\"true\"";?>>Yes</label>
              					    	</div>
              					    	<div class="radio">
             					    		<label><input type="radio" name="<?php print $key?>" value="false" <?php if ($value == "false") print "checked=\"true\"";?>>No</label>
              					    	</div>
               					 	</div>
             					 </div><hr>
							<?php 
						}
						
						?>
						
						<?php endforeach; ?>
					</div>
				</div>
				<?php 
			}
			else {?>
				<script>alert("You do not have permission to view this record."); window.location = "submissions";</script>
			<?php }			
		}
		else {
			?><script>alert("This record does not exist."); window.location = "submissions";</script><?php
		}
	}
	else {
		?><script>alert("This record does not exist."); window.location = "submissions";</script><?php
	}
	
	
	
	?>
	
  </div>
</div>

<?php require "includes/footer.php"; ?>
