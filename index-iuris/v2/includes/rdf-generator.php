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

global $rolesRDFArray;

$rolesRDFArray = array(
		"Author" => "AUT",
		"Editor" => "EDT",
		"Publisher" => "PBL",
		"Translator" => "TRL",
		"Creator" => "CRE",
		"Etcher" => "ETR",
		"Engraver" => "EGR",
		"Owner" => "OWN",
		"Visual Artist" => "ART",
		"Architect" => "ARC",
		"Binder" => "BND",
		"Book designer" => "BKD",
		"Book producer" => "BKP",
		"Calligrapher" => "CLL",
		"Cartographer" => "CTG",
		"Collector" => "COL",
		"Colorist" => "CLR",
		"Commentator for written text" => "CWT",
		"Compiler" => "COM",
		"Compositor" => "CMT",
		"Dubious author" => "DUB",
		"Facsimilist" => "FAC",
		"Illuminator" => "ILU",
		"Illustrator" => "ILL",
		"Lithographer" => "LTG",
		"Printer" => "PRT",
		"Printer of plates" => "POP",
		"Printmaker" => "PRM",
		"Repository" => "RPS",
		"Rubricator" => "RBR",
		"Scribe" => "SCR",
		"Sculptor" => "SCL",
		"Type designer" => "TYD",
		"Typographer" => "TYG",
		"Wood engraver" => "WDE",
		"Wood cutter" => "WDC",
);




