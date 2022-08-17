<?php 



	class conexionGAS{
	
	function conectarGAS() {
	try {
		// $host='localhost:C:\\BD\\GASOLINERA.FDB';
	     $host='172.16.1.25:C:\\Imagenco\\dbi\\Imagen\\GASOLINERA.FDB';
		$user="SYSDBA";
		$password="masterkey";
		
		$conexion=ibase_connect($host,$user,$password);
 
			return $conexion;
	} catch (Exception $e) {
		
		return $e;
	}
	
	}

	function conectarGASconsola($estacion)
	{
		try {
			// $host='localhost:C:\\BD\\GASOLINERA.FDB';
		    $host=$estacion.':C:\\Imagenco\\Dbi\\consola\\GASCONSOLA.FDB';
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
