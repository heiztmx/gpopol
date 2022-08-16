<?php 
session_start();
if(isset($_SESSION['user']) &&  $_SESSION['logeado']== true){




 ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Portada Principal</title>




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


   <!-- Buenas librerias hasta ahora -------------- -->
<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="../js/preciosPortada.js"></script>
<!-- --------------------------------------------- -->
<link rel="stylesheet" href="../css/styleModificarPrecios.css" />
<link rel="stylesheet" href="../css/styleprecios.css" />
<link rel="stylesheet" href="../css/styleportada.css">
<!-- links de movil -->
<link rel="stylesheet" href="../cssmovil/movilportada.css">

</head>
<body>
	<?php 
		
 
		include 'metodosweb.php';
		include 'elegir-encabezado.php';
		$x = new  encabezados();
		$enca = $x->elegir_enca();
		$met = new metodosweb();
		$arrayEstaciones=array();
		$metodos =$met->tablaEstaciones();
		while($row = ibase_fetch_object($metodos)){
			array_push($arrayEstaciones,$row->ESTACION);				
		}
			
				
				
		
	?>
		<h1 class="titulop">Web Precios</h1>
		<p class="parrafop">Esta pagina web esta hecha para agregar precios nuevos de los combustibles asi como borrar y modifacion de los mismos.</p>
	


<section id="img-estaciones">

	<?php 
	for($i=0; $i<count($arrayEstaciones); $i++){
	$estaciones=$met->preciosPortada1($arrayEstaciones[$i]);
	while($esta=ibase_fetch_assoc($estaciones))
	{
		$datos= $esta['ESTACION']."||".
		$esta['IMAGEN']."||".
		$esta['MAGNA']."||".
		$esta['PREMIUM']."||".$esta['DIESEL']."||".$esta['FECHA'];
	 ?>
		<figure id="picture<?php echo $esta['ESTACION']; ?>" style="background-image: url(<?php echo $esta['IMAGEN'] ?>);" class=" moviedown figurap" onclick="DesplegarPrecios('<?php  echo $datos; ?>')">
		<div class="datos">
				
					<table>

				<tr>
				<td><label for="">Magna</label></td>
				<td>
					<label type="text"> <?php print number_format($esta['MAGNA'],2,'.',','); ?>
					</label>
				</td>
				</tr>


				
				<tr>
				<td><label for="">Premium:</label></td>
				<td><label type="text"> <?php print number_format($esta['PREMIUM'],2,'.',','); ?>
					</label>
				</td>
			</tr>
				

				<tr>
				<td><label for="">Diesel:</label></td>
				<td><label type="text"> <?php print number_format($esta['DIESEL'],2,'.',','); ?>
					</label>
				</td>
				</tr>
			
				
			</table>
			</div>

		</figure>
	
	<?php
	 } 
	 	}
	?>

		
	
	</section>

	<footer id="main_footer">
			
</footer>
</body>
</html>

<?php 
} else {
	header("location:../index.php");
}