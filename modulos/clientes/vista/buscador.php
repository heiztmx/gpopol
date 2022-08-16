<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Buscador de clientes</title>
</head>
<body>
	<h4 style=" font-weight: bold; position: relative; top: -25px;" id="titulo_estado">Buscador de clientes</h4>




	<div class="col-lg-9" style="display: flex;justify-content: center;align-items: center;">

		<input  class="form-control  col-lg-10" type="text" id="buscar_rfc" name="Buscar nombre" placeholder="Buscar nombre">	
		<div class="col-lg-2 d-flex justify-content-center">
			<button type="button" class="btn btn-primary " id="" onclick="buscador_clientes()">Buscar</button>
		</div>
	</div>

	<table id="tabla_clientes" class="display cell-border compact hover table-striped table-bordered" style="width:100%; margin-top: 10px;">
		<thead>
			<tr>
				<td>ID</td>
				<td>NOMBRE</td>
				<td>RFC</td>
				<td>TARJETAS</td>
				<td>Solicitud</td>
			</tr>
		</thead>

	</table>
	<br>
</body>
</html>