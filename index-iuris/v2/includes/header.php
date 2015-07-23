<?php
/**
 * @file header.php
 * Prints out the HTML structure.
 */
error_reporting(-1);
ini_set("display_errors", "On");
session_start();

require_once "config.php";

if (isset($loginRequired) && $loginRequired && !$_SESSION["logged-in"]) {
  header("Location: login");
}

?><!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">

  <title><?php print isset($title) ? $title . " - " : ""; ?>Index Iuris</title>

  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/collex.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <nav class="nav navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <?php for ($i = 0; $i < 3; $i++): ?>
            <span class="icon-bar"></span>
          <?php endfor; ?>
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
          <li><a href="rdf-form">Metadata Submission</a></li>
          <li><a href="governance">Governance</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php print $_SESSION["username"]; ?> <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="logout">Logout</a></li>
            </ul>
          </li>
          <?php else: ?>
          <li <?php print $title == "Login" ? "class='active'" : ""; ?> ><a href="login">Login</a></li>
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

