

	function tomardatos_tabla(tabla) {
		var table = $('#'+tabla).DataTable();
 
		var data = table
			.rows()
			.data();
		 
		alert( 'The table has '+data.length+' records' );
	}

	// buscadores_x_columna()

	function modal_opciones_crear_documento($datos ="") {
		$("#btn_modal_crear_doc").click()
		// alert(idusuario)
		parametros = {
			"opcion":"permisos_crear_documentos",

		}
		$.ajax({
			type: 'POST',
			url:'../webCompras/busqueda.php',
			data:parametros,
			success:function (respuesta) {
				option =""
				datos  = JSON.parse(respuesta)
				if (datos["estado"] == "success") {
					
					permisos = datos["permisos"]
					for(i=0; i<permisos.length; i++)
					{
						permiso = datos["permisos"][i]["PERMISO"]
						nombre =datos["permisos"][i]["NOMBRE_PERMISO"]
						// nombre = nombre.substring(5,nombre.length)
						// nombre = MaysPrimera(nombre)
						option +="<div class='form-check'>"
						+"<input class='form-check-input' type='radio' name='elegir_permiso' id='"+permiso+"' value='"+permiso+"' >"
						+"<label class='form-check-label' for='"+permiso+"'>"
						+ "  "+nombre+" "	
						+"</label>"
						+"</div>"
					}
					$("#opciones_documentos").html(option)
				}else{
					option = "<h5 style='text-align:center'>No tienes permisos para hacer solicitudes</h5>"
					$("#opciones_documentos").html(option)
				}
			}
		})



	}

	


	function pagina_principal_compras() {
		// body...
		window.location="index.php";
	}

	function siguiente_crear_documento() {
		opcion_crear = $("input:radio[name=elegir_permiso]:checked").val()
		console.log(opcion_crear)
		if (opcion_crear != undefined) {
			if (opcion_crear == "ADDORDENCOM") {
				window.location="nueva_ordencompra.php"
			}
			if (opcion_crear == "ADDREQUISICION") {
				window.location ="nueva_requisicion.php"
			}
		}else{
			$("#error_opcion").empty();
			$("#error_opcion").css({"display":"inline"})
			$("#error_opcion").html("<p style ='color:red' >Seleccionar el tipo de solicitud que desea crear</p>")
			setTimeout(function () {
				$("#error_opcion").css({"display": "none"})
			}, 2000)
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


			$("#"+tabla+" tr").find('td:eq(4) input[type=text]').each(function () {
			// nuevo  = campo+""+i
			
			$(this).removeAttr("id")
			$(this).attr("id","cantidad"+i)
			// $(this).attr("id",nuevo);
			i++
			
		})
			i = 1
			$("#"+tabla+" tr").find('td:eq(5) input[type=text]').each(function () {
			// nuevo  = campo+""+i
			
			$(this).removeAttr("id")
			$(this).attr("id","precio"+i)
			// $(this).attr("id",nuevo);
			i++
			
		})
			i = 1
			$("#"+tabla+" tr").find('td:eq(6) input[type=text]').each(function () {
			// nuevo  = campo+""+i
			
			$(this).removeAttr("id")
			$(this).attr("id","importes"+i)
			// $(this).attr("id",nuevo);
			i++
			
		})
		   // $("#"+campo+""+i).removeAttr("id");
   		// 	$("#"+campo+""+i).attr("id",campo+""+i);
   	}
   	function regenerar_index(tabla) {

   		var table = $('#'+tabla).DataTable();
   		rows1 =table.rows().data().length
   		
   		for(i=0; i<rows1; i++)
   		{

   			index = i + 1 

   			table.cell(i, 1).data(index).draw()
   		}
   		contador = 0



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
			return false
			

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

function agregar_registro(tabla) {
	// $('#tabla_requ_nuevas').DataTable( {
	// 	"ajax": '../jsCompras/arrays.txt'
	// } );
	
	var table = $('#'+tabla).DataTable()


	var counter = 1;
	var data = table.rows().data();
	numero_rows = data.length
	

 	// (table.row().count())
 	contador = data.length + 1
 	contador =  Math.floor(Math.random()*54545454)
 	
 	check = '<input type="checkbox" id="checkborrar'+contador+'"  class = "select-checkbox" onclick =activar_borrado_requisiciones("'+tabla+'","'+contador+'") >'
 	codigo='<input type="text" class="form-control" name="productos[]" placeholder="producto" >'

 	producto = ' <input type="text" class="form-control" name="productos[]" placeholder="producto" onclick =modal_buscar_producto("'+tabla+'") id="producto'+contador+'">'

 	cantidad='<input type="text" class="form-control" name="cantidad[]" placeholder="cantidad" id="cantidad'+contador+'" oninput=calculo_real_req("'+contador+'","cantidad","precio") ></div>';

 	precio_estimado='<input type="text" class="form-control" name="precio_estimado[]" placeholder="precío" id="precio'+contador+'"   oninput=calculo_real_req("'+contador+'","precio","cantidad") ></div>';

 	importe_total='<input type="text" class="form-control" name="importe_total[]" placeholder="Importe total" id="importes'+contador+'"></div>';


 	contador = data.length + 1
 	table.row.add( [
 		check,
 		contador,
 		codigo,
 		producto,
 		cantidad,
 		precio_estimado,
 		importe_total
 		] ).draw( false );

        // counter++;


        // activar_borrado_requisiciones(tabla)
        // moverMouse(tabla)
        
    }

    function calculo_real_req(id,inputkeyup, getcantidad) {


    	var rowIndex 
	// datos = "hola"
	table = $('#tabla_requ_nuevas').DataTable();

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
						url: "../webCompras/busqueda.php",
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


     function guardardatos(tabla) {
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
     		title: 'Procesando espere por favor...',
     		onOpen: function () {
     			Swal.showLoading()
     			$.ajax({
						// url: "http://gd.geobytes.com/AutoCompleteCity",
						type: 'POST',
						url: '../webCompras/nuevas_solicitudes.php',
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
		url: '../webCompras/nuevas_solicitudes.php',
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
						url: "../webCompras/busqueda.php",
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
						url: '../webCompras/busqueda.php',
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
 		url : "../webCompras/guardar_archivos.php",
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
 	window.open("../webCompras/doc_requisicion.php?codigo="+codigo+"", "_blank");

 }
