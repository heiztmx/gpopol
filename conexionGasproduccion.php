<?php 

//Heriberto Izquierdo

class conexionGASProduccion{
	
	function produccionGas() {
		try {
			// $host='localhost:C:\\BD\\GASOLINERA.FDB';
	  $host='C:\\Imagenco\\dbi\\Imagen\\GASOLINERA.FDB';
			$user="SYSDBA";
			$password="masterkey";
			
			$conexion=ibase_connect($host,$user,$password);

			return $conexion;
		} catch (Exception $e) {
			
			return $e;
		}
		
	}
}



?>