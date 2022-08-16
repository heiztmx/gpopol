<?php 


/**
 * 
 */
include '../../cartera/metGASOLINERA/metodosGASOLINERA.php'; 
class productos 
{
	
	public function conexionlocal()
	{
		$objeto = new conexion();
		$conexion =$objeto->conectar();
		return $conexion;
	}
	public function conexionGas()
	{
		$objeto = new conexionGAS();
		$conexion = $objeto->conectarGAS();
		return $conexion;
	}
	public function conexionVentas()
	{
		$objeto = new conexionADMON();
		$conexion = $objeto->conectarADMON();
		return $conexion;
	}

	public function conexionAdmon($value='')
	{
		$objeto  = new conexionADMON();
		$conexion = $objeto->conectarADM();
		return $conexion;
	}

	public function find_by($tabla,$campo, $id,$conexion)
	{
		$sql  = "SELECT * FROM  ".$tabla." WHERE ".$campo." = '$id' ";
		$exe = ibase_query($conexion,$sql);
		$datos  = ibase_fetch_assoc($exe);

		return $datos;
	}

	public function estaciones()
	{
		$sql ="SELECT * FROM ESTACIONES";
		$estacion = ibase_query($this->conexionlocal(),$sql);
		$estaciones = array();
		while ($est = ibase_fetch_assoc($estacion)) {
			array_push($estaciones, $est);
		}
		return $estaciones;
	}

	public function productosxestacion($estacion)
	{
		if ($estacion  != "opcion") {
			
			
			$precios = $this->preciosproductos($estacion);
			(int)$estacion;
			$sql ="SELECT * FROM DGASPROD WHERE ESTACION = '$estacion'";
			$productos = ibase_query($this->conexionGAS(),$sql);
			$cont=0;
			$array_prod = array();
			$estaciones = $this->estaciones();
			$nombre_estacion = "";
			while ($pro= ibase_fetch_assoc($productos)) {
				$cadena ="";
				
				for ($i=0; $i <count($estaciones) ; $i++) { 
					if ($estaciones[$i]["ID"] == $pro["ESTACION"]) {
						$nombre_estacion= $estaciones[$i]["ESTACION"];
						// print_r($pro);
						// break;
					}
				}
				
				$descripcion = str_replace(" ", ".", $pro["DESCRIPCION"]);
				if (array_key_exists($pro["CLAVE"],$precios)) {
					$precio_producto_cadena =$precios[$pro["CLAVE"]];
					$precio_producto = "$ ".number_format($precios[$pro["CLAVE"]],2,'.',',') ;
				}else{
					$precio_producto_cadena = "Sin_precio";
					$cadena_linea  = $pro["CLAVE"]."||".$descripcion."||".$precio_producto_cadena."||".$pro["CODIGO_BARRA"]."||".$pro["ACTIVO"]."||".$pro["LINEA"]."||".$nombre_estacion."||".$pro["ESTACION"];
					// $onclick = "onclick = asignar_precio('".$cadena_linea."')  ";
					$precio_producto = "<a  style='color:red;'>Sin precio asignado</a>" ;
				}
				 $cadena  = $pro["CLAVE"]."||".$descripcion."||".$precio_producto_cadena."||".$pro["CODIGO_BARRA"]."||".$pro["ACTIVO"]."||".$pro["LINEA"]."||".$nombre_estacion."||".$pro["ESTACION"];
				// $array=array();
				// array_push($array, $pro);
				// exit;
				$datos= array("id"=> $pro["CLAVE"],
					"producto" =>$pro["DESCRIPCION"],
					"unidad" =>$pro["UNIDAD"],
					"precio" => $precio_producto
					,"barras" =>$pro["CODIGO_BARRA"],
					"activo" =>$pro["ACTIVO"],
					"linea" =>$pro["LINEA"],
					"estacion" =>$nombre_estacion,
					"todos" =>$cadena);
				$array_prod["data"][] =$datos;
				$cont++;

			}
			if($cont > 0){
				return json_encode($array_prod);


			}else{
				$array_prod["data"] = [];
				return json_encode($array_prod);
			}
		}else{
			$array_prod["data"] = [];
			return json_encode($array_prod);
		}
	}