function generateRDF($objectID) {
  global $mysqli;
  $RDFRDF = array(
  		"AUT" => "Author",
  		"EDT" => "Editor",
  		"PBL" => "Publisher",
  		"TRL" => "Translator",
  		"CRE" => "Creator",
  		"ETR" => "Etcher",
  		"EGR" => "Engraver",
  		"OWN" => "Owner",
  		"ART" => "Artist",
  		"ARC" => "Architect",
  		"BND" => "Binder",
  		"BKD" => "Book designer",
  		"BKP" => "Book producer",
  		"CLL" => "Calligrapher",
  		"CTG" => "Cartographer",
  		"COL" => "Collector",
  		"CLR" => "Colorist",
  		"CWT" => "Commentator for written text",
  		"COM" => "Compiler",
  		"CMT" => "Compositor",
  		"CRE" => "Creator",
  		"DUB" => "Dubious author",
  		"FAC" => "Facsimilist",
  		"ILU" => "Illuminator",
  		"ILL" => "Illustrator",
  		"LTG" => "Lithographer",
  		"PRT" => "Printer",
  		"POP" => "Printer of plates",
  		"PRM" => "Printmaker",
  		"RPS" => "Repository",
  		"RBR" => "Rubricator",
  		"SCR" => "Scribe",
  		"SCL" => "Sculptor",
  		"TYD" => "Type designer",
  		"TYG" => "Typographer",
  		"ART" => "Visual Artist",
  		"WDE" => "Wood engraver",
  		"WDC" => "Wood cutter"
  );
	
  global $rolesRDFArray;
  /*$rdfNamespaces = array(
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
  );*/

  $statement = $mysqli->prepare("SELECT custom_namespace, rdf_about, archive, title, type, url, origin, provenance, place_of_composition, shelfmark, freeculture, full_text_url, full_text_plain, is_full_text, image_url, source, metadata_xml_url, metadata_html_url, text_divisions, language, ocr, thumbnail_url, notes, file_format, date_created, date_updated, user_id FROM objects WHERE id = ? LIMIT 1");
  $statement->bind_param("s", $objectID);
  $statement->execute();
  $statement->store_result();
  
  $statement->bind_result($custom_namespace, $rdf_about, $archive, $title, $type, $url, $origin, $provenance, $place_of_composition, $shelfmark, $freeculture, $full_text_url, $full_text_plain, $is_full_text, $image_url, $source, $metadata_xml_url, $metadata_html_url, $text_divisions, $language, $ocr, $thumbnail_url, $notes, $file_format, $date_created, $date_updated, $user_id);
  $statement->fetch();

  $rdf = "";
  if (!file_exists("includes/rdf-header.rdf")) {
  	print "Error. Unable to open RDF header.";
  	return;  			
  }
  
  $rdf .= file_get_contents("includes/rdf-header.rdf") . "\n<". $custom_namespace . " rdf:about=\"" . $rdf_about. "\">\n";
  //TODO: add namespace identifier and uri once namespaces have been defined
  $rdf .= "<rdfs:seeAlso rdf:resource=\"" . $url. "\"/>\n<collex:federation>INDEXIURIS</collex:federation>\n";

  
  if ($archive!=""){
  	$rdf .= "<collex:archive>".$archive."</collex:archive>\n";
  }

  if ($title!=""){
  	$rdf .= "<dc:title>".$title."</dc:title>\n";
  }

  if ($type!=""){
  	$rdf .= "<ii:type>".$type."</ii:type>\n";
  }

  if ($origin!=""){
  	$rdf .= "<ii:origin>".$origin."</ii:origin>\n";
  }

  if ($provenance!=""){
  	$rdf .= "<ii:provenance>".$provenance."</ii:provenance>\n";
  }

  //place of composition TODO: check namespace name with Colin and Abigail
  if($place_of_composition!=""){
  	$rdf .= "<ii:composition>".$place_of_composition."</ii:composition>\n";
  }
  
  if ($shelfmark!=""){
  	$rdf .= "<ii:shelfmark>".$shelfmark."</ii:shelfmark>\n";
  }
  
  if ($freeculture!=""){
  	$rdf .= "<collex:freeculture>".$freeculture."</collex:freeculture>\n";
  }  
  
  //fulltext
  if ($is_full_text == "true"){
  	if ($full_text_url != ""){
  		$rdf .= "<collex:text rdf:resource=\">".$full_text_url."\"/>\n";
  	}
  	else {
  		$rdf .= "<collex:text>".$full_text_plain."</collex:text>\n";
  	}
  }

  if ($image_url!=""){
  	$rdf .= "<collex:image rdf:resource=\"".$image_url."\"/>\n";
  }
  if($source!=""){
  	$rdf .= "<dc:source>".$source."</dc:title>\n";
  }

  if($metadata_xml_url!=""){
  	$rdf .= "<collex:source_xml>".$metadata_xml_url."</collex:source_xml>\n";
  }

  if($metadata_html_url!=""){
  	$rdf .= "<collex:source_html>".$metadata_html_url."</collex:source_html>\n";
  }

  if($text_divisions!=""){
  	$rdf .= "<ii:divisions>".$text_divisions."</ii:divisions>\n";
  }

  if($language!=""){
  	$rdf .= "<dc:language>".$language."</dc:language>\n";
  }

  if($ocr!=""){
  	$rdf .= "<collex:ocr>".$ocr."</collex:ocr>\n";
  }

  if($thumbnail_url!=""){
  	$rdf .= "<<collex:thumbnail rdf:resource=\"".$thumbnail_url."\"/>\n";
  }

  if($notes!=""){
  	$rdf .= "<ii:notes>".$notes."</ii:notes>\n";
  }

  if($file_format!=""){
  	$rdf .= "<ii:format>".$file_format."</ii:format>\n";
  }
  
  //role
  $temp = $mysqli->prepare("SELECT role, value FROM roles WHERE object_id = ?");
  $temp->bind_param("s", $objectID);
  $temp->execute();
  $temp->store_result();
  $temp->bind_result($role, $value);
  
  while ($temp->fetch()){
  	$rdf .= "<role:".$rolesRDFArray[$role].">".$value."</role:".$rolesRDFArray[$role].">\n";
  }

  
  //genre
  $temp = $mysqli->prepare("SELECT genre FROM genres WHERE object_id = ?");
  $temp->bind_param("s", $objectID);
  $temp->execute();
  $temp->store_result();
  $temp->bind_result($genre);
  
  while ($temp->fetch()){
  	$rdf .= "<ii:genre>".$genre."</ii:genre>\n";
  }
  
  //alternative titles
  $temp = $mysqli->prepare("SELECT alt_title FROM alt_titles WHERE object_id = ?");
  $temp->bind_param("s", $objectID);
  $temp->execute();
  $temp->store_result();
  $temp->bind_result($altTitle);
  
  while ($temp->fetch()){
  	$rdf .= "<dcterms:alternative>".$altTitle."</dcterms:alternative>\n";
  }
  
  //parts
  $temp = $mysqli->prepare("SELECT type, part_id FROM parts WHERE object_id = ?");
  $temp->bind_param("s", $objectID);
  $temp->execute();
  $temp->store_result();
  $temp->bind_result($type, $partID);
  
  while ($temp->fetch()){
  	$part = $mysqli->prepare("SELECT rdf_about FROM objects WHERE id = ? LIMIT 1");
  	$part->bind_param("s", $partID);
  	$part->execute();
  	$part->store_result();
  	$part->bind_result($part_rdf_about);
  	$part->fetch();
  	
  	$rdf .= "<dcterms:$type rdf:resource=\"".$part_rdf_about."\"/>\n";
  }
  
  //date
  $temp = $mysqli->prepare("SELECT type, machine_date, human_date FROM dates WHERE object_id = ?");
  $temp->bind_param("s", $objectID);
  $temp->execute();
  $temp->store_result();
  $temp->bind_result($type, $machine, $human);
  
  while ($temp->fetch()){
  	$rdf .= "<dc:date>\n<collex:date>\n<rdfs:label>".$human."</rdfs:label>\n<rdf:value>".$machine."<rdf:value>\n</collex:date>\n</dc:date>\n";
  }
  

  $rdf .= "</" . $custom_namespace . ">\n</rdf:RDF>\n";

  return $rdf;
}
