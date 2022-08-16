function elegirOpcion(){
var opcion =document.getElementById("opciones").value;

if (opcion == "PP"){
  // document.getElementById('boton').onclick="buscar_folio()";
   
  $("#bPP").css({"display":"inline"});
  $("#bCR").css({"display":"none"});
  $("#bCO").css({"display":"none"});
}
if(opcion == "CR"){
  // document.getElementById('boton').onclick="buscar_estacion()";

  $("#bCR").css({"display":"inline"});
   $("#bPP").css({"display":"none"});
   $("#bCO").css({"display":"none"});
}
if (opcion == "CO") {

$("#bCO").css({"display":"inline"});
  $("#bPP").css({"display":"none"});
   $("#bCR").css({"display":"none"});
}




}


function ocultarMontoCredito(id) {
  var opcion =document.getElementById("tipoCliente"+id).value;
  switch(opcion) {
  case "PP":
  $("#grupoFac"+id).val("3");

      $("#tituloCredito"+id).css({"display" : "none"});
      $("#Clienteprepago"+id).css({"display" : "inline"});
       $("#contenedorcredito"+id).css({"display" : "inline"});
    break;
  case "CR":
  $("#grupoFac"+id).val("2");
        $("#tituloCredito"+id).css({"display" : "inline"});
        $("#Clienteprepago"+id).css({"display" : "none"});
        $("#contenedorcredito"+id).css({"display" : "inline"});
    break;
  case "CO":
  $("#grupoFac"+id).val("1");

          $("#tituloCredito"+id).css({"display" : "none"});
        $("#Clienteprepago"+id).css({"display" : "none"});
        $("#contenedorcredito"+id).css({"display" : "none"});
        break;
      }
}

function tipoCT(id) {


  var factura = $("#grupof"+id).val(); //123
  var tipoCliente = $("#tipoc"+id).val(); //PP CR CO
  var metodoPag = $("#metodopagDEF"+id).val();


  // alert(factura);
  // alert(tipoCliente);
  switch(tipoCliente) {
  case "PP":
      $("#tituloCredito"+id).css({"display" : "none"});
      $("#Clienteprepago"+id).css({"display" : "inline"});
       $("#contenedorcredito"+id).css({"display" : "inline"});
    break;
  case "CR":
        $("#tituloCredito"+id).css({"display" : "inline"});
        $("#Clienteprepago"+id).css({"display" : "none"});
        $("#contenedorcredito"+id).css({"display" : "inline"});
    break;
  case "CO":
          $("#tituloCredito"+id).css({"display" : "none"});
        $("#Clienteprepago"+id).css({"display" : "none"});
        $("#contenedorcredito"+id).css({"display" : "none"});
        break;
      }


    // if(tipoCliente == "CR" )
    // {
    //    $("#tituloCredito").css({"display" : "inline"});
    //   $("#contenedorcredito").css({"display" : "inline"});
    // }else{
    //   $("#contenedorcredito").css({"display" : "none"});
    //   $("#tituloCredito").css({"display" : "none"});
      
    // }

  $("#grupoFac"+id+" option[value="+factura+"]").attr("selected",true);
  $("#tipoCliente"+id+" option[value="+tipoCliente+"]").attr("selected",true);
  // if (metodoPag != "" || metodoPag != null){
  //    $("#formapagodefault"+id+" option[value="+metodoPag+"]").attr("selected",true);
  //  }else{
     
  //  }


}