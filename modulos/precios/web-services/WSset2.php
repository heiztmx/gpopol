<?php 

session_start();



require_once '../../../NuSOAP/lib/nusoap.php';

include '../webprecios/metodosweb.php';

$metodos = new metodosweb();
$cone = new conexion();
$conexion = $cone->conectar();


  # code...
  try {
    $client = new nusoap_client("http://172.16.0.13:9092/BD.asmx?WSDL",true);
  
} catch (Exception $e) {
  print_r("Error al conectarse al Web Services comunicarse con el administrador del sistema".$client);

}
 
    





 //url del servicio
$com1=isset($_POST['magna']) ? $_POST['magna'] : "";
$com2=isset($_POST['premium'] )? $_POST['premium'] :"";
$com3=isset($_POST['diesel']) ? $_POST['diesel'] : "";
$datetime=isset($_POST['date3']) ? $_POST['date3'] : "";
$estaciones=isset($_POST['Estaciones']) ? $_POST['Estaciones'] : "";

//recibir las estaciones (POST)
$post=$metodos->tablaEstaciones();
$postEstaciones=array();
$postVerificar = array();

while($alias=ibase_fetch_object($post)){
$postEstaciones = explode("||", $estaciones);
}






// Formato de las fechas y hora
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




//parametros para la facturacion
$paraFACTURA=array();                           //Heizt
$paraFACTURA['estacion']='172.16.1.25';
$paraFACTURA['com1']=$com1;
$paraFACTURA['com2']=$com2;
$paraFACTURA['com3']=$com3;
$paraFACTURA['fecha']=$fechaFAC;  //Modificacion 02/07-2020 $fechaFAC; por $fechacompleta; q2uedo igual
$paraFACTURA['usuario']=$usuario;




// for ($i=0; $i <3 ; $i++) { 
//   # code...
//   try{
//   $po1 =$resultPoli1=$client->call('SetPreciosFactura',$paraFACTURA);
//   if ($po1['SetPreciosFacturaResult'] == "Actualizado" || $po1['SetPreciosFacturaResult'] == "Actualizado") {
//     # code...
//     break;
//   }
// }
// catch(Exception $e){
// print_r($po1);
// if($i == 3){
//        echo "<script>
//                 alert('Problemas al intentar conectar con el servidor favor de llamar a sistemas');
                
//     </script>";
//   }
// }
// }
  $po1 =$resultPoli1=$client->call('SetPreciosFactura',$paraFACTURA);


if ($po1['SetPreciosFacturaResult'] == "Actualizado" || $po1['SetPreciosFacturaResult'] == "Agregado"){

// es el que trae las estaciones de la BD
$estaciones=$metodos->tablaEstaciones();
$ipBD=array();
$estBD=array();
while($ws=ibase_fetch_object($estaciones)){
  array_push($estBD,$ws->ESTACION);
  array_push($ipBD,$ws->IP);
}



$contador=0;
for($z=0; $z<count($ipBD); $z++){

$paraWS=array();
$paraWS['estacion']=$ipBD[$z];
$paraWS['com1']=$com1;
$paraWS['com2']=$com2;
$paraWS['com3']=$com3;
$paraWS['fecha']=$fechacompleta;
$paraWS['usuario']=$usuario;

if($postEstaciones[$contador] == $estBD[$z]){
  try{
$po = $client->call('SetPrecios',$paraWS);
$longitud =strlen($po["SetPreciosResult"]);
// if($longitud <= 5 ){

// }else{
//   print_r("El web services dejo de insertar en la estacion".$postEstaciones[$z]);
//   break;

// }
$mystring = $po['SetPreciosResult'];
$findme   = 'FALLOTRY';
$pos = strpos($mystring, $findme);

  (int)$po['SetPreciosResult'];




if($po['SetPreciosResult'] > 0 && $pos == false){

    $parametrosLocal=array($po['SetPreciosResult'],
    $fecha,$hora,$estBD[$z],$com1,$com2,$com3,"NO",$usuario,$ipBD[$z]);
    $insert=$metodos->insertarPrecios($parametrosLocal);
  if($insert == 1){
    print_r($estBD[$z]." ");
    // echo $postEstaciones[$z]."<br>";
  }else{
     print_r(" ");
  }
  
   
  }else{
    print_r(" ");
  } // fin del if del folio
  
}catch(Exception $ex){
    print_r($ex);
  }
  $contador++;
}else{
  print_r(" ");
  $contador++;}// fin del if para ver Estaciones POST

} //termina el while
 
    }else{
      print_r(" ");


    }


// al momento de guardar una nueva estacion en la base de datos (local) se tiene que verificar en el POSTMAN
// si la insercion fue exitosa tanto en el WS y en la tabla local imprimira los nombres de las estaciones que se enviaron 

























 



 
?>

