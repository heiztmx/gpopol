

	function tomardatos_tabla(tabla) {
		var table = $('#'+tabla).DataTable();
 
		var data = table
			.rows()
			.data();
		 
		alert( 'The table has '+data.length+' records' );
	}

	// buscadores_x_columna()



function valideKey(evt){
    
    // code is the decimal ASCII representation of the pressed key.
    var code = (evt.which) ? evt.which : evt.keyCode;
    
    if(code==8) { // backspace.
      return true;
    } else if(code>=48 && code<=57) { // is a number.
      return true;
    } else if (evt.keyCode === 13 && !evt.shiftKey){ // is a enter
    					document.getElementById('boton_foliovol').focus();
      				valida_foliovol('tabla_requ_nuevas','seccioncupones','valida_x_foliovol');

    }else{
    	return false;
    }


}


	function modal_opciones_crear_documento($datos ="") {
		$("#btn_modal_crear_doc").click()
		// alert(idusuario)
		parametros = {
			"opcion":"permisos_crear_documentos",

		}
		$.ajax({
			type: 'POST',
			url:'../webCupones/busqueda.php',
			data:parametros,
			success:function (respuesta) { 
						option= "<div class='col-lg-12 d-flex flex-wrap'>"
						 +"<div class='col-lg-10 d-flex flex-wrap justify-content-between'>"
						   
						    +"<label class='col-lg-6' for='Folio'> Folio Volumetrico:</label>" + " "
						    +"<input class='col-lg-6 form-control' type='text' onkeypress='return valideKey(event);' name='Folio_Vol' id='FOLIO' value='' placeholder='Ingrese Folio' >"
						   
						 +"</div>"
						 +"</div>"
						 +"<div class='col-lg-12 d-flex flex-wrap  '></div>"

						 +"<div class='col-lg-12 d-flex flex-wrap'>"
						 +"<div class='col-lg-10 d-flex flex-wrap justify-content-between'>"
						    
						   +"<label class='col-lg-6' for='Combustible'> Combustible:</label>" + " "
							+"<div class='form-group col-lg-6' style='padding-left:0px; padding-right:0px; margin-bottom:1px;  ' >"
							 +"<select class='form-control '  name='opcioncombustible' id='TipoCombustible'>"
							 +"<option  selected value='1'>Magna</opcion>"
							 +"<option  value='2'>Premium</opcion>"
							 +"<option  value='3'>Diesel</opcion>"
							 +"</select>"
							+"</div>"
						   
						  +"</div>"
					 	 +"</div>"
					 	 +"</div>"
					 	 +"<div class='col-lg-12 d-flex flex-wrap'>"
						 +"<div class='col-lg-10 d-flex flex-wrap justify-content-between'>"
						   
						    +"<label class='col-lg-6' for='Precio'> Precio:</label>" + " "
						    +"<input class='col-lg-6 form-control' type='number'  name='Precio' id='Precio' value='' placeholder='Ingrese Precio' >"
						   
						 +"</div>"
						 +"</div>"

						 +"<div class='col-lg-12 d-flex flex-wrap'>"
						 +"<div class='col-lg-10 d-flex flex-wrap justify-content-between'>"
						   
						    +"<label class='col-lg-6' for='Importe'> Importe:</label>" + " "
						    +"<input class='col-lg-6 form-control' type='number'  name='Importe' id='Importe' value='' placeholder='Ingrese el Importe' >"
						   
						 +"</div>"
						 +"</div>"
												

						$("#opciones_documentos").html(option)
			}
		})



	}

	


	function pagina_principal_compras() {
		// body...
		window.location="index.php";
	}

	function recepcion_cupones() {
		window.location="recepcion_cupones.php"
	}

	function siguiente_crear_documento() {
		var Folio_Vol= null;
		var TipoCombustible= null;
		var Precio= null;
		var importe= null;

		opcion_crear = $("input:radio[name=elegir_permiso]:checked").val()
		Folio_Vol = document.getElementById("FOLIO").value;
		TipoCombustible = document.getElementById("TipoCombustible").value;
		Precio = document.getElementById("Precio").value;
		importe = document.getElementById("Importe").value;

		console.log(Folio_Vol + ",", TipoCombustible + ",", Precio + ",", importe)

		if (Folio_Vol != '' && Precio != '' && importe != '') {
			if (Precio > 0 && importe > 0) {

				window.location="nueva_requisicion.php"
			}
			else{
			$("#error_opcion").empty();
			$("#error_opcion").css({"display":"inline"})
			$("#error_opcion").html("<p style ='color:red; text-align: justify-content-between; font-size:0.8rem; align-items:center;' >Imposible continuar, no se acepta cantidad negativa.</p>")
			setTimeout(function () { $("#error_opcion").css({"display": "none"}) }, 3000)
		}
		}else{
			$("#error_opcion").empty();
			$("#error_opcion").css({"display":"inline"})
			$("#error_opcion").html("<p style ='color:red; text-align: justify-content-between; font-size:0.8rem; align-items:center;' >Imposible continuar, no se aceptan casillas vacias.</p>")
			setTimeout(function () {
				$("#error_opcion").css({"display": "none"})
			}, 3000)
		}

		function recepcion_cupones() {
			
					window.location ="recepcion_cupones.php"
			}
	// Seleccionar el tipo de solicitud que desea crear
}


function validar_seleccionados(tabla) {
	var table  = $("#"+tabla).DataTable();
	contador = 0;
	$("#"+tabla+" tr").find('td:eq(0) input[type=checkbox]').each(function () {
		if ($(this).prop('checked')) {

			contador++;
		}
	})
	return contador
}
function MaysPrimera(string){
	return string.charAt(0).toUpperCase() + string.slice(1);
}

function eliminar_registro(tabla) {
/*
    $("#"+tabla).click(function () {
                 var check = $ ("input [name = 'check']: radio"); // Casilla seleccionada
        check.each(function(){
            var row=$(this).parent("td").parent("tr").remove()
        });
 
    });*/


	var table = $('#'+tabla).DataTable();
	_seleccionados = validar_seleccionados(tabla)


	if (_seleccionados > 0) {


		if (table.data().count() ) {
			alertify.confirm('Eliminar', '¿Seguro que desea eliminar el registro', 
				function(){ 
					var table = $('#'+tabla).DataTable();
					$("#"+tabla+" tr").find('td:eq(0) input[type=checkbox]').each(function () {

						if ($(this).prop('checked')) {

							table.row('.seleccionado_borrar').remove().draw(false);
						}



					})

					regenerar_index(tabla)
				}

				, 
				function(){ 
			// alertify.error('Cancel')
		});
		}

	}



}

