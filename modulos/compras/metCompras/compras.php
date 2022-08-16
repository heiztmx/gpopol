<?php 



/**
 * 
 */

include '../../../ConexionADMON.php';
include '../../../general/funciones.php';
class metodos_compras 
{



	public function Conexion_ventas()
	{
		$obj = new conexionADMON();
		$conexion  = $obj->conectarADMON();
		return $conexion;
	}


	public function Conexion_admon()
	{
		$obj = new conexionADMON();
		$conexion  = $obj->conectarADM();
		return $conexion;
	}

	public function informacion_general($sucursal,$serie,$folio)
	{
		$conexion_ventas  = $this->Conexion_ventas();
		$sql  = "SELECT * FROM DINVREQU WHERE SUCURSAL  = '$sucursal' AND SERIE  =  '$serie' AND FOLIO  = '$folio' ";

		$exe  = ibase_query($conexion_ventas,$sql);
		$datos  = ibase_fetch_assoc($exe);
		return $datos;
	}


	public function proveedores1()
	{
		
		$sql = "SELECT NOPROV, NOMBRE FROM DGENPROV WHERE ACTIVO  = 'Si'";
		$proveedores = [];
		$prov = ibase_query($this->Conexion_admon(),$sql);

		while ($row = ibase_fetch_assoc($prov)) {
			$proveedores[$row["NOPROV"]] = $row;
		}
		return $proveedores;

	}

	public function por_proveedor($sucursal,$serie,$folio)
	{
		$conexion_ventas  =$this->Conexion_ventas();
		$sql  = "SELECT * FROM DINVREQUD  WHERE SUCURSAL  = '$sucursal' AND SERIE  =  '$serie' AND FOLIO  = '$folio' ";
		$exe  = ibase_query($conexion_ventas,$sql);
		$proveedores = array();
		$proveedores_nombre =array();
		$productos =array();
		$gen  = new generales();
		$datos_proveedor = $this->proveedores1();
		define("SINPROVEEDOR", "00000001");
		while ($r = ibase_fetch_assoc($exe)) {
			


			$id_proveedor = $r["PROVEEDOR"];
			$nombre_prov ="";


			if (array_key_exists($id_proveedor, $datos_proveedor)) {
				$da = $datos_proveedor[$id_proveedor];

				$nombre_prov = $da["NOMBRE"];
				// print_r($nombre_prov);
			}else{
				$nombre_prov = "SIN PROVEEDOR";
			}


			$r["DESCRIP_PRODUCTO"] = $gen->reparar_utf8($r["DESCRIP_PRODUCTO"]);
			if ($id_proveedor  == ""  || $id_proveedor  == null) {
				$r["PROVEEDOR"] = SINPROVEEDOR;
				$id_proveedor = SINPROVEEDOR;
			}

			if (!in_array($id_proveedor, $proveedores)) {
				$combinar = $id_proveedor."|".$gen->reparar_utf8($nombre_prov);
				array_push($proveedores, $id_proveedor);
				array_push($proveedores_nombre, $combinar);
			}
			array_push($productos, $r);
		}
		// sort($proveedores);
						array_multisort($proveedores_nombre,SORT_ASC,$proveedores);

		$resultado = ["proveedores_nombre" =>$proveedores_nombre,"proveedores"=>$proveedores, "productos"=>$productos, "id_sin_proveedor"=>SINPROVEEDOR];
		return $resultado;
	}




}


?>