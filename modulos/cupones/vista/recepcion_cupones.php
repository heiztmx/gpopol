


<?php 



include "../../../conexion/sesion.php";
$ses = new sesion();
$permisos = $ses->validar_sesion();


include '../../../menu/menu2.php' ;

?>
<!DOCTYPE html>
<html >
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Recepcion de Cupones</title>
	<link rel="stylesheet" href="../../../bootstrapcss/comprascss.css">

	<script type="text/javascript" src="../jsCupones/nueva_req.js"></script>


	<script type="text/javascript" src="../jsCupones/funCompras.js"></script>

<!--
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js">javascript"></script> -->
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/css/jquery.dataTables.min.css"> 
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.16/js/jquery.dataTables.min.js"></script>

<style>
	.err {
		border: solid 2px #FF0000 !important;
	}
</style>

	
	<?php 
	include "../submenus/menucompras.php";
	include "../metCupones/metodosCupones.php";
	$obj= new Cupones();
	if ($_SESSION["idgas"] == Null || $_SESSION["idgas"] == "") {
		echo "<div class = 'div_contenedor'>
		<h4  >Usuario web, sin usuario igas en la tabla usuarios</h4></div>";
		exit();
	}

	$list_est =$obj->REC_ESTACIONES($_SESSION["id"],"RECCUPONFIL");

	//$EstAut= $list_est["ESTACION"];
	//$gen = $permisos["general"];// $gen = new generales();
	?> 



	<!-- <script type="text/javascript" src="../jsCupones/nueva_req.js"></script> -->
	<!-- <script src="../../../javascript/jquery-3.3.1.min.js"></script> -->


</head>
<body>
	<br>
	<br>
	<br>
	<br>

		<div class="w-100 p-3 align-middle">
			<span class="font-weight-normal">Recepcion de Cupones</span>
		</div>



