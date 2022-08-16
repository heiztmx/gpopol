window.onload = function(){
  var fecha = new Date(); //Fecha actual
  var mes = fecha.getMonth()+1//obteniendo mes+1; 
  var dia = fecha.getDate(); //obteniendo dia
  var ano = fecha.getFullYear(); //obteniendo año

  if(mes<10)
    mes='0'+mes //agrega cero si el menor de 10
$("#fecha_buscar_liq").val(ano+"-"+mes+"-"+dia);

$("#liquidaciones tfoot th").hide()
// $("#tabla tfoot th").hide()
}


function buscar_liquidaciones() {
	
	fecha = $("#fecha_buscar_liq").val()
	estacion  =$("#estaciones option:selected").val();
	isla = $("#isla").val();  
	turno  =   $("#turnos option:selected").val();

	parametro ={
		"fecha":fecha,
		"estacion":estacion,
		"isla":isla,
		"turno":turno,
		"opcion":"busqueda_detallada"
	}
	console.log(parametro)
	if (isla  !== "") {
		

		$("#liquidaciones").DataTable({
			destroy: true,
			responsive: true,
			orderCellsTop: true,

			"language": {
				"emptyTable": "No se encontraron liquidaciones "
			},
			"ajax":{
				"data":parametro,
				"method":"POST",
				"url": "../metHerramientas/opciones_liquidaciones.php"
			},
			"columns":[


		// {"data":"Suc"},
		{"data":"fecha"},
		{"data":"estacion"},
		{"data":"folio"},
		{"data":"isla"},
		{"data":"turno"},
		{"data":"total"},
		{"data":"borrar"}

		],

		"columnDefs": [
		{

			"render": function ( data, type, row ) {

				return "<i class='far fa-trash-alt fa-2x mx-auto' onclick =mensaje_borrar_liquidaciones('"+data+"')></i>";
			},
			"targets": 6
		}],

		"initComplete": function() {

			buscadores_x_columna("liquidaciones")


		}

	});
	}
	else{
		Swal({type: 'error',title:'Liquidaciones',html:"<p>Favor de poner el numero de isla</p>",
			footer: '<a href ="#"></a>'}).then((result) => {
				if (result.value) {
					// $('#liquidaciones').DataTable().ajax.reload();

				}
			});
		}
	}

	function mensaje_borrar_liquidaciones(datos_liquidacion) {
		datos = datos_liquidacion.split("*");
		Swal({
			title: '¿Seguro que desea eliminar la liquidacion?',
			html: "<p>Folio de liquidacion:  <strong>"+datos[0]+"</strong> <p>",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: '¡Si, eliminar!'
		}).then((result) => {
			if (result.value) {

				borrar_liquidaciones(datos[0],datos[1],datos[2],datos[3],datos[4])
			}
		})
	}

	function borrar_liquidaciones(folio,estacion,turno,fecha,isla) {

	// liquidacion = datos_liquidacion.split("*")
	// folio = liquidacion[0];
	// estacion = liquidacion[1];
	// turno = liquidacion[2]
	parametro = {
		"folio":folio,
		"estacion":estacion,
		"turno":turno,
		"fecha":fecha,
		"isla":isla,
		"opcion":"eliminar"
	}
	console.log(parametro)

	$.ajax({
		type:"POST",
		url:"../metHerramientas/opciones_liquidaciones.php",
		data:parametro,
		success:function(respuesta){
			console.log(respuesta)
			datos=JSON.parse(respuesta);
			if (datos["tipo"]  === "success") {
				Swal({type: ''+datos["tipo"],title:'Liquidaciones',html: ''+datos["mensaje"],
					footer: '<a href ="#"></a>'}).then((result) => {
						if (result.value) {
							$('#liquidaciones').DataTable().ajax.reload();

						}
					});
				}else{
					tabla = "<table class='table table-sm'><thead><tr><th scope='col'>Tabla</th><th scope='col'>Error</th></tr></thead>" +
					"<tbody>";
					for(i = 0; i<datos["errores"].length; i++)
					{
						res = datos["errores"][$i].split("**");
						tabla_bd =res[0];
						error_bd = res[1];

						tabla += "<tr>";
						tabla += "<td scope='row'>" + tabla_bd + "</td>";
						tabla += "<td scope='row'>" + error_bd + "</td>"
						tabla += "</tr>";

					}

					tabla += " </tbody></table>";
					Swal({type: ''+datos["tipo"],title:'Liquidaciones',html:""+tabla,
						footer: '<a href ="#"></a>'}).then((result) => {
							if (result.value) {
								$('#liquidaciones').DataTable().ajax.reload();

							}
						});
					}


				}
			});

}


