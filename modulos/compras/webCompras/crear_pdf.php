<?php 	

include '../../../conexionGas.php';
include '../../../ConexionADMON.php';
require_once( '../../../conexion.php');
include("../../../general/funciones.php");
include ("../../precios/web-services/classWS.php");


$gen  = new generales();
$ws = new classWS();
$datos  = isset($_POST["datos"]) ? $_POST["datos"] : "-2-2P-1";
$tipo  = isset($_POST["tipo"]) ? $_POST["tipo"] : "requisicion";
$d = explode("-", $datos);

$sucursal = (int)$d[1];
$serie  = $d[2];
$folio  = (int) $d[3];

$filtro  = $sucursal."-".$serie."-".$folio;
$objws = new classWS();
$conexionVAD = new conexionADMON();
$conec = new conexion();

$conexionLocal  = $conec->conectar();
$conexionV  = $conexionVAD->conectarADMON();
$conexionAd = $conexionVAD->conectarADM();

$variables  = $conec->variables_compras();

$sql  = "SELECT * FROM SUCURSALES_IGAS WHERE CLAVE_SUC_IGAS  = '$sucursal'";
$datosuc  = ibase_query($conexionLocal,$sql);
$suc = ibase_fetch_assoc($datosuc);
$razon_social_suc = $gen->reparar_utf8($suc["RAZON_SOCIAL"]);
$direccion_suc = $gen->reparar_utf8($suc["DIRECCION"]);
$rfc_suc = $suc["RFC"];
$telefono_suc  = $suc["TELEFONOS"];
$poblacion_suc  = $gen->reparar_utf8($suc["POBLACION"]);
$correo_suc  = $suc["CORREO"];

$proveedor  = "";
$detallado =array();
$importe_total = 0;


$unidad_campo  = "";
$precio_campo  = "";
if ($tipo  == "requisicion") {
	$sql  ="SELECT * FROM DINVREQUD WHERE SUCURSAL  = '$sucursal' AND SERIE = '$serie' AND FOLIO ='$folio'";
	$unidad_campo = "UNIDAD_PROD";
	$precio_campo = "PRECIO_ESTIMADO";
}elseif ($tipo == "orden_compra") {
	$sql  ="SELECT * FROM DCPRDOCP WHERE SUCURSAL  = '$sucursal' AND SERIE = '$serie' AND FOLIO ='$folio'";
	// print_r($sql);
	$unidad_campo = "UNIDAD";
	$precio_campo  = "PRECIO";
}else{
	echo "nada";
	exit;
}

$exe_detallado = ibase_query($conexionV,$sql);
while ($det = ibase_fetch_assoc($exe_detallado)) {
	$fila  = array();
	$fila =["DESCRIP_PRODUCTO" =>$gen->reparar_utf8($det["DESCRIP_PRODUCTO"])
	,"CANTIDAD" =>$det["CANTIDAD"]
	,"UNIDAD_PROD"=>$det[$unidad_campo]
	,"PRECIO_ESTIMADO"=>$det[$precio_campo]];

	array_push($detallado, $fila);
	$proveedor = (int) $det["PROVEEDOR"];
	
	$importe_total += $det["CANTIDAD"] * $det[$precio_campo];
}
$fecha_campo = "";
$estatus_campo = "";
if ($tipo  == "requisicion") {
	# code...
	$sql  ="SELECT * FROM DINVREQU WHERE SUCURSAL  = '$sucursal' AND SERIE = '$serie' AND FOLIO ='$folio'";
	$fecha_campo  = "FECHA_CAPTURA";
	$estatus_campo = "ESTADO";
}elseif ($tipo == "orden_compra"){
	$sql  ="SELECT * FROM DCPROCPR WHERE SUCURSAL  = '$sucursal' AND SERIE = '$serie' AND FOLIO ='$folio'";
	$fecha_campo  = "FECHA_GENERO";
	$estatus_campo="ESTATUS";
}else{
	echo "nada";
	exit;
}


$exe_ge  = ibase_query($conexionV,$sql);
$dat_g = ibase_fetch_assoc($exe_ge);
$elaboro  = $gen->reparar_utf8($dat_g["ELABORO"]);
$concepto = $gen->reparar_utf8($dat_g["CONCEPTO1"]);
$estatus_general  = $gen->reparar_utf8($dat_g[$estatus_campo]);
$fecha  = $dat_g[$fecha_campo];
$telefono_sol = "(999) 943-02-75";
$afectacion  = $dat_g["TIPO_AFECTACION"];
// Rechazada req
//C odc


$nombre_pro = "N/A";
$direccion_pro="N/A";
$poblacion_pro ="N/A";
$telefono_pro ="";
$rfc_pro ="N/A";



// echo $pos = strpos($mystring, $findme);

$titulo ="Requisición";


$sql  ="SELECT COUNT(*) as EXISTE_OP FROM DCPROCPR WHERE SUCURSAL  = '$sucursal' AND SERIE = '$serie' AND FOLIO ='$folio'";
$exe = ibase_query($conexionV,$sql);
$exi = ibase_fetch_assoc($exe);