function regenera_id(tabla) {
	table  = $("#"+tabla).DataTable();
	i = 1
	columna ="";
		// if (campo == "cantidad") {columna  == 4}
		// 	if (campo == "precio") {columna == 5}
		// 		if (campo == "importes") {columna == 6}
			// console.log(typeof tabla)
			// console.log( tabla)


			$("#"+tabla+" tr").find('td:eq(3) input[type=text]').each(function () {
			// nuevo  = campo+""+i
			
			$(this).removeAttr("id")
			$(this).attr("id","factura"+i)
			// $(this).attr("id",nuevo);
			i++
			
		})
			i = 1
			$("#"+tabla+" tr").find('td:eq(4) input[type=text]').each(function () {
			// nuevo  = campo+""+i
			
			$(this).removeAttr("id")
			$(this).attr("id","folio"+i)
			// $(this).attr("id",nuevo);
			i++
			
		})
			i = 1
			$("#"+tabla+" tr").find('td:eq(6) input[type=text]').each(function () {
			// nuevo  = campo+""+i
			
			$(this).removeAttr("id")
			$(this).attr("id","importe"+i)
			// $(this).attr("id",nuevo);
			i++
			
		})
		   // $("#"+campo+""+i).removeAttr("id");
   		// 	$("#"+campo+""+i).attr("id",campo+""+i);
   	}
   	function regenerar_index(tabla) {

	var table = $('#'+tabla).DataTable({    
																		  "bProcessing": true,
																	    "sAutoWidth": false,
																	    "bDestroy":true,
																	    "sPaginationType": "bootstrap", // full_numbers
																	    "iDisplayStart ": 10,
																	    "iDisplayLength": 10,
																	    "bPaginate": false, //hide pagination
																	    "bFilter": false, //hide Search bar
																	    "bInfo": false, // hide showing entries  
    																});

   		rows1 =table.rows().data().length
   		
   		for(i=0; i<rows1; i++)
   		{

   			index = i + 1 

   			table.cell(i, 1).data(index).draw();
   			//table.cell(i, 1).css({"text-align":"center"});
   		}
   		contador = 0
   									sum=getTblTotal($("#"+tabla).DataTable,'input[name="importes[]"]');
											$("#totalg").val(sum);
											$("#importe_folio").val(document.getElementById('totalg').value);


	}
	function empresa1() {
		empresa ="";
		empresa = $("#empresas").val();
		vacio  =  0;

		$("#departamento option:selected").attr("selected",false);
		$("#departamento option[value="+empresa+"]").attr("selected",true);
	// console.log("empresa "+empresa)
	// $("#almacen option:selected").attr("selected",false);
	

	$('#almacen  option').each(function(){
		// console.log("opt "+this.value+ " ---  empr" + empresa)
		if ( $("#almacen option[value='"+empresa+"']").length > 0 ) {

			//desmarcar para evitar errores
			$("#almacen option:selected").attr("selected",false);
			

			//seleccionar la opcion dependiendo de la empresa
			$("#almacen option[value="+empresa+"]").attr("selected",true);
			

			if ( $("#afectacion option[value='2']").length > 0) {

			}else{

				$('#afectacion').append($('<option>', {value: 2,text: 'Almacen'}));

			}
			

			
			vacio++;
			return false;
			

		}else{
			$('#afectacion option[value="2"]').remove();
			
			
		}

		
	});
	if (vacio === 0) {
		$("#almacen option[value='']").attr("selected",true);
		return false;
	}

	

	


}


function activar_borrado_requisiciones(tabla,cont) {



	if ($("#checkborrar"+cont).prop('checked')) {
		$('tr').click(function() {
			$(this).addClass('seleccionado_borrar');	
		})

	}else{
		$('tr').click(function() {	
			$(this).removeClass('seleccionado_borrar');		
		})
	}





}


function borrador(tabla) {
	// var table = $('#'+tabla).DataTable();
	// activar_borrado_requisiciones(tabla)
}


function pulsar(e) {
    
	    if (e.keyCode === 13 && !e.shiftKey) {
		        //e.preventDefault();
						   agregar_registro_datatable('tabla_requ_nuevas','valida_x_cupon');
				}
}




function agregar_registro(tabla) {

	var cod_cupon=document.getElementById('cod').value
	var combo_est = $("#empresas").val();
	var fecha_rec = $("#fecha_recuperacion").val();
	var par_factura=valida_formato_cupon(cod_cupon)["estacion"];
	var par_estacion=valida_formato_cupon(cod_cupon)["estacion"];
	var par_folio=valida_formato_cupon(cod_cupon)["folio"];
	var par_importe=valida_formato_cupon(cod_cupon)["importe"];
	var counter = 1;
	var table = $('#'+tabla).DataTable()
	var data = table.rows().data();


	folios = table.$('input[name="folio[]"]').map(function(){ 
     		return this.value; }).get();
	const folio_existe=folios.find(element => element == par_folio);
	var est= valida_formato_cupon(cod_cupon);
	
if(valida_formato_cupon(cod_cupon) != false &&  folio_existe === undefined &&  par_estacion === combo_est)
{
	//console.log(par_estacion, par_folio, par_importe)
  var parametros={
  								"fecha_recuperacion":fecha_rec,
									"estacion":par_estacion,
									"folio_cupon":par_folio
								 }
console.log(parametros)

	//$("#tabla_list").css({"display":"inline"});



					$("#tabla_list").DataTable({
					destroy: true,
					responsive: true,
					orderCellsTop: true,

					"language": {
						"emptyTable": "No se encontraron registros "
					},
					"ajax": {
						"data": parametros,
						"method": "POST",
						"url": "../webCupones/busqueda.php"
					},
					"columns": [

					{ "data": "Check" },
						{ "data": "No" },
						{ "data": "Factura" },
						{ "data": "Folio" },
						{ "data": "Importe" },
						],

						"columnDefs": [{
							"targets": 1,
							"data": "No",
							"render": function (data, type, row, meta) {
								afectacion_re = row.Estado

								req = data.split("/")
								requisicion = req[0].replace(/[-+()\s]/g, '-');
								cadena1 = "<strong  >" + req[0] + ", </strong>";
								cadena2 = "";
								if (req.length > 1) {
									cadena2 = "<span style='color:gray'>" + req[1] + "</span>"
								}
								archivo = "busqueda";

								if (afectacion_re == "Pendiente de Cotizar" || afectacion_re == "Solicitando Precios" || (afectacion_re == "Pendiente de Autorizar" && afec == "PendientedeCotizar")) {
									afectacion_re = borrar_espacios(afectacion_re)
									modal = "<a href='#'' data-toggle='modal' data-target='.modal_cotizador' onclick=modal_detallado_cotizaciones('" + requisicion + "','" + afectacion_re + "') >" + cadena1 + "</a>" + cadena2;
								} else {
									modal = "<a href='#'' data-toggle='modal' data-target='.bd-example-modal-lg' onclick=modal_detallado('" + requisicion + "','" + estado_btn + "') >" + cadena1 + "</a>" + cadena2;

								}

								return modal
							}
						}],
						
						footerCallback: function (row, data, start, end, display) {


							var api = this.api();
						// Remove the formatting to get integer data for summation
						var intVal = function (i) {
							return typeof i === 'string' ?
							i.replace(/[\$,]/g, '') * 1 :
							typeof i === 'number' ?
							i : 0;
						};

						// Total over all pages
						var total = api
						.column(5)
						.data()
						.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);

						// Total over this page
						var pageTotal = api
						.column(5, { page: 'current' })
						.data()
						.reduce(function (a, b) {
							return intVal(a) + intVal(b);
						}, 0);

						// Update footer
						$(api.column(5).footer()).html(
							'$' + pageTotal.toFixed(2)
							);
					},
					"initComplete": function () {

						buscadores_x_columna("tabla")



					}

				});




	
/*
	numero_rows = data.length;
	counter = 1 + numero_rows;

 	// (table.row().count())
 	contador = data.length + 1
 	contador =  Math.floor(Math.random()*54545454)

 	
 	estilo='style="text-align:center;"'
 	check = '<input type="checkbox" id="checkborrar'+contador+'"  class = "select-checkbox" onclick =activar_borrado_requisiciones("'+tabla+'","'+contador+'")>'
 	No = '<input type="text" name="contador[]" id=id"'+ contador + '" value="'+counter+'">'
 	factura='<input name="factura[]" placeholder="Factura" id="factura'+ contador + '" value="'+par_factura+'">'
 	folio = ' <input name="folio[]" readonly placeholder="Folio" onclick =modal_buscar_producto("'+tabla+'") id="folio'+contador+'" value="'+par_folio+'">'
 	importe = ' <input name="importes[]" placeholder="Importe" oninput=calculo_real_req("'+contador+'","cantidad","precio") value="'+par_importe+'" id="importe'+contador+ '">'

// 	contador = data.length + 1
 	table.row.add( [
 		check,
 		No,
 		factura,
 		folio,
 		importe
 		] ).draw( false );

*/
 		$("#cod").val("");
 		$("td").css({"text-align":"center"});
 		$("td").addClass("align-middle")
        // counter++;


        // activar_borrado_requisiciones(tabla)
        // moverMouse(tabla)


}else if(folio_existe != undefined && par_estacion === combo_est){

		     		Swal({
		     		type: 'error',
		     		title: 'Cupon ya existe en la lista',
		     		text: '',
		     		footer: '<a href ="#"></a>'
		    	 	})

     	}else{
			     	Swal({
			     		type: 'error',
			     		title: 'Cupon no valido',
			     		text: 'Verique con el encargado, el cupon no es valido para la estacion seleccionada',
			     		footer: '<a href ="#"></a>'
			     	})
		     	}


 }

 function valida_formato_cupon(cadena){

	let estacion = cadena.substring(0, 5);
	let folio = cadena.substring(5, 13);
	let importe = cadena.substring(13, 16);
	var datos_cupon=new Array();
	
	if (estacion === "55ORA"){
		datos_cupon={"estacion":'1',"folio":folio,"importe":importe};
				return datos_cupon;
	}else if (estacion === "55JXR"){
		datos_cupon={"estacion":'4',"folio":folio,"importe":importe};
			return datos_cupon;
	}else if (estacion === "55RNH"){
		datos_cupon={"estacion":'2',"folio":folio,"importe":importe};
			return datos_cupon;
	}else{
		return false;
	}
}       



