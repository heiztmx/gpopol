<?php 
session_start();
if(isset($_SESSION['user']) &&  $_SESSION['logeado']== true){




 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Listado General</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="../css/normalize.css">

<!-- 	<link rel="stylesheet" href="css/styleprecios2.css"> -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

	<link href="https://fonts.googleapis.com/css?family=Gugi" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Gugi|Roboto+Condensed" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Patua+One|Teko" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Russo+One" rel="stylesheet">
	<!-- <link rel="stylesheet" href="../css/stylegeneral.css"> -->
	<link rel="stylesheet" href="../css/stylelistado.css">
	<link rel="stylesheet" href="../css/menu-desplegable.css">
	<link rel="stylesheet" href="../css/styleprecios.css">
	<link rel="stylesheet" href="../cssmovil/movilGeneral.css">
  <!--   <script src="http://code.jquery.com/jquery-1.6.2.min.js"></script> -->
    <!-- <script src="http://code.jquery.com/mobile/1.0b2/jquery.mobile-1.0b2.min.js"></script> -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script src="../js/menu-slider.js"></script>
    <script src="../js/mobiscroll-1.5.1.js" type="text/javascript"></script> -->
     <!-- Buenas librerias hasta ahora -------------- -->
<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="../js/mobiscroll-1.5.1.js" type="text/javascript"></script>
<!-- --------------------------------------------- -->

	<!-- <script src="../js/menu-slider.js"></script> -->

	
</head>
<body class="tabla-general">
	<?php 
		
 
		include 'metodosweb.php';
		include 'elegir-encabezado.php';
		$x = new  encabezados();
		$enca = $x->elegir_enca();
	?>

<h1 class="encabezado-tabla">LISTA GENERAL DE PRECIÓS</h1>
<table id="tabla2" ><a id="uman"></a>
		<tr id="titulo">

		<th colspan="11" id="h3">
			<figure><img  src="../imagenes/logo_normal.png" alt=""></figure>
			<h3>Lista General de Precios</h3>
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
									<td id="td" class="e9">Estacion</td>
		</tr>
					<?php 
 $metodos = new metodosweb();
 $met = $metodos->consultaGeneral();

while ($row =ibase_fetch_object($met)) {
	

  ?>
					<tr id="cajas">
			<td><input type="text"  readonly value="<?php echo $row->FOLIO; ?>"></td>
				<td><input type="text"  readonly value="<?php echo $row->FECHA;?>"></td>
				<td><input type="text"  readonly value="<?php echo $row->HORA; ?>"></td>
				<td><input class="letra" type="text" value="<?php print number_format($row->MAGNA,2,'.',','); ?>" readonly></td>
				<td><input class="letra" type="text" value="<?php print number_format($row->PREMIUM,2,'.',','); ?>" readonly></td>
				<td><input class="letra" type="text" value="<?php print number_format($row->DIESEL,2,'.',','); ?>" readonly ></td>
				<td><input type="text"  readonly value="<?php echo $row->APLICADO; ?>"></td>
				<td><input type="text"  readonly value="<?php echo $row->USUARIO; ?>"></td>
				<td><input type="text"  readonly value="<?php echo $row->ESTACION; ?>"></td>
				 <td><button style="border :0px; background-color:white"><a  href="frmModificar-precios.php?folio=<?php echo $row->FOLIO ?>"><i class="fas fa-pencil-alt"></i></a></button></td>
			

					</tr>

			<!-- 	<td ><a style="text-decoration: none; color: black; padding: 10px;" href="frmModificar-precios.php?folio=<?php //echo $row->FOLIO ?>"><i class="fas fa-pencil-alt"></i></a></td>
				<?php //print number_format($row->por_asi,2,".",",").'%';?> 
				
				<td><a style="text-decoration: none; color: black; padding: 10px;" 
				href="eliminarPrecios.php?folio=<?php //echo $row->FOLIO ?>" 	onclick="return confirm('¿Seguro de querer borrar el registro?');" ><i class="fas fa-trash"></i></a></td> -->
						<?php 
}
				 ?>

				</table>
</body>
</html>

<?php 
} else {
	header("location:../index.php");
}
