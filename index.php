<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<title>Portal de Cupones</title>
	<script src="javascript/jquery-3.3.1.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<link rel="shortcut icon" href="favicon.ico" />
	<link rel="stylesheet" href="bootstrapcss/stylelogin.css">
	<script src="modulos/precios/js/logear.js"></script>
	<link rel="shortcut icon" href="favicon.png">

</head>


<body>


	<div class=" d-flex justify-content-end div_padre_boton" >
		<div class="contenedor_boton_registro">
			<!--<a target="_blank" href="general/registro"  class=" btn-link">Registrarse</a>-->
		</div>
	</div>

	<div class="row col-lg-5 col-sm-10   mx-auto div_contenedor" >

		<form class="mx-auto col-lg-12 m-5">
			<div class=" col-lg-10 row mx-auto " >
				<figure class="row mx-auto" >
					<img src="imagenes/oxxo_gas.png" class="img-responsive" alt="">
				</figure>
			</div>
			<div class="form-group d-flex flex-column col-lg-12  mx-auto m-3">
				<p id="errorlogin"></p>
				<input type="text" class="form-control col-lg-10 mx-auto" id="user" placeholder="Usuario">
			</div>

			<div class="form-group d-flex flex-row col-lg-12 mx-auto">

				<input type="password" class="form-control col-lg-10 mx-auto" id="contr" placeholder="Contraseña">
			</div>
			<div class="row d-flex flex-row col-lg-12 mx-auto flex-column">
				<button type="button" class="btn btn-secondary mx-auto col-lg-10 p-2 m-3" id="btnlogin" onclick="logear()">Entrar</button>
				<a target="_blank" href="general/envio_correo" class="mx-auto">Olvidé mi contraseña</a>
			</div>
			<div class="row m-3">
	
			</div>
		</form>
	</div>


</body>

</html>