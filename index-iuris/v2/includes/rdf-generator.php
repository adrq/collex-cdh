<?php
/**
 * @file rdf-generator.php
 * Small summary of the current page's existence should go here.
 */

/**
 * Generates an RDF.
 *
 * @param {Array} $submission: Brief explanation of this variable goes here.
 * @return {String}
 */
function generateRDF($submission) {
  $rdfNamespaces = array(
    "archive" => "collex:archive",
    "title" => "dc:title",
    "type" => "dc:type",
    "genre" => "collex:genre",
    "origin" => "origin",
    "provenance" => "placeOfComposition",
    "shelfmark" => "shelfmark",
    "alternative-title" => "dcterms:alternative",
    "source" => "collex:source",
    "text-divisions" => "textDivisions",
    "notes" => "notes",
    "file-format", "fileFormat"
  );

  print "<br><br>";

  $rdf = "";
  if (file_exists("rdf-header.rdf")) {
    $rdf .= file_get_contents("rdf-header.rdf") . "\n<" . $submission["custom-namespace"] . " rdf:about=\"" . $submission["rdf:about"] . "\">\n";
    $rdf .= "<rdfs:seeAlso rdf:resource=\"" . $submission["seeAlso"] . "\"/>\n";

    // print htmlspecialchars($rdf);
  }

  foreach ($rdfNamespaces as $key=>$value) {
    // if (!array_key_exists($key, $submission));
    // $tempKey = (string) $key;

    if ($submission[$key] !== "") {
      $rdf .= "<" . $value . ">" . $submission[$key] . "</" . $value . ">\n";
    }
  }

  $rdf .= "</" . $submission["custom-namespace"] . ">\n</rdf:RDF>\n";

  // print "<pre>" . htmlspecialchars($rdf) . "</pre>";

  return $rdf;
}
