<?php 

include '../metGASOLINERA/metodosGASOLINERA.php';



$noclie =isset($_POST["noclie"]) ? $_POST["noclie"]:"";
$nombre=isset($_POST["nombre"]) ? $_POST["nombre"] :"";
$calle=isset($_POST["calle"]) ? $_POST["calle"] :"";
$numExt=isset($_POST["numExt"]) ? $_POST["numExt"] :"";
$numInt=isset($_POST["numInt"]) ? $_POST["numInt"] :"";
$cp=isset($_POST["cp"]) ? $_POST["cp"] :"";
$contacto=isset($_POST["contacto"]) ? $_POST["contacto"] :"";
$correo=isset($_POST["correo"]) ? $_POST["correo"] :"";
$metodoPago=isset($_POST["metodoPago"]) ? $_POST["metodoPago"] :"";
$activo=isset($_POST["activo"]) ? $_POST["activo"] :"";


$objeto  = new GASOLINERA();
$modificacion = $objeto->modificacionClientes($noclie,$nombre,$calle,$numExt,$numInt,$cp,$contacto,$correo,$metodoPago,$activo);

if ($modificacion == 1) {
 print_r("modificado");
}else{
	print_r("error");
}

 ?>