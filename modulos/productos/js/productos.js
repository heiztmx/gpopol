$(document).ready(function () {
	guardar = $("#guardar_producto")
	guardar.click(function () {
		formulario = $("#formulario_productos").serializeArray();
		validar = true
		campos_vacios = []
		for (i = 0; i < formulario.length; i++) {

			if (formulario[i].value === "") {
				validar = false
				$("#" + formulario[i].name).addClass("error")
				campos_vacios.push($("#" + formulario[i].name + "_label").text())
			}
		}

		if (validar == true) {
			$.ajax({

				type: 'POST',
				url: '../metproductos/guardar_producto',
				data: formulario,
				success: function (resp) {
					console.log(resp)
					r = JSON.parse(resp)
					if (r["estatus"] == "success") {

						$("#ocultar_div").css({ "display": "none" })
						$("#icono_prod_res").css({ "display": "inline" })
						add_icono("success_products", "icono_prod_res")
						$("#texto_res").text("Producto guardado exitosamente.")


					} else {

						$("#ocultar_div").css({ "display": "none" })
						$("#icono_prod_res").css({ "display": "inline" })
						add_icono("error", "icono_prod_res")
						$("#texto_res").text("Error al guardar el producto.")

					}


				}
			})
		} else {
			cadena_vacios = "";
			campos_vacios.map(function (x) {
				cadena_vacios += "<li class ='list-group-item list-group-item-action'>" + x + "</li>";
				// console.log(x)
			});
			Swal({
				title: 'Producto',
				html: "<p style='font-weight:bold'>Campos vacios favor de validar</p>" +
					"<ul class='list-group'>" + cadena_vacios + "</ul>",
				type: 'warning',
				// footer: '<a href>Why do I have this issue?</a>'

			})
		}

	})


	click_derecho()
	// add_icono("success_products","icono_prod_res")
	// ocultar_menu()
	// elegir_opcion_menu()

});


function add_icono(icono, id) {
	animacion = lottie.loadAnimation({

		container: document.getElementById(id),
		renderer: 'svg',
		loop: true,
		autoplay: true,
		path: '../assets/' + icono + ".json"
	});
}

function validar_codigo_barras(codigo_barras, estacion, nextStepWizard, isValid, curInputs, nombre_estacion) {
	parametro = { "codigo_barras": codigo_barras, "opcion": "codigo_barras", "estacion": estacion }
	$.ajax({

		type: 'POST',
		url: '../metproductos/opciones_productos.php',
		data: parametro,
		success: function (resp) {
			// console.log(resp)
			respuesta = JSON.parse(resp)
			if (respuesta["existe"] == "si") {

				// refill_select(id,arreglo,caracter_separador,pordefault)
				confirmacion_codigo_barras(isValid, nextStepWizard, curInputs, respuesta, codigo_barras, nombre_estacion)


			} else if (respuesta["existe"] == "no") {
				if (isValid) nextStepWizard.removeAttr('disabled').trigger('click');
			}

		}
	})


}



function confirmacion_codigo_barras(isValid, nextStepWizard, curInputs, respuestabd, codigo_barras, nombre_estacion) {



	Swal.fire({
		title: 'Producto',
		html: "<p style='font-weight:bold'>El codigo de barras <span style='color:#008558;font-weight:bold'>" + codigo_barras + "</span>"
			+ " ya existe en la estacion <span style='color:#008558;font-weight:bold'>" + nombre_estacion + "</span></p> "
			+ "<p style='font-weight:bold' >¿Estas seguro que deseas continuar?</p> ",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Continuar',
		cancelButtonText: "Cancelar"
	}).then((result) => {
		if (result.value) {
			if (isValid) {
				rellenar_formulario(respuestabd, curInputs)
				nextStepWizard.removeAttr('disabled').trigger('click');
			} else {
				for (i = 0; i < curInputs.length; i++) {
					valor = curInputs[i].value;
					if (valor == "") {

						idinput = curInputs[i].id
						$("#" + idinput).addClass("error")
					}
				}
				limpiar_errores(curInputs)


			}

		}
	})

}

