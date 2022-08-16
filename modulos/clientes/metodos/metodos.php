<?php 



include '../../../conexionGas.php';
include '../../../ConexionADMON.php';
require_once( '../../../conexion.php');
include("../../../general/funciones.php");

class metodosclientes
{
	
	
	public function conexionventas()
	{
		$con  = new conexionADMON();
		$conexion = $con->conectarADMON();
		return $conexion;
	}

	public function conexiongas()
	{
		$con  = new conexionGAS();
		$conexion = $con->conectarGAS();
		return $conexion;
	}
	public function tarjetas($id)
	{
		(int)$id;
		$sql ="SELECT  COUNT(*) as TARJETAS FROM DGASTARJ  WHERE  ESTATUS  = 'Activa' AND NOCLIE = '$id'";
		$numero = ibase_query($this->conexiongas(),$sql);
		$tarjetas = ibase_fetch_assoc($numero);
		ibase_free_result($numero);
		ibase_close($this->conexiongas());
		return $tarjetas["TARJETAS"];
	}

	public function datos_clientes($id)
	{
		(int)$id;
		$tarjetas  = $this->tarjetas($id);
		$sql = "SELECT * FROM DGENCLIE WHERE NOCLIE  = '$id'";
		$execute = ibase_query($this->conexionventas(),$sql);
		$datos  = ibase_fetch_assoc($execute);
		$datos["TARJETAS"] = $tarjetas;

		return $datos;
	}

	public function buscador_clientes_rfc($rfc)
	{
		$gene = new generales();

		$conexionventas =$this->conexionventas();
		$rfc2= " ".$rfc;
		$sql = "SELECT * FROM  DGENCLIE WHERE RFC  = '$rfc' OR RFC = '$rfc2'";

		$cliente= ibase_query($conexionventas,$sql);
		$contador = 0;
		$arraydatos = array();
		$tarjetas = "";
		while ($cli = ibase_fetch_assoc($cliente)) {
			$nombre = $gene->reparar_utf8($cli["NOMBRE"]);
			// $nombre  = utf8_decode($nombre);
			$tarjetas = $this->tarjetas($cli["NOCLIE"]);
			$datos = array("id" => $cli["NOCLIE"],
				"nombre" =>$nombre ,
				"rfc" => $cli["RFC"], 
				"tarjetas" =>$tarjetas
				,"tipo" =>$cli["CREDITO"]);

			$arraydatos[] = $datos;
			$contador++;
		}
		
		if ($contador > 0) {
			return json_encode($arraydatos);

		}else{
			$arraydatos = [];
			return json_encode($arraydatos);
		}
	}
}

?>