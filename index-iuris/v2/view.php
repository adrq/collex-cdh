<?php
/**
 * @file view.php
 * Prints out an individual submission.
 */
$title = "View Submission";
$loginRequired = true;
require "includes/header.php";

if (!isset($_GET["id"])):
  ?><script>window.location = "submissions";</script><?php
else:
  global $mysqli;

  $statement = $mysqli->prepare("SELECT custom_namespace, rdf_about, archive, title, type, url, origin, provenance, place_of_composition, shelfmark, freeculture, full_text_url, full_text_plain, is_full_text, image_url, source, metadata_xml_url, metadata_html_url, text_divisions, language, ocr, thumbnail_url, notes, file_format, date_created, date_updated, user_id FROM objects WHERE id = ? LIMIT 1");
  $statement->bind_param("s", $_GET["id"]);
  $statement->execute();

  $row = $statement->get_result()->fetch_assoc();

  global $objectsTableColumDisplayNames;

  $objectsTableColumDisplayNames = array(
    "custom_namespace" => "Custom namespace",
    "rdf_about" => "Unique identifier (URI)",
    "archive" => "Archive",
    "title" => "Title",
    "type" => "Type" ,
    "url" => "URL" ,
    "origin" => "Origin" ,
    "provenance" => "Provenance" ,
    "place_of_composition" => "Place of Composition" ,
    "shelfmark" => "Shelfmark" ,
    "freeculture" => "Freeculture" ,
    "full_text_url" => "Full text URL" ,
    "full_text_plain" => "Full text" ,
    "is_full_text" => "Fulltext" ,
    "image_url" => "Image URL" ,
    "source" => "Source" ,
    "metadata_xml_url" => "XML Metadata URL" ,
    "metadata_html_url" => "HTML Metadata URL" ,
    "text_divisions" => "Divisions of the Text" ,
    "language" => "Language" ,
    "ocr" => "OCR" ,
    "thumbnail_url" => "Thumbnail URL" ,
    "notes" => "Notes" ,
    "file_format" => "File format" ,
    "date_created" => "Date created",
    "date_updated" => "Date updated",
    "user_id" => "User ID"
  );

  if ($row) {
    ?>
    <div class="container">
      <div class="row page-header">
        <div class="col-xs-12">
          <h1><?php print $row["title"]; ?></h1>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-9">
          <h3><?php print $row["custom_namespace"]; ?></h3>
          <h5><?php print $row["archive"]; ?></h5>
        </div>

        <div class="col-xs-3 pull-right text-right">
          <p>Created: <time><?php print $row["date_created"]; ?></time></p>
          <p>Updated: <time><?php print $row["date_updated"]; ?></time></p>
        </div>
      </div>

      <hr>


      <div class="row">
        <div class="col-xs-12">
          <?php foreach ($row as $key=>$value): ?>
          <p><?php print $objectsTableColumDisplayNames[$key]?>: <?php print $value?></p>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <?php
  } else {
    ?><script>alert("This record does not exist.");window.location = "submissions";</script><?php
  }

endif;/*
?>
<div class="container">
  <div class="row page-header">
    <div class="col-xs-12">
      <h1>Individual Submission</h1>
      <p class="lead">ID: <?php print $_GET["id"]; ?></p>
    </div>
  </div>

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

<?php */ require "includes/footer.php"; ?>
