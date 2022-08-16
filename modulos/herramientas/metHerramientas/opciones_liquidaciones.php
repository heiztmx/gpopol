<?php 

 include  '../../cartera/metGASOLINERA/metodosGASOLINERA.php';

$fecha =isset($_POST["fecha"]) ?   $_POST["fecha"] : "2019-08-13";
$estacion =isset($_POST["estacion"]) ?   $_POST["estacion"] : 1;
$isla =isset($_POST["isla"]) ?   $_POST["isla"] : 1;
$turno =isset($_POST["turno"]) ?   $_POST["turno"] : 3;
$opcion =isset($_POST["opcion"]) ?   $_POST["opcion"] : "conexiones";
$folio =isset($_POST["folio"]) ?   $_POST["folio"] : 28488;
$ip = isset($_POST["ip"]) ? $_POST["ip"] : "172.16.4.75";
$activacion = isset($_POST["activacion"]) ? $_POST["activacion"] : "";
 session_start();
 $objeto = new GASOLINERA();
 // $general = new generales();

switch ($opcion) {
	case 'busqueda_detallada':
		$liquidaciones = $objeto->busqueda_liquidaciones_detallada($fecha,$estacion,$isla,$turno);
		echo $liquidaciones;

		break;
	case 'eliminar':
		
		$borrar = $objeto->eliminar_liquidaciones($folio,$estacion,$turno,$fecha,$isla);
		echo $borrar;
		break;
	case 'conexiones':
		$elimi_conexion = $objeto->eliminacion_conexion($ip);
		print_r($elimi_conexion);
		break;
	// case 'activacion_liquidaciones':
	// 	$activacion_liquidaciones = $general->activar_liquidaciones($activacion);
	// 	$array =array("respuesta" => $activar_liquidaciones);
	// 	echo json_encode($array);

	// 	break;
	default:
		# code...
		break;
}
 ?>