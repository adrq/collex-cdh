<?php
/**
 * @file view-reply.php
 * Prints the view reply page.
 */
if (!isset($_GET["commentName"])) {
  header("Location: comments");
}

$title = "All Replies";
$loginRequired = true;
require "includes/header.php";

$commentName = $_GET["commentName"];

$statement = $mysqli->prepare("SELECT comments_id, reply_comment, replied_by FROM reply_$commentName");
$statement->execute();
$statement->store_result();
$statement->bind_result($commentID, $replyComment, $repliedBy);
?>

<div class="container">
  <div class="row page-header">
    <div class="col-xs-12">
      <h3>Comments for: <?php print $commentName; ?></h3>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <?php while ($statement->fetch()): ?>
        <?php
        $temp = $mysqli->prepare("SELECT user_id, $commentName FROM comments WHERE id = ?");
        $temp->bind_param("s", $commentID);
        $temp->execute();
        $temp->store_result();
        $temp->bind_result($user_id, $comment);
        $temp->fetch();

        $temp2 = $mysqli->prepare("SELECT username from users where id = ?");
        $temp2->bind_param("s", $user_id);
        $temp2->execute();
        $temp2->store_result();
        $temp2->bind_result($username);
        $temp2->fetch();
        ?>
        <p>Comment by: <?php print $username; ?></p>
        <p>Comment: <?php print $comment; ?></p>
        <p>Reply by: <?php print $repliedBy; ?></p>
        <p>Reply: <?php print $replyComment; ?></p>
        <hr>
      <?php endwhile; ?>
    </div>
  </div>
</div>

<?php require "includes/footer.php"; ?>
