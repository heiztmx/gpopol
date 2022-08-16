<?php 

/**
 * 
 */
include "config.php";

class sesion
{
	
	public function validar_sesion($usuario="",$logeado="",$id_usuario="")
	{
		session_start();
		$cont=0;
		$permisos =array();
		$modulos_autorizados=array();
		$link_modulos_url=array();
		if (isset($_SESSION["id"])) {
			$id_usuario =$_SESSION["id"];
			$logeado= $_SESSION["logeado"];
			$usuario=$_SESSION["user"];
			$conexion_local=ibase_connect(host_local,user_local,password_local);
			if ($conexion_local) {
				if ($logeado === true ) {
					$sql_usuario = "SELECT COUNT(*) AS EXISTE FROM USUARIOS WHERE USUARIO ='$usuario'";
					$usuario1 = ibase_query($conexion_local,$sql_usuario);
					$existe = ibase_fetch_assoc($usuario1);

					if($existe["EXISTE"] > 0){

						$sql = "SELECT * FROM PERMISOS_USUARIOS WHERE IDUSUARIO = '$id_usuario' ORDER BY ORDERMOD ASC";
						$modulos =ibase_query($conexion_local,$sql);
						while ($mod=ibase_fetch_assoc($modulos)) {
							$cont++;
							array_push($permisos, $mod["PERMISO"]);
							if(!in_array($mod["MODULO"], $modulos_autorizados))
							{
								array_push($modulos_autorizados, $mod["MODULO"]);
							}
						}
						
						if (count($permisos) > 0) {

							for ($i=0; $i <count($modulos_autorizados) ; $i++) {
								$mod_aut= $modulos_autorizados[$i];
								$array_ordenar_id=array();
								$sql_mod ="SELECT LINK,ID FROM MODULOSMASTER WHERE MODULO = '$mod_aut' ORDER BY ID ASC";
								$m=ibase_query($conexion_local,$sql_mod);
								$link=ibase_fetch_assoc($m);
								array_push($link_modulos_url,$link["LINK"]);
								array_push($array_ordenar_id,$link["ID"]);

							}
							// array_multisort($modulos_autorizados, SORT_ASC, $array_ordenar_id);
							$retorno =  ["permisos" => $permisos, "modulos_autorizados" => $modulos_autorizados, "link_modulos" =>$link_modulos_url];
							return $retorno;
						}
					}else{
						header('location:../../../index.php');
						exit;
					}

				}else{
					header('location:../../../index.php');
					exit;
				}
			}else{
				header('location:../../../index.php');
				exit;
			}
		}else{
			header('location:../../../index.php');
			exit;
		}
	}
}
