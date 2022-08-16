
$(document).ready(function(){

	$("#contenedor_herramientas").load("mascaras.php");
});


function Activar_mascara() {
	// body..

	
	var mascara = $("#listaMascaras").val();
	parametro ={"mascara": mascara,
	"opcion" :"mascaras"}
	$.ajax({
		type: "POST",
		url: "../metHerramientas/DirMascara.php",
		data: parametro,
		success: function(respuesta) {
			subDatos=respuesta.split("**");
			Swal({
				type: ''+subDatos[0],
				title: 'Mascaras',
				html: ''+subDatos[1],
				allowOutsideClick: false,
				footer: '<a id="enlace"  target="_blank">Excel</a>'
			}).then((result) => {
				if (result.value) {
					recargar_accordion();
				}
			})
		}
	})

	
}


function Usadas_mascaras(datos) {
	// body...
	subDatos = datos.split("||");
	total = parseInt(subDatos[2]) - parseInt( subDatos[1]);
	parametro ={"mascara": subDatos[0],
	"opcion" :"usadas"}
	$.ajax({
		type: "POST",
		url: "../metHerramientas/DirMascara.php",
		data: parametro,
		success: function(respuesta) {

			resultado = total - parseInt(respuesta);
			$("#disponibles"+subDatos[0]).val(resultado);
			$("#usados"+subDatos[0]).val(respuesta);


		}
	});
}

function delete_mascara(id) {
	// body...
	parseInt(id);
	parametro ={"id":id,
	"opcion" :"delete"}

	Swal({
		title: '¿Deseas eliminar esta mascara?',
		text: "",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, eliminarlo'
	}).then((result) => {
		if (result.value) {
			$.ajax({
				type: "POST",
				url: "../metHerramientas/DirMascara.php",
				data: parametro,
				success: function(respuesta) {
					console.log(respuesta)
					subDatos =respuesta.split("**")
					Swal({
						type: ''+subDatos[0],
						title: 'Mascaras',
						html: ''+subDatos[1],
						allowOutsideClick: false,
						footer: '<a id="enlace"  target="_blank"></a>'
					}).then((result) => {
						if (result.value) {
							recargar_accordion();
						}
					})

				}
			});
		}
	})

}


function nuevas_mascaras() {
	
	mascara = $("#mascara_new").val();
	inicial = $("#inicial").val();
	final = $("#final").val();
	opcion="nuevas_mascaras";
	parametro = { "mascara": mascara,
	"inicial": inicial,
	"final":final,
	"opcion": opcion}
	val_mas = isNaN(mascara);
	val_inicial = isNaN(inicial);
	val_final =isNaN(final);


	if(mascara != ""  && inicial != "" && final != ""){
		if( val_mas === false && val_inicial === false && val_final === false){

			if(mascara.length == 12 && parseInt(final) > 0){

				$.ajax({
					type:"POST",
					url:"../metHerramientas/DirMascara.php",
					data:parametro,
					success:function(respuesta){
						console.log(respuesta);
						subDatos = respuesta.split("**");
						if(subDatos[0] == "info"){
							// console.log(respuesta)					CANCELADO,ESTATUS
							decision_reactivar(subDatos[1],subDatos[0],subDatos[2],subDatos[3])
						}else{
							Swal({ 
								type: ''+subDatos[0],
								title: 'Creación de nuevas mascaras',
								html: ''+subDatos[1],
								allowOutsideClick: false,
								footer: '<a id="enlace"  target="_blank"></a>'
							}).then((result) => {
								if (result.value) {
									recargar_accordion();
								}
							})
						}
					}
				});
			}else{	
				errores='<p  style="text-align: center; color: red"> El tamaño de la mascara debe ser de 12 digitos '+
				'y  el numero final sea mayor a cero</p> ';
				Swal({
					type: 'error',
					title: 'Longitud ',
					html: ''+errores,
					allowOutsideClick: false,
					footer: '<a id="enlace"  target="_blank"></a>'
				});

			}
		}else{
			Swal({
				type: 'error',
				title: 'Formatos',
				html: 'Los campos solo pueden contener numeros',
				allowOutsideClick: false,
				footer: '<a id="enlace"  target="_blank"></a>'
			});
		}
	}else{

		Swal({
			type: 'warning',
			title: 'Campor vacios',
			html: 'Favor de llenar todos los campos',
			allowOutsideClick: false,
			footer: '<a id="enlace"  target="_blank"></a>'
		});
	}



}