function rellenar_formulario(respuestabd, curInputs) {
	for (i = 0; i < curInputs.length; i++) {
		valor_bd = respuestabd["formulario"][curInputs[i].id]
		if ($("#" + curInputs[i].id).is('input')) {
			$("#" + curInputs[i].id).val(valor_bd)
		}
	}


	valor_bd = respuestabd["formulario"]["estaciones"]
	defaults = respuestabd["principales"]["estaciones_default"]
	refill_select("estaciones", valor_bd, "**", defaults)

	$("#sublinea_producto").prop('disabled', false)
	valor_bd = respuestabd["formulario"]["sublinea_producto"]
	defaults = respuestabd["principales"]["sublinea_producto_default"]
	refill_select("sublinea_producto", valor_bd, "**", defaults)

	valor_bd = respuestabd["formulario"]["marca_producto"]
	defaults = respuestabd["principales"]["marca_producto_default"]
	refill_select("marca_producto", valor_bd, "**", defaults)


	valor_bd = respuestabd["formulario"]["iva_producto"]
	defaults = respuestabd["principales"]["iva_producto_default"]
	refill_select("iva_producto", valor_bd, "**", defaults)


}

function producto_x_estacion() {

	estacion = $("#grupo_estaciones option:selected").val()

	parametro = {
		"estacion": estacion,
		"opcion": "productoxestacion"
	}
	$("#tabla_productos").DataTable({

		destroy: true,
		responsive: true,


		"language": {
			"emptyTable": "No se encontraron productos "
		},
		"ajax": {
			"data": parametro,
			"method": "POST",
			"url": "../metproductos/opciones_productos.php",

		},
		"columns": [

			{ "data": "id" },
			{ "data": "producto" },
			{ "data": "unidad" },
			{ "data": "precio" },
			{ "data": "barras" },
			{ "data": "estacion" },
			{ "data": "activo" },
			{ "data": "linea" },
			{ "data": "todos" },

		],
		"columnDefs": [
			{

				"render": function (data, type, row) {

					// console.log(row)

					
					
					// console.log(row)
					return '<span style="width:100%" class="context-menu-one btn btn-link fas fa-ellipsis-v" id="' + data + '"></span>';
				},
				"targets": 8
			}],

		"initComplete": function () {
			// suma_totales("tabla_descripcion","idtotal");

		}


	});
}



function desbloquear_update() {
	$(".btn-primary").prop('disabled', false);
}


function tomar_datos(datos) {
	$("#modificar_productos").click();
	subdatos = datos.split("||")
	console.log(datos)

	id = subdatos[0]

	nombre = ""
	giros = cuantasVecesAparece(subdatos[1], ".")
	if (giros > 0) {
		arreglo = subdatos[1].split(".")
		for (i = 0; i < arreglo.length; i++) {
			nombre += arreglo[i] + " "

		}

	} else {
		nombre = subdatos[1]
	}
	clave = subdatos[0]
	precio = subdatos[2]
	barras = subdatos[3]
	activo = subdatos[4]
	linea = subdatos[5]
	estacion = subdatos[7]
	$("#clave").val(clave)
	$("#id_estacion").val(estacion)
	$("#precio").val("$" + precio)
	$("#nombre").val(nombre)
	$("#codigo").val(barras)
	$("#estado option[value='" + activo + "']").attr("selected", true);
	$("#estacion option[value='" + estacion + "']").attr("selected", true);
	$("#linea option[value='" + linea + "']").attr("selected", true);

	// });

}
function cuantasVecesAparece(cadena, caracter) {
	var indices = [];
	for (var i = 0; i < cadena.length; i++) {
		if (cadena[i].toLowerCase() === caracter) indices.push(i);
	}
	return indices.length;
}

