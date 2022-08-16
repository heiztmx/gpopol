
// -----------------------------------------------------------
function obtenerDatosprecios(precios){
  recibidoPrecios = precios.split('||');
  $("#foliomd").val(recibidoPrecios[0]);
  $("#fechamd").val(recibidoPrecios[1]);
  $("#horamd").val(recibidoPrecios[2]);
  $("#estacionmd").val(recibidoPrecios[8]);
  $("#magnamd").val(recibidoPrecios[3]);
  $("#premiummd").val(recibidoPrecios[4]);
  $("#dieselmd").val(recibidoPrecios[5]);
  var ip = recibidoPrecios[9];

  swal({
    title: "¿Desea borrar este registro?",
    text: "una vez borrado no podra recuperar el folio :"+ $("#foliomd").val(),
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {

     var folio=$("#foliomd").val();
     var parametros ={"folio":folio, "ip":ip}
     $.ajax({
      type:'POST',
      url: '../webprecios/eliminarPrecios.php',
      data:parametros,
      success:function(eliminado){
        if (eliminado === "Eliminado") {
          swal("Registro eliminado", {
            icon: "success",})
          .then((aceptar) =>{
            if(aceptar){
              setTimeout("location.href = 'general.php'",0);
            }else{
              setTimeout("location.href = 'general.php'",2000);
            }
          });
          
          $("#modalborrarprs").css({"display":"none"});
        }else{
          swal("Poof! Hubo un error al querer borrar llama a sistemas :(", {
            icon: "error",});
        }


      }
        }); //fin del ajax;
     return false;
     
   } else {
  // swal("Hubo un error al querer borrar llama a sistemas :(",{
  //         icon: "error",});
}
});

}