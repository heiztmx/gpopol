<?php 

session_start();



require_once '../../../NuSOAP/lib/nusoap.php';
include '../webprecios/metodosweb.php';

$metodos = new metodosweb();



try {
    $client = new nusoap_client("http://172.16.0.103/WebSite1/BD.asmx?WSDL",true);
} catch (Exception $e) {
  print_r("Error al conectarse al Web Services comunicarse con el administrador del sistema".$client);
}


 //url del servicio
$com1=isset($_POST['magna']) ? $_POST['magna'] : "";
$com2=isset($_POST['premium'] )? $_POST['premium'] :"";
$com3=isset($_POST['diesel']) ? $_POST['diesel'] : "";
$datetime=isset($_POST['date3']) ? $_POST['date3'] : "";

$todas_esta=isset($_POST['todos']) ? $_POST['todos']: "";
$poli = isset($_POST['poli']) ? $_POST['poli']: "";
$uman =isset($_POST['uman']) ? $_POST['uman']: "";
$peri =isset($_POST['peri']) ? $_POST['peri']: "";
$side =isset($_POST['side']) ? $_POST['side']: "";

$date = date_create($datetime);
$fechacompleta = date_format($date, 'Y-m-d H:i:s');
$fechacompleta=(string)$fechacompleta;
$x =explode(" ", $fechacompleta);
$fecha = $x[0];
$fechaFAC = (string)$x[0];                //'Heizt'
$hora = $x[1];

$com1 = floatval($com1);
$com2 = floatval($com2);
$com3 = floatval($com3);
$usuario=isset($_SESSION['user']) ? $_SESSION['user'] : "";
$EstRecibidas= array();




$paraWS=array();
$paraPOLI['estacion']='172.16.0.103';
$paraPOLI['com1']=$com1;
$paraPOLI['com2']=$com2;
$paraPOLI['com3']=$com3;
$paraPOLI['fecha']=$fechacompleta;
$paraPOLI['usuario']=$usuario;

$paraFACTURA=array();                           //Heizt
$paraFACTURA['estacion']='172.16.0.103';
$paraFACTURA['com1']=$com1;
$paraFACTURA['com2']=$com2;
$paraFACTURA['com3']=$com3;
$paraFACTURA['fecha']=$fechaFAC;
$paraFACTURA['usuario']=$usuario;

$estaciones=$metodos->tablaEstaciones();



if ($po1['SetPreciosFacturaResult'] == 1){     //Heizt



while ($row=ibase_fetch_object($estaciones)) {
$paraWS=array();
$paraPOLI['estacion']=$row->ESTACION;
$paraPOLI['com1']=$com1;
$paraPOLI['com2']=$com2;
$paraPOLI['com3']=$com3;
$paraPOLI['fecha']=$fechacompleta;
$paraPOLI['usuario']=$usuario;

			try {
				
			} catch (Exception $e) {
				
			}



}



}else{
  print_r("0"); // se hara un mensaje para el usuario donde no se puedo agregar a facturacion


}

 ?>