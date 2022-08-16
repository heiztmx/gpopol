<?php 

include 'metodosweb.php';


$con= new conexion();
$conexion = $con->conectar();


$folio =  isset($_GET['folio']) ? $_GET['folio']  : "No hay folio";

$folio=(int)$folio;
// echo $folio;

$metodos = new metodosweb();
$met = $metodos->eliminarPrecios($folio);

if ($met ==1) {
	header("location:listado.php");
} else {
	echo "<script>alert('Algo salio mal llamar a sistemas');</script>";
}





 ?>