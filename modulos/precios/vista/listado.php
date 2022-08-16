
<?php

include "../../../conexion/sesion.php";


$ses = new sesion();

$permisos = $ses->validar_sesion();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	  <div id="tm1"  style="display: none;color: white; margin-top: 10px; margin-left: 15px;" >Modulo 1 </div>
	<meta charset="UTF-8">

	<title>Listado por Estaciones</title>
	<link rel="stylesheet" href="../../../bootstrapcss/estiloListado.css">

</head>
<body>
	<?php 
		 include '../../../menu/menu2.php';

		 $arrayEst = array();
		 $imagenesEst= array();
		 $razonsocial= array();
		$metodo = new metodosweb();
		$est = $metodo->tablaEstaciones();
	
		while($row=ibase_fetch_assoc($est))
		{
			array_push($arrayEst,$row['ESTACION']);
			array_push($imagenesEst, $row['IMAGEN']);
			array_push($razonsocial, $row['RAZON_SOCIAL']);
		
		}
	$find_permiso = $metodo->permisos_del_upd($_SESSION["user"],"PRECIOS");
		$priv = $objeto->ElegirPrivilegios($_SESSION['user']);
	  $digito ="1";
	 ?>
	 <script src="../js/clickModulo1.js"></script>
		<!-- <div class=" row m-5"></div>
		<div class=" row m-5"></div> -->
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		
		
	 <h5 style="text-align: left; font-weight: bold; position: relative; top: -75px;">Listado por Estacion</h5>




	 

		<?php for($i=0; $i<count($arrayEst); $i++){
			?>
		
<div id="accordion" style="position: relative; top:-60px;">
  <div class="card">
    <div class="card-header" id="heading<?php echo $arrayEst[$i]; ?>">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse<?php echo $arrayEst[$i]; ?>" aria-expanded="false" aria-controls="<?php echo $arrayEst[$i]; ?>">
          <?php echo $arrayEst[$i]; ?>
        </button>
      </h5>
    </div>

	<div id="collapse<?php echo $arrayEst[$i]; ?>" class="collapse" aria-labelledby="heading<?php echo $arrayEst[$i]; ?>" data-parent="#accordion">
      <div class="card-body">
       <table class="table mx-auto table-sm "   style="position: relative;  left: -20px;">
		<thead>
			<tr  colspan="" >
				<td>	
					<figure class="iconosEstaciones" >
					<img class="imgIconos" src="<?php echo $imagenesEst[$i]; ?>" alt="">
				</figure>
			</td>
			<td scope="col" colspan="5">
				<h5 class="titulos"><?php echo $razonsocial[$i]; ?></h5>
			</td>
			
			
			
			</tr>
					<tr>
						<td  class="ocultar"  class="ocultar"style="text-align: center;font-weight: bold;" scope="col">Folio</td>
						<td style="text-align: center;font-weight: bold;" scope="col">Fecha</td>
						<td style="text-align: center;font-weight: bold;" scope="col">Hora</td>
						<td style="text-align: center;font-weight: bold;" scope="col">Magna</td>
						<td style="text-align: center;font-weight: bold;" scope="col">Premium</td>
						<td style="text-align: center;font-weight: bold;" scope="col">Diesel</td>
						<td class="ocultar"  class="ocultar" style="text-align: center;font-weight: bold;" scope="col">Aplicado</td>
						<td class="ocultar"  class="ocultar" style="text-align: center;font-weight: bold;" scope="col">Usuario</td>
						
					</tr>
				</thead>
				<?php 
				$met = $metodo->porEstacion(100,$arrayEst[$i]);
			
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

					}?>
				 <th class="ocultar" style="text-align: center;" id="folio<?php echo $arrayEst[$i]; ?>" scope="row"><?php echo $row['FOLIO'] ?></th>
     			 <td style="text-align: center;" id="hora<?php echo $arrayEst[$i] ?>"><?php echo $nuevafecha ?></td>
     			 <td style="text-align: center;" id="premium<?php echo $arrayEst[$i] ?>"><?php echo $row['HORA'] ?></td>
     			 <td style="text-align: center;" id="premium<?php echo $arrayEst[$i] ?>"><?php echo $row['MAGNA'] ?></td>
      			 <td style="text-align: center;" id="premium<?php echo $arrayEst[$i] ?>"><?php echo $row['PREMIUM'] ?></td>
      			 <td style="text-align: center;" id="diesel<?php echo $arrayEst[$i] ?>"><?php echo $row['DIESEL'] ?></td>
      			 <td class="ocultar" style="text-align: center;" id="aplicado<?php echo $arrayEst[$i] ?>"><?php echo $row['APLICADO'] ?></td>
      			 <td class="ocultar" style="text-align: center;" id="usuario<?php echo $arrayEst[$i] ?>"><?php echo $row['USUARIO'] ?></td>
      			 
      		
				</tr>
				</tbody>
			<?php } ?>
			</table>
      </div>
    </div>
 
       


  </div>
</div>
			<?php 
}
			 ?>
		
 
	



</table>
</body>
</html>



