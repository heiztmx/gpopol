<?php 

 include 'metodosweb.php';

require_once '../NuSOAP/lib/nusoap.php';

// $con= new conexion();
// $conexion = $con->conectar();




try {
    $client = new nusoap_client("http://172.16.0.13:9092/BD.asmx?WSDL",true);
} catch (Exception $e) {
  print_r("Error al conectarse al Web Services comunicarse con el administrador del sistema".$client);
}


$folio =  isset($_POST['folio']) ? $_POST['folio']  : "no folio";

 $datetime =  isset($_POST['date3']) ? $_POST['date3']  : "no hay fecha";
 $estacion = isset($_POST['Est']) ? $_POST['Est'] : "No hay estacion";
 
 $magna1 = isset($_POST['magna']) ?  $_POST['magna'] : null ;
  
 $premium1=  isset($_POST['premium']) ? $_POST['premium'] : null;
 
 $diesel1=  isset($_POST['diesel']) ? $_POST['diesel']: null;

$usuario =isset($_POST['usuario']) ? $_POST['usuario']:null;



$folio =(int)$folio;
$magna=floatval($magna1);
 $premium=floatval($premium1);
 $diesel=floatval($diesel1);

$date= date_create($datetime);
$fechacompleta = date_format($date, 'Y-m-d H:i:s');
$x =explode(" ", $fechacompleta);
$fecha = $x[0];
$hora = $x[1];

 $datoslocal=array($fecha,$hora,$magna,$premium,$diesel,$folio,$usuario);
 $metodos = new metodosweb();



 $datos  = array();
 $datos['Folio']=$folio;
$datos['Est']=$estacion;
$datos['com1']= $magna;
$datos['com2']=$premium;
$datos['com3']=$diesel;




 try{
	$actualizar = $client->call('UdpPrecios',$datos);

  if($actualizar['UdpPreciosResult'] == "Actualizado"){
    $modificar =$metodos->modificarPrecios($datoslocal);
    if($modificar == 1){
      print_r($actualizar['UdpPreciosResult']." ");
    }else{
      print_r("Error al modificar en BD local llamar a Sistemas");
    }
     
     
  }else{
    print_r($actualizar['UdpPreciosResult']);
  }
	
	
} catch (exception $e){
print_r($actualizar);
}




 ?>



