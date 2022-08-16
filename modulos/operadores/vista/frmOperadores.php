<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Formulario Operadores</title>
</head>

<body>
	<?php
	include '../../precios/webprecios/metodosweb.php';
	$objeto = new metodosweb();
	$estaciones = $objeto->tablaEstaciones();


	?>


	<h5 style="text-align: center;">Escriba los datos del Operador</h5>
	<br>
	<div class="container col-lg-8 mx-auto m-2" style="border: 1px #C1C1C1 solid">
		<div class="container col-lg-5">


			<div class="form-group">
				<br>
				<label for="inputIDOperador">Identificador de operador</label>
				<input style="text-align: center;" type="text" class="form-control" id="inputIDOperador" disabled="">
			</div>
		</div>
		<div class="d-flex flex-wrap justify-content-between align-items-center  col-lg-12">

			<div class=" col-lg-6">
				<div class="form-group">
					<br>
					<label for="inputNombreOperador">Nombre</label>
					<input type="text" class="form-control" id="inputNombreOperador" placeholder="Nombre completo">
				</div>
				<div class="form-group">
					<label for="selectEstacion">Estaciones</label>
					<select class="form-control" id="selectEstacion">

						<?php
						while ($row = ibase_fetch_assoc($estaciones)) {
							echo "<option value=" . $row["ID"] . ">" . $row["ESTACION"] . "</option>";
						}
						?>

					</select>
				</div>
				<div class="form-group">
					<label for="inputPasswordOperador">NIP</label>
					<input type="text" class="form-control" id="inputPasswordOperador" placeholder="Password">
				</div>

			</div>
			<!-- --------------------------------------- -->
			<div class="col-lg-5 ">
				<div class="form-group">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" id="chbActivo" value="Si">
						<!-- 					      <input class="form-check-input" type="checkbox" id="gridCheck" value="No"> -->
						<label class="form-check-label" for="chbActivo">
							Activo
						</label>
					</div>
				</div>

				<div class="form-group">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" id="chbJefe" value="Si">
						<!-- 					      <input class="form-check-input" type="checkbox" id="gridCheck" value="No"> -->
						<label class="form-check-label" for="chbJefe">
							Jefe
						</label>
					</div>
				</div>
				<div class="form-group">
					<label for="tipo">Tipo de Operador</label>
					<select class="form-control" id="tipo">
						<option value="Local">Local</option>
						<option value="Global">Global</option>

					</select>
				</div>



			</div>
		</div>
	</div>
</body>

</html>