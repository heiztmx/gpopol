<?php 
session_start();
include '../metGASOLINERA/metodosGASOLINERA.php';

$noclie = isset($_POST["id"]) ? $_POST["id"] : "NO HAY CLIENTE";
$credito = isset($_POST["credito"]) ? $_POST["credito"] : "";
$numTarjetas = isset($_POST["tarjetas"]) ? $_POST["tarjetas"] :"";
$alias =isset($_POST["alias"]) ? $_POST["alias"] : "";
$usuario = isset($_SESSION["user"]) ? $_SESSION["user"] :"xxx";
$tipoCliente =isset($_POST["tipoCliente"]) ? $_POST["tipoCliente"] : "";
$grupofac =isset($_POST["grupofac"]) ? $_POST["grupofac"] : "";
$metodoPago = isset($_POST["metodoPago"]) ? $_POST["metodoPago"]:"";
$nombreClientex =isset($_POST["nombreClientex"]) ? $_POST["nombreClientex"] : "";

// $usuario= $_SESSION["user"];
//38  y 33


$noclie = (int)$noclie;
$credito =floatval($credito);
$numTarjetas=(int)$numTarjetas;
$objeto = new GASOLINERA();

// print_r($objeto->crear_usuario_web_igas($noclie));
$monto = $objeto->insertDGASSALD($noclie,$nombreClientex,$credito,$usuario,$metodoPago,$tipoCliente,$grupofac);

$resulTarjetas =$objeto->insertTarjetas($numTarjetas,$noclie,$usuario,$alias,$tipoCliente);
$noclie2 = (string)$noclie;

$respuesta =$monto."**".$resulTarjetas["tarjetas"]."**".$resulTarjetas["arrayTarjetas"]."**".$resulTarjetas["arrayNip"]."**".$nombreClientex."**".$noclie2."**".$usuario."**".$tipoCliente."**".$resulTarjetas["numerosVehiculos"];
print_r($respuesta);






 ?>