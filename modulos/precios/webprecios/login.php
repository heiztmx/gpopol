<?php 

session_start();
include '../../../conexion/config.php';


$conexion_local=ibase_connect(host_local,user_local,password_local);
$usuario=$_POST['user'];
$password= $_POST['contr']; 
	

	$consulta ="SELECT  * FROM USUARIOS WHERE USUARIO ='$usuario'";

			$verificar =ibase_query($conexion_local,$consulta);
			$row = ibase_fetch_assoc($verificar);
			$x = $row['PASSWORD'];
				// print_r("Correcto ".$cadena_modulos);
//  $password == $row["PASSWORD"]
		if(password_verify($password,$x)){
			$modulos=array();
			$master=ibase_query($conexion_local,"SELECT * FROM MODULOSMASTER");
			while ($mod=ibase_fetch_assoc($master)) {
				$modulos[$mod["MODULO"]] = $mod["LINK"];
			}
			$id_usuario=$row["IDUSUARIO"];
			$mod_usuario=ibase_query($conexion_local,"SELECT DISTINCT MODULO FROM PERMISOS_USUARIOS WHERE IDUSUARIO ='$id_usuario'");
			$cadena_modulos="";
			while ($m=ibase_fetch_assoc($mod_usuario)) {
				$key=$m["MODULO"];
				if(array_key_exists($key, $modulos)){
					$_SESSION[$key]=$key;
					
					$cadena_modulos.=$modulos[$key]."||";
				}

				
			}

			$sql  = "SELECT PERMISO FROM  PERMISOS_USUARIOS WHERE  IDUSUARIO ='$id_usuario' AND (PERMISO = 'AUT1COMPRA' OR PERMISO = 'AUT2COMPRA')";
			$result  = ibase_query($conexion_local,$sql);
			$aut = ibase_fetch_assoc($result);
			$sesion_autorizador = "sin_autorizador";
			if ($aut["PERMISO"] != ""  || $aut["PERMISO"] != null) {
				$sesion_autorizador = $aut["PERMISO"];
				
			}

			$_SESSION['aut_compras'] = $sesion_autorizador;
			$_SESSION['id'] = $row["IDUSUARIO"];
			$_SESSION['user'] = $row['USUARIO'];
			$_SESSION['logeado']=true;
			$_SESSION['user'] =$usuario;
			$_SESSION['tiempo']=time();
			$_SESSION["idgas"] =$row["IDUSUARIOIGAS"];
			$_SESSION["usuarioigas"]=$row["USUARIOIGAS"];
			
			print_r("Correcto ".$cadena_modulos);
			
		

			 }
			 else {
			 	
			 print_r("Error ");
			 }
			


			

 ?>


