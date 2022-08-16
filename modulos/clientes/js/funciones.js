 
$(document).ready(function(){

// $('.custom-file input').change(function() {
//     var $el = $(this),
//     files = $el[0].files,
//     label = files[0].name;
//     if (files.length > 1) {
//         label = label + " and " + String(files.length - 1) + " more files"
//     }
//     $el.next('.custom-file-label').html(label);
// });


// documentos()
// 
// ejemplo()

});





function custom_selected() {

	clases_selected = ["class_combustible","class_solicitud_km","class_periodo","class_dias_carga","class_period_horas"]
	for (var i = 0; i < clases_selected.length; i++) {
		// console.log(clases_selected[i])
		// $('.'+clases_selected[i]).multiSelect({


		// 	'containerHTML': '<div class="multi-select-container">',
		// 	'menuHTML': '<div class="multi-select-menu">',
		// 	'buttonHTML': '<span class="multi-select-button">',
		// 	'menuItemsHTML': '<div class="multi-select-menuitems">',
		// 	'menuItemHTML': '<label class="multi-select-menuitem">',
		// 	'presetsHTML': '<div class="multi-select-presets">',
		// 	'modalHTML': undefined,
		// 	'activeClass': 'multi-select-container--open',
		// 	'noneText': '-- Select --',
		// 	'allText': undefined,
		// 	'presets': undefined,
		// 	'positionedMenuClass': 'multi-select-container--positioned',
		// 	'positionMenuWithin': undefined,
		// 	'viewportBottomGutter': 20,
		// 	'menuMinHeight': 200

		// });


				$('.'+clases_selected[i]).select2()
	
	}

}
// $(function(){




// 	$('#hora_inicio').multiSelect({

//   // Custom templates
//   'containerHTML': '<div class="multi-select-container">',
//   'menuHTML': '<div class="multi-select-menu">',
//   'buttonHTML': '<span class="multi-select-button">',
//   'menuItemsHTML': '<div class="multi-select-menuitems">',
//   'menuItemHTML': '<label class="multi-select-menuitem">',
//   'presetsHTML': '<div class="multi-select-presets">',

//   // sets some HTML (eg: <div class="multi-select-modal">) to enable the modal overlay.
//   'modalHTML': undefined,

//   // Active CSS class
//   'activeClass': 'multi-select-container--open',

//   // Text to show when no option is selected
//   'noneText': '-- Select --',

//   // Text to show when all options are selected
//   'allText': undefined,

//   // an array of preset option groups
//   'presets': undefined,

//   // CSS class added to the container, when the menu is about to extend beyond the right edge of the position<a href="https://www.jqueryscript.net/menu/">Menu</a>Within element
//   'positionedMenuClass': 'multi-select-container--positioned',

//   // If you provide a jQuery object here, the plugin will add a class (see positionedMenuClass option) to the container when the right edge of the dropdown menu is about to extend outside the specified element, giving you the opportunity to use CSS to prevent the menu extending, for example, by allowing the option labels to wrap onto multiple lines.
//   'positionMenuWithin': undefined,

//   // The plugin will attempt to keep this distance, in pixels, clear between the bottom of the menu and the bottom of the viewport, by setting a fixed height style if the menu would otherwise approach this distance from the bottom edge of the viewport.
//   'viewportBottomGutter': 20,

//   // minimal height
//   'menuMinHeight': 200

// });



