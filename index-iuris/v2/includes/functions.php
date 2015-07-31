<?php
/**
 * @file functions.php
 * Functions used throughout the website.
 */
// Assure that config is imported prior to this file being executed.
require_once "config.php";

// Assure error reporting is on.
error_reporting(-1);
ini_set("display_errors", "On");

/**
 * Grabs a username based on the id.
 *
 * @param {int} $id: The unique id of the username.
 * @return {String}
 */
function findUsername($id) {
  global $mysqli;
  $statement = $mysqli->prepare("SELECT username FROM users WHERE id = ?");
  $statement->bind_param("i", $id);
  $statement->execute();
  $statement->store_result();
  $statement->bind_result($username);
  $statement->fetch();

  return $username;
} // function findUsername($id);

/**
 * Determines if a user is a superuser or not.
 *
 * @return {Boolean}
 */
function isSuper() {
  return $_SESSION["user_role"] == "superuser";
}

/**
 * Renders MySQL values into HTML-ready entities.
 * - Currently only detects quotation marks.
 *
 * @param {String} $text: The MySQL value.
 * @param {Boolean} $ignore: Ignore the "value=''" attribute.
 */
function printValue($text, $ignore = false) {
  if ($ignore) {
    print preg_replace("/\"/", "&quot;", $text);
  } else {
    print 'value="' . preg_replace("/\"/", "&quot;", $text) . '"';
  }
} // function printValue($text, $ignore = false)

/**
 * Submit a comment on the governance page to the database.
 *
 * @param {String} $comment: The comment.
 * @return {Boolean}
 */
function submitGovernanceComment($comment) {
  global $mysqli;
  $userID  = $_SESSION["user_id"];
  $comment = htmlspecialchars(trim($comment));

  $statement = $mysqli->prepare("INSERT INTO constitution_comments (comment_text, date_submitted, user_id) VALUES (?, NOW(), ?)");
  $statement->bind_param("ss", $comment, $userID);
  $statement->execute();
  $statement->store_result();

  return $statement->affected_rows !== 0;
} // function submitGovernanceComments($comment)

/**
 * Renders all comments submitted on the governance page.
 */
function renderGovernanceComments() {
  global $mysqli;
  $statement = $mysqli->prepare("SELECT comment_text, date_submitted, user_id FROM constitution_comments ORDER BY date_submitted");
  $statement->execute();
  $statement->store_result();
  $statement->bind_result($comment, $date, $userID);

  while ($statement->fetch()) {
    $search = $mysqli->prepare("SELECT username FROM users WHERE id = ?");
    $search->bind_param("s", $userID);
    $search->execute();
    $search->store_result();
    $search->bind_result($username);
    $search->fetch();
    ?>
    <div class="col-xs-8">
      <h4><?php print $username; ?><time class="pull-right"><?php print $date; ?></time></h4>
      <p class="comment-text"><?php print $comment; ?></p>
      <hr>
    </div>
  <?php
  } // while ($statement->fetch())
} // function renderGovernanceComments()

/**
 * Prints an example list.
 *
 * @param {Array} $array: The pre-determined array list of examples.
 */
function printExamples($array) {
  foreach ($array as $example) {
    print "<li>" . $example . "</li>";
  }
} // function printExamples($array)

/**
 * Prints multiple options in a select dropdown.
 *
 * @param {Array} $array: The pre-determined array list of options.
 */
function printOptions($array) {
  foreach ($array as $option) {
    print "<option>" . $option . "</option>";
  }
} // function printOptions($array)

/**
 * Renders a hierarchy list of comments on the comments page.
 *
 * @param {String} $value: The value of the selected item.
 */
function renderComments($value) {
  global $mysqli;
  $statement = $mysqli->prepare("SELECT id, comments_id, reply_comment, replied_by FROM reply_$value");
  $statement->execute();
  $statement->store_result();
  $statement->bind_result($id, $commentID, $reply, $replier);
  $statement->fetch();

  $original = $mysqli->prepare("SELECT $value, user_id FROM comments WHERE id = ?");
  $original->bind_param("i", $commentID);
  $original->execute();
  $original->store_result();
  $original->bind_result($comment, $userID);
  $original->fetch();
  ?>
  <div class="comment col-xs-9">
    <?php renderCommentInterior(findUsername($userID), $comment); ?>
  </div>
  <?php // Print out the first comment because of the mandatory fetch above. ?>
  <div class="comment-reply col-xs-9">
    <?php renderCommentInterior($replier, $reply); ?>
  </div>
  <?php while ($statement->fetch()): ?>
    <div class="comment-reply col-xs-9">
      <?php renderCommentInterior($replier, $reply); ?>
    </div>
  <?php endwhile;
} // function renderComment($value)

function renderCommentInterior($user, $text) {
  ?>
  <h4><?php print $user; ?><span class="reply pull-right">Reply</span></h4>
  <p><?php print $text; ?></p>
  <?php
}

