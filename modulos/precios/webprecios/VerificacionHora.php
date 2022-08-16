<?php 
include '../webprecios/metodosweb.php';

$datetime =isset($_POST["hora"]) ? $_POST["hora"] : "";
$estaciones = isset($_POST["estaciones"]) ? $_POST["estaciones"]:"";
$date = date_create($datetime);
$fechacompleta = date_format($date, 'd-m-Y H:i:s');
$x =explode(" ", $fechacompleta);
$fecha = $x[0];
$hora = $x[1];


// print_r($estaciones);

$objeto = new metodosweb();
$Existentes =array();
$cont=0;
$resulFecha = str_replace("-", ".", $fecha);
$resulHora =str_replace(":", ":", $hora);

for ($i=0; $i <count($estaciones) ; $i++) { 
	
	$respuesta = $objeto->VerificacionHora($resulHora,$resulFecha,$estaciones[$i]);
	if($respuesta == "Existente")
	{
		// $Existentes[] = $respuesta;
		array_push($Existentes, $estaciones[$i]);
		$cont++;
	}
	// else{
	// 	$Existentes[$estaciones[$i]] = $respuesta;
	// }
}



$arrayResul =array("contador" =>$cont, "resultadosEstaciones" =>$Existentes);
print_r(json_encode($arrayResul));


 ?>