	public function preciosproductos($estacion)
	{
		$sql = "SELECT * FROM DGASPREAEST WHERE  ESTACION  = '$estacion'";
		$execute = ibase_query($this->conexionGAS(),$sql);
		$precios = array();
		while ($pre = ibase_fetch_assoc($execute)) {
			$precios[$pre["PRODUCTO"]] = $pre["PRECIO"];
		}
		ibase_free_result($execute); 
		ibase_close($this->conexionGAS());
		return $precios;
	}



	public function modificar_productos($estacion,$nombre,$barras,$estado,$linea,$id_estacion,$clave)
	{
		$update ="UPDATE DGASPROD SET  DESCRIPCION = '$nombre', CODIGO_BARRA = '$barras' , ACTIVO ='$estado',LINEA = '$linea' ,ESTACION = '$estacion' WHERE CLAVE  = '$clave' AND ESTACION = '$id_estacion' ";
		$execute  = ibase_query($this->conexionGas(),$update);
		if ($execute) {
			
			return  "actualizado";

		}else{
			return  "error";
		}
	}
	public function activar_producto($clave,$id_estacion,$estado)
	{
		$update ="UPDATE DGASPROD SET   ACTIVO = '$estado' WHERE CLAVE  = '$clave' AND ESTACION = '$id_estacion' ";
		$execute  = ibase_query($this->conexionGas(),$update);
		$respuesta  = array();

		if ($execute) {
			$loquesemando = "Desactivado";
			if ($estado == "Si") {
				$loquesemando = "Activado";
			}
			$respuesta  = ["estatus"=>"success","mensaje"=>"El producto fue ".$loquesemando." exitosamente"];
		}else{
			$loquesemando = "Desactivar";
			if ($estado == "Si") {
				$loquesemando = "Activar";
			}
			$respuesta = ["estatus"=>"success","mensaje"=>"El producto no se logro  ".$loquesemando];
		}
		return json_encode($respuesta);
	}

	public function buscador_lineas($tabla,$dato,$input)
	{
		$campo = "";
		// if ($tabla  == "DINVSLIN") {
		// 	$campo ="SUBLINEA";
		// }
		// if ($tabla == "DINVLINE") {
		// 	$campo = "LINEA";
		// }

		if (ctype_digit($dato)) {
			(int)$dato;
			$sql  = "SELECT FIRST 20 * FROM  DINVLINE WHERE LINEA CONTAINING '$dato' AND ACTIVO  = 'Si' ";
		}else{
			$sql  = "SELECT FIRST 20 * FROM  DINVLINE WHERE  DESCRIPCION CONTAINING '$dato' AND ACTIVO ='Si' ";
		}
		
		$gen = new generales();
		$contador  = 0;
		$array_respuesta =[];
		$datos  = ibase_query($this->conexionVentas(),$sql);
		while ($r=ibase_fetch_assoc($datos)) {
			$linea = $r["LINEA"]."|".$gen->reparar_utf8($r["DESCRIPCION"]);
				// $d = array("CLAVE"=>$r["LINEA"], "DESCRIPCION"=>$gen->reparar_utf8($r["DESCRIPCION"]));
			array_push($array_respuesta, $linea);

		}
		
		if (count($array_respuesta) > 0 ) {
			return json_encode($array_respuesta);
		}else{
			
			return json_encode($array_respuesta);
		}
		
	}