<div class="container " style="width: 100%;">

  <form id="form1"  class="" >
	<div class="form-row">
		
		<div class="input-group col-md" style="margin-bottom: 10px;">
		  <div class="input-group-prepend">
		    <span class="input-group-text">Empresa</span>
		  </div>
						<select class="form-control" id="empresas">
							<!-- <option selected=""></option> -->
							<?php 
							
							// echo('<pre>');
							// var_dump($list_est[0]["PERMISO_ESPECIAL"]);
							// echo('</pre>');
							
													
							for ($i=0; $i < count($list_est); $i++) { 
								$idsuc = $list_est[$i]["PERMISO_ESPECIAL"];
								$sucursal = $list_est[$i]["ESTACION"];
								
								echo "<option value=".$idsuc.">".$sucursal."</option>";

							}
							

							?>
							

						</select>
			  <div class="input-group-append">
			  </div>
		</div>

		<div class="input-group col-md btn-group me-2" role="group" aria-label="First group" style="margin-bottom: 10px;">

		  	 <div class="input-group-prepend" aria-label="First group">
		   		 <span class="input-group-text">Folio Volumetrico</span>
		 	 </div>
				 <input required maxlength="9" min="0" class="form-control" type="text" id="folio_volumetrico"  onkeypress="return valideKey(event);" onclick="limpia('tabla_requ_nuevas')">
				 <button type="button" id="boton_foliovol" class="btn btn-outline-secondary" onclick="valida_foliovol('tabla_requ_nuevas','seccioncupones','valida_x_foliovol')"><i class="fas fa-search"></i></button>
			  <div class="input-group-append">
			  </div>


		</div>		

		<div class="input-group col-lg" style="margin-bottom: 10px;">

		  	 <div class="input-group-prepend">
		   		 <span class="input-group-text">Fecha</span>
		 	 </div>
				 <input required class="form-control" type="date" id="fecha_recuperacion"  value="<?php 
				 date_default_timezone_set('America/Mexico_City'); 
				 echo date("Y-m-d");?>">
			  <div class="input-group-append">
			  </div>
		  

		</div>


	</div>
  



	<div class="form-row">
		<div class="input-group col-md" style="margin-bottom: 5px;">

		  	 <div class="input-group-prepend">
		   		 <span class="input-group-text" >Producto</span>
		 	 </div>
					<select required class="form-control" id="producto">
				      <option value=""></option>
				      <option value="1" >Magna</option>
				      <option value="2">Premium</option>
				      <option value="3">Diesel</option>
				    </select>
			  <div class="input-group-append">
			  </div>

		</div>

		<div class="input-group col-md" style="margin-bottom: 5px;">

		  	 <div class="input-group-prepend">
		   		 <span class="input-group-text">Precio</span>
		 	 </div>
				 <input required maxlength="6" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" class="form-control" type="number" step="0.01" min="1"  id="precio_folio">
			  <div class="input-group-append">
			  </div>
	  


		</div>

		<div class="input-group col-md" style="margin-bottom: 5px;">

		  	 <div class="input-group-prepend">
		   		 <span class="input-group-text">Importe</span>
		 	 </div>
				 <input required class="form-control" type="number" maxlength="10" step="0.01" min="0" oninput="if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" id="importe_folio">
			  <div class="input-group-append ">
			  </div>
		  


		</div>
	</div>
  </form>

   

	<div id="seccioncupones" class="row justify-content-center invisible" >
	 <div class="col-lg-6 justify-content-center" style="">
		 <div class="col d-flex flex-wrap justify-content-center " style="margin-top: 0rem;padding: 0px;" >

			

			<div class="input-group " style="margin-bottom: 5px;">

		  		 <div id="areacod" class="input-group-prepend">
		   			 <span class="input-group-text">Codigo de Cupon</span>
		 		 </div>
				 	<input id="cod" placeholder="Escanear Cupon" class="form-control" type="text" id="cod" onkeypress="pulsar(event);">
			 	 <div class="input-group-append">
			  </div>

			</div>

			<div class="btn-group " role="group" aria-label="Basic example" style="margin-bottom: 5px;" >
	 			 <button type="button" class="btn btn-secondary" onclick="agregar_registro_datatable('tabla_requ_nuevas','valida_x_cupon')">Agregar</button>
	 			 <button type="button" class="btn btn-secondary" onclick="eliminar_registro('tabla_requ_nuevas')">Eliminar</button>
				 <button id="boton_guardar" disabled class="btn btn-dark" type="button" onclick="validar_campos('tabla_requ_nuevas')">Guardar</button>
			</div>

		 </div>	

		  
						<table id="tabla_requ_nuevas" class="display cell-border compact hover table-striped table-bordered dataTable dtr-inline" role="grid" aria-describedby="tabla_info" style="width:100%;" >
							<thead>
								<tr role="row" style="background-color:#e9ecef;">
									<th  style=" text-align: center;font-weight: normal; width:5%;"><!--<input type="checkbox" id="checkTodos">--></th>
									<th  style="text-align: center;font-weight: normal; width:5%;" id="tipo_req_odc">No.</th>
									<th  style="text-align: center;font-weight: normal; width:30%;">Fecha Factura</th>
									<th  style="text-align: center;font-weight: normal; width:30%;">Factura</th>
									<th  style="text-align: center;font-weight: normal; width:30%;">Folio</th>
									<th  style="text-align: center;font-weight: normal; width:20%;">Importe</th>
								</tr>
							</thead>
							<tfoot>
								<tr role="row" style="background-color:#e9ecef;">
									<th  style=" text-align: center;font-weight: normal; width:5%;"></th>
									<th  style="text-align: center;font-weight: normal; width:5%;"></th>
									<th  style="text-align: center;font-weight: normal; width:30%;"></th>
									<th  style="text-align: center;font-weight: normal; width:30%;"></th>
									<th  style="text-align: center;font-weight: normal; width:30%;">Total:</th>
									<th  style="text-align: center;font-weight: normal; width:20%;" id="importe">
									<input class="form-control border-0"  style="text-align:center;padding:0px;height:auto;" name="total[]" readonly placeholder="Total"  id="totalg">	
									</th>
								</tr>
							</tfoot>							


						</table>

	 </div>
	
	</div>
						<div id="loading">

						</div>


</div>

<script language="javascript">

 

</script>


			<br>

		<?php
		//include  '../modals/requisiciones.php';
		//include  '../modals/ordenes_compra.php';
		//include  '../modals/buscador_productos.php';
		//include  '../modals/buscador_proveedores.php';
		//include '../modals/opciones_crear_documentos.php';
		?>
	</body>
	</html>


