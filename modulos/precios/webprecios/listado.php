<?php 
session_start();
if(isset($_SESSION['user']) &&  $_SESSION['logeado']== true){




 ?>


<!DOCTYPE html>
<html lang="en">
<head>



 
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Listado de Precios</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
	<link rel="stylesheet" href="../css/normalize.css">
	<link rel="stylesheet" href="../css/styleprecios.css">
	<!-- <link rel="stylesheet" href="css/styleprecios2.css"> -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Gugi" rel="stylesheet">
	<link rel="stylesheet" href="../alertifyjs/css/alertify.css">
	<link rel="stylesheet" href="../alertifyjs/css/themes/default.css">
	<link rel="stylesheet" href="../css/stylelistado.css">
	<link rel="stylesheet" href="../css/stylemodalBorrarprecios.css">
	<link rel="stylesheet" href="../cssmovil/movilListado.css">
<script src="../javascript/jquery-3.3.1.min.js"></script>
<script src="../alertifyjs/alertify.js"></script>
<script src="../js/datosPreciosListado.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<!-- --------------SweetAlert no las borren es un pedo despues :v ------------------- -->
<script src="../javascript/jquery-3.3.1.min.js"></script>
<link href="../sweetalert-master/src/sweetalert.css" type="text/css">
<script src="../sweetalert-master/docs/assets/sweetalert/sweetalert.min.js"></script>
<script src="../js/irmodificar.js"></script>
<script src="../js/llamarValidarSiNo.js"></script>
<script src="../js/ocultar-estaciones.js"></script>

</head>


<body>

	 <?php
	 include 'metodosweb.php';
	 include '../modals/borrarPrecios-modal.php';
		include 'elegir-encabezado.php';
		$x = new  encabezados();
		$enca = $x->elegir_enca();
		$arrayEst = array();
		$metodo = new metodosweb();
		$est = $metodo->tablaEstaciones();
		while($row=ibase_fetch_assoc($est))
		{
			array_push($arrayEst,$row['ESTACION']);
		
		}
	 ?>

		<h1 class="h1">Precios Por Estacion</h1>

		
		<div id="menu-anclas1">
		<a id="todas" onclick="ocultar_Estaciones('<?php 
		foreach($arrayEst as $valor){
			echo $concatenado =$valor."||";
		}
		?>')">Todas</a>
		<?php
		
		
		$estaciones = $metodo->tablaEstaciones();
		while($row=ibase_fetch_assoc($estaciones))
		{
			
		 ?>
			<a id="tabla<?php echo $row['ESTACION'];?>"  
				onclick="ocultar_Estaciones('<?php 
				foreach($arrayEst as $valor){
			echo $concatenado =$valor."||";
				}
		?>')"
			><?php echo $row['ESTACION']; ?></a>
		
		<!-- href="#poliforum" 	class="menu-anclas" -->
		<?php
		}
		 ?>
		</div>

	<button class="btnSiNo" id="actualizarSiNo">Actualizar</button>
		<!-- tabla -->
		<table id="tabla1"><a id="siderurgica"></a>
		<tr id="titulo">

		<th colspan="10" id="h3">
			<figure><img src="../imagenes/SINFONDO/siderurgica.png" alt=""></figure>
			<h3>Estación de Servicio Siderúrgica, S.A. de C.V. </h3>
			<h4>Estación de Servicio Siderúrgica, S.A. de C.V. </h4>
		</th>
		</tr> 
		<tr id="nombres">
			
								

								<td id="td" class="e1">Folio</td>
									<td id="td" class="e2">Fecha</td>
									<td id="td" class="e3">Hora</td>	
									<td id="td" class="e4">Magna</td>
									<td id="td" class="e5">Premium</td>
									<td id="td" class="e6">Diesel</td>
									<td id="td" class="e7">Aplicado</td>
									<td id="td" class="e8">Usuario</td>
		</tr>
<?php 
 $metodos = new metodosweb();
 $met = $metodos->porEstacion(12,'Siderurgica');

 // while($row = ibase_fetch_object($met)){
 //  $my_array_of_table_names[] = $row->FOLIO;
 

 // }
 // sort($my_array_of_table_names);

 // foreach ($my_array_of_table_names as $table_name){
 //     echo "$table_name\n";
 // }


while ($row =ibase_fetch_object($met)) {
$date = date_create($row->FECHA);
$nuevafecha=date_format($date, 'd/m/y');


	$datosSide = $row->FOLIO."||".
				$nuevafecha."||".
				$row->HORA."||".
				$row->MAGNA."||".
				$row->PREMIUM."||".
				$row->DIESEL."||".
				$row->APLICADO."||".
				$row->USUARIO."||".$row->IP;


  ?>
	
			<tr id="cajas">
			<td id="folioLis"><input type="text"  readonly value="<?php echo $row->FOLIO; ?>" class="reduccion"></td>
				<td id="fechaLis"><input type="text"  readonly value="<?php echo $nuevafecha;?>"></td>
				<td id="horaLis"><input type="text"  readonly value="<?php echo $row->HORA; ?>"></td>
				<td id="magnaLis"><input class="letra reduccion" type="text" value="<?php print number_format($row->MAGNA,2,'.',','); ?>" readonly></td>
				<td id="premiumLis"><input class="letra reduccion" type="text" value="<?php print number_format($row->PREMIUM,2,'.',','); ?>" readonly></td>
				<td id="dieselLis"><input class="letra reduccion" type="text" value="<?php print number_format($row->DIESEL,2,'.',','); ?>" readonly ></td>
				<td id="aplicadoLis"><input type="text"  readonly value="<?php echo $row->APLICADO; ?>"></td>
				<td id="usuarioLis"><input type="text"  readonly value="<?php echo $row->USUARIO; ?>"></td>
				<td id="estacionLis"><input type="text" value="<?php echo $row->ESTACION; ?>" hidden=""></td>
				 <td><button  style="border :1px; background-color:white"><a style="border :0px;" href="frmModificar-precios.php?folio=<?php echo $row->FOLIO ?>"><i class="fas fa-pencil-alt"></i></a></button></td>
				
				<td><a  onclick="VerificarSINO('<?php echo $datosSide; ?>')" class="op" id="btnsiSide">
			<i class="fas fa-trash"></i></a></td>
					</tr>
				
						<?php 
}
				 ?>

</table>
				

			
				
			
		
			


	
	
			<!-- tabla -->
		<table id="tabla2"><a id="uman"></a>
		<tr id="titulo">

		<th colspan="10" id="h3">
			<figure><img  src="../imagenes/SINFONDO/uman.png" alt=""></figure>
			<h3>Servicio Industrial Umán S.A de C.V. </h3>
			<h4>Servicio Industrial Umán S.A de C.V. </h4>
		</th>
		</tr> 
		<tr id="nombres">
			
								<td id="td" class="e1">Folio</td>
									<td id="td" class="e2">Fecha</td>
									<td id="td" class="e3">Hora</td>	
									<td id="td" class="e4">Magna</td>
									<td id="td" class="e5">Premium</td>
									<td id="td" class="e6">Diesel</td>
									<td id="td" class="e7">Aplicado</td>
									<td id="td" class="e8">Usuario</td>
								
		</tr>
					<?php 
 $metodos = new metodosweb();
 $met = $metodos->porEstacion(12,'Uman');

while ($row =ibase_fetch_object($met)) {

	$date = date_create($row->FECHA);
$nuevafecha=date_format($date, 'd/m/y');

	$datosUman = $row->FOLIO."||".
				$nuevafecha."||".
				$row->HORA."||".
				$row->MAGNA."||".
				$row->PREMIUM."||".
				$row->DIESEL."||".
				$row->APLICADO."||".
				$row->USUARIO."||".$row->IP;

  ?>
				<tr id="cajas">
			<td id="folioLiu"><input type="text"  readonly value="<?php echo $row->FOLIO; ?>"></td>
				<td id="fechaLiu"><input type="text"  readonly value="<?php echo $nuevafecha;?>"></td>
				<td id="horaLiu"><input type="text"  readonly value="<?php echo $row->HORA; ?>"></td>
				<td id="magnaLiu"><input class="letra" type="text" value="<?php print number_format($row->MAGNA,2,'.',','); ?>" readonly></td>
				<td id="premiumLiu"><input class="letra" type="text" value="<?php print number_format($row->PREMIUM,2,'.',','); ?>" readonly></td>
				<td id="dieselLiu"><input class="letra" type="text" value="<?php print number_format($row->DIESEL,2,'.',','); ?>" readonly ></td>
				<td id="aplicadoLiu"><input type="text"  readonly value="<?php echo $row->APLICADO; ?>"></td>
				<td id="usuarioLiu"><input type="text"  readonly value="<?php echo $row->USUARIO; ?>"></td>
				<td id="estacionLis"><input type="text" value="<?php echo $row->ESTACION; ?>" hidden=""></td>
			 <td><button style="border :0px; background-color:white"><a style="border :0px;" href="frmModificar-precios.php?folio=<?php echo $row->FOLIO ?>"><i class="fas fa-pencil-alt"></i></a></button></td>
				
				<td><a    onclick="VerificarSINO('<?php echo $datosUman; ?>')" class="op" id="btnsiUman">
			<i class="fas fa-trash"></i></a></td>
					</tr>


						<?php 
}
				 ?>

				</table>
				
				
				
				
				
				
			<!-- 
				</div>

				</div> -->

		<!-- tabla -->
		<table id="tabla3"><a id="san-pedro"></a>
		<tr id="titulo">

		<th colspan="10" id="h3">
			<figure><img  src="../imagenes/SINFONDO/PER.png" alt=""></figure>
			<h3>Servicio Perioriente, SA de CV </h3>
			<h4>Servicio Perioriente, SA de CV </h4>
		</th>
		</tr> 
		<tr id="nombres">
			
								<td id="td" class="e1">Folio</td>
									<td id="td" class="e2">Fecha</td>
									<td id="td" class="e3">Hora</td>	
									<td id="td" class="e4">Magna</td>
									<td id="td" class="e5">Premium</td>
									<td id="td" class="e6">Diesel</td>
									<td id="td" class="e7">Aplicado</td>
									<td id="td" class="e8">Usuario</td>
		</tr>
					<?php 
 $metodos = new metodosweb();
 $met = $metodos->porEstacion(12,'Perioriente');

while ($row =ibase_fetch_object($met)) {

	$date = date_create($row->FECHA);
$nuevafecha=date_format($date, 'd/m/y');

$datosPeri = $row->FOLIO."||".
				$nuevafecha."||".
				$row->HORA."||".
				$row->MAGNA."||".
				$row->PREMIUM."||".
				$row->DIESEL."||".
				$row->APLICADO."||".
				$row->USUARIO."||".$row->IP;
  ?>
				<tr id="cajas">
			<td id="folioLisp"><input type="text"  readonly value="<?php echo $row->FOLIO; ?>"></td>
				<td id="fechaLisp"><input type="text"  readonly value="<?php echo $nuevafecha;?>"></td>
				<td id="horaLisp"><input type="text"  readonly value="<?php echo $row->HORA; ?>"></td>
				<td id="magnaLisp"><input class="letra" type="text" value="<?php print number_format($row->MAGNA,2,'.',','); ?>" readonly></td>
				<td id="premiumLisp"><input class="letra" type="text" value="<?php print number_format($row->PREMIUM,2,'.',','); ?>" readonly></td>
				<td id="dieselLisp"><input class="letra" type="text" value="<?php print number_format($row->DIESEL,2,'.',','); ?>" readonly ></td>
				<td id="aplicadoLisp"><input type="text"  readonly value="<?php echo $row->APLICADO; ?>"></td>
				<td id="usuarioLisp"><input type="text"  readonly value="<?php echo $row->USUARIO; ?>"></td>
				<td id="estacionLis"><input type="text" value="<?php echo $row->ESTACION; ?>" hidden=""></td>
			 <td><button style="border :0px; background-color:white"><a style="border :0px;" href="frmModificar-precios.php?folio=<?php echo $row->FOLIO ?>"><i class="fas fa-pencil-alt"></i></a></button></td>
				
				<td><a   onclick="VerificarSINO('<?php echo $datosPeri; ?>')" class="op" id="btnsiPeri">
			<i class="fas fa-trash"></i></a></td>
					</tr>
										<?php 
}
				 ?>

				</table>
				
				
				
				
				
				
			
				<!-- </div>

				</div> -->

					<!-- tabla1 -->
				<table id="tabla4"> <a id="poliforum"></a>
		<tr id="titulo">

		<th colspan="10" id="h3">
			<figure><img  src="../imagenes/SINFONDO/poliforum.png" alt=""></figure>
			<h3>Combustibles y Lubricantes Poliforum, SA de CV.</h3>
			<h4>Combustibles y Lubricantes Poliforum, SA de CV.</h4>
		</th>
		</tr> 
		<tr id="nombres">
			
										<td id="td" class="e1">Folio</td>
									<td id="td" class="e2">Fecha</td>
									<td id="td" class="e3">Hora</td>	
									<td id="td" class="e4">Magna</td>
									<td id="td" class="e5">Premium</td>
									<td id="td" class="e6">Diesel</td>
									<td id="td" class="e7">Aplicado</td>
									<td id="td" class="e8">Usuario</td>
		</tr>
										<?php 
 $metodos = new metodosweb();
 $met = $metodos->porEstacion(12,'Poliforum');

while ($row =ibase_fetch_object($met)) {
	$date = date_create($row->FECHA);
$nuevafecha=date_format($date, 'd/m/y');
	$datosPoli = $row->FOLIO."||".
				$nuevafecha."||".
				$row->HORA."||".
				$row->MAGNA."||".
				$row->PREMIUM."||".
				$row->DIESEL."||".
				$row->APLICADO."||".
				$row->USUARIO."||".$row->IP;

  ?>		
  			<tr id="cajas">
			<td id="folioLip"><input type="text"  readonly value="<?php echo $row->FOLIO; ?>"></td>
				<td id="fechaLip"><input type="text"  readonly value="<?php echo $nuevafecha;?>"></td>
				<td id="horaLip"><input type="text"  readonly value="<?php echo $row->HORA; ?>"></td>
				<td id="magnaLip"><input class="letra" type="text" value="<?php print number_format($row->MAGNA,2,'.',','); ?>" readonly></td>
				<td id="premiumLip"><input class="letra" type="text" value="<?php print number_format($row->PREMIUM,2,'.',','); ?>" readonly></td>
				<td id="dieselLip"><input class="letra" type="text" value="<?php print number_format($row->DIESEL,2,'.',','); ?>" readonly ></td>
				<td id="aplicadoLip"><input type="text"  readonly value="<?php echo $row->APLICADO; ?>"></td>
				<td id="usuarioLip"><input type="text"  readonly value="<?php echo $row->USUARIO; ?>"></td>
				<td id="estacionLis"><input type="text" value="<?php echo $row->ESTACION; ?>" hidden=""></td>
				 <td><button style="border :0px; background-color:white"><a style="border :0px;" href="frmModificar-precios.php?folio=<?php echo $row->FOLIO ?>"><i class="fas fa-pencil-alt"></i></a></button></td>
				
				<td><a   onclick="VerificarSINO('<?php echo $datosPoli; ?>')" class="op" id="btnsiPoli">
			<i class="fas fa-trash"></i></a></td>
					</tr>
										<?php 
}
				 ?>

				</table>
	</div>





	</form>
	</div> 

</body>

</html>

<?php 
} else {
	header("location:../index.php");
}

 ?>