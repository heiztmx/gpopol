<?php 
session_start();
if(isset($_SESSION['user']) &&  $_SESSION['logeado']== true){




 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Agregar Usuarios</title>
	<link rel="stylesheet" href="../css/normalize.css">


	<link rel="stylesheet" href="../css/styleprecios.css">
	
	<link rel="stylesheet" href="../css/styleUsuarios.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">


<!-- Buenas librerias hasta ahora -------------- -->
<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="../js/mobiscroll-1.5.1.js" type="text/javascript"></script>
<!-- --------------------------------------------- -->

</head>
<body>


<?php 

include 'metodosweb.php';
include 'elegir-encabezado.php';
$x = new  encabezados();
$enca = $x->elegir_enca();

?>

<script language=Javascript>
function guardarUsuario(){

formulariousu.action='insertUser.php';
formulariousu.submit();
}
</script> 

	<a class="enlace" href="#modal3">REDIMENSIONAR</a>
	
<div id="modal3" class="modalmask">
    <div class="modalbox resize">
        <a href="#close" title="Close" class="close">X</a>
     <form id="formulariousu" action="insertUser.php" method="POST">
	
	<!-- 	<script src="../js/selec-checkbox.js"></script>	 -->
	<h2>Registro de Usuarios Nuevos</h2>
			<h3>Tipo de usuario:</h3>
			<div id="privilegios">
			 <label class="tipos" for="">
				<input  type="radio" id="priv1" name="privilegio" value="0" class="radios" >Consulta
			</label>

			<label class="tipos" for="">
				<input  type="radio" id="priv2" name="privilegio" value="1" class="radios" >Operador
			</label>

			<label class="tipos" for="">
				<input  type="radio" id="priv3" name="privilegio" value="2"  class="radios">Administrador
			</label>
		
	</div>
	<p id="respUsuariov" style="color: #008558; text-align: center;"></p>
		<p id="respUsuariox" style="color: red; text-align: center;"></p>
		<div id="informacionUsuario">
			
			<div class="datos">
<!-- 				<i id="icono" class="fas fa-user ico"></i> -->
				<input class="contenedor" type="text" name="usuario" placeholder="Usuario" id="usuariomodal">
			</div>
				<div class="datos">
				
				<!-- <i id="icono"  class="fas fa-key ico"></i> -->
				<input class="contenedor"  type="password" name="password" placeholder="Password" id="passwordmodal">
			</div>
				<div class="datos">
				<!-- <i id="icono" class="fas fa-address-card ico"></i> -->
				<input class="contenedor" type="text" name="nombre" placeholder="Nombre completo" id="nombremodal" >
			</div>
		</div>

		<div id="botonesUsurio">
			<input type="submit" value="Guardar" class="botonUsuario" id="aceptarUsuario">

		</div>

	</form>  
    </div>
</div>
</body>
</html>
<?php 
} else {
	header("location:../index.php");
}

 ?>