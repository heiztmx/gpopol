<?php 

/**
 * 
 */

   
      

class encabezados
{
	
public 	function elegir_enca(){
// session_start();
 $usuario = $_SESSION['user'];
		$con = new conexion();
		$conexion = $con->conectar();

		$consulta = "SELECT PRIVILEGIO FROM USUARIOS WHERE USUARIO = '$usuario'";
		$privilegio = ibase_query($conexion,$consulta);
		$row =ibase_fetch_assoc($privilegio);
		$pri =$row['PRIVILEGIO'];

	switch ($pri) {
		case 1:
		echo $usuario;

			 include '../encabezado.php';
		
			break;
		
		case 2 : 
		echo $usuario;
		 include '../encabezado2.php';
		
		break;

		case 0: 
		echo $usuario;
		 include '../encabezado3.php';
		 echo $c3;
	}
}

	

}
 ?>