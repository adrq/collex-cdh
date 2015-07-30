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
$title = "View All Reply";
$loginRequired = true;
require "includes/header.php";
$comment_name = $_GET["comment_name"];
$username = $_GET["username"];
$table_name = "reply_".$_GET["table_name"];
$id = $_GET["id"];
$table = $_GET["table_name"];
$reply_username = $_SESSION["username"];
?>

<div class="container">
  <div class="row page-header">
    <div class="col-xs-12">
      <h4><?php print "User Name : $username"; ?></h4>
	  <h4><?php print "User Comment : $comment_name"; ?></h4>
    </div>
  </div>
  <form method="POST" >
  <div class="form-group">
    <label for="replyforcomment" class="control-label col-xs-12">Please Reply to the comment here:</label>
    <div class="col-xs-12">
      <input type="text" class="form-control" name="replycomment" id="replycomment">
    </div>
	
  </div>
  <br>
  <br>
  	
</div>

<section class="form-group " style=" margin-top: 1%; margin-left: 25%">
  	<div class="col-xs-1">
        <button type="submit" class="btn btn-success col-xs-12" name="button1">Submit</button>
  	</div>
 </section> 
 </form>
 
 <?php
 if (isset($_POST['button1'])):  
	 $statement = $mysqli->prepare("INSERT into $table_name(comments_id,reply_comment,replied_by) values(?,?,?)");
 	 print $mysqli->error;
	 $statement->bind_param("sss", $_GET["id"], $_POST["replycomment"],$reply_username);
	 $statement->execute();
	 $statement->close();
	 
?>	 
	
	<section class="form-group " style=" margin-top: 1%; margin-left: 25%">
		<br>
		<br>
		<br>
		<h4> Comment submitted succesfully. Please click below to view all comments.</h4>
		<br>
	<td class="text-center">
		  <a href="view-reply?id=<?php print $id; ?>&comment_name=<?php print $table; ?>" class="btn btn-success">View all Replies</a>
	</td> 
	 </section> 
<?php endif; ?> 	   	
    
<?php require "includes/footer.php"; ?>