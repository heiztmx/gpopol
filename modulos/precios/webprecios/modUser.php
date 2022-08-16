<?php 

session_start();
include "metodosweb.php";
// include "../conexion/conexion.php";
include "../../../conexion/config.php";
// include "../conexion/conexion.php";
$obj = new metodosweb();
$metodos = $obj->modulos();
$conexion_local=ibase_connect(host_local,user_local,password_local);
$usuario=$_POST['usuario'];
$password=isset($_POST['password']) ? $_POST['password'] : "";
$nombre=$_POST['nombre'];
$aplico =$_SESSION['user'];
$id_usuario=$_POST["idUsuario"];
$permisos=array();
$permisos=$_POST["permisos"];
$permisos_cadena=$_POST["permisos_cadena"];
$cadena=explode("||", $permisos_cadena);
$merge=array();
$correo = $_POST["correo"];
$pe_req =array();
$pe_odc=array();
$pe_reccupon=array();
$pe_repcupon=array();


if (array_key_exists("pe_req", $_POST)) {
	$pe_req= $_POST["pe_req"];
}else{
	$pe_req= [];
}

if (array_key_exists( "pe_odc", $_POST)) {
	# code...
	$pe_odc=$_POST["pe_odc"];
}else{
	$pe_odc=[];
}

if (array_key_exists( "pe_reccupon", $_POST)) {
	# code...
	$pe_reccupon=$_POST["pe_reccupon"];
}else{
	$pe_reccupon=[];
}

if (array_key_exists( "pe_repcupon", $_POST)) {
	# code...
	$pe_repcupon=$_POST["pe_repcupon"];
}else{
	$pe_repcupon=[];
}

$random = rand(0, 1000)."".rand(0, 1000)."".rand(0, 1000);
$recover = $usuario."".$random;
$recover_pass = md5($recover);
for ($i=0; $i <count($metodos["modulos_js"]); $i++) { 
	
	
	if(is_array($permisos[$i])){
		${"array_$i"}=$permisos[$i];
		$merge[$cadena[$i]] = ${"array_$i"};
	}
}


// modificarUsuarios()
$fecha=date("Y/m/d");
$sum=0;
$id_aum=0;
$suma_permisos=0;
$exisUser = "SELECT COUNT(*) AS EXISTE FROM USUARIOS WHERE USUARIO = '$usuario' AND  IDUSUARIO != '$id_usuario'";
$resulU =ibase_query($conexion_local,$exisUser);
$use = ibase_fetch_assoc($resulU);
$extra = " AND IDUSUARIO  != '".$id_usuario."'";

$existe_email = $obj->validar_existe($conexion_local,"USUARIOS","EMAIL",$correo, $extra);
$existe_usuario = $obj->validar_existe($conexion_local,"USUARIOS","USUARIO",$correo, $extra);
if ($existe_email > 0) {
	echo "El correo ya es usado por otro usuario";
	exit;
}
if($existe_usuario > 0){
	echo "Existente";
}else{
	$id;
	$trans1=ibase_trans("IBASE_WRITE",$conexion_local);	
	if ($password != "") {
		$passIncri = password_hash($password , PASSWORD_BCRYPT);
		$usuario_prim ="UPDATE USUARIOS SET  NOMBRE = '$nombre', 
		USUARIO='$usuario',
		PASSWORD='$passIncri',
		AUTORIZO ='$aplico',
		FECHA ='$fecha',
		EMAIL = '$correo',
		RECOVER_PASS = '$recover_pass' WHERE IDUSUARIO='$id_usuario'";	
	}else{
		$usuario_prim ="UPDATE USUARIOS SET  NOMBRE = '$nombre', 
		USUARIO='$usuario',
		AUTORIZO ='$aplico',
		FECHA ='$fecha',
		EMAIL = '$correo',
		RECOVER_PASS = '$recover_pass'
		WHERE IDUSUARIO='$id_usuario'";	
	}
	
	
	$veri=ibase_query($trans1,$usuario_prim);
	$use= ibase_commit($trans1);
// print_r($pe_req);
	if( $veri > 0)
	{
		if (count($pe_req) > 0 ) {
			
			$obj->permisos_especiales($conexion_local,$id_usuario,$pe_req,"COMPRAS","ALLREQFIL","actualizar");
		}

		if (count($pe_odc) > 0) {
			$obj->permisos_especiales($conexion_local,$id_usuario,$pe_odc,"COMPRAS","ALLORDENCOMPFIL","actualizar");

		}

		if (count($pe_reccupon) > 0 ) {
			
			$obj->permisos_especiales($conexion_local,$id_usuario,$pe_reccupon,"CUPONES","RECCUPONFIL","actualizar");
		}

		if (count($pe_repcupon) > 0) {
			$obj->permisos_especiales($conexion_local,$id_usuario,$pe_repcupon,"CUPONES","REPCUPONFIL","actualizar");

		}

		$mod=ibase_query($conexion_local,"DELETE FROM PERMISOS_USUARIOS WHERE IDUSUARIO = '$id_usuario' ");
		if ($mod> 0) {
			for ($i=0; $i <count($metodos["modulos_js"]); $i++) { 
				$key=$metodos["modulos_js"][$i];
				$traer_link = ibase_query($conexion_local,"SELECT * FROM MODULOS WHERE  NOMBRE_JS = '$key'");
				while ($li=ibase_fetch_assoc($traer_link)) {
					$permiso_link= $li["PERMISO_JS"];
					$array_links[$permiso_link]=$li;
				}
				if(array_key_exists($key, $merge)){
					$suma_permisos+=count($merge[$key]);

					for ($z=0; $z <count($merge[$key]); $z++) { 	
						$per=$merge[$key][$z];
						if (array_key_exists($per, $array_links)) {
							# code...
							$trans=ibase_trans("IBASE_WRITE",$conexion_local);
							$link_agregar=$array_links[$per]["URL_PERMISO"];
							$icono = $array_links[$per]["ICONO"];
							$type=$array_links[$per]["TYPE_CASCADA"];	
							$funcion = $array_links[$per]["FUNCION"];
							$parametros = $array_links[$per]["PARAMETROS_FUNCION"];
							$nombre_permiso = $array_links[$per]["PERMISO"];
							$ordenado = $array_links[$per]["ORDENADO"];
							$ordermod=$array_links[$per]["ORDERMOD"];
							(int)$ordenado;
							(int)$ordermod;
							$query ="INSERT INTO PERMISOS_USUARIOS(IDUSUARIO,PERMISO,MODULO,LINK_PERMISO,ICONO,TYPE_CASCADA,FUNCION,PARAMETROS,NOMBRE_PERMISO,ORDENADO,ORDERMOD) 
							VALUES ('$id_usuario','$per','$key','$link_agregar','$icono','$type','$funcion','$parametros','$nombre_permiso' ,'$ordenado','$ordermod')";
							$veri2=ibase_query($trans,$query);
							$estado= ibase_commit($trans);
							if($veri2 >0)
							{
								$sum++;

							}
							
						}
						
						
						
					}
					
				}

			}
			if ($sum > 0) {
				print_r("update");
			}


		}else{
			print_r("Error al modificar los permisos del usuario");
		}
		

	}else{
		print_r("Error al modificar los datos del usuario");
	}


	
	
}


?>