function agregar_registro_datatable(tabla,opcion) {

	var cod_cupon=document.getElementById('cod').value;
	//var lectorcod = document.getElementById('inputcod')
	var combo_est = $("#empresas").val();
	var fecha_rec = $("#fecha_recuperacion").val();
	var par_factura="";
	var par_estacion=valida_formato_cupon(cod_cupon)["estacion"];
	var par_folio=parseInt(valida_formato_cupon(cod_cupon)["folio"]);
	var par_importe=valida_formato_cupon(cod_cupon)["importe"];
	var counter = 1;
	var table = $('#'+tabla).DataTable({    
																		  "bProcessing": true,
																	    "sAutoWidth": false,
																	    "bDestroy":true,
																	    "sPaginationType": "bootstrap", // full_numbers
																	    "iDisplayStart ": 10,
																	    "iDisplayLength": 10,
																	    "bPaginate": false, //hide pagination
																	    "bFilter": false, //hide Search bar
																	    "bInfo": false, // hide showing entries  
    																});
	var data = table.rows().data();


	folios = table.$('input[name="folio[]"]').map(function(){ 
     		return this.value; }).get();
	const folio_existe=folios.find(element => element == par_folio);
	var est= valida_formato_cupon(cod_cupon);
	

if(folio_existe === undefined &&  par_estacion === combo_est)
{
	//console.log(par_estacion, par_folio, par_importe)
  //opcion="valida_x_cupon";
  var parametros={
  								"fecha_recuperacion":fecha_rec,
									"estacion":par_estacion,
									"folio_cupon":par_folio,
								  "opcion":opcion
								 }
  //console.log("Parametros enviado = ", parametros,typeof(parametros))

  $.ajax({
							type: 'POST',
							url: '../webCupones/busqueda.php',
							data: parametros,
							dataType:"html",
							timeout: 10000, //10seg
      
      beforeSend: function(){
                    //imagen de loading
                    //lectorcod.disabled = true;
                    $("#loading").css({"display":"inline"});
                    $('#cod').prop('readonly', true);
                    $('#boton_guardar').prop('disabled', true);
                    $("#loading").html("<div  id='loader' class='preloader mx-auto font-weight-light' style='border-top:10px solid #fbbb1d;'></div>");
                    },

		  error: function(request, status, err)
		  				{
		  					if (status == "timeout") 
		  						 {
          				  alert("Su petición demoro mas de lo permitido");
       						 } else {
           		 					// another error occured  
						                Swal({
						                			type: 'error',
						                			title: 'No se pudo validar el cupon',
						                			text: 'Error de comunicacion con el servidor. Intenta de nuevo recargando la pagina, si el problema persiste llamar a sistemas',
																	confirmButtonColor: "#fbbb1d"
																})
        									}

              },						
			success: function( respuesta ) 
							{											
								//lectorcod.disabled = false;
								$('#cod').prop('readonly', false);
								$("#loading").css({"display":"none"});
								$('#boton_guardar').prop('disabled', false);
								datos=JSON.parse(respuesta);

							 if (datos.length>0)
							 {
							 	switch (datos[0]["ESTATUS"])
							 	{
							 		case 'S':
						                Swal({
						                			type: 'warning',
						                			title:'Cupon no vendido',
						                			text: 'Existe en stock pero aun no tiene factura de anticipo asignada',
																	confirmButtonColor: "#fbbb1d"
																})								 		

							 		break;
							 		case 'V':
														numero_rows = data.length;
														counter = 1 + numero_rows;
													 	contador = par_folio;		
													 	dato_fecha=formatDate(new Date(datos[0]["FECHAVENTA"]),2);			

													 	estilo='class="form-check" style="align-items:center;height:auto;background-color:white !important;"';
													 	estilo1='class="form-control border-0"  style="text-align:center;padding:0px;height:auto;background-color:white !important;"';
													 
													 	check = '<div class="d-flex justify-content-center"><input '+estilo+' type="checkbox" id="checkborrar'+contador+'"  class = "select-checkbox" onclick =activar_borrado_requisiciones("'+tabla+'","'+contador+'")></div>'
													 	No = '<input '+estilo1+' name="contador[]" readonly id=id"'+ contador + '" value="'+counter+'">'
													 	fechaventa='<input '+estilo1+' name="fechaventa[]" readonly placeholder="fechaventa" id="fechaventa'+ contador + '" value="'+dato_fecha+'">'
													 	factura='<input '+estilo1+' name="factura[]" readonly placeholder="Factura" id="factura'+ contador + '" value="'+"FA"+"-"+datos[0]["IDANTICIPO"]+'">'
													 	folio = '<input '+estilo1+' name="folio[]" readonly placeholder="Folio" onclick =modal_buscar_producto("'+tabla+'") id="folio'+contador+'" value="'+datos[0]["FOLIO"]+'">'
													 	importe = ' <input '+estilo1+' name="importes[]" readonly placeholder="Importe" oninput=calculo_real_req("'+contador+'","cantidad","precio") value="'+parseFloat(datos[0]["IMPORTE"]).toFixed(2)+'" id="importe'+contador+ '">'
													 	//folio = '<input '+estilo1+' name="folio[]" readonly placeholder="Folio" onclick =modal_buscar_producto("'+tabla+'") id="folio'+contador+'" value="'+datos[0]["ESTATUS"]+'">'
													 	table.row.add([check,No,fechaventa,factura,folio,importe]).draw( false );
													 	$("td").css({"padding":"0px","height":"auto","text-align":"center"});
													 	
													 	sum=getTblTotal(table,'input[name="importes[]"]');
														$("#totalg").val(sum);
														$("#importe_folio").val(document.getElementById('totalg').value);

													 	//$("td").addClass("form-control ");
													 	/*
														$("#checkTodos").change(function () {
														      $("input:checkbox").prop('checked', $(this).prop("checked"));
														
														 														 });*/	
						 		

							 		break;
							 		case 'C':
						                Swal({
						                			type: 'warning',
						                			title:'Cupon cancelado',
						                			text: 'La factura de anticipo fue cancelada',
																	confirmButtonColor: "#fbbb1d"
																})								 		

							 		break;
							 		case 'R':
						                Swal({
						                			type: 'warning',
						                			title:'Cupon recuperado',
						                			html: 'El cupon ya fue recuperado el día '+ datos[0]["FECHARECUP"]+'<br>con el Folio Volumetrico: '+ datos[0]["FOLIOVOLUMETRICO"],
																	confirmButtonColor: "#fbbb1d"
																})									 		

							 		break;
							 		case 'P':
						                Swal({
						                			type: 'warning',
						                			title:'Cupon pendiente',
						                			text: 'Comuniquese con el administrador del sistema',
																	confirmButtonColor: "#fbbb1d"
																})										 		

							 		break;

							 		default:
						                Swal({
						                			type: 'warning',
						                			title:'Error desconocido',
						                			text: 'Comuniquese con el administrador del sistema',
																	confirmButtonColor: "#fbbb1d"
																})
									break;									 		
  							}

								//console.log("Datos recibidos = ", datos,typeof(datos) )
								//console.log("No: ", counter, "Factura: ",datos[0]["SERIEFAC"],datos[0]["FOLIOFAC"],"Folio: ",datos[0]["FOLIO"],"Importe: ",datos[0]["IMPORTE"],typeof(datos) )									

							}else{
						                Swal({
						                			type: 'warning',
						                			title:'Cupon no existe',
						                			text: 'El cupon no fue vendido por esta empresa',
																	confirmButtonColor: "#fbbb1d"
																})								
										}


							}
	});

}else if(folio_existe != undefined && par_estacion === combo_est){

		     		Swal({
		     		type: 'warning',
		     		title: 'Cupon ya existe en la lista',
		     		text: 'Verifique la lista de cupones capturados',
						confirmButtonColor: "#fbbb1d"
		    	 	})

     	}else if(cod_cupon==""){
			     	Swal({
			     		type: 'warning',
			     		title: 'Escriba el codigo del cupon',
			     		text: 'La casilla de captura del codigo del cupon no debe estar vacia',
							confirmButtonColor: "#fbbb1d"
			     	})
		     	}else
		     	{
			     	Swal({
			     		type: 'warning',
			     		title: 'Cupon no valido',
			     		text: 'Verique con el encargado, el cupon no es valido para la estacion seleccionada',
							confirmButtonColor: "#fbbb1d"
			     	})


		     	}
	
	$("#cod").val("");


 }       

