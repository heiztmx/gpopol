<?php 
// include '../webprecios/metodosweb.php';
include '../metGASOLINERA/metodosGASOLINERA.php';
// $metodo = new metodosweb();

$metodoGAS = new GASOLINERA();


?>


<link rel="stylesheet" href="../../../bootstrapcss/limclientes.css">


<h5 style="text-align: left; font-weight: bold; position: relative; top: 0px;">Clientes de Credito</h5>




<div class="m-1">
	<small id="emailHelp" class="form-text text-muted">Escribe el nombre o el folio del cliente  que desee buscar</small>
</div>
<div class=" d-flex flex-wrap">

	<input class="form-control  col-lg-12" type="text" id="buscadorNombreCO" onclick="buscadorCO()" name="Buscar nombre" placeholder="Buscar nombre">	

</div>



<br>
<table class="table table-hover  table-sm" id="myTableCO">
	<thead class="thead-dark">
		<tr  class="ocultarColumnas">
			<td colspan="2"></td>
			<td colspan="2" style="text-align: center;border-left: 1px black solid; border-right:  1px black solid; font-weight:bold; " >Pendiente de facturar</td>
			<td colspan="1" style="text-align: center; font-weight:bold;">Facturado</td>
			<td colspan="2" style="text-align: center;border-left: 1px black solid; border-right:  1px black solid; font-weight:bold;">Credito</td>

		</tr>


		<tr style="background-color: #F7F7F9">
			<th  id="folio" class="letras" style="text-align: center;font-weight: bold;" scope="col">No. Cliente</th>
			<th  id="estacion" class="letras"  style="text-align: center;font-weight: bold;" scope="col">Nombre</th>
			<th  id="estacion" class="letras ocultarColumnas"  style="text-align: center;font-weight: bold;" scope="col">Tarjetas</th>
			<th  id="estacion" class="letras  ocultarColumnas"  style="text-align: center;font-weight: bold;" scope="col">Vales</th>
			<th  id="estacion" class="letras ocultarColumnas"  style="text-align: center;font-weight: bold;" scope="col">SaldoCXC</th>
			<th id="fecha" class="letras"  style="text-align: center;font-weight: bold;" scope="col">Limite</th>
			<th id="fecha" class="letras"  style="text-align: center;font-weight: bold;" scope="col">Disponible</th>
			<!-- <th></th> -->

		</tr>
	</thead>
	<tbody>
		<?php				

		$nofacturadotar =0;
		$nofacturadoVal = 0;
		$saldo =0;
		$i=0;
		$clie =$metodoGAS->datos_clientes();
		$no_fact_tarjetas =$metodoGAS->noFacturadoTarjetas();
		$vales_clie =$metodoGAS->noFacturadoVales();
		$saldoCXC =$metodoGAS->DCXCSCXC();
		$metGAS = $metodoGAS->limClieCredito();

		// print_r($clie);
		for ($i=0; $i <count($clie) ; $i++) { 
			# code...


			$num_cliente= $clie[$i]["noclie"];
			$limite_credito=0;
			$nofacturadotar= 0;
			$saldo=0;
			$nofacturadoVal=0;
			if (array_key_exists($num_cliente, $metGAS)) {
				$limite_credito =$metGAS[$num_cliente];
			}

			if (array_key_exists($num_cliente,$no_fact_tarjetas )) {
				$nofacturadotar = $no_fact_tarjetas[$num_cliente];
			}
			if (array_key_exists($num_cliente, $saldoCXC)) {
				$saldo = $saldoCXC[$num_cliente];
			}

			if (array_key_exists($num_cliente,$vales_clie )) {
				$nofacturadoVal= $vales_clie[$num_cliente];
			}
			$disponible =$limite_credito-($nofacturadotar + $nofacturadoVal +  $saldo);
			if ($saldo > 0  || $nofacturadotar > 0 || $nofacturadoVal > 0) {
		
			
			?>	





			<tr  id="contenido_clientesConsultaCO" style="cursor:pointer;" >

				<th style="text-align: center; width: 15%;" id="" scope="row" class="letras" > <?php echo $num_cliente ?></th>

				<td  id="heading" scope ="row" style="text-align: left;"  class="col-lg-3 letras  ">



					<?php 

					$nombre = $clie[$i]["nombre"];
					echo $nombre;
					


					?>
				</td>

				<td  id="heading" scope ="row" style=""  class="col-lg-3 letras ocultarColumnas ">
					<?php

					if ($nofacturadotar > 0) {
						print number_format($no_fact_tarjetas[$num_cliente],2,'.',',');
					}
					
					?>
				</td>
				<td  id="heading" scope ="row" style=""  class="col-lg-3 letras ocultarColumnas ">
					<?php

						if ($nofacturadoVal > 0) {
							print number_format($vales_clie[$num_cliente],2,'.',',');
						}
					
							//$nofacturadoVal =$metodoGAS->noFacturadoVales($row['NOCLIE']);
							//print number_format($nofacturadoVal,2,'.',','); ?>
						</td>

						<td  id="heading" scope ="row" style=""  class="col-lg-3 letras ocultarColumnas ">
							<?php

							if ($saldo > 0) {
								print number_format($saldoCXC[$num_cliente],2,'.',',');
							}
							
							?>
						</td>
						<td  scope ="row"  id="" class="letras"> <?php print number_format($limite_credito,2,'.',','); ?></td>

						<?php 
						
						
						$xc="";
						?>
						<td 

						<?php 
						if($disponible <= 5000 && $disponible >=1000 && $limite_credito> 10000) 
							{ echo "class='table-warning letras'  ";$xc="*";
					}
					elseif ($disponible < 1000 ) {
						echo "class ='table-danger letras'  ";
						$xc="*";
					}else{
							echo "class=' letras'";
							$xc="";
						} ?> 

						scope ="row"  id="" > 

						<?php 

						if ($disponible < 0 ) {
				 		# code...
							print "0".$xc;
						}else{

							print number_format($disponible,2,'.',',').$xc;
						}
						?>



					</td>

				</tr>










				<?php
}
			} ?>
		</tbody>
	</table>