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
$title = "Reply Page";
$loginRequired = true;
require "includes/header.php";
$comment_name = $_GET["comment_name"];
$table_name = "reply_".$comment_name;

$statement = $mysqli->prepare("SELECT comments_id,reply_comment,replied_by FROM $table_name");
$statement->execute();
$statement->store_result();
$statement->bind_result($comment_id,$reply_comment,$replied_by);
?>

<div class="container">
	<div class="row page-header">
		<h3> Comments for : <?php print $comment_name; ?> </h3>
		</div>
    <div class="col-xs-12">
		
				<?php
						
							while ($statement->fetch()): 
							$temp = $mysqli->prepare("SELECT user_id,$comment_name FROM comments WHERE id = ?");
							$temp2 = $mysqli->prepare("SELECT username from users where id = ?");
						    $temp->bind_param("s", $comment_id);
						    $temp->execute();
						    $temp->bind_result($user_id,$comment);
						    $temp->fetch();
							$temp->close();
						    $temp2->bind_param("s", $user_id);
						    $temp2->execute();
						    $temp2->bind_result($username);
						    $temp2->fetch();
							$temp2->close();
				?>
		          <tr>
					  <p> Comment by : <?php print $username; ?></p>
					  <p> Comment : <?php print $comment; ?></p>
					  <p> Reply by : <?php print $replied_by; ?></p>
					  <p> Reply : <?php print $reply_comment; ?></p>						
  		  			  <hr>
					  <?php endwhile; ?>
	</div>
</div>
	



<?php require "includes/footer.php"; ?>