function eliminar_all_registros(tabla){

	var table = $('#'+tabla).DataTable();

	if (table.data().count() ) {
					//var table = $('#'+tabla).DataTable();
					$("#"+tabla+" tr").find('td:eq(0) input[type=checkbox]').each(function () {

							table.row('.odd').remove().draw(false);
					})

				}

	
}     

function limpia(tabla){
  eliminar_all_registros(tabla);
  $("#seccioncupones").addClass('invisible');
  						              $("#importe_folio").val("");
														$("#precio_folio").val("");
														$("#producto").val("");
														$("#fecha_recuperacion").val("");
}
    
function valida_foliovol(tabla,div,opcion)
{
	var cod_cupon=document.getElementById('cod').value;
	//var lectorcod = document.getElementById('inputcod')
	var fecha_rec = $("#fecha_recuperacion").val();
	var par_estacion=document.getElementById('empresas').value;
	var counter=0, recorre=0;
	var table = $('#'+tabla).DataTable({    
																		  "bProcessing": true,
																	    "sAutoWidth": false,
																	    "bDestroy":true,
																	    "sPaginationType": "bootstrap", // full_numbers
																	    "iDisplayStart ": 10,
																	    "iDisplayLength": 10,
																	    "bPaginate": false, //hide pagination
																	    "bFilter": false, //hide Search bar
																	    "bInfo": false, // hide showing entries  
    																});
	var data = table.rows().data();
  var foliovol= document.getElementById('folio_volumetrico').value;	
  document.getElementById('boton_foliovol').focus();

  eliminar_all_registros(tabla);
  						              $("#importe_folio").val("");
														$("#precio_folio").val("");
														$("#producto").val("");
														$("#fecha_recuperacion").val("");

 if (foliovol!="")
 {

	  var parametros={
										"estacion":par_estacion,
									  "opcion":opcion,
									  "folio_volumetrico":foliovol
									 }
	  //console.log("Parametros enviado = ", parametros,typeof(parametros))
	  
	  $.ajax({		
	  						type: 'POST',
								url: '../webCupones/busqueda.php',
								data: parametros,
								dataType:"html",
								timeout: 20000, //15seg
	      
	      beforeSend: function(){
	                    //imagen de loading
	                    //lectorcod.disabled = true;
	                    $("#loading").css({"display":"inline"});
	                    $('#folio_volumetrico').prop('readonly', true);
	                    $('#boton_foliovol').prop('disabled', true);
	                    $('#boton_guardar').prop('disabled', true);
	                    $("#loading").html("<div  id='loader' class='preloader mx-auto font-weight-light' style='border-top:10px solid #fbbb1d;'></div>");
	                    },

			  error: function(request, status, err)
			  				{
			  					if (status == "timeout") 
			  						 {
	          				  //alert("Su petición demoro mas de lo permitido");
	          				  				Swal({
							                			type: 'error',
							                			title: 'Error de comunicacion con el servidor, timeout 20 Seg',
							                			text: 'Intenta de nuevo recargando la pagina, si el problema persiste llamar al administrador del sistema',
																		confirmButtonColor: "#fbbb1d"
																	})
	       						 } else {
	           		 					// another error occured  
							                Swal({
							                			type: 'error',
							                			title: 'Error de comunicacion con el servidor',
							                			text: 'Intenta de nuevo recargando la pagina, si el problema persiste llamar al administrador del sistema',
																		confirmButtonColor: "#fbbb1d"
																	})
	        									}
									$('#cod').prop('readonly', false);
									$("#loading").css({"display":"none"});	        				
									$('#folio_volumetrico').prop('readonly', false);
									$('#boton_foliovol').prop('disabled', false);
									$('#boton_guardar').prop('disabled', false);
									$("#importe_folio").val("");
									$("#precio_folio").val("");

	              },						
				success: function( respuesta ) 
									{		
									 //console.log("respuesta", respuesta);									
									//lectorcod.disabled = false;
									$('#cod').prop('readonly', false);
									$("#loading").css({"display":"none"});

									
									
									$("#importe_folio").val("");
									$("#precio_folio").val("");
									$('#folio_volumetrico').prop('readonly', false);
									$('#boton_foliovol').prop('disabled', false);
									$('#boton_guardar').prop('disabled', false);									
									//document.getElementById('cod').focus();

									//console.log("datos", respuesta);
									datos=JSON.parse(respuesta);
									console.log("Consulta datos", datos);
									//$("#"+tabla+" tbody>tr>td").remove();

									//table.row('.odd').remove().draw(false);
									
									/*FALTA VALIDAR QUE SE DESACTIVE */
									//$('#folio_volumetrico').prop('readonly', true);


									recorre=datos.length;
									if(recorre>0)
									{ bande=0;
										 if(recorre>1){
											
											 if (datos[1]["SERIEFAC"] !== null){bande=1;}
											//console.log(dats);
										 }
										if(datos[0]["FACTURADO"]=='No' && bande==0){
											
											$("#"+div).removeClass('invisible');

											dato_fecha=datos[0]["FECHA"].split(" ");

											//console.log(dato_fecha[0])
											$("#fecha_recuperacion").val(dato_fecha[0]);
											$("#producto").val(datos[0]["COMBUSTIBLE"]);
											$("#precio_folio").val(datos[0]["PRECIO"]);
											$("#importe_folio").val(datos[0]["IMPORTE"]);


										  for(i=1;i<recorre;i++){
										  			//dato_fecha=datos[i]["FECHAVENTA"].split(" ");
										  			dato_fecha=formatDate(new Date(datos[i]["FECHAVENTA"]),2);
														numero_rows = data.length-1;
														counter = 1 + counter;
													 	contador = i;							 		
													 	estilo='class="form-check" style="align-items:center;height:auto;background-color:white !important;"';
													 	estilo1='class="form-control border-0"  style="text-align:center;padding:0px;height:auto;background-color:white !important;"';
													 
													 	check = '<div class="d-flex justify-content-center"><input '+estilo+' type="checkbox" id="checkborrar'+contador+'"  class = "select-checkbox" onclick =activar_borrado_requisiciones("'+tabla+'","'+contador+'")></div>'
													 	No = '<input '+estilo1+' name="contador[]" readonly id=id"'+ contador + '" value="'+counter+'">'
													 	fechaventa='<input '+estilo1+' name="fechaventa[]" readonly placeholder="fechaventa" id="fechaventa'+ contador + '" value="'+dato_fecha+'">'
													 	factura='<input '+estilo1+' name="factura[]" readonly placeholder="Factura" id="factura'+ contador + '" value="'+"FA"+"-"+datos[i]["IDANTICIPO"]+'">'
													 	folio = '<input '+estilo1+' name="folio[]" readonly placeholder="Folio" onclick =modal_buscar_producto("'+tabla+'") id="folio'+contador+'" value="'+datos[i]["FOLIO"]+'">'
													 	importe = ' <input '+estilo1+' name="importes[]" readonly placeholder="Importe" oninput=calculo_real_req("'+contador+'","cantidad","precio") value="'+parseFloat(datos[i]["IMPORTE"]).toFixed(2)+'" id="importe'+contador+ '">'
													 	//importe = parseFloat(datos[i]["IMPORTE"]).toFixed(2);
													 	//folio = '<input '+estilo1+' name="folio[]" readonly placeholder="Folio" onclick =modal_buscar_producto("'+tabla+'") id="folio'+contador+'" value="'+datos[i]["ESTATUS"]+'">'
													 	table.row.add([check,No,fechaventa,factura,folio,importe]).draw( false );
													 	$("td").css({"padding":"0px","height":"auto","text-align":"center"});	



										   }

											}else if (datos[0]["FACTURADO"]=='Si' && datos[0]["TIPOPAGO"]!='0'){
						                Swal({
						                			type: 'warning',
						                			title:'Folio Volumetrico Facturado',
						                			html: 'El ticket ya fue facturado el día '+ datos[1]["FECHARECUP"]+'<br>Factura: '+ datos[1]["SERIEFAC"]+ '-' +datos[1]["FOLIOFAC"],
																	confirmButtonColor: "#fbbb1d"
																})
						                $("#importe_folio").val("");
														$("#precio_folio").val("");
														$("#"+div).addClass('invisible');
														//$("#folio_volumetrico").val("");
														//document.getElementById('folio_volumetrico').focus();				

											}else if(bande==1 ){
																  Swal({
						                			type: 'warning',
						                			title:'Folio Volumetrico Facturado',
						                			html: 'El ticket ya fue facturado el día '+ datos[1]["FECHARECUP"]+'<br>Factura: '+ datos[1]["SERIEFAC"]+ '-' +datos[1]["FOLIOFAC"],
																	confirmButtonColor: "#fbbb1d"
																})
																			 $("#"+div).addClass('invisible');
																	      $("#importe_folio").val("");
																				$("#precio_folio").val("");	

											}else if (datos[0]["FACTURADO"]=='Si' && datos[0]["TIPOPAGO"]=='0'){
						                Swal({
						                			type: 'warning',
						                			title:'Folio Volumetrico Facturado',
						                			html: 'El ticket ya fue facturado como de contado',
																	confirmButtonColor: "#fbbb1d"
																})
						                $("#importe_folio").val("");
														$("#precio_folio").val("");
														$("#"+div).addClass('invisible');


											}else{
						                $("#importe_folio").val("");
														$("#precio_folio").val("");
														$("#"+div).removeClass('invisible');
														//$("#fecha_recuperacion").val(formatDate(new Date(),2));												

											}
											//var total = document.getElementById('importe').value;
												
	
											//sum=getTblTotal(table,'input[name="importes[]"]');
											//$("#totalg").val(sum);
											//console.log( sum);
											/*
									    table.DataTable( {
									        "pageLength": 4,
									        "footerCallback": function ( row, data, start, end, display ) {
									        
									            total = this.api()
									                .column(4)//numero de columna a sumar
									                //.column(1, {page: 'current'})//para sumar solo la pagina actual
									                .data()
									                .reduce(function (a, b) {
									                    return parseInt(a) + parseInt(b);
									                }, 0 );

									            $(this.api().column(4).footer()).html(total);
									            
									        }
									    });*/
									}else{ 
												
												
												//console.log(xx)
												$("#"+div).removeClass('invisible'); 
												//$("#fecha_recuperacion").val(formatDate(new Date(),2));
											}

										  sum=getTblTotal(table,'input[name="importes[]"]');
											$("#totalg").val(sum);
								/*
								 if (datos.length>0)
								 {
						 	 		

									 		$("#"+div).removeClass('invisible');
											agregar_registro_datatable('tabla_requ_nuevas','valida_x_foliovol');
											
											

								 }*/
								 //console.log (datos.length);
													 
								}
				});



  }else{
	      Swal({
	  			type: 'warning',
	  			title:'Campo vacio',
	  			text: 'Es necesario el numero de folio para continuar',
					confirmButtonColor: "#fbbb1d"
				})
			 //document.getElementById('folio_volumetrico').focus();
			 $("#"+div).addClass('invisible');
	      $("#importe_folio").val("");
				$("#precio_folio").val("");			 	
	    }
	
	

}

