<?php
/**
 * @file comments.php
 * Prints all comments for super users.
 */

if (isset($_GET["comments"])) {
  require_once "includes/config.php";

  global $mysqli;
  session_start();

  $statement;
  $commentName = $_GET["comments"];

  if ($commentName == "genre") {
    $statement = $mysqli->prepare("SELECT user_id, genre_required_available, genre_controled_available, suggested_terms_genre FROM comments");
  } else if ($commentName == "type_available" || $commentName == "role_available" || $commentName == "comments_date") {
    $statement = $mysqli->prepare("SELECT id, user_id, type_available, role_available, date_available, suggested_terms_type, suggested_terms_role, comments_date FROM comments");
  } else {
    $statement = $mysqli->prepare("SELECT id, user_id, $commentName FROM comments");
  }

  $statement->execute();
  $statement->store_result();

  if ($commentName == "genre") {
    $statement->bind_result($userID, $genreRequired, $genreControlled, $suggestedGenre);
  } else if ($commentName == "type_available" || $commentName == "role_available" || $commentName == "comments_date") {
    $statement->bind_result($id, $userID, $typeAvailable, $roleAvailable, $dateAvailable, $suggestedType, $suggestedRole, $commentDate);
  } else {
    $statement->bind_result($id, $userID, $commentColumn);
  }

  ?>
  <table class="table table-striped table-hover dt">
    <thead>
      <tr>
        <?php if ($commentName == "genre"): ?>
          <th>User</th>
          <th>Required/Optional</th>
          <th>Controlled/Free-Form</th>
          <th>Suggested Term</th>
        <?php elseif ($commentName == "type_available" || $commentName == "role_available"): ?>
          <th>Commented By</th>
          <th>Decision</th>
          <th>Suggested items</th>
        <?php elseif ($commentName == "comments_date"): ?>
          <th>Commented By</th>
          <th>Decision</th>
          <th>Comments</th>
          <th>Reply</th>
          <th>All Replies</th>
        <?php elseif ($commentName == "custom_namespace_available" || $commentName == "url_available"): ?>
          <th>User</th>
          <th>Decision</th>
        <?php else: ?>
          <th>Commented By</th>
          <th>Comment</th>
          <th>Reply</th>
          <th>All Replies</th>
        <?php endif; ?>
      </tr>
    </thead>
    <tbody>
      <?php
      $temp = $mysqli->prepare("SELECT username FROM users WHERE id = ?");
      while ($statement->fetch()):
        $temp->bind_param("s", $userID);
        $temp->execute();
        $temp->bind_result($username);
        $temp->fetch();
        ?>
        <tr>
          <td><?php print $username; ?></td>

          <?php if ($commentName == "genre"): ?>
            <td><?php print $genreRequired; ?></td>
            <td><?php print $genreControlled; ?></td>
            <td><?php print $suggestedGenre; ?></td>
          <?php elseif ($commentName == "type_available"): ?>
            <td><?php print $typeAvailable; ?></td>
            <td><?php print $suggestedType; ?></td>
          <?php elseif ($commentName == "role_available"): ?>
            <td><?php print $roleAvailable; ?></td>
            <td><?php print $suggestedRole; ?></td>
          <?php elseif ($commentName == "comments_date"): ?>
            <td><?php print $dateAvailable; ?></td>
            <td><?php print $commentDate; ?></td>
            <td class="text-center">
              <a href="reply?username=<?php print $username; ?>&amp;commentName=<?php print $commentDate; ?>&amp;tableName=<?php print $commentName; ?>&amp;id=<?php print $id; ?>" class="btn btn-primary">Reply</a>
            </td>
            <td class="text-center">
              <a href="view-reply?id=<?php print $id; ?>&amp;commentName=<?php print $commentName; ?>" class="btn btn-success">View</a>
            </td>
          <?php elseif ($commentName == "custom_namespace_available" || $commentName == "url_available"): ?>
            <td><?php print $commentColumn; ?></td>
          <?php else: ?>
            <td><?php print $commentColumn; ?></td>
            <td class="text-center">
              <a href="reply?username=<?php print $username; ?>&amp;commentName=<?php print $commentDate; ?>&amp;tableName=<?php print $commentName; ?>&amp;id=<?php print $id; ?>" class="btn btn-primary">Reply</a>
            </td>
            <td class="text-center">
              <a href="view-reply?id=<?php print $id; ?>&amp;commentName=<?php print $commentName; ?>" class="btn btn-success">View</a>
            </td>
          <?php endif; ?>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <?php
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
    array("value" => "genre", "title" => "Genre"),
    array("value" => "custom_namespace_available", "title" => "Custom Namespace Decisions"),
    array("value" => "url_available", "title" => "URI or URL Decisions"),
    array("value" => "type_available", "title" => "Type Decisions"),
    array("value" => "role_available", "title" => "Role Decisions"),
    array("value" => "comments_date", "title" => "Date")
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
      <section id="commentResults"></section>
    </div>
  </div>

</div>

<?php require "includes/footer.php"; ?>
