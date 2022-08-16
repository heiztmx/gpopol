

<?php 
include '../metCupones/metodosCupones.php';

$fecha =isset($_POST["fecha"]) ? $_POST["fecha"] : "";
$fecha2 =isset($_POST["fecha2"]) ? $_POST["fecha2"] : "";
$cliente =isset($_POST["cliente"]) ? $_POST["cliente"] : 0;
$estacion =isset($_POST["estacion"]) ? $_POST["estacion"] : "";
$mostrarUsuario =isset($_POST["ip"]) ? $_POST["ip"]: "";
$usuario =isset($_POST["usuario"]) ? $_POST["usuario"]:"";
 $fecha =$fecha ." 00:00";
 $objetocupones = new Cupones();

 // $estacion = 1;
 // $cliente="todos";
 // $fecha ='01.09.2018 00:00';
 if($mostrarUsuario == "Siusuario"){
 	
 	 $cupones = $objetocupones->traercuponesUsuarios($estacion,$cliente,$fecha,$fecha2,$usuario);
 }else{
 	 $cupones = $objetocupones->traercupones($estacion,$cliente,$fecha,$fecha2,$usuario);
 }



print_r($cupones);
 ?>