function error(elemento){
	//document.getElementById("mensajeError").innerHTML = elemento.validationMessage;
	var formulario=document.getElementById('form1');
	formulario.className="was-validated";
	elemento.placeholder=elemento.validationMessage;
	//elemento.className ="form-control error";
	formulario.focus();
	elemento.focus();
}

function borrarerror(){
	var formulario=document.getElementById('form1');
		formulario.className="";
	/*	
	for(var i=0; i<formulario.elements.length;i++)
	{
		formulario.elements[i].removeClass="error";
	}*/

}

function valida_fol(e){
	if (!e.checkValidity()){ error(e);	return false;	} return true;
}

function valida_fecha(e){
	if (!e.checkValidity()){ error(e);	return false;	} return true;
}

function valida_producto(e){
	if (!e.checkValidity()){ error(e);	return false;	} return true;
}

function valida_precio(e){	
	if (!e.checkValidity()){ error(e);	return false;	} return true;

}

function valida_importe(e){	
	if (!e.checkValidity()){ error(e);	return false;	} return true;
}

function validar_campos(tabla) {
 var folios=Array();
 var table = $('#'+tabla).DataTable();
 var elemento_fol=document.getElementById('folio_volumetrico');
 var elemento_fecha=document.getElementById('fecha_recuperacion');
 var elemento_producto=document.getElementById('producto');
 var elemento_precio=document.getElementById('precio_folio');
 var elemento_importe=document.getElementById('importe_folio');

 var empresa= document.getElementById('empresas').value;
 var folio_volumetrico=elemento_fol.value;
 var fecha_recuperacion=elemento_fecha.value;
 var producto=elemento_producto.value;
 var precio_folio=parseFloat(elemento_precio.value).toFixed(2);
 var importe_folio=parseFloat(elemento_importe.value).toFixed(2);
 var fecha_venta_cupon=table.$('input[name="fechaventa[]"]').map(function(){ 
     		return this.value; }).get()
 var folio_cupon=table.$('input[name="folio[]"]').map(function(){ 
     		return this.value; }).get()
 var importe_cupon=table.$('input[name="importes[]"]').map(function(){ 
     		return this.value; }).get()
 var fecha_valida=true;
 var fechav,fechavc;
 var totalg=parseFloat(document.getElementById('totalg').value).toFixed(2);

	for(var i = 0, len = folio_cupon.length, ArrayCupones = []; i < len; i++){ ArrayCupones.push({
	FOLIO: folio_cupon[i], IMPORTE: importe_cupon[i], FECHAVENTA:fecha_venta_cupon[i]
	}); }

 	borrarerror();  // borra la validación de bordes verdes

	if (valida_fol(elemento_fol) && valida_fecha(elemento_fecha) && valida_producto(elemento_producto) && valida_precio(elemento_precio) && valida_importe(elemento_importe))
	{

		 var datos ={	
					 empresa:empresa,
					 folio_vol:folio_volumetrico,
					 fecha_rec:fecha_recuperacion,
					 producto:producto,
					 precio_foliovol:precio_folio,
					 importe_foliovol:importe_folio,
					 cupones:ArrayCupones
				};


			for (var i=0; i<datos.cupones.length;i++)
			{ 
				fechavc=datos.cupones[i]["FECHAVENTA"];
				if (fechavc>datos.fecha_rec){fecha_valida=false;}
				//console.log("fecha_valida", fecha_valida,fechavc,datos.fecha_rec);		
			}
			
			//PERMITE GUARDAR TICKETS
			/*
			if (datos.importe_foliovol != totalg){

      				Swal({
          			type: 'warning',
          			title: 'Recuperación de cupones invalida',
          			text: 'El importe del ticket es diferente al importe total de cupones',
								confirmButtonColor: "#fbbb1d"
							})				

				return ;
			}*/

				 	  
			if (datos && fecha_valida) {
					alertify.confirm('¿Desea guardar los datos?', 
						function(){
							confirma_guardardatos(datos); 
							eliminar_all_registros(tabla);
							$("#fecha_recuperacion").val(formatDate(new Date(),2));
							}, 
						function(){ return ; } );
				}else{ 
      				Swal({
          			type: 'warning',
          			title: 'Recuperación de cupones invalida',
          			text: 'La fecha de recepción debe ser inferior o igual a la fecha de venta del cupon',
								confirmButtonColor: "#fbbb1d"
							})
								return; 
						 }

	}

	
	//console.log("datos", datos["cupones"]);
	//var data = table.rows().data();
	//folios = table.$('input[name="folio[]"]').map(function(){ return this.value; }).get();


	return 
}