	public function buscar_sublineas($dato)
	{
		(int)$dato;
		$conexion  = $this->conexionVentas();
		$gen = new generales();
		$sublineas = array();
		if (ctype_digit($dato)) {
			$sql = "SELECT FIRST 20 *  FROM DINVSLIN WHERE LINEA  = '$dato' AND ACTIVO = 'Si'";
		}else{
			$sql  =  "SELECT FIRST 20 * FROM DINVSLIN WHERE DESCRIPCION CONTAINING '$dato' AND ACTIVO = 'Si' ";
		}
		$resultado  = ibase_query($conexion,$sql);
		while ($r = ibase_fetch_assoc($resultado)) {
			$sublinea = $r["SUBLINEA"]."**".$gen->reparar_utf8($r["DESCRIPCION"]);
			array_push($sublineas, $sublinea);
		}
		$lista_marcas = array();
		$sql  = "SELECT *  FROM DINVMARC";
		$marcas =  ibase_query($conexion,$sql);
		while ($m = ibase_fetch_assoc($marcas)) {
			$marca  = $m["CLAVE"]."**".$gen->reparar_utf8($m["DESCRIPCION"]);
			array_push($lista_marcas, $marca);
		}

		$lista_ivas  = array();
		$sql ="SELECT * FROM DGENCIVA";
		$ivas  = ibase_query($this->conexionAdmon(),$sql);
		while ($i = ibase_fetch_assoc($ivas)) {
			$iva = $i["CLAVE"]."**".$gen->reparar_utf8($i["DESCRIPCION"]);
			array_push($lista_ivas,$iva);
		}

		$re = array("sublineas"=>$sublineas, "marcas" =>$lista_marcas, "ivas"=>$lista_ivas);
		return json_encode($re);
	}

	public function buscador_sat($dato,$tabla)
	{
		if ($tabla == "DGENPRODSERVSAT") {
			if (ctype_digit($dato)) {
				if (strlen($dato) == 8) {
					$sql  = "SELECT FIRST 20 * FROM  ".$tabla." WHERE CLAVE = '$dato'  ";
				}else{
					$sql  = "SELECT FIRST 20 * FROM  ".$tabla." WHERE CLAVE CONTAINING '$dato'  ";
				}

			}else{
				$sql  = "SELECT FIRST 20 * FROM  ".$tabla." WHERE  DESCRIPCION CONTAINING '$dato'  ";
			}
		}else{
			$isnum = substr($dato, 1,1);

			if (strlen($dato) <= 3) {
				$dato  = strtoupper($dato);
				
				$sql  = "SELECT FIRST 20 * FROM  ".$tabla." WHERE CLAVE CONTAINING '$dato'  ";
				
			}else{
				$sql  = "SELECT FIRST 20 * FROM  ".$tabla." WHERE  DESCRIPCION CONTAINING '$dato'  ";
			}

		}
		// print_r($sql);
		$gen = new generales();
		$contador  = 0;
		$array_respuesta =[];
		$datos  = ibase_query($this->conexionAdmon(),$sql);
		while ($r=ibase_fetch_assoc($datos)) {
			$linea = $r["CLAVE"]."|".$gen->reparar_utf8($r["DESCRIPCION"]);
				// $d = array("CLAVE"=>$r["LINEA"], "DESCRIPCION"=>$gen->reparar_utf8($r["DESCRIPCION"]));
			array_push($array_respuesta, $linea);

		}
		
		if (count($array_respuesta) > 0 ) {
			return json_encode($array_respuesta);
		}else{
			
			return json_encode($array_respuesta);
		}
		
	}

	public function guardar_producto($datos)
	{
		# code...
	}



