<?php
/**
 * @file view-comments.php
 * Renders all comments for users.
 */
require "config.php";

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
} else {
  header("Location: ./");
}
