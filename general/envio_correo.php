<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Recuperación de contraseña</title>
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



	<div class="row col-lg-5 col-sm-10   mx-auto div_contenedor">
		<form class="mx-auto col-lg-12 m-5" id="formulario_password" >
			<h3 style="text-align: center;">Recuperación de contraseña</h3>
			<div class=" col-lg-10 row mx-auto" style="">
				<figure class="row mx-auto" style="height: 11.5rem; width: 15rem;" id="contenedor_animacion">

				</figure>
			</div>
			<div class="form-group d-flex flex-column col-lg-12  mx-auto m-3">
				<p id="errorlogin"></p>
				<input type="email" class="form-control col-lg-10 mx-auto text-center" id="email" placeholder="Correo">
			</div>

			<div class="form-group d-flex flex-row col-lg-12 mx-auto">

				<input type="email" class="form-control col-lg-10 mx-auto text-center" id="email_confirmacion" placeholder="Confirmacion de correo">
			</div>
			<div class="row d-flex flex-row col-lg-12 mx-auto flex-column">
				<p id="enviando_wait" style="text-align: center;display: none;"><strong>Enviado...</strong></p>
				<button type="button" class="btn btn-secondary mx-auto col-lg-10 p-2 m-3" id="btnlogin" onclick="enviar_email()">Recuperar</button>

			</div>
			<div class="row m-3">

			</div>
		</form>

		<div class="mx-auto col-lg-12 m-5" id="respuesta_email" style="display: none;">
			<h3 style="text-align: center;" id="titulo_email"></h3>
			<div class=" col-lg-10 row mx-auto" >
				<figure class="row mx-auto" style="height: 11.5rem; width: 15rem;" id="contenedor_animacion_email" >
				
				</figure>
			</div>
			<div>
				<p style="text-align: center;" id="explicacion">Se enviado un correo  a la direccíon <strong id="correo_txt"></strong>.De no encontrarlo en su bandeja de entrada , verificar su carpeta de spam</p>
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
		loop: false,
		autoplay: true,
		path: 'assets/candado.json' // the path to the animation json
	});

	}

</script>
</html>