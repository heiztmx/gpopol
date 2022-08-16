<?php 

//session_start();
include  '../metCupones/metodosCupones.php';

$fecha_recuperacion= isset($_POST["fecha_recuperacion"])?$_POST["fecha_recuperacion"]:"";
$estacion=isset($_POST["estacion"])?$_POST["estacion"]:"";
$folio_cupon=isset($_POST["folio_cupon"])?$_POST["folio_cupon"]:"";
$opcion=isset($_POST["opcion"])?$_POST["opcion"]:"";
$folio_volumetrico=isset($_POST["folio_volumetrico"])?$_POST["folio_volumetrico"]:"";
$obj_datos=isset($_POST["datos"])?$_POST["datos"]:"";

$objeto = new Cupones();


switch ( $_POST["opcion"]) 
	{
	  case 'valida_x_cupon':
			# code...
	  		$datos=array();
	  		$cont=0;
			$resultado = $objeto->valida_cupon($fecha_recuperacion,$estacion,$folio_cupon);
 					
 					while ($r = ibase_fetch_assoc($resultado))
						{
							array_push($datos, $r);
						}
 					//var_dump($datos);	*/

		echo json_encode($datos);

	  break;

	  case 'valida_x_foliovol':
			# code...

	  		//$resultadox=array(); 

	  		$cont=0;
	  		//$folio=strval(intval($folio_volumetrico) + 1000000000);   //MASCARA 100,000,000 PARA SEPARAR DISTINGUIR FOLIOS OXXO GAS VS POLIGAS
	  		$folio=strval(intval($folio_volumetrico));

			$resultadox = $objeto->traer_datos_ticket_cupones($estacion,$folio);
 				if (!is_array($resultadox)){

 					echo json_encode($resultadox);
 				}else {echo json_encode($resultadox);}

			//$datos=$objeto->trae_ip_est($estacion);
 		

		//echo json_encode($resultadox);
		//echo json_encode($datos);
		

	  break;
	
	  case 'guardar':

	 		
	 		//$folio=strval(intval($folio_volumetrico) + 1000000000);   //MASCARA 100,000,000 PARA SEPARAR 
	 		//$resultadox = $obj_datos;
		 	$resultadox = $objeto->guardar_datos_ticket_cupones($obj_datos);

 				if ($resultadox!=''){

 					echo json_encode($resultadox);
 				}else{echo 'Respuesta :'.$resultadox;};
		
		//$datos = explode("-", $filtro3);
		//$sucursal =$datos[1];

	  break;

	  default:
			 echo '<script language="javascript">alert("Los parametros no fueron recibidos en el servidor")</script>';	  

	  break;
	}


?>