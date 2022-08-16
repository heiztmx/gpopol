<?php 

include '../metOperadores/metodosOperadores.php';

$objeto = new Operadores();
$estas=$objeto->tablaEstaciones();
	$estaciones ="";
	while($r=ibase_fetch_assoc($estas))
	{
		$estaciones.=$r["ESTACION"]."||";
	}
	echo $estaciones;
 ?>