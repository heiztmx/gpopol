<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="../menu/bootstrap-3.3.7-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../menu/bootstrap-3.3.7-dist/css/bootstrap.css">

<script src="../javascript/jquery-3.3.1.min.js"></script>
<script src="../menu/bootstrap-3.3.7-dist/js/bootstrap.js"></script>
<script src="../menu/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../bootstrapcss/stylelogin.css">
<script src="js/funciones.js"></script>
 <script src="../lottie/player/lottie.min.js"></script>
<head>
	<meta charset="UTF-8">
	<title>Registro de usuarios</title>
</head>
<body>
	
	<div class="contenedor_registro" >

		<div class="" style="width: 100%">
			<h3 style="text-align: center;">Registro de usuario</h3>
			<div class="form-group cont_input">
				<label for="exampleInputEmail1">Nombre</label>
				<input type="text" class="form-control" id="" placeholder="Nombre">
				
			</div>
			<div class="form-group cont_input">
				<label for="exampleInputEmail1">Email</label>
				<input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email">
				
			</div>
			<div class="form-group cont_input">
				<label for="exampleInputPassword1">Contraseña</label>
				<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
				<small id="emailHelp" class="form-text text-muted">Haga una constraseña con letras y numeros</small>
			</div>

			<div class="centrar">
				<button id="btn_registrar" class="btn btn-primary mx-auto" onclick="registro_usuario()" >Registrar</button>
			</div>
		</div>
	</div>
</body>
</html>