function buscador_clientes() {
	rfc  = $("#buscar_rfc").val();
	// alert(rfc)
	parametro={
		"rfc":rfc,
		"opcion":"buscar_rfc"
	}


	$.ajax({
		type: 'POST',
		url: '../solicitudes/receptor.php',
		data: parametro,
		success: function(respuestas) {
			// console.log(respuestas.hasOwnProperty("error"))
			// console.log(respuestas)
			// $(".btn-next").click()
			$("#resultado_busqueda_rfc").empty()
			_html = ""
			resultados = JSON.parse(respuestas)
			if (resultados.length  > 0){
				// _html +=""
				// $("#seleccionar_cliente").hide()
				$("#seleccionar_cliente").show()
				for(i=0; i<resultados.length; i++){
					_html+= "<tr>"
					_html += "<th scope='row'>"+resultados[i]["id"]+"</th>"
					_html += "<td>"+resultados[i]["nombre"]+"</td>"
					_html += "<td> "+resultados[i]["rfc"]+"</td>"
					// _html += "<td>"+resultados[i]["tarjetas"]+"</td>"
					_html += "<td>"+resultados[i]["tipo"]+"</td>"
					_html += "<td><button type='button' class='btn btn-secondary' onclick='detallado_cliente("+resultados[i]["id"]+")'>Seleccionar</button></td>"
					_html+= "<hr>"
				}
			}else{
				$("#seleccionar_cliente").hide()
				$(".thead-dark").hide()
				_html = "<div style='margin-top:80px;'>"
				_html+= "<h2> No se encontraron resultados :( </h2>"
				_html+= "</div>"
			}
			
			
			$("#resultado_busqueda_rfc").html(""+_html)
		}
	});



	// $("#tabla_clientes").DataTable({
	// 	destroy: true,
	// 	responsive: true,
	// 	orderCellsTop: true,

	// 	"language": {
	// 		"emptyTable": "No se encontraron registros "
	// 	},
	// 	"ajax":{
	// 		"data":parametro,
	// 		"method":"POST",
	// 		"url": "../solicitudes/receptor.php",

	// 	},
	// 	"columns":[

	// 	{"data":"id"},
	// 	{"data":"nombre"},
	// 	{"data":"rfc"},
	// 	{"data":"tarjetas"},
	// 	{"data":"id"}

	// 	],

	// 	"columnDefs": [ 
	// 	{

	// 		"render": function ( data, type, row ) {

	// 			return "<a href='solicitud?id="+data+"' target='_blank'>Solicitud</a>";
	// 		},
	// 		"targets": 4
	// 	}
	// 	],



	// 	"initComplete": function() {
	// 		table = $('#tabla_clientes').DataTable();
	// 		if ( ! table.data().any() ) {
	// 			mensaje()
	// 		}
	// 		// buscadores_x_columna("tabla_clientes")



	// 	}

	// });

}

function mensaje (argument) {
	if(!alertify.errorAlert){
  //define a new errorAlert base on alert
  alertify.dialog('errorAlert',function factory(){
  	return{
  		build:function(){
  			var errorHeader = '<span class="fas fa-user fa-2x" '
  			+    'style="vertical-align:middle;color:#e10000;">'
  			+ '</span> Sin resultados';
  			this.setHeader(errorHeader);
  		}
  	};
  },true,'alert');
}
//launch it.
// since this was transient, we can launch another instance at the same time.
alertify
.errorAlert("No existen resultados con el rfc proporcionado<br/><br/><br/>" +
	"Si desea crear al cliente " + 
	"<a href='nuevosClientes?rfc="+rfc+"' target='_blank'> presione aqui</a>");
}




function documentos(argument) {

}

function detallado_cliente(id_cliente) {
	alert(id_cliente)

	parametro={
		"rfc":rfc,
		"opcion":"buscar_id"
	}
	$.ajax({
		type: 'POST',
		url: '../solicitudes/receptor.php',
		data: parametro,
		success: function(respuestas) {}
	});
}