	public function buscar_codigo_barras($codigo_barras,$estacion)
	{
		$gen = new generales();
		(int)$estacion;
		$conexionGas = $this->conexionGas();
		$conexionVen =$this->conexionVentas();
		$sql  = "SELECT COUNT(*) AS EXISTE FROM DGASPROD WHERE  CODIGO_BARRA = '$codigo_barras' AND ESTACION = '$estacion'";

		$resul = ibase_query($conexionGas,$sql);
		$codigo = ibase_fetch_assoc($resul);
		$respuesta  = array();
		$marcas  = array();
		$ivas = array();
		$sublineas=array();
		$formulario  = array();

		if ($codigo["EXISTE"] >  0) {

			$sql  = "SELECT * FROM DGASPROD  WHERE  CODIGO_BARRA = '$codigo_barras' AND ESTACION = '$estacion'";
			$resul = ibase_query($conexionGas,$sql);
			$pro = ibase_fetch_assoc($resul);
			(int)$clave = $pro["CODIGO"];
			$estacion  = $gen->reparar_utf8($pro["ESTACION"]);
			$descripcion = $gen->reparar_utf8($pro["DESCRIPCION"]);
			$linea  = $pro["LINEA"];
			$unidad = $pro["UNIDAD"];
			$cveprodsat =$pro["CVEPRODSAT"];
			$cveunisat = $pro["CVEUNISAT"];

			$sql = "SELECT MARCA,CLAVEIVA,SUBLINEA FROM DGENPROD WHERE CLAVE = '$clave'";
			// print_r($sql);
			$exe = ibase_query($conexionVen,$sql);
			$dg = ibase_fetch_assoc($exe);
			(int)$marca = $dg["MARCA"];
			(int)$iva = $dg["CLAVEIVA"];
			(int)$sublinea = $dg["SUBLINEA"];

			
			$sql  = "SELECT * FROM DINVMARC";
			$mar = ibase_query($conexionVen,$sql);
			while ($m = ibase_fetch_assoc($mar)) {
				$marcabd  = $m["CLAVE"]."**".$gen->reparar_utf8($m["DESCRIPCION"]);
				array_push($marcas, $marcabd);
			}


			$sql  = "SELECT *  FROM DGENCIVA";
			$exe = ibase_query($this->conexionAdmon(),$sql);
			while ($i = ibase_fetch_assoc($exe)) {
				$ivabd = $i["CLAVE"]."**".$gen->reparar_utf8($i["DESCRIPCION"]);
					array_push($ivas, $ivabd);
			}

			$sql  = "SELECT * FROM DINVSLIN WHERE LINEA = '$linea'";
			$exe  = ibase_query($conexionVen,$sql);
			while ($sub = ibase_fetch_assoc($exe)) {
				$subli = $sub["SUBLINEA"]."**".$gen->reparar_utf8($sub["DESCRIPCION"]);
				array_push($sublineas, $subli);

			}

			$sql  = "SELECT * FROM ESTACIONES";
			$exe = ibase_query($this->conexionlocal(),$sql);
			$estaciones = array();
			while ($e=ibase_fetch_assoc($exe)) {
				$estaciont = $e["ID"]."**".$e["ESTACION"];
				array_push($estaciones, $estaciont);
			}

			$sql  = "SELECT LINEA,DESCRIPCION FROM DINVSLIN  WHERE LINEA = '$linea'";
			$exe = ibase_query($conexionVen,$sql);
			$li = ibase_fetch_assoc($exe);
			$linea = $li["LINEA"]."|".$li["DESCRIPCION"];

			$formulario  =["codigobarras_producto"=>$codigo_barras,
				"estaciones"=>$estaciones,"nombre_pro"=>$descripcion,
				"linea_producto"=>$linea,"sublinea_producto"=>$sublineas,"unidad_producto"=>$unidad,
				"CVEPRODSAT"=>$cveprodsat,"CVEUISAT"=>$cveunisat,"marca_producto"=>$marcas,"iva_producto"=>$ivas];

			$principales = array("estaciones_default"=>$estacion,"sublinea_producto_default"=>$sublinea,"marca_producto_default"=>$marca, "iva_producto_default"=>$iva);

			$respuesta  = ["existe" =>"si","formulario"=>$formulario,"principales"=>$principales];
		}else{
			$respuesta = ["existe"=>"no"];
		}
		return json_encode($respuesta);
	}
	
}
?>