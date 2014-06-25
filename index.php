<?php
// Agrega libreria
require_once 'Xpath.php';

// URL de donde obtener datos
$url = "http://ocw.mit.edu/courses/";
$base = "http://ocw.mit.edu";

// nuevo objeto xpath
$xpath = new XPATH($url);

//enviamos la expresion xpath
$courseQuery = $xpath->query("//td/a/text()");

// Array para almacenar los resultados
$dataCourse = array();
$dataLinks = array();
$merge = array();

// Iteracion de la lectura de cada dato y tabla
for($x=2; $x < $courseQuery->length; $x++){

	// almacenamos los datos, escapando saltos de linea y tabulaciones
	$data[$x] = trim(preg_replace('/\n\t+/', ' ', $courseQuery->item($x)->nodeValue));
}

// datos en formato JSON de cursos
json_encode($data);

//enviamos la expresion
$linkQuery = $xpath->query("//td/a/@href");

for($y=3; $y < $courseQuery->length; $y++){

	// almacenamos los datos, escapando saltos de linea y tabulaciones
	$dataLinks[$y] = $base.$linkQuery->item($y)->nodeValue;
}

$results = array_unique($dataLinks);
// links de cursos
//echo json_encode($results, JSON_UNESCAPED_SLASHES);
$merge = array_merge($data, $results);

echo json_encode($merge, JSON_UNESCAPED_SLASHES);

?>