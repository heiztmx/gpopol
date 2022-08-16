// 
function VerificarSINO(DPoli){
	preciosPoli = DPoli.split('||');


          IP = preciosPoli[8];
         folio =preciosPoli[0];

        
        swal({
  title: "¿Desea borrar este registro?",
  text: "una vez borrado no podra recuperar el folio: "+$("#foliomd").val(),
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {

    // var folio=$("#foliomd").val();
    var parametros ={"folio":folio,
    "ip" :IP}
        $.ajax({
          type:'POST',
          url: '../webprecios/eliminarPrecios.php',
          data:parametros,
          success:function(eliminado){
            console.log(eliminado)
              if (eliminado === "Eliminado") {
            swal("Registro Eliminado", {
          icon: "success",})
             .then((aceptar) =>{
              if(aceptar){
                setTimeout("location.href = 'listado.php'",0);
              }else{
                setTimeout("location.href = 'listado.php'",2000);
              }
            });
            
                 $("#modalborrarprs").css({"display":"none"});
               }else{
                swal(eliminado+" :(", {
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




 // puede servir mas adelante es lo sweetAlert 


// function obtenerDatosSIDE(Dside){
// preciosSide = Dside.split('||');
//   $("#foliomd").val(preciosSide[0]);
//    $("#fechamd").val(preciosSide[1]);
//     $("#horamd").val(preciosSide[2]);
//      $("#estacionmd").val(preciosSide[8]);
//       $("#magnamd").val(preciosSide[3]);
//        $("#premiummd").val(preciosSide[4]);
//         $("#dieselmd").val(preciosSide[5]);

//         swal({
//   title: "¿Desea borrar este registro?",
//   text: "una vez borrado no podra recuperar el folio: "+$("#foliomd").val(),
//   icon: "warning",
//   buttons: true,
//   dangerMode: true,
// })
// .then((willDelete) => {
//   if (willDelete) {

//     var folio=$("#foliomd").val();
//     var parametros ={"folio":folio}
//         $.ajax({
//           type:'POST',
//           url: '../webprecios/eliminarPrecios.php',
//           data:parametros,
//           success:function(eliminado){
//               if (eliminado === "Eliminado") {
//             swal("Registro Eliminado", {
//           icon: "success",}) 
//             .then((aceptar) =>{
//               if(aceptar){
//                 setTimeout("location.href = 'listado.php'",0);
//               }else{
//                 setTimeout("location.href = 'listado.php'",2000);
//               }
//             });
            
//                  $("#modalborrarprs").css({"display":"none"});
//                }else{
//                 swal("Poof! Hubo un error al querer borrar llama a sistemas :(", {
//           icon: "error",});
//                }


//           }
//         }); //fin del ajax;
//         return false;
   
//   } else {
//   // swal("Hubo un error al querer borrar llama a sistemas :(",{
//   //         icon: "error",});
//   }
// });

// }
// function obtenerDatosUMAN(DUman){
//  preciosUman = DUman.split('||');
// $("#foliomd").val(preciosUman[0]);
//    $("#fechamd").val(preciosUman[1]);
//     $("#horamd").val(preciosUman[2]);
//      $("#estacionmd").val(preciosUman[8]);
//       $("#magnamd").val(preciosUman[3]);
//        $("#premiummd").val(preciosUman[4]);
//         $("#dieselmd").val(preciosUman[5]);
//         swal({
//   title: "¿Desea borrar este registro?",
//   text: "una vez borrado no podra recuperar el folio: "+$("#foliomd").val(),
//   icon: "warning",
//   buttons: true,
//   dangerMode: true,
// })
// .then((willDelete) => {
//   if (willDelete) {

//     var folio=$("#foliomd").val();
//     var parametros ={"folio":folio}
//         $.ajax({
//           type:'POST',
//           url: '../webprecios/eliminarPrecios.php',
//           data:parametros,
//           success:function(eliminado){
//               if (eliminado === "Eliminado") {
//             swal("Registro Eliminado ", {
//           icon: "success",})
//              .then((aceptar) =>{
//               if(aceptar){
//                 setTimeout("location.href = 'listado.php'",0);
//               }else{
//                 setTimeout("location.href = 'listado.php'",2000);
//               }
//             });
            
//                  $("#modalborrarprs").css({"display":"none"});
//                }else{
//                 swal("Poof! Hubo un error al querer borrar llama a sistemas :(", {
//           icon: "error",});
//                }


//           }
//         }); //fin del ajax;
//         return false;
   
//   } else {
//   // swal("Hubo un error al querer borrar llama a sistemas :(",{
//   //         icon: "error",});
//   }
// });
// }

// function obtenerDatosPERI(DPeri){
//  preciosPeri = DPeri.split('||');
// $("#foliomd").val(preciosPeri[0]);
//    $("#fechamd").val(preciosPeri[1]);
//     $("#horamd").val(preciosPeri[2]);
//      $("#estacionmd").val(preciosPeri[8]);
//       $("#magnamd").val(preciosPeri[3]);
//        $("#premiummd").val(preciosPeri[4]);
//         $("#dieselmd").val(preciosPeri[5]);
//         swal({
//   title: "¿Desea borrar este registro?",
//   text: "una vez borrado no podra recuperar el folio: "+$("#foliomd").val(),
//   icon: "warning",
//   buttons: true,
//   dangerMode: true,
// })
// .then((willDelete) => {
//   if (willDelete) {

//     var folio=$("#foliomd").val();
//     var parametros ={"folio":folio}
//         $.ajax({
//           type:'POST',
//           url: '../webprecios/eliminarPrecios.php',
//           data:parametros,
//           success:function(eliminado){
//               if (eliminado === "Eliminado") {
//             swal("Registro Eliminado!", {
//           icon: "success",})
//             .then((aceptar) =>{
//               if(aceptar){
//                 setTimeout("location.href = 'listado.php'",0);
//               }else{
//                 setTimeout("location.href = 'listado.php'",2000);
//               }
//             });
            
//                  $("#modalborrarprs").css({"display":"none"});
//                }else{
//                 swal("Poof! Hubo un error al querer borrar llama a sistemas :(", {
//           icon: "error",});
//                }


//           }
//         }); //fin del ajax;
//         return false;
   
//   } else {
//   // swal("Hubo un error al querer borrar llama a sistemas :(",{
//   //         icon: "error",});
//   }
// });
// }