function BorrarFacturacion(datos) {
	subDatos = datos.split("||");
	 fecha =subDatos[4];
	estacion =subDatos[3]

// busqueda_pre()
					 Swal({
				  title: 'Precios Facturacion',
				  text: "¿Seguro que deseas eliminar estos precios?",
				  type: 'warning',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  cancelButtonColor: 'Si,Eliminarlo!'
				}).then((result) => {
				  if (result.value) {
				  		 parametros={"fecha":fecha, "estacion":estacion};
						 $.ajax({
						 	type:'POST',
						 	url:'../webprecios/borrarFactura.php',
						 	data:parametros,
						 	success:function(respuesta) {
						 		
						 		 if (respuesta === "Borrado") {

					              Swal({ type: 'success', title: 'Precios de factura Eliminados Existosamente', showConfirmButton: true });
					              setTimeout(tablaFactura(), 3000);

					              } else{
					                Swal({ type: 'info', title: 'Error', text: ''+respuesta, footer: '<a></a>' });
					                      setTimeout(tablaFactura(), 3000);
					                 }
						 	}
						 });
	 						return false;
				  }
				})



}


function buscarFacturaFecha() {
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable #tabla_factura").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
}

     function tablaFactura() {
      
      
       var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
      document.getElementById("cargador").innerHTML =
      this.responseText;
    }
      };
      xhttp.open("GET", "ListaFacturacion.php", true);
      xhttp.send();   
         
       
         }