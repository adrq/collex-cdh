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
    $statement = $mysqli->prepare("SELECT id,user_id, type_available, role_available, date_available, suggested_terms_type, suggested_terms_role, comments_date FROM comments");
  } else {
    $statement = $mysqli->prepare("SELECT id,user_id, $commentName FROM comments");
  }

  $statement->execute();
  $statement->store_result();

  if ($commentName == "genre") {
    $statement->bind_result($userID, $genreRequired, $genreControlled, $suggestedGenre);
  } else if ($commentName == "type_available" || $commentName == "role_available" || $commentName == "comments_date") {
    $statement->bind_result($id,$userID, $typeAvailable, $roleAvailable, $dateAvailable, $suggestedType, $suggestedRole, $commentDate);
  } else {
    $statement->bind_result($id,$userID, $commentColumn);
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
		 <th>View All Reply</th>
        <?php elseif ($commentName == "custom_namespace_available" || $commentName == "url_available"): ?>
          <th>Decision</th>
        <?php else: ?>
		  <th>Commented By</th>
          <th>Comment</th>
		  <th>Reply</th>
		  <th>View All Reply</th>
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
				  <a href="reply?username=<?php print $username; ?>&comment_name=<?php print $commentDate ?>&table_name=<?php print $commentName; ?>&id=<?php print $id; ?>" class="btn btn-primary">Reply</a>
			</td>
			<td class="text-center">
				  <a href="view-reply?id=<?php print $id; ?>&comment_name=<?php print $commentName; ?>" class="btn btn-success">View all Replys</a>
			</td>
          <?php elseif ($commentName == "custom_namespace_available" || $commentName == "url_available"): ?>
            <td><?php print $commentColumn; ?></td>	
          <?php else: ?>
            <td><?php print $commentColumn; ?></td>
	  		<td class="text-center">
	  			  <a href="reply?username=<?php print $username; ?>&comment_name=<?php print $commentColumn ?>&table_name=<?php print $commentName; ?>&id=<?php print $id; ?>" class="btn btn-primary">Reply</a>
	  		</td>
	  		<td class="text-center">
	  			  <a href="view-reply?id=<?php print $id; ?>&comment_name=<?php print $commentName; ?>" class="btn btn-success">View all Replys</a>
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
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <form class="form-horizontal">
        <fieldset>
          <div class="form-group">
            <label for="comment" class="control-label col-xs-3">Suggested Item</label>
            <div class="col-xs-9">
              <select class="form-control" id="comment" name="comment">
                <option selected=""></option>
                <option value="comments_rdf_about">RDF: About</option>
                <option value="comments_provenance">Provenance</option>
                <option value="comments_place_of_composition">Place of composition</option>
                <option value="comments_is_part_of">Is-Part-Of</option>
                <option value="comments_has_part">Has-Part</option>
                <option value="comments_text_divisions">Text-Division</option>
                <option value="comments_notes">Notes</option>
                <option value="genre">Genre</option>
                <option value="custom_namespace_available">Custom Namespace Decisions</option>
                <option value="url_available">URI or URL Decisions</option>
                <option value="type_available">Type Decisions</option>
                <option value="role_available">Role Decisions</option>
                <option value="comments_date">Date</option>
              </select>
            </div>
          </div>
        </fieldset>
      </form>

      <section id="commentResults"></section>
    </div>
  </div>

</div>

<?php require "includes/footer.php"; ?>
