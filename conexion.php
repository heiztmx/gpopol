<?php 
 //movi algo 
 // Heriberto Izquierdo


class conexion{
	
	function conectar() {
		try {
			$host='\\BD\\WEBPRECIOS.FDB';
			$user="SYSDBA";
			$password="masterkey";

			$conexion=ibase_connect($host,$user,$password);

			return $conexion;
		} catch (Exception $e) {

			return $e;
		}

	}

	function variables_compras()
	{
		$ip_xampp = "172.16.0.4";
		$ip_WSgpopol= "172.16.0.35:9093";

		return $datos =array("ip_xampp"=>$ip_xampp,"ip_WSgpopol"=>$ip_WSgpopol);
	}

}



?>
