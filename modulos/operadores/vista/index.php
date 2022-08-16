<?php


include "../../../conexion/sesion.php";

$ses = new sesion();
$permisos = $ses->validar_sesion();

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Operadores de Estaciones</title>
	
	<script src="../jsOperadores/modificacionOperadores.js"></script>
	<link rel="stylesheet" href="../../../bootstrapcss/estiloListado.css">
	<link rel="stylesheet" href="../../../bootstrapcss/despachadores.css">
</head>

<body>
	<?php
	include '../../../menu/menu2.php';
	include '../metOperadores/metodosOperadores.php';
	include '../../../general/funciones.php';
	$gen  = new generales();
	$metodo = new metodosweb();
	$find_permisos=$metodo->permisos_del_upd($_SESSION["user"],"OPERADORES");
	$metodoGAS = new Operadores();
		// $priv = $objeto->ElegirPrivilegios($_SESSION['user']);
	$digito="2";
	$arrayEstaciones = array();
	$idsEst = array();
	$estaciones = $metodo->tablaEstaciones();
	while ($est = ibase_fetch_assoc($estaciones)) {
			# code...
		array_push($arrayEstaciones, $est["ESTACION"]);
		array_push($idsEst, $est["ID"]);
	}

	include '../submenus/menuoperadores.php';

	?>
	<!-- 		<script src="../../../js/clickModulo3.js"></script> -->


	<!-- <div class=" row m-5"></div> -->
	<br>
	<br>
	<br>
	<br>
	<br>



	<h5 id="tituloOperadores" style="text-align: left; font-weight: bold; position: relative; top: 0px;">Operadores de Estaciones</h5>


	<script>
		$(document).ready(function() {
			$("#myInput").on("keyup", function() {
				var value = $(this).val().toLowerCase();
				$("#myTable #tabla_Operadores").filter(function() {
					$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
			});
		});
	</script>


	<div class="m-1">

	</div>

	<div id="buscadorOperadores">
		<small id="emailHelp " class="form-text text-muted">Escribe el dato que desee filtrar</small>
		<input class="form-control " type="text" id="myInput" name="Buscar" placeholder="Buscar">
	</div>

	<div id="cargadorOperadores">

	</div>


	<br>
	<div id="contenedor_tabla">
		<table class="table table-hover mx-auto table-sm" id="myTable">
			<thead class="thead-dark">

				<tr style="background-color: #F7F7F9">
					<!-- <td  id="folio" style="text-align: center;font-weight: bold;" scope="col">Clave</td> -->
					<th id="estacion" class="letras" style="text-align: left;font-weight: bold;" scope="col">Nombre</th>
					<th id="fecha" class="letras" style="text-align: center;font-weight: bold;" scope="col">Estacion</th>
					<th id="hora" class="letras" style="text-align: center;font-weight: bold;" scope="col">Nip</th>

					<th id="magna" class="letras" style="text-align: center;font-weight: bold;" scope="col">Activo</th>
					<th id="premium" class="letras" style="text-align: center;font-weight: bold;" scope="col">
						<!--Jefe-->
					</th>
					<th id="diesel" class="letras columOcultas" style="text-align: center;font-weight: bold;" scope="col">Tipo</th>


				</tr>
			</thead>
			<?php

			$metGAS = $metodoGAS->Despachadores();
			$EstacionAsignada = "";
			$i = 0;

			while ($row = ibase_fetch_assoc($metGAS)) {
				for ($i = 0; $i < count($arrayEstaciones); $i++) {
					if ($row["ESTACION"] == $idsEst[$i]) {
						$EstacionAsignada = $arrayEstaciones[$i];
						break;
					}
				}

				$datos = $row['CLAVE'] . "||" . $row['NOMBRE'] . "||" .
				$EstacionAsignada . "||" . $row["ACTIVO"] . "||" . $row["ES_JEFE_DE_TURNO"] . "||" . $row["TIPO_DESPACHADOR"] . "||" . $row["PASSW"];
				?>
				<tbody>




					<tr id="tabla_Operadores">
						<?php
						if ($find_permisos == true) {


							?>
							<td onclick="formularioOperadores('<?php echo $datos; ?>' ,'<?php

								foreach ($arrayEstaciones as $valor) {
									echo $CadenaEst = $valor . "--";
								}
								?>','<?php foreach ($idsEst as $ids)
								echo	$CadIds = $ids . "/";
								?>')" class="letras btn-link" scope="row" style="text-align: left; cursor: pointer;color: black;" id="">
								 <?php echo $gen->reparar_utf8($row["NOMBRE"])?>

							</td>
						<?php 
					} else {
							echo "<td   class='letras btn-link' scope ='row' style='text-align: left; cursor: pointer' id=''>" . $gen->reparar_utf8($row["NOMBRE"] ) . "</td>";
						}
						?>
						<td class="letras" scope="row" style="text-align: center;color:black" id=""> <?php

						for ($i = 0; $i < count($arrayEstaciones); $i++) {
							if ($row["ESTACION"] == $idsEst[$i]) {
								echo $arrayEstaciones[$i];
								break;
							}
						}

						?>
					</td>
					<td class="letras" type="password" scope="row" style="text-align: center;" id=""> <?php echo $row["PASSW"] ?></td>
					<td class="letras" scope="row" style="text-align: center;" id="rowActivo"> <?php echo $row["ACTIVO"] ?></td>
					<td class="letras" scope="row" style="text-align: center;" id=""> <?php
					if ($row["ES_JEFE_DE_TURNO"] == 'Si') {

						?> <a class="fa fa-star" )>
						</a>

						<?php
					}

					?>

				</td>
				<td class="letras columOcultas" scope="row" style="text-align: center;" id=""> <?php echo $row["TIPO_DESPACHADOR"] ?></td>


			</tr>
		</tbody>
		<?php

	} ?>
</table>
</div>
</body>

</html>