/**
 * Renders a data table on the comments page.
 *
 * @param {String} $value: The value of the selected item.
 */
function renderTable($value) {
  global $mysqli;
  $statement;

  if ($value == "genre") {
    $statement = $mysqli->prepare("SELECT genre_required_available, genre_controlled_available, suggested_terms_genre, user_id FROM comments");
  } else if ($value == "type_available") {
    $statement = $mysqli->prepare("SELECT type_available, suggested_terms_type, user_id FROM comments");
  } else if ($value == "role_available") {
    $statement = $mysqli->prepare("SELECT role_available, suggested_terms_role, user_id FROM comments");
  } else {
    $statement = $mysqli->prepare("SELECT $value, user_id FROM comments");
  }

  $statement->execute();
  $statement->store_result();

  if ($value == "genre") {
    $statement->bind_result($required, $controlled, $suggested, $userID);
  } else if ($value == "type_available" || $value == "role_available") {
    $statement->bind_result($available, $suggested, $userID);
  } else {
    $statement->bind_result($commentColumn, $userID);
  }
  ?>
  <table class="table table-striped table-hover dt">
    <thead>
      <tr>
        <th>Username</th>

        <?php if ($value == "genre"): ?>
          <th>Required/Optional</th>
          <th>Controlled/Free-Form</th>
          <th>Suggested Terms</th>
        <?php elseif ($value == "type_available" || $value == "role_available"): ?>
          <th>Available</th>
          <th>Suggested Terms</th>
        <?php else: ?>
          <th>Decision</th>
        <?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php while ($statement->fetch()): ?>
        <tr>
          <td><?php print findUsername($userID); ?></td>

          <?php if ($value == "genre"): ?>
            <td><?php print $required == "true" ? "Required" : $required == "false" ? "Optional" : "<em>No data given</em>"; ?></td>
            <td><?php print $controlled == "true" ? "Controlled" : $required == "false" ? "Free-form" : "<em>No data given</em>"; ?></td>
            <td><?php print renderTableCell($suggested); ?></td>
          <?php elseif ($value == "type_available" || $value == "role_available"): ?>
            <td><?php print renderTableCell($available); ?></td>
            <td><?php print renderTableCell($suggested); ?></td>
          <?php else: ?>
            <td><?php print renderTableCell($commentColumn); ?></td>
          <?php endif; ?>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <?php
} // function renderTable($value)

/**
 * Renders a table cell's data.
 *
 * @param {String} $data: The data.
 * @return {String}
 */
function renderTableCell($data) {
  return $data === "" || $data === NULL ? "<em>No data given</em>" : $data;
} // function renderTabelCell($data)

/**
 * Saves an entire object to the database.
 *
 * @param {$_POST} $data: The posted data from a form.
 * @param {int} $object_id: The unique identification number.
 */
