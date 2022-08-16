

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.0/css/all.css" integrity="sha384-aOkxzJ5uQz7WBObEZcHvV5JvRW3TUc2rNPA7pe3AwnsUohiw1Vj2Rgx2KSOkF5+h" crossorigin="anonymous">
	<link rel="apple-touch-icon" sizes="76x76" href="../../../wizard/assets/img/favicon.ico">

	<title>Solcicitud de clientes</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta name="viewport" content="width=device-width" />

	<link rel="apple-touch-icon" sizes="76x76" href="../../../wizard/assets/img/apple-icon.png" />
	<link rel="icon" type="image/png" href="../../../wizard/assets/img/favicon.png" />

	<!--     Fonts and icons     -->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

	<!-- CSS Files -->
	<link href="../../../wizard/assets/css/bootstrap.min.css" rel="stylesheet" />
	<link href="../../../wizard/assets/css/material-bootstrap-wizard.css" rel="stylesheet" />
	<link rel="stylesheet" href="../../../bootstrapcss/clientes.css">

	<link href="../../../lou-multi-select-57fb8d3/css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="../../../jQuerymultiselectjs/src/example-styles.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<!-- <link href="../../../wizard/assets/css/demo.css" rel="stylesheet" /> -->
</head>

<body >
	<div class="image-container set-full-height" style="background-image: url('../../../wizard/assets/img/wizard-profile.jpg')">

		<a href="http://demos.creative-tim.com/material-kit/index.html?ref=material-bootstrap-wizard" class="made-with-mk">
			<div class="brand">MK</div>
			<div class="made-with">Made with <strong>Material Kit</strong></div>
		</a>

		<!--   Big container   -->
		<div class="container">
			<div class="row">
				<div class="col-sm-8 col-sm-offset-2" id="contendor_contenido_general">
					<!--      Wizard container        -->
					<div class="wizard-container">
						<div class="card wizard-card" data-color="green" id="wizardProfile">
							<form action="acccion.php" method="POST">
								<!--        You can switch " data-color="purple" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->

								<div class="wizard-header">
									<h3 class="wizard-title">
										Build Your Profile
									</h3>
									<h5>Solicitud de clientes.</h5>
								</div>
								<div class="wizard-navigation">
									<ul>
										<li><a href="#buscador" id="buscador_a" data-toggle="tab">Buscador</a></li>
										<li><a href="#RFC" data-toggle="tab" id="RFC_a">Clientes</a></li>
										<li><a href="#documentacion" id="documentacion_a" data-toggle="tab">Documentacion</a></li>
										<li><a href="#contenedor_tarjetas" id="contenedor_tarjetas_a" data-toggle="tab">Tarjetas</a></li>
										<li><a href="#address" id="address_a" data-toggle="tab">Finalizar</a></li>


									</ul>
								</div>

								<div class="tab-content">
									<div class="tab-pane" id="buscador" style="">
										<div class="con_buscador" style="">
											

											<div class="input-group">
												<span class="input-group-addon">
													<i class="material-icons">record_voice_over</i>
												</span>
												<div class="form-group label-floating">
													<label class="control-label">RFC <small>(necesario)</small></label>
													<input  class="form-control col-sm-10" type="text" id="buscar_rfc" name="rfc" >
												</div>
											</div>


											<!-- 	<button type="button"  class="btn col-sm-2" id="" onclick="buscador_clientes()">Buscar</button> -->

										</div>


									</div>
									<div class="tab-pane" id="RFC">

										<h4 id="seleccionar_cliente"> Seleccione el cliente que desea integrar a la cartera </h4>
										<table class='table' id="clientes_rfc">
											<thead class='thead-dark'>
												<tr>
													<th scope='col'>ID</th>
													<th scope='col'>Nombre</th>
													<th scope='col'>RFC</th>
													<th scope='col'>Tipo</th>
													<th scope='col'>Seleccionar</th>
												</tr>
											</thead>
											<tbody id="resultado_busqueda_rfc">
											</tbody>
										</table>
									</div>
									<div class="tab-pane"  id="documentacion">
										<h4 class="info-text"> Documentacion necesarioa </h4>



										<div class="contenedor_documentos">
											<h6>Acta constitutiva</h6>
											<div class="sub_cont_documentos"  onchange="upload_files('input_actaconsti', 'div_acta_contitutiva')">
												<input type="file" id="input_actaconsti" class="col-sm-2 col-sm-offset-1"  name="input_actaconsti">
												<div  id="div_acta_contitutiva" class="col-sm-5 col-sm-offset-1" >
												</div>
											</div>
											<h6>Solicitud de credito</h6>
											<div  class="sub_cont_documentos" onchange="upload_files('input_solicitud_credito','div_solicitud_credito')">
												<input type="file" id="input_solicitud_credito" class="col-sm-2 col-sm-offset-1" name="input_solicitud_credito">
												<div  id="div_solicitud_credito" class="col-sm-5 col-sm-offset-1" >
												</div>
											</div>
											<h6>Documento de RFC</h6>
											<div class="sub_cont_documentos" onchange="upload_files('input_rfc','div_rfc')">
												<input type="file" id="input_rfc" class="col-sm-2 col-sm-offset-1" name="input_rfc">
												<div  id="div_rfc" class="col-sm-5 col-sm-offset-1">
												</div>
											</div>
											<h6>Poder representante legal</h6>
											<div  class="sub_cont_documentos" onchange="upload_files('input_representante_legal','div_representante_legal')">
												<input type="file" id="input_representante_legal" class="col-sm-2 col-sm-offset-1" name="input_representante_legal">
												<div  id="div_representante_legal" class="col-sm-5 col-sm-offset-1" >
												</div>
											</div>
											<h6>Comprobante de domicilio</h6>
											<div class="sub_cont_documentos" onchange="upload_files('input_comprobante_domicilio','div_comprobante_domicilio')">
												<input type="file" id="input_comprobante_domicilio" class="col-sm-2 col-sm-offset-1" name="input_comprobante_domicilio">
												<div  id="div_comprobante_domicilio" class="col-sm-5 col-sm-offset-1" >
												</div>
											</div>
											<h6>Registro de vehiculos</h6>
											<div class="sub_cont_documentos" onchange="upload_files('input_registro_autos','div_registro_autos')">
												<input type="file" id="input_registro_autos" class="col-sm-2 col-sm-offset-1" name="input_registro_autos">
												<div  id="div_registro_autos" class="col-sm-5 col-sm-offset-1" >
												</div>
											</div>

										</div>


									<!-- 	<div class="row">
											<div class="col-sm-10 col-sm-offset-1">

											   <div class="col-sm-4 col-sm-offset-1">

												
											   </div>
												<div class="col-sm-4">
													<div class="choice" data-toggle="wizard-checkbox">
														<input type="checkbox" name="jobb" value="Code">
														<div class="icon">
															<i class="fa fa-terminal"></i>
														</div>
														<h6>Code</h6>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="choice" data-toggle="wizard-checkbox">
														<input type="checkbox" name="jobb" value="Develop">
														<div class="icon">
															<i class="fa fa-laptop"></i>
														</div>
														<h6>Develop</h6>
													</div>
												</div>
											</div>
										</div> -->
									</div>
									<div class="tab-pane" id="contenedor_tarjetas">
										<div class="input-group">
											<span class="input-group-addon">
												<!-- <i class="material-icons">record_voice_over</i> -->
											</span>
											<div class="form-group label-floating" style="display: flex;">
												<label class="control-label">Numero de tarjetas <small>(necesario)</small></label>
												<input  class="form-control col-sm-5" type="text" id="numero_tarjetas" name="numero_tarjetas" >
												<div class="col-sm-3">
													<button  type="button"  onclick="formulario_tarjetas()">Crear formularios</button>
												</div>
											</div>

										</div>
										<div id="formulario_tarjetas_n" class="form-group col-sm-12" style="display: flex;  flex-direction: column;">
											
										</div>
