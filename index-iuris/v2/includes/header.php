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

  <?php if ($title == "Metadata Submission Form"): ?>
  <?php // TODO: Move to footer. - JavaScript slows down webpage load when in <head> ?>
  <script src="js/jquery.min.js"></script>
  <script>
  $(document).ready(function() {
      var role_wrapper = $("#role_fields_wrap"); //Fields wrapper
      var genre_wrapper = $("#genre-fields-wrap"); //Fields wrapper
      var add_role_button = $("#add-role-button"); //Add button ID
      var add_genre_button = $("#add-genre-button"); //Add button ID
      var alt_title_wrapper = $("#alt-title-fields-wrap"); //Fields wrapper
      var add_alt_title_button = $("#add-alt-title-button"); //Add button ID
      var has_part_wrapper = $("#has-part-wrap"); //Fields wrapper
      var add_has_part_button = $("#add-has-part-button"); //Add button ID

      $(add_role_button).click(function(e){ //on add input button click
          var inputFields;
        $.ajax({
            url: "includes/form-include.php",
            data: {
              "form-element" : "role"
            },
            success: function( data ) {
              inputFields = data;
              $(role_wrapper).append(inputFields);
            }
          });
          e.preventDefault();

      });

      $(add_genre_button).click(function(e){ //on add input button click
          var inputFields;
        $.ajax({
            url: "includes/form-include.php",
            data: {
              "form-element" : "genre"
            },
            success: function( data ) {
              inputFields = data;
              $(genre_wrapper).append(inputFields);
            }
          });
          e.preventDefault();

      });

      $(add_alt_title_button).click(function(e){ //on add input button click
          var inputFields;
        $.ajax({
            url: "includes/form-include.php",
            data: {
              "form-element" : "alt-title"
            },
            success: function( data ) {
              inputFields = data;
              $(alt_title_wrapper).append(inputFields);
            }
          });
          e.preventDefault();

      });

      $(add_has_part_button).click(function(e){ //on add input button click
          var inputFields;
        $.ajax({
            url: "includes/form-include.php",
            data: {
              "form-element" : "has-part"
            },
            success: function( data ) {
              inputFields = data;
              $(has_part_wrapper).append(inputFields);
            }
          });
          e.preventDefault();

      });


      $(genre_wrapper).on("click",".remove_field", function(e){ //user click on remove text
          e.preventDefault(); $(this).parent('div').remove();
      })
      $(role_wrapper).on("click",".remove_field", function(e){ //user click on remove text
          e.preventDefault(); $(this).parent('div').remove();
      })
      $(alt_title_wrapper).on("click",".remove_field", function(e){ //user click on remove text
          e.preventDefault(); $(this).parent('div').remove();
      })
      $(has_part_wrapper).on("click",".remove_field", function(e){ //user click on remove text
          e.preventDefault(); $(this).parent('div').remove();
      })
  });
  </script>
  <?php endif; ?>

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

