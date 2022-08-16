<?php 

session_start();
 $todas_esta = isset($_POST['todos']) ? $_POST['todos']: "";
 $poli = isset($_POST['poli']) ? $_POST['poli']: "";
 $uman =isset($_POST['uman']) ? $_POST['uman']: "";
 $peri =isset($_POST['peri']) ? $_POST['peri']: "";
 $side =isset($_POST['side']) ? $_POST['side']: "";



$usuario=isset($_SESSION['user']) ? $_SESSION['user'] : "";
$precio1 =  isset($_POST['magna']) ? $_POST['magna']  : "no hay magna";
$precio2=  isset($_POST['premium']) ? $_POST['premium']  : "no hay premium";
$precio3 =  isset($_POST['diesel']) ? $_POST['diesel']  : "diesel";
$datetime =  isset($_POST['date3']) ? $_POST['date3']  : "no hay fecha";

 
$date = date_create($datetime);
$fechacompleta = date_format($date, 'Y-m-d H:i:s');
$x =explode(" ", $fechacompleta);
$fecha = $x[0];
$hora = $x[1];


$aplicado ="NO";
$precioM=floatval($precio1);
$precioP=floatval($precio2);
$precioD=floatval($precio3);



$datosside=array($fecha,$hora,"SIDE",$precioM,$precioP,$precioD,$aplicado,$usuario);
$datospoli=array($fecha,$hora,"POLI",$precioM,$precioP,$precioD,$aplicado,$usuario);
$datosuman=array($fecha,$hora,"UMAN",$precioM,$precioP,$precioD,$aplicado,$usuario);
$datosperi=array($fecha,$hora,"PERI",$precioM,$precioP,$precioD,$aplicado,$usuario);
$datosGeneral=array($fecha,$hora,$x,$precioM,$precioP,$precioD,$aplicado,$usuario);




include 'metodosweb.php';
$metodos = new metodosweb();

if ($todas_esta == "todos"){
	
try {
$metodos->insertarSIDE($datosside);
$metodos->insertarPOLI($datospoli);
$metodos->insertaruman($datosuman);
$metodos->insertarperi($datosperi);
$metodos->insertarPrecios($datosside);
$metodos->insertarPrecios($datospoli);
$metodos->insertarPrecios($datosuman);
$metodos->insertarPrecios($datosperi);
echo "<script> alert('Datos guardados exitosamente'); location.href ='frmPrecios.php'; </script>";

} catch (Exception $e) {
	echo "<script> alert('Error al guardar los datos en las estaciones'); location.href ='frmPrecios.php'; </script>";

}

}
if ($uman == "UMAN"){

try {
	$metodos->insertaruman($datosuman);
	$metodos->insertarPrecios($datosuman);
	echo "<script> alert('Datos guardados en UMAN'); location.href ='frmPrecios.php'; </script>";

} catch (Exception $e) {
	echo "<script> alert('Error al guardar los datos en UMAN'); location.href ='frmPrecios.php'; </script>";

}
 	
}





if($peri == "PERI"){
	
try {
	$metodos->insertarperi($datosperi);
	$metodos->insertarPrecios($datosperi);
		echo "<script> alert('Datos guardados en PERIORIENTE'); location.href ='frmPrecios.php'; </script>";
} catch (Exception $e) {
echo "<script> alert('Error al guardar los datos en PERIORIENTE'); location.href ='frmPrecios.php'; </script>";

}	
}
 


if ($poli == "POLI"){


try {
	$metodos->insertarPOLI($datospoli);
	$metodos->insertarPrecios($datospoli);
		echo "<script> alert('Datos guardados en POLIFORUM'); location.href ='frmPrecios.php'; </script>";
} catch (Exception $e) {
	echo  "<script> alert('Error al guardar los datos en  POLIFORUM); location.href ='frmPrecios.php'; </script>";

}

}


if($side == "SIDE"){
	
	try {
		$metodos->insertarSIDE($datosside);
		$metodos->insertarPrecios($datosside);
		echo "<script> alert('Datos guardados en SIDERURGICA'); location.href ='frmPrecios.php'; </script>";
	} catch (Exception $e) {
		echo "<script> alert('Error al guardar los datos en SIDERURGICA'); location.href ='frmPrecios.php'; </script>";

		
	}

}


 ?>