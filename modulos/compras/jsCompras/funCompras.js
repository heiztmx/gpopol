$(document).ready(function () {
	$("#descripcionesxproducto").hide();
	$("#tabla tfoot th").hide()
	// buscadores_x_columna()


});
$(document).on('click', '#explicacion_swal', function () {

})
$(document).on('click', '.btn_swal', function () {

	id = $(this).attr("id")
	switch (id) {
		case 'btn_cancelar_swal':
		Swal.close()
		break;

		case 'btn_guardar_swal':
		validar_cotizacion()
		break;

		case 'btn_coti_provee_swal':
		cotizar_x_proveedor()
		break;

		default:
		alert("problemas en las opciones")
	}
});





function toggle_descripciones() {

	$("#descripcionesxproducto").toggle();

}


function cotizar_x_proveedor() {
	requisicion  = $("#requisicion_cot").val()
	da = requisicion.split("-")
	sucursal  =  da[1];
	serie =  da[2];
	folio = da[3];

	// window.open("cotizar_proveedor.php?sucursal="+sucursal+"&serie="+serie+"&folio="+folio+"", "_blank");
	location.href="cotizar_proveedor.php?sucursal="+sucursal+"&serie="+serie+"&folio="+folio;

}

function tipo_busqueda() {
	tipo = $("#tipo_busqueda option:selected").val()
	tipo_txt = $("#tipo_busqueda option:selected").text()
	$("#box_busqueda").focus();
	$("#span_buscar").html(tipo_txt)
	return tipo
}

function buscador_tabla() {
	tipo = tipo_busqueda();
	columna = parseInt(tipo)
	var input, filter, table, tr, td, i, txtValue;
	input = document.getElementById("box_busqueda");
	filter = input.value.toUpperCase();
	table = document.getElementById("tabla_requi_compras");
	tr = table.getElementsByTagName("tr");
	for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[columna];
		// console.log(td)
		if (td) {
			// console.log(td.innerText)
			txtValue = td.textContent || td.innerText;
			if (txtValue.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			} else {
				tr[i].style.display = "none";
			}
		}
	}
}



window.onload = function () {
	var fecha = new Date(); //Fecha actual
	var mes = fecha.getMonth() + 1//obteniendo mes+1; 
	var dia = fecha.getDate(); //obteniendo dia
	var ano = fecha.getFullYear(); //obteniendo año

	if (mes < 10)
		mes = '0' + mes //agrega cero si el menor de 10
	$("#fecha_buscar").val(ano + "-" + mes);
}

// $(window).on("load resize ", function() {
// 	var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
// 	$('.tbl-header').css({'padding-right':scrollWidth});
// }).resize();


function buscadores_x_columna(tabla) {



	$('#' + tabla + ' tfoot  tr th ').each(function () {

		var id = $('#' + tabla + ' tfoot tr:eq(0) th').eq($(this).index()).attr("id");
		var title = $('#' + tabla + ' tfoot tr:eq(0) th').eq($(this).index()).text();
		// console.log(id)
		if (id != "importe") {
			if (id == "concepto_ft") {
				$(this).html('<input type="text" style="text-align: center;width: 100%;" placeholder="' + title + '" />');
				//ejemplo
			} else {
				$(this).html('<input type="text" style="text-align:center" placeholder="' + title + '" />');
			}

		} else {
			$(this).html('<label style="font-size:15px;text-align:center">' + title + ' <label/>');
		}



	});

	// $('#example thead .filters th').each(function() {
	//     var title = $('#example thead tr:eq(0) th').eq($(this).index()).text();
	//     $(this).html('<input type="text" placeholder="Search ' + title + '" />');
	// });

	var table = $('#' + tabla).DataTable();




	table.columns().eq(0).each(function (colIdx) {
		$('input', $('#' + tabla + ' tfoot tr th')[colIdx]).on('keyup change', function () {

			table
			.column(colIdx)
			.search(this.value)
			.draw();
		});
	});


}



