<?php

include "../../../conexion/sesion.php";


$ses = new sesion();

$permisos = $ses->validar_sesion();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Listado General</title>
	<script src="../js/clickModulo1.js"></script>
	<link rel="stylesheet" href="../../../bootstrapcss/estiloListado.css">

</head>
<body >
	<?php 
	include '../../../menu/menu2.php';

	$metodo = new metodosweb();
	$usuario="admin";
	$arrayEst = array();
	$imagenesEst= array();
	$razonsocial= array();
	$est = $metodo->tablaEstaciones();
	while($row1=ibase_fetch_assoc($est))
	{
		array_push($arrayEst,$row1['ESTACION']);
		array_push($imagenesEst, $row1['IMAGEN']);
		array_push($razonsocial, $row1['RAZON_SOCIAL']);

	}
	$find_permiso = $metodo->permisos_del_upd($_SESSION["user"],"PRECIOS");
	$priv = $objeto->ElegirPrivilegios($_SESSION['user']);
	$digito ="1";
	?>


	<br>
	<br>
	<br>
	<br>

	
	<h5 style="text-align: left; font-weight: bold; position: relative; top: -25px;">Lista General de Precios</h5>




	<table class="table mx-auto table-sm">
		<thead>

			<tr>
				<td  id="folio" style="text-align: center;font-weight: bold;" class="ocultar" scope="col">Folio</td>
				<td  id="estacion" class="ocultar" style="text-align: center;font-weight: bold;" scope="col">Estacion</td>
				<td id="fecha"  style="text-align: center;font-weight: bold;" scope="col">Fecha</td>
				<td  id="hora" style="text-align: center;font-weight: bold;" scope="col">Hora</td>

				<td id="magna"  style="text-align: center;font-weight: bold;" scope="col">Magna</td>
				<td id="premium"  style="text-align: center;font-weight: bold;" scope="col">Premium</td>
				<td  id="diesel" style="text-align: center;font-weight: bold;" scope="col">Diesel</td>
				<td id="aplicado"  style="text-align: center;font-weight: bold;" scope="col" class="ocultar">Aplicado</td> 

				<td  id="usuario" style="text-align: center;font-weight: bold;" class="ocultar" scope="col">Usuario</td>

			</tr>
		</thead>
		<?php				

		$met = $metodo->consultaGeneral();

		$i=0;
		while($row=ibase_fetch_assoc($met)){
			$date = date_create($row['FECHA']);
			$nuevafecha=date_format($date, 'd/m/y');

			$datos = $row['FOLIO']."||".
			$nuevafecha."||".
			$row['HORA']."||".
			$row['MAGNA']."||".
			$row['PREMIUM']."||".
			$row['DIESEL']."||".
			$row['APLICADO']."||".
			$row['USUARIO']."||".$row['IP']."||".$row["ESTACION"];
			?>	
			<tbody>



			

				<tr  <?php 
				if ($find_permiso == true) {
					if($row['APLICADO'] == 'Si'){
						echo "class=''";
					}else{
						echo "class='table-warning'";
					}

					?> style="cursor:pointer;" onclick="borrar_precios('<?php echo $datos; ?>')">
					<?php 
				} else{	
					?>

					<tr  <?php 
					if($row['APLICADO'] == 'Si'){
						echo "class=''";
					}else{
						echo "class='table-warning'";
					}

					?> style="cursor:pointer;" >
					<?php 

				}
				?>


				
				<th style="text-align: center;" id="folio<?php echo $row['ESTACION'];echo $row['FOLIO']; ?>" class="ocultar" scope="row"><?php echo $row['FOLIO'] ?></th>

				<td style="text-align: center;" class="ocultar" id="premium<?php echo $row['ESTACION'];echo $row['FOLIO']?>"><?php echo $row['ESTACION'] ?></td>
				<td style="text-align: center;" id="hora<?php echo $row['ESTACION']; echo $row['FOLIO']; ?>"><?php echo $nuevafecha ?></td>
				<td style="text-align: center;" id="premium<?php echo $row['ESTACION']; echo $row['FOLIO']; ?>"><?php echo $row['HORA'] ?></td>

				<td style="text-align: center;" id="premium<?php echo $row['ESTACION']; echo $row['FOLIO']; ?>"><?php echo $row['MAGNA'] ?></td>
				<td style="text-align: center;" id="premium<?php echo $row['ESTACION']; echo $row['FOLIO']; ?>"><?php echo $row['PREMIUM'] ?></td>
				<td style="text-align: center;" id="diesel<?php echo $row['ESTACION']; echo $row['FOLIO']; ?>"><?php echo $row['DIESEL'] ?></td>
				<td style="text-align: center;" class="ocultar" id="aplicadotabla"><?php echo $row['APLICADO'] ?></td>
				<td style="text-align: center;" id="usuario<?php echo $row['ESTACION']; echo $row['FOLIO']; ?>" class="ocultar"><?php echo $row['USUARIO'] ?></td>


			</tr>
		</tbody>
		<?php
		$i++;
	} ?>
</table>

</body>
</html>

