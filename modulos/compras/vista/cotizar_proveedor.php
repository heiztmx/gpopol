<?php
include "../../../conexion/sesion.php";


$ses = new sesion();
$permisos = $ses->validar_sesion();
include '../../../menu/menu2.php';
include '../submenus/menu_cotizador.php';

$sucursal  = $_GET["sucursal"];
$serie  = $_GET["serie"];
$folio  = $_GET["folio"];

include '../metCompras/compras.php';

$obj = new metodos_compras();

$datos  = $obj->informacion_general($sucursal,$serie,$folio);

$concepto =  $datos["CONCEPTO1"];
$estado  = $datos["ESTADO"];


$id  = "(".$sucursal.")-".$serie."-".$folio;
// $estado = "Pendiente de Autorizar";
$por_proveedor =  $obj->por_proveedor($sucursal,$serie,$folio);
// print_r($por_proveedor["productos"]);
$id_sin_proveedor= $por_proveedor["id_sin_proveedor"];

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<script type="text/javascript" src="../jsCompras/nueva_req.js"></script>
	<script type="text/javascript" src="../jsCompras/funCompras.js"></script>
	<link rel="stylesheet" href="../../../bootstrapcss/comprascss.css">
	<script type="text/javascript">
		var id_sin_proveedor = "<?php echo $id_sin_proveedor ?>";
	</script>
</head>
<body>
	
	<br><br><br><br><br><br>

	<?php 

	if ($estado  == "Pendiente de Autorizar") {
		echo "<div><p class='text-center'>La requisicion <strong>".$id." </strong> se encuentra en <strong>".$estado."</strong> por lo que no se puede modificar 
		o enviar datos a los proveedores<p></div>";
		exit;
	}

	?>

	<h3 class="text-center"><?php echo $concepto ?></h3>
	<h5 class="text-center" style="color: #007BFF"><strong id="id_requisicion_"><?php echo  $id ?></strong></h5>





	<?php 



	// print_r($por_proveedor["proveedores"]);
	for ($i=0; $i <count($por_proveedor["proveedores_nombre"] ); $i++) { 

		$id_proveedor = $por_proveedor["proveedores"][$i];
		$nombre_proveedor = $por_proveedor["proveedores_nombre"][$i];
		$nombre_tabla =  "";
		$danger = "";
		if ($id_proveedor === $id_sin_proveedor ) {
			$nombre_tabla = "sin_proveedor_tabla";
			$danger =  "style='color:red' ";

		}
		$cont_producto = 0;
		for ($x=0; $x <count($por_proveedor["productos"]) ; $x++) { 
			if ($id_proveedor === $por_proveedor["productos"][$x]["PROVEEDOR"]) {
				$cont_producto++;
			}
		}


				?>

			<div class="accordion" id="accordionExample<?php echo $id_proveedor ?>">

				<div class="card">
					<div class="card-header" id="headingTwo<?php echo $id_proveedor ?>">
					
							<a  class="btn  collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo<?php echo $id_proveedor ?>" aria-expanded="false" aria-controls="collapseTwo<?php echo $id_proveedor ?>" <?php echo $danger ?> >
								<?php 
								$p = explode("|", $nombre_proveedor);
								$nombre_proveedor = $p[1];
								$cantidad_datos ="<span class='circulo_numero'>".$cont_producto."</span>";
								echo "<strong>".$nombre_proveedor."".$cantidad_datos."</strong>" ;
								
								?>
							</a>

						
					</div>
					<div id="collapseTwo<?php echo $id_proveedor ?>" class="collapse" aria-labelledby="headingTwo<?php echo $id_proveedor ?>" data-parent="#accordionExample<?php echo $id_proveedor ?>">
						<div class="card-body">

							<table class="table table-hover" id="<?php echo $nombre_tabla ?>">
								<thead  class="text-center">
									<tr>
										<th scope="col">ID</th>
										<th  >Producto</th>
										<!-- 00000001 significa que no tiene proveedor asignado es un numero que elegi al azar :v -->
										<?php 

										if ($id_proveedor == $id_sin_proveedor) {

											echo "<td style='width:10%'>    </td>";
										}
										?>
									</tr>
								</thead>
								<?php 
								if ($id_proveedor === $id_sin_proveedor ) { ?>
									<div class="form-group">
										<label for="">Proveedor</label>
										<div style="display: flex;">
											<input onclick="buscador_autocompletar('<?php echo $id_sin_proveedor ?>','../webCompras/busqueda.php','buscarProveedor')" type="text" class="form-control col-lg-8" id="<?php echo $id_sin_proveedor ?>" placeholder="Proveedor">
											<button style="margin-left: 10px" onclick="proveedor_por_producto('sin_proveedor_tabla')" class ='btn btn-success '> Guardar</button>
										</div>

									</div>
									<tbody>


										<?php 
									}	
									for ($x=0; $x <count($por_proveedor["productos"]) ; $x++) { 
										if ($id_proveedor === $por_proveedor["productos"][$x]["PROVEEDOR"]) {
											$producto = $por_proveedor["productos"][$x]["DESCRIP_PRODUCTO"];
											$indice = $por_proveedor["productos"][$x]["INDICE"];
										// echo $indice."--".$producto."<br>";
											?>


											<tr>
												<td scope="row" class="text-center"><?php echo $indice; ?></td>
												<td style="" class="td_producto"><?php echo $producto ?></td>
												<?php 

												if ($id_proveedor == $id_sin_proveedor) {

													echo "<td colspan='5'>   
													<input class='form-check-input' type='checkbox' id='' value='option1'>  </td>";

												}
												?>

											</tr>









											<?php
										}
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>
		<?php } ?>

	</body>
	</html>