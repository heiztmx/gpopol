<?php 

session_start();
include  '../metCompras/metCompras.php';

$afectacion=isset($_POST["afectacion"]) ? $_POST["afectacion"] :"todas_afectaciones";
$fecha=isset($_POST["fecha"]) ? $_POST["fecha"] :"201912";
$opcion=isset($_POST["opcion"]) ? $_POST["opcion"] :"busqueda";
$filtro =isset($_POST["filtro"]) ? $_POST["filtro"]: "-54-AP-1";





$solicitadas =isset($_POST["solicitadas"]) ? $_POST["solicitadas"]: "";
$aprobadas =isset($_POST["aprobadas"]) ? $_POST["aprobadas"]: "";
$importes =isset($_POST["importes"]) ? $_POST["importes"]: "";
$filtro3 = isset($_POST["filtro3"]) ? $_POST["filtro3"] :"";
$solicito = isset($_POST["solicito"]) ? $_POST["solicito"] :"";
$cod_producto =isset($_POST["cod_producto"]) ? $_POST["cod_producto"] :"";
$indices =isset($_POST["indices"]) ? $_POST["indices"] :"";
$motivo_rechazo = isset($_POST["motivo_rechazo"]) ? $_POST["motivo_rechazo"] :"motivo de rechazo";
$producto =isset($_POST["producto"]) ? $_POST["producto"] :"xxxxxxx";
$autorizo = isset($_SESSION["user"]) ? $_SESSION["user"] :"xxxxxxx";
$proveedor =isset($_POST["proveedor"]) ? $_POST["proveedor"] :"xxxxxxx";
$id_proveedor =isset($_POST["id_proveedor"]) ? $_POST["id_proveedor"] :"xxxxxxx";

$datos_cotizacion  = isset($_POST["datos"]) ? $_POST["datos"] : "";

$objeto = new Compras();
// print_r($opcion);

switch ($opcion) {
	case 'busqueda':
		# code...
	$resultado = $objeto->filtras_estados($afectacion,$fecha);
	$add_local = "";
	echo $resultado;

	break;





	case 'busquedaDetallada':
			# code...
	$detalle =explode("-", $filtro);
	
	
	$datos= $objeto->busquedaDetallada($detalle[1],$detalle[2],$detalle[3]);
	echo $datos;
	


	break;
	case 'updateContas':

	$estatus ="PreAutorizado";
	$total=0;
	$datos = explode("-", $filtro3);
	$sucursal =$datos[1];
	$serie = $datos[2];
	$folio =$datos[3];
	for ($i=0; $i <count($importes) ; $i++) { 
				# code...
		$total+=floatval($importes[$i]);
	}
	$resultado= $objeto->guardarCompras($sucursal,$serie,$folio,$solicito,$autorizo,$estatus,$total,$aprobadas,$cod_producto,$indices,$fecha);
	echo $resultado;
	break;
	





	case 'busqueda_x_columna':
	$resultado = $objeto->filtras_estados($afectacion,$fecha);
	print_r($resultado );
	break;

	case 'cancelar_requisicion':
	$total=0;
	$datos = explode("-", $filtro3);
	$sucursal =$datos[1];
	$serie = $datos[2];
	$folio =$datos[3];
	for ($i=0; $i <count($importes) ; $i++) { 
				# code...
		$total+=floatval($importes[$i]);
	}
	$estatus="Rechazada";
	$cancelado = $objeto->cancelar_requisicion($sucursal,$serie,$folio,$solicito,$autorizo,$estatus,$total,$aprobadas,$cod_producto,$indices,$fecha,$motivo_rechazo);
	echo $cancelado;
	break;
	case 'buscarProducto':
	$productos = $objeto->buscador_producto($producto);

	print_r($productos);
		# code...
	break;
	case 'permisos_usuarios':
	// $permisos =$objeto->permisos_igas();
	// print_r($permisos);

	break;

	case 'buscarProveedor':
		$proveedores = $objeto->buscar_proveedor($proveedor);
		print_r($proveedores);
		break;
	case 'busqueda_detallada_proveedor':
		$detallado_prov = $objeto->busqueda_detallada_proveedor($id_proveedor);
		print($detallado_prov);
		break;

	case 'url_documento':
		$url = $objeto->url_documento($filtro);
		echo $url;
		break;

	case 'permisos_crear_documentos':
		echo $permisos_crear_doc = $objeto->permisos_crear_documentos($_SESSION["id"]);
		break;
	case 'busquedaDetalladaCotizacion':
		$detalle =explode("-", $filtro);
		$sucursal = $detalle[1];
		$serie  = $detalle[2];
		$folio  = $detalle[3];
		echo $productos_cotizaciones  = $objeto->detallado_cotizacion($sucursal,$serie,$folio);
		break;
	case 'validar_cotizacion':
			$requisicion =  $filtro3;
		 $v = $objeto->validar_cotizacion($datos_cotizacion,$requisicion);
		 print_r($v);
		break;
	case 'guardar_producto_proveedor':
		$resp = $objeto->guardar_producto_proveedor($_POST);
		print_r($resp);
		break;
	default:
		# code...
	break;
}


?>