<?php
/**
 * @file edit.php
 * Prints the edit submission page.
 */
if (isset($_POST["custom_namespace"], $_GET["archive"], $_GET["type"])) {
  // Do stuff.
}

$title = "Edit Submission";
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
    if ($row["user_id"] == $_SESSION["user_id"]): ?>
      <div class="container">
        <div class="row page-header">
          <div class="col-xs-12">
            <h1 class="pull-left">Edit <?php print $row["title"]; ?></h1>
            <p class="last-updated">Last Updated: <time><?php print $row["date_updated"]; ?></time></p>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-12">
            <form class="form-horizontal" action="<?php print htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
              <fieldset>
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
                        <input type="text" class="form-control" id="value<?php print $counter; ?>" name="role-value[]" value="<?php print $value; ?>">
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
                        <input type="text" class="form-control" id="altTitle<?php print $counter; ?>" name="alternative-title[]" value="<?php print $altTitle; ?>">
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
                      <input type="text" class="form-control" id="humanDate<?php print $counter; ?>" name="date-human" value="<?php print $humanDate; ?>" required="">
                    </div>
                  </section>
                  <section class="form-group">
                    <label for="machineDate<?php print $counter; ?>" class="control-label col-xs-2">Machine Date</label>
                    <div class="col-xs-10">
                      <input type="text" class="form-control" id="machineDate<?php print $counter; ?>" name="date-machine" value="<?php print $machineDate; ?>" required="">
                    </div>
                  </section>
                  <?php
                  $counter++;
                endwhile;
                ?>
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
    endif; // if ($row["user_id"] == $_SESSION["user_id"])
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
