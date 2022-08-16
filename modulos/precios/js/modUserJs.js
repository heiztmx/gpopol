 function obtenerDatos(datos){


	datos2= datos.split('||');
$('#idUsuario').val(datos2[0]);
$('#nombremodalm').val(datos2[1]);
$('#usuariomodalm').val(datos2[2]);
$('#priv1m').val(datos2[3]);
$('#passwordmodalm').val(datos2[4]);
$('#autorizom').val(datos2[5]);

 }








 function obtenerDatosEliminar(datosEliminar){
 recibido = datosEliminar.split('||');
 $('#IdUsuariombs').val(recibido[0]);
 $('#nombrembs').val(recibido[1]);
 $('#usuariombs').val(recibido[2]);
swal({

title:"¿Seguro que desea Borrar a este usuario?",
text:"una vez eliminado el usuario "+$('#nombrembs').val()+ "  no se recuperara",
buttons:true,
dangerMode:true,
})
.then((usuarioborrado) => {
 if (usuarioborrado) {
  var id=$("#IdUsuariombs").val();
 var parametros ={"idusuario":id}
 
 $.ajax({
          type:'POST',
          url: '../webprecios/eliminarUsuario.php',
          data:parametros,
          success:function(eliminado){
            if (eliminado =="Eliminado") {

              swal("Usuario Eliminado",{icon:"success",})
              .then((EliUsuario) => {
                if(EliUsuario){
                   setTimeout("location.href = 'listadoxUsuarios.php'",0); 
                }else{
                setTimeout("location.href = 'listadoxUsuarios.php'",2000);
                }

              });
               
            }else{
              swal("Poof!, Hubo un problema llamar a sistemas :(",{icon :"error"});
            }
          }
}); //fin del ajax
 return false;
 }else{
//podria ir un mensaje
 }
});

}












// $(document).ready(function(){
//  $("#btnsimbs").click(function(){
//   var id=$("#IdUsuariombs").val();
//  var parametros ={
//   "idusuario":id
//         }
//         $.ajax({
//           type:'POST',
//           url: '../webprecios/eliminarUsuario.php',
//           data:parametros,
//           success:function(eliminado){
//               if (eliminado === "Eliminado") {
//                  alertify.success('Eliminacion Exitosamente');
//                  setTimeout("location.href = 'listadoxUsuarios.php'",2000);
//                  $("modalborrarUs").css({"display":"none"});
//                }else{
//                 // $("#erroreliminarUsuario").html(eliminado);
//                  alertify.error("No se pudo Eliminar el usuario llamar a sistemas   :( ");
//                }
//           }
//         }); //fin del ajax;
//         return false;
//     });
// });




$(document).ready(function(){
$("#aceptarUsuariom").click(function(){
var tipo =$('input:radio[name=privilegio]:checked').val();
var usuario=$('#usuariomodalm').val();
var password=$('#passwordmodalm').val();
var nombre=$('#nombremodalm').val();
var idUsuario=$('#idUsuario').val();

 var parametros = {
      "idUsuario": idUsuario,
        "tipo" : tipo,
         "usuario" : usuario,
          "password" : password,
          "nombre" : nombre
      }

$.ajax({
 	type:'POST',
 	url:'../webprecios/modUser.php',
 	data:parametros,
 	success:function(respuesta){
 		 if (respuesta === "modificado") {
        alertify.success('Modificacion Exitosamente');
      
        setTimeout("location.href = 'listadoxUsuarios.php'",2000);
      }else{
      	// $('#erormu').html(respuesta);
      	 alertify.error("No se pudo modificar el usuario llamar a sistemas   :( ");
      	
      }
 	}
});
return false;
	});
});

