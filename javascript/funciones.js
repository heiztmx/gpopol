function eliminar(identificador,controlador){
	if (confirm("¿Realmente desea eliminar este registro? "+controlador))
	{
		window.location="?accion="+controlador+"&id="+identificador;
	}
}