function saveObjectToDB($data, $objectID) {
  global $mysqli;
  $userID = $_SESSION["user_id"];

  $customNamespace  = htmlspecialchars(trim($data["custom_namespace"]));
  $rdfAbout         = htmlspecialchars(trim($data["rdf_about"]));
  $archive          = htmlspecialchars(trim($data["archive"]));
  $title            = htmlspecialchars(trim($data["title"]));
  $type             = htmlspecialchars(trim($data["type"]));
  $url              = htmlspecialchars(trim($data["url"]));
  $origin           = htmlspecialchars(trim($data["origin"]));
  $provenance       = htmlspecialchars(trim($data["provenance"]));
  $compositionPlace = htmlspecialchars(trim($data["place_of_composition"]));
  $shelfmark        = htmlspecialchars(trim($data["shelfmark"]));

  // TODO: Add these fields to the form, pending approval from Colin and Abigail.
  $freeculture      = "true";
  $fullTextURL      = "";
  $fullTextPlain    = "";
  $isFullText       = "";
  $imageURL         = "";

  $source           = htmlspecialchars(trim($data["source"]));

  // TODO: Determine format from input and add to appropriate variable
  $metadataXMLURL   = htmlspecialchars(trim($data["metadata_xml_url"]));
  $metdataHTMLURL   = htmlspecialchars(trim($data["metadata_html_url"]));
  $textDivisions    = htmlspecialchars(trim($data["text_divisions"]));
  $language         = htmlspecialchars(trim($data["language"]));
  $ocr              = isset($data["ocr"]) ? htmlspecialchars(trim($data["ocr"])) : NULL;

  // TODO: Add this field to form, pending approval from Colin and Abigail.
  $thumbnailURL     = "";

  $notes            = $data["notes"];
  $fileFormat       = $data["file_format"];

  $statement = $mysqli->prepare("UPDATE objects SET custom_namespace = ?, rdf_about = ?, archive = ?, title = ?, type = ?, url = ?, origin = ?, provenance = ?, place_of_composition = ?, shelfmark = ?, freeculture = ?, full_text_url = ?, full_text_plain = ?, is_full_text = ?, image_url = ?, source = ?, metadata_xml_url = ?, metadata_html_url = ?, text_divisions = ?, language = ?, ocr = ?, thumbnail_url = ?, notes = ?, file_format = ?, date_updated = NOW(), user_id = ? WHERE id = ?");
  $statement->bind_param("ssssssssssssssssssssssssss", $customNamespace, $rdfAbout, $archive, $title, $type, $url, $origin, $provenance, $compositionPlace, $shelfmark, $freeculture, $fullTextURL, $fullTextPlain, $isFullText, $imageURL, $source, $metadataXMLURL, $metdataHTMLURL, $textDivisions, $language, $ocr, $thumbnailURL, $notes, $fileFormat, $userID, $objectID);
  $statement->execute();
  $statement->store_result();

  // Add alternative titles to its table.
  $insert = $mysqli->prepare("DELETE FROM alt_titles WHERE object_id = ?");
  $insert->bind_param("s", $objectID);
  $insert->execute();

  foreach ($data["alternative_title"] as $altTitle) {
    $altTitle = htmlspecialchars(trim($altTitle));

    if ($altTitle === "") { continue; }

    $insert = $mysqli->prepare("INSERT INTO alt_titles (object_id, alt_title) VALUES (?, ?)");
    $insert->bind_param("is", $objectID, $altTitle);
    $insert->execute();
  }

  // Add genres to its table.
  $genres = array();
  // TODO: Determine if $data["genre"] can just be used as an array instead of pushing all its contents into a new array.
  foreach ($data["genre"] as $genre) {
    $genre = htmlspecialchars(trim($genre));

    if ($genre === "") { continue; }

    array_push($genres, $genre);
  }

  if (count($genres) !== 0) {
    $insert = $mysqli->prepare("DELETE FROM genres WHERE object_id = ?");
    $insert->bind_param("s", $objectID);
    $insert->execute();
  }

  foreach ($genres as $genre) {
    $insert = $mysqli->prepare("INSERT INTO genres (object_id, genre) VALUES (?, ?)");
    $insert->bind_param("is", $objectID, $genre);
    $insert->execute();
  }

  // Add date to its table.
  $insert = $mysqli->prepare("DELETE FROM dates WHERE object_id = ?");
  $insert->bind_param("s", $objectID);
  $insert->execute();

  $humanDate   = htmlspecialchars(trim($data["human_date"]));
  $machineDate = htmlspecialchars(trim($data["machine_date"]));

  $insert = $mysqli->prepare("INSERT INTO dates (object_id, type, machine_date, human_date) VALUES (?, 'text', ?, ?)");
  $insert->bind_param("iss", $objectID, $machineDate, $humanDate);
  $insert->execute();

  $insert = $mysqli->prepare("DELETE FROM parts WHERE object_id = ?");
  $insert->bind_param("s", $objectID);
  $insert->execute();

  // Add isPartOf to its table.
  if (isset($data["is_part_of"])) {
    foreach ($data["is_part_of"] as $id) {
      $id = htmlspecialchars(trim($id));

      if ($id === "") { continue; }

      $insert = $mysqli->prepare("INSERT INTO parts (object_id, type, part_id) VALUES (?, 'isPartOf', ?)");
      $insert->bind_param("ii", $objectID, $id);
      $insert->execute();
    }
  }

  // Add hasPart to its table.
  if (isset($data["has_part"])) {
    foreach ($data["has_part"] as $id) {
      $id = htmlspecialchars(trim($id));

      if ($id === "") { continue; }

      $insert = $mysqli->prepare("INSERT INTO parts (object_id, type, part_id) VALUES (?, 'hasPart', ?)");
      $insert->bind_param("ii", $objectID, $id);
      $insert->execute();
    }
  }

  // Add roles to its table
  $insert = $mysqli->prepare("DELETE FROM roles WHERE object_id = ?");
  $insert->bind_param("s", $objectID);
  $insert->execute();

  $i = 0;
  $roleValues = array();
  // TODO: Determine if $data["role_value"] can just be used as an array instead of pushing all its contents into a new array.
  if (isset($data["role_value"], $data["role"])) {
    foreach ($data["role_value"] as $value) {
      array_push($roleValues, $value);
    }

    foreach ($data["role"] as $role) {
      $value = htmlspecialchars(trim($roleValues[$i++]));
      $role  = htmlspecialchars(trim($role));

      if ($value === "" || $role === "") { continue; }

      $insert = $mysqli->prepare("INSERT INTO roles (object_id, role, value) VALUES (?, ?, ?)");
      $insert->bind_param("iss", $objectID, $role, $value);
      $insert->execute();
    }
  }
} // function saveObjectToDB($data, $objectID)


