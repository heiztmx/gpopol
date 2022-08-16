<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Nueva contraseña</title>

	<script src="../javascript/jquery-3.3.1.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="stylesheet" href="../bootstrapcss/stylelogin.css">
	<script src="js/funciones.js"></script>
	<script src="../lottie/player/lottie.min.js"></script>

	
	<script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
	<script src="../sweetAlert2/dist/sweetalert2.min.js"></script>
	<link rel="stylesheet" href="../sweetAlert2/dist/sweetalert2.min.css">

</head>
<body>
	<?php 

	


	$clave = $_GET["clave"];
	$id = $_GET["id"];


	 ?>
	<div class="row col-lg-5 col-sm-10   mx-auto div_contenedor">
		<form class="mx-auto col-lg-12 m-5" id="formulario_contrasenia" >
			<h3 style="text-align: center;">Restauracion de contraseña</h3>
			<div class=" col-lg-10 row mx-auto" style="">
				<figure class="row mx-auto" style="height: 13.5rem; width: 15rem;" id="contenedor_animacion">

				</figure>
			</div>
			<div class="form-group d-flex flex-column col-lg-12  mx-auto m-3">
				<p id="errorlogin"></p>
				<input type="password" class="form-control col-lg-10 mx-auto text-center" id="pass" placeholder="Contraseña">
			</div>

			<div class="form-group d-flex flex-row col-lg-12 mx-auto">

				<input type="password" class="form-control col-lg-10 mx-auto text-center" id="pass_confirmacion" placeholder="Confirmacion de contraseña">
				<input type="text" style="display: none;" id="datos" value="<?php echo $clave.'||'.$id ?>">
			</div>
			<div class="row d-flex flex-row col-lg-12 mx-auto flex-column">
				<button type="button" class="btn btn-secondary mx-auto col-lg-10 p-2 m-3" id="btnlogin" onclick="reset_password()">Cambiar contraseña</button>

			</div>
			<div class="row m-3">

			</div>
		</form>

		<div class="mx-auto col-lg-12 m-5" id="respuesta_contrasenia" style="display: none;">
			<h3 style="text-align: center;" id="titulo"></h3>
			<div class=" col-lg-10 row mx-auto" >
				<figure class="row mx-auto" style="height: 11.5rem; width: 15rem;" id="contenedor_animacion_contrasenia" >

				</figure>
			</div>
			<div>
				<p style="text-align: center;" id="explicacion"></p>
			</div>
		</div>
	</div>
</body>


<script>
	
	$( document ).ready(function() 
	{
		animations_lottie_password() 
		// animations_lottie()

	});



	function animations_lottie_password() {

		lottie.loadAnimation({
		container: document.getElementById('contenedor_animacion'), // the dom element that will contain the animation
		renderer: 'svg',
		loop: true,
		autoplay: true,
		path: 'assets/contrasenia.json' // the path to the animation json
	});

	}

</script>
</html>