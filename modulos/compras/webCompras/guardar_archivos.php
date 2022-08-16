<?php 
include '../../../conexion.php';
include '../../precios/web-services/classWS.php';
$obj = new conexion();

$con  = $obj->conectar();
$conexion  = $con;
if ($_FILES["archivo"]["name"]  != "") {

$carpeta = $_POST["carpeta"];
$test = explode(".", $_FILES["archivo"]["name"]);
$archivo  = str_replace(" ", "_", $_FILES["archivo"]["name"]);
$archivo  = str_replace("  ", "_", $_FILES["archivo"]["name"]);

$extension  = end($test);
// $poligas = "poligas documentos";
$hasheado = hash("ripemd160", $carpeta);

if (!file_exists("../../../OrdenesPago")) {
	mkdir("../../../OrdenesPago/",0777,true);
}
	if (!file_exists("../../../OrdenesPago/".$carpeta)) {
		mkdir("../../../OrdenesPago/".$carpeta,0777,true);
		mkdir("../../../OrdenesPago/".$carpeta."/".$hasheado,0777,true);
	}
$ubicacion  = "../../../OrdenesPago/".$carpeta."/".$hasheado."/".$archivo;
move_uploaded_file($_FILES["archivo"]["tmp_name"], $ubicacion);

$contsql  = "SELECT COUNT(*) as REGISTROS FROM ORDENES_PAGO";
$exe = ibase_query($conexion, $contsql);
$rows  = ibase_fetch_assoc($exe);
$id = $rows["REGISTROS"] + 1 ;
$datos = explode("-", $carpeta);
$sucursal = (int)$datos[0];
$serie  = $datos[1];
$folio  = $datos[2];
$variables_dominio = $obj->variables_compras();
$dominio = "http://".$variables_dominio["ip_xampp"]."/";
// $dominio = "http://gpopol.dyndns.biz:8888/";
$url = $dominio."gpopol/OrdenesPago/".$carpeta."/".$hasheado."/".rawurlencode($archivo);
// $u = urlencode($url);
// echo $url;

$sql = "INSERT INTO ORDENES_PAGO (ID, SUCURSAL,SERIE,FOLIO,URL,HASH_ARCHIVO) VALUES ('$id' , '$sucursal', '$serie' ,'$folio' ,'$url' ,'$hasheado')";
ibase_query($conexion,$sql);
// echo $u;
}

?>