<!-- 										<div class="form-group col-sm-12"  style="display: flex; justify-content: space-between;" >
											<div class="col-sm-3">
												<div class="input-group ">

													<div class="form-group label-floating">
														<label class="control-label">Placas</label>
														<input name="name" type="text" class="form-control">
													</div>
												</div>

											</div>
											<div  class="col-sm-3">
												<div class="input-group ">

													<div class="form-group label-floating">
														<label class="control-label">Marca auto</label>
														<input name="name" type="text" class="form-control">
													</div>
												</div>
											</div>
											<div  class="col-sm-3">
												<div class="input-group ">

													<div class="form-group label-floating">
														<label class="control-label">Chofer</label>
														<input name="name" type="text" class="form-control">
													</div>
												</div>
											</div>
											<div class=" col-sm-2">

												<div class="form-group label-floating" style="display: flex;">
													<label class="control-label">Combustibles</label>
													<select id="solicitud_combustibles" name="solicitud_combustibles" multiple>
														<option value="magna">M</option>
														<option value="premium">P</option>
														<option value="diesel">D</option>

													</select>
												</div>
											</div>

											<div class=" col-sm-2">
												<div class="form-group label-floating" style="display: flex;">
													<label class="control-label">Solicitud de km</label>
													<select id="solicitud_km" name="solicitud_km" multiple>
														<option value="Si">Si</option>
														<option value="No">No</option>
													</select>
												</div>
											</div>
											<div class="input-group col-sm-2">
												<div class="form-group label-floating" style="display: flex;">
													<label class="control-label">Dias de carga</label>
													<select id="periodo" name="periodo" multiple>
														<option value="semanal">Semanal</option>
														<option value="mensual">Mensual</option>
													</select>

												</div>
											</div>
											<div class="input-group col-sm-2">
												<div class="form-group label-floating" style="display: flex;">
													<label class="control-label">Dias de carga</label>
													<select id="dias_carga" name="dias_carga" multiple>
														<option value="domingo">D</option>
														<option value="lunes">L</option>
														<option value="martes">Ma</option>
														<option value="miercoles">Mi</option>
														<option value="jueves">J</option>
														<option value="viernes">V</option>
														<option value="sabado">S</option>
													</select>

												</div>
											</div>
											<div  class="col-sm-2">
												<div class="input-group">
													<div class="form-group label-floating">
														<label class="control-label">Horas de carga</label>
														<div style="display: flex;">

															<select id="hora_final" name="hora_final" multiple>
																<option value="domingo">01:00</option>
																<option value="lunes">02:00</option>
																<option value="martes">03:00</option>
																<option value="miercoles">04:00</option>
																<option value="jueves">05:00</option>
																<option value="viernes">06:00</option>
																<option value="sabado">08:00</option>
																<option value="sabado">09:00</option>
																<option value="sabado">10:00</option>
																<option value="sabado">11:00</option>
																<option value="sabado">12:00</option>				
															</select>
														</div>
													</div>
												</div>
											</div>
											<div  class="col-sm-3">
												<div class="input-group">

													<div class="form-group label-floating">
														<label class="control-label">Monto maximo</label>
														<input name="name" type="text" class="form-control">
													</div>
												</div>
											</div>


										</div> -->
									</div>
									<div class="tab-pane" id="address">
										<div class="row">
											<div class="col-sm-12">
												<h4 class="info-text"> Are you living in a nice area? </h4>
											</div>
											<div class="col-sm-7 col-sm-offset-1">
												<div class="form-group label-floating">
													<label class="control-label">Street Name</label>
													<input type="text" class="form-control">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="form-group label-floating">
													<label class="control-label">Street Number</label>
													<input type="text" class="form-control">
												</div>
											</div>
											<div class="col-sm-5 col-sm-offset-1">
												<div class="form-group label-floating">
													<label class="control-label">City</label>
													<input type="text" class="form-control">
												</div>
											</div>
											<div class="col-sm-3">
												<select id="languages" name="languages" multiple>
													<option value="JavaScript">JavaScript</option>
													<option value="C++">C++</option>
													<option value="Python">Python</option>
													<option value="Ruby">Ruby</option>
													<option value="PHO">PHP</option>
													<option value="Pascal">Pascal</option>
												</select>

											</div>
										</div>
									</div>
								</div>
								<div class="wizard-footer">
									<div class="pull-right">
										<input type='button' class='btn btn-next btn-fill btn-success btn-wd' name='next' value='Next' />
										<input type='submit' class='btn btn-finish btn-fill btn-success btn-wd' name='finish' value='Finish' />
									</div>

									<div class="pull-left">
										<input type='button' class='btn btn-previous btn-fill btn-default btn-wd' name='previous' value='Previous' />
									</div>
									<div class="clearfix"></div>
								</div>
							</form>
						</div>
					</div> <!-- wizard container -->
				</div>
			</div><!-- end row -->
		</div> <!--  big container -->

		<div class="footer">
			<div class="container text-center">
				Made with <i class="fa fa-heart heart"></i> by <a href="http://www.creative-tim.com">Creative Tim</a>. Free download <a href="http://www.creative-tim.com/product/bootstrap-wizard">here.</a>
			</div>
		</div>
	</div>

</body>
<!--   Core JS Files   -->
<script src="../../../wizard/assets/js/jquery-2.2.4.min.js" type="text/javascript"></script>
<script src="../../../wizard/assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../lou-multi-select-57fb8d3/js/jquery.multi-select.js" type="text/javascript"></script>
<script src="../../../wizard/assets/js/jquery.bootstrap.js" type="text/javascript"></script>
<script src="../../../jQuerymultiselectjs/src/jquery.multi-select.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<!--  Plugin for the Wizard -->
<script src="../../../wizard/assets/js/material-bootstrap-wizard.js"></script>

<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
<script src="../../../wizard/assets/js/jquery.validate.min.js"></script>
<script src="../js/funciones.js"></script>
</html>