function confirma_guardardatos(obj_datos){
  //eliminar_all_registros(tabla);
	

	var parametros={
									"datos": obj_datos,
									"opcion": 'guardar'
								 }


	  $.ajax({		
	  						type: 'POST',
								url: '../webCupones/busqueda.php',
								data: parametros,
								dataType:"html",
								timeout: 20000, //15seg
	      
	      beforeSend: function(){

	                    console.log("Datos enviados:", obj_datos);
											$('#folio_volumetrico').prop('readonly', true);
											$('#boton_foliovol').prop('disabled', true);	                    
	                    $("#seccioncupones").addClass('invisible');
	                    $("#loading").css({"display":"inline"});

	                    $("#loading").html("<div  id='loader' class='preloader mx-auto font-weight-light' style='border-top:10px solid #fbbb1d;'></div>");
	                    },

			  error: function(request, status, err)
			  				{
			  					if (status == "timeout") 
			  						 {
	          				  //alert("Su petición demoro mas de lo permitido");
	          				  				Swal({
							                			type: 'error',
							                			title: 'Error de comunicacion con el servidor, timeout 20 Seg',
							                			text: 'Intenta de nuevo recargando la pagina, si el problema persiste llamar al administrador del sistema',
																		confirmButtonColor: "#fbbb1d"
																	})
	       						 } else {
	           		 					// another error occured  
							                Swal({
							                			type: 'error',
							                			title: 'Error de comunicacion con el servidor',
							                			text: 'Intenta de nuevo recargando la pagina, si el problema persiste llamar al administrador del sistema',
																		confirmButtonColor: "#fbbb1d"
																	})
	        									}

									//$('#cod').prop('readonly', false);
									$("#loading").css({"display":"none"});	        				
									$('#folio_volumetrico').prop('readonly', false);
									$('#boton_foliovol').prop('disabled', false);
									//$('#boton_guardar').prop('disabled', false);
									$("#importe_folio").val("");
									$("#precio_folio").val("");

	              },						
				success: function( respuesta ) 
									{		

									$("#loading").css({"display":"none"});
									$('#folio_volumetrico').prop('readonly', false);
									$('#boton_foliovol').prop('disabled', false);									


									//datos=JSON.parse(respuesta);
									datos=respuesta;
									if (datos.indexOf('exitoso') > -1){

															Swal({
							                			type: 'success',
							                			title: '¡Buen trabajo!',
							                			text: datos,
																		confirmButtonColor: "#fbbb1d"
																	})
										 
										 //console.log("Recibidos ", datos);
																 $("#importe_folio").val("");
																 $("#precio_folio").val("");
																 $("#folio_volumetrico").val("");
										 
										 

									}else{
												$("#seccioncupones").removeClass('invisible');

															Swal({
							                			type: 'error',
							                			title: 'Ocurrio un problema',
							                			text: datos,
																		confirmButtonColor: "#fbbb1d"
																	})
											}

								 } 
    });



	
}



function formatDate(dateObj,format)
{
    var monthNames = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
    var curr_date = dateObj.getDate();
    var curr_month = dateObj.getMonth();
    curr_month = curr_month + 1;
    var curr_year = dateObj.getFullYear();
    var curr_min = dateObj.getMinutes();
    var curr_hr= dateObj.getHours();
    var curr_sc= dateObj.getSeconds();
    if(curr_month.toString().length == 1)
    curr_month = '0' + curr_month;      
    if(curr_date.toString().length == 1)
    curr_date = '0' + curr_date;
    if(curr_hr.toString().length == 1)
    curr_hr = '0' + curr_hr;
    if(curr_min.toString().length == 1)
    curr_min = '0' + curr_min;

    if(format ==1)//dd-mm-yyyy
    {
        return curr_date + "-"+curr_month+ "-"+curr_year;       
    }
    else if(format ==2)//yyyy-mm-dd
    {
        return curr_year + "-"+curr_month+ "-"+curr_date;       
    }
    else if(format ==3)//dd/mm/yyyy
    {
        return curr_date + "/"+curr_month+ "/"+curr_year;       
    }
    else if(format ==4)// MM/dd/yyyy HH:mm:ss
    {
        return curr_month+"/"+curr_date +"/"+curr_year+ " "+curr_hr+":"+curr_min+":"+curr_sc;       
    }
}



function getTblTotal(table,columna) {
	var sum=0;
											arr = table.$(columna).map(function(){ 
								     		return this.value; }).get();
								     		if (arr!=""){
								     		var g = arr.map(i => +i || null);
									      const reducer = (accumulator, curr) => accumulator + curr;
									      sum=parseFloat(g.reduce(reducer)).toFixed(2);
									    }
    return sum;
}



function calculo_real_req(id,inputkeyup, getcantidad) {


    	var rowIndex 
	// datos = "hola"
	//table = $('#tabla_requ_nuevas').DataTable();

	cantidad = $("#"+getcantidad+""+id).val()
	if(cantidad == ""){
		cantidad = 0
	}
	importe =0

	$("#"+inputkeyup+""+id).keyup(function(){
		

		var value = $(this).val();

		cantidad_tecleada= isNaN(value) 
		preciopza = isNaN(cantidad)

		// console.log(value)

		if((cantidad_tecleada === false && value != "")   )
		{

			importe = parseFloat(value) * parseFloat(cantidad);
			// console.log(importe)

			importe_dos =trunck_dos(importe)
			$("#importes"+id).val(String(importe_dos))
			$("#importes"+id).attr("readonly","readonly");
			$("#importes"+id).css({"color" : "#495057"})
			$("#importes"+id).css({"background-color" : "#E9ECEF"})


		}else
		{

			$("#importes"+id).val(String(0))
			$("#importes"+id).css({"color" : "white"})
			$("#importes"+id).attr("readonly","readonly");
			$("#importes"+id).css({"background-color" : "#FC3645"})
			sumatotalgeneral = 0
			// $("#idtotal").val(String(sumatotalgeneral))
		}

	});
}

