<!DOCTYPE html>
<html lang="en">
<head>

	<?php 

	include "../../../conexion/sesion.php";
	$ses = new sesion();
	$permisos = $ses->validar_sesion();
	include '../../../menu/menu2.php';
	include '../../cartera/metGASOLINERA/metodosGASOLINERA.php';

	$gas = new GASOLINERA();
	$estaciones = $gas->estaciones();
	?>
	<meta charset="UTF-8">
	<title>Eliminación de liquidaciones</title>
	
	<script src="../../compras/jsCompras/funCompras.js"></script>
	<script src="../jsHerramientas/liquidaciones.js"></script>
	<link rel="stylesheet" href="../../../bootstrapcss/liquidacionescss.css">
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
</head>
<body>
	<br>
	<br>
	<br>
	<br>
	<br><br>
	<div class="row"></div>
	<div class="col-lg-12" style=""><h4 style=" font-weight: bold;" id="titulo_estado"> Modulo liquidaciones</h4></div>
	<div class="col-lg-12 d-flex flex-wrap justify-content-between mx-auto" style="">

		<div class="col-lg-6  mx-auto separador"  >
			<div class="col-lg-12 d-flex " id="">
				<label for="example-datetime-local-input" class="col-lg-3 col-form-label" id="" style="text-align: center;">Fecha</label>
				<input class="form-control col-lg-7"   type="date"  id="fecha_buscar_liq"  style="" >
			</div>

		</div>

		<div class="col-lg-6 mx-auto separador" style="">
			<div class="col-lg-12 d-flex " id="">
				<label for="example-datetime-local-input" class="col-lg-3 col-form-label" id="" style="text-align: center;">Estación</label>
				<select name="" id="estaciones" class="col-lg-7 form-control">
					<?php 
					
					// print_r($estaciones);
					for ($i=0; $i <count($estaciones) ; $i++) { 
						echo "<option value='".$estaciones[$i]["ID"]."'>".$estaciones[$i]["ESTACION"]."</option>";
					}
					?>
					
				</select>
			</div>
		</div>
	</div>


	<div class="col-lg-12 d-flex flex-wrap justify-content-between" style="">

		<div class="col-lg-6 mx-auto separador"   style="">
			<div class="col-lg-12 d-flex " id="">
				<label for="example-datetime-local-input" class="col-lg-3 col-form-label" id="" style="text-align: center;">Isla</label>
				<input class="form-control col-lg-7"   type="text"  id="isla"  style="" >
			</div>

		</div>
		<br>
		<div class="col-lg-6 mx-auto separador" style="">
			<div class="col-lg-12 d-flex " id="">
				<label for="example-datetime-local-input" class="col-lg-3 col-form-label" id="" style="text-align: center;">Turno</label>
				<select name="turnos" id="turnos" class="col-lg-7 form-control">
					<option value="1">1</option>	
					<option value="2">2</option>			
					<option value="3">3</option>			
					<option value="4">4</option>							
				</select>
			</div>
		</div>
	</div>

	<div class="d-flex  justify-content-center mx-auto" style="margin-top: 10px;"> 
		<button style="text-align: center;"  type="submit" class="btn btn-primary my-1" onclick="buscar_liquidaciones()">Generar</button></div>


		<table  id="liquidaciones"  class="display cell-border compact hover table-striped table-bordered" style="width:100%; ">
			<thead>

				<tr>

					<th>Fecha</th>
					<th>Estacion</th>
					<th>Folio</th>
					<th>Isla</th>
					<th>Turno</th>
					<th>Total</th>
					<th></th>


				</tr>
			</thead>
			<tbody></tbody>
			<tfoot>
				<tr>

					<th>Fecha</th>
					<th>Estacion</th>
					<th>Folio</th>
					<th>Isla</th>
					<th>Turno</th>
					<th>Total</th>
					<th></th>
				</tr>
			</tfoot>
		</table>



<!-- <input type="checkbox" data-toggle="toggle" data-on="Enabled" data-off="Disabled"> -->
<!-- <div id="console-event"></div> -->

<!-- <button onclick="bloquear_liquidacion()">click</button> -->
<script>
  $(function() {
    $('#toggle-event').change(function() {
 	if (    $(this).prop('checked')) {
 		alert("activo")
 	}else{
 		alert("desactivo")
 	}
    })
  })
</script>
	</body>
	</html>