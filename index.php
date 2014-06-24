<?php
// Agrega libreria
require_once 'Xpath.php';

// URL de donde obtener datos
$url = "http://ocw.mit.edu/courses/";

// nuevo objeto xpath
$xpath = new XPATH($url);

//enviamos la expresion xpath
$courseQuery = $xpath->query("//td/a/text()");

// Array para almacenar los resultados
$data = array();

// Iteracion de la lectura de cada dato y tabla
for($x=2; $x < $courseQuery->length; $x++){

	// almacenamos los datos, escapando saltos de linea y tabulaciones
	$data[$x] = trim(preg_replace('/\n\t+/', ' ', $courseQuery->item($x)->nodeValue));
}

// datos en formato JSON
echo json_encode($data);

?>