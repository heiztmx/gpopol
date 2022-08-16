<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
	<?php 

	include '../metproductos/productos.php';
	$obj = new GASOLINERA();
	$estaciones= $obj->estaciones();
	?>

</head>
<body>
	<h4>Agregar productos</h4>

	<div>
		<div class="container d-flex flex-wrap col-lg-8 mx-auto justify-content-between">
			<div class="form-group col-lg-4">
				<label for="grupo_estaciones">Estaciones</label>
				<select class="form-control" id="grupo_estaciones" onchange="producto_x_estacion()">
					<option value="opcion" selected="">Seleccione estacion</option>
					<?php 

					for ($i=0; $i <count($estaciones) ; $i++) { 
						$id_estacion = $estaciones[$i]["ID"];
						$name_estacion = $estaciones[$i]["ESTACION"];
						echo "<option value='".$id_estacion."'>".$name_estacion."</option>";
					}
					?>
				</select>
			</div>
			<div class="col-lg-4 form-group ">
				<label for="">Catalogo</label>
				<select name="" id=""   class="form-control">
					<option value="">Servicio</option>
					<option value="" selected="">Pieza</option>
					<option value="">Litro</option>
				</select>
			</div>
		</div>
		<div class="container d-flex flex-wrap  justify-content-between " >
			<div class="form-group col-lg-3 ">
				<label for="formGroupExampleInput">Folio</label>
				<input type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input">
			</div>
			<div class="form-group col-lg-6 ">
				<label for="formGroupExampleInput">Nombre</label>
				<input type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input">
			</div>

			<div class="form-group col-lg-3 ">
				<label for="formGroupExampleInput">Folio</label>
				<input type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input">
			</div>
		</div>

	</div>


</body>
</html>