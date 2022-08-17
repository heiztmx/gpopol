<?php 



	class conexionADMON{
	
	function conectarADMON() {
	try {
		//tablaDGNCLI
		// $host='localhost:C:\\BD\\VENTAS.FDB';
		$host='172.16.1.25:C:\\Imagenco\\dbi\\Imagen\\VENTAS.FDB';
		$user="SYSDBA";
		$password="masterkey";
		
		$conexion=ibase_connect($host,$user,$password);

			return $conexion;
	} catch (Exception $e) {
		
		return $e;
	}
	
	}

	public function conectarADM()
	{
			try {
		//tablaDGNCLI
		// $host='localhost:C:\\BD\\ADMON.FDB';
		$host='172.16.1.25:C:\\Imagenco\\dbi\\Imagen\\ADMON.FDB';
		
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