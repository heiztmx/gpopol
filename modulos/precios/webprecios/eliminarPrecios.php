<?php 

include 'metodosweb.php';
require_once '../../../NuSOAP/lib/nusoap.php';

$con= new conexion();
$conexion = $con->conectar();
$metodos = new metodosweb();



try {
    $client = new nusoap_client("http://172.16.0.13:9092/BD.asmx?WSDL",true);
} catch (Exception $e) {
  print_r("Error al conectarse al Web Services comunicarse con el administrador del sistema".$client);
}

$folio =  isset($_POST['folio']) ? $_POST['folio']  : "No hay folio";
$ip = isset($_POST['ip']) ? $_POST['ip'] : "No hay ip";


$datos =array();
$datos['Folio']=$folio;
$datos['Est']=$ip;

$folio=(int)$folio;
// $metodos = new metodosweb();


try{
	$eliminar = $client->call('DelPrecios',$datos);
	
	if($eliminar['DelPreciosResult'] == "Eliminado"){
		
		 $met = $metodos->eliminarPrecios($folio);
		 print_r($eliminar['DelPreciosResult']);
	}else{
		 print_r($eliminar['DelPreciosResult']);
	}
	
} catch (exception $e){
print_r($eliminar);
}






 ?>