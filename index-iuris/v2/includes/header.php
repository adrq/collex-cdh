<?php
/**
 * @file header.php
 * Prints out the HTML structure.
 */
session_start();

$loginRequired = isset($loginRequired) ? $loginRequired : false;
if ($loginRequired && !isset($_SESSION["logged-in"]) && !$_SESSION["logged-in"]) {
  header("Location: login");
}

error_reporting(-1);
ini_set("display_errors", "On");

require_once "config.php";

?><!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">

  <title><?php print isset($title) ? $title . " - " : ""; ?>Index Iuris</title>

  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
  <?php foreach (array("bootstrap.css", "dataTables.bootstrap.css", "collex.css") as $style): ?>
  <link rel="stylesheet" href="css/<?php print $style; ?>">
  <?php endforeach; ?>
</head>
<body>
  <noscript>
    <style>nav, .container { display: none !important; }</style>
    <p>You need JavaScript enabled to use this site.</p>
  </noscript>

  <nav class="nav navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <?php
        // TODO: Convert to image.
        // TOOD: Convert to .png
        // <img src="img/logo.jpg" class="img-responsive" alt="Index Iuris">
        ?>
        <a href="./" class="navbar-brand">Index Iuris</a>
      </div>

      <div class="collapse navbar-collapse" id="menu">
        <ul class="nav navbar-nav navbar-right">
          <li <?php print $title == "Home" ? "class='active'" : ""; ?> ><a href="./">Home</a></li>

          <?php if (isset($_SESSION["logged-in"]) && $_SESSION["logged-in"]): ?>
          <li <?php print $title == "Metadata Submission Form" ? "class='active'" : ""; ?> ><a href="rdf-form">Metadata Submission</a></li>
          <li <?php print $title == "Governance" ? "class='active'" : ""; ?> ><a href="governance">Governance</a></li>
          <li <?php print $title == "View Submissions" || $title == "View Submission" ? "class='active'" : ""; ?> ><a href="submissions">View Submissions</a></li>
          <?php // TODO: Show this tab only if the user is superuser. ?>
          <li <?php print $title == "Comments and Suggested Items" ? "class='active'" : ""; ?> ><a href="comments">Comments</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php print $_SESSION["username"]; ?> <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="logout">Logout</a></li>
            </ul>
          </li>
          <?php else: ?>
          <li <?php print $title == "Login" ? "class='active'" : ""; ?> ><a href="login">Login</a></li>
          <li <?php print $title == "Register" ? "class='active'" : ""; ?> ><a href="register">Register</a></li>
          <?php endif; ?>

          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Contact <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="mailto:wildercf@mailbox.sc.edu">Colin Wilder (University of South Carolina)</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="mailto:afire2@uky.edu">Abigail Firey (University of Kentucky)</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
