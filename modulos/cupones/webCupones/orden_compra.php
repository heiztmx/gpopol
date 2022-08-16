<?php 



include  '../metCupones/metCupones.php';
$obj = new Compras();
$estado = isset($_POST["estado"]) ? $_POST["estado"] : "Pagado";
$fecha = isset($_POST["fecha"]) ? $_POST["fecha"] : "10-Marzo-2019";
$filtro = isset($_POST["filtro"]) ? $_POST["filtro"] : "-1-1A-276";
$concepto = isset($_POST["concepto"]) ? $_POST["concepto"] : "zzzzz";
$motivo_rechazo = isset($_POST["motivo_rechazo"]) ? $_POST["motivo_rechazo"] : "zzzzz";


$objeto = new Compras();
switch ($estado) {
	case 'Pendiente de Surtir':

	$estado= "Pendiente de Surtir";	
	$datos = $obj->ordenes_compra($estado,$fecha);	
	echo $datos;
	break;








	case 'todas_ordenes':
	$estado= "";	
	$datos = $obj->all_ordenes_compras($fecha);	
	echo $datos;
	// $datos = $obj->requisicion_ordenescompra_folios($fecha,"RQ");
	// print_r($datos);
	break;



	case 'Pagar':

	$detalle =explode("-", $filtro);
	$pagadoc = $obj->pagarOC($detalle[1],$detalle[2],$detalle[3],$concepto);
	$respuesta = array("estado" => $pagadoc);
	echo json_encode($respuesta);
	break;



	case 'busquedaDetallada':
	
	$detalle =explode("-", $filtro);

	$datos= $objeto->busquedaDetalladaOC($detalle[1],$detalle[2],$detalle[3]);
	echo $datos;
	
	break;



	case 'Pagado':

	$datos = $obj->pagadas_ordenes_compras($fecha);	
	echo $datos;
	break;



	case 'cancelar_odc':

	$datos  = explode("-", $filtro);
	$suc = $datos[1];
	$serie  = $datos[2];
	$folio = $datos[3];
	echo  $datos  = $obj->rechazar_odc($suc,$serie,$folio,$motivo_rechazo,$fecha);
		# code...
		break;




	default:
	
	break;
}

?>