function modificar_productos() {
	nombre = $("#nombre").val()
	barras = $("#codigo").val()
	var estado = $("#estado option:selected").val();
	var estacion = $("#estacion option:selected").val();
	var linea = $("#linea option:selected").val();
	var id_estacion = $("#id_estacion").val();
	var clave = $("#clave").val();
	parametros = {

		"nombre": nombre,
		"barras": barras,
		"estado": estado,
		"estacion": estacion,
		"linea": linea,
		"id_estacion": id_estacion,
		"opcion": "modificar",
		"clave": clave
	}
	// console.log(parametros)
	$.ajax({
		type: 'POST',
		url: '../metproductos/opciones_productos.php',
		data: parametros,
		success: function (respuestas) {
			console.log(respuestas)
			if (respuestas === "actualizado") {
				Swal({
					type: 'success', title: 'Productos', html: 'Producto actualizado',
					footer: '<a href ="#"></a>'
				}).then((result) => {
					if (result.value) {
						$('#tabla_productos').DataTable().ajax.reload();
						$("#modificar_productos").click();
					}
				});
			} else {
				Swal(
					'Productos',
					'Problemas al actualizar el producto' + nombre,
					'error'
				)
			}
		}
	});
}


function agregar_producto() {

	$("#agregar_productos").click()
}


function asignar_precio(linea) {
	datos  = linea.split("||")
	$("#descripcion_asignar_precio").val(datos[1])
	$("#estacion_asignar_precio").val(datos[datos.length - 2])
	$("#codigo_barras_asignar_precio").val(datos[3])
	$("#id_producto_asignar").val(datos[0])
}

function buscador_autocomplete(id, opcion) {

	// $("#"+id).keyup(function () {

	$("#" + id).autocomplete({

		source: function (request, response) {
			buscando = request.term

			parametros = {
				"opcion": opcion,
				"nombre": buscando,

			}
			console.log(parametros)
			$.ajax({
				type: 'POST',
				url: '../metproductos/opciones_productos',
				dataType: "json",
				data: parametros,
				success: function (respuesta) {
					response(respuesta);
					console.log(respuesta)
				}
			})


		},
		select: function (event, ui) {

		},
		open: function () {
			$(this).removeClass("ui-corner-all").addClass("ui-corner-top");
		},
		close: function () {
			$(this).removeClass("ui-corner-top").addClass("ui-corner-all");
		}
	});
	// });
}

