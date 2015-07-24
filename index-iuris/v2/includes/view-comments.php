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

  $statement = $mysqli->prepare("SELECT username FROM users WHERE id = ?");
  $statement->bind_param("s", $userID);
  $statement->execute();
  $statement->store_result();
  $statement->bind_result($username);
  $statement->fetch();

  $commentColumn = $_GET["comments"];
  $comment = $mysqli->prepare("SELECT $commentColumn FROM comments");
  $comment->execute();
  $comment->store_result();
  $comment->bind_result($commentResult);
  $comment->fetch();

  print "<p>" . $commentResult . "</p>";
  exit();
} else {
  header("Location: ./");
}
