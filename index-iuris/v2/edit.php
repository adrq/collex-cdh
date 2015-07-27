<?php
/**
 * @file edit.php
 * Prints the edit submission page.
 */
if (isset($_GET["custom_namespace"], $_GET["archive"], $_GET["type"])) {
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
    if ($row["user_id"] == $_SESSION["user_id"]):
      ?>
      <div class="container">
        <div class="row page-header">
          <div class="col-xs-12">
            <h1 class="pull-left">Edit <?php print $row["title"]; ?></h1>
            <p class="last-updated">Last Updated: <time><?php print $row["date_updated"]; ?></time></p>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-12">
            <form class="form-horizontal" action="<?php print htmlentities($_SERVER['PHP_SELF']); ?>" method="GET">
              <fieldset>
                <?php foreach ($row as $key=>$value): ?>
                  <?php switch ($objectsTableInputTypes[$key]): case "text": // Need a reason as to why PHP can be stupid? Any trailing whitespace between switch and the first case throws an error. http://php.net/manual/en/control-structures.alternative-syntax.php ?>
                    <section class="form-group">
                      <label for="<?php print $key; ?>" class="control-label"><?php print $objectsTableColumDisplayNames[$key]; ?></label>
                      <input type="text" class="form-control" name="<?php print $key; ?>" id="<?php print $key; ?>" value="<?php print $value; ?>">
                    </section>
                    <hr>
                    <?php break; ?>
                    <?php case "textarea": ?>
                    <section class="form-group">
                      <label for="<?php print $key; ?>" class="control-label"><?php print $objectsTableColumDisplayNames[$key]; ?></label>
                      <textarea class="form-control" name="<?php print $key ;?>" id="<?php print $key; ?>" rows="4"><?php print $value; ?></textarea>
                    </section>
                    <hr>
                    <?php break; ?>
                    <?php case "radio": ?>
                    <section class="form-group">
                      <label for="<?php print $key; ?>" class="control-label"><?php print $objectsTableColumDisplayNames[$key]; ?></label>
                      <div class="radio">
                        <label><input type="radio" name="<?php print $key; ?>" value="true" <?php print $value == "true" ? "checked=''" : ""; ?> >Yes</label>
                      </div>
                      <div class="radio">
                        <label><input type="radio" name="<?php print $key; ?>" value="false" <?php print $value == "false" ? "checked=''" : ""; ?> >No</label>
                      </div>
                    </section>
                    <hr>
                    <?php break; ?>
                  <?php endswitch; ?>
                <?php endforeach; ?>
                <section class="form-group" style="margin-bottom: 15%">
                  <input type="hidden" class="hide" name="id" value="<?php print $id; ?>">
                  <button type="submit" class="btn btn-success">Save Changes</button>
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

require "includes/footer.php"; ?>
