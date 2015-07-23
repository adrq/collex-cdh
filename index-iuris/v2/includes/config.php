<?php
/**
 * @file config.php
 * Determines variables to be used throughout the site.
 */

error_reporting(-1);
ini_set("display_errors", "On");

// TODO: Remove these.
$database_host = "127.0.0.1";
$database_username = "collex";
$database_password = "password";
$database_database = "cdh_rdf_inbox";

// TODO: Convert these to proper values.
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "root");
define("DB_BASE", "collex");

global $mysqli;
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_BASE);

if ($mysqli->connect_error || $mysqli->connect_errno) {
  print "<h1 class='text-danger'>Database Connection Error (" . $mysqli->connect_errno . ")</h1>";
}