if (strpos($serie , "P") != "" || $exi["EXISTE_OP"] > 0) {
	$sql  = "SELECT * FROM DGENPROV  WHERE NOPROV = '$proveedor'";
	
	$exe_pro = ibase_query($conexionAd,$sql);
	
	$prov = ibase_fetch_assoc($exe_pro);
	$nombre_pro  = $gen->reparar_utf8($prov["NOMBRE"]);
	$direccion_pro =$gen->reparar_utf8( $prov["DIRECCION"]);
	$poblacion_pro  = $gen->reparar_utf8($prov["POBLACION"]);
	$rfc_pro = $prov["RFC"];
	$telefono_pro = $prov["TELEFONO"];
	$titulo  = "Requisición O.P.";
}

$contador_hash= 0;
$hash_pdf ="";
$sql  ="SELECT * FROM ORDENES_PAGO  WHERE SUCURSAL  = '$sucursal' AND SERIE  = '$serie' AND FOLIO = '$folio'";
$execute_pdf = ibase_query($conexionLocal,$sql);
while ($r=ibase_fetch_assoc($execute_pdf)) {
	$contador_hash++;
	$hash_pdf = $r["HASH_PDF"];

}
if ($contador_hash == 0 || $hash_pdf == "" || $hash_pdf == null) {
	$hash_pdf = "sin_hash_pdf";
}

$total_letras = $gen->numtoletras($importe_total);
$total_letras =$gen->reparar_utf8($total_letras);
$resultado  = array ("razon_social" =>$razon_social_suc,
	"direccion_suc" => $direccion_suc
	,"rfc_suc" => $rfc_suc
	,"telefono_suc" =>$telefono_suc
	,"poblacion_suc" =>$poblacion_suc
	,"correo_suc" =>$correo_suc
	,"todo_detallado" =>$detallado
	,"elaboro" =>$elaboro
	,"fecha" =>$fecha
	,"telefono_sol" =>$telefono_sol
	,"afectacion" =>$afectacion
	,"nombre_pro" =>$nombre_pro
	,"direccion_pro" =>$direccion_pro
	,"poblacion_pro" =>$poblacion_pro
	,"rfc_pro"=>$rfc_pro
	,"telefono_pro"=>$telefono_pro
	,"filtro"=>$filtro
	,"id_pro" =>$proveedor
	,"concepto" =>$concepto
	,"hash_pdf" =>$hash_pdf
	,"total_letras" =>$gen->reparar_utf8($total_letras)
	,"titulo"=>$gen->reparar_utf8($titulo)
	,"estatus_general"=>$estatus_general
);
// print_r($resultado);
$json  = json_encode($resultado);
// print_r($json);

$servidor  = $ws->ConexionMetodos($variables["ip_WSgpopol"]);

// print_r($servidor);
$metodo_ws  = "";

if ($tipo == "orden_compra") {
	$metodo_ws = "ExcelToPDF_OC";

}elseif ($tipo  == "requisicion") {
	$metodo_ws = "ExcelToPDF_REQ";
}else{
	echo "nada";
	exit;
}
try {
	$paraWS=array();
	$paraWS['datos']=$json;

	// if (is_soap_fault($servidor)) {
	// 	$array = array("proceso" => "error" ,"url" =>"<p>Sin conexion con el webservices. Validar documentación</p> <p>Error 1.1 PDF</p>");
	// 	print_r(json_encode($array));
	// 	exit;
	// }
	$respuesta = $servidor->call($metodo_ws,$paraWS);


	if (!is_array($respuesta)) {
		$array = array("proceso" => "error" ,"url" =>"<p>Respuesta inesperada por parte del webservices. Reinicie el servicio IIS</p> <p style='font-weight:bold'>Error 1.1 PDF</p>");
		print_r(json_encode($array));
		exit;
	}

	$respuesta_ws = $metodo_ws."Result";
	if (!array_key_exists($respuesta_ws,$respuesta)) {
		$array = array("proceso" => "error" ,"url" =>"<p>Sin respuesta por parte del webservices. Validar documentación</p> <p style='font-weight:bold'>Error 1.2 PDF</p>");
		print_r(json_encode($array));
		exit;
	}

	
	
	$r =  json_decode($respuesta[$respuesta_ws],true);
	if (!is_array($r)) {
		$array = array("proceso" => "error" ,"url" =>"<p>Respuesta inesperada por parte del webservices. Validar documentación</p> <p style='font-weight:bold'>Error 1.3 PDF</p>");
		print_r(json_encode($array));
		exit;
	}
		# code...
	
	if (array_key_exists("proceso",$r)) {
		


		//$url  = str_replace("c:/xampp/htdocs", "http://".$variables["ip_xampp"], $r["resultado"]);
		$url  = str_replace("C:/inetpub/wwwroot", "http://".$variables["ip_xampp"], $r["resultado"]);

		$array = array("proceso" => $r["proceso"], "url" =>$url);

		print_r(json_encode($array));
	}else{
		$array = array("proceso" => "error" ,"url" =>"El PDF no pudo crearse correctamente. Validar documentación <p style='font-weight:bold'>Error 1.4 PDF</p>");

		print_r(json_encode($array));
	}


	
} catch (Exception $e) {
	echo "nada";
}
?>
