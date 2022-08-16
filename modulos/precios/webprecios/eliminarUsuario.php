<?php 

include 'metodosweb.php';


$con= new conexion();
$conexion = $con->conectar();

$obj = new metodosweb();
$idusuario =  isset($_POST['idusuario']) ? $_POST['idusuario']  : "No hay folio";

$idusuario=(int)$idusuario;
$borrar ="DELETE FROM USUARIOS WHERE IDUSUARIO = '$idusuario';";
$resul=ibase_query($conexion,$borrar);
if ($resul ==1) {
	$borrar2="DELETE FROM PERMISOS_USUARIOS WHERE IDUSUARIO = '$idusuario'";
	$borrar_permisos= ibase_query($conexion,$borrar2);
	if($borrar_permisos > 0){

		$permiso_especial =$obj->existe_usuario($conexion,"PERMISOS_ESPECIALES",$idusuario);
		if ($permiso_especial > 0) {
			$borrar3="DELETE FROM PERMISOS_ESPECIALES WHERE IDUSUARIO = '$idusuario'";
			$borrar_permisos3= ibase_query($conexion,$borrar3);
			if ($borrar_permisos3 >0) {
				print_r("Eliminado");
			}
		}else{
			print_r("Eliminado");
		}
	}else{
		print_r($borrar_permisos);
	}
} else {
	print_r($met);
}






