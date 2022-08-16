<?php 

session_start();

if(isset($_SESSION['user']) &&  $_SESSION['logeado']== true){

}else{

	

header( "refresh:50; url=../index.php");
   echo "No haz iniciado sesion";

}

		$now = time();

 

		if($now > $_SESSION['expiro']) {

			

		session_destroy();

 
		echo "Su sesion a terminado,

				<a href='../index.php'>Necesita Hacer Login</a>";
exit;

}



 ?>