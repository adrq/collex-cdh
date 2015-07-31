<?php
/**
 * @file reply.php
 * Prints the reply page.
 */
if (isset($_POST["comment"], $_POST["table"], $_POST["id"])) {
  require_once "includes/config.php";
  session_start();
  global $mysqli;

  $id    = $_POST["id"];
  $table = $_POST["table"];

  if (!in_array($table, array("comments_date", "comments_has_part", "comments_is_part_of", "comments_notes", "comments_place_of_composition", "comments_provenance", "comments_rdf_about", "comments_text_divisions"))) { ?>
    <script>alert("Please do not alter hidden values."); window.location = "logout";</script>
    <?php
    // For a split second, JavaScript does not execute.
    // This header will be the fall-back and exit() will reassure that nothing else will be displayed.
    header("Location: logout");
    exit();
  }

  $comment  = htmlspecialchars(trim($_POST["comment"]));
  $username = $_SESSION["username"];

  $statement = $mysqli->prepare("INSERT INTO reply_$table (comments_id, reply_comment, replied_by) VALUES (?, ?, ?)");
  $statement->bind_param("iss", $id, $comment, $username);
  $statement->execute();
  $statement->store_result();

  if ($statement->affected_rows === 0) {
    ?><script>alert("Your comment was unable to be submitted. Please try again later."); window.location = "comments";</script><?php
  } else {
    header("Location: view-reply?id=" . $id . "&commentName=" . $table);
  }
}

$id          = $_GET["id"];
$table       = $_GET["tableName"];
$username    = $_GET["username"];
$commentName = $_GET["commentName"];

$title = "Reply";
$loginRequired = true;
require "includes/header.php";
?>

<div class="container">
  <div class="row page-header">
    <div class="col-xs-12">
      <h4>
      <h4>Commented By: <?php print $username; ?></h4>
      <h4>Comment:<?php print $commentName; ?></h4>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <form class="form-horizontal" action="<?php print htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
        <fieldset>
          <section class="form-group">
            <label for="comment" class="control-label col-xs-2">Reply</label>
            <div class="col-xs-10">
              <input type="text" class="form-control" id="comment" name="comment">
            </div>
          </section>

          <section class="form-group">
            <div class="col-xs-3 center-block">
              <input type="hidden" name="id" value="<?php print $id; ?>">
              <input type="hidden" name="table" value="<?php print $table; ?>">
              <button type="submit" class="btn btn-success col-xs-12">Submit</button>
            </div>
          </section>
        </fieldset>
      </form>
    </div>
  </div>

</div>

<?php require "includes/footer.php"; ?>
