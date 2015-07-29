<?php
/**
 * @file functions.php
 * Functions used throughout the website.
 *
 * Note: Assure that config.php is imported prior to this file being executed.
 */

// Assure error reporting is on.
error_reporting(-1);
ini_set("display_errors", "On");

/**
 * Renders MySQL values into HTML-ready entities.
 * - Currently only detects quotation marks.
 *
 * @param {String} $text: The MySQL value.
 */
function printValue($text) {
	print 'value="' . preg_replace("/\"/", "&quot;", $text) . '"';
}

/**
 * Saves an entire object to the database.
 *
 * @param {$_POST} $data: The posted data from a form.
 * @param {int} $object_id: The unique identification number.
 */
function saveObjectToDB($data, $objectID) {
	global $mysqli;
	$userID = $_SESSION["user_id"];

	$customNamespace  = $data["custom_namespace"];
	$rdfAbout         = $data["rdf_about"];
	$archive          = $data["archive"];
	$title            = $data["title"];
	$type             = $data["type"];
	$url              = $data["url"];
	$origin           = $data["origin"];
	$provenance       = $data["provenance"];
	$compositionPlace = $data["place_of_composition"];
	$shelfmark        = $data["shelfmark"];

	// TODO: Add these fields to the form, pending approval from Colin and Abigail.
	$freeculture      = "true";
	$fullTextURL      = "";
	$fullTextPlain    = "";
	$isFullText       = "";
	$imageURL         = "";

	$source           = $data["source"];

	// TODO: Determine format from input and add to appropriate variable
	$metadataXMLURL   = $data["metadata_xml_url"];
	$metdataHTMLURL   = $data["metadata_html_url"];
	$textDivisions    = $data["text_divisions"];
	$language         = $data["language"];
	$ocr              = isset($data["ocr"]) ? $data["ocr"] : NULL;

	// TODO: Add this field to form, pending approval from Colin and Abigail.
	$thumbnailURL     = "";

	$notes            = $data["notes"];
	$fileFormat       = $data["file_format"];

	$statement = $mysqli->prepare("UPDATE objects SET custom_namespace = ?, rdf_about = ?, archive = ?, title = ?, type = ?, url = ?, origin = ?, provenance = ?, place_of_composition = ?, shelfmark = ?, freeculture = ?, full_text_url = ?, full_text_plain = ?, is_full_text = ?, image_url = ?, source = ?, metadata_xml_url = ?, metadata_html_url = ?, text_divisions = ?, language = ?, ocr = ?, thumbnail_url = ?, notes = ?, file_format = ?, date_updated = NOW(), user_id = ? WHERE id = ?");
	$statement->bind_param("ssssssssssssssssssssssssss", $customNamespace, $rdfAbout, $archive, $title, $type, $url, $origin, $provenance, $compositionPlace, $shelfmark, $freeculture, $fullTextURL, $fullTextPlain, $isFullText, $imageURL, $source, $metadataXMLURL, $metdataHTMLURL, $textDivisions, $language, $ocr, $thumbnailURL, $notes, $fileFormat, $userID, $objectID);
	$statement->execute();
	$statement->store_result();

	// Add alternative titles to its table.
	$insert = $mysqli->prepare("DELETE FROM alt_titles WHERE object_id = ?");
	$insert->bind_param("s", $objectID);
	$insert->execute();

	foreach ($data["alternative_title"] as $altTitle) {
		if (trim($altTitle === "")) { continue; }

		$insert = $mysqli->prepare("INSERT INTO alt_titles (object_id, alt_title) VALUES (?, ?)");
		$insert->bind_param("is", $objectID, $altTitle);
		$insert->execute();
	}

	// Add genres to its table.
	$genres = array();
	// TODO: Determine if $data["genre"] can just be used as an array instead of pushing all its contents into a new array.
	foreach ($data["genre"] as $genre) {
		if (trim($genre) === "") { continue; }
		array_push($genres, $genre);
	}

	if (count($genres) !== 0) {
		$insert = $mysqli->prepare("DELETE FROM genres WHERE object_id = ?");
		$insert->bind_param("s", $objectID);
		$insert->execute();
	}

	foreach ($genres as $genre) {
		if (trim($genre) === "") { continue; }

		$insert = $mysqli->prepare("INSERT INTO genres (object_id, genre) VALUES (?, ?)");
		$insert->bind_param("is", $objectID, $genre);
		$insert->execute();
	}

	// Add date to its table.
	$insert = $mysqli->prepare("DELETE FROM dates WHERE object_id = ?");
	$insert->bind_param("s", $objectID);
	$insert->execute();

	$dateType    = "text";
	$humanDate   = $data["human_date"];
	$machineDate = $data["machine_date"];

	$insert = $mysqli->prepare("INSERT INTO dates (object_id, type, machine_date, human_date) VALUES (?, ?, ?, ?)");
	$insert->bind_param("isss", $objectID, $dateType, $machineDate, $humanDate);
	$insert->execute();

	$insert = $mysqli->prepare("DELETE FROM parts WHERE object_id = ?");
	$insert->bind_param("s", $objectID);
	$insert->execute();

	// Add isPartOf to its table.
	if (isset($data["is_part_of"])) {
		$partType = "isPartOf";
		foreach ($data["is_part_of"] as $id) {
			if (trim($id) === "") { continue; }

			$insert = $mysqli->prepare("INSERT INTO parts (object_id, type, part_id) VALUES (?, ?, ?)");
			$insert->bind_param("isi", $objectID, $partType, $id);
			$insert->execute();
		}
	}

	// Add hasPart to its table.
	if (isset($data["has_part"])) {
		$partType = "hasPart";
		foreach ($data["has_part"] as $id) {
			if (trim($id) === "") { continue; }

			$insert = $mysqli->prepare("INSERT INTO parts (object_id, type, part_id) VALUES (?, ?, ?)");
			$insert->bind_param("isi", $objectID, $partType, $id);
			$insert->execute();
		}
	}

	// Add roles to its table
	$insert = $mysqli->prepare("DELETE FROM roles WHERE object_id = ?");
	$insert->bind_param("s", $objectID);
	$insert->execute();

	$i = 0;
	$roleValues = array();
	// TODO: Determine if $data["role_value"] can just be used as an array instead of pushing all its contents into a new array.
	if (isset($data["role_value"], $data["role"])) {
		foreach ($data["role_value"] as $value) {
			array_push($roleValues, $value);
		}

		foreach ($data["role"] as $role) {
			$value = trim($roleValues[$i++]);
			if ($value === "") { continue; }

			$insert = $mysqli->prepare("INSERT INTO roles (object_id, role, value) VALUES (?, ?, ?)");
			$insert->bind_param("iss", $objectID, $role, $value);
			$insert->execute();
		}
	}
} // function saveObjectToDB($data, $objectID)
