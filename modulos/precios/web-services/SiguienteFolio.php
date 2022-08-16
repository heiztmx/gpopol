<?php 
require_once '../../../NuSOAP/lib/nusoap.php';
try {
    $client = new nusoap_client("http://172.16.0.103/WebSite1/BD.asmx?WSDL",true);
} catch (Exception $e) {
  print_r("Error al conectarse al Web Services comunicarse con el administrador del sistema".$client);
}

$Est=isset($_POST['estacion']) ? $_POST['estacion'] : "";

$parametro=array();
$parametro['estacion']=$Est;

try{
$folio =$client->call('SiguienteFolio',$parametro);
print_r($folio);
}
  //Heizt
catch(Exception $e){
print_r($po1);
}


 ?>