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
define("DB_HOST", "127.0.0.1");
define("DB_USER", "collex");
define("DB_PASS", "password");
define("DB_BASE", "cdh_rdf_inbox");

global $mysqli;
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_BASE);

if ($mysqli->connect_error || $mysqli->connect_errno) {
  print "<h1 class='text-danger'>Database Connection Error (" . $mysqli->connect_errno . ")</h1>";
}

global $objectsTableColumDisplayNames;

$objectsTableColumDisplayNames = array(
		"custom_namespace" => "Custom namespace",
		"rdf_about" => "Unique identifier (URI)",
		"archive" => "Archive",
		"title" => "Title",
		"type" => "Type" ,
		"url" => "URL" ,
		"origin" => "Origin" ,
		"provenance" => "Provenance" ,
		"place_of_composition" => "Place of Composition" ,
		"shelfmark" => "Shelfmark" ,
		"freeculture" => "Freeculture" ,
		"full_text_url" => "Full text URL" ,
		"full_text_plain" => "Full text" ,
		"is_full_text" => "Fulltext" ,
		"image_url" => "Image URL" ,
		"source" => "Source" ,
		"metadata_xml_url" => "XML Metadata URL" ,
		"metadata_html_url" => "HTML Metadata URL" ,
		"text_divisions" => "Divisions of the Text" ,
		"language" => "Language" ,
		"ocr" => "OCR" ,
		"thumbnail_url" => "Thumbnail URL" ,
		"notes" => "Notes" ,
		"file_format" => "File format" ,
		"date_created" => "Date created",
		"date_updated" => "Date updated",
		"user_id" => "User ID"
);

global $objectsTableInputTypes;

$objectsTableInputTypes = array(
		"custom_namespace" => "text" ,
		"rdf_about" => "text" ,
		"archive" => "text" ,
		"title" => "text" ,
		"type" => "text" ,
		"url" => "text" ,
		"origin" => "text" ,
		"provenance" => "text" ,
		"place_of_composition" => "text" ,
		"shelfmark" => "text" ,
		"freeculture" => "radio" ,
		"full_text_url" => "text" ,
		"full_text_plain" => "textarea" ,
		"is_full_text" => "radio" ,
		"image_url" => "text" ,
		"source" => "text" ,
		"metadata_xml_url" => "text" ,
		"metadata_html_url" => "text" ,
		"text_divisions" => "textarea" ,
		"language" => "text" ,
		"ocr" => "radio" ,
		"thumbnail_url" => "text" ,
		"notes" => "textarea" ,
		"file_format" => "text" ,
		"date_created" => "date",
		"date_updated" => "date",
		"user_id" => "user"
);

global $rolesArray;
$rolesArray = array(
		"Author",
		"Editor",
		"Publisher",
		"Translator",
		"Creator",
		"Etcher",
		"Engraver",
		"Owner",
		"Artist",
		"Architect",
		"Binder",
		"Book designer",
		"Book producer",
		"Calligrapher",
		"Cartographer",
		"Collector",
		"Colorist",
		"Commentator for written text",
		"Compiler",
		"Compositor",
		"Creator",
		"Dubious author",
		"Facsimilist",
		"Illuminator",
		"Illustrator",
		"Lithographer",
		"Printer",
		"Printer of plates",
		"Printmaker",
		"Repository",
		"Rubricator",
		"Scribe",
		"Sculptor",
		"Type designer",
		"Typographer",
		"Visual Artist",
		"Wood engraver",
		"Wood cutter"
);

global $genresArray;
$genresArray = array(
		"Account",
		"Accusation",
		"Aide",
		"Amercement",
		"Appeal",
		"Assize",
		"Benefice",
		"Brief",
		"Canon",
		"Casus",
		"Causa",
		"Census",
		"Certificate",
		"Challenge",
		"Charge",
		"Code of laws",
		"Collection",
		"Commentary",
		"Consilium",
		"Consistory",
		"Contract",
		"Corpus",
		"Council",
		"Covenant",
		"Damages",
		"Defense",
		"Decretal",
		"Deposition",
		"Dicta",
		"Dispensation",
		"Distinction",
		"Edict",
		"Enfeoffement",
		"Evidence",
		"Formula",
		"Gloss",
		"Handbook",
		"Immunity",
		"Imperial constitution",
		"Inquest",
		"Inquisition",
		"Investigation",
		"Judgment",
		"Manumission",
		"Narrative",
		"Oath",
		"Opinion",
		"Petition",
		"Plea",
		"Prescription",
		"Privilege",
		"Process",
		"Proof",
		"Receipt",
		"Regulation",
		"Rescript",
		"Response",
		"Statute",
		"Summa",
		"Summation",
		"Synod",
		"Testament",
		"Testimony",
		"Treatise",
		"Trial",
		"Textbook",
		"Verdict",
		"Voucher",
		"Will",
		"Writ"
);