function function_name() {
	// body...
	var xhr;
	new autoComplete({
		selector: 'input[name="q"]',
		source: function(term, response){
			try { xhr.abort(); } catch(e){}
			xhr = $.ajax('/some/ajax/url/', { q: term }, function(data){ response(data); });
		}
	});

	$.ajax({
		type: 'POST',
		url: '../metproductos/opciones_productos.php',
		data: parametros,
		success: function(respuestas) {
			// console.log(respuestas)

		}
	});
}


function autocompletar(tabla,columna,fila) {
	// body...
	setTimeout(function (){
		$('#texto_producto').focus();
	}, 1000);
	
	$( function() {

		$( "#texto_producto" ).autocomplete({

			source: function( request, response ) {
				opcion  = "buscarProducto";
				$.ajax({
						// url: "http://gd.geobytes.com/AutoCompleteCity",
						type:'POST',
						url: "../webCupones/busqueda.php",
						dataType: "json",
						data: {
							"producto": request.term,
							"opcion":opcion
						},
						success: function( data ) {
							response( data );
							// console.log(data)
						}
					});
			},

			select: function( event, ui ) {
					// log( ui.item ?
					// 	"Selected: " + ui.item.label :
					// 	"Nothing selected, input was " + this.value);
					agregar_producto_elegido_tabla(ui.item ?
						ui.item.label : this.value,columna,fila,tabla);
				},
				open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				},
				close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				}
			});
	} );


}



function agregar_producto_elegido_tabla( message,columna, fila,tabla ) {
      // $( "<div>" ).text( message ).prependTo( "#log" );
      var table = $('#'+tabla).DataTable();
      
      columna_codProducto = parseInt(columna) - 1;

      partes = message.split("|")
     	// $('input[name="productos"]').val(partes[0]);
     	table.cell({row:fila, column:columna_codProducto}).data(partes[0]);
     	table.cell({row:fila, column:columna}).data(partes[1]);
     	$("#btn_buscador_producto").click();

     	$( "#texto_producto" ).scrollTop( 0 );
     	moverMouse(tabla)
     }


     function modal_buscar_producto(tabla) {
     	$("#texto_producto").val("")
     	$('td').click(function(){
     		var columna = $(this).parent().children().index($(this));
     		var fila = $(this).parent().parent().children().index($(this).parent());
  // alert('Row: ' + fila + ', Column: ' + columna);
  
  if(columna == 3 ){
  	$("#btn_buscador_producto").click();
  	autocompletar(tabla,columna,fila);	
  }

});

     }


     function guardardatos_cup(tabla) {
     	var table = $('#'+tabla).DataTable();

     	indices = table.column(1).data()
     	codigos = table.column(2).data()
     	descripciones = table.column(3).data()

     	var data = table.rows().data();
     	cantidad_tabla =  data.length 

     	array_indices = []
     	array_codigos = []
     	array_descripciones =[]
     	enviar_pro  = false;
     	enviar_can = false;
     	enviar_da = false;
     	vacios_colum=0


     	for (i =0; i<cantidad_tabla; i++) {



     		array_indices.push(indices[i])
     		array_codigos.push(codigos[i])



     		cortado =descripciones[i].substr(1,6)
     		if ('<input' !== cortado) {
     			array_descripciones.push(descripciones[i])

     		}



     	}


     	console.log(array_descripciones)

     	if ( array_descripciones.length == cantidad_tabla && cantidad_tabla > 0) 
     	{
     		enviar_pro = true
     	}else{
     		enviar_pro = false
     	}

     	cantidades = table.$('input[name="cantidad[]"]').map(function(){ 
     		return this.value; }).get();


     	precios_estimados =table.$('input[name="precio_estimado[]"]').map(function(){ 
     		return this.value; }).get();
     	importes_totales =table.$('input[name="importe_total[]"]').map(function(){ 
     		return this.value; }).get();

     	vacios_ca = validar_vacios(cantidades)
     	vacios_pre_est = validar_vacios(precios_estimados)
     	vacios_importes = validar_vacios(importes_totales)

     	if (vacios_ca !== true  && vacios_pre_est != true && vacios_importes !== true ) {
     		enviar_can = true
     	}else{
     		enviar_can = false
     	}
     	empresa  = $("#empresas").val();
     	urgencia  = $("#urgencia").val()
     	afectacion  = $("#afectacion").val();
     	almacen  = $("#almacen").val();
     	if (almacen == "") {
     		almacen  = "sin_almacen"
     	}
     	departamento  = $("#departamento").val();
     	moneda = $("#moneda").val();
     	concepto = $("#concepto").val();
     	proveedor = "";
     	tipo = "";

     	val_proveedor = true;
     	val_imagen = true;
     	error_imagen = false;
     	mensaje_img = "";

     	if (tabla == "tabla_nueva_ordenes_compra") {

     		proveedor = $("#elegido_proveedores").val();
     		imagen_v = $("#archivo").val()
     		// console.log(imagen_v)
     		// var propiedad  = document.getElementById("archivo").files[0]
     		// var imagen_name = propiedad.name
     		
     		tipo = "orden_pago"

     		if (proveedor != "") {
     			val_proveedor = true;
     		}else{
     			val_proveedor = false;
     		}

     		if (imagen_v   != "") {
     			val_imagen = true;
     			validar_imagen = validar_ext_docum(tabla)
     			// console.log(validar_imagen)
     			mensaje_img  = validar_imagen["mensaje"]
     			error  = validar_imagen["error"]
     			if (error  === true ) {
     				error_imagen = true
     				
     			}
     		}else{
     			val_imagen = false;
     		}





     	}else{
     		tipo = "requisicion"
     	}


     	parametros ={
     		"indices":array_indices,
     		"codigos":array_codigos,
     		"descripciones":array_descripciones,
     		"cantidades":cantidades,
     		"precios_estimados":precios_estimados,
     		"importes_totales": importes_totales,
     		"empresa":empresa,
     		"urgencia":urgencia,
     		"afectacion":afectacion,
     		"almacen":almacen,
     		"departamento":departamento,
     		"moneda":moneda,
     		"concepto":concepto,
     		"opcion":"1",
     		"tipo":tipo,
     		"proveedor":proveedor
     	}
     	// console.log(parametros)
     	vacios_param = 0;
     	if (empresa != "" && urgencia != "" && afectacion != "" && departamento != ""
     		&& moneda != "" && concepto != "") {
     		enviar_da = true
     }else{
     	enviar_da = false
     }
     

     if (error_imagen === false ) {

//enviar_pro  === true && 
     	if( enviar_pro  === true && enviar_can  === true && enviar_da === true && val_proveedor === true && val_imagen === true)
     	{
     	// cargando ()


     	Swal({
     		title: 'Procesando, espere por favor...',
     		onOpen: function () {
     			Swal.showLoading()
     			$.ajax({
						// url: "http://gd.geobytes.com/AutoCompleteCity",
						type: 'POST',
						url: '../webCupones/nuevas_solicitudes.php',
						data: parametros,
						success: function( datos ) {
							respuesta =JSON.parse(datos);
							
							if (respuesta["resultado"] == "guardado") {

								sucursal = respuesta["sucursal"]
								serie = respuesta["serie"]
								folio =respuesta["folio"]
								afectacion =respuesta["afectacion"]
								cantidad = respuesta["cantidad"]

								actualizar(sucursal,serie,folio,afectacion,cantidad,tabla)
							}else{
								Swal({
									type: 'error',
									title: 'Error',
									text: ''+respuesta["mensaje"],
									footer: '<a href ="#"></a>'
								})

							}
						}


					});
     			setTimeout(function () {
     				
     			}, 4000)
     		}
     	})


     }else{
     	Swal({
     		type: 'error',
     		title: 'Campos vacios',
     		text: 'No puede tener datos vacíos',
     		footer: '<a href ="#"></a>'
     	})
     }

 }else{
 	Swal({
 		type: 'error',
 		title: 'Error en documento',
 		html: ''+mensaje_img,
 		footer: '<a href ="#"></a>'
 	})
 }


}

