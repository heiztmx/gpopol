<?php

require_once '../../../NuSOAP/lib/nusoap.php';
$servicio = new soap_server();

$ns = "urn:miserviciowsdl";
$servicio->configureWSDL("MiPrimerServicioWeb",$ns);
$servicio->schemaTargetNamespace = $ns;

$servicio->register("MiFuncion", array('num1' => 'xsd:integer', 'num2' => 'xsd:integer'), array('return' => 'xsd:string'), $ns );

function MiFuncion($num1, $num2){

 $resultadoSuma = $num1 + $num2;
 $resultado = "El resultado de la suma de " . $num1 . "+" .$num2 . " es: " . $resultadoSuma;	
 return $resultado;
 
}
$server->service(file_get_contents("php://input"));


$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';

?>