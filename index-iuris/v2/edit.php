<?php
/**
 * @file edit.php
 * Prints the edit submission page.
 *
 * 7/28/15 - This page does not load on Lichen server due to the fact that it does not have MySQLnd installed.
 * The only way to work around this (aside from installing the driver) is to remove $statement->get_result() and
 * workaround that method - which will be a pain.
 *
 */
$title = "Edit Submission";
$loginRequired = true;
require "includes/header.php";

if (!isset($_GET["id"]) && !isset($_POST["id"])):
  ?><script>window.location = "submissions";</script><?php
else:
  global $mysqli;

  $id = isset($_POST["id"]) ? $_POST["id"] : $_GET["id"];

  if (isset($_POST["id"])) {
    saveObjectToDB($_POST, $id);
    ?><script>alert("Submission updated successfully."); window.location = "edit?id=<?php print $id; ?>":</script><?php
  }

  $statement = $mysqli->prepare("SELECT custom_namespace, rdf_about, archive, title, type, url, origin, provenance, place_of_composition, shelfmark, freeculture, full_text_url, full_text_plain, is_full_text, image_url, source, metadata_xml_url, metadata_html_url, text_divisions, language, ocr, thumbnail_url, notes, file_format, date_created, date_updated, user_id FROM objects WHERE id = ? LIMIT 1");
  $statement->bind_param("s", $id);
  $statement->execute();
  $statement->store_result();
  $statement->bind_result($custom_namespace, $rdf_about, $archive, $title, $type, $url, $origin, $provenance, $place_of_composition, $shelfmark, $freeculture, $full_text_url, $full_text_plain, $is_full_text, $image_url, $source, $metadata_xml_url, $metadata_html_url, $text_divisions, $language, $ocr, $thumbnail_url, $notes, $file_format, $date_created, $date_updated, $user_id);

  // 7/29/15 - Removed until MySQLnd is installed onto Lichen.
  // $row = $statement->get_result()->fetch_assoc();

  // 7/29/15 - When MySQLnd is installed, replace the following two uncommented
  // if statements with the following two commented if statements.
  // if ($row)
  // if ($row["user_id"])

  if ($statement->fetch()):
    if ($user_id == $_SESSION["user_id"]): ?>
      <div class="container">
        <div class="row page-header">
          <div class="col-xs-12">
            <h1 class="pull-left">Edit <?php print $title; ?></h1>
            <p class="last-updated">Last Updated: <time><?php print $date_updated; ?></time></p>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-12">
            <form class="form-horizontal" action="<?php print htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
              <fieldset>
                <?php
                // 7/29/15 - Current workaround until MySQLnd is installed onto Lichen.
                printResult("custom_namespace", "Custom Namespace", $custom_namespace, "input");
                printResult("rdf_about", "Unique Identifier (URI)", $rdf_about, "input");
                printResult("archive", "Archive", $archive, "input");
                printResult("title", "Title", $title, "input");
                printResult("type", "Type", $type, "input");
                printResult("url", "URL", $url, "input");
                printResult("origin", "Origin", $origin, "input");
                printResult("provenance", "Provenance", $provenance, "input");
                printResult("place_of_composition", "Place of Composition", $place_of_composition, "input");
                printResult("shelfmark", "Shelfmark", $shelfmark, "input");
                printResult("freeculture", "Freeculture", $freeculture, "radio");
                printResult("full_text_url", "Full text URL", $full_text_url, "input");
                printResult("full_text_plain", "Full text", $full_text_plain, "textarea");
                printResult("is_full_text", "Fulltext", $is_full_text, "radio");
                printResult("image_url", "Image URL", $image_url, "input");
                printResult("source", "Source", $source, "input");
                printResult("metadata_xml_url", "XML Metadata URL", $metadata_xml_url, "input");
                printResult("metadata_html_url", "HTML Metadata URL", $metadata_html_url, "input");
                printResult("text_divisions", "Divisions of the Text", $text_divisions, "textarea");
                printResult("language", "Language", $language, "input");
                printResult("ocr", "OCR", $ocr, "radio");
                printResult("thumbnail_url", "Thumbnail URL", $thumbnail_url, "input");
                printResult("notes", "Notes", $notes ,"textarea");
                printResult("file_format", "File Format", $file_format, "input");

                // This is literally the worst.

                /* 7/29/15 - Removed until MySQLnd is installed onto Lichen.
                <?php foreach ($row as $key=>$value): ?>
                  <?php switch ($objectsTableInputTypes[$key]): case "text": // Need a reason as to why PHP can be stupid? Any trailing whitespace between switch and the first case throws an error. http://php.net/manual/en/control-structures.alternative-syntax.php ?>
                    <section class="form-group">
                      <label for="<?php print $key; ?>" class="control-label col-xs-2"><?php print $objectsTableColumDisplayNames[$key]; ?></label>
                      <div class="col-xs-10">
                        <input type="text" class="form-control" name="<?php print $key; ?>" id="<?php print $key; ?>" value="<?php print $value; ?>"<?php printRequired($key); ?>>
                      </div>
                    </section>
                    <hr>
                    <?php break; ?>
                    <?php case "textarea": ?>
                    <section class="form-group">
                      <label for="<?php print $key; ?>" class="control-label col-xs-2"><?php print $objectsTableColumDisplayNames[$key]; ?></label>
                      <div class="col-xs-10">
                        <textarea class="form-control" name="<?php print $key ;?>" id="<?php print $key; ?>" rows="4"<?php printRequired($key); ?>><?php print $value; ?></textarea>
                      </div>
                    </section>
                    <hr>
                    <?php break; ?>
                    <?php case "radio": ?>
                    <section class="form-group">
                      <label for="<?php print $key; ?>" class="control-label col-xs-2"><?php print $objectsTableColumDisplayNames[$key]; ?></label>
                      <div class="col-xs-10">
                        <div class="radio">
                          <label><input type="radio" name="<?php print $key; ?>" value="true"<?php print $value == "true" ? " checked=''" : ""; ?>>Yes</label>
                        </div>
                        <div class="radio">
                          <label><input type="radio" name="<?php print $key; ?>" value="false"<?php print $value == "false" ? " checked=''" : ""; ?>>No</label>
                        </div>
                      </div>
                    </section>
                    <hr>
                    <?php break; ?>
                  <?php endswitch; ?>
                <?php
                endforeach;
                */

                $temp = $mysqli->prepare("SELECT role, value FROM roles WHERE object_id = ?");
                $temp->bind_param("s", $id);
                $temp->execute();
                $temp->bind_result($role, $value);
                ?>
                <span class="hide">Role</span>
                <section>
                  <?php
                  $counter = 1;
                  while ($temp->fetch()): ?>
                    <div class="form-group">
                      <label for="role<?php print $counter; ?>" class="control-label col-xs-2"><button type="button" class="close hide pull-left">x</button>Role</label>
                      <div class="col-xs-10">
                        <select class="form-control" id="role<?php print $counter; ?>" name="role[]">
                          <option<?php print $role === "" ? " selected=''" : ""; ?>></option>
                          <?php foreach ($rolesArray as $item): ?>
                            <option<?php print $item == $role ? " selected=''" : ""; ?>><?php print $item; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="value<?php print $counter; ?>" class="control-label col-xs-2"><button type="button" class="close hide pull-left">x</button>Value</label>
                      <div class="col-xs-10">
                        <input type="text" class="form-control" id="value<?php print $counter; ?>" name="role_value[]" value="<?php print $value; ?>">
                      </div>
                    </div>
                    <?php
                    $counter++;
                  endwhile;
                  ?>
                  <div class="form-group">
                    <div class="col-xs-12">
                      <button type="button" class="btn btn-default pull-right" id="addRoleButton">Add Another Role</button>
                    </div>
                  </div>
                </section>

                <hr>
                <?php
                $temp = $mysqli->prepare("SELECT genre FROM genres WHERE object_id = ?");
                $temp->bind_param("s", $id);
                $temp->execute();
                $temp->bind_result($genre);
                ?>
                <span class="hide">Genre</span>
                <section>
                  <?php
                  $counter = 1;
                  while ($temp->fetch()): ?>
                    <div class="form-group">
                      <label for="genre<?php print $counter; ?>" class="control-label col-xs-2"><button type="button" class="close hide pull-left">x</button>Genre</label>
                      <div class="col-xs-10">
                        <select class="form-control" id="genre<?php print $counter; ?>" name="genre[]">
                          <option<?php print $genre === "" ? " selected=''" : ""; ?>></option>
                          <?php foreach ($genresArray as $item): ?>
                            <option<?php print $item == $genre ? " selected=''" : ""; ?>><?php print $item; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <?php
                    $counter++;
                  endwhile;
                  ?>
                  <div class="form-group">
                    <div class="col-xs-12">
                      <button type="button" class="btn btn-default pull-right" id="addGenreButton">Add Another Genre</button>
                    </div>
                  </div>
                </section>

                <hr>
                <?php
                $temp = $mysqli->prepare("SELECT alt_title FROM alt_titles WHERE object_id = ?");
                $temp->bind_param("s", $id);
                $temp->execute();
                $temp->bind_result($altTitle);
                ?>
                <span class="hide">Alternative Title</span>
                <section>
                  <?php
                  $counter = 1;
                  while ($temp->fetch()): ?>
                    <div class="form-group">
                      <label for="altTitle<?php print $counter;?>" class="control-label col-xs-2"><button type="button" class="close hide pull-left">x</button>Alt Title</label>
                      <div class="col-xs-10">
                        <input type="text" class="form-control" id="altTitle<?php print $counter; ?>" name="alternative_title[]" value="<?php print $altTitle; ?>">
                      </div>
                    </div>
                    <?php
                    $counter++;
                  endwhile;
                  ?>
                  <div class="form-group">
                    <div class="col-xs-12">
                      <button type="button" class="btn btn-default pull-right" id="addAltTitleButton">Add Another Alternative Title</button>
                    </div>
                  </div>
                </section>

                <hr>
                <?php
                $temp = $mysqli->prepare("SELECT type, machine_date, human_date FROM dates WHERE object_id = ?");
                $temp->bind_param("s", $id);
                $temp->execute();
                $temp->bind_result($type, $machineDate, $humanDate);

                $counter = 1;
                while ($temp->fetch()): ?>
                  <section class="form-group">
                    <label for="humanDate<?php print $counter; ?>" class="control-label col-xs-2">Human Date</label>
                    <div class="col-xs-10">
                      <input type="text" class="form-control" id="humanDate<?php print $counter; ?>" name="human_date" value="<?php print $humanDate; ?>" required="">
                    </div>
                  </section>
                  <section class="form-group">
                    <label for="machineDate<?php print $counter; ?>" class="control-label col-xs-2">Machine Date</label>
                    <div class="col-xs-10">
                      <input type="text" class="form-control" id="machineDate<?php print $counter; ?>" name="machine_date" value="<?php print $machineDate; ?>" required="">
                    </div>
                  </section>
                  <?php
                  $counter++;
                endwhile;

                ?><hr><?php
                $temp = $mysqli->prepare("SELECT part_id FROM parts WHERE object_id = ? AND type = 'isPartOf'");
                $temp->bind_param("s", $id);
                $temp->execute();
                $temp->bind_result($partID);
                ?>
                <span class="hide">Is Part Of</span>
                <section>
                  <?php
                  $counter = 1;
                  while ($temp->fetch()): ?>
                    <div class="form-group">
                      <label for="isPartOf<?php print $counter; ?>" class="control-label col-xs-2">Is Part Of</label>
                      <div class="col-xs-10">
                        <input type="text" class="form-control" id="isPartOf<?php print $counter; ?>" name="is_part_of[]" value="<?php print $partID; ?>" required="">
                      </div>
                    </div>
                    <?php
                    $counter++;
                  endwhile;
                  ?>
                  <div class="form-group">
                    <div class="col-xs-12">
                      <button type="button" class="btn btn-default pull-right" id="addIsPartOfButton">Add Another Is Part Of</button>
                    </div>
                  </div>
                </section>
                <?php
                $temp = $mysqli->prepare("SELECT part_id FROM parts WHERE object_id = ? AND type = 'hasPart'");
                $temp->bind_param("s", $id);
                $temp->execute();
                $temp->bind_result($partID);
                ?>
                <span class="hide">Has Part</span>
                <section>
                  <?php
                  $counter = 1;
                  while ($temp->fetch()): ?>
                    <div class="form-group">
                      <label for="hasPart<?php print $counter; ?>" class="control-label col-xs-2">Has Part</label>
                      <div class="col-xs-10">
                        <input type="text" class="form-control" id="hasPart<?php print $counter; ?>" name="has_part[]" value="<?php print $partID; ?>" required="">
                      </div>
                    </div>
                    <?php
                    $counter++;
                  endwhile;
                  ?>
                  <div class="form-group">
                    <div class="col-xs-12">
                      <button type="button" class="btn btn-default pull-right" id="addHasPartButton">Add Another Has Part</button>
                    </div>
                  </div>
                </section>

                <hr>
                <section class="form-group" style="margin-bottom: 15%">
                  <input type="hidden" class="hide" name="id" value="<?php print $id; ?>">
                  <div class="col-xs-3 center-block">
                    <button type="submit" class="btn btn-success col-xs-12">Save Changes</button>
                  </div>
                </section>
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    <?php
    else:
      ?><script>alert("You do not have permission to view this record."); window.location = "submissions";</script><?php
    endif; // if ($user_id == $_SESSION["user_id"])
  else:
    ?><script>alert("This record does not exist."); window.location = "submissions";</script><?php
  endif; // if ($row)