function put_width() {
	 // alert("puse clases")
	 $("#contendor_contenido_general").removeClass("col-sm-8");
	 $("#contendor_contenido_general").removeClass("col-sm-offset-2");
	 $("#contendor_contenido_general").addClass("col-sm-12");

	}
	function return_width(argument) {
		// alert("quite clases")
		$("#contendor_contenido_general").removeClass("col-sm-12");
		$("#contendor_contenido_general").addClass("col-sm-8");
		$("#contendor_contenido_general").addClass("col-sm-offset-2");

	}



	function formulario_tarjetas() {

		

		div_inicio  = "<div class='form-group col-sm-12'  style='display: flex; justify-content: space-between;margin-top:-15px;' >";
		div_final = "</div>"

		div_placas  = "<div class='col-sm-3'>"
		+"<div class='input-group '>"
		+"<div class='form-group label-floating'>"
		+"<label class='control-label'>Placas</label>"
		+"<input name='name' type='text' class='form-control'>"
		+"</div>"
		+"</div>"
		+"</div>";
		div_marca_auto = "<div  class='col-sm-3'>"
		+"<div class='input-group '>"
		+"<div class='form-group label-floating'>"
		+"<label class='control-label'>Marca auto</label>"
		+"<input name='name' type='text' class='form-control'>"
		+"	</div>"
		+"</div>"
		+"</div>";

		div_chofer = "<div  class='col-sm-3'>"
		+"<div class='input-group '>"
		+"<div class='form-group label-floating'>"
		+"<label class='control-label'>Chofer</label>"
		+"<input name='name' type='text' class='form-control'>"
		+"	</div>"
		+"</div>"
		+"</div>";

		div_combustibles = "<div class=' col-sm-2'>	"
		+"<div class='form-group label-floating' style='display: flex;'>"	
		+"<label class='control-label'>Combustibles</label>"
		+"<select id='' name='solicitud_combustibles[]' multiple class='class_combustible'>"
		+"<option class='opt_combustible' value='magna'>M</option>"
		+"<option class='opt_combustible' value='premium'>P</option>"
		+"<option class='opt_combustible' value='diesel'>D</option>"
		+"</select>"
		+"</div>"
		+"</div>";

		div_solicitud_km = "<div class=' col-sm-2'>"
		+"<div class='form-group label-floating' style='display: flex;'>"
		+"<label class='control-label'>Solicitud de km</label>"
		+"<select id='' name='solicitud_km[]' multiple class='class_solicitud_km'>"
		+"<option class='opt_soli_km' value='Si'>Si</option>"
		+"<option class='opt_soli_km' value='No'>No</option>"
		+"</select>"
		+"</div>"
		+"</div>";

		div_periodo_carga="<div class='input-group col-sm-2'>"
		+"<div class='form-group label-floating' style='display: flex;'>"
		+"<label class='control-label'>Periodo de carga</label>"
		+"<select id='' name='periodo[]' multiple class='class_periodo' >"
		+"<option class='opt_periodo_carga' value='semanal'>Semanal</option>"
		+"<option class='opt_periodo_carga' value='mensual'>Mensual</option>"
		+"</select>"
		+"</div></div>"

		div_dias_carga = "<div class='input-group col-sm-2'>"
		+"<div class='form-group label-floating' style='display: flex;'>"
		+"<label class='control-label'>Dias de carga</label>"
		+"<select id='' name='dias_carga[]' multiple class='class_dias_carga'>"
		+"<option class='opt_dias_carga' value='domingo'>D</option>"
		+"<option class='opt_dias_carga' value='lunes'>L</option>"
		+"<option class='opt_dias_carga' value='martes'>Ma</option>"
		+"<option class='opt_dias_carga' value='miercoles'>Mi</option>"
		+"<option class='opt_dias_carga' value='jueves'>J</option>"
		+"<option class='opt_dias_carga' value='viernes'>V</option>"
		+"<option class='opt_dias_carga' value='sabado'>S</option>"
		+"</select>"
		+"</div>"
		+"	</div>"

		div_horas_carga = "<div  class='col-sm-2'>"
		+"<div class='input-group'>"
		+"<div class='form-group label-floating'>"
		+"<label class='control-label'>Horas de carga</label>"
		+"<div style='display: flex;'>"
		+"<select id='' name='periodo_hora[]' multiple class='class_period_horas'>"
		+"<option class='opt_horas_carga' value='domingo'>01:00</option>"
		+"<option class='opt_horas_carga' value='lunes'>02:00</option>"
		+"<option class='opt_horas_carga' value='martes'>03:00</option>"
		+"<option class='opt_horas_carga' value='miercoles'>04:00</option>"
		+"<option class='opt_horas_carga' value='jueves'>05:00</option>"
		+"<option class='opt_horas_carga' value='viernes'>06:00</option>"
		+"<option class='opt_horas_carga' value='sabado'>08:00</option>"
		+"<option class='opt_horas_carga' value='sabado'>09:00</option>"
		+"<option class='opt_horas_carga' value='sabado'>10:00</option>"
		+"<option class='opt_horas_carga' value='sabado'>11:00</option>"
		+"<option class='opt_horas_carga' value='sabado'>12:00</option>"
		+"</select>"
		+"</div>"
		+"</div>"
		+"</div>"
		+"</div>"


		div_monto_maximo = "<div  class='col-sm-3'>"
		+"<div class='input-group'>"
		+"<div class='form-group label-floating'>"
		+"<label class='control-label'>Monto maximo</label>"
		+"<input name='name' type='text' class='form-control'>"
		+"</div>"
		+"</div>"
		+"</div>"
		
		numero_tarjetas = $("#numero_tarjetas").val()		
		numero_tarjetas = parseInt(numero_tarjetas)							
		formulario = ""
		for (var i = 0; i <numero_tarjetas; i++) {
			if (i == 0) {
				i = i+1
			}
			formulario += div_inicio+"<h3>"+i+"</h3>"+div_placas+""+div_marca_auto+""+div_chofer+""+div_combustibles+""+div_solicitud_km
			+""+div_periodo_carga+""+div_dias_carga+""+div_horas_carga+""+div_monto_maximo+""+div_final;
			// console.log(formulario)
		}	

		$("#formulario_tarjetas_n").empty()

		$("#formulario_tarjetas_n").html(formulario);
		custom_selected()

		
	}