function busqueda_pre(afectacion) {



	$("#tipo_req_odc").text("REQ | OC")
	var return_data = new Array();
	if (afectacion == "todas_afectaciones") {

		$("#barra_busqueda_todas_afectaciones").removeClass("d-none");
		$('#tipo_busqueda').focus();
		// setTimeout(function() { $("#barra_busqueda_todas_afectaciones").click()}, 3000);

	} else {
		$("#barra_busqueda_todas_afectaciones").addClass("d-none");
	}
	estado_btn = ""
	$("#titulo_estado").empty();

	fecha = $("#fecha_buscar").val();
	afec = "";
	if (afectacion == "Rechazada") {

		$("#titulo_estado").html("Requisiciones Rechazadas")
		afec = "Rechazada";

	}
	else if (afectacion == "PendientedeAutorizar") {
		$("#titulo_estado").html("Requisiciones pendientes por Autorizar")
		afec = "Pendiente de Autorizar";
		estado_btn = "PendientedeAutorizar"

	}
	else if (afectacion == "Autorizada") {
		$("#titulo_estado").html("Requisiciones Autorizada")
		afec = "Autorizada";
	} else if (afectacion == "todas_afectaciones") {
		afec = "todas_afectaciones"
		$("#titulo_estado").html("Requisiciones del mes")

	} else if (afectacion == "Preautorizadas") {
		afec = "Preautorizadas"
		estado_btn = "Preautorizadas"
		$("#titulo_estado").html("Requisiciones PreAutorizadas")
	}
	else if (afectacion == "PendientedeCotizar") {
		afec = "PendientedeCotizar"
		$("#titulo_estado").html("Pendientes de cotizar")
	}


	f = $("#fecha_buscar").val();
	fecha = f.replace("-", "");

	parametro = {
		"afectacion": afec,
		"fecha": fecha, "opcion": "busqueda"
	}

	console.log(parametro)
	$("#tabla").DataTable({
		destroy: true,
		responsive: true,
		orderCellsTop: true,

		"language": {
			"emptyTable": "No se encontraron registros "
		},
		"ajax": {
			"data": parametro,
			"method": "POST",
			"url": "../webCompras/busqueda.php"
		},
		"columns": [

		{ "data": "Fecha" },
			// {"data":"Suc"},
			{ "data": "Requisicion" },
			{ "data": "Elaboro" },
			{ "data": "Concepto" },
			{ "data": "Autorizo" },
			{ "data": "Importe" },
			{ "data": "Estado" }
			],

			"columnDefs": [{
				"targets": 1,
				"data": "Requisicion",
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


	// selected_tr("tabla")
	// ventana_ancho = $(window).width();
	// if (ventana_ancho > 500) {
	// 	buscadores_x_columna()
	// }

}
function borrar_espacios(palabra) {

	datos = palabra.split(" ")
	sin_espacios = ""
	for (i = 0; i < datos.length; i++) {
		if (i == 0) {
			sin_espacios += datos[i]
		} else {
			sin_espacios += "*" + datos[i]
		}

	}
	return sin_espacios

}

function recuperar_espacios(palabra) {
	datos = palabra.split("*")
	recuperado = ""
	for (i = 0; i < datos.length; i++) {
		if (i == 0) {
			recuperado += datos[i]
		} else {
			recuperado += " " + datos[i]
		}

	}
	return recuperado
}






function selected_tr(tabla) {
	$('#' + tabla).on('click', 'tr', function () {
		$(this).toggleClass('selected');
	});
}


function modal_detallado_cotizaciones(requisicion, estado) {
	parametro = {
		"filtro": requisicion,
		"opcion": "busquedaDetalladaCotizacion"
	}
	row = recuperar_espacios(estado)
	table = $('#tabla').DataTable();
	bloquear = "";
	estado = "";
	$('#tabla tbody').on('click', 'tr', function () {

		datos = table.row(this).data();
		// console.log(datos)
		$("#requisicion_cot").val(requisicion);
		$("#fecha_cot").val(datos["Fecha"]);
		$("#tipo_afectacion_cot").val(datos["tipo_afectacion"]);
		$("#solicitante_cot").val(datos["Elaboro"]);
		$("#concepto_cot").val(datos["Concepto"]);

		estado = datos["Estado"]


		// $("#btn_cancelar_requ").hide()
		$("#btn_rechazar_req_cot").hide()
		$("#btn_autorizar_cot").hide()



		if (estado === "Pendiente de Autorizar" || estado === "PreAutorizado") {

			if (estado === "Pendiente de Autorizar" || estado === "PreAutorizado") {

				if (aut_compras == "AUT1COMPRA" && estado === "Pendiente de Autorizar") {
					$("#btn_autorizar_cot").show()
					if (permiso_rechazar_req > 0) {
						$("#btn_rechazar_req_cot").show()
					}
					// $("#btn_cancelar_requ").show()
				}

				if (aut_compras == "AUT2COMPRA" && estado === "PreAutorizado") {
					$("#btn_autorizar_cot").show()
					if (permiso_rechazar_req > 0) {
						$("#btn_rechazar_req_cot").show()
					}
					// $("#btn_cancelar_requ").show()
				}

			}
			if (estado == "Nueva" && permiso_rechazar_req > 0) {
				$("#btn_rechazar_req_cot").show()
			}



		} else {
			// $("#btn_cancelar_requ").hide()
			$("#btn_rechazar_req_cot").hide()
			$("#btn_autorizar_cot").hide()
		}

	});
	$("#tabla_descripcion_cotizador").removeAttr('width').DataTable({

		destroy: true,
		responsive: true,


		"language": {
			"emptyTable": "No se encontraron registros "
		},
		"ajax": {
			"data": parametro,
			"method": "POST",
			"url": "../webCompras/busqueda.php",

		},

		scrollCollapse: true,


		"columns": [
		{"data": "index" },
		{ "data": "producto" },
		{ "data": "proveedor" },
		{ "data": "cantidad" },
		{ "data": "precio" },
		{ "data": "total" },
		],
		// "columnDefs": [
		// 	{ "width": "30%", "targets": 1 }
		// ], fixedColumns: true,
		// "columns": [
		// 	{ "width": "30%" },
		// 	null,
		// 	null,
		// 	null,
		// 	null
		//   ]

	});

}


function buscador_autocompletar(id, direccion, opcion_metodo) {


	$(function () {

		$("#" + id).autocomplete({

			source: function (request, response) {

				$.ajax({

					type: 'POST',
					url: direccion,
					dataType: "json",
					data: {
						"proveedor": request.term,
						"opcion": opcion_metodo
					},
					success: function (data) {
						response(data);
						// console.log(data)
					}
				});
			},

			select: function (event, ui) {
				// agregar_producto_elegido_tabla(ui.item ?
				// 	ui.item.label : this.value,columna,fila,tabla);
			},
			open: function () {
				$(this).removeClass("ui-corner-all").addClass("ui-corner-top");
			},
			close: function () {
				$(this).removeClass("ui-corner-top").addClass("ui-corner-all");
			}
		});
	});
}


function proveedor_por_producto(tabla) {

	// console.log(tabla)
	cont = 0;
	productos_seleccionados = [];
	$('#'+ tabla+' > tbody > tr').each(function () {


		indice  = texto  = $(this).find("td").eq(0).text();
		producto  = $(this).find("td").eq(1).text();
		check  = $(this).find('td:eq(2) input[type=checkbox]')
		if (check.prop('checked')) {

			productos_seleccionados.push(indice)
		}

	});

	requisicion = $("#id_requisicion_").text()
	datos = requisicion.split("-")
	sucursal = datos[0].replace("(", "");
	sucursal = sucursal.replace(")", "");
	proveedor  = $("#"+id_sin_proveedor).val()

	serie  = datos[1]
	folio  = datos[2]
	parametros = {"sucursal":sucursal,
	"serie":serie,
	"folio":folio,
	"indices":productos_seleccionados,
	"opcion":"guardar_producto_proveedor",
	"proveedor":proveedor}

	if (proveedor != "" ) {


	if (productos_seleccionados.length > 0) {


	$.ajax({
		type:'POST',
		url: "../webCompras/busqueda.php",
		data: parametros,
		success:function (resp) {
			console.log(resp)
			datos =JSON.parse(resp)
			Swal({
				title: 'Productos',
				html: datos["mensaje"],
				type: datos["estado"],
				showConfirmButton: true,
				allowOutsideClick: true,
				footer: '<a >Informacion con sistemas</a>'

			}).then((result) => {
				if (result.value) {
					location.href="cotizar_proveedor.php?sucursal="+sucursal+"&serie="+serie+"&folio="+folio;
					// $('#tabla_descripcion_cotizador').DataTable().ajax.reload();
					// $("#btn_cancelar_requ_cot").click();;
				}
			})
		}
	})
}else{
	Swal({
				title: 'Productos',
				html: "<p>Debe seleccionar al menos un producto para guardar</p>",
				type:"warning",
				showConfirmButton: true,
				allowOutsideClick: true,
				footer: '<a >Informacion con sistemas</a>'

		})
}
}else{
		Swal({
				title: 'Productos',
				html: "<p>Favor de escribir el nombre del proveedor</p>",
				type:"warning",
				showConfirmButton: true,
				allowOutsideClick: true,
				footer: '<a >Informacion con sistemas</a>'

		})
}

}
function modal_detallado(requisicion, estado1) {

	parametro = {
		"filtro": requisicion,
		"opcion": "busquedaDetallada"
	}



	table = $('#tabla').DataTable();
	bloquear = "";
	estado = "";
	$('#tabla tbody').on('click', 'tr', function () {

		datos = table.row(this).data();
		// console.log(datos)
		$("#requisicion").val(requisicion);
		$("#fecha").val(datos["Fecha"]);
		$("#tipo_afectación").val(datos["tipo_afectacion"]);
		$("#solicitante").val(datos["Elaboro"]);
		$("#concepto").val(datos["Concepto"]);

		estado = datos["Estado"]


		// $("#btn_cancelar_requ").hide()
		$("#btn_rechazar_req").hide()
		$("#btn_autorizar").hide()



		if (estado === "Nueva" || estado === "Pendiente de Cotizar" || estado === "Solicitando Precios" ||
			estado === "Pendiente de Autorizar" || estado === "PreAutorizado") {

			if (estado === "Pendiente de Autorizar" || estado === "PreAutorizado") {

				if (aut_compras == "AUT1COMPRA" && estado === "Pendiente de Autorizar") {
					$("#btn_autorizar").show()
					if (permiso_rechazar_req > 0) {
						$("#btn_rechazar_req").show()
					}
					// $("#btn_cancelar_requ").show()
				}

				if (aut_compras == "AUT2COMPRA" && estado === "PreAutorizado") {
					$("#btn_autorizar").show()
					if (permiso_rechazar_req > 0) {
						$("#btn_rechazar_req").show()
					}
					// $("#btn_cancelar_requ").show()
				}

			}
			if (estado == "Nueva" && permiso_rechazar_req > 0) {
				$("#btn_rechazar_req").show()
			}



		} else {
			// $("#btn_cancelar_requ").hide()
			$("#btn_rechazar_req").hide()
			$("#btn_autorizar").hide()
		}

	});

	// estado =$("#estadogeneral").val()

	contador = 0;
	$("#tabla_descripcion").DataTable({

		destroy: true,
		responsive: true,


		"language": {
			"emptyTable": "No se encontraron registros "
		},
		"ajax": {
			"data": parametro,
			"method": "POST",
			"url": "../webCompras/" + archivo + ".php",

		},
		"columns": [

		{ "data": "descripcion" },
		{ "data": "unidad_pro" },
		{ "data": "solicitadas" },
		{ "data": "aprobadas" },
		{ "data": "precios" },
		{ "data": "importe" },
		{ "data": "codigo_pro" },
		{ "data": "indice_pro" },
		],
		"columnDefs": [
		{

			"render": function (data, type, row) {
				contador++
				return "<input class='form-control text-center' readonly type='text' name='cantidades[][solicitadas]' value='" + data + "'>";
			},
			"targets": 2
		},
		{

			"render": function (data, type, row) {
				bloquear = ""
				if ((estado !== "Pendiente de Autorizar" && estado !== "PreAutorizado") || data == 0) {
					bloquear = "readonly"
				}
				return "<input class='form-control text-center' " + bloquear + " min='1' type='text' id='aprobadas" + contador + "' name='cantidades[][aprobadas]' oninput=calculo_real('" + contador + "') value='" + data + "'>";
			},
			"targets": 3
		},
		{
			"data": "importe",
			"render": function (data, type, row) {

				return "<input class='form-control text-center TOTALES' readonly id='importes" + contador + "'  type='text' name='cantidades[][importes]' value='" + data + "'>";
			},
			"targets": 5
		},
		{

			"render": function (data, type, row) {
				return "<input class='form-control text-center d-none' type='text' name='cantidades[][codigo_producto]' value='" + data + "'>";
			},
			"targets": 6
		},


		{

			"render": function (data, type, row) {
				return "<input class='form-control text-center d-none '  type='text' name='cantidades[][indice]' value='" + data + "'>";
			},
			"targets": 7
		},
		{

			"render": function (data, type, row) {
				if (data === null) { data = 0 }
					return "<input class='form-control text-center' readonly  id='precios" + contador + "'   type='text' value='" + data + "'>";
			},
			"targets": 4
		}



		],
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
			.column(4, { page: 'current' })
			.data()
			.reduce(function (a, b) {
				return intVal(a) + intVal(b);
			}, 0);

			// Update footer
			$(api.column(4).footer()).html(
				'$' + pageTotal.toFixed(2)
				);
			$(api.column(5).footer()).html(
				'$' + total.toFixed(2)
				);
		},

		"initComplete": function () {

			traer_url_documento(requisicion)
		}


	});





}


function traer_url_documento(requisicion) {
	// console.log(requisicion)
	parametro = {
		"opcion": "url_documento",
		"filtro": requisicion
	}
	$.ajax({
		type: "POST",
		url: "../webCompras/busqueda.php",
		data: parametro,
		dataType: "html",

		success: function (respuesta) {
			// console.log(respuesta)    

			datos = JSON.parse(respuesta);
			url = datos["url"];
			if (url === "sin_url") {
				$(".cont_archivo").css({ "display": "none" })

			} else {
				$(".cont_archivo").css({ "display": "inline" })
				$(".cont_archivo").attr('href', url);
			}

		}
	});

}
function modal_detalladoOC(requisicion, estado) {


	parametro = {
		"filtro": requisicion,
		"estado": "busquedaDetallada"
	}


	if (estado === "PendientedeSurtir") {
		estado = "Pendiente de Surtir"
	}









	table = $('#tabla').DataTable();
	bloquear = "";
	estado = "";
	$('#tabla tbody').on('click', 'tr', function () {

		datos = table.row(this).data();
		$("#requisicionco").val(requisicion);
		$("#fechaco").val(datos["Fecha"]);
		$("#tipo_afectaciónco").val(datos["tipo_afectacion"]);
		$("#solicitanteco").val(datos["Elaboro"]);
		$("#conceptoco").val(datos["Concepto"]);

		estado = datos["Estado"]
		// if ( (estado !== "Pendiente de Autorizar" && estado !== "PreAutorizado") ) {

		// }

		console.log(estado)
		// $("#btn_cancelar_oc").hide()
		$("#btn_rechazar_oc").hide()
		$("#btn_pagar_oc").hide()

		if (estado != "Cancelado" && estado.indexOf("/Pagado") == -1) {
			$("#btn_pagar_oc").show()
		}




		if (estado === "Nueva" || estado === "Pendiente de Cotizar" || estado === "Solicitando Precios" ||
			estado === "Pendiente de Autorizar" || estado === "PreAutorizado") {
			// if (estado === "Pendiente de Autorizar" || estado === "PreAutorizado") {
			// 	$("#btn_cancelar_requ").show()
			// 	$("#btn_autorizar").show()
			// }

			if (parseInt(permiso_rechazar_orden) > 0) {
				$("#btn_rechazar_oc").show()
			} else {
				$("#btn_rechazar_oc").hide()
				// Pagado
			}

		} else {
			// $("#btn_cancelar_requ").hide()
			$("#btn_rechazar_req").hide()
			$("#btn_autorizar").hide()
		}

	});

	// estado =$("#estadogeneral").val()

	contador = 0;
	console.log(parametro)
	$("#tabla_descripcionOC").DataTable({

		destroy: true,
		responsive: true,


		"language": {
			"emptyTable": "No se encontraron registros "
		},
		"ajax": {
			"data": parametro,
			"method": "POST",
			"url": "../webCompras/orden_compra.php",

		},
		"columns": [

		{ "data": "descripcion" },
		{ "data": "unidad_pro" },
		{ "data": "solicitadas" },
		{ "data": "aprobadas" },
		{ "data": "precios" },
		{ "data": "importe" }
		],

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
			.column(4, { page: 'current' })
			.data()
			.reduce(function (a, b) {
				return intVal(a) + intVal(b);
			}, 0);

			// Update footer
			$(api.column(4).footer()).html(
				'$' + pageTotal.toFixed(2)
				);
			$(api.column(5).footer()).html(
				'$' + total.toFixed(2)
				);
		},
		"initComplete": function () {

			traer_url_documento(requisicion)
		}


	});

	// btn_cancelar_oc




}
function formatNumber(num) {
	return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}

function probar() {

	table = $('#tabla_descripcion').DataTable();
	$('#tabla_descripcion tbody').on('click', 'td', function () {
		var rowIdx = table
		.cell(this)
		.index().row;
	});
}
function suma_totales(tabla, input, columna) {
	// body...


	var table = $('#' + tabla).DataTable();
	suma = table.columns(columna).data().sum();

	$("#" + input).val(0)
	// console.log(suma)
	sum = suma.toFixed(2)

	suma_format = formatNumber(sum)
	$("#" + input).val("$ " + String(suma_format))
}


function contador1(cont) {
	cont++;
	return cont + 1;
}
function calculo_real(id) {


	var rowIndex
	// datos = "hola"
	table = $('#tabla_descripcion').DataTable();

	datos_precio = $("#precios" + id).val()
	importe = 0

	$("#aprobadas" + id).keyup(function () {


		var value = $(this).val();

		cantidad = isNaN(value)
		preciopza = isNaN(datos_precio)



		if ((cantidad === false && value != "")) {

			importe = parseInt(value) * parseFloat(datos_precio);
			// console.log(importe)

			importe_dos = trunck_dos(importe)
			$("#importes" + id).val(String(importe_dos))
			$("#importes" + id).attr("readonly", "readonly");
			$("#importes" + id).css({ "color": "#495057" })
			$("#importes" + id).css({ "background-color": "#E9ECEF" })
			importes = table.$('input[name="cantidades[][importes]"]').map(function () {
				return this.value;
			}).get();
			sumatotalgeneral = 0
			for (i = 0; i < importes.length; i++) {
				sumatotalgeneral += parseFloat(importes[i]);
			}
			sumado = trunck_dos(sumatotalgeneral)
			$("#idtotal").val(String(sumado))

		} else {

			$("#importes" + id).val(String(0))
			$("#importes" + id).css({ "color": "white" })
			$("#importes" + id).attr("readonly", "readonly");
			$("#importes" + id).css({ "background-color": "#FC3645" })
			sumatotalgeneral = 0
			$("#idtotal").val(String(sumatotalgeneral))
		}

	});


}

function trunck_dos(numero) {
	// body...
	dato = numero.toFixed(2)

	dos_datos = formatNumber(dato)
	return dos_datos

}


function buscador_compras(filtro_columna) {
	//comprobamos si se pulsa una tecla
	$("#box_busqueda").keyup(function (e) {


		consulta = $("#box_busqueda").val();
		$("#resultado_filtrado_columna").css({ "display": "inline" })
		//hace la búsqueda
		parametro = {
			"filtro": filtro_columna,
			"fecha": fecha, "opcion": "busqueda_x_columna"
		}
		$.ajax({
			type: "POST",
			url: "../webCompras/busqueda.php",
			data: parametro,
			dataType: "html",
			beforeSend: function () {
				//imagen de carga
				$("#resultado_filtrado_columna_body").html("<h3> Espere por favor</h3>");
			},
			error: function () {
				alert("error petición ajax");
			},
			success: function (datas) {
				$("#resultado_filtrado_columna_body").empty();
				$("#resultado_filtrado_columna_body").append(datas);

			}
		});


	});
}

function enviar_Autorizadas() {



	table = $('#tabla_descripcion').DataTable();
	solicitadas = table.$('input[name="cantidades[][solicitadas]"]').map(function () {
		return this.value;
	}).get()



	aprobadas = table.$('input[name="cantidades[][aprobadas]"]').map(function () {
		return this.value;
	}).get()



	errores = 0;
	noNum = 0;
	for (i = 0; i < aprobadas.length; i++) {
		validar = isNaN(aprobadas[i]);
		// console.log(aprobadas[i])
		if (aprobadas[i] == "" || validar === true) {

			noNum++;
		}
	}


	if (noNum == 0) {
		for (i = 0; i < solicitadas.length; i++) {
			solic = parseInt(solicitadas[i]);
			aproba = parseInt(aprobadas[i]);


			if (aproba > solic) {
				$("#aprobadas" + i).css({ " background-color": "red" });
				$("#aprobadas" + i).focus();

				errores++;

			} else {


			}




		}
		if (errores == 0) {

			importes = table.$('input[name="cantidades[][importes]"]').map(function () {
				return this.value;
			}).get();

			var cod_producto = table.$('input[name="cantidades[][codigo_producto]"]').map(function () {
				return this.value;
			}).get();

			var indices = table.$('input[name="cantidades[][indice]"]').map(function () {
				return this.value;
			}).get();
			// console.log(indices)
			filtro3 = $("#requisicion").val();
			solicito = $("#solicitante").val();
			fecha = $("#fecha").val();
			// alert(fecha)

			parametro = {
				"solicitadas": solicitadas,
				"aprobadas": aprobadas,
				"importes": importes,
				"filtro3": filtro3,
				"solicito": solicito,
				"cod_producto": cod_producto,
				"indices": indices,
				"opcion": "updateContas",
				"fecha": fecha
			}

			// console.log(aprobadas);
			// console.log(cod_producto);

			// console.log(indices);
			$.ajax({
				type: "POST",
				url: "../webCompras/busqueda.php",
				data: parametro,
				success: function (respuesta) {
					// console.log(respuesta)
					datos = JSON.parse(respuesta);
					Swal({
						type: '' + datos["tipo"], title: 'Respuesta', html: '' + datos["mensaje"],
						footer: '<a href ="#"></a>'
					}).then((result) => {
						if (result.value) {
							$('#tabla').DataTable().ajax.reload();
							$("#btn_cancelar_requ").click();
						}
					});

				}
			});
		} else {


			Swal({
				type: 'info', title: 'Cantidades autorizadas', html: ' <p> Las cantidades aprobadas no puede ser mayores a las solicitadas   </p>',
				footer: '<a href ="#"></a>'
			})


		}
	} else {


		Swal({
			type: 'info', title: 'Cantidades autorizadas', html: '<p> No se puede dejar campos vacios en  los campos para cantidades autorizadas debe de poner cero </p> ',
			footer: '<a href ="#"></a>'
		})
	}

}

function observacion_x_producto(text) {
	// console.log(text)
	datos = JSON.parse(text);
	Swal({
		type: 'info', title: 'Cantidades autorizadas', html:
		'' + datos["observacion"],
		footer: '<a href ="#"></a>'
	})
}

function aviso_rechazar_todo(tipo_rechazo, id_boton) {
	Swal.fire({
		title: 'Rechazar ' + tipo_rechazo,
		text: "¿Estas seguro que deseas rechazar la " + tipo_rechazo + " ?",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si,Rechazar'
	}).then((result) => {
		if (result.value) {
			// if (tipo_rechazo == "requisicion") {
				$("#" + id_boton).click();
			// }
			// if (tipo_rechazo == "ODC") {
			// 	$("#btn_cancelar_oc").click()
			// }

			mensaje_rechazar(tipo_rechazo);
		}
	})
}

async function mensaje_rechazar(tipo_rechazo) {

	const { value: text } = await Swal.fire({
		input: 'textarea',
		inputPlaceholder: 'Motivo de rechazo',
		showCancelButton: true
	})

	if (text) {
		if (tipo_rechazo == "requisicion") {
			rechazar_toda_requisicion(text)
		}
		if (tipo_rechazo == "ODC") {
			rechazar_toda_odc(text)
		}

	} else {
		alert("Para poder realizar el rechazo, se debera describir el motivo")
	}
}


function realizar_cotizacion() {

}

function rechazar_toda_odc(motivo_rechazo) {
	odc = $("#requisicionco").val()
	fecha = $("#fechaco").val()

	parametros = {
		"filtro": odc,
		"estado": "cancelar_odc", "motivo_rechazo": motivo_rechazo, "fecha": fecha
	}
	console.log(parametros)
	console.log(motivo_rechazo)
	$.ajax({

		type: 'POST',
		url: '../webCompras/orden_compra.php',
		data: parametros,
		success: function (resq) {
			console.log(resq)
			estado = JSON.parse(resq)
			if (estado["estado"] == "success") {
				Swal({
					type: 'success',
					title: 'Cancelacion de ODC',
					html: '<p>Se ha cancelado exitosamente la ODC <spam style="font-weight:bold">' + estado["odc"] + '</spam><p>',
					footer: '<a href ="#"></a>'
				}).then((result) => {
					if (result.value) {
						$('#tabla').DataTable().ajax.reload();
					}
				})
			} else {
				Swal({
					type: 'error',
					title: 'Error',
					html: '<p>No se pudo cancelar la ODC <spam style="font-weight:bold">' + estado["odc"] + "</spam></p>",
					footer: '<a href ="#">Si el problema persiste llamar a sistemas</a>'
				}).then((result) => {
					if (result.value) {
						$('#tabla').DataTable().ajax.reload();
					}
				})
			}
		}
	})

}
function rechazar_toda_requisicion(motivo_rechazo) {


	table = $('#tabla_descripcion').DataTable();
	solicitadas = table.$('input[name="cantidades[][solicitadas]"]').map(function () {
		return this.value;
	}).get()



	aprobadas = table.$('input[name="cantidades[][aprobadas]"]').map(function () {
		return this.value;
	}).get()
	importes = table.$('input[name="cantidades[][importes]"]').map(function () {
		return this.value;
	}).get();

	var cod_producto = table.$('input[name="cantidades[][codigo_producto]"]').map(function () {
		return this.value;
	}).get();

	var indices = table.$('input[name="cantidades[][indice]"]').map(function () {
		return this.value;
	}).get();
	// console.log(indices)
	filtro3 = $("#requisicion").val();
	solicito = $("#solicitante").val();
	fecha = $("#fecha").val();


	rechazadas = [];
	for (i = 0; i < aprobadas.length; i++) {
		rechazadas.push(0)
	}
	parametro = {
		"solicitadas": solicitadas,
		"aprobadas": rechazadas,
		"importes": importes,
		"filtro3": filtro3,
		"solicito": solicito,
		"cod_producto": cod_producto,
		"indices": indices,
		"opcion": "cancelar_requisicion",
		"fecha": fecha,
		"motivo_rechazo": motivo_rechazo
	}

	$.ajax({
		type: 'POST',
		url: "../webCompras/busqueda.php",
		data: parametro,
		success: function (respuesta) {
			// console.log(respuesta)
			datos = JSON.parse(respuesta);


			Swal({
				type: '' + datos["tipo"],
				title: 'Cancelada',
				html: '' + datos["mensaje"],
				footer: '<a href ="#">' + datos["pie"] + '</a>'
			}).then((result) => {
				if (result.value) {
					$('#tabla').DataTable().ajax.reload();
					$("#btn_cancelar_requ").click();;
				}
			})

		}
	}); //fin del ajax
}


function compras_pagar(estado) {


	$("#tipo_req_odc").text("OC | REQ")
	f = $("#fecha_buscar").val();
	$("#titulo_estado").empty();

	fecha = f.replace("-", "");
	// alert(fecha)
	if (estado === "PendientedeSurtir") {
		estado = "Pendiente de Surtir";
		$("#titulo_estado").html("Ordenes de compra")
	}
	if (estado === "todas_ordenes") {
		estado = "todas_ordenes"
		$("#titulo_estado").html("Ordenes de compra del mes")
	}

	if (estado == "Pagado") {
		estado = "Pagado";
		$("#titulo_estado").html("Ordenes pagadas")
	}
	// alert(estado)
	parametro = {
		"estado": estado,
		"fecha": fecha
	}
	console.log(parametro)

	$("#tabla").DataTable({
		destroy: true,
		responsive: true,


		"language": {
			"emptyTable": "No se encontraron registros "
		},
		"ajax": {
			"data": parametro,
			"method": "POST",
			"url": "../webCompras/orden_compra.php",


		},

		"columns": [

		{ "data": "Fecha" },

		{ "data": "Requisicion" },
		{ "data": "Elaboro" },
		{ "data": "Concepto" },
		{ "data": "Autorizo" },
		{ "data": "Total" },
		{ "data": "Estado" }
		],
		"columnDefs": [{
			"targets": 1,
			"data": "Requisicion",
			"render": function (data, type, row, meta) {
				req = data.split("/")
				requisicion = req[0].replace(/[-+()\s]/g, '-');
				archivo = "orden_compra";
				if (estado === "Pendiente de Surtir") {
					estado = "PendientedeSurtir"
				}
				cadena1 = "<strong  >" + req[0] + ", </strong>";
				cadena2 = "";
				if (req.length > 1) {
					cadena2 = "<span style='color:gray'>" + req[1] + "</span>"
				}
				return "<a href='#'' data-toggle='modal' data-target='#modal_detalladoOC' onclick=modal_detalladoOC('" + requisicion + "','" + estado + "')>" + cadena1 + "</a>" + cadena2;
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

	})




}


function pagar_OC() {
	requisicion = $("#requisicionco").val();
	concepto = $("#conceptoco").val();
	parametro = {
		"filtro": requisicion,
		"estado": "Pagar",
		"concepto": concepto
	}

	$.ajax({
		type: 'POST',
		url: "../webCompras/orden_compra.php",
		data: parametro,
		success: function (respuesta) {
			// console.log(respuesta)
			datos = JSON.parse(respuesta);
			if (datos["estado"] === "Pagado") {

				Swal({
					type: 'success',
					title: 'Pagado',
					text: 'La orden de compra ha sido pagada ',
					footer: '<a href ="#"></a>'
				}).then((result) => {
					if (result.value) {
						$('#tabla').DataTable().ajax.reload();
						$("#btn_cancelar_oc").click();;
					}
				})
			} else {
				Swal({
					type: 'error',
					title: 'Error',
					text: 'No se pudo registrar el pago de la orden de compra',
					footer: '<a href ="#">Si el problema persiste llamar a sistemas</a>'
				})
			}
		}
	}); //fin del ajax
}


jQuery.fn.dataTable.Api.register('sum()', function () {
	return this.flatten().reduce(function (a, b) {
		if (typeof a === 'string') {
			a = a.replace(/[^\d.-]/g, '') * 1;
		}
		if (typeof b === 'string') {
			b = b.replace(/[^\d.-]/g, '') * 1;
		}

		return a + b;
	}, 0);
});



function importar_pdf(campo, type_file) {

	//'requisicion','requisicion'
	datos = $("#" + campo).val();

	param = {
		"datos": datos,
		"tipo": type_file
	}
	Swal({
		title: 'Creando vista previa, por favor espere...',
		onOpen: function () {
			Swal.showLoading()

			$.ajax({
				type: 'POST',
				url: "../webCompras/crear_pdf.php",
				data: param,
				success: function (respuesta) {
					datos_pdf = JSON.parse(respuesta);
					console.log(respuesta)
					if (datos_pdf["proceso"] == "success") {
						url = datos_pdf["url"];
						window.open(url, "_blank");


						Swal({
							type: 'success',
							title: 'Vista previa',
							html: 'Se ha creado la vista previa',
							footer: '<a href ="#"></a>'
						})
					} else {
						Swal({
							type: 'error',
							title: 'Vista previa',
							html: datos_pdf["url"],
							footer: '<a href ="#">Favor de comunicarse con sistemas</a>'
						})
					}
				}
			})


		}
	})

}

function show_modal_ending() {

	collapse = "<br> <div class='collapse' id='explicacion_swal_cot'>" +
	"<div class='card card-body '>" +
	" <a href='#' class='list-group-item list-group-item-action list-group-item-light'><span class='explicacion_estados'>Pendiente de cotizar:</span> Ningun producto tiene asignado precio y proveedor</a>" +
	"<a href='#' class='list-group-item list-group-item-action list-group-item-light'><span class='explicacion_estados'>Solicitando precio:</span> Al menos un producto tiene asignado precio y proveedor </a>" +
	"<a href='#' class='list-group-item list-group-item-action list-group-item-light'><span class='explicacion_estados'>Pendiente de autorizar:</span> Todos los productos tienen asignado precio y proveedor</a>" +
	"<a href='#' class='list-group-item list-group-item-action list-group-item-light'>Estado original al no cumplir ninguna de las anteriores</a>" +
	"</div>" +
	"</div>"

	_html = "<div class='cont_butones' >" +
	"<button class = 'btn btn-danger btn_swal' id='btn_cancelar_swal' >Cancelar</button>" +
	"<button class='btn btn-primary btn_swal' id='btn_guardar_swal'>Guardar</button>" +
	"<button class='btn btn-success btn_swal' id='btn_coti_provee_swal'>Por proveedor</button>" +

	"</div>" + collapse


	Swal({
		title: 'Opciones de cotización',
		html: _html,
		type: 'warning',
		showConfirmButton: false,
		allowOutsideClick: false,
		footer: '<a data-toggle="collapse" href="#explicacion_swal_cot" role="button" aria-expanded="false"' +
		' aria-controls="explicacion_swal_cot">explicación de opciones</a>'

	})
}



function validar_cotizacion() {

	table = $("#tabla_descripcion_cotizador").DataTable();
	datos = table.rows().data().toArray()
	campos = ["importes_cot", "cantidad_cot", "precio_cot", "proveedor_cot"]
	datos_obtenidos = [];
	productos = []
	indices = []
	requisicion  = $("#requisicion_cot").val();

	for (i = 0; i < campos.length; i++) {
		obtenido = table.$('input[name="' + campos[i] + '[]"]').map(
			function () {
				return this.value;
			}
			).get();
		datos_obtenidos[i] = obtenido;

	}

// console.log(datos)
for (i = 0; i < datos.length; i++) {
	productos.push(datos[i].producto)
	indices.push(datos[i].index)

}

datos_obtenidos[4] = productos
datos_obtenidos[5] = indices


$.ajax({
	type: 'POST',
	url: '../webCompras/busqueda.php',
	data: { "datos": datos_obtenidos, "opcion": "validar_cotizacion","filtro3":requisicion },
	success: function (response) {
		datos  = JSON.parse(response)
		console.log(response)
		Swal({
			title: 'Cotizaciones',
			html: datos["mensaje"],
			type: datos["estado"],
			showConfirmButton: true,
			allowOutsideClick: false,
			footer: '<a data-toggle="collapse" href="#explicacion_swal_cot" role="button" aria-expanded="false"' +
			' aria-controls="explicacion_swal_cot">Informacion con sistemas</a>'

		}).then((result) => {
			if (result.value) {
				$('#tabla_descripcion_cotizador').DataTable().ajax.reload();
				$("#btn_cancelar_requ_cot").click();;
			}
		})
	}
})

}