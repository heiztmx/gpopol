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
	<link href="https://fonts.googleapis.com/css?family=Gugi|Roboto+Condensed" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Patua+One|Teko" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Russo+One" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Gugi" rel="stylesheet">
	<link rel="stylesheet" href="../alertifyjs/css/alertify.css">
	<link rel="stylesheet" href="../alertifyjs/css/themes/default.css">
	<link rel="stylesheet" href="../css/stylelistado.css">
	<link rel="stylesheet" href="../css/styleprecios.css">
	<link rel="stylesheet" href="../css/menu-desplegable.css">
 	<link rel="stylesheet" href="../css/stylemodalBorrarprecios.css">
	<script src="../alertifyjs/alertify.js"></script>
	<script src="../js/datosPreciosListado.js"></script>
 <!-- Buenas librerias hasta ahora -------------- -->
<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<!-- --------------------------------------------- -->

<!-- --------------SweetAlert no las borren es un pedo despues :v ------------------- -->
<script src="../javascript/jquery-3.3.1.min.js"></script>
<link href="../sweetalert-master/src/sweetalert.css" type="text/css">
<script src="../sweetalert-master/docs/assets/sweetalert/sweetalert.min.js"></script>
<link rel="stylesheet" href="../cssmovil/movilGeneral.css">
<!-- <script src="../js/irmodificar.js"></script> -->

	
<script src="../js/datosPrecios.js"></script>
</head>
<body class="tabla-general">
	<?php 
		
 
		include 'metodosweb.php';
		include 'elegir-encabezado.php';
		include '../modals/borrarPrecios-modal.php';
		$x = new  encabezados();
		$enca = $x->elegir_enca();
	?>

<h1 class="encabezado-tabla">LISTA GENERAL DE PRECIÓS</h1>
<form method="GET">
<table id="tabla2" ><a id="uman"></a>
		<tr id="titulo">

		<th colspan="11" id="h3">
			<figure><img  src="../imagenes/logo_normal.png" alt=""></figure>
			<h3>Lista General de Precios</h3>
			<h4>Lista General de Precios</h4>
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
				<td id="estacionLip"><input  type="text" value="<?php echo $row->ESTACION; ?>"></td>
				 <td><a style="border :0px;" href="frmModificar-precios.php?folio=<?php echo $row->FOLIO ?>"><i class="fas fa-pencil-alt"></i></a></td>
				
				<td><a   onclick="VerificarSINO('<?php echo $datosPoli; ?>')" class="op" id="btnsiPoli">
			<i class="fas fa-trash"></i></a></td>
					</tr>
										<?php 
}
				 ?>

				</table>
			</form>
</body>
</html>

<?php 
} else {
	header("location:../index.php");
}
