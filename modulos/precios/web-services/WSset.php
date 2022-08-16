<?php 

session_start();




include 'classWs.php';
include '../webprecios/metodosweb.php';


$metodos = new metodosweb();
$cone = new conexion();
$conexion = $cone->conectar();

$objWS = new classWS();


  # code...








$com1=isset($_POST['magna']) ? $_POST['magna'] : "";
$com2=isset($_POST['premium'] )? $_POST['premium'] :"";
$com3=isset($_POST['diesel']) ? $_POST['diesel'] : "";
$datetime=isset($_POST['date3']) ? $_POST['date3'] : "";
$estaciones=isset($_POST['Estaciones']) ? $_POST['Estaciones'] : "";

//recibir las estaciones (POST)
$post=$metodos->tablaEstaciones();
$postEstaciones=array();
$postVerificar = array();
$ipBD=array();
$estBD=array();
$idEstaciones=array();
$ipsFactura =array();
$error="error";

while($ws=ibase_fetch_object($post)){
  $postEstaciones = explode("||", $estaciones);
  array_push($estBD,$ws->ESTACION);
  array_push($ipBD,$ws->IP);
  array_push($idEstaciones, $ws->ID);
  array_push($ipsFactura, $ws->IPFACTURACION);
}


array_pop($postEstaciones);



// Formato de las fechas y hora
$date = date_create($datetime);
$fechacompleta = date_format($date, 'Y-m-d H:i:s');
$fechacompleta=(string)$fechacompleta;
$x =explode(" ", $fechacompleta);
$fecha = $x[0];
$fechaFAC = (string)$x[0];                //'Heizt'
$hora = $x[1];

$magna = floatval($com1);
$premium = floatval($com2);
$diesel = floatval($com3);
$usuario=isset($_SESSION['user']) ? $_SESSION['user'] : "";


$Resultadofinal= array();



for ($z=0; $z <count($ipBD) ; $z++) { 
  if($postEstaciones[$z] == $estBD[$z]){
    $facturo = $objWS->Facturacion($ipsFactura[$z],$idEstaciones[$z],$magna,$premium,$diesel,$fechaFAC,$usuario,$hora);  // Modificacion 02/07-2020 $fechaFAC por $fechacompleta
     //print_r($fechacompleta);
    if ($facturo == 1 ) {
      // $ipe=$ipBD[$z]
      $resultPrecios =$objWS->Agregar_precios($ipBD[$z],$magna,$premium,$diesel,$fechacompleta,$usuario,$fecha,$hora,$estBD[$z]);
       $Resultadofinal[$estBD[$z]] = $resultPrecios;

    
  }else{
    $Resultadofinal[$estBD[$z]] = $error;
     }
    }
  }
  print_r(json_encode($Resultadofinal));


















?>
