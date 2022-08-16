<?php 
session_start();
if(isset($_SESSION['user']) &&  $_SESSION['logeado']== true){




 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Gugi" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Gugi|Roboto+Condensed" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Patua+One|Teko" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Russo+One" rel="stylesheet">
<link rel="stylesheet" href="../css/stylePortada2.css">
   <!-- Buenas librerias hasta ahora -------------- -->
<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


<!-- --------------------------------------------- -->
<link rel="stylesheet" href="../css/styleModificarPrecios.css" />
<link rel="stylesheet" href="../css/styleprecios.css" />
<link rel="stylesheet" href="../css/styleportada.css">
<!-- links de movil -->
<link rel="stylesheet" href="../cssmovil/movilportada.css">


<!--links de slider-->

<link rel="stylesheet" href="../css/flexslider.css" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script src="../woocommerce-FlexSlider-53570ee/jquery.flexslider.js"></script>
<script src="../js/carrousel.js"></script>
</head>
<body>


    <script>
    // Can also be used with $(document).ready()
        $(window).load(function() {
    $('.flexslider').flexslider({
        animation: "slide"
    });
});
    </script>
<?php

include 'metodosweb.php';
include 'elegir-encabezado.php';
$x= new encabezados();
$enca = $x->elegir_enca();
$objeto = new metodosweb();
$estaciones = $objeto->tablaEstaciones();
$arrayestaciones = array();
//arreglos precios Aplicados
$Arfecha=array();
$Armagna=array();
$Arpremium=array();
$Ardiesel=array();
//$Arfolio=array();
// arreglos precios Programados
$ArfechaPr = array();
$ArmagnaPr = array();
$ArpremiumPr = array();
$ArdieselPr =array();
//ArfolioPr = array();
while($row = ibase_fetch_assoc($estaciones)){
array_push($arrayestaciones,$row['ESTACION']);
    }

for($i=0; $i<count($arrayestaciones); $i++){

    $metodoApli = $objeto->preciosPortada1($arrayestaciones[$i]);
  
    while($aplicados=ibase_fetch_assoc($metodoApli)){
        array_push($Arfecha,$aplicados['FECHA']);
        array_push($Armagna,$aplicados['MAGNA']);
        array_push($Arpremium,$aplicados['PREMIUM']);
        array_push($Ardiesel,$aplicados['DIESEL']);
            }   
  $metodoProg = $objeto->preciosProgramados($arrayestaciones[$i]);
      while($programados=ibase_fetch_assoc($metodoProg)){
        array_push($ArfechaPr,$programados['FECHA']);
        array_push($ArmagnaPr,$programados['MAGNA']);
        array_push($ArpremiumPr,$programados['PREMIUM']);
        array_push($ArdieselPr,$programados['DIESEL']);
      }      
         }
 ?>


<!-- Place somewhere in the <body> of your page -->
<div class="flexslider">
  <ul class="slides">
    <li>
        <img src="../imagenes/4.png">
        <section class="flex-caption">LOREM IPSUM</section>
    </li>
    <li>
      <img src="../imagenes/2.jpg">
      <section class="flex-caption">LOREM IPSUM</section>
    </li>
   <li>
      <img src="../imagenes/3.jpg">
      <section class="flex-caption">LOREM IPSUM</section>
    </li>
  </ul>
</div>





</body>
</html>
<?php 
} else {
	header("location:../index.php");
}