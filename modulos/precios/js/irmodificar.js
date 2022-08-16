

function VerificacionHora1() {
    fechacompleta = document.getElementById("date3").value;

    paraHora={
    "hora":fechacompleta}

$.ajax({
   type:'POST',
   url:'../webprecios/VerificacionHora.php',
   data:paraHora,
   success:function (respuesta) {
       if (respuesta === "Adelante") {
        confirmarModificacion();
       }else{
        Swal('Verificacion de Hora','Elija otra hora esta ya fue usada para esta fecha',"warning");
        
   }
  }
});
 return false;
}





function  confirmarModificacion(){


 
    var folio =$("#folio").val();
    var fecha =$("#date3").val();
    var estacion =$("#estacion").val();
    var magna=$("#magna1").val();
    var premium=$("#premium1").val();
    var diesel=$("#diesel1").val();
    var usuario=$("#usuario").val();

      if (magna != "" && premium != "" && diesel != "" && fecha != "") {

              $("#foliomodal").val(folio);
              $("#fechamodal").val(fecha);
              $("#estacionmodal").val(estacion);
              $("#magnamodal").val(magna);
              $("#premiummodal").val(premium);
              $("#dieselmodal").val(diesel);
              
              $("#btn_modalM").trigger("click");


      }else{
                 Swal({
  type: 'error',
  title: 'Oops...',
  text: 'Debes de llenar todos los datos',
  

})
      }

}

function Modificacion() {
 var folio =$("#foliomodal").val();
    var fecha =$("#fechamodal").val();
    var estacion =$("#ipEstacion").val();
    var magna=$("#magnamodal").val();
    var premium=$("#premiummodal").val();
    var diesel=$("#dieselmodal").val();
     var usuario=$("#usuario").val();

     $("#tachamod").css({"display" : "none"});
     $("#btnCancelarModalm").css({"display" : "none"});
     $("#btnEnviarModalm").css({"display" : "none"});

  var parametros ={
    "folio":folio,
     "date3":fecha,
    "magna":magna,
    "premium":premium,
    "diesel":diesel,
   "usuario":usuario,
   "Est":estacion
    }
    $("#loader").css({"display" : "inline"});
    $.ajax({
      type:'POST',
      url:'../webprecios/modPrecios.php',
      data:parametros,
      success:function(resultado){
        arregloDeSubCadenas = resultado.split(" ");

       
        if (arregloDeSubCadenas[0] === "Actualizado") {

          $("#errorFatalM").css({"color": "green"})
          $("#errorFatalM").html("Los precios fueron Actualizados Exitosamente");
          $("#loader").css({"display" : "none"});
          $("#imagen").attr("src", "../imagenes/v01.png");
          $("#imagen" ).css({ "display": "inline" });
          $("#btnOK").css({"display" : "inline"});
        }else{

          $("#loader").css({"display" : "none"});
          $("#imagen").attr("src", "../imagenes/x01.png");
          $("#imagen" ).css({ "display": "inline" });
          $("#errorFatalM").css({"color": "red"});
          $("#errorFatalM").html(""+resultado);
          $("#btnOK").css({"display" : "inline"});
        }
      }
    }); //fin del ajax
    return false;
}



function clear_interface_update() {
    $("#tachamod").css({"display" : "inline"});
    $("#btnCancelarModalm").css({"display" : "inline"});
    $("#btnEnviarModalm").css({"display" : "inline"});
    $("#btnOK").css({"display" : "none"});

    $("#loader").css({"display" : "none"});
    $("#imagen").attr("src", "");
    $("#errorFatalM" ).html("");
   var folio =$("#foliomodal").val();
    var fecha =$("#fechamodal").val();
    var estacion =$("#ipEstacion").val();
    var magna=$("#magnamodal").val();
    var premium=$("#premiummodal").val();
    var diesel=$("#dieselmodal").val();
     var usuario=$("#usuario").val();

     folio="";
     fecha="";
     estacion ="";
     magna="";
     premium="";
     diesel="";
     usuario="";
}


function mostrarCalendario() {
  // body...
  $("#calTem").css({"display": "none"});

 $("#date3").trigger("click");
  $("#date3").css({"display":"inline"});

}

//  $( document ).ready(function() 
//  {


// $("#magna1").on({
//   "focus": function(event) {
//     $(event.target).select();
//   },
//   "keyup": function(event) {
//     $(event.target).val(function(index, value) {
//       return value.replace(/\D/g, "")
//         .replace(/([0-9])([0-9]{2})$/, '$1.$2')
//         .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
//     });
//   }
// });

// $("#premium1").on({
//   "focus": function(event) {
//     $(event.target).select();
//   },
//   "keyup": function(event) {
//     $(event.target).val(function(index, value) {
//       return value.replace(/\D/g, "")
//         .replace(/([0-9])([0-9]{2})$/, '$1.$2')
//         .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
//     });
//   }
// });


// $("#diesel1").on({
//   "focus": function(event) {
//     $(event.target).select();
//   },
//   "keyup": function(event) {
//     $(event.target).val(function(index, value) {
//       return value.replace(/\D/g, "")
//         .replace(/([0-9])([0-9]{2})$/, '$1.$2')
//         .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
//     });
//   }
// });

// });