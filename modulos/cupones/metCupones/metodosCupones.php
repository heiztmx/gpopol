<?php 

include '../../../conexionGas.php';
include '../../../ConexionADMON.php';
require_once( '../../../conexion.php');
include("../../../general/funciones.php");
 	/**
 	 * 
 	 */
 	
 class Cupones  
 {
	public function conloc()
	{
		# code...
		$objeto = new conexion();
		$conexion =$objeto->conectar();
		return $conexion;
	}
	public function conCONSOLA($IP_Est)
	{
		# code...
		$objeto = new conexionGAS();
		$conexion =$objeto->conectarGASconsola($IP_Est);
		return $conexion;
	} 

	public function conADMON()
	{
		$objeto = new conexionADMON();
		$conexion = $objeto->conectarADM();
		return $conexion;
	}

	public function conVen()
	{
		$objeto = new conexionADMON();
		$conexion = $objeto->conectarADMON();
		return $conexion;
	}

	public function conGas()
	{
		$objeto = new conexionGAS();
		$conexion = $objeto->conectarGAS();
		return $conexion;
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

 		public function usuariosCupones()
 		{
 			$objeto = new conexion();
 			$conexion =$objeto->conectar();
 			$query ="SELECT DISTINCT IP FROM IPREPORTES ORDER BY IP DESC";
 			$usuarios =ibase_query($conexion,$query);
 			ibase_free_result($usuarios); 
 			ibase_close($conexion);
 			
 			return $usuarios;
 		}
 
 		public function ipUsuarios()
 		{
 			$objeto = new conexion();
 			$conexion =$objeto->conectar();
 			$query ="SELECT * FROM IPREPORTES";
 			$nombre ="";
 			$ip="";

 			$usuarios =ibase_query($conexion,$query);
 			
 			while ($us  =ibase_fetch_object($usuarios)) {
 				$nombre.=$us->NOMBRE."||";
 				$ip.=$us->IP."||";
 				
 			}
 			$resultado =$nombre." ".$ip;
 			
 			ibase_free_result($usuarios); 
 			ibase_close($conexion);
 			return $resultado;
 		}

 		public function NombreDescargo($datos,$ipgas)
 		{
 			

 			$des =explode(" ", $datos);
 			$nombres =array();
 			$ip =array();
 			$nombres=explode("||", $des[0]);
 			$ip =explode("||", $des[1]);
 			$nombreDescargo ="";
 			for($i=0; $i<count($ip); $i++)
 			{
 				if($ip[$i] == $ipgas)
 				{
 					
 					$nombreDescargo = $nombres[$i];
 					break;
 				}

 			}	
 			
 			return $nombreDescargo;	
 		}
 		
 		
 		public function traercupones($estacion,$cliente,$fecha,$fecha2,$usuario)
 		{	
 			$objeto1 = new Cupones();
 			$ipnombres=$objeto1->ipUsuarios();
 			$idClientes =$objeto1->traerClientes($estacion,$fecha,$fecha2,$cliente,$ipnombres,$usuario);
 			
 			if($idClientes == NULL)
 			{
 				return $resultado = "No existe informacion, con los datos proporcionados";
 			}else{


 				$objeto = new conexionGAS();
 				$conexion = $objeto->conectarGAS();


 				
 				
 				$resultado ="";
 				$sumaImporte=0;
 				$totalGeneral=0;
 				$totalCupones=0;
 				$cuponesTotalesGeneral=0;
 				
 				
 				$resultado.= " <table class='table table-hover mx-auto table-sm font-weight-light ' id='myTable'>
 					<thead> 
 									

 					<tr class='letras font-weight-bold' style='background-color: #e9ecef'>
 					<td style='width:8%; text-align:center'>F.Cupon</td>
 					<td style='width:8%; text-align:center' >F.Vol.</td>
 					 					
 					<td style='width:15%; text-align:center'>F.Anticipo</td>
 					<td style='width:15%; text-align:center' >F.Consumo</td>
 					<td style='width:15%; text-align:center' class='columOcultas'>F.Venta</td>
 					<td style='width:15%; text-align:center' class='columOcultas'>F.Recep</td>
 					<td style='text-align:right;width:40%;'>Importe</td>
 					
 					
 					
 					</tr>
 					</thead>";				

 				
 				for($i=0; $i<count($idClientes); $i++)
 				{
 					$nombreCliente =$objeto1->NombreClientes($idClientes[$i]);
 					$x =$objeto1->datosCupones($estacion,$fecha,$fecha2,$idClientes[$i],$usuario,$ipnombres,$cliente);
 					
 				// $registros = ibase_fetch_object($x);
 				// echo  $registros->SERIE;
 					

 					$nombreCliente=ucwords(strtolower(utf8_encode($nombreCliente)));
 					$resultado.= " 					
 					
 					<tr style='background-color: #F7F7F9'>
 					<th  id='estacion' class='letras font-italic' colspan='7' style='text-align: left;' scope='col'>"." ".$nombreCliente." (".$idClientes[$i].")"."</th>
 					
					 ";
 					
 					
 					
 					
 					
 					
 					while ($row = ibase_fetch_assoc($x)) {
 						$xx =explode(" ", $row["FECHARECUP"]);
 						if($row["HORA"] != NULL){

 							$ww =explode(" ", $row["HORA"]);

 							$res =$xx[0]." ".$ww[1];
 						}else{
 							$res =$xx[0];
 						}
 						$res = new DateTime($res);
 						$res = $res->format('d/m/Y');
 						
 						$fechaV = new DateTime($row["FECHAVENTA"]);
 						$fechaV = $fechaV->format('d/m/Y');
 			// if ($idClientes[$i] == $row["NOCLIENTE"]) 
 			// 			{
 						$importe =number_format($row['IMPORTE'],2,'.',',');
 						$con =$row["SERIEFAC"]."-".$row["FOLIOFAC"];
 						$sumaImporte+=$row["IMPORTE"];

 						$fol_real=intval($row["FOLIOVOLUMETRICO"]);
 						
 						/*
 						if ($fol_real>1000000000){ 
 							$fol_real=intval(substr($row["FOLIOVOLUMETRICO"], 1));
 						}
						*/

 							# code...
 						$resultado.= " 
 						 
 						<tbody>
 						<tr class='letras font-weight-light'>
 						<th scope='row'  style='text-align:center;font-weight: normal;'>".$row["FOLIO"]."</th>
 						<td style='text-align:center;'>".$fol_real."</td>
 						
 						<td style='text-align:center'>FA-".$row["IDANTICIPO"]."</td>
 						<td style='text-align:center'>".$con."</td>
 						<td style='text-align:center' class='columOcultas'>".$fechaV."</td>
 						<td style='text-align:center' class='columOcultas'>".$res."</td>
 						<td style='text-align:right;'>".$importe."</td>
 						
 						</tr></tbody>
 						
 						

 						
 						";
 					// }
 						$totalCupones++;
 						$cuponesTotalesGeneral++;
 					}	
 					
 					$sumaImporte1 =number_format($sumaImporte,2,'.',',');
 					$resultado.=" <tr class='letras font-weight-light'>
 					
 					<td colspan='5' style ='text-align:right;font-weight:bold;'>Cupones: ".$totalCupones."</td>
 					<td colspan='2' style ='text-align:right;font-weight:bold;'>Total: ".$sumaImporte1."</td>
 					
 					</tr>";
 

 					$totalGeneral+=$sumaImporte;
 					$totalGeneral1 =number_format($totalGeneral,2,'.',',');
 					$sumaImporte=0;
 					$totalCupones=0;
 				}

 				$resultado.=" 
 				<tfoot style='background-color:#e9ecef;'>
 				<tr class='letras font-weight-light'>
 				
 				<td colspan='4' style ='text-align:left;font-weight:bold;'>Total de Cupones: ".$cuponesTotalesGeneral."</td>
 				<td colspan='3' style ='text-align:right;font-weight:bold;'>Importe General: $".$totalGeneral1."</td>
 				</tr></tfoot></table>";




 				return $resultado;
 			}
 		}


 		public function NombreClientes($id)
 		{
 			$ad      = new conexionADMON();
 			$admon   = $ad->conectarADMON();
 			$clie    = "SELECT * FROM DGENCLIE WHERE NOCLIE = '$id' ";
 			$cliente = ibase_query($admon, $clie);
 			$cli = ibase_fetch_assoc($cliente);
 			ibase_free_result($cliente); 
 			ibase_close($admon);
 			return $cli["NOMBRE"];
 		}	

 		public function traerClientes($estacion,$fecha,$fecha2,$id,$cadena,$usuario)
 		{
 			$objeto = new conexionGAS();
 			$conexion = $objeto->conectarGAS();
 			$objetoL= new Cupones();
 			$ips = $objetoL->movimientosUsuario($cadena,$usuario);
 			(int)$id;
 			$idClientes = array();
 			// print_r($ips);
 			if($estacion == "todas" && $id == 0 &&  $usuario == "todosUsuarios")
 			{
 				$select = "SELECT DISTINCT NOCLIENTE FROM DGASCUPO
 				WHERE  ESTATUS='R'  AND (FECHARECUP >= '$fecha' AND FECHARECUP <= '$fecha2') ORDER BY NOCLIENTE ASC";
 			}
 			elseif($estacion == "todas" &&  $usuario == "todosUsuarios"  && $id !=0){
 				$select = "SELECT DISTINCT NOCLIENTE FROM DGASCUPO
 				WHERE  NOCLIENTE ='$id' AND  ESTATUS='R'  AND (FECHARECUP >= '$fecha' AND FECHARECUP <= '$fecha2') ORDER BY NOCLIENTE ASC";
 			}
 			elseif($id == 0 &&  $usuario == "todosUsuarios" && $estacion != "todas"){
 				$select = "SELECT DISTINCT NOCLIENTE FROM DGASCUPO
 				WHERE  ESTACIONRECUP = '$estacion' AND  ESTATUS='R'  AND (FECHARECUP >= '$fecha' AND FECHARECUP <= '$fecha2') ORDER BY NOCLIENTE ASC";
 			}
 			elseif (  $estacion == "todas" && $id == 0 && $usuario != "todosUsuarios" )
 			{
 				
 				$select = "SELECT DISTINCT C.NOCLIENTE AS NOCLIENTE FROM DGASCUPO C 
 				JOIN DGASRCUP CR
 				ON C.FOLIO  = CR.CUPON   AND
 				C.ESTACIONRECUP  = CR.ESTACION
 				WHERE
 				C.ESTATUS ='R' AND 
 				(C.FECHARECUP >='$fecha' AND C.FECHARECUP <= '$fecha2') AND (CR.IP = '$ips[0]' OR CR.IP = '$ips[1]'  OR CR.IP = '$ips[2]' OR CR.IP = '$ips[3]' OR CR.IP = '$ips[4]')";
 				

 			}
 			elseif ($estacion  != "todas" && $id != 0 && $usuario == "todosUsuarios") {
 				
 				$select = "SELECT DISTINCT NOCLIENTE FROM DGASCUPO
 				WHERE  ESTACIONRECUP = '$estacion' AND NOCLIENTE = '$id' AND  ESTATUS='R'  AND 
 				(FECHARECUP >= '$fecha' AND FECHARECUP <='$fecha2') ORDER BY NOCLIENTE ASC";
 			}
 			elseif ($estacion != "todas" && $id == 0 && $usuario != "todosUsuarios") {
 				# code...

 				$select = "SELECT DISTINCT C.NOCLIENTE AS NOCLIENTE FROM DGASCUPO C 
 				JOIN DGASRCUP CR
 				ON C.FOLIO  = CR.CUPON   AND
 				C.ESTACIONRECUP  = CR.ESTACION
 				WHERE ESTACIONRECUP = '$estacion'  AND  ESTATUS='R'  AND (FECHARECUP >= '$fecha' AND FECHARECUP <= '$fecha2') AND (CR.IP = '$ips[0]' OR CR.IP = '$ips[1]'  OR CR.IP = '$ips[2]' OR CR.IP = '$ips[3]' OR CR.IP = '$ips[4]') ORDER BY NOCLIENTE ASC";

 			}elseif ($estacion == "todas" && $id != 0 &&  $usuario  != "todosUsuarios") {
 				$select = "SELECT DISTINCT C.NOCLIENTE AS NOCLIENTE FROM DGASCUPO C 
 				JOIN DGASRCUP CR
 				ON C.FOLIO  = CR.CUPON   AND
 				C.ESTACIONRECUP  = CR.ESTACION
 				WHERE NOCLIENTE = '$id'  AND  ESTATUS='R'  AND (FECHARECUP >= '$fecha' AND FECHARECUP<='$fecha2') AND (CR.IP = '$ips[0]' OR CR.IP = '$ips[1]'  OR CR.IP = '$ips[2]' OR CR.IP = '$ips[3]' OR CR.IP = '$ips[4]') ORDER BY NOCLIENTE ASC";
 			}elseif ($estacion != "todas" && $id != 0 && $usuario != "todosUsuarios") {
 				
 				$select = "SELECT DISTINCT C.NOCLIENTE AS NOCLIENTE FROM DGASCUPO C 
 				JOIN DGASRCUP CR
 				ON C.FOLIO  = CR.CUPON   AND
 				C.ESTACIONRECUP  = CR.ESTACION
 				WHERE NOCLIENTE = '$id' AND ESTACIONRECUP = '$estacion'   AND  ESTATUS='R'  AND 
 				(FECHARECUP >= '$fecha' AND FECHARECUP<='$fecha2') AND (CR.IP = '$ips[0]' OR CR.IP = '$ips[1]'  OR CR.IP = '$ips[2]' OR CR.IP = '$ips[3]' OR CR.IP = '$ips[4]') ORDER BY NOCLIENTE ASC";
 			}

 			else{

 				$select = "SELECT DISTINCT NOCLIENTE FROM DGASCUPO
 				WHERE (FECHARECUP >= '$fecha' AND FECHARECUP <= '$fecha2') ORDER BY NOCLIENTE ASC"; 				
 			}
 			
 			
 			$cli=ibase_query($conexion,$select);
 			while ($row=ibase_fetch_assoc($cli)) {
 				array_push($idClientes, $row["NOCLIENTE"]);
				# code...
 			}
			ibase_free_result($cli);  //  <-------
			ibase_close($conexion);	
			
			// print_r($idClientes);
			

// print_r($idClientes);

			return $idClientes;
		}

		public function traercuponesUsuarios($estacion,$cliente,$fecha,$fecha2,$usuario)
		{	
			$objeto1 = new Cupones();
			$ipnombres=$objeto1->ipUsuarios();
			$idClientes =$objeto1->traerClientes($estacion,$fecha,$fecha2,$cliente,$ipnombres,$usuario);
			$objetoCo =new Cupones();
			$cadena  = $objeto1->ipUsuarios();

			if($idClientes == NULL)
			{
				return $resultado ="No hay datos con la fecha seleccionada";
			}else{


				$objeto = new conexionGAS();
				$conexion = $objeto->conectarGAS();
				

				
				
				$resultado ="";
				$sumaImporte=0;
				$totalGeneral=0;
				$totalCupones=0;
				$cuponesTotalesGeneral=0;
				
				
				
				
				for($i=0; $i<count($idClientes); $i++)
				{
					$nombreCliente =$objeto1->NombreClientes($idClientes[$i]);
					$resultado.= " <table class='table table-hover mx-auto table-sm' id='myTable'>
					<thead>
					
					<tr style='background-color: #F7F7F9'>
					<th  id='estacion' class='letras'  style='text-align: left;font-weight: bold; width:8%;'  scope='col'>".$idClientes[$i]."</th>
					<th  id='estacion' class='letras' colspan='5' style='text-align: left;font-weight: bold;' scope='col'>".$nombreCliente."</th>
					
					</tr>
					</thead>
					<tr>
					<td style='font-weight:bold;color:gray;'>Folio</td>
					<td style='font-weight:bold;color:gray; width:8%; text-align:center' class='columOcultas'>Serie</td>
					<td style='font-weight:bold;color:gray; width:8%; text-align:center' >Recuperado</td>
					
					<td style='font-weight:bold;color:gray; text-align:center;width:12%'>Terminal</td>
					<td style='font-weight:bold;color:gray;width:10%'>Factura</td>
					<td style='font-weight:bold;color:gray;width:30%;'>Fecha de venta</td>

					<td style='font-weight:bold;color:gray;width:30%;' class='columOcultas'>Fecha de recuperacion</td>
					<td style='font-weight:bold;color:gray; text-align:center'>Importe</td>
					<td style='font-weight:bold;color:gray; text-align:center' class='columOcultas'></td>
					
					</tr> ";
					
					 	# code...
					$x =$objeto1->datosCuponesCusuarios($estacion,$fecha,$fecha2,$idClientes[$i],$usuario,$cadena);	 

					while($row = ibase_fetch_assoc($x)) {

						$nombreip = $objeto1->NombreDescargo($ipnombres,$row["IP"]);

						$xx =explode(" ", $row["FECHARECUP"]);
						if($row["HORA"] != NULL){

							$ww =explode(" ", $row["HORA"]);

							$res =$xx[0]." ".$ww[1];
						}else{
							$res =$xx[0];
						}
						$res = new DateTime($res);
						$res = $res->format('d/m/Y H:i:s');
						$importe =number_format($row['IMPORTE'],2,'.',',');

						$fechaV = new DateTime($row["FECHAVENTA"]);
						$fechaV = $fechaV->format('d/m/Y H:i:s');
//comparar las ip para el nombre
						
						$con =$row["SERIEFAC"]."".$row["FOLIOFAC"];
						$sumaImporte+=$row["IMPORTE"];
 							# code...
						$resultado.= " 
						<tbody> 
						
						<tr>
						<th scope='row'>".$row["FOLIO"]."</th>
						<td style='text-align:center' class='columOcultas'".$row["SERIE"]."</td>
						<td style='text-align:center'>".$row["ESTACIONRECUP"]."</td>
						<td style='text-align:center;'>".$nombreip."</td>
						<td>".$con."</td>
						<td>".$fechaV."</td>
						<td class='columOcultas'>".$res."</td>
						<td style='text-align:center;'>".$importe."</td>
						
						</tr>
						
						</tbody>

						
						";
 					// }
						$totalCupones++;
						$cuponesTotalesGeneral++;
					}	
					$sumaImporte1 =number_format($sumaImporte,2,'.',',');
					$resultado.=" <tr>
					<td colspan='1' class='columOcultas'><td>
					<td colspan='2' style ='text-align:right;font-weight:bold;'>Total de cupones: ".$totalCupones."<td>
					<td colspan='2' style ='text-align:right;font-weight:bold;'> Total: ".$sumaImporte1."</td>
					
					</tr>
					</table>";
					$totalGeneral+=$sumaImporte;
					$sumaImporte=0;
					$totalCupones=0;
				}
				$totalGeneral1 =number_format($totalGeneral,2,'.',',');
				$resultado.="<br> 
				<div class ='d-flex flex-wrap justify-content-between'>
				<h5 style='font-weight:bold;text-align:left;'> Total de Cupones: ".$cuponesTotalesGeneral."</h5>
				<h5 style='font-weight:bold;text-align:right;margin-right:120px;'>Total General: $".$totalGeneral1."</h5>
				</div>";
				ibase_free_result($x);
				ibase_close($conexion);
				return $resultado;
			}

		}
		

		

		public function datosCuponesCusuarios($estacion,$fecha,$fecha2,$id,$usuario,$cadena)
		{
			$objeto = new conexionGAS();
			$conexion = $objeto->conectarGAS();
			$objetoCo = new Cupones();
			$ips=$objetoCo->movimientosUsuario($cadena,$usuario);
			if($estacion == "todas" && $id == 0 && $usuario == "todosUsuarios")

			{
				
				$query="SELECT  C.SERIE,C.ESTACION,C.IMPORTE,C.FECHARECUP,C.FECHAVENTA,C.FOLIO,C.SERIEFAC,C.FOLIOFAC,C.ESTATUS,C.NOCLIENTE,C.ESTACIONRECUP,C.HORA, CR.IP FROM DGASRCUP CR 
				JOIN DGASCUPO  C
				ON  C.FOLIO  = CR.CUPON 
				AND
				C.ESTACIONRECUP  = CR.ESTACION

				WHERE  (C.FECHARECUP >='$fecha' AND C.FECHARECUP <='$fecha2') ";

			}elseif ($estacion != "todas" && $id == 0 &&  $usuario == "todosUsuarios") {
				
				$query="SELECT  C.SERIE,C.ESTACION,C.IMPORTE,C.FECHARECUP,C.FECHAVENTA,C.FOLIO,C.SERIEFAC,C.FOLIOFAC,C.ESTATUS,C.NOCLIENTE,C.ESTACIONRECUP,C.HORA, CR.IP FROM DGASRCUP CR 
				JOIN DGASCUPO  C
				ON  C.FOLIO  = CR.CUPON 
				AND
				C.ESTACIONRECUP  = CR.ESTACION

				WHERE  (C.FECHARECUP >='$fecha' AND C.FECHARECUP <='$fecha2') AND C.ESTACIONRECUP = '$estacion'  ";

			}

			elseif ($id  != 0 && $estacion == "todas"  && $usuario == "todosUsuarios") {
 						# code...

				$query="SELECT  C.SERIE,C.ESTACION,C.IMPORTE,C.FECHARECUP,C.FECHAVENTA,C.FOLIO,C.SERIEFAC,C.FOLIOFAC,C.ESTATUS,C.NOCLIENTE,C.ESTACIONRECUP,C.HORA, CR.IP FROM DGASRCUP CR 
				JOIN DGASCUPO  C
				ON  C.FOLIO  = CR.CUPON 
				AND
				C.ESTACIONRECUP  = CR.ESTACION

				WHERE  (C.FECHARECUP >='$fecha' AND C.FECHARECUP <='$fecha2' ) AND C.NOCLIENTE = '$id'  "	;

			} elseif ($id  == 0 && $estacion == "todas"  && $usuario != "todosUsuarios") {
 						# code...

				$query="SELECT  C.SERIE,C.ESTACION,C.IMPORTE,C.FECHARECUP,C.FECHAVENTA,C.FOLIO,C.SERIEFAC,C.FOLIOFAC,C.ESTATUS,C.NOCLIENTE,C.ESTACIONRECUP,C.HORA, CR.IP FROM DGASRCUP CR 
				JOIN DGASCUPO  C
				ON  C.FOLIO  = CR.CUPON 
				AND
				C.ESTACIONRECUP  = CR.ESTACION

				WHERE  (C.FECHARECUP >='$fecha' AND C.FECHARECUP <='$fecha2' ) AND (CR.IP = '$ips[0]' OR CR.IP = '$ips[1]'  OR CR.IP = '$ips[2]' OR CR.IP = '$ips[3]' OR CR.IP = '$ips[4]' ) ";


			}elseif ($estacion != "todas" && $id  != 0   && $usuario == "todosUsuarios") {
 						# code...
 						// print_r("imprimir");
				$query="SELECT  C.SERIE,C.ESTACION,C.IMPORTE,C.FECHARECUP,C.FECHAVENTA,C.FOLIO,C.SERIEFAC,C.FOLIOFAC,C.ESTATUS,C.NOCLIENTE,C.ESTACIONRECUP,C.HORA, CR.IP FROM DGASRCUP CR 
				JOIN DGASCUPO  C
				ON  C.FOLIO  = CR.CUPON 
				AND
				C.ESTACIONRECUP  = CR.ESTACION

				WHERE  (C.FECHARECUP >='$fecha' AND C.FECHARECUP <='$fecha2' ) AND C.NOCLIENTE = '$id'  AND C.ESTACIONRECUP = '$estacion' ";


			}elseif ($estacion != "todas" && $id  == 0   && $usuario != "todosUsuarios") {
 						# code...
				$query=" SELECT  C.SERIE,C.ESTACION,C.IMPORTE,C.FECHARECUP,C.FECHAVENTA,C.FOLIO,C.SERIEFAC,C.FOLIOFAC,C.ESTATUS,C.NOCLIENTE,C.ESTACIONRECUP,C.HORA, CR.IP FROM DGASCUPO C 
				JOIN DGASRCUP CR
				ON C.FOLIO  = CR.CUPON   AND
				C.ESTACIONRECUP  = CR.ESTACION
				WHERE
				(C.FECHARECUP >='$fecha' AND C.FECHARECUP <='$fecha2' ) AND C.ESTACIONRECUP = '$estacion' AND (CR.IP = '$ips[0]' OR CR.IP = '$ips[1]'  OR CR.IP = '$ips[2]' OR CR.IP = '$ips[3]' OR CR.IP = '$ips[4]' )";
			}elseif ($estacion == "todas" && $id  != 0   && $usuario != "todosUsuarios") {

				$query=" SELECT  C.SERIE,C.ESTACION,C.IMPORTE,C.FECHARECUP,C.FECHAVENTA,C.FOLIO,C.SERIEFAC,C.FOLIOFAC,C.ESTATUS,C.NOCLIENTE,C.ESTACIONRECUP,C.HORA, CR.IP FROM DGASCUPO C 
				JOIN DGASRCUP CR
				ON C.FOLIO  = CR.CUPON   AND
				C.ESTACIONRECUP  = CR.ESTACION
				WHERE
				(C.FECHARECUP >='$fecha' AND C.FECHARECUP <='$fecha2' ) AND C.NOCLIENTE = '$id' AND (CR.IP = '$ips[0]' OR CR.IP = '$ips[1]'  OR CR.IP = '$ips[2]' OR CR.IP = '$ips[3]' OR CR.IP = '$ips[4]' )";

			}elseif ($estacion != "todas" && $id  != 0   && $usuario != "todosUsuarios") {
 						# code...
				
				$query=" SELECT  C.SERIE,C.ESTACION,C.IMPORTE,C.FECHARECUP,C.FECHAVENTA,C.FOLIO,C.SERIEFAC,C.FOLIOFAC,C.ESTATUS,C.NOCLIENTE,C.ESTACIONRECUP,C.HORA, CR.IP FROM DGASCUPO C 
				JOIN DGASRCUP CR
				ON C.FOLIO  = CR.CUPON   AND
				C.ESTACIONRECUP  = CR.ESTACION
				WHERE
				(C.FECHARECUP >='$fecha' AND C.FECHARECUP <='$fecha2' ) AND C.NOCLIENTE = '$id' 	AND C.ESTACIONRECUP = '$estacion' AND (CR.IP = '$ips[0]' OR CR.IP = '$ips[1]'  OR CR.IP = '$ips[2]' OR CR.IP = '$ips[3]' OR CR.IP = '$ips[4]' )";
			}

			
			else{
				
				$query="SELECT  C.SERIE,C.ESTACION,C.IMPORTE,C.FECHARECUP,C.FECHAVENTA,C.FOLIO,C.SERIEFAC,C.FOLIOFAC,C.ESTATUS,C.NOCLIENTE,C.ESTACIONRECUP,C.HORA, CR.IP FROM DGASRCUP CR 
				JOIN DGASCUPO  C
				ON  C.FOLIO  = CR.CUPON 
				AND
				C.ESTACIONRECUP  = CR.ESTACION

				WHERE  (C.FECHARECUP >='$fecha' AND C.FECHARECUP <='$fecha2' )  ";	
			}
			
			
			
			$vales = ibase_query($conexion,$query);

 			ibase_free_result($vales);  //  <-------
 			ibase_close($conexion);
 			return $vales;

 		}
 		public function movimientosUsuario($cadena,$usuario)
 		{

 			$des =explode(" ", $cadena);
 			$nombres =array();
 			$ip =array();
 			$nombres=explode("||", $des[0]);
 			$ip =explode("||", $des[1]);

 			$ipsUsuarios= array();
 			for($i=0; $i<count($ip); $i++)
 			{		
 				

 				if($usuario == $nombres[$i])
 				{
 					array_push($ipsUsuarios, $ip[$i]);
 				}
 				
 			}

 			$resu = 5 - count($ipsUsuarios);
 			for ($i=0; $i <$resu; $i++) { 
 				array_push($ipsUsuarios, "x");
 			}
 			
 			return $ipsUsuarios;
 		}

 		public function  datosCupones($estacion,$fecha,$fecha2,$id,$usuario,$cadena,$cliente)
 		{

 			$objeto = new conexionGAS();
 			$conexion = $objeto->conectarGAS();

 			$objetoCo =new Cupones();
 			$ips=$objetoCo->movimientosUsuario($cadena,$usuario);
 			
 			
 			if($estacion == "todas" && $id == 0 && $usuario == "todosUsuarios")

 			{
 				$query="SELECT  SERIE,ESTACION,IMPORTE,FECHARECUP,FECHAVENTA,FOLIO,SERIEFAC,FOLIOFAC,ESTATUS,NOCLIENTE,ESTACIONRECUP,HORA,FOLIOVOLUMETRICO,IDANTICIPO FROM DGASCUPO WHERE (FECHARECUP >='$fecha' AND FECHARECUP <= '$fecha2') ";


 			}elseif ($estacion != "todas" && $id == 0 &&  $usuario == "todosUsuarios") {
 				$query="SELECT  SERIE,ESTACION,IMPORTE,FECHARECUP,FECHAVENTA,FOLIO,SERIEFAC,FOLIOFAC,ESTATUS,NOCLIENTE,ESTACIONRECUP,HORA,FOLIOVOLUMETRICO,IDANTICIPO FROM DGASCUPO WHERE ESTACIONRECUP ='$estacion'  AND  (FECHARECUP >='$fecha' AND FECHARECUP <= '$fecha2') "; 

 			}
 			elseif ($id  != 0 && $estacion == "todas"  && $usuario == "todosUsuarios") {
 						# code...
 				$query="SELECT SERIE, ESTACION,IMPORTE,FECHARECUP,FECHAVENTA,FOLIO,SERIEFAC,FOLIOFAC,ESTATUS,NOCLIENTE,ESTACIONRECUP,HORA,FOLIOVOLUMETRICO,IDANTICIPO FROM DGASCUPO WHERE NOCLIENTE ='$id'  AND  (FECHARECUP >='$fecha' AND FECHARECUP <= '$fecha2')"; 	
 			} elseif ($id  == 0 && $estacion == "todas"  && $usuario != "todosUsuarios") {
 						# code...
 				$query=" SELECT  C.SERIE,C.ESTACION,C.IMPORTE,C.FECHARECUP,C.FECHAVENTA,C.FOLIO,C.SERIEFAC,C.FOLIOFAC,C.ESTATUS,C.NOCLIENTE,C.ESTACIONRECUP,C.HORA,C.FOLIOVOLUMETRICO,C.IDANTICIPO, CR.IP FROM DGASCUPO C 
 				JOIN DGASRCUP CR
 				ON C.FOLIO  = CR.CUPON   AND
 				C.ESTACIONRECUP  = CR.ESTACION
 				WHERE
 				(C.FECHARECUP >='$fecha' AND C.FECHARECUP <='$fecha2') AND (CR.IP = '$ips[0]' OR CR.IP = '$ips[1]'  OR CR.IP = '$ips[2]' OR CR.IP = '$ips[3]' OR CR.IP = '$ips[4]' )";

 			}elseif ($estacion != "todas" && $id  != 0   && $usuario == "todosUsuarios") {
 						# code...
 				$query="SELECT  SERIE,ESTACION,IMPORTE,FECHARECUP,FECHAVENTA,FOLIO,SERIEFAC,FOLIOFAC,ESTATUS,NOCLIENTE,ESTACIONRECUP,HORA,FOLIOVOLUMETRICO,IDANTICIPO FROM DGASCUPO WHERE ESTACIONRECUP ='$estacion'  AND NOCLIENTE='$id' AND (FECHARECUP >='$fecha' AND FECHARECUP <= '$fecha2') ";
 			}elseif ($estacion != "todas" && $id  == 0   && $usuario != "todosUsuarios") {
 						# code...
 				$query=" SELECT  C.SERIE,C.ESTACION,C.IMPORTE,C.FECHARECUP,C.FECHAVENTA,C.FOLIO,C.SERIEFAC,C.FOLIOFAC,C.ESTATUS,C.NOCLIENTE,C.ESTACIONRECUP,C.HORA,C.FOLIOVOLUMETRICO,C.IDANTICIPO, CR.IP FROM DGASCUPO C 
 				JOIN DGASRCUP CR
 				ON C.FOLIO  = CR.CUPON   AND
 				C.ESTACIONRECUP  = CR.ESTACION
 				WHERE
 				(C.FECHARECUP >='$fecha' AND C.FECHARECUP <='$fecha2') AND ESTACIONRECUP = '$estacion' AND (CR.IP = '$ips[0]' OR CR.IP = '$ips[1]'  OR CR.IP = '$ips[2]' OR CR.IP = '$ips[3]' OR CR.IP = '$ips[4]' )";
 			}elseif ($estacion == "todas" && $id  != 0   && $usuario != "todosUsuarios") {

 				$query=" SELECT  C.SERIE,C.ESTACION,C.IMPORTE,C.FECHARECUP,C.FECHAVENTA,C.FOLIO,C.SERIEFAC,C.FOLIOFAC,C.ESTATUS,C.NOCLIENTE,C.ESTACIONRECUP,C.HORA,C.FOLIOVOLUMETRICO,C.IDANTICIPO, CR.IP FROM DGASCUPO C 
 				JOIN DGASRCUP CR
 				ON C.FOLIO  = CR.CUPON   AND
 				C.ESTACIONRECUP  = CR.ESTACION
 				WHERE
 				(C.FECHARECUP >='$fecha' AND C.FECHARECUP <='$fecha2') AND NOCLIENTE = '$id' AND (CR.IP = '$ips[0]' OR CR.IP = '$ips[1]'  OR CR.IP = '$ips[2]' OR CR.IP = '$ips[3]' OR CR.IP = '$ips[4]' )";
 			}elseif ($estacion != "todas" && $id  != 0   && $usuario != "todosUsuarios") {
 						# code...
 				$query="SELECT SERIE, ESTACION,IMPORTE,FECHARECUP,FECHAVENTA,FOLIO,SERIEFAC,FOLIOFAC,ESTATUS,NOCLIENTE,ESTACIONRECUP,HORA,FOLIOVOLUMETRICO,IDANTICIPO FROM DGASCUPO WHERE FECHARECUP ='$fecha'"; 
 				$query=" SELECT  C.SERIE,C.ESTACION,C.IMPORTE,C.FECHARECUP,C.FECHAVENTA,C.FOLIO,C.SERIEFAC,C.FOLIOFAC,C.ESTATUS,C.NOCLIENTE,C.ESTACIONRECUP,C.HORA,C.FOLIOVOLUMETRICO,C.IDANTICIPO, CR.IP FROM DGASCUPO C 
 				JOIN DGASRCUP CR
 				ON C.FOLIO  = CR.CUPON   AND
 				C.ESTACIONRECUP  = CR.ESTACION
 				WHERE
 				(C.FECHARECUP >='$fecha' AND C.FECHARECUP <='$fecha2') AND C.NOCLIENTE = '$id' 	AND C.ESTACIONRECUP = '$estacion' AND (CR.IP = '$ips[0]' OR CR.IP = '$ips[1]'  OR CR.IP = '$ips[2]' OR CR.IP = '$ips[3]' OR CR.IP = '$ips[4]' )";
 			}

 			
 			else{
 				
 				$query="SELECT  SERIE, ESTACION,IMPORTE,FECHARECUP,FECHAVENTA,FOLIO,SERIEFAC,FOLIOFAC,ESTATUS,NOCLIENTE,ESTACIONRECUP,HORA,FOLIOVOLUMETRICO,IDANTICIPO FROM DGASCUPO WHERE (FECHARECUP >='$fecha' AND FECHARECUP <= '$fecha2') "; 	
 			}
 			

 			
 			$vales = ibase_query($conexion,$query);

 			ibase_free_result($vales);  //  <-------
 			ibase_close($conexion);
 			
 			return $vales;

 		}

		public function REC_ESTACIONES($id_igas,$permiso)
		{
			$sucursales_aut=array();
			$sql =" SELECT DISTINCT IdEst.PERMISO_ESPECIAL, NameEst.ESTACION, NameEst.IP FROM PERMISOS_ESPECIALES IdEst join ESTACIONES NameEst on IdEst.PERMISO_ESPECIAL = NameEst.ID WHERE IDUSUARIO = '$id_igas' AND PERMISO = '$permiso'";

			$per_resul= ibase_query($this->conloc(),$sql);
				while ($r = ibase_fetch_assoc($per_resul))
				{
					array_push($sucursales_aut, $r);
				}

			return $sucursales_aut;

		} 		


 		public function valida_cupon($fecha_recuperacion,$estacion,$folio_cupon)
 		{
 			$folio=intval($folio_cupon) ;
 			$est=intval($estacion) ;
 			$obj=new conexionGAS;
 			$conexion=$obj->conectarGAS();
 			$sql= "SELECT * FROM DGASCUPO WHERE FOLIO = '$folio' AND ESTACION ='$est' AND FECHAVENTA>='10.05.2021'";

 			$datos = ibase_query($conexion,$sql);

 			ibase_free_result($datos);  //  <-------
 			ibase_close($conexion);
  			
 			return $datos;
 		}

 		/*new para validar por folio vol*/
 		public function trae_ip_est($estacion)
 		{
 			$IP=array();
 			$query ="SELECT ID, IP FROM ESTACIONES where ID = '$estacion'";
			$per_resul= ibase_query($this->conloc(),$query);
			while ($r = ibase_fetch_assoc($per_resul))
			{
				array_push($IP, $r);
			}

			//$dato= isset($IP[0]["IP"])?$IP[0]["IP"]:'No_Existe_IP_Est_BDLocal';

		return $IP;
 		}

/*
 		public function valida_siestafacturado_foliovol($IP_Est,$folio_volumetrico)
 		{


	 			$folio=intval($folio_volumetrico) ;
	 			$FACTURADO=array();
	 			$sql= "SELECT FECHA, FOLIO, COMBUSTIBLE, PRECIO, IMPORTE, FACTURADO, TIPOPAGO FROM DPVGMOVI WHERE FOLIO = '$folio'";

				$resul= ibase_query($this->conCONSOLA($IP_Est),$sql);
				while ($r = ibase_fetch_assoc($resul))
				{
					array_push($FACTURADO, $r);
				}

				//$dato= isset($FACTURADO[0]["FACTURADO"])?$FACTURADO[0]["FACTURADO"]:'No_Existe_FolioVol';
	  			
	 			return $FACTURADO; 

 		}
*/

 		public function valida_foliovol_new($estacion,$folio_volumetrico)
 		{
 		  $IPs=array();
 		  $obj= new Cupones;
 		  $IP=$obj->trae_ip_est($estacion);
 
 		  if (isset($IP[0]["IP"])){	
 		  		$IP_Est=$IP[0]["IP"];

	 			$folio=intval($folio_volumetrico) ;
	 			$FACTURADO=array();
	 			$sql= "SELECT FECHA, FOLIO, COMBUSTIBLE, PRECIO, IMPORTE, FACTURADO, TIPOPAGO, '$IP_Est' AS IP FROM DPVGMOVI WHERE FOLIO = '$folio'";
	 			
				$resul= ibase_query($this->conCONSOLA($IP_Est),$sql);
				if ($resul){
					while ($r = ibase_fetch_assoc($resul))
					{
						array_push($FACTURADO, $r);

					}
				}
					if (count($FACTURADO)==0)
				    { 
					  $FACTURADO[0]=["IP"=>$IP_Est];
					}
					//$FACTURADO[0]["IP"]=$IP_Est;

				//$FACTURADO= isset($FACTURADO[0]["FACTURADO"])?$FACTURADO[0]["FACTURADO"]:'No_Existe';
	  			
	 			return $FACTURADO; 
	 		}else{
		    	return 'Error';
		   }

 		}




 		public function traer_datos_ticket_cupones($estacion,$folio_volumetrico)
 		{
 		  /*
 		  $IPs=array();
 		  $obj= new Cupones;
 		  $IP=$obj->trae_ip_est($estacion);
 
 		  if (isset($IP[0]["IP"])){	*/
		   $obj2= new Cupones;
		   $FACTURADO=array();
           //$FACTURADO=$obj2->valida_siestafacturado_foliovol($IP[0]["IP"],$folio_volumetrico);
           $FACTURADO = $obj2->valida_foliovol_new($estacion,$folio_volumetrico);
           $ExisteFolVol = isset($FACTURADO[0]["FACTURADO"])?$FACTURADO[0]["FACTURADO"]:'No_Existe';
           

	 		   //if ($ExisteFolVol !='')
	 		   //{
		  		$datos=array();
		  		$datosx=array();	 		   	
	 			$foliovol=intval($folio_volumetrico);
	 			$est=intval($estacion) ;
	 			$obj3=new conexionGAS;
	 			$conexion=$obj3->conectarGAS();
	 			
	 			//$sql= "SELECT * FROM DGASCUPO WHERE FOLIOVOLUMETRICO = '$foliovol' AND ESTACION ='$est' AND (IDANTICIPO is not null) AND ESTATUS='R'";

	 			$sql= "SELECT * FROM DGASCUPO WHERE FOLIOVOLUMETRICO = '$foliovol' AND ESTACION ='$est'  AND FECHAVENTA>='10.05.2021'";

	 			$datos = ibase_query($conexion,$sql);
 					while ($r = ibase_fetch_assoc($datos))
						{
							array_push($datosx, $r);

						}

	 			ibase_free_result($datos);  //  <-------
	 			ibase_close($conexion);

 				/*FALTA AGREGAR VALIDACION DONDE SE LLEVE LOS DATOS DEL FOLIO VOLUMETRICO QUE SI LO PUEDE USAR
 				EN UN SOLO ARREGLO PARA VALIDARLO EN JS*/
				$arrayresult=array_merge($FACTURADO, $datosx);
	 			return $arrayresult; 		
	 		   
	 			//}
		
 		   /*
		   }else{
		    	return $IP;
		   }*/



		}

		public function update_cupones($estacion,$folio_volumetrico){

				//$resultado=array();
 		   	
	 			//$foliovol=intval($folio_volumetrico);
	 			//$est=intval($estacion) ;
	 			$obj=new conexionGAS;
	 			$conexion=$obj->conectarGAS();
	 			

	 			$SQL= "UPDATE DGASCUPO SET FECHARECUP = null, ESTATUS='V', ESTACIONRECUP = null, FOLIOVOLUMETRICO = null, COMBUSTIBLE= null, IMPORTE_DESP=null WHERE FOLIOVOLUMETRICO = '$folio_volumetrico' AND ESTACION ='$estacion' AND FECHAVENTA>='10.05.2021'";

	 			$resultado = ibase_query($conexion,$SQL);

	 			if($resultado){
	 			 return 'OK';

	 			}

	 			//ibase_free_result($resultado);  //  <-------
	 			ibase_close($conexion);

	 			return 'Error, los cupones no se guardaron'; 

		}




		public function guardar_datos_ticket_cupones($datos){

			//$folio_real=intval($datos['folio_vol']) +1000000000;
			$folio_real=intval($datos['folio_vol']);
			$FECHA=$datos['fecha_rec'];
			$COMBUSTIBLE=$datos['producto'];
			$VOLUMEN=$datos['importe_foliovol']/$datos['precio_foliovol'];
			$IMPORTE=$datos['importe_foliovol'];
			$PRECIO=$datos['precio_foliovol'];
			$ESTACION=$datos['empresa'];
			$CUPONES=isset($datos['cupones'])?$datos['cupones']:array();
			$GASID=rand(5,15);

		   $obj2= new Cupones;
		   $FACTURADO=array();
		   //$resul=array();
           //$FACTURADO=$obj2->valida_siestafacturado_foliovol($IP[0]["IP"],$folio_volumetrico);
           $FACTURADO = $obj2->valida_foliovol_new($ESTACION,$folio_real);
           $Facturado_NoExiste = isset($FACTURADO[0]["FACTURADO"])?$FACTURADO[0]["FACTURADO"]:'No_Existe';
           $IP = isset($FACTURADO[0]["IP"])?$FACTURADO[0]["IP"]:'No_Existe';
           

 		   if ($Facturado_NoExiste !='Si')
 		   {

 		   	if($Facturado_NoExiste== 'No_Existe'){

				$SQL="INSERT INTO DPVGMOVI (FOLIO,FECHA,HORA,POSCARGA,COMBUSTIBLE,VOLUMEN,IMPORTE,IMPRESO,APLICAR,FECHACORTE,CORTE,PRECIO,FACTURADO,TAG,FECHATURNO,TURNO,JARREO,MANGUERA,TIPOPAGO,REFERENCIABITACORA,CUPONIMPRESO,GASID,CONSIGNACION,DESCUENTO) VALUES ('$folio_real','$FECHA','$FECHA','1','$COMBUSTIBLE','$VOLUMEN','$IMPORTE','No','No','$FECHA','1','$PRECIO','No','0','$FECHA','1','No','1','0','0','No','$GASID','No','0.000')";
			   }else if($Facturado_NoExiste== 'No'){
			   			//$SQL="";
			   			
						$SQL ="UPDATE DPVGMOVI SET FECHA = '$FECHA', HORA = '$FECHA', FECHACORTE = '$FECHA', FECHATURNO = '$FECHA', COMBUSTIBLE = '$COMBUSTIBLE', VOLUMEN = '$VOLUMEN', PRECIO = '$PRECIO', IMPORTE = '$IMPORTE' WHERE FOLIO = '$folio_real'";		   			

			   		}else{return 'Error_en_valida_foliovol_new';}

			   	$resul= ibase_query($this->conCONSOLA($IP),$SQL);

			   	//Tengo que aplicar UPDATE regresando los cupones que consincidan con este folio vol desde aqui a estatus Vendido
			   	if ($resul){

			   	 $UpdateCupones=$this->update_cupones($ESTACION,$folio_real);

				   	//y con este for hacer UPDATE con los datos recibidos de nuevo a los cupones
				   if ($UpdateCupones =='OK'){
				    	$obj=new conexionGAS;
				        $conexion=$obj->conectarGAS();

						    for($i=0;$i<count($CUPONES);$i++){

						    	$foliocup=$CUPONES[$i]["FOLIO"];
						    	$importecup=$CUPONES[$i]["IMPORTE"];

						    	$SQL= "UPDATE DGASCUPO SET FECHARECUP = '$FECHA', ESTATUS='R', ESTACIONRECUP = '$ESTACION', FOLIOVOLUMETRICO = '$folio_real', COMBUSTIBLE= '$COMBUSTIBLE', IMPORTE_DESP='$importecup'  WHERE FOLIO = '$foliocup' AND ESTACION ='$ESTACION' AND FECHAVENTA>='10.05.2021'";
						    	//$resultado=array();
			 					$resultado = ibase_query($conexion,$SQL);

					 			if($resultado){

					 			 $RESPUESTA='Registro exitoso, datos guardados';

					 			}else{
					 				return 'Error, los cupones no se guardaron';
					 			}

						    	
						    }

						//ibase_free_result($resultado);  //  <-------
					 	ibase_close($conexion);
					 	$respuestaok= isset($RESPUESTA)?$RESPUESTA:'Registro exitoso, datos guardados';
					 	return $respuestaok;
					   

				   }else{ return 'Error, los cupones no se guardaron'; }


				}else{ return 'Error, el ticket no se guardo'; }
			    //return 'Ticket Guardado';

//*/

			}else{ return 'Error, el ticket ya fue facturado'; }
			//return $FACTURADO;

		}



 		
}
 	?>