function buscador_lineas_sublineas(id, tabla) {
	// body...clave_producto


	$("#" + id).keyup(function () {


		if ($(this).val() === "") {
			$("#sublinea_producto").prop("disabled", true);
			select_sublinea = document.getElementById("sublinea_producto");
			vaciar_select(select_sublinea)
		}

		$("#" + id).autocomplete({

			source: function (request, response) {


				linea = request.term


				if (linea.indexOf('|') != -1) {
					take = linea.split("|")
					linea = take[0]
				}


				opcion = "buscador_lineas";
				parametros = {
					"opcion": opcion,
					"tabla": tabla,
					"nombre": linea,

				}

				$.ajax({

					type: 'POST',
					url: "../metproductos/opciones_productos",
					dataType: "json",
					data: parametros,
					success: function (datas) {
						response(datas);

						if (datas.length == 0 || datas == "") {

							// $("sublinea_producto").prop('disabled',false);
							$("#sublinea_producto").prop("disabled", true);
						}
					}
				});

			},

			select: function (event, ui) {


				get_sub_lineas(ui.item ? ui.item.label : this.value);
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


function get_sub_lineas(linea) {

	if (linea.indexOf('|') != -1) {
		take = linea.split("|")
		linea = take[0]
	}
	$("#sublinea_producto").prop("disabled", false);
	// _selected ="<option selected></option>";
	parametros = { "opcion": "buscador_sublineas", tabla: "DINVSLIN", "nombre": linea }

	select_sublinea = document.getElementById("sublinea_producto");
	vaciar_select(select_sublinea)
	$.ajax({

		type: 'POST',
		url: '../metproductos/opciones_productos',
		data: parametros,
		success: function (resq) {
			respuesta = JSON.parse(resq)
			datos = respuesta["sublineas"]
			for (i = 0; i < datos.length; i++) {

				d = datos[i].replace(/[\[\]']+/g, "")
				cortar = d.split("**")
				sublinea = cortar[0]
				var option_sublinea = document.createElement("option")
				option_sublinea.setAttribute("value", sublinea);
				option_sublinea.setAttribute("label", cortar[1])
				option_sublinea.text = cortar[1]

				select_sublinea.appendChild(option_sublinea);



			}

			// id_select , array_resultado, separador p/split , dato por default
			refill_select("marca_producto", respuesta["marcas"], "**", 1)

			refill_select("iva_producto", respuesta["ivas"], "**", 1)


		}
	})
}


function limpiar_errores(campos) {
	setTimeout(function () {
		for (i = 0; i < campos.length; i++) {
			id = campos[i].id
			$("#" + id).removeClass("error")
		}
	}, 2000);
}


function refill_select(id, arreglo, caracter_separador, pordefault) {

	_select = document.getElementById(id)
	vaciar_select(_select)

	for (i = 0; i < arreglo.length; i++) {
		cortar = arreglo[i].split(caracter_separador)
		value = cortar[0]
		texto = cortar[1]
		var option = document.createElement("option")
		option.setAttribute("value", value)
		option.setAttribute("label", texto)
		option.text = texto
		if (pordefault === parseInt(value)) {
			option.selected = true
		}
		_select.appendChild(option)
	}
}

function vaciar_select(lista) {
	while (lista.firstChild) {
		lista.removeChild(lista.firstChild);

	}



}


function click_derecho(fila) {

	$(function () {
		
		$.contextMenu({
			selector: '.context-menu-one',
			trigger: 'left',
			callback: function (key, options) {
				datos = $(this).attr("id")
				// console.log(datos)
				d = $(this).attr("id").split("||")

				id_producto = d[0]
				estacion = d[d.length - 1]
				switch (key) {
					case "editar":
						tomar_datos(datos)
						break;
					case "activar":
						cambio_estatus_producto(id_producto,estacion,"Si","cambio_estatus")
						break;
					case "desactivar":
						cambio_estatus_producto(id_producto,estacion,"No","cambio_estatus")
						break;

					default:
						break;
				}

				// alert($(this).attr("id"))
			},

			items: {
				"editar": { name: "Editar", icon: "fas fa-edit" },
				"activar": { name: "Activar", icon: "fas fa-check-circle",disabled: function(){ 

					datos = $(this).attr("id").split("||")

					activado  = datos[4]
					console.log(activado)
					if (activado  == "Si") {
						return true
					}else{
						return false; 
					}
					
					}  },
				"desactivar": { name: "Desactivar", icon: "fas fa-times",disabled: function(){ 

					datos = $(this).attr("id").split("||")
					activado  = datos[4]
					if (activado  == "No") {
						return true
					}else{
						return false; 
					}
					
					} 
				},
				

			}
		});

		$('.context-menu-one').on('click', function (e) {
			console.log('clicked', this);
		})
	});

	// $('.context-menu-one').on('click', function (e) {
	// 	console.log('clicked', this);
	// })
}

function cambio_estatus_producto(id_producto, estacion,estatus, opcion) {

	parametros = {
		"clave": id_producto
		, "id_estacion": estacion
		,"estado":estatus
		, "opcion": opcion
	}
	$.ajax({
		type:"POST"
		,url:"../metproductos/opciones_productos.php"
		,data:parametros,
		success:function (response) {
			r = JSON.parse(response)
			Swal({
				type: ''+r["estatus"]
				, title: 'Cambio de estatus'
				, html: '<p > <span style=" font-weight:bold ">'+r["mensaje"]+'</span></p>',
				footer: '<a href ="#"></a>'
			}).then((result) => {
				if (result.value) {
					$('#tabla_productos').DataTable().ajax.reload();
				
				}
			});
		}
	})

}
function da(datos) {
	alert(datos)
}