endif; // if (!isset($_GET["id"]))

require "includes/footer.php";

/**
 * Prints if the form field is required or not.
 *
 * @param {String} $key: The form field name.
 */
function printRequired($key) {
  print in_array($key, array("custom_namespace", "rdf_about", "archive", "title", "type", "file_format")) ? ' required=""' : "";
}

function printResult($name, $label, $value, $type) {
  ?>
  <section class="form-group">
    <label for="<?php print $name; ?>" class="control-label col-xs-2"><?php print $label; ?></label>
    <div class="col-xs-10">
      <?php
      switch ($type) {
        case "input":
        ?><input type="text" class="form-control" name="<?php print $name; ?>" id="<?php print $name; ?>" value="<?php print $value; ?>"<?php printRequired($name); ?>><?php
        break;
        case "radio":
        ?>
        <div class="radio">
          <label><input type="radio" name="<?php print $name; ?>" value="true"<?php print $value == "true" ? " checked=''" : ""; ?>>Yes</label>
        </div>
        <div class="radio">
          <label><input type="radio" name="<?php print $name; ?>" value="false"<?php print $value == "false" ? " checked=''" : ""; ?>>No</label>
        </div>
        <?php
        break;
        case "textarea":
        ?><textarea class="form-control" name="<?php print $name; ?>" id="<?php print $name; ?>" rows="4"<?php printRequired($name); ?>><?php print $value; ?></textarea><?php
        break;
      }
      ?>
    </div>
  </section>
  <hr>
  <?php
}
