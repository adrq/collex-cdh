<?php
/**
 * @file comments.php
 * Prints all comments for super users.
 */

if (isset($_GET["comments"])) {
  require_once "includes/functions.php";

  $commentName = $_GET["comments"];

  if (strpos($commentName, "comments_") !== false) {
	  print $commentName;
    renderComments($commentName);
  } else {
    renderTable($commentName);
  }
  exit();
}

$title = "Comments and Suggested Items";
$loginRequired = true;
require "includes/header.php";
?>

<div class="container">
  <div class="row page-header">
    <div class="col-xs-12">
      <h1>Comment and Suggested Items Viewer</h1>
      <p class="lead">View what users are saying.</p>
    </div>
  </div>

  <?php
  $array = array(
    array("value" => "comments_rdf_about", "title" => "RDF: About"),
    array("value" => "comments_provenance", "title" => "Provenance"),
    array("value" => "comments_place_of_composition", "title" => "Place of Composition"),
    array("value" => "comments_is_part_of", "title" => "isPartOf"),
    array("value" => "comments_has_part", "title" => "Has-Part"),
    array("value" => "comments_text_divisions", "title" => "Text-Division"),
    array("value" => "comments_notes", "title" => "Notes"),
    array("value" => "comments_date", "title" => "Date"),
    array("value" => "genre", "title" => "Genre"),
    array("value" => "custom_namespace_available", "title" => "Custom Namespace Decisions"),
    array("value" => "url_available", "title" => "URI or URL Decisions"),
    array("value" => "type_available", "title" => "Type Decisions"),
    array("value" => "role_available", "title" => "Role Decisions")
  );
  ?>

  <div class="row">
    <?php foreach ($array as $item): ?>
      <div class="viewer" data-value="<?php print $item['value']; ?>">
        <h4><?php print $item["title"]; ?></h4>
      </div>
    <?php endforeach; ?>
  </div>

  <hr class="row">

  <div class="row">
    <div class="col-xs-12">
      <section id="results"></section>
    </div>
  </div>

</div>

<?php require "includes/footer.php"; ?>
