<?php
/**
 * @file index.php
 * Prints the home pagae.
 */
$title = "Home";
require "includes/header.php";
?>
<form action="process.php" method='post'>
<div class="container">
  <div class="row page-header">
    <div class="col-xs-12">
		<legend>Comments</legend>
		<p> Please select a comment you wish to see from the below drop down list </p>
        <div class="form-group">
          <label for="comment" class="control-label col-xs-2"><button type="button" class="close hide pull-left">x</button>Comment</label>
          <div class="col-xs-10">
            <select class="form-control" id="comment" name="comment">
              <option selected=""></option>
			  <option value="comments_rdf_about">RDF: About</option>
			    <option value="comments_date">Date</option>
			    <option value="comments_provenance">Provenance</option>
			    <option value="comments_place_of_composition">Place of composition</option>
			    <option value="comments_is_part_o">Is-Part-Of</option>
			    <option value="comments_has_part">Has-Part</option>
			    <option value="comments_text_divisions">Text-division</option>
			    <option value="comments_notes">Notes</option>
            </select>
          </div>
        </div>
    </div>
  </div>
</div>
</form>
<?php 

$mysqli  = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_BASE);
if ($mysqli->connect_error) {
  exit("<h2 class='text-danger'>Database connection error. (" . $mysqli->connect_errno . ")</h2>");
}
$userID  = $_SESSION['user_id'];
$username = $mysqli->prepare("SELECT username FROM users WHERE id = ?");
$username->bind_param("s", $userID);
$username->execute();
$username->bind_result($username);
$username->fetch();
printf( "<h3>username is </h3> %s", $username);

$comment_name=$_POST['comment'];
$comment = $mysqli->prepare("SELECT $comment_name FROM comments");
$comment->execute();
$comment->bind_result($comment_results);
$comment->fetch();
printf( "<h3>username is </h3> %s", $comment_results); 
?>

<?php require "includes/footer.php"; ?>