<?php 
session_start();
if(isset($_SESSION['user']) &&  $_SESSION['logeado']== true){




 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Lista de  datos</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">	
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/styleprecios.css">
<link rel="stylesheet" href="../css/styleDGeneral.css">

<link href="https://fonts.googleapis.com/css?family=Gugi" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

<link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet">
<script type="text/javascript" src="javascript/funciones.js"></script>

 <!-- Buenas librerias hasta ahora -------------- -->
<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="../js/mobiscroll-1.5.1.js" type="text/javascript"></script>
<!-- --------------------------------------------- -->
</head>
<body>
<?php 

include 'metodosweb.php';
include 'elegir-encabezado.php';
$x = new  encabezados();
$enca = $x->elegir_enca();
$metodos= new metodosweb();
$datos=$metodos->consultaGeneral();
?>
 
 <h1>LISTA GENERAL DE PRECIOS</h1>
<form action="modificar-precios.php" method="POST">
<!-- <table id="table">
	<tr id="titulo">
		<td>FOLIO</td>
		<td>FECHA</td>
		<td>HORA</td>
		<td>ESTACION</td>
		<td>MAGNA</td>
		<td>PREMIUM</td>
		<td>DIESEL</td>
		<td>APLICADO</td>
		<td>USUARIO</td>
	</tr> -->
<div id="titulo">
		<p>FOLIO</p>
		<p>FECHA</p>
		<p>HORA</p>
		<p>ESTACION</p>
		<p>MAGNA</p>
		<p>PREMIUM</p>
		<p>DIESEL</p>
		<p>APLICADO</p>
		<p>USUARIO</p>
</div>
<?php 



if (ibase_num_fields($datos)>0) {
	
	while ($row=ibase_fetch_object($datos)) {
		# code...


 ?>
 <table id="table2">
	<tr id="datos">
		<td><input type="text" name="folio" value='<?php echo $row->FOLIO; ?>'  readonly > </td>
		<td><input type="text" disabled="" name="fecha" value='<?php echo $row->FECHA ?>'> </td>
		<td><input type="text" disabled="" name="hora" value='<?php echo $row->HORA ?>'> </td>
		<td><input type="text" disabled="" name="estacion" value='<?php echo $row->ESTACION ?>'> </td>
		<td><input  type="text" disabled="" name="magna"value='<?php echo $row->MAGNA ?>' class="precios"> </td>
		<td><input  type="text" disabled="" name="premium" value='<?php echo $row->PREMIUM ?>' class="precios"> </td>
		<td><input type="text" disabled="" name="diesel" value='<?php echo $row->DIESEL ?>' class="precios" > </td>
		<td><input type="text" disabled="" name="aplicado" value='<?php echo $row->APLICADO ?>'> </td>
		<td><input type="text" disabled="" name ="usuario" value='<?php echo $row->USUARIO ?>'> </td>

		<div id="bot">
			<td><button><a  href="eliminarPrecios.php?folio=<?php echo $row->FOLIO ?>" onclick="return confirm('Seguro de querer borrar el registro?');">
			<i class="fas fa-trash"></i></a></button></td>

		<!-- <a href='editar.php?ID=<?PHP //echo $folio?>' -->
		<td><button><a href="frmModificar-precios.php?folio=<?php echo $row->FOLIO ?>"><i class="fas fa-pencil-alt"></i></a></button></td>
		</div>
		
  

	<!-- 	<a  href="eliminar.php?id=<?php //comment_ID(); ?>" 
  onclick="return confirm('Seguro de querer borrar el registro?');"
  ></a> -->
	</tr>
</table>

<?php 
	}
} 

else {
	echo "hay algo mal en la consulta";
}

 ?>
 </form>
</body>
</html>


<?php 
} else {
	header("location:../index.php");
}