


function desbloqueoMonto(datos) {
	// body...
setTimeout(bloqueartodo(datos),2000);
	var subDatos = datos.split("||");

	$("#montoCredito"+subDatos[0]).prop("disabled",false);
	$("#montoCredito"+subDatos[0]).trigger("click");
	$("#montoCredito"+subDatos[0]).focus();
	$("#guardarMonto"+subDatos[0]).css({"display" : "inline"});
	$("#modificarMonto"+subDatos[0]).css({"display" : "none"});
	

}

function cambioCredito(datos) {
	subDatos = datos.split("||");
	alert("Monto modificado");
}



function bloqueartodo(datos) {
	subDatos = datos.split("||");
	$("#montoCredito"+subDatos[0]).prop("disabled",true);
	
	
	$("#guardarMonto"+subDatos[0]).css({"display" : "none"});
	$("#modificarMonto"+subDatos[0]).css({"display" : "line"});
	// body...
}
