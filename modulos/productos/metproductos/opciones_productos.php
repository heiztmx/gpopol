<?php 
include 'productos.php';
$obj = new productos();

$estacion =isset($_POST["estacion"]) ? $_POST["estacion"] : "3";
$opcion = isset($_POST["opcion"]) ? $_POST["opcion"] : "buscador_lineas_sublineas";
$nombre =isset($_POST["nombre"]) ? $_POST["nombre"] : "3";
$barras =isset($_POST["barras"]) ? $_POST["barras"] : "3";
$estado =isset($_POST["estado"]) ? $_POST["estado"] : "3";
$linea =isset($_POST["linea"]) ? $_POST["linea"] : "3";
$id_estacion = isset($_POST["id_estacion"]) ? $_POST["id_estacion"] :"";
$clave = isset($_POST["clave"]) ? $_POST["clave"] :"";
$tabla  =  isset($_POST["tabla"]) ? $_POST["tabla"] :"DINVLINE";
$input  =  isset($_POST["input"]) ? $_POST["input"] :"";
$codigo_barras = isset($_POST["codigo_barras"]) ? $_POST["codigo_barras"] : "";
switch ($opcion) {
	case 'productoxestacion':
	(int)$estacion;
	echo $obj->productosxestacion($estacion);
	break;
	case 'modificar':
	(int)$estacion;
	echo $obj->modificar_productos($estacion,$nombre,$barras,$estado,$linea,$id_estacion,$clave);
	break;

	case 'buscador_lineas':

	echo $obj->buscador_lineas($tabla,$nombre,$input);
	break;

	case 'buscador_sublineas':
	print_r($obj->buscar_sublineas($nombre));
	break;

	case 'DGENPRODSERVSAT':
	$tabla  = $opcion;
	echo $obj->buscador_sat($nombre,$tabla);
	break;
	
	case 'DGENUNISAT':
	$tabla  = $opcion;
	echo $obj->buscador_sat($nombre,$tabla);
	break;

	case 'codigo_barras':
	echo  $obj->buscar_codigo_barras($codigo_barras,$estacion);
		# code...
		break;
	case 'cambio_estatus':
		echo $obj->activar_producto($clave,$id_estacion,$estado);
	default:
		# code...
	break;
}

?>