function moverMouse(tabla) {
	$( "#"+tabla ).mousemove(function( event ) {


	});
}

function validar_vacios(arreglo) {
	vacios  = 0;
	for (i =0; i<arreglo.length; i++) {
		if (arreglo[i] == "") {
			vacios++
		}
	}
	if (vacios > 0) {
		return true;
	}else{
		return false
	}
}

function actualizar(sucursal,serie,folio,afectacion,cantidad,tabla) {
	parametros = {
		"serie":serie,
		"folio":folio,
		"sucursal":sucursal,
		"opcion":"2",
		"afectacion":afectacion,
		"cantidad":cantidad
	}
	respuesta  = ""
	$.ajax({


		type: 'POST',
		url: '../webCupones/nuevas_solicitudes.php',
		data: parametros,
		success: function( data ) {
			
			res = JSON.parse(data)
			titulo ="";
			if (res["resultado"] == "actualizado") {

				if (tabla  === "tabla_nueva_ordenes_compra") {
					carpeta  = sucursal+"-"+serie+"-"+folio
					guardar_documento(tabla,carpeta)
					titulo = "Orden de pago"
				}else{
					titulo = "Requisicion"
				}
				datos_requisicion = "<p style =' font-weight: bold;'>"+serie+"-"+folio+"</p>"
				Swal({
					type: 'success',
					title: 'Exitoso',
					html: '<p style ="font-weight: bold;">'+titulo+' guardada</p>'+datos_requisicion,
					allowOutsideClick: false,
					footer: '<a id="enlace"  target="_blank"></a>'
				}).then((result) => {
					codigo  = sucursal+"-"+serie+"-"+folio

				})
				
			}else{

				Swal({
					type: 'error',
					title: 'Error',
					text: 'Error al  guardar la requisicion',
					footer: '<a href ="#"></a>'
				})

			}
		}

	});
	return respuesta 
}




function buscar_proveedor(tabla) {

	$("#btn_modal_proveedores").click()
	$( function() {
		texto  = $("#proveedores").val()
		if (texto == "") {
			$("#contenedor_generel_proveedores").css({"display" : "none"})
		}
		texto_formulario = $("#elegido_proveedores").val()
		
		if (texto_formulario != "") {
			$("#contenedor_generel_proveedores").css({"display" : "inline"})
		}
		$( "#proveedores" ).autocomplete({

			source: function( request, response ) {

				opcion  = "buscarProveedor";
				$.ajax({
						// url: "http://gd.geobytes.com/AutoCompleteCity",
						type:'POST',
						url: "../webCupones/busqueda.php",
						dataType: "json",
						data: {
							"proveedor": request.term,
							"opcion":opcion
						},
						success: function( data ) {
							response( data );
							// console.log(data)
						}
					});
			},

			select: function( event, ui ) {
					// log( ui.item ?
					// 	"Selected: " + ui.item.label :
					// 	"Nothing selected, input was " + this.value);
					datos_proveedor(ui.item ?
						ui.item.label : this.value,tabla);
				},
				open: function() {
					$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				},
				close: function() {
					$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				}
			});
	} );



}

function datos_proveedor(proveedor) {

	datos  = proveedor.split("|")
	id_prov = datos[0]
	nombre = datos[1]
	parametros = {
		"id_proveedor" : id_prov,
		"opcion":"busqueda_detallada_proveedor"
	}
	$.ajax({
						// url: "http://gd.geobytes.com/AutoCompleteCity",
						type: 'POST',
						url: '../webCupones/busqueda.php',
						data: parametros,
						success: function( datos ) {
							// console.log(datos)
							// $("#id").val("")
							// $("#rfc").val("")
							// $("#tipo_persona").val("")
							// $("#direccion").val("")
							// $("#poblacion").val("")
							// $("#pais").val("")
							// $("#cp").val("")
							// $("#telefono").val("")
							// $("#email").val("")
							// $("#contacto").val("")
							// $("#moneda").val("")


							respuesta =JSON.parse(datos);
							$("#contenedor_generel_proveedores").css({"display" : "inline"})
							$("#id").val(respuesta["id"])
							$("#rfc").val(respuesta["rfc"])
							$("#tipo_persona").val(respuesta["tipo_persona"])
							$("#direccion").val(respuesta["direccion"])
							$("#poblacion").val(respuesta["poblacion"])
							$("#pais").val(respuesta["pais"])
							$("#cp").val(respuesta["cp"])
							$("#telefono").val(respuesta["telefono"])
							$("#email").val(respuesta["email"])
							$("#contacto").val(respuesta["contacto"])
							$("#moneda_pro").val(respuesta["moneda"])





						}


					});
}

function elegir_proveedor() {
	$("#contenedor_generel_proveedores").css({"display" : "none"})
	proveedor  =$("#proveedores").val()
 	// d = datos.split("|")
 	$("#elegido_proveedores").val(proveedor)
 }





 function guardar_documento(tabla,carpeta) {
 	
 	var propiedad  = document.getElementById("archivo").files[0]
 	var imagen_name = propiedad.name
 	var imagen_extension = imagen_name.split('.').pop().toLowerCase();
 	// console.log(jQuery.inArray(imagen_extension, ["pdf"]))
 	// if (jQuery.inArray(imagen_extension, ["pdf"]) == -1 ) {
 	// 	alert("Solo pueden ser formato PDF")
 	// }

 	var form_data = new FormData();
 	form_data.append("archivo" , propiedad)
 	form_data.append("carpeta",carpeta)
 	$.ajax({
 		url : "../webCupones/guardar_archivos.php",
 		method:"POST",
 		data:form_data,
 		contentType:false,
 		cache:false,
 		processData:false,
 		success:function(data){
 			// console.log(data)
 		}
 	})



 }


 function validar_ext_docum(tabla) {
 	var propiedad  = document.getElementById("archivo").files[0]
 	var imagen_name = propiedad.name
 	var imagen_extension = imagen_name.split('.').pop().toLowerCase();
 	var tamanio  = propiedad.size
 	// console.log(jQuery.inArray(imagen_extension, ["pdf"]))
 	mensaje = ""
 	error = true;
 	error_ext = true
 	error_size = true
 	
 	if (jQuery.inArray(imagen_extension, ["pdf","png","jpg", "jpeg","gif"]) === -1 ) {
 		mensaje = "Solo se aceptan los archivos <span style = '  font-weight: bold;'>  .pdf  .png  .jpg  .jpeg  .gif </span>"
 		error_ext = true;
 	}else{
 		error_ext = false
 	}
 	// console.log(tamanio)
 	if (tamanio > 5000000) {
 		mensaje = "Los archivos no pueden ser mayores a <span style = '  font-weight: bold;'> 5MB</span>"
 		error_size = true;
 	}else{
 		error_size = false
 	}
 	if (error_size === false  && error_ext === false) {
 		error = false
 	}else{
 		error = true
 	}
 	var respuesta  = new Array();
 	respuesta["mensaje"] = mensaje
 	respuesta["error"] = error

 	return respuesta
 }



 function crear_pdf(codigo) {
 	window.open("../webCupones/doc_requisicion.php?codigo="+codigo+"", "_blank");

 }


