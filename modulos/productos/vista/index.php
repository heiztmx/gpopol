<?php

include "../../../conexion/sesion.php";




$ses = new sesion();
$permisos = $ses->validar_sesion();

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Lista de productos</title>
	<?php include '../../../menu/menu2.php' ?>
</head>
<!-- <script src="../../../javascript/jquery-3.3.1.min.js"></script> -->
<script src="../../precios/js/cambioSubmenu.js"></script>
<script src="../js/productos.js"></script>
<script src="../js/validaty.js"></script>
<link rel="stylesheet" href="../../../bootstrapcss/productos.css">
<body>
	
	<?php include '../submenus/menuproductos.php';
		include '../modals/modal_eliminar.php';
		include '../modals/modal_agregar_productos.php';
		include '../modals/modal_asignar_precio.php';
		?>

	<br>
	<br>
	<br>
	<br>
	<br>
	<br>



	<br>
	
	<h4 style=" font-weight: bold; position: relative; top: -25px;" id="titulo_estado">Productos</h4>

	<div class="col-lg-12">
		<div class="form-group col-lg-4 d-flex justify-content-between">
			<div style="display: flex;justify-content: center;align-items: center;padding: 10px;"><label for="grupo_estaciones">Estaciones</label></div>
			<select class="form-control" id="grupo_estaciones" onchange="producto_x_estacion()">
				<option value="opcion" selected="">Seleccione estacion</option>
				<?php 


				for ($i=0; $i <count($estaciones_check) ; $i++) { 
					$id_estacion = $ids_estaciones[$i];
					$name_estacion = $estaciones_check[$i];
					echo "<option value='".$id_estacion."'>".$name_estacion."</option>";
				}
				?>
			</select>
		</div>
	</div>
	<table class="display cell-border compact hover table-striped table-bordered" style="width:100%; "id="tabla_productos">
		<thead>
			<tr>
				<th scope="col">ID</th>
				<th scope="col">Nombre</th>
				<th scope="col">Unidad</th>
				<th scope="col">Precio</th>
				<th scope="col">Codigo</th>
				<th scope="col" style="display: none;">Estacion</th>
				<th scope="col" style="display: none;">Activo</th>
				<th scope="col" style="display: none;">Linea</th>
				<th scope="col">Acciones</th>

			</tr>
		</thead>
		<tbody>

		</tbody>
	</table>
	<!-- <ul id="the-node">
	

	</ul>	 -->
	
	
</body>
</html>