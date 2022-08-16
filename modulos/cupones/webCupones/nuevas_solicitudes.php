<?php 

include  '../metCupones/metCupones.php';
session_start();

$obj = new Compras();
switch ($_POST["opcion"]) {
 		case '1':
 		 echo $datos  = $obj->nueva_requisicion($_POST);
 		  
 		
 			break;
 		case '2':
 		
 		echo $obj->checar($_POST["sucursal"],$_POST["serie"],$_POST["folio"],$_POST["afectacion"],$_POST["cantidad"]);
 		
 			break;
 		default:
 			# code...
 			break;
 	} 	# code...
 

// print_r($indices);



?>