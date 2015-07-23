<?php
/**
 * @file new-comment.php
 * Submits a user-created comment to the database.
 */
require "includes/config.php";
session_start();

if (isset($_POST) && $_SESSION["logged-in"]) {
  global $mysqli;
  $userID  = $_SESSION["user_id"];
  $comment = htmlspecialchars($_POST["commentText"]); //removed real_escape_string - no need with prepared statements

  $statement = $mysqli->prepare("INSERT INTO constitution_comments (comment_text, date_submitted, user_id) VALUES (?, NOW(), ?)");
  $statement->bind_param("ss", $comment, $userID);
  $statement->execute();
  $statement->store_result();

  if ($statement->affected_rows === 0) {
    print "<p>Something broke... (" . $statement->errno . ") " . $statement->error . "</p>";
  } else {
    header("Location: governance#newComment");
  }

} else {
  header("Location: ./");
}
