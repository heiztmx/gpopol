<?php 

/**
 * 
 */
include '../../../conexion/config.php';
$opcion=isset($_POST["opcion"]) ? $_POST["opcion"] : "";
$id =isset($_POST["id"]) ? $_POST["id"] :"";

$conexion_local=ibase_connect(host_local,user_local,password_local);

switch ($opcion) {
	case 'buscar_permisos':
	$arraypermisos= array();
	$checkpermisos = array();
	$inputs =["peres_estacion","peres_elaboro","peres_estatus"];
	$estaciones_req ="";
	$elaboro_req ="";
	$estatus_req="";
	$estaciones_odc="";
	$elaboro_odc="";
	$estatus_odc="";
	$estaciones_reccupon="";
	$elaboro_reccupon="";
	$estatus_reccupon="";
	$estaciones_repcupon="";
	$elaboro_repcupon="";
	$estatus_repcupon="";

	$sql = "SELECT * FROM PERMISOS_USUARIOS  WHERE IDUSUARIO = '$id'";
	$permisos = ibase_query($conexion_local,$sql);
	while ($per = ibase_fetch_assoc($permisos)) {
		array_push($checkpermisos, $per["PERMISO"]);
	}
	$sqlPE = "SELECT * FROM PERMISOS_ESPECIALES WHERE IDUSUARIO = '$id'";
	$pe = ibase_query($conexion_local,$sqlPE);
	
	while ($perEs=ibase_fetch_assoc($pe)) {
		if ($perEs["INPUT"] == "peres_estacion" && $perEs["PERMISO"] == "ALLREQFIL") {
			$estaciones_req .=$perEs["PERMISO_ESPECIAL"].",";
		}

		if ($perEs["INPUT"] == "peres_elaboro" && $perEs["PERMISO"] == "ALLREQFIL") {
			$elaboro_req .=$perEs["PERMISO_ESPECIAL"].",";
		}

		if ($perEs["INPUT"] == "peres_estatus" && $perEs["PERMISO"] == "ALLREQFIL") {
			$estatus_req .=$perEs["PERMISO_ESPECIAL"].",";
		}

		if ($perEs["INPUT"] == "peres_estacion" && $perEs["PERMISO"] == "ALLORDENCOMPFIL") {
			$estaciones_odc .=$perEs["PERMISO_ESPECIAL"].",";
		}

		if ($perEs["INPUT"] == "peres_elaboro" && $perEs["PERMISO"] == "ALLORDENCOMPFIL") {
			$elaboro_odc .=$perEs["PERMISO_ESPECIAL"].",";
		}
		
		if ($perEs["INPUT"] == "peres_estatus" && $perEs["PERMISO"] == "ALLORDENCOMPFIL") {
			$estatus_odc .=$perEs["PERMISO_ESPECIAL"].",";
		}

		if ($perEs["INPUT"] == "peres_estacion" && $perEs["PERMISO"] == "RECCUPONFIL") {
			$estaciones_reccupon .=$perEs["PERMISO_ESPECIAL"].",";
		}

		if ($perEs["INPUT"] == "peres_elaboro" && $perEs["PERMISO"] == "RECCUPONFIL") {
			$elaboro_reccupon .=$perEs["PERMISO_ESPECIAL"].",";
		}
		
		if ($perEs["INPUT"] == "peres_estatus" && $perEs["PERMISO"] == "RECCUPONFIL") {
			$estatus_reccupon .=$perEs["PERMISO_ESPECIAL"].",";
		}		

		if ($perEs["INPUT"] == "peres_estacion" && $perEs["PERMISO"] == "REPCUPONFIL") {
			$estaciones_repcupon .=$perEs["PERMISO_ESPECIAL"].",";
		}

		if ($perEs["INPUT"] == "peres_elaboro" && $perEs["PERMISO"] == "REPCUPONFIL") {
			$elaboro_repcupon .=$perEs["PERMISO_ESPECIAL"].",";
		}
		
		if ($perEs["INPUT"] == "peres_estatus" && $perEs["PERMISO"] == "REPCUPONFIL") {
			$estatus_repcupon .=$perEs["PERMISO_ESPECIAL"].",";
		}		
	}


	$estaciones_req = substr ($estaciones_req, 0, strlen($estaciones_req) - 1);
	$elaboro_req = substr ($elaboro_req, 0, strlen($elaboro_req) - 1);
	$estatus_req = substr ($estatus_req, 0, strlen($estatus_req) - 1);

	$estaciones_odc = substr ($estaciones_odc, 0, strlen($estaciones_odc) - 1);
	$elaboro_odc = substr ($elaboro_odc, 0, strlen($elaboro_odc) - 1);
	$estatus_odc = substr ($estatus_odc, 0, strlen($estatus_odc) - 1);

	$estaciones_reccupon = substr ($estaciones_reccupon, 0, strlen($estaciones_reccupon) - 1);
	$elaboro_reccupon = substr ($elaboro_reccupon, 0, strlen($elaboro_reccupon) - 1);
	$estatus_reccupon = substr ($estatus_reccupon, 0, strlen($estatus_reccupon) - 1);	

	$estaciones_repcupon = substr ($estaciones_repcupon, 0, strlen($estaciones_repcupon) - 1);
	$elaboro_repcupon = substr ($elaboro_repcupon, 0, strlen($elaboro_repcupon) - 1);
	$estatus_repcupon = substr ($estatus_repcupon, 0, strlen($estatus_repcupon) - 1);	

	$arraypermisos = ["estaciones_req" => $estaciones_req,
	"elaboro_req" => $elaboro_req,
	"estatus_req" =>$estatus_req, 
	"estaciones_odc" => $estaciones_odc,
	"elaboro_odc" => $elaboro_odc,
	"estatus_odc" =>$estatus_odc,
	"estaciones_reccupon" => $estaciones_reccupon,
	"elaboro_reccupon" => $elaboro_reccupon,
	"estatus_reccupon" =>$estatus_reccupon,
	"estaciones_repcupon" => $estaciones_repcupon,
	"elaboro_repcupon" => $elaboro_repcupon,
	"estatus_repcupon" =>$estatus_repcupon,
	"permisos" =>$checkpermisos];
	print_r( json_encode($arraypermisos));
	break;
	
	default:
		# code...
	break;
}



?>