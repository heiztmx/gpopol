



// $(document).ready(function(){
// 	$('body').keyup(function(e) {
// 		if(e.which == 13){
// 		//ejecuto algo
// buscador_clientes_modi();
// 		}
// 	});
// 	});

// function ModificacionClientes() {
 
//  nombre  = $("#nombrecli").val();
//  calle  =$("#callecli").val();
//  numExt=$("#numeroExtcli").val();
//  numInt =$("#numeroIntcli").val();
//  cp =$("#cpcli").val();
//  contacto =$("#contactocli").val();
//  correo =$("#correocli").val();
//  metodoPago =$("#metodopagocli option:selected").val();
// activo  =$("#activocli").val();
// noclie =$("#noclie").val();

// parametros ={
//  "nombre": nombre,
//  "calle": calle,
//  "numExt":numExt,
//  "numInt":numInt,
//  "cp": cp,
//  "contacto":contacto,
//  "correo":correo,
//  "metodoPago":metodoPago,
//  "activo":activo,
//  "noclie":noclie

// }

// if (nombre != ""){
// 	  $.ajax({
//           type:'POST',
//           url: '../webClientes/modificarClientes.php',
//           data:parametros,
//           success:function(resultado){
//             console.log(eliminado);
//               if (eliminado === "modificado") {
//             Swal("Datos Actualizados", {
//           icon: "success",})
//              .then((aceptar) =>{
//               if(aceptar){
//                   $("#CargadorClienteCreditos").load("limClientesCredito.php");
//                 // setTimeout("location.href = 'listado.php'",2000);
//               }
//             });
            
               
//                }else{
//            Swal.fire({
// 			  type: 'error',
// 			  title: 'Error',
// 			  html: 'No se pudieron modificar los datos del cliente <br>'+nombre,
// 			  footer: '<a href ="#">Si el problema persiste favor de llamar al departamento de sistemas</a>'
// 			})
//                }


//           }
//         });
// }


//   function buscador_clientes_modi() {
//   // body...

                                      
//               //obtenemos el texto introducido en el campo de búsqueda
//               consulta = $("#bCR").val();
          
//               //hace la búsqueda
//               parametro={
//                 "nombre":consulta
//               }                                                                                  
//               $.ajax({
//                     type: "POST",
//                     url: "../webClientes/buscadorModificacion.php",
//                     data: parametro,
//                     dataType: "html",
//                     beforeSend: function(){
//                     //imagen de carga
//                     $("#tablaBusqueda").html("<div  id='loader' class='preloader mx-auto'></div>");
//                     },
//                     error: function(){
//                     Swal({type: 'error',title: 'Oops...',text: 'Algo salio mal con la busqueda',footer: '<a href ="#">Recarga la pagina si el problema persiste llamar a sistemas</a>'})
//                     },
//                     success: function(data){                                                    
//                     $("#tablaBusqueda").empty();
//                     $("#tablaBusqueda").append(data);                                                             
//                     }
//               });                                                                         
//       