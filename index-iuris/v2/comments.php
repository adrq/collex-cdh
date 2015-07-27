<?php
/**
 * @file comments.php
 * Prints all comments for super users.
 */
require_once "includes/config.php";

if (isset($_GET["comments"])) {
  global $mysqli;
  session_start();

  $commentName = $_GET["comments"];

  $statement = $mysqli->prepare("SELECT user_id, $commentName FROM comments");
  $statement->execute();
  $statement->store_result();
  $statement->bind_result($userID, $commentColumn);
  ?>
  <table class="table table-striped table-hover dt">
    <thead>
      <tr>
        <th>Username</th>
        <th>Comment</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while ($statement->fetch()):
        $temp = $mysqli->prepare("SELECT username FROM users WHERE id = ?");
        $temp->bind_param("s", $userID);
        $temp->execute();
        $temp->store_result();
        $temp->bind_result($username);
        $temp->fetch();
        ?>
        <tr>
          <td><?php print $username; ?></td>
          <td><?php print $commentColumn; ?></td>
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
    <div class="col-xs-6">
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
                <option value="genre">Suggested Genre Terms</option>
                <option value="custom_namespace_available">Custom Namespace Decisions</option>
                <option value="url_available">URI or URL Decisions</option>
                <option value="type_available">Type Decisions</option>
                <option value="role_available">Role Decisions</option>
				<option value="date">Date</option>
              </select>
            </div>
          </div>
        </fieldset>
      </form>

      <section id="commentResults"></section>
    </div>

    <div class="col-xs-6">
      <?php // TODO: Insert other area. ?>
    </div>
  </div>
</div>

<?php require "includes/footer.php"; ?>
