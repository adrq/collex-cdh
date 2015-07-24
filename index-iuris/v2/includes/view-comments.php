<?php
/**
 * @file view-comments.php
 * Renders all comments for users.
 */
require "config.php";

if (isset($_GET["comments"])) {
  global $mysqli;
  session_start();

  $userID = $_SESSION["user_id"];

  
  

  $comment_name=$_GET["comments"];
  $results = $mysqli->query("select user_id,$comment_name from comments");
  print '<table border="3">';
  print '<tr>';
  print '<th> User Name    </th>';
  print '<th> Comment </th>';
  print '</tr>';
  while($row = $results->fetch_assoc()) {
  	    print '<tr>';
	    $statement = $mysqli->prepare("SELECT username FROM users WHERE id = ?");
	    $statement->bind_param("s", $row["user_id"]);
	    $statement->execute();
	    $statement->store_result();
	    $statement->bind_result($username);
	    $statement->fetch();
	    print '<td>' .$username.'</td>';
  	    print '<td>' .$row[$_GET["comments"]].'</td>';
  	    print '</tr>';
  	}  
  print '</table>';
  

  //print "<p>" . $commentResult . "</p>";
  exit();
} else {
  header("Location: ./");
}
