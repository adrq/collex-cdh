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

  $id = $_GET["id"];
  $statement = $mysqli->prepare("SELECT custom_namespace, rdf_about, archive, title, type, url, origin, provenance, place_of_composition, shelfmark, freeculture, full_text_url, full_text_plain, is_full_text, image_url, source, metadata_xml_url, metadata_html_url, text_divisions, language, ocr, thumbnail_url, notes, file_format, date_created, date_updated, user_id FROM objects WHERE id = ? LIMIT 1");
  $statement->bind_param("s", $id);
  $statement->execute();

  $row = $statement->get_result()->fetch_assoc();

  if ($row):
    if ($row["user_id"] == $_SESSION["user_id"]):
      ?>
      <div class="container">
        <div class="row page-header">
          <div class="col-xs-12">
            <h1 class="pull-left"><?php print $row["title"]; ?></h1>
            <a href="edit?id=<?php print $id; ?>" class="btn btn-default pull-right" style="margin-top: 20px;">Edit</a>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-9">
            <h3><?php print $row["custom_namespace"]; ?></h3>
            <h5><?php print $row["archive"]; ?></h5>
            <p><?php print $row["rdf_about"]; ?></p>
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
              print printListItem("Type", $row["type"]);
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
            print printWell("URL", $row["url"]);
            // 7/27/15 - Temporarily removed until submission form gives off these fields.
            // print printWell("Image URL", $row["image_url"]);
            // print printWell("Thumbnail URL", $row["thumbnail_url"]);
            print printWell("Full Text URL", $row["full_text_url"]);
            print printWell("HTML Metadata URL", $row["metadata_html_url"]);
            print printWell("XML Metadata URL", $row["metadata_xml_url"]);
            ?>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-3">
            <h2>Roles</h2>
            <ul class="list-group">
              <?php
              $temp = $mysqli->prepare("SELECT role, value FROM roles WHERE object_id = ?");
              $temp->bind_param("s", $id);
              $temp->execute();
              $temp->bind_result($role, $value);

              while ($temp->fetch()): ?>
              <li class="list-group-item"><strong><?php print $role; ?></strong>: <?php print $value; ?></li>
              <?php endwhile; ?>
            </ul>
          </div>

          <div class="col-xs-3">
            <h2>Genres</h2>
            <ul class="list-group">
              <?php
              $temp = $mysqli->prepare("SELECT genre FROM genres WHERE object_id = ?");
              $temp->bind_param("s", $id);
              $temp->execute();
              $temp->bind_result($genre);

              while ($temp->fetch()): ?>
              <li class="list-group-item"><strong>Genre</strong>: <?php print $genre; ?></li>
              <?php endwhile; ?>
            </ul>
          </div>

          <div class="col-xs-3">
            <h2>Alternative Titles</h2>
            <ul class="list-group">
              <?php
              $temp = $mysqli->prepare("SELECT alt_title FROM alt_titles WHERE object_id = ?");
              $temp->bind_param("s", $id);
              $temp->execute();
              $temp->bind_result($altTitle);

              while ($temp->fetch()): ?>
              <li class="list-group-item"><strong>Title</strong>: <?php print $altTitle; ?></li>
              <?php endwhile; ?>
            </ul>
          </div>

          <div class="col-xs-3">
            <h2>Dates</h2>
            <ul class="list-group">
              <?php
              $temp = $mysqli->prepare("SELECT type, machine_date, human_date FROM dates WHERE object_id = ?");
              $temp->bind_param("s", $id);
              $temp->execute();
              $temp->bind_result($type, $machine, $human);

              while ($temp->fetch()): ?>
              <li class="list-group-item"><strong>Human</strong>: <?php print $human; ?></li>
              <li class="list-group-item"><strong>Machine</strong>: <?php print $machine; ?></li>
              <?php endwhile; ?>
            </ul>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6">
            <h2>Parts</h2>
            <ul class="list-group">
              <?php
              $temp = $mysqli->prepare("SELECT type, part_id FROM parts WHERE object_id = ?");
              $temp->bind_param("s", $id);
              $temp->execute();
              $temp->store_result();
              $temp->bind_result($type, $part_id);

              while ($temp->fetch()): 
              $temp2 = $mysqli->prepare("SELECT title FROM objects WHERE id = ? LIMIT 1");
              $temp2->bind_param("s", $part_id);
              $temp2->execute();
              $temp2row = $temp2->get_result()->fetch_assoc();
              //$temp2->store_result();
              //$temp2->bind_result($part_title);
              ?>
              <li class="list-group-item"><strong><?php print $type; ?></strong>: <a href="view?id=<?php print $part_id?>"><?php print $temp2row["title"]; ?></a></li>
              <?php endwhile; ?>
            </ul>
          </div>
       </div>

        <div class="row">
          <div class="col-xs-12">
            <?php foreach ($row as $key=>$value): ?>
            <?php if (in_array($key, array("type", "rdf_about", "url", "language", "origin", "provenance", "place_of_composition", "file_format", "shelfmark", "text_divisions", "source", "notes", "image_url", "thumbnail_url", "full_text_url", "metadata_html_url", "metadata_xml_url", "title", "custom_namespace", "archive", "date_created", "date_updated"))) { continue; } ?>
            <p><?php print $objectsTableColumDisplayNames[$key]?>: <?php print $value?></p>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <?php
    else:
      ?><script>alert("You do not have permission to view this record."); window.location = "submissions";</script><?php
    endif; // if ($row["user_id"] == $_SESSION["user_id"])
  else:
    ?><script>alert("This record does not exist."); window.location = "submissions";</script><?php
  endif; // if ($row)
endif; // if (!isset($_GET["id"]))

require "includes/footer.php";

/**
 * Prints a list item.
 *
 * @param {String} $text: The heading.
 * @param {String} $column: The string of an array representing the value of a column.
 */
function printListItem($text, $column) {
  $column = trim($column) === "" ? "<em>Blank</em>" : trim($column);
  ?>
  <li class="list-group-item"><strong><?php print $text; ?></strong>: <?php print $column; ?></li>
  <?php
}

/**
 * Prints a panel.
 *
 * @param {String} $text: The heading.
 * @param {String} $column: The string of an array representing the value of a column.
 */
function printPanel($text, $column) {
  $column = trim($column) === "" ? "<em>Blank</em>" : trim($column);
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
  $column = trim($column) === "" ? "<em>Blank</em>" : trim($column);
  ?>
  <p><?php print $text; ?>:</p>
  <div class="well well-sm"><?php print $column; ?></div>
  <?php
}


