<?php 

 include  '../../cartera/metGASOLINERA/metodosGASOLINERA.php';

 session_start();
 $objeto = new GASOLINERA();

 // $objeto->sincronizador_tarjetas($_SESSION["user"]);
$mascara =isset($_POST["mascara"]) ?   $_POST["mascara"] : "";
$opcion =isset($_POST["opcion"]) ? $_POST["opcion"] :"regenerador_excel";
$id =isset($_POST["id"]) ? $_POST["id"] :4810;
$inicial =isset($_POST["inicial"]) ? $_POST["inicial"] :0;
$final =isset($_POST["final"]) ? $_POST["final"] :9999;




switch ($opcion) {
	case 'mascaras':
		# code...
		print_r($objeto->Activar_mascara($mascara));
		break;
	case 'usadas':
		# code...
		print_r($objeto->mascaras_Usadas($mascara));
		break;
	case 'delete':
		# code...
		print_r($objeto->delete_mascaras($id));
		break;
	case 'nuevas_mascaras':
		# code...
		(int)$inicial;
		(int)$final;
		print_r($objeto->new_mascaras($mascara,$inicial,$final, $_SESSION['user'] ));
		break;
	case 'regenerador_excel':
		(int)$id;
		$datos = $objeto->mascaras_x_cliente($id,$_SESSION['user']);
		$js = json_encode($datos);
		 print_r( $js);
		break;
	case 'reactivar_mascaras':
		print_r($objeto->reactivar_mascaras($mascara));
		
		break;

	default:
		print_r( "error**hubo problemas para poder realizar la accion, favor de llamar a sistemas");
		break;
}

 ?>