<?php 


include '../metOperadores/metodosOperadores.php';
 	$objeto = new Operadores();
  	$folio = $objeto->ultimoFolioDespachador();
  	print_r($folio);


 ?>