<?php 


/**
 * 
 */	 

include '../../../conexionGas.php';
include '../../../ConexionADMON.php';
require_once( '../../../conexion.php');
include("../../../general/funciones.php");

class Compras 
{


	

	public function conloc()
	{
		# code...
		$objeto = new conexion();
		$conexion =$objeto->conectar();
		return $conexion;
	}
	public function conGas()
	{
		$objeto = new conexionGAS();
		$conexion = $objeto->conectarGAS();
		return $conexion;
	}
	public function conVen()
	{
		$objeto = new conexionADMON();
		$conexion = $objeto->conectarADMON();
		return $conexion;
	}
	public function conVen2()
	{
		$objeto = new conexionADMON();
		$conexion = $objeto->conectarADMON();
		return $conexion;
	}
	public function conADMON()
	{
		$objeto = new conexionADMON();
		$conexion = $objeto->conectarADM();
		return $conexion;
	}

	public function validad_autorizador($id)
	{
		(int)$id;
		$buscar  ="SELECT COUNT(*) AS AUTORIZADOR  FROM PERMISOS_USUARIOS WHERE IDUSUARIO = '$id'  AND PERMISO = 'AUT2COMPRA' OR PERMISO = 'AUT1COMPRA'";

		$execute = ibase_query($this->conloc(),$buscar);
		$find = ibase_fetch_assoc($execute);
		if ($find["AUTORIZADOR"] > 0) {

			$sql ="SELECT * FROM PERMISOS_USUARIOS WHERE IDUSUARIO = '$id'  AND (PERMISO = 'AUT2COMPRA' OR 
			PERMISO = 'AUT1COMPRA')";

			$permiso =ibase_query($this->conloc(),$sql);
			$per=ibase_fetch_assoc($permiso);
			
			ibase_free_result($permiso);
			ibase_close($this->conloc());
			if ($per["PERMISO"] == 'AUT1COMPRA') {
				return $per["PERMISO"];
			}else{
				return $per["PERMISO"];
			}

		}else{
			return false;
		}

	}
	public function tabla_compras_local_negar_AUT1($fecha_mes_dia)
	{
		$anio = substr($fecha_mes_dia, 0, 4);
		$mes = substr($fecha_mes_dia, 4, 6);

		$sql =" SELECT * FROM  COMPRASS WHERE   EXTRACT(MONTH   FROM FECHA_REQUISICION) = '$mes' AND
		EXTRACT(YEAR   FROM FECHA_REQUISICION) = '$anio'  AND  (AUT1 IS NOT NULL)  AND  ESTATUS = 'PreAutorizado'";

		$compras= ibase_query($this->conloc(),$sql);
		$requisiciones = array();
		$folios_completos="";
		while ($com = ibase_fetch_assoc($compras)) {
			$folios_completos = $com["SUCURSAL"]."".$com["SERIE"]."".$com["FOLIO"];
			$requisiciones[$folios_completos]=$com;
		}	
		return $requisiciones;

	}


	public function tabla_compras_local_AUT2($fecha_mes_dia)
	{
		$anio = substr($fecha_mes_dia, 0, 4);
		$mes = substr($fecha_mes_dia, 4, 6);

		$sql =" SELECT * FROM  COMPRASS WHERE   EXTRACT(MONTH   FROM FECHA_REQUISICION) = '$mes' AND
		EXTRACT(YEAR   FROM FECHA_REQUISICION) = '$anio'  AND ESTATUS = 'PreAutorizado'";

		$compras= ibase_query($this->conloc(),$sql);
		$requisiciones = array();
		$cont = 0;
		$folios_completos="";
		while ($com = ibase_fetch_assoc($compras)) {
			$folios_completos = $com["SUCURSAL"]."".$com["SERIE"]."".$com["FOLIO"];
			$requisiciones[$folios_completos]=$com;
			$cont++;
		}
		if ($cont >0) {
			return $requisiciones;
		}else{
			return $cont;
		}
		
	}
	// public function ordenes_compra_local()
	// {
	// 	# code...
	// }
	public function compras_canceladas_and_autorizadas_todas($consultabd,$afectacion,$tipo_autorizador,$fecha,$conexion)
	{
		$general = new generales();
		$cont=0;
		$resultados=[];
		$resultado="";	
		$requisiciones_pagadas =$this->requisiciones_pagadas($fecha,"");
		$ordenes_igas= $this->requisicion_ordenescompra_folios($fecha,"OC" ,$conexion);
		$estado ="";



		ibase_free_result($consultabd);
		ibase_close($this->conVen());
		while ($r=ibase_fetch_assoc($consultabd)) {
			$requisicion="";
			$requisiciones_locales =$r["SUCURSAL"]."".$r["SERIE"]."".$r["FOLIO"];
			if (array_key_exists($requisiciones_locales, $requisiciones_pagadas)) {
				$estado = $general ->reparar_utf8($r["ESTADO"]."/Pagado");
			}else{
				$estado = $general ->reparar_utf8($r["ESTADO"]);
			}
			$requisicion ="(".$r["SUCURSAL"].")".$r["SERIE"]."-".$r["FOLIO"];
			if (array_key_exists($requisiciones_locales, $ordenes_igas)) {
				$requisicion.= "/".$ordenes_igas[$requisiciones_locales];
			}
			$importe =$r["IMPORTE_COMPRAS"];
			$concepto=$general->reparar_utf8($r["CONCEPTO1"]);
			$elaboro = $general->reparar_utf8($r["ELABORO"]);
			$autorizo = $general->reparar_utf8($r["AUTORIZO"]);
			
			$f_t = explode(" ", $r["FECHA"]);
			$fecha = $general->fecha_bien($f_t[0]);
			$datos=array(
				""=>"",
				"Fecha" =>$fecha,
				// "Suc" =>$r["SUCURSAL"],
				"Requisicion" => $requisicion,
				"Elaboro" =>$elaboro,
				"Concepto" =>$concepto,
				"Autorizo" => $autorizo,
				"Importe" =>number_format($importe, 2, '.', ','),
				"Estado" =>$estado,
				"tipo_afectacion" =>$r["TIPO_AFECTACION"]);
			$arrayDatos["data"][] = $datos;
			$cont++;

		}


		if($cont > 0){
			return json_encode($arrayDatos);


		}else{
			$arrayDatos["data"] = [];
			return json_encode($arrayDatos);
		}
	}



	public function find_rows($consultabd,$find,$arrayrequisiciones,$afectacion,$tipo_autorizador ,$btn_afectacion="")
	{
		$cont=0;
		$resultados=[];
		$resultado="";	
		$general = new generales();

		if ($arrayrequisiciones > 0) {
			# code...

			while ($r=ibase_fetch_assoc($consultabd)) {


				$id = $r["SUCURSAL"]."".$r["SERIE"]."".$r["FOLIO"];

//!	

				if (array_key_exists($id,$arrayrequisiciones ) === $find ) {
					$estado = "";
					$requisicion = $r["SERIE"]."-".$r["FOLIO"];
					$row="";
					$fecha="";
					$titulo_fecha="";	
					$importe=0;
					$autpre="";

					$fecha = explode(" ", $r["FECHA"]);
					$importe =$r["IMPORTE_COMPRAS"];
					if (array_key_exists($id, $arrayrequisiciones)) {
						$autpre = 	$arrayrequisiciones[$id]["AUT1"];
					}else{
						$autpre ="";
					}


					$fecha1 = $general->fecha_bien($fecha[0]);
					$requisicion = "(".$r["SUCURSAL"].")".$r["SERIE"]."-".$r["FOLIO"];
					$elaboro = $general->reparar_utf8($r["ELABORO"]);
					$concepto=$general->reparar_utf8($r["CONCEPTO1"]);
					if ($find == true ) {
						$estado  = "PreAutorizado";
					}else{
						$estado = $general->reparar_utf8($r["ESTADO"]);
					}
					
					
					$afectacion = "";
					if ($find === true) {
						$afectacion = $arrayrequisiciones[$id]["ESTATUS"];
					}else{
						$afectacion = $r["TIPO_AFECTACION"];
					}
					$datos= array(
						"Fecha" =>$fecha1,
						"Requisicion" => $requisicion, 
						"Elaboro" => $elaboro ,
						"Concepto" => $concepto ,
						"Autorizo" => $autpre ,
						"Importe" => number_format($importe, 2, '.', ','),
						"Estado" =>$estado ,
						"tipo_afectacion" =>$afectacion);
					$arrayDatos["data"][] = $datos;
					$cont++;
				}
			}
			if($cont > 0){

				return  json_encode($arrayDatos);
			}else{
				$arrayDatos["data"] = [];
				return json_encode($arrayDatos);
			}
		}else{
			$arrayDatos["data"] = [];
			return json_encode($arrayDatos);
		}
	}




	public function preAutorizadas($fecha,$consultabd,$tipo_autorizador,$afectacion)
	{

		if ($tipo_autorizador == "AUT1COMPRA") {
			$find = false;
			$arrayrequisiciones_locales =$this->tabla_compras_local_negar_AUT1($fecha);
		}else{
			$find =true;
			$arrayrequisiciones_locales =$this->tabla_compras_local_AUT2($fecha);
		}

		return $this->find_rows($consultabd,$find,$arrayrequisiciones_locales,$afectacion,$tipo_autorizador);

	}

	public function preAutorizadas_Autorizador2($fecha,$consultabd,$tipo_autorizador,$afectacion,$btn_afectacion = "")
	{
		$cont=0;
		$arrayrequisiciones_locales =$this->tabla_compras_local_AUT2($fecha);
		$resultado="";

		return $this->find_rows($consultabd,true,$arrayrequisiciones_locales,$afectacion,$tipo_autorizador,$btn_afectacion);

	}

	public function filtras_estados($afectacion,$fecha)
	{
			//requisiciones permisos especiales
		
		
		if ($afectacion  == "todas_afectaciones") {
			$general = new generales();
			$sql = $general->query_permisos_especiales($this->conloc(),$_SESSION["id"],"ALLREQFIL","DINVREQU", $fecha);
			

		}
		elseif($afectacion == "Preautorizadas")
		{
			$sql ="SELECT  * FROM DINVREQU WHERE ESTADO = 'Pendiente de Autorizar' AND MES = '$fecha'";
		}elseif($afectacion  == "PendientedeCotizar")
		{
			$sql  = "SELECT * FROM DINVREQU WHERE MES = '$fecha' AND  (ESTADO  =  'Pendiente de Cotizar'  OR ESTADO  = 'Solicitando Precios' OR ESTADO = 'Pendiente de Autorizar' )  ";

		}
		else{
			if($afectacion == "Rechazada"): 
				$sql ="SELECT  *  FROM DINVREQU WHERE ESTADO CONTAINING  '$afectacion' AND MES = '$fecha'";
			else:
				$sql ="SELECT  * FROM DINVREQU WHERE ESTADO = '$afectacion' AND MES = '$fecha'";
			endif;
		}

		$conexion = $this->conVen();
		$requisiciones_obtenidas_igas =ibase_query($conexion,$sql);
		$resultado="";	
		$resultados =[];

		$cont=0;
		$tipo_autorizador = $this->validad_autorizador($_SESSION["id"]);

		if( $tipo_autorizador !== false)
		{
			// print_r($sql);
			if ( $afectacion !=  "Pendiente de Autorizar"  && $afectacion != "Preautorizadas") {


				return $this->compras_canceladas_and_autorizadas_todas($requisiciones_obtenidas_igas,$afectacion,$tipo_autorizador,$fecha,$conexion);


			}
			elseif($afectacion == "Pendiente de Autorizar"){


				return 	$this->preAutorizadas($fecha,$requisiciones_obtenidas_igas,$tipo_autorizador,$afectacion);

			}elseif($afectacion == "Preautorizadas"){
				$afectacion_aux = "Pendiente de Autorizar";
				return 	$this->preAutorizadas_Autorizador2($fecha,$requisiciones_obtenidas_igas,$tipo_autorizador,$afectacion_aux,$afectacion);
			}

		}else{
			return  $resultados =["tituloFecha" => "Error", "bodyTable" => "el usuario no tiene permisos para compras favor de hablar con sistemas"];	
		}



	}



	public function busqueda_columna($columna,$fecha)
	{
		$sql = "SELECT * FROM DINVREQU WHERE MES  = '$fecha' AND ESTADO  != 'Pendiente de Autorizar'";
		$requ =ibase_query($this->conVen(),$sql);
		$resultado =  $this->compras_canceladas_and_autorizadas_todas($requ,"","",$fecha,"");
		return $resultado["bodyTable"];
	}
	public function busquedaDetallada($sucursal,$serie,$folio)
	{
		$autorizador = $this->validad_autorizador($_SESSION["id"]);
		(int)$sucursal;
		(int)$folio;
		$cadena ="";
		$importe=0;
		$total_importes=0;
		$cantidad_autorizada="";
		$sql ="SELECT * FROM DINVREQUD WHERE SUCURSAL = '$sucursal' AND SERIE = '$serie' AND FOLIO = '$folio'";
		$busqueda =ibase_query($this->conVen(),$sql);
		$cont=0;
		$observacion="";

		while ($r = ibase_fetch_assoc($busqueda)) {


			if ($autorizador == "AUT1COMPRA") {
				$cantidad_autorizada = $r["CANTIDAD"];
				$importe = $r["CANTIDAD"] * $r["PRECIO_COMPRAS"];

			}else{
				$cantidad_autorizada = $r["CANTIDAD_AUTORIZADA"];
				$importe = $r["CANTIDAD_AUTORIZADA"] * $r["PRECIO_COMPRAS"];
			}

			$descripcion_producto="";
			floatval($importe);
			if(!mb_detect_encoding($r["DESCRIP_PRODUCTO"],"UTF-8",true)){
				$descripcion_producto = utf8_encode($r["DESCRIP_PRODUCTO"]);
			}else{
				$descripcion_producto=$r["DESCRIP_PRODUCTO"];
			}

			$observacion_x_producto =array();

			if ($r["OBSERVACION"] !==  null) {

				$blob_data = ibase_blob_info( $r["OBSERVACION"]);
				$blob_hndl = ibase_blob_open( $r["OBSERVACION"]);
				// print_r($blob_data[0]);
				$obse=      ibase_blob_get($blob_hndl, $blob_data[0]);

				if(!mb_detect_encoding($obse,"UTF-8",true)){
					$obse = utf8_encode($obse);
				}else{
					$obse = $obse;
				}

			}else{
				$obse= "*";
			}

			if ($obse != "*") {
				$observacion .= $obse."||||";
			}

			$datos = array(
				"descripcion" =>$descripcion_producto,
				"unidad_pro" => $r["UNIDAD_PROD"],
				"solicitadas" => $r["CANTIDAD"],
				"aprobadas" =>$cantidad_autorizada,
				"precios" =>$r["PRECIO_COMPRAS"],
				"importe" =>number_format($importe, 2, '.', ','),
				"codigo_pro" =>$r["PRODUCTO"],
				"indice_pro" =>$r["INDICE"]
			);
			$arrayDatos["data"][] = $datos;
			$total_importes+=$importe;
			$cont++;


		}
		// (String)$total_importes;
		// $arrayDatos["total"] =$total_importes;
		if ($cont > 0) {

			return json_encode($arrayDatos);
		}else{
			$arrayDatos["data"] = [];
			return json_encode($arrayDatos);
		}

		$arrayDatos["data"] = [];
		return json_encode($arrayDatos);
	}

	public function pagarOC($sucursal,$serie,$folio,$concepto)
	{
		session_start();
		$sqlgas = "SELECT FIRST(1) * FROM DCPRDOCP WHERE SUCURSAL = '$sucursal' AND SERIE = '$serie' AND FOLIO = '$folio'";
		$sqligas_exce = ibase_query($this->conVen(), $sqlgas);
		$oc_gas = ibase_fetch_assoc($sqligas_exce);

		$sql_mayor = "SELECT COUNT(*) AS MAXIMO  FROM ORDENES_COMPRA ";
		$sql_mayor_exec = ibase_query($this->conloc() ,$sql_mayor);
		$sql_max = ibase_fetch_assoc($sql_mayor_exec);
		$mayor = $sql_max["MAXIMO"] + 1;

		
		(int)$sucursal;
		(int)$folio;

		$descripcion_OC = $concepto;
		$suc_req= $oc_gas["SUCURSAL_REQU"];
		$serie_req = $oc_gas["SERIE_REQU"];
		$folio_req = $oc_gas["FOLIO_REQU"];
		$usuario = $_SESSION['user'];
		
		$fecha_pagado = date("d.m.Y");
		$fecha_bd = explode(" ", $oc_gas["FECHA"]);
		$fecha_oc = $fecha_bd[0];
		$sql_pagar = "INSERT INTO ORDENES_COMPRA 
		(ID, DESCRIPCION_ORDEN,SUCURSAL, SERIE, FOLIO ,FECHA_OC , NOTA_REFERENCIA, ESTADO, SUCURSAL_REQ, SERIE_REQ, FOLIO_REQ, USUARIO,FECHA_PAGADO) VALUES 
		('$mayor','$descripcion_OC', '$sucursal' ,'$serie','$folio','$fecha_oc','','Pagado','$suc_req', '$serie_req', '$folio_req','$usuario' ,'$fecha_pagado')";

		$guardar_pagado = ibase_query($this->conloc(),$sql_pagar);
		if ($guardar_pagado) {
			return "Pagado";
		}else{
			return "Error";
		}
	}
	public function busquedaDetalladaOC($sucursal,$serie,$folio)
	{
		
		(int)$sucursal;
		(int)$folio;
		$cadena ="";
		$importe=0;
		$total_importes=0;
		$cantidad_autorizada="";
		$sql ="SELECT * FROM DCPRDOCP WHERE SUCURSAL = '$sucursal' AND SERIE = '$serie' AND FOLIO = '$folio'";
		$busqueda =ibase_query($this->conVen(),$sql);
		$cont=0;
		$observacion="";

		while ($r = ibase_fetch_assoc($busqueda)) {




			
			$cantidad_autorizada = $r["CANTIDAD"];
			$importe = $r["CANTIDAD"] * $r["PRECIO"];

			
			$descripcion_producto="";
			floatval($importe);

			if(!mb_detect_encoding($r["DESCRIP_PRODUCTO"],"UTF-8",true)){
				$descripcion_producto = utf8_encode($r["DESCRIP_PRODUCTO"]);
			}else{
				$descripcion_producto=$r["DESCRIP_PRODUCTO"];
			}

			$observacion_x_producto =array();

			if ($r["DESCRIPCION"] !==  null) {

				$blob_data = ibase_blob_info( $r["DESCRIPCION"]);
				$blob_hndl = ibase_blob_open( $r["DESCRIPCION"]);
				// print_r($blob_data[0]);
				$obse=      ibase_blob_get($blob_hndl, $blob_data[0]);

				if(!mb_detect_encoding($obse,"UTF-8",true)){
					$obse = utf8_encode($obse);
				}else{
					$obse = $obse;
				}

			}else{
				$obse= "*";
			}

			if ($obse != "*") {
				$observacion .= $obse."||||";
			}

			$datos = array(
				"descripcion" =>$descripcion_producto,
				"unidad_pro" => $r["UNIDAD"],
				"solicitadas" => $r["CANTIDAD"],
				"aprobadas" =>$cantidad_autorizada,
				"precios" =>$r["PRECIO"],
				"importe" =>number_format($importe, 2, '.', ','),
				"codigo_pro" =>$r["PRODUCTO"],
				"indice_pro" =>$r["INDICE"]
			);
			$arrayDatos["data"][] = $datos;
			$total_importes+=$importe;
			$cont++;


		}
		// (String)$total_importes;
		// $arrayDatos["total"] =$total_importes;
		if ($cont > 0) {

			return json_encode($arrayDatos);
		}else{
			$arrayDatos["data"] = [];
			return json_encode($arrayDatos);
		}

		$arrayDatos["data"] = [];
		return json_encode($arrayDatos);;
	}

	public function datos_usuario($id_usuario)
	{


		$datos_compras = "SELECT 
		US.IDUSUARIO AS ID, 
		US.USUARIOIGAS AS USUARIOIGAS,
		US.IDUSUARIOIGAS AS IDUSUARIOIGAS,
		PU.PERMISO AS TIPOAUTORIZADOR
		FROM USUARIOS US 
		JOIN PERMISOS_USUARIOS PU
		ON US.IDUSUARIO = PU.IDUSUARIO	
		WHERE US.IDUSUARIO = '$id_usuario' AND PU.IDUSUARIO = '$id_usuario' AND (PU.PERMISO = 'AUT1COMPRA' OR PU.PERMISO = 'AUT2COMPRA')";
		$user_datos = ibase_query($this->conloc(),$datos_compras);
		$user_datos_compras = ibase_fetch_assoc($user_datos);

		return $user_datos_compras;
	}
	public function guardarCompras($sucursal,$serie,$folio,$solicito,$aut1,$estatus,$importe,$aprobadas,$cod_producto,$indices,$fechareq)
	{
		(int)$sucursal;
		(int)$folio;
		$contador =0;
		$fecha=date("d.m.Y");
		$id=0;
		$id_usuario =$_SESSION["id"];
		$aut = $_SESSION["user"];
		$general = new generales();

		$vali_aut = "SELECT  PERMISO FROM PERMISOS_USUARIOS WHERE IDUSUARIO = '$id_usuario' AND ( PERMISO = 'AUT1COMPRA' OR PERMISO = 'AUT2COMPRA') ";
		$tipo_val_auto =ibase_query($this->conloc(),$vali_aut);
		$validad_autorizador =ibase_fetch_assoc($tipo_val_auto);


		$user_igas = $this->datos_usuario($id_usuario);
		$usuarioIgas = $user_igas["USUARIOIGAS"];
		$id_usuario_igas = 0;
		if ($id_usuario_igas != "" || $id_usuario_igas != NULL) {
			$id_usuario_igas = $user_igas["IDUSUARIOIGAS"];
		}
		

		if ($validad_autorizador["PERMISO"] == "AUT1COMPRA") {

			$veri =ibase_query($this->conloc(),"SELECT COUNT(*) as REGISTROS FROM COMPRASS");
			$count =ibase_fetch_assoc($veri);
			$id = $count["REGISTROS"] + 1;	
			$fechareq2 = $general->fecha_bd($fechareq);
			$sql ="INSERT INTO COMPRASS (ID,FECHA,SUCURSAL,SERIE,FOLIO,IMPORTE,SOLICITO,AUT1,ESTATUS,FECHA_REQUISICION)
			VALUES  ('$id','$fecha','$sucursal','$serie','$folio','$importe','$solicito','$aut','$estatus','$fechareq2')";

			$accion_local =ibase_query($this->conloc(),$sql);
			if ($accion_local == 1) {
				for ($i=0; $i <count($aprobadas) ; $i++) { 
					(int)$aprobadas[$i];
					(int)$cod_producto[$i];
					(int)$indices[$i];
					$aprob = number_format((float) $aprobadas[$i], 3, '.', '');
					(string)$aprob;
					$update ="UPDATE DINVREQUD SET CANTIDAD_AUTORIZADA = '$aprob' WHERE SUCURSAL = '$sucursal' AND SERIE = '$serie' AND FOLIO = '$folio' AND  PRODUCTO = '$cod_producto[$i]' AND  INDICE = '$indices[$i]' " ;

					$actua = ibase_query($this->conVen(), $update);
					if($actua == 1)
					{

						$contador++;
					}

				}


			}
			if($contador == count($indices))
			{
				$respuesta = ["mensaje" => "<p>Se ha pre-Autorizado la requisicion con folio: <strong>".$sucursal."".$serie."".$folio."</strong></p>. <p>Se tendra que esperar la autorizacion final</p>", "tipo" => "success"];	
			}elseif ($contador < count($indices) && $contador > 0) {
			# code...
				$respuesta = ["mensaje" => "<p>No se pudieron  pre-autorizar todos los productos de  la requisicion con folio: <strong>".$sucursal."".$serie."".$folio."</strong></p>. <p>Favor de validarlo con sistemas</p>", "tipo" => "info"];	
			}elseif ($contador == 0) {
			# code...
				$respuesta = ["mensaje" => "<p>No se pudo pre-Autorizar la requisicion con folio: <strong>".$sucursal."".$serie."".$folio."</strong></p>. <p>intentelo mas tarde<p>", "tipo" => "error"];
			}else{
				$respuesta = ["mensaje" => "Error" , "tipo" => "error"];
			}
			return json_encode($respuesta);

		}else{

			$sql ="UPDATE COMPRASS  SET AUT2 = '$aut', ESTATUS = 'Autorizado', IMPORTE = '$importe'
			WHERE SERIE = '$serie' AND SUCURSAL = '$sucursal' AND  FOLIO = '$folio'";
			$estado_requisicion = "";
			$cont_autorizadas=0;
			$date = date_create();
			$fecha_hora_autoriza = date("d.m.Y");
			date_default_timezone_set("America/Mexico_City");

			$hora_autoriza =date("H:i"); 
			$importe_autorizado = $importe;
			$accion_local =ibase_query($this->conloc(),$sql);
			$total_cantidad_autorizada=0.0;
			if ($accion_local == 1) {

				for ($i=0; $i <count($aprobadas) ; $i++) {

					(int)$aprobadas[$i];
					(int)$cod_producto[$i];
					(int)$indices[$i];
					// $aprob = $aprobadas[$i];
					// floatval($aprob);
					$aprob = number_format((float) $aprobadas[$i], 3, '.', '');
					$total_cantidad_autorizada+=$aprob;
					$estado_requisicion = "Autorizada";

					if ($aprob > 0) {
						$estado_requisicion ="Autorizada";
						$cont_autorizadas++;

					}else{
						$estado_requisicion ="Rechazada";
					}

					$update ="UPDATE DINVREQUD SET CANTIDAD_AUTORIZADA = '$aprob'  , FECHA_AUTORIZA = '$fecha_hora_autoriza', HORA_AUTORIZA = '$hora_autoriza', ESTADO  = '$estado_requisicion' WHERE SUCURSAL = '$sucursal' AND SERIE = '$serie' AND FOLIO = '$folio' AND  PRODUCTO = '$cod_producto[$i]' AND  INDICE = '$indices[$i]' " ;





					$actua = ibase_query($this->conVen(), $update);
					if($actua == 1)
					{

						$contador++;
					}

				}


				if ($cont_autorizadas > 0) {
					$estado_requisicion ="Autorizada";
				}else{
					$estado_requisicion ="Rechazada";
				}
				$sql_update_igas ="UPDATE DINVREQU SET CANTIDAD_AUTORIZADA ='$total_cantidad_autorizada', IMPORTE_AUTORIZADO = '$importe_autorizado', FECHA_AUTORIZA = '$fecha_hora_autoriza', HORA_AUTORIZA = '$hora_autoriza', ESTADO = '$estado_requisicion' , AUTORIZO = '$usuarioIgas', CLAVEAUTORIZO = '$id_usuario_igas' WHERE SERIE = '$serie' AND SUCURSAL = '$sucursal' AND  FOLIO = '$folio' ";
				$sql_autorizodor = ibase_query($this->conVen(), $sql_update_igas);


			}

			if($contador == count($indices))
			{
				$respuesta = ["mensaje" => "<p>Se ha autorizado la requisicion con folio: <strong>".$sucursal."".$serie."".$folio."</strong></p>.", "tipo" => "success"];	
			}elseif ($contador < count($indices) && $contador > 0) {
			# code...
				$respuesta = ["mensaje" => "<p>No se pudieron  autorizar todos los productos de  la requisicion con folio: <strong>".$sucursal."".$serie."".$folio."</strong></p>. <p>Favor de validarlo con sistemas</p>", "tipo" => "info"];	
			}elseif ($contador == 0) {
			# code...
				$respuesta = ["mensaje" => "<p>No se pudo Autorizar la requisicion con folio: <strong>".$sucursal."".$serie."".$folio."</strong></p>. <p>intentelo mas tarde<p>", "tipo" => "error"];
			}else{
				$respuesta = ["mensaje" => "Error" , "tipo" => "error"];
			}
			return json_encode($respuesta);

		}





	}



	public function cancelar_requisicion($sucursal,$serie,$folio,$solicito,$aut1,$estatus,$importe,$aprobadas,$cod_producto,$indices,$fechareq,$motivo_rechazo)
	{

		$general = new generales();
		$user_igas = $this->datos_usuario($_SESSION["id"]);
		$usuarioIgas = $user_igas["USUARIOIGAS"];
		$id_usuario_igas = 0;
		if ($id_usuario_igas != "" || $id_usuario_igas != NULL) {
			$id_usuario_igas = $user_igas["IDUSUARIOIGAS"];
		}
		(int)$id_usuario_igas;
		$tipo_autorizador = $user_igas ["TIPOAUTORIZADOR"];
		$campobd_aut ="";
		$contador=0;
		$aut=$_SESSION["user"];
		$fechareq = $general->fecha_bd($fechareq);
		$sqlid = "SELECT COUNT(*) AS MAXIMO  FROM COMPRASS";
		$sqlexecute= ibase_query($this->conloc(),$sqlid);
		$max = ibase_fetch_assoc($sqlexecute);
		$id = $max["MAXIMO"]+1; 

		$date = date_create();
		$fecha_hora_autoriza = date("d.m.Y");
		date_default_timezone_set("America/Mexico_City");
		$hora_autoriza =date("H:i"); 
		if ($tipo_autorizador == "AUT1COMPRA") {
			$campobd_aut ="AUT1";
			$sql ="INSERT INTO COMPRASS (ID,FECHA,SUCURSAL,SERIE,FOLIO,IMPORTE,SOLICITO,".$campobd_aut.",ESTATUS,FECHA_REQUISICION)
			VALUES  ('$id','$fecha_hora_autoriza','$sucursal','$serie','$folio',0,'$solicito','$aut','Rechazada','$fechareq')";
		}else{
			$campobd_aut ="AUT2";
			$sql ="UPDATE COMPRASS  SET AUT2 = '$aut',  FECHA = '$fecha_hora_autoriza',ESTATUS = 'Rechazada', IMPORTE = 0
			WHERE SERIE = '$serie' AND SUCURSAL = '$sucursal' AND  FOLIO = '$folio'";
		}

		
		
		$estado_requisicion = "";
		$cont_autorizadas=0;


		
		$importe_autorizado = $importe;
		$accion_local =ibase_query($this->conloc(),$sql);
		$total_cantidad_autorizada=0.0;
		if ($accion_local == 1) {

			for ($i=0; $i <count($aprobadas) ; $i++) {

				(int)$aprobadas[$i];
				(int)$cod_producto[$i];
				(int)$indices[$i];

				$aprob = (float) $aprobadas[$i];
				$total_cantidad_autorizada+=$aprob;
				$estado_requisicion = "";

				if ($aprob > 0) {
					$estado_requisicion ="Autorizada";
					$cont_autorizadas++;

				}else{
					$estado_requisicion ="Rechazada";
				}

				$update ="UPDATE DINVREQUD SET CANTIDAD_AUTORIZADA = '$aprob' ,ESTADO  = '$estado_requisicion' , MOTIVO_RECHAZO = '$motivo_rechazo' WHERE SUCURSAL = '$sucursal' AND SERIE = '$serie' AND FOLIO = '$folio' AND  PRODUCTO = '$cod_producto[$i]' AND  INDICE = '$indices[$i]' " ;





				$actua = ibase_query($this->conVen(), $update);
				if($actua == 1)
				{

					$contador++;
				}

			}


			if ($cont_autorizadas > 0) {
				$estado_requisicion ="Autorizada";
			}else{
				$estado_requisicion ="Rechazada";
			}

			$sql_update_igas ="UPDATE DINVREQU 
			SET CANTIDAD_AUTORIZADA ='$total_cantidad_autorizada', IMPORTE_AUTORIZADO = 0.0 , ESTADO = '$estado_requisicion' , 
			AUTORIZO = '$usuarioIgas',
			CLAVEAUTORIZO = '$id_usuario_igas',
			MOTIVO_RECHAZO = '$motivo_rechazo',
			MOTIVO_CANCELACION = '$motivo_rechazo'
			WHERE SERIE = '$serie' AND SUCURSAL = '$sucursal' AND  FOLIO = '$folio' ";
			
			$sql_autorizodor = ibase_query($this->conVen(), $sql_update_igas);


		}

		if($contador == count($indices) && $sql_autorizodor)
		{
			$respuesta = ["mensaje" => "<p>Se ha cancelado la requisicion con folio: <strong>".$sucursal."".$serie."".$folio."</strong></p>.", "tipo" => "success", "pie" => ""];	
		}else{
			$respuesta = ["mensaje" => "Error" , "tipo" => "error", "pie" => "Si el problema persiste, llamar a sistemas"];
		}
		return json_encode($respuesta);



	}
	public function ordenes_compra_pagadas($fecha,$estado)
	{
		$anio = substr($fecha, 0, 4);
		$mes = substr($fecha, 4, 6);

		$sql =" SELECT * FROM  ORDENES_COMPRA WHERE   EXTRACT(MONTH   FROM FECHA_OC) = '$mes' AND
		EXTRACT(YEAR   FROM FECHA_OC) = '$anio' AND ESTADO = 'Pagado'";
		// print_r($sql);
		$compras = ibase_query($this->conloc(),$sql);
		$clave ="";
		$cont=0;
		$arraycompras = array();
		while ($ordenes = ibase_fetch_assoc($compras)) {
			$clave = $ordenes["SUCURSAL"]."".$ordenes["SERIE"]."".$ordenes["FOLIO"];
			$arraycompras[$clave] = $ordenes;
			$cont++;
		}
		ibase_free_result($compras);
		ibase_close($this->conloc());
		return $arraycompras;

		
	}
	public function requisiciones_pagadas($fecha,$estado)
	{
		$anio = substr($fecha, 0, 4);
		$mes = substr($fecha, 4, 6);

		$sql =" SELECT * FROM  ORDENES_COMPRA WHERE   EXTRACT(MONTH   FROM FECHA_OC) = '$mes' AND
		EXTRACT(YEAR   FROM FECHA_OC) = '$anio' AND ESTADO = 'Pagado'";

		$compras = ibase_query($this->conloc(),$sql);
		$clave ="";
		$cont=0;
		$arraycompras = array();
		while ($ordenes = ibase_fetch_assoc($compras)) {
			$clave = $ordenes["SUCURSAL_REQ"]."".$ordenes["SERIE_REQ"]."".$ordenes["FOLIO_REQ"];
			$arraycompras[$clave] = $ordenes;
			$cont++;
		}
		return $arraycompras;


	}


	public function ordenes_compra($estado,$fecha )
	{

		$general = new generales();
		// $fecha  = $general->fecha_bd($fecha);
		// $f=explode(".", $fecha);
		// $fecha  = $f[0]."".$f[1];
		$sql= "SELECT * FROM DCPROCPR WHERE  ESTATUS != 'C' AND MES  = '$fecha' ";
		$conexion = $this->conVen();
		$sql_compras = ibase_query($conexion,$sql);
		$ordenes_local = $this->ordenes_compra_pagadas($fecha,$estado);
		$tabla = "";
		$registros=0;

		
		$arrayDatos=array();


		$requi_igas= $this->requisicion_ordenescompra_folios($fecha,"RQ",$conexion);
		while ($orden_igas= ibase_fetch_assoc($sql_compras)) {
			$clave = "";
			$estado ="";
			$clave = $orden_igas["SUCURSAL"]."".$orden_igas["SERIE"]."".$orden_igas["FOLIO"];

			if (!array_key_exists($clave, $ordenes_local)) {

				$fechas= explode(" ", $orden_igas["FECHA"]);
				$orden ="(".$orden_igas["SUCURSAL"].")".$orden_igas["SERIE"]."-".$orden_igas["FOLIO"];

				if ($orden_igas["ESTADO"] == "Pendiente de Surtir") {
					$estado = "Pendiente por pagar";
				}else{
					$estado =$orden_igas["ESTADO"];
				}
				$registros++;

				if (array_key_exists($clave, $requi_igas)) {
					$orden.="/".$requi_igas[$clave];
				}
				$datos = array(
					"Fecha" =>$general->fecha_bien($fechas[0]),
					"Requisicion"=>$orden,
					"Elaboro" =>$general->reparar_utf8($orden_igas["ELABORO"]),
					"Concepto" =>$general->reparar_utf8($orden_igas["CONCEPTO1"]),
					"Autorizo" =>$general->reparar_utf8($orden_igas["AUTORIZO"]),
					"Total" =>number_format($orden_igas["TOTAL"],2),
					"Estado" =>$estado
				);
				$arrayDatos["data"][]= $datos;
			}

		}
		if ($registros > 0) {
			return json_encode($arrayDatos);
		}else{
			$arrayDatos["data"]=[];
			return json_encode($arrayDatos);
		}
		// }else{
		// 	$arrayDatos["datos"]=[];
		// 	return json_encode($arrayDatos);
		// }



	}
	public function requisicion_ordenescompra_folios($fecha,$tipo,$conexion)
	{
		$sql = "";
		$array =array();
		if ($tipo == "RQ") {
			$sql = "SELECT DISTINCT SUCURSAL,FOLIO, SERIE  ,SERIE_REQU , FOLIO_REQU ,SUCURSAL_REQU FROM DCPRDOCP WHERE MES = '$fecha'";
			
			$datos = ibase_query($conexion,$sql);

			while ($cla = ibase_fetch_assoc($datos)) {
				$orden="";
				$requisicion="";
				$orden = $cla["SUCURSAL"]."".$cla["SERIE"]."".$cla["FOLIO"];
				$requisicion = "(".$cla["SUCURSAL_REQU"].")".$cla["SERIE_REQU"]."-".$cla["FOLIO_REQU"];
				$array[$orden] = $requisicion;

			}
			ibase_free_result($datos);
			ibase_close($conexion);
			return $array;
		}

		if ($tipo = "OC") {

			$fecha2 = $this->aumentar_fecha($fecha);
			$sql = "SELECT DISTINCT SUCURSAL,FOLIO, SERIE  ,SERIE_REQU , FOLIO_REQU ,SUCURSAL_REQU FROM DCPRDOCP  WHERE  MES = '$fecha' OR  MES  = '$fecha2' ";
			// print_r($sql);
			$datos = ibase_query($conexion,$sql);
			while ($cla = ibase_fetch_assoc($datos)) {
				$orden = "(".$cla["SUCURSAL"].")".$cla["SERIE"]."-".$cla["FOLIO"];
				$requisicion = $cla["SUCURSAL_REQU"]."".$cla["SERIE_REQU"]."".$cla["FOLIO_REQU"];
				$array[$requisicion] = $orden;

			}
			ibase_free_result($datos);
			ibase_close($conexion);
			return $array;
		}


	}


	public function aumentar_fecha($fecha)
	{
		$mes_mas = substr($fecha, -2);
		$anio_mas  =  substr($fecha, 0,4);
		$fecha2 =  "";
		if ($mes_mas == "12") {

			$anio_mas =(int)$anio_mas + 1;
			$mes_mas =  "01";
			return $fecha2 = $anio_mas."".$mes_mas;
		}else{
			$mes_mas = (int)$mes_mas + 1;
		// print_r($mes_mas);
			if ($mes_mas < 10) {
				$fecha2 = $anio_mas."0".$mes_mas;
			}else{
				$fecha2 = $anio_mas."".$mes_mas;
			}

			return $fecha2;
		}

	}
	public function all_ordenes_compras($fecha)
	{


		// $fecha  = $general->fecha_bd($fecha);
		// $f=explode(".", $fecha);
		// $fecha  = $f[0]."".$f[1];

		session_start();

		$general = new generales();
		$sql = $general->query_permisos_especiales($this->conloc(),$_SESSION["id"],"ALLORDENCOMPFIL","DCPROCPR", $fecha);
		// echo $sql;

		$conexion = $this->conVen();
		$sql_compras = ibase_query($conexion,$sql);
		// $ordenes_local = $this->ordenes_compra_local($fecha,$estado);
		
		$tabla = "";
		$registros=0;
		$estado ="";
		$general = new generales();
		$arrayDatos=array();
		$requisicion_new="";
		$ordenes_pagadas = $this->ordenes_compra_pagadas($fecha,"");
		$requi_igas= $this->requisicion_ordenescompra_folios($fecha,"RQ",$conexion);


		while ($orden_igas= ibase_fetch_assoc($sql_compras)) {
			$clave = "";
			$orden_co="";
			$clave = $orden_igas["SUCURSAL"]."".$orden_igas["SERIE"]."".$orden_igas["FOLIO"];

			if ($orden_igas["ESTATUS"] == "C") {

				$estado = "Cancelado";

			}else {
				if (array_key_exists($clave, $ordenes_pagadas)) {
					$estado = $orden_igas["ESTADO"]."/Pagado";
				}else{
					$estado = $orden_igas["ESTADO"];
				}
			}
			
			$requisicion_new = "/".$requi_igas[$clave];
			// print_r($$requi_igas[$clave]);
			$orden_co ="(".$orden_igas["SUCURSAL"].")".$orden_igas["SERIE"]."-".$orden_igas["FOLIO"]."".$requisicion_new;


			$fechas= explode(" ", $orden_igas["FECHA"]);
			

			$registros++;
			$datos = array(
				"Fecha" =>$general->fecha_bien($fechas[0]),
				"Requisicion"=>$orden_co,
				"Elaboro" =>$general->reparar_utf8($orden_igas["ELABORO"]),
				"Concepto" =>$general->reparar_utf8($orden_igas["CONCEPTO1"]),
				"Autorizo" =>$general->reparar_utf8($orden_igas["AUTORIZO"]),
				"Total" =>number_format($orden_igas["TOTAL"],2),
				"Estado" =>$estado
			);
			$arrayDatos["data"][]= $datos;


		}
		// ibase_free_result($sql_compras);
		// ibase_close($this->conVen());
		if ($registros > 0) {
			return json_encode($arrayDatos);
		}else{
			$arrayDatos["data"]=[];
			return json_encode($arrayDatos);
		}
		// }else{
		// 	$arrayDatos["datos"]=[];
		// 	return json_encode($arrayDatos);
		// }
	}

	public function pagadas_ordenes_compras($fecha)
	{
		//ordenes de compra permisos especiales

		// 

		session_start();

		$general = new generales();
		// $fecha  = $general->fecha_bd($fecha);
		// $f=explode(".", $fecha);
		// $fecha  = $f[0]."".$f[1];
		// $sql = $general->query_permisos_especiales($this->conloc(),$_SESSION["id"],"ALLORDENCOMPFIL","DCPROCPR", $fecha);
		$query = "SELECT * FROM DCPROCPR WHERE MES  = '$fecha' ";
		$conexion = $this->conVen();
		$sql_compras = ibase_query($conexion,$query);

		// $ordenes_local = $this->ordenes_compra_local($fecha,$estado);
		$tabla = "";
		$registros=0;
		$estado ="";
		$general = new generales();
		$arrayDatos=array();
		
		$ordenes_pagadas = $this->ordenes_compra_pagadas($fecha,$estado);
		if (count($ordenes_pagadas) == 0) {
			$arrayDatos["data"]=[];
			return json_encode($arrayDatos);
			exit;
		}

		$requi_igas= $this->requisicion_ordenescompra_folios($fecha,"RQ",$conexion);
		while ($orden_igas= ibase_fetch_assoc($sql_compras)) {
			$clave = "";
			$clave = $orden_igas["SUCURSAL"]."".$orden_igas["SERIE"]."".$orden_igas["FOLIO"];

			if (array_key_exists($clave, $ordenes_pagadas)) {
				$estado = $orden_igas["ESTADO"]."/Pagado";
				
				$fechas= explode(" ", $orden_igas["FECHA"]);
				$odc ="(".$orden_igas["SUCURSAL"].")".$orden_igas["SERIE"]."-".$orden_igas["FOLIO"];

				if (array_key_exists($clave, $requi_igas)) {
					$odc.="/".$requi_igas[$clave];
				}
				$registros++;
				$datos = array(
					"Fecha" =>$general->fecha_bien($fechas[0]),
					"Requisicion"=>$odc,
					"Elaboro" =>$general->reparar_utf8($orden_igas["ELABORO"]),
					"Concepto" =>$general->reparar_utf8($orden_igas["CONCEPTO1"]),
					"Autorizo" =>$general->reparar_utf8($orden_igas["AUTORIZO"]),
					"Total" =>number_format($orden_igas["TOTAL"],2),
					"Estado" =>$estado
				);
				$arrayDatos["data"][]= $datos;

			}
			
		}
		if ($registros > 0) {
			return json_encode($arrayDatos);
		}else{
			$arrayDatos["data"]=[];
			return json_encode($arrayDatos);
		}
		// }else{
		// 	$arrayDatos["datos"]=[];
		// 	return json_encode($arrayDatos);
		// }
	}

	public function rechazar_odc($sucursal,$serie,$folio, $motivo_rechazo,$fechamod)
	{
		session_start();
		(int)$sucursal;
		(int)$folio;
		$general = new generales();
		$conexion_ventas = $this->conVen();
		$conexion_admon = $this->conADMON();
		$conexion_local  = $this->conloc();
		$sql  = "SELECT DISTINCT * FROM DCPRDOCP WHERE SUCURSAL = '$sucursal' AND SERIE = '$serie' AND FOLIO = '$folio' ";
		$odc =  ibase_query($conexion_ventas,$sql);
		$r = ibase_fetch_assoc($odc);
		$suc_req = $r["SUCURSAL_REQU"];
		$serie_req = $r["SERIE_REQU"];
		$folio_req = $r["FOLIO_REQU"];

		$suc_odc = $r["SUCURSAL"];
		$serie_odc =$r["SERIE"];
		$folio_odc = $r["FOLIO"];

		$odc_res = "(".$suc_odc.")-".$serie_odc."-".$folio_odc;

		$sql  = "SELECT  * FROM DINVREQU WHERE SUCURSAL = '$sucursal' AND SERIE = '$serie' AND FOLIO = '$folio' ";
		$da = ibase_query($conexion_ventas,$sql);
		$rd = ibase_fetch_assoc($da);

		$solicito = $rd["ELABORO"];
		$aut=$_SESSION["user"];

		$fechareq = $general->fecha_bd($fechamod);
		// print_r($fechareq);
		$date = date_create();
		$fecha_hora_autoriza = date("d.m.Y");
		date_default_timezone_set("America/Mexico_City");


		$id_usuario_igas = 0;
		$user_igas = $this->datos_usuario($_SESSION["id"]);
		$usuarioIgas = $user_igas["USUARIOIGAS"];
		

		if ($id_usuario_igas != "" || $id_usuario_igas != NULL) {
			$id_usuario_igas = $user_igas["IDUSUARIOIGAS"];
		}
		(int)$id_usuario_igas;
		$tipo_autorizador = $user_igas ["TIPOAUTORIZADOR"];

		$sql  = "SELECT COUNT(*) AS FILAS FROM  COMPRASS";
		$exe = ibase_query($conexion_local,$sql);
		$f =  ibase_fetch_assoc($exe);
		$id = $f["FILAS"] + 1;


		if ($tipo_autorizador == "AUT1COMPRA") {
			$campobd_aut ="AUT1";
			$sql ="INSERT INTO COMPRASS (ID,FECHA,SUCURSAL,SERIE,FOLIO,IMPORTE,SOLICITO,".$campobd_aut.",ESTATUS,FECHA_REQUISICION)
			VALUES  ('$id','$fecha_hora_autoriza','$suc_req','$serie_req','$folio_req',0,'$solicito','$aut','Rechazada','$fechareq')";
		}else{

			$sql  = "SELECT COUNT(*) AS FILAS FROM  COMPRASS WHERE SUCURSAL = '$suc_req' AND SERIE = '$serie_req' AND FOLIO = '$folio_req' ";
			$exe = ibase_query($conexion_local,$sql);
			$f = ibase_fetch_assoc($exe);
			if ($f["FILAS"] > 0) {
				$campobd_aut ="AUT2";
				$sql ="UPDATE COMPRASS  SET AUT2 = '$aut',  FECHA = '$fecha_hora_autoriza',ESTATUS = 'Rechazada', IMPORTE = 0
				WHERE SUCURSAL = '$suc_req' AND SERIE = '$serie_req' AND FOLIO = '$folio_req'";
			}else{
				$sql ="INSERT INTO COMPRASS (ID,FECHA,SUCURSAL,SERIE,FOLIO,IMPORTE,SOLICITO,".$campobd_aut.",ESTATUS,FECHA_REQUISICION)
				VALUES  ('$id','$fecha_hora_autoriza','$suc_req','$serie_req','$folio_req',0,'$solicito','$aut','Rechazada','$fechareq')";
			}

		}
		$sql_local = ibase_query($conexion_local,$sql);
		if (!$sql_local) {
			$array =array("estado"=>"error" ,"odc"=>$odc_res );
			return json_encode($array );
			exit;
		}


		$sql  = "UPDATE DINVREQU SET CANTIDAD_SURTIDA = 0 , CANTIDAD_AUTORIZADA = 0, IMPORTE_COMPRAS = 0, IMPORTE_AUTORIZADO = 0,
		ESTADO =  'Rechazada' , MOTIVO_RECHAZO = '$motivo_rechazo', MOTIVO_CANCELACION = '$motivo_rechazo', AUTORIZO = '$usuarioIgas' 
		WHERE SUCURSAL = '$suc_req' AND SERIE = '$serie_req' AND FOLIO = '$folio_req' ";
		$gen_req = ibase_query($conexion_ventas,$sql);

		if (!$gen_req) {
			$array =array("estado"=>"error" ,"odc"=>$odc_res );
			return json_encode($array );
			exit;
		}

		$sql  = "UPDATE DINVREQUD SET CANTIDAD  = 0,CANTIDAD_AUTORIZADA = 0, ESTADO = 'Rechazada', MOTIVO_RECHAZO = '$motivo_rechazo'
		,CANTIDAD_SURTIDA = 0 WHERE SUCURSAL = '$suc_req' AND SERIE = '$serie_req' AND FOLIO = '$folio_req'  ";
		$detalle_req = ibase_query($conexion_ventas,$sql);
		// print_r(ibase_affected_rows($conexion_ventas));
		if (!$detalle_req) {
			$array =array("estado"=>"error" ,"odc"=>$odc_res );
			return json_encode($array );
			exit;
		}


		// $sql  = "UPDATE DCPROCPR SET CANTIDAD_SURTIDA = 0 , SUBTOTAL = 0 , IVA = 0, TOTAL = 0 , ESTADO ='Cancelada',
		// AUTORIZO = '$usuarioIgas' , IEPS = 0,  IVA_RETENIDO = 0 , ISR_RETENIDO = 0, APLICADO ='No',SURTIDA='No'
		// WHERE SUCURSAL = '$suc_odc' AND SERIE = '$serie_odc' AND FOLIO = '$folio_odc'";

		$sql  = "UPDATE dcprocpr SET SURTIDA = 'No' ,
		CANTIDAD_SURTIDA  = 0,
		APLICADO = 'No' ,
		ESTATUS = 'C'   ,
		ENVIADA = 'No'
		WHERE SUCURSAL = '$suc_odc' AND SERIE = '$serie_odc' AND FOLIO = '$folio_odc'";

		$gen_odc= ibase_query($conexion_ventas,$sql);

		if (!$gen_odc) {
			$array =array("estado"=>"error" ,"odc"=>$odc_res );
			return json_encode($array );
			exit;
		}

		$sql  = "UPDATE DCPRDOCP SET 
		CANTIDAD_SURTIDA  = 0,
		APLICADO = 'No',
		SURTIDA = 'No'   
		WHERE SUCURSAL = '$suc_odc' AND SERIE = '$serie_odc' AND FOLIO = '$folio_odc'";

		$gen_odc= ibase_query($conexion_ventas,$sql);
		if (!$gen_odc) {
			$array =array("estado"=>"error" ,"odc"=>$odc_res );
			return json_encode($array );
			exit;
		}



		$array =array("estado"=>"success" ,"odc"=>$odc_res);
		return json_encode($array );





	}
	public function buscador_producto($producto)
	{

		$gen  = new  generales();
		$sql = "SELECT FIRST 20 * FROM DGENPROD WHERE  DESCRIPCION CONTAINING '$producto' AND ACTIVO  = 'Si' ";
		$cont = 0;
		$arreglo =[];
		$execute  = ibase_query($this->conVen(), $sql);
		while ($pro = ibase_fetch_assoc($execute)) {

			$producto = $pro["CLAVE"]." | ".$gen->reparar_utf8($pro["DESCRIPCION"]);
			array_push($arreglo, $producto);
			$cont++;
		}

		if ($cont > 0) {
			return json_encode($arreglo);

		}else{
			array_push($arreglo, "");
			return json_encode($arreglo);
		}

	}


	public function buscar_proveedor($proveedor)
	{
		$gen = new generales();
		$sql = "SELECT NOPROV, NOMBRE FROM DGENPROV WHERE NOMBRE CONTAINING '$proveedor' AND ACTIVO  = 'Si'";
		$cont = 0;
		$proveedores = [];
		$prov = ibase_query($this->conADMON(),$sql);

		while ($pro = ibase_fetch_assoc($prov)) {
			$proveedor = $pro["NOPROV"]. " | ". $gen->reparar_utf8($pro["NOMBRE"]);
			array_push($proveedores, $proveedor);
			$cont++;
		}
		if ($cont > 0) {
			return json_encode($proveedores);
		}else{
			array_push($proveedores, "");
			return json_encode($proveedores);
		}
	}

	public function busqueda_detallada_proveedor($id_proveedor)
	{
		(int)$id_proveedor;
		$sql = "SELECT NOPROV,NOMBRE,DIRECCION,POBLACION,TELEFONO,EMAIL,CONTACTO,MONEDA,CODIGOPOSTAL,PAIS,TIPO_PERSONA,RFC FROM DGENPROV WHERE NOPROV = '$id_proveedor'";
		$execute  = ibase_query($this->conADMON(),$sql);
		$pro  = ibase_fetch_assoc($execute);
		$gen = new generales();
		$arreglo  = array("nombre" =>$gen->reparar_utf8($pro["NOMBRE"]),
			"direccion" => $gen->reparar_utf8($pro["DIRECCION"]),
			"poblacion" => $gen->reparar_utf8($pro["POBLACION"]),
			"telefono" =>$pro["TELEFONO"],
			"email" => $pro["EMAIL"],
			"contacto" =>$gen->reparar_utf8($pro["CONTACTO"]),
			"moneda" =>$pro["MONEDA"],
			"cp" =>$pro["CODIGOPOSTAL"],
			"pais" => $gen->reparar_utf8($pro["PAIS"]),
			"tipo_persona" =>$gen->reparar_utf8($pro["TIPO_PERSONA"]),
			"rfc" =>$pro["RFC"],
			"id" =>$pro["NOPROV"]
		);
		return json_encode($arreglo);
	}
	public function permisos_igas($id_igas)
	{
		
		$gen = new generales();
		$sucursales_aut =array();
		$monedas = array();
		$departamentos = array();
		$almacenes = array();
		$conex_admon = $this->conADMON();
		$result    = ibase_query($conex_admon,"SELECT VARINI FROM DGENUSUA WHERE CLAVE = '$id_igas'");
		// $execute  = ibase_query( $result);
		$data      = ibase_fetch_object($result);
		$blob_data = ibase_blob_info($data->VARINI);
		$blob_hndl = ibase_blob_open($data->VARINI);
		$blob  =ibase_blob_get($blob_hndl, $blob_data[0]);

		$div_blob = explode("Cpr", $blob); //CprSucu
		$sucursales =[];
		for ($i=0; $i <count($div_blob) ; $i++) { 
			
			$permisos = explode("=", $div_blob[$i]);
			if ($permisos[0] == "Lentr") {
			//if ($permisos[0] == "Sucu") {
				$sucursales = explode(";", $permisos[1]);
				array_pop($sucursales);
			}


		}
		$where_suc = "";
		for ($i=0; $i <count($sucursales) ; $i++) { 
			if ($i == 0) {
				$where_suc.= "suc.CLAVE = ".$sucursales[$i];
			}else{
				$where_suc.= " OR suc.CLAVE = ".$sucursales[$i];
			}

		}

		if ($where_suc == "") {
			//div_contenedor
			print_r("<div class  = 'div_contenedor'><p> No tienes los permisos necesarios para realizar requisiciones u ordenes de compra. Comunique con el departamento de sistemas </p></div>");
			exit;
		}
		$sql = "SELECT suc.clave as CLAVESUC, suc.nombre as SUCURSAL , dep.nombre as DEPARTAMENTO FROM  DGENSUCL  suc
		left join  DGENDEPA dep
		on suc.clave  = dep.sucursal WHERE  ".$where_suc. " ORDER BY suc.CLAVE ASC";
		$result = ibase_query($conex_admon,$sql);

		// $SUC = ibase_fetch_assoc($result);
		while ($r =ibase_fetch_assoc($result)) {
			array_push($sucursales_aut, $r);
					# code...
		}
		
		$sql_monedas= "SELECT * FROM DGENMONE";
		$result = ibase_query($conex_admon,$sql_monedas);
		while ($r=ibase_fetch_assoc($result)) {
			array_push($monedas, $r);
			
		}

		$sqlAlmacen = "SELECT * FROM DINVALMA";
		$resulA = ibase_query($this->conVen(),$sqlAlmacen);
		while ($r= ibase_fetch_assoc($resulA)) {
			array_push($almacenes, $r);
			# code...
		}
		// print_r($almacenes);
		// print_r("*-----------------------------------------\n");
		return $resultados=array("sucursales_dep" => $sucursales_aut, "monedas" => $monedas, "almacenes" => $almacenes , "general" => $gen);
		// ibase_blob_echo();
	}

	
	public function nueva_requisicion($arreglo)
	{
		date_default_timezone_set('America/Merida');
		$mes = date("Y.m");
		$conexionV = $this->conVen();
		$indices =$arreglo["indices"];
		$codigos = $arreglo["codigos"];
		$descripciones = $arreglo["descripciones"];
		$cantidades = $arreglo["cantidades"];
		
		$importes_totales = $arreglo["importes_totales"];
		$depar = $arreglo["empresa"];
		
		
		
		
		$tag = $this->series_locales($depar);

		
		if ($tag["contador"] == 0) {
			$respuesta = array("resultado" => "error",
				"mensaje" => "La empresa seleccionada no tiene una serie asignada");

			return json_encode($respuesta);
			exit;
		}

		$sucursal  = $depar;
		(int)$sucursal;
		$serie = "";
		$proveedor = "";
		$tipo  = $arreglo["tipo"] ;

		if ($arreglo["tipo"] == "orden_pago") {
			$serie = $tag["serie"]."P";
			$datos  = explode("|", $arreglo["proveedor"]);
			$proveedor =$datos[0];
			(int) $proveedor;

		}
		if ($arreglo["tipo"] == "requisicion") {
			$serie = $tag["serie"]."R";
		}
		
		$folio = $this->ultimo_folio($conexionV,$sucursal,$serie);
		$ulti_folio = $folio + 1;
		$departamento  = (int)$arreglo["departamento"];
		$mesbd = str_replace(".","",$mes);
		$fecha = date("Y-m-d")." 00:00";
		$concepto  = $arreglo["concepto"];

		$cantidad = 0;
		

		for ($i=0; $i <count($cantidades) ; $i++) { 
			$cantidad+=floatval($cantidades[$i]);
		}
		
		$cantidad_surtida = 0;
		$cantidad_autorizada = 0;
		$indice =  0;
		$estatus = "A";
		$elaboro =$_SESSION["usuarioigas"];
		$surtida = "No";
		$aplicado = "Si";
		$lugar_entrega = (int)$sucursal;
		$tipo_pedido = 1;
		$urgencia  = (int)$arreglo["urgencia"];
		$dias_entrega = 7;

		(int)$arreglo["afectacion"];
		$afectacion = "";
		
		switch ($arreglo["afectacion"]) {
			case 1:
			$afectacion = "Directo Al Gasto";
			break;
			case 2:
			$afectacion = "Almacen";
			break;
			case 3:
			$afectacion = "Otros";
				# code...
			break;
			
			default:
			$afectacion = "Otros";
			break;
		}

		// if ($arreglo["almacen"]  != "") {
		// 	# code...
		// }
		$campo_almacen  = "";
		$dato_almacen = "";
		$almacen = "";
		// print_r($arreglo["almacen"]);


		switch ($urgencia) {
			case 1:
				# urgencia alto
			$dias_entrega = 1;
			break;
			case 2:
				# urgencia media
			$dias_entrega = 3;
			break;
			case 3:
				# urgencia baja
			$dias_entrega = 7;
			break;
			default:
				# code...
			break;
		}
		$total_importe = 0;
		$precios_estimados = $arreglo["precios_estimados"];

		for ($i=0; $i <count($arreglo["importes_totales"]) ; $i++) { 
			$total_importe += floatval($arreglo["importes_totales"][$i]);
		}

		$fecha_captura = date("Y.m.d")." 00:00";
		$hora_captura = date("H:i");
		$estado = "Nueva";
		$documorigen = "CPR1";
		$moneda = $arreglo["moneda"];

		$importe_compras = 0;
		$importe_autorizado = 0;
		$claveusuario = (int)$_SESSION["idgas"];
		$estado_interno  = "Autorizado";


		$tr=ibase_trans(IBASE_COMMITTED,$conexionV);
		
		
		$indice_detallado = 1;
		// print_r($arreglo["almacen"]);
		if ($arreglo["almacen"] != "sin_almacen") {

			$almacen  = $arreglo["almacen"];
			(int) $almacen;
			$campo_almacen = ",ALMACEN";
			$dato_almacen = " ,'".$almacen."' ";

		}
		$departamento = 1;
		// // print($cantidad);
		$sql = " INSERT INTO DINVREQU (SUCURSAL
		,SERIE
		,FOLIO
		,DEPARTAMENTO
		,MES
		,FECHA
		,CONCEPTO1
		,CANTIDAD
		,CANTIDAD_SURTIDA
		,CANTIDAD_AUTORIZADA
		,INDICE
		,ESTATUS
		,ELABORO
		,SURTIDA
		,APLICADO
		,LUGAR_ENTREGA
		,TIPO_PEDIDO
		,GRADO_URGENCIA
		,DIAS_ENTREGA
		,TIPO_AFECTACION
		".$campo_almacen."
		,IMPORTE_ESTIMADO
		,IMPORTE_COMPRAS
		,IMPORTE_AUTORIZADO
		,FECHA_CAPTURA
		,HORA_CAPTURA
		,ESTADO
		,DOCUMORIGEN
		,MONEDA
		,CLAVEUSUARIO
		,ESTADO_INTERNO
		
		)VALUES (	
		'$sucursal'
		,'$serie'
		,'$ulti_folio'
		,'$departamento'
		,'$mesbd'
		,'$fecha'
		,'$concepto'
		,'$cantidad'
		,'$cantidad_surtida'
		,'$cantidad_autorizada'
		,'$indice'
		,'$estatus'
		,'$elaboro'
		,'$surtida'
		,'$aplicado'
		,'$lugar_entrega'
		,'$tipo_pedido'
		,'$urgencia'
		,'$dias_entrega'
		,'$afectacion'
		".$dato_almacen."
		,'$total_importe'
		,'$importe_compras'
		,'$importe_autorizado'
		,'$fecha_captura'
		,'$hora_captura'
		,'$estado'
		,'$documorigen'
		,'$moneda'
		,'$claveusuario'
		,'$estado_interno')";
		// print_r($sql);
		$insert= ibase_query($tr,$sql);
		$result = ibase_commit($tr);


		if ($result) {
			for ($i=0; $i <count($codigos) ; $i++) { 

				$cantidad_autorizada = 0;
				$registro = $this->nueva_requisicion_detallado($sucursal,$serie,$ulti_folio,$indice_detallado,$departamento,$mesbd,$fecha,$codigos[$i],$cantidades[$i],$surtida,$aplicado,$descripciones[$i],$precios_estimados[$i],$urgencia,$dias_entrega,$cantidad_autorizada,$fecha_captura,$estado,$lugar_entrega,$conexionV,$surtida,$proveedor,$tipo);
				if ($registro === true) {
					$indice_detallado++;
				}
				
			}
		}else{
			$respuesta = array("resultado" => "error"
				, "serie" => $serie
				, "sucursal" => $sucursal 
				, "folio" => $ulti_folio
				, "afectacion" => $afectacion
				, "cantidad" => $cantidad, "mensaje" => "Error al guardar");

			return json_encode($respuesta);
			exit;
		}

		ibase_close($conexionV);


		$respuesta1 = "";
		if (!$result) {
			$respuesta1= "error";
		}else{
			$respuesta1 =  "guardado";
		}
		
		
		$respuesta = array("resultado" => $respuesta1
			, "serie" => $serie
			, "sucursal" => $sucursal 
			, "folio" => $ulti_folio
			, "afectacion" => $afectacion
			, "cantidad" => $cantidad,"mensaje" =>"");

		return json_encode($respuesta);
		
	// return $arreglo["cantidades"];
	}

	public function recepcion_cupones($arreglo)
	{
		date_default_timezone_set('America/Merida');
		$mes = date("Y.m");
		$conexionV = $this->conVen();
		$indices =$arreglo["indices"];
		$codigos = $arreglo["codigos"];
		$descripciones = $arreglo["descripciones"];
		$cantidades = $arreglo["cantidades"];
		
		$importes_totales = $arreglo["importes_totales"];
		$depar = $arreglo["empresa"];
		
		
		
		
		$tag = $this->series_locales($depar);

		
		if ($tag["contador"] == 0) {
			$respuesta = array("resultado" => "error",
				"mensaje" => "La empresa seleccionada no tiene una serie asignada");

			return json_encode($respuesta);
			exit;
		}

		$sucursal  = $depar;
		(int)$sucursal;
		$serie = "";
		$proveedor = "";
		$tipo  = $arreglo["tipo"] ;

		if ($arreglo["tipo"] == "orden_pago") {
			$serie = $tag["serie"]."P";
			$datos  = explode("|", $arreglo["proveedor"]);
			$proveedor =$datos[0];
			(int) $proveedor;

		}
		if ($arreglo["tipo"] == "requisicion") {
			$serie = $tag["serie"]."R";
		}
		
		$folio = $this->ultimo_folio($conexionV,$sucursal,$serie);
		$ulti_folio = $folio + 1;
		$departamento  = (int)$arreglo["departamento"];
		$mesbd = str_replace(".","",$mes);
		$fecha = date("Y-m-d")." 00:00";
		$concepto  = $arreglo["concepto"];

		$cantidad = 0;
		

		for ($i=0; $i <count($cantidades) ; $i++) { 
			$cantidad+=floatval($cantidades[$i]);
		}
		
		$cantidad_surtida = 0;
		$cantidad_autorizada = 0;
		$indice =  0;
		$estatus = "A";
		$elaboro =$_SESSION["usuarioigas"];
		$surtida = "No";
		$aplicado = "Si";
		$lugar_entrega = (int)$sucursal;
		$tipo_pedido = 1;
		$urgencia  = (int)$arreglo["urgencia"];
		$dias_entrega = 7;

		(int)$arreglo["afectacion"];
		$afectacion = "";
		
		switch ($arreglo["afectacion"]) {
			case 1:
			$afectacion = "Directo Al Gasto";
			break;
			case 2:
			$afectacion = "Almacen";
			break;
			case 3:
			$afectacion = "Otros";
				# code...
			break;
			
			default:
			$afectacion = "Otros";
			break;
		}

		// if ($arreglo["almacen"]  != "") {
		// 	# code...
		// }
		$campo_almacen  = "";
		$dato_almacen = "";
		$almacen = "";
		// print_r($arreglo["almacen"]);


		switch ($urgencia) {
			case 1:
				# urgencia alto
			$dias_entrega = 1;
			break;
			case 2:
				# urgencia media
			$dias_entrega = 3;
			break;
			case 3:
				# urgencia baja
			$dias_entrega = 7;
			break;
			default:
				# code...
			break;
		}
		$total_importe = 0;
		$precios_estimados = $arreglo["precios_estimados"];

		for ($i=0; $i <count($arreglo["importes_totales"]) ; $i++) { 
			$total_importe += floatval($arreglo["importes_totales"][$i]);
		}

		$fecha_captura = date("Y.m.d")." 00:00";
		$hora_captura = date("H:i");
		$estado = "Nueva";
		$documorigen = "CPR1";
		$moneda = $arreglo["moneda"];

		$importe_compras = 0;
		$importe_autorizado = 0;
		$claveusuario = (int)$_SESSION["idgas"];
		$estado_interno  = "Autorizado";


		$tr=ibase_trans(IBASE_COMMITTED,$conexionV);
		
		
		$indice_detallado = 1;
		// print_r($arreglo["almacen"]);
		if ($arreglo["almacen"] != "sin_almacen") {

			$almacen  = $arreglo["almacen"];
			(int) $almacen;
			$campo_almacen = ",ALMACEN";
			$dato_almacen = " ,'".$almacen."' ";

		}
		$departamento = 1;
		// // print($cantidad);
		$sql = " INSERT INTO DINVREQU (SUCURSAL
		,SERIE
		,FOLIO
		,DEPARTAMENTO
		,MES
		,FECHA
		,CONCEPTO1
		,CANTIDAD
		,CANTIDAD_SURTIDA
		,CANTIDAD_AUTORIZADA
		,INDICE
		,ESTATUS
		,ELABORO
		,SURTIDA
		,APLICADO
		,LUGAR_ENTREGA
		,TIPO_PEDIDO
		,GRADO_URGENCIA
		,DIAS_ENTREGA
		,TIPO_AFECTACION
		".$campo_almacen."
		,IMPORTE_ESTIMADO
		,IMPORTE_COMPRAS
		,IMPORTE_AUTORIZADO
		,FECHA_CAPTURA
		,HORA_CAPTURA
		,ESTADO
		,DOCUMORIGEN
		,MONEDA
		,CLAVEUSUARIO
		,ESTADO_INTERNO
		
		)VALUES (	
		'$sucursal'
		,'$serie'
		,'$ulti_folio'
		,'$departamento'
		,'$mesbd'
		,'$fecha'
		,'$concepto'
		,'$cantidad'
		,'$cantidad_surtida'
		,'$cantidad_autorizada'
		,'$indice'
		,'$estatus'
		,'$elaboro'
		,'$surtida'
		,'$aplicado'
		,'$lugar_entrega'
		,'$tipo_pedido'
		,'$urgencia'
		,'$dias_entrega'
		,'$afectacion'
		".$dato_almacen."
		,'$total_importe'
		,'$importe_compras'
		,'$importe_autorizado'
		,'$fecha_captura'
		,'$hora_captura'
		,'$estado'
		,'$documorigen'
		,'$moneda'
		,'$claveusuario'
		,'$estado_interno')";
		// print_r($sql);
		$insert= ibase_query($tr,$sql);
		$result = ibase_commit($tr);


		if ($result) {
			for ($i=0; $i <count($codigos) ; $i++) { 

				$cantidad_autorizada = 0;
				$registro = $this->recepcion_cupones_detallado($sucursal,$serie,$ulti_folio,$indice_detallado,$departamento,$mesbd,$fecha,$codigos[$i],$cantidades[$i],$surtida,$aplicado,$descripciones[$i],$precios_estimados[$i],$urgencia,$dias_entrega,$cantidad_autorizada,$fecha_captura,$estado,$lugar_entrega,$conexionV,$surtida,$proveedor,$tipo);
				if ($registro === true) {
					$indice_detallado++;
				}
				
			}
		}else{
			$respuesta = array("resultado" => "error"
				, "serie" => $serie
				, "sucursal" => $sucursal 
				, "folio" => $ulti_folio
				, "afectacion" => $afectacion
				, "cantidad" => $cantidad, "mensaje" => "Error al guardar");

			return json_encode($respuesta);
			exit;
		}

		ibase_close($conexionV);


		$respuesta1 = "";
		if (!$result) {
			$respuesta1= "error";
		}else{
			$respuesta1 =  "guardado";
		}
		
		
		$respuesta = array("resultado" => $respuesta1
			, "serie" => $serie
			, "sucursal" => $sucursal 
			, "folio" => $ulti_folio
			, "afectacion" => $afectacion
			, "cantidad" => $cantidad,"mensaje" =>"");

		return json_encode($respuesta);
		
	// return $arreglo["cantidades"];
	}



	public function series_locales($id_suc_igas)
	{
		(int)$id_suc_igas;
		$cont = 0;
		$serie = "";
		$sql = "SELECT * FROM SUCURSALES_IGAS WHERE CLAVE_SUC_IGAS = '$id_suc_igas'";
		$execute  = ibase_query($this->conloc(),$sql);
		while ($suc  = ibase_fetch_assoc($execute)) {
			$cont++;
			$serie = $suc["SERIE"];
		}
		$respuesta  = array("contador"=> $cont, "serie" =>$serie);
		return $respuesta;
	}
	public function ultimo_folio($conexion,$sucursal,$serie)
	{
		(int)$sucursal;
		$sql = "SELECT COUNT(*) AS FOLIOMAX  FROM DINVREQU WHERE SUCURSAL = '$sucursal' AND SERIE  = '$serie'";
		$execute  = ibase_query($conexion,$sql);
		$folio = ibase_fetch_assoc($execute);

		return $folio["FOLIOMAX"];
	}

	public function checar($sucursal,$serie,$folio,$afectacion,$cantidad)
	{
		(int)$sucursal;
		(int)$folio;
		floatval($cantidad);

		$conexion  = $this->conVen();
		$checar  = "SELECT COUNT(*) AS EXISTE FROM DINVREQU  WHERE SUCURSAL = '$sucursal'  and SERIE = '$serie'  and FOLIO = '$folio'";
			// sleep(3);
		$DATO  = ibase_query($conexion,$checar);
		$existe  = ibase_fetch_assoc($DATO);

		$sql  = "UPDATE DINVREQU SET APLICADO  = 'Si' WHERE SUCURSAL = '$sucursal' and FOLIO = '$folio' and SERIE = '$serie'";
		$updateaplicado= ibase_query($conexion,$sql);


		$sql1  = "UPDATE DINVREQU SET  CANTIDAD = '$cantidad', TIPO_AFECTACION = '$afectacion',ESTATUS = 'A' WHERE SUCURSAL = '$sucursal' and FOLIO = '$folio' and SERIE = '$serie'";
		
		$update_cantidad= ibase_query($conexion,$sql1);



		$resultado =array();
		if ($updateaplicado  > 0  && $update_cantidad > 0 ) {
			$resultados =["resultado" => "actualizado"];
			return json_encode($resultados);
		}else{
			$resultados =["resultado" => "error"];
			return json_encode($resultados);
		}
	}

	public function nueva_requisicion_detallado($sucursal,$serie,$folio,$indice,$departamento,$mes,$fecha,$codigo,$cantidad,$surtido,$aplicado,$descripcion,$precio,$urgencia,$dias_entrega,$cantidad_autorizada,$fecha_captura,$estado,$lugar_entrega,$conexion,$surtida,$proveedor,$tipo)
	{
		$fecha1 = date("Y-m-d");
		floatval($cantidad);
		$trDetallado=ibase_trans(IBASE_COMMITTED,$conexion);
		$origen ="Otros";
		$cuenta_contable = null;


		$buscar_pro = "SELECT UNIDAD,MARCA FROM DGENPROD WHERE CLAVE  = '$codigo'";
		$producto  = ibase_query($conexion,$buscar_pro);
		$pro = ibase_fetch_assoc($producto);
		$marca  =  (int) $pro["MARCA"];
		$unidad = $pro["UNIDAD"];

		$campo_prov = "";
		$dato_prov = "";
		if ($tipo == "orden_pago") {
			$campo_prov = ",PROVEEDOR";
			$dato_prov = ", '".$proveedor."'";
		}
		// print_r($campo_prov);
		// print_r($dato_prov);

		$sql = "INSERT INTO DINVREQUD (SUCURSAL
		,SERIE
		,FOLIO
		,INDICE
		,DEPARTAMENTO
		,PRODUCTO
		,CANTIDAD
		,CANTIDAD_SURTIDA
		,SURTIDA
		,APLICADO
		,REGISTRO
		,DESCRIP_PRODUCTO
		,UNIDAD_PROD
		,MARCA_PROD
		,PRECIO_ESTIMADO
		,GRADO_URGENCIA
		,DIAS_ENTREGA
		,CANTIDAD_AUTORIZADA
		,FECHA_COMPRAS
		,ESTADO
		,ORIGEN_PRECIO
		,LUGAR_ENTREGA
		,CUENTA_CONTABLE
		,  MES
		,FECHA
		".$campo_prov.") 
		VALUES 
		('$sucursal'
		,'$serie'
		,'$folio'
		,'$indice'
		,'$departamento'
		,'$codigo'
		,'$cantidad'
		,0
		,'$surtida'
		,'$aplicado'
		,'$indice'
		,'$descripcion'
		,'$unidad'
		,'$marca'
		,'$precio'
		,'$urgencia'
		,'$dias_entrega'
		,'$cantidad_autorizada'
		,'$fecha_captura'
		,'$estado'
		,'$origen'
		,'$lugar_entrega'
		,'$cuenta_contable'
		,'$mes'
		,'$fecha1'
		".$dato_prov.")";

		// print_r($sql);
		$insert= ibase_query($trDetallado,$sql);
		$result = ibase_commit($trDetallado);
		if ($insert > 0) {
			// print_r("guarde");
			return true;
		}
	}

	public function recepcion_cupones_detallado($sucursal,$serie,$folio,$indice,$departamento,$mes,$fecha,$codigo,$cantidad,$surtido,$aplicado,$descripcion,$precio,$urgencia,$dias_entrega,$cantidad_autorizada,$fecha_captura,$estado,$lugar_entrega,$conexion,$surtida,$proveedor,$tipo)
	{
		$fecha1 = date("Y-m-d");
		floatval($cantidad);
		$trDetallado=ibase_trans(IBASE_COMMITTED,$conexion);
		$origen ="Otros";
		$cuenta_contable = null;


		$buscar_pro = "SELECT UNIDAD,MARCA FROM DGENPROD WHERE CLAVE  = '$codigo'";
		$producto  = ibase_query($conexion,$buscar_pro);
		$pro = ibase_fetch_assoc($producto);
		$marca  =  (int) $pro["MARCA"];
		$unidad = $pro["UNIDAD"];

		$campo_prov = "";
		$dato_prov = "";
		if ($tipo == "orden_pago") {
			$campo_prov = ",PROVEEDOR";
			$dato_prov = ", '".$proveedor."'";
		}
		// print_r($campo_prov);
		// print_r($dato_prov);

		$sql = "INSERT INTO DINVREQUD (SUCURSAL
		,SERIE
		,FOLIO
		,INDICE
		,DEPARTAMENTO
		,PRODUCTO
		,CANTIDAD
		,CANTIDAD_SURTIDA
		,SURTIDA
		,APLICADO
		,REGISTRO
		,DESCRIP_PRODUCTO
		,UNIDAD_PROD
		,MARCA_PROD
		,PRECIO_ESTIMADO
		,GRADO_URGENCIA
		,DIAS_ENTREGA
		,CANTIDAD_AUTORIZADA
		,FECHA_COMPRAS
		,ESTADO
		,ORIGEN_PRECIO
		,LUGAR_ENTREGA
		,CUENTA_CONTABLE
		,  MES
		,FECHA
		".$campo_prov.") 
		VALUES 
		('$sucursal'
		,'$serie'
		,'$folio'
		,'$indice'
		,'$departamento'
		,'$codigo'
		,'$cantidad'
		,0
		,'$surtida'
		,'$aplicado'
		,'$indice'
		,'$descripcion'
		,'$unidad'
		,'$marca'
		,'$precio'
		,'$urgencia'
		,'$dias_entrega'
		,'$cantidad_autorizada'
		,'$fecha_captura'
		,'$estado'
		,'$origen'
		,'$lugar_entrega'
		,'$cuenta_contable'
		,'$mes'
		,'$fecha1'
		".$dato_prov.")";

		// print_r($sql);
		$insert= ibase_query($trDetallado,$sql);
		$result = ibase_commit($trDetallado);
		if ($insert > 0) {
			// print_r("guarde");
			return true;
		}
	}



	public function url_documento($codigo)
	{
		$conexion  = $this->conloc();
		$d  = explode("-", $codigo);
		$sucursal = (int) $d[1];
		$serie = $d[2];
		$folio = (int) $d[3];
		$cont= 0;

		
		$sql = "SELECT URL FROM ORDENES_PAGO WHERE SUCURSAL  = '$sucursal' AND SERIE ='$serie' AND FOLIO = '$folio' ";
		$exe = ibase_query($conexion, $sql);
		while ($dato  = ibase_fetch_assoc($exe)) {
			$cont++;
			$url = $dato["URL"];
		}
		// print_r($cont);
		if ($cont > 0) {
			
			$res = array("url"=> $url);
			return json_encode($res);
		}else{
			$res = array("url"=> "sin_url");
			return json_encode($res);
		}
		
	}

	public function permisos_crear_documentos($id_usuario)
	{
		(int)$id_usuario;
		$contador = 0;
		$permisos =array();
		$sql ="SELECT * FROM PERMISOS_USUARIOS  WHERE PERMISO IN ('ADDREQUISICION','ADDORDENCOM') AND IDUSUARIO = '$id_usuario'";
		$resultado  = ibase_query($this->conloc(),$sql);
		while ($r=ibase_fetch_assoc($resultado)) {
			$da = array("PERMISO"=>$r["PERMISO"], "NOMBRE_PERMISO"=>ucfirst(strtolower($r["NOMBRE_PERMISO"])) );
			array_push($permisos, $da);
			$contador++;
		}
		if ($contador > 0 ) {
			$resul  = array("estado"=>"success","permisos"=>$permisos);
			return json_encode($resul);
		}else{
			$resul  = array("estado"=>"error","permisos"=>$permisos);
			return json_encode($resul);
		}
	}



	public function detallado_cotizacion($sucursal,$serie,$folio)
	{
		$general = new generales();
		$sql = "SELECT * FROM DINVREQUD WHERE SUCURSAL  = '$sucursal' AND SERIE = '$serie' AND FOLIO  = '$folio' order by indice asc";
		$exe  = ibase_query($this->conVen(),$sql);
		$arrayDatos  = array();


		$sql = "SELECT NOPROV, NOMBRE FROM DGENPROV";
		$cont = 0;
		$proveedores = [];
		$prov = ibase_query($this->conADMON(),$sql);
		while ($p = ibase_fetch_assoc($prov)) {
			$proveedores[$p["NOPROV"]] =  $p["NOPROV"]."|".$p["NOMBRE"];
		}

		$contador=0;
		while ($row = ibase_fetch_assoc($exe)) {
			if (array_key_exists($row["PROVEEDOR"], $proveedores)) {
				$provee = $general->reparar_utf8($proveedores[$row["PROVEEDOR"]]);
			}else{
				$provee ="S/P";
			}
			$tabla = "";
			$aux = $contador + 1;
			$numero_aleatorio = mt_rand(0,5000) * $aux;
			$url  = '../webCompras/busqueda.php';
			$opcion_metodo ='buscarProveedor';
			$id_input  = $numero_aleatorio;
			$onclick = "onclick=buscador_autocompletar('".$id_input."','".$url."','".$opcion_metodo."')";

			$oninput="oninput=calculo_real_req('".$id_input."','canti_pro_cot','precio_pro_cot')";
			$cantidad_prod =  "<input   ".$oninput."   type='text' class='form-control text-center ' 
			name='cantidad_cot[]' id='canti_pro_cot".$id_input."' value='".$row["CANTIDAD"]."' >";
			
			$oninput="oninput=calculo_real_req('".$id_input."','precio_pro_cot','canti_pro_cot')";
			$precio_prod =  "<input   ".$oninput."   type='text' class='form-control text-center 
			' name='precio_cot[]' id='precio_pro_cot".$id_input."' value='".$row["PRECIO_ESTIMADO"]."' >";

			$importes_prod_cot =  "<input  disabled=''  type='text' class='form-control text-center 
			' name='importes_cot[]' id='importes".$id_input."' value='".$row["CANTIDAD"]*$row["PRECIO_ESTIMADO"]."' >";

			$input_provee =  "<input   ".$onclick."   type='text' class='form-control' name='proveedor_cot[]' id='".$id_input."' value='".$provee."' style='font-size:10px;width:100%'>";
			$datos = array(
				"index"=>$row["INDICE"]
				,"producto"=>$general->reparar_utf8($row["DESCRIP_PRODUCTO"])
				,"total"=>$importes_prod_cot
				,"cantidad"=>$cantidad_prod
				,"precio"=>$precio_prod
				,"proveedor"=>$input_provee);
			$arrayDatos["data"][]=$datos;
			$contador++;
		}
		if ($contador > 0) {
			return json_encode($arrayDatos);
		}else{
			$arrayDatos["data"] = [];
			return json_encode($arrayDatos);
		}
	}


	public function validar_cotizacion($datos,$requisicion)
	{

		// print_r($datos);
		// exit;
		$da_req  =  explode("-",$requisicion);
		$sucursal =  $da_req[1];
		$serie = $da_req[2];
		$folio  = $da_req[3];
		$respuesta  = [];
		$conexion_admon  = $this->conADMON();
		$conexion_ventas = $this->conVen2();
		$array_precios  = $datos[2];
		$array_proveedores =  $datos[4];
		$where_sql = "WHERE SUCURSAL = '$sucursal' AND SERIE = '$serie' AND FOLIO ='$folio'";

		$sql =  "SELECT * FROM DINVREQU ".$where_sql;
		$exe  =  ibase_query($conexion_ventas,$sql);
		$row  = ibase_fetch_assoc($exe);
		$estado_ori =$row["ESTADO"];
		$estado_ori_detallado =  "";
		// print_r($estado_ori_detallado);

		$sql  = "SELECT * FROM DINVREQUD ".$where_sql." order by INDICE asc";
		$val_prov =  0;
		$val_precio = 0;
		$suma_total = 0;
		$cantidad_total  = 0 ;
		$estado_ori_deta = 0;
		$actualizados=0;
		$x = 0;
		$filas=array();
		$exex  = ibase_query($conexion_ventas,$sql);
		
		
		while ($row =  ibase_fetch_assoc($exex)) {


			$bandera_precio =  false;
			$bandera_proveedor = false;
			$estado_ori_deta  = $row["ESTADO"];
			$importes  =  $datos[0][$x];
			$cantidad = (int)$datos[1][$x];
			$precio = floatval($datos[2][$x]);
			$proveedor =$datos[3][$x];
			$indice  = $datos[5][$x];
			$id_prove = "";
			$suma_total  +=$precio;
			$cantidad_total += $cantidad;  
			$precio  = floatval($precio);
			if ($precio > 0) {
				$val_precio++;
				$bandera_precio = true;

			}



			if ($proveedor != "S/P" && $proveedor != "") {
					// print($proveedor);
				if (strpos($proveedor,"|") !== false) {
					$dat = explode("|",$proveedor);
					$id_pro =  (int)$dat[0];
					$id_prove =  ", PROVEEDOR = '".$id_pro."' ";
					$proveedor = $dat[1];
					$val_prov++;
					$bandera_proveedor = true;


				}
			}

			if ($bandera_precio === true && $bandera_proveedor === true) {
				array_push($filas, "FILA ".$x);
			}

				//actualizando precios, cantidad y proveedor

			$sql  = "UPDATE DINVREQUD SET CANTIDAD  = '$cantidad'
			, PRECIO_ESTIMADO  = '$precio' ".$id_prove." ".$where_sql. " AND INDICE  = '$indice' ";
			
			$exe = ibase_query($conexion_ventas,$sql);
			if ($exe > 0) {
				$actualizados++;
			}
			$estado_ori_detallado = $row["ESTADO"];
			$x++;



		}

		$respuesta  = array();
		$filas_completas = count($filas);
		$estado  = "";
		$estado_d = "";
		//*
		if ($filas_completas == 0) {
			$estado  = "Pendiente de Cotizar";
			$estado_d  = "Pendiente de Cotizar";
			$mensaje = "<p>La requisición <span class = 'btn btn-link' style='font-weight:bold'>(".$sucursal.")-".$serie."-".$folio."</span></p> 
			<p> Ha cambiado de  <span style = 'font-weight:bold'> ".$estado_ori." </span> a <span style = 'font-weight:bold'>".$estado."</span> , por no tener ningun proveedor y precio asignado </p>   ";
			$respuesta = ["estado" =>"warning", "mensaje" =>$mensaje ];

		}
		elseif ( $filas_completas > 0 &&  $filas_completas < count($array_precios) ) {
			$estado  = "Solicitando Precios";
			$estado_d  = "Solicitando Precios";
			$mensaje = "<p>La requisición <span class = 'btn btn-link' style='font-weight:bold'>(".$sucursal.")-".$serie."-".$folio."</span></p> 
			<p>Ha cambiado de  <span style = 'font-weight:bold'> ".$estado_ori." </span>   a <span style = 'font-weight:bold'>".$estado."</span> , por no tener todos proveedores y precios asignado  </p> ";
			$respuesta = ["estado" =>"warning", "mensaje" =>$mensaje ];

		}
		elseif ( $filas_completas == count($array_precios) ) {
			$estado  = "Pendiente de Autorizar";
			$estado_d  = "Pendiente de Autorizar";
			$mensaje = "<p>La requisición <span class = 'btn btn-link' style='font-weight:bold'>(".$sucursal.")-".$serie."-".$folio."</span></p> 
			<p> Ha cambiado de <span style = 'font-weight:bold'> ".$estado_ori." </span>   a <span style = 'font-weight:bold'>".$estado."</span></p> ";
			$respuesta = ["estado" =>"warning", "mensaje" =>$mensaje ];
		}else{
			$estado = $estado_ori;
			$estado_d  = $estado_ori;
			$mensaje = "<p>La requisición <span class = 'btn btn-link' style='font-weight:bold'>(".$sucursal.")-".$serie."-".$folio."</span></p> 
			<p> Se ha quedado  en <span style = 'font-weight:bold'> ".$estado_ori." </span>   ";
			$respuesta = ["estado" =>"warning", "mensaje" =>$mensaje ];

		}

			//6.18.2. Listas de elementos con badges
			// print_r($filas);
		$sql  ="UPDATE DINVREQU SET CANTIDAD = '$cantidad_total', IMPORTE_ESTIMADO  = '$suma_total', ESTADO  = '$estado'  " .$where_sql;
		$exe1  = ibase_query($conexion_ventas,$sql);

		$exe2 = 1;
		if ($estado_d != "Pendiente de Cotizar") {
			for ($i=0; $i <count($datos[5]) ; $i++) { 
				$indice  = (int)$datos[5][$i];
				$sql  = "UPDATE DINVREQUD SET ESTADO  = '$estado_d', CANTIDAD_SURTIDA = 0 ".$where_sql."  AND INDICE  = '$indice' ";
				$exe2 = ibase_query($conexion_ventas,$sql);

			}
		}
		



		if ($exe1 == 0 && $exe2 == 0) {
			$estado  = "Pendiente de Autorizar";
			$mensaje = "<p>La requisición <span class = 'btn btn-link' style='font-weight:bold'>(".$sucursal.")-".$serie."-".$folio."</span></p> 
			<p> no se pudo cambiar de estado. Intente mas tarde</p>";
			$respuesta = ["estado" =>"warning", "mensaje" =>$mensaje ];
		}
		return json_encode($respuesta);
		


	}


	public function guardar_producto_proveedor($datos)
	{
		$conexion_ventas = $this->conVen2();
		$sucursal = $datos["sucursal"];
		$serie = $datos["serie"];
		$folio  = $datos["folio"];
		$productos  = $datos["indices"];
		$prove = explode("|", $datos["proveedor"]);
		$nom_proveedor = $prove[1];
		$contador = 0;
		$id_proveedor = (int) $prove[0];
		for ($i=0; $i < count($productos); $i++) { 
			$indice  = $productos[$i];
			$sql  = "UPDATE DINVREQUD SET PROVEEDOR = '$id_proveedor' WHERE SUCURSAL = '$sucursal' AND SERIE = '$serie'
			AND FOLIO  = '$folio'  AND INDICE  = '$indice' ";
			$exe  = ibase_query($conexion_ventas,$sql);
			if ($exe) {
				$contador++;
			}
		}
		$this->crear_excel($datos,$conexion_ventas);
		if ($contador == count($productos)) {
			$arreglo = ["estado"=>"success","mensaje"=>"<p>Los productos seleccionados han sido asignados al proveedor <strong>".$nom_proveedor."</strong></p>"];
			return json_encode($arreglo);
		}elseif ($contador > 0  && $contador < count($productos)) {
			$arreglo = ["estado"=>"warning","mensaje"=>"<p>Algunos productos de los seleccionados no pudieron ser  asignados al proveedor <strong>".$nom_proveedor."</strong></p>"];
			return json_encode($arreglo);
		}else{
			$arreglo = ["estado"=>"error","mensaje"=>"<p>Los productos seleccionados no pudieron ser  asignados al proveedor <strong>".$nom_proveedor."</strong></p>"];
			return json_encode($arreglo);
		}
		// return $datos["proveedor"];
	}

	public function back_to_origin($datos,$estado_detallado, $estado_general)
	{
		# code...
	}

	public function crear_excel($datos,$conexion_ventas)
	{

		$conexion_local  = $this->conloc();
		$conexion_admon = $this->conADMON();
		$gen = new generales();
		$p_asignar = "EJEMPLODECOTIZACIONPROVEEDOR";
		$sql = "SELECT * FROM DINVREQU WHERE SUCURSAL = '".$datos["sucursal"]."' AND SERIE = '".$datos["serie"]."' AND FOLIO = '".$datos["folio"]."' ";

		date_default_timezone_set('UTC');
		date_default_timezone_set("America/Mexico_City");
		$exe = ibase_query($conexion_ventas,$sql);
		$da_general = ibase_fetch_assoc($exe);
		$concepto  = $da_general["CONCEPTO1"];
		$elaboro = $da_general["ELABORO"];

		$sql  = "SELECT * FROM SUCURSALES_IGAS WHERE CLAVE_SUC_IGAS = '".$datos["sucursal"]."'";
		$exe = ibase_query($conexion_local,$sql);
		$datos_sucursal  = ibase_fetch_assoc($exe);


		$p = explode("|", $datos["proveedor"]);
		$id_proveedor = $p[0];
		$sql = "SELECT * FROM DGENPROV WHERE NOPROV = '".$id_proveedor."' ";
		$exe = ibase_query($conexion_admon,$sql);
		$datos_provee = ibase_fetch_assoc($exe);


		$sql = "SELECT * FROM DINVREQUD WHERE SUCURSAL = '".$datos["sucursal"]."' AND SERIE = '".$datos["serie"]."' AND FOLIO = '".$datos["folio"]."' order by INDICE ASC";
		$exe  = ibase_query($conexion_ventas,$sql);
		$prod_detallado =array();
		$c= 0;
		while ($f = ibase_fetch_assoc($exe)) {
			$prod_detallado[$c] = $f;
			$c++;
		}
		require_once '../../../PHPExcel/Classes/PHPExcel.php';
		require_once ('../../../PHPMailer/src/PHPMailer.php');
		require("../../../PHPMailer/src/SMTP.php");
		require("../../../PHPMailer/src/Exception.php");

		$por_hoja = 10;
		$ope2 = count($datos["indices"]) % $por_hoja;
		$sheets=0;
		

		if($ope2 != 0)
		{
			$ope = count($datos["indices"]) / $por_hoja;
			$res = explode(".",$ope);
			$sheets = $res[0]+ 1;

		}else{
			$sheets = count($datos["indices"]) / $por_hoja;

		}
		$objPHPExcel = new PHPExcel();
		$objReader = PHPExcel_IOFactory::createReader("Excel2007");
		$objPHPExcel = $objReader->load('../webCompras/cotizacion.xlsx');
		$contador = 0;
		$hoy = date("H:i:s"); 
		$div_productos=array_chunk($prod_detallado, $por_hoja);
		$suma_total = 0;
		for ($y=0; $y <$sheets ; $y++) { 

			$paginas =$contador." de ".$sheets;
			$objHoja = $objPHPExcel->getSheet($y);
			$objHoja->setTitle("Hoja".$contador); //Establecer nombre 
			echo "<h1>hola</h1>";


			$objHoja->setCellValue('E1', $datos_sucursal["RAZON_SOCIAL"]);
			$objHoja->setCellValue('E2', $datos_sucursal["DIRECCION"]);
			$objHoja->setCellValue('F3', $hoy);
			$objHoja->setCellValue('F4', $datos_sucursal["TELEFONOS"]);
			$objHoja->setCellValue('F5', $datos_sucursal["CORREO"]);
			$objHoja->setCellValue('F6', $datos_provee["NOMBRE"]);
			$objHoja->setCellValue('F7', $datos_provee["DIRECCION"]);
			$objHoja->setCellValue('F8', $datos_provee["POBLACION"]);
			$objHoja->setCellValue('F9', $datos_provee["RFC"]);
			$c_fila  = 13;
			for ($i=0; $i < count($div_productos[$y]); $i++) { 
				$indice = $div_productos[$y][$i]["INDICE"];
				$producto  = $div_productos[$y][$i]["DESCRIP_PRODUCTO"];
				$cantidad = $div_productos[$y][$i]["CANTIDAD"];
				$precio  = $div_productos[$y][$i]["PRECIO_ESTIMADO"];
				$importe = $cantidad * $precio;
				$c_fila = $c_fila + $i;

				if(!mb_detect_encoding($producto,"UTF-8",true)){
					$producto = utf8_encode($producto);
				}else{
					$producto=$producto;
				}
				$objHoja->setCellValue('A'.$c_fila, $indice);
				$objHoja->setCellValue('B'.$c_fila, $producto);
				$objHoja->setCellValue('J'.$c_fila, $cantidad);
				$objHoja->setCellValue('L'.$c_fila, $precio);
				$objHoja->setCellValue('N'.$c_fila, $importe);
				$suma_total+=$importe;

			}
		// validamos si es el ultimo
			$v =  $sheets - 1;
			if ($v == $y) {
				$cantidad_en_letras = $gen->numtoletras($suma_total);
				$objHoja->setCellValue('A38', "Total con letras:");
				$objHoja->setCellValue('E38', $cantidad_en_letras);
				$objHoja->setCellValue('L38', "Total:");
				$objHoja->setCellValue('N38', number_format($suma_total,2));
			}


		}
		// $hojas_en_excel = 8;
		//     $para_for=$hojas_en_excel - $sheets;  //6

		//     if($para_for > 0):

		//     	for ($i=0; $i <$para_for; $i++) { 
		//     		$sh = $i + $sheets;
		//     		$objPHPExcel->setActiveSheetIndexByName('Hoja'.$sh);
		//     		$sheetIndex = $objPHPExcel->getActiveSheetIndex();
		//     		$objPHPExcel->removeSheetByIndex($sheetIndex);


		//     	}
		//     endif;

		    $archivo =$p_asignar." ".$hoy;

		    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		    header('Content-Disposition: attachment;filename="'.$archivo.'.xlsx"');
		    header('Cache-Control: max-age=0');

		    // $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
		    // $objWriter->save('php://output');
		    

		    $objwriter = PHPExcel_IOFactory::createWriter($objPHPExcel,"Excel2007");
		    // $objwriter->save('php://output');
		    $objwriter->save('Pictures/'.$archivo.'.xlsx');



		}

	}


	?>


