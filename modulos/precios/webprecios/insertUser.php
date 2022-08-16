<?php 

session_start();
include "metodosweb.php";
// include "../conexion/conexion.php";
include "../../../conexion/config.php";

$obj = new metodosweb();
$metodos = $obj->modulos();
$conexion_local=ibase_connect(host_local,user_local,password_local);

$usuario=$_POST['usuario'];
$password=$_POST['password'];
$nombre=$_POST['nombre'];
$aplico =$_SESSION['user'];


$permisos=array();
$permisos=$_POST["permisos"];
$permisos_cadena=$_POST["permisos_cadena"];
$cadena=explode("||", $permisos_cadena);
$merge=array();
$correo = $_POST["correo"];
$pe_req =array();
$pe_odc=array();
$pe_reccupon =array();
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

if (array_key_exists("pe_reccupon", $_POST)) {
	$pe_reccupon= $_POST["pe_reccupon"];
}else{
	$pe_reccupon= [];
}

if (array_key_exists( "pe_repcupon", $_POST)) {
	# code...
	$pe_repcupon=$_POST["pe_repcupon"];
}else{
	$pe_repcupon=[];
}





$random = rand(0, 1000)."".rand(0, 1000)."".rand(0, 1000);

$recover = $usuario."".$random;
$recover_pass =md5($recover); 
for ($i=0; $i <count($metodos["modulos_js"]); $i++) { 
	
	
	if(is_array($permisos[$i])){
		${"array_$i"}=$permisos[$i];
		$merge[$cadena[$i]] = ${"array_$i"};
	}
}
// print_r($merge);
$passIncri = password_hash($password , PASSWORD_BCRYPT);
$newuser="SELECT MAX(IDUSUARIO) AS MAXIMO FROM USUARIOS";
$usuariox=ibase_query($conexion_local,$newuser);
$folio_pre =ibase_fetch_assoc($usuariox);

$fecha=date("Y/m/d");
$sum=0;
$id_aum=1;
$suma_permisos=0;
$existe_usuario = $obj->validar_existe($conexion_local,"USUARIOS","USUARIO",$usuario, "");
$existe_email = $obj->validar_existe($conexion_local,"USUARIOS","EMAIL",$correo, "");


if ($existe_email > 0) {
	echo "El email que desea usar ya existe";
	exit;
}
if($existe_usuario > 0){
	echo "El usuario que desea usar ya existe";
}else{

	$id=$folio_pre["MAXIMO"] + 1;

	$trans1=ibase_trans("IBASE_WRITE",$conexion_local);	
	$usuario_prim ="INSERT INTO USUARIOS(IDUSUARIO,NOMBRE,USUARIO,PASSWORD,AUTORIZO,FECHA,EMAIL,RECOVER_PASS) 
	VALUES ('$id','$nombre','$usuario','$passIncri','$aplico','$fecha', '$correo', '$recover_pass');";
	$veri=ibase_query($trans1,$usuario_prim);
	$use= ibase_commit($trans1);
	if($use == 1)
	{

		if (count($pe_req) > 0 ) {
			$obj->permisos_especiales($conexion_local,$id,$pe_req,"COMPRAS","ALLREQFIL","insertar");
		}
		if (count($pe_odc) > 0) {
			$obj->permisos_especiales($conexion_local,$id,$pe_odc,"COMPRAS","ALLORDENCOMPFIL", "insertar");

		}

		if (count($pe_reccupon) > 0 ) {
			$obj->permisos_especiales($conexion_local,$id,$pe_reccupon,"CUPONES","RECCUPONFIL","insertar");
		}
		if (count($pe_repcupon) > 0) {
			$obj->permisos_especiales($conexion_local,$id,$pe_repcupon,"CUPONES","REPCUPONFIL", "insertar");

		}
		
		

		for ($i=0; $i <count($metodos["modulos_js"]); $i++) { 
			$key=$metodos["modulos_js"][$i];

			if(array_key_exists($key, $merge)){
				$suma_permisos+=count($merge[$key]);
				$array_links= array();

				$traer_link = ibase_query($conexion_local,"SELECT * FROM MODULOS WHERE  NOMBRE_JS = '$key'");
				
				while ($li=ibase_fetch_assoc($traer_link)) {
					$permiso_link= $li["PERMISO_JS"];
					$array_links[$permiso_link]=$li;
				}
				for ($z=0; $z <count($merge[$key]); $z++) { 	
					$per=$merge[$key][$z];
					$trans=ibase_trans("IBASE_WRITE",$conexion_local);

					if (array_key_exists($per,$array_links)) {
						$link_agregar=$array_links[$per]["URL_PERMISO"];
						$icono = $array_links[$per]["ICONO"];
						$type=$array_links[$per]["TYPE_CASCADA"];
						$funcion = $array_links[$per]["FUNCION"];
						$parametros = $array_links[$per]["PARAMETROS_FUNCION"];
						$nombre_permiso = $array_links[$per]["PERMISO"];
						$ordenado = $array_links[$per]["ORDENADO"];
						$ordenadomod =$array_links[$per]["ORDERMOD"];
						$query ="INSERT INTO PERMISOS_USUARIOS(IDUSUARIO,PERMISO,MODULO,LINK_PERMISO,ICONO,TYPE_CASCADA,FUNCION,PARAMETROS,NOMBRE_PERMISO,ORDENADO,ORDERMOD) 
						VALUES ('$id','$per','$key','$link_agregar','$icono','$type','$funcion','$parametros','$nombre_permiso','$ordenado','$ordenadomod');";
						$veri=ibase_query($trans,$query);
						$estado= ibase_commit($trans);		
					}	
					
					if ($estado) {
						$sum++;
						$id_aum++;
					}
				}	
			}

		}	
		if ($sum > 0 && $id_aum >1) {
			echo "guardado";
		}
	}


	
	
}



?>