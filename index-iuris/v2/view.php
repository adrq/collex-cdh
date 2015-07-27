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

  if ($row) {
    ?>
    <div class="container">
      <div class="row page-header">
        <div class="col-xs-12">
          <h1 class="pull-left"><?php print $row["title"]; ?></h1>
          <a href="#" class="btn btn-default pull-right" style="margin-top: 20px;">Edit</a>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-9">
          <h3><?php print $row["custom_namespace"]; ?></h3>
          <h5><?php print $row["archive"]; ?></h5>
        </div>

        <div class="col-xs-3 text-right">
          <p>Created: <time><?php print $row["date_created"]; ?></time></p>
          <p>Updated: <time><?php print $row["date_updated"]; ?></time></p>
        </div>
      </div>

      <hr>

      <div class="row">
        <div class="col-xs-4">
          <ul class="list-group">
            <?php
            print printListItem("Language", $row["language"]);
            print printListItem("Origin", $row["origin"]);
            print printListItem("Provenance", $row["provenance"]);
            print printListItem("Place of Composition", $row["place_of_composition"]);
            print printListItem("File Format", $row["file_format"]);
            ?>
          </ul>
        </div>

        <div class="col-xs-5">
          <?php
          print printPanel("Shelfmark", $row["shelfmark"]);
          print printPanel("Divisions of the Text", $row["text_divisions"]);
          print printPanel("Source", $row["source"]);
          print printPanel("Notes", $row["notes"]);
          ?>
        </div>

        <div class="col-xs-3">
          <?php
          print printWell("Image URL", $row["image_url"]);
          print printWell("Full Text URL", $row["full_text_url"]);
          print printWell("HTML Metadata URL", $row["metadata_html_url"]);
          print printWell("XML Metadata URL", $row["metadata_xml_url"]);
          ?>
        </div>
      </div>


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
    ?><script>alert("This record does not exist."); window.location = "submissions";</script><?php
  }

endif;

require "includes/footer.php";

/**
 * Prints a list item.
 *
 * @param {String} $text: The heading.
 * @param {String} $column: The string of an array representing the value of a column.
 */
function printListItem($text, $column) {
  ?>
  <li class="list-group-item"><strong><?php print $text; ?></strong>: <?php print $column === "" ? "<em>Blank</em>" : $column; ?></li>
  <?php
}

/**
 * Prints a panel.
 *
 * @param {String} $text: The heading.
 * @param {String} $column: The string of an array representing the value of a column.
 */
function printPanel($text, $column) {
  ?>
  <div class="panel panel-default">
    <div class="panel-heading"><?php print $text; ?></div>
    <div class="panel-body"><?php print $column; ?></div>
  </div>
  <?php
}
/**
 * Prints a well with an anchor tag.
 *
 * @param {String} $text: The heading.
 * @param {String} $column: The string of an array representing the value of a column.
 */
function printWell($text, $column) {
  ?>
  <p><?php print $text; ?>:</p>
  <div class="well well-sm">
    <a href="<?php print $column; ?>" target="_blank"><?php print $column; ?></a>
  </div>
  <?php
}


