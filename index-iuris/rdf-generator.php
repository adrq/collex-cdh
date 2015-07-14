<?php




function generateRDF($submission){
	//mb_internal_encoding("UTF-8");
	$rdfNamespaces = [
		'archive' => 'collex:archive',
		'title' => 'dc:title',
		'type' => 'dc:type', // need to create new namespace
		'genre' => 'collex:genre', //need to create new namespace
		'origin' => 'origin', //need to create new namespace
		'provenance' => 'provenance', //need to create new namespace
		'place-of-composition' => 'placeOfComposition', //need to create new namespace
		'shelfmark' => 'shelfmark', //need to create new namespace
		'alternative-title' => 'dcterms:alternative',
		'source' => 'collex:source',
		'text-divisions' => 'textDivisions', //need to create new namespace
		'notes' => 'notes', //need to create new namepace
		'file-format' => 'fileFormat' //need to create new namespace
				];
	echo '<br><br>';
	
	$rdfHeader = file_get_contents('rdf-header.rdf');
	
	$rdf = $rdfHeader."\n<".$submission['custom-namespace']." rdf:about=\"".$submission['rdf:about']."\">\n";
	$rdf = $rdf."<rdfs:seeAlso rdf:resource=\"".$submission['seeAlso']."\"/>\n";
	
	//echo htmlspecialchars($rdf);
	
	$rdfContent = "";
	
	foreach ($rdfNamespaces as $key => $value){
		//if (!array_key_exists($key, $submission));
		//$tmpKey = (string)$key;
		if ($submission[$key] != '') {
			$rdfContent = $rdfContent."<".$value.">".$submission[$key]."</".$value.">\n";
		}
	}
	$rdf = $rdf.$rdfContent;
	$rdf = $rdf."</".$submission['custom-namespace'].">\n</rdf:RDF>\n";
	//echo '<pre>'.htmlspecialchars($rdf).'</pre>';
	return $rdf;
}

?>