function decision_reactivar(texto,tipo,cancelado,estatus) {
	// body...
	if(cancelado == "V"){


		Swal({
			title: 'Reactivar mascara',
			html: ""+texto+"<br> ¿Deseas reactivarla?",
			type: ''+tipo,
			showCancelButton: true,
			confirmButtonColor: '#007BFF',
			cancelButtonColor: '#6C757D',
			confirmButtonText: 'Si, reactivar',
			allowOutsideClick: false,
			cancelButtonText:"Cancelar"
		}).then((result) => {
			if (result.value) {
				mascara=$("#mascara_new").val();
				reactivar_mascaras(mascara);

			}
		})
	}else{
		Swal({
			type: 'info',
			title: " Mascaras",
			html: ''+texto+'<br> la puedes elegir como predeterminada para usarla',
			allowOutsideClick: false,
			footer: '<a id="enlace"  target="_blank"></a>'
		});
	}
}

function modal_excel(id) {
	// body...


	var noclie  = $("#noclie"+id).val();
	var nombre  = $("#nombrecliente1"+id).val();
	var tipo = $("#tipoCliente"+id+" option:selected").val();
	$("#id_excel").val(noclie);
	$("#nombre_excel").val(nombre);
	$("#tipoCli_excel").val(tipo)
	


	parametro={"id" : noclie,
	"opcion":"regenerador_excel"};




	$.ajax({
		type:"POST",
		url:"../../herramientas/metHerramientas/DirMascara.php",
		data:parametro,
		success:function(respuesta){
			console.log(respuesta);
			jsonObj = JSON.parse(respuesta);

			var select_usadas=document.getElementById("mascaras_usadas");;
			var select_inicial=document.getElementById("tar_inicial");
			var select_final=document.getElementById("tar_final");

			
			var mascaras =[];
			var tarjetas =[];
				   //eliminar lo que tiene el selected para que no se duplique
				   while (select_usadas.firstChild) {
				   	select_usadas.removeChild(select_usadas.firstChild);
				   }

				   while (select_inicial.firstChild) {
				   	select_inicial.removeChild(select_inicial.firstChild);

				   }
				   while(select_final.firstChild){
				   	select_final.removeChild(select_final.firstChild);
				   }

				   var tipos = Object.keys(jsonObj["mascaras"]);
				   var all_tarjetas = Object.keys(jsonObj["tarjetasArray"]);
				   var elegir=document.createElement("option");
				   elegir.setAttribute("value" ,"");
				   elegir.setAttribute("label","Eligir una mascara");
				   elegir.text="Eligir una mascara";
				   select_usadas.appendChild(elegir);
				   tipos.forEach(function(tipo){
				   	mascaras.push(jsonObj["mascaras"][tipo]);	
				   	var usada=document.createElement("option");
				   	usada.setAttribute("value",jsonObj["mascaras"][tipo]);
				   	usada.setAttribute("label",jsonObj["mascaras"][tipo]);
				   	usada.text=jsonObj["mascaras"][tipo];

				   	select_usadas.appendChild(usada);

				   });

				   mascara_seleccionada =$("#mascaras_usadas option:selected").val();
				    // all_tarjetas.forEach(function(row) {
				    // 	// body...
				    // 	tarjetas.push(jsonObj["tarjetasArray"][row]);
				    // });

				    lista ={"tarjetas":tarjetas};
				    $('#mascaras_usadas').attr('onchange',"filtro_por_mascara('"+jsonObj["tarjetasArray"]+"')");



				}
			});
}
function filtro_por_mascara(lista) {
	// body...s
					// parametro = JSON.parse(lista);
					mascara_seleccionada =  $("#mascaras_usadas option:selected").val();
					sublista=lista.split("||");
					sublista.sort();
					var select_inicial=document.getElementById("tar_inicial");
					var select_final=document.getElementById("tar_final");

					while (select_inicial.firstChild) {
						select_inicial.removeChild(select_inicial.firstChild);

					}
					while(select_final.firstChild){
						select_final.removeChild(select_final.firstChild);
					}
					// sublista.pop();
					for(i=0; i<sublista.length; i++)
					{
 					 // aparece =sublista[i].indexOf(mascara_seleccionada);
 					 if(mascara_seleccionada == sublista[i].substring(0, 12))
 					 {
 					 	var filtradas_ini=document.createElement("option");
 					 	var filtradas_fin =document.createElement("option");

 					 	filtradas_ini.setAttribute("value",sublista[i]);
 					 	filtradas_ini.setAttribute("label",sublista[i]);
 					 	filtradas_ini.text=sublista[i];

 					 	filtradas_fin.setAttribute("value",sublista[i]);
 					 	filtradas_fin.setAttribute("label",sublista[i]);
 					 	filtradas_fin.text=sublista[i];


 					 	select_inicial.appendChild(filtradas_ini);
 					 	select_final.appendChild(filtradas_fin);
 					 }
 					}
 				}

 				function datos_excel() {
 	// body...
 	inicio =   $("#tar_inicial option:selected").val();
 	fin =  $("#tar_final option:selected").val()
 	

 	subIni =parseInt(inicio.substr(12,15));
 	subfin =parseInt(fin.substr(12,15));

 // alert(subIni+" "+ subfin)

 if(subIni <= subfin){
 	var noclie  = $("#id_excel").val();
 	var nombre  =$("#nombre_excel").val();
 	var tipo = $("#tipoCli_excel").val();
 	if(tipo == "Credito"){ tipo="CR"} else if(tipo == "Prepago"){tipo="PP"} else if(tipo == "CONTADO"){tipo ="CO"}

 		parametro={"id" : noclie,
 	"opcion":"regenerador_excel"};

 	$.ajax({
 		type:"POST",
 		url:"../../herramientas/metHerramientas/DirMascara.php",
 		data:parametro,
 		success:function(respuesta){

 			jsonResp = JSON.parse(respuesta);
 			mascara_seleccionada =  $("#mascaras_usadas option:selected").val();
 			arTar = jsonResp["tarjetasExcel"].split("||");
 			arNips = jsonResp["nipsExcel"].split("||");
							// arPlacas = jsonResp["placasExcel"].split("||");
							listaTarjetas ="";
							listaNips="";
							placas=[];
							choferes=[];
							economico=[];
							
							// listaplacas="";

							// console.log(arTar);
							// console.log(arNips);
							for(i=0; i<arTar.length; i++)
							{
								familia=arTar[i].indexOf(mascara_seleccionada);
								if(familia > -1){
									dato = arTar[i].substr(12,15);
									datocr =parseInt(dato);
									
									if( (datocr == subIni || datocr > subIni)  && datocr <= subfin)
									{
										console.log(datocr);
										listaTarjetas+=arTar[i]+"||";
										listaNips+=arNips[i]+"||";
										placas.push(jsonResp["placas"][i]);
										choferes.push(jsonResp["choferes"][i]);
										economico.push(jsonResp["economico"][i]);
										
										
									}
								}
							}
							// console.log(listaTarjetas);
							// console.log(listaNips);
							// console.log(placas);
							window.open("../webClientes/regenerarExcel.php?tarjetas="+listaTarjetas+"&nips="+listaNips+"&nombre="+nombre+"&noclie="+noclie+"&usuario="+jsonResp["empleado"]+"&placas="+placas+"&choferes="+choferes+"&economico="+economico+"&tipo_cliente="+tipo+"", "_blank");
						}
					});
 }else{
 	Swal({type: 'error',title: 'Longitud ',html: '<p style="  font-weight: bold; color:#F27474"> El tarjeta inicial no puede ser mayor a la final <p>'
 		,allowOutsideClick: false,
 		footer: '<a id="enlace"  target="_blank">Para cualquie duda llamar a sistemas</a>'});

 }

}

function reactivar_mascaras(mascara ="") {
	// body...
	mascara =   $("#listaMascaras_canceladas option:selected").val();
	parametro ={"mascara":mascara,
	"opcion":"reactivar_mascaras"}
	$.ajax({
		type:"POST",
		url:"../metHerramientas/DirMascara.php",
		data:parametro,
		success:function(respuesta){
			console.log(respuesta);
			subDatos = respuesta.split("**");
			Swal({ 
				type: ''+subDatos[0],
				title: 'Reactivacion de mascaras',
				html: ''+subDatos[1],
				allowOutsideClick: false,
				footer: '<a id="enlace"  target="_blank"></a>'
			}).then((result) => {
				if (result.value) {
					recargar_accordion();
				}
			})
		}
	});
}

function recargar_accordion() {
 	// body...
 	location.reload();
 	// $("#formulario_mascaras").empty();
 	// $("#formulario_mascaras").load("Herramientas.php");
 }

