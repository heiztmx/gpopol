// function bloquearEstaciones(estaciones) {
 





function bloquearEstaciones(Estaciones) {
  // alert(cadena)
  cadena = Estaciones;
  separador = "||", 
    subEstaciones = cadena.split(separador);
  




if ($("#todos1").prop('checked') )
      {
          for(i=0;  i<subEstaciones.length; i++){
            $("#Estacion" +subEstaciones[i]).prop("disabled", true);
              $("#Estacion"+subEstaciones[i]).prop("checked", false);
          }
      
}else{
  for(i=0;  i<subEstaciones.length; i++){
            $("#Estacion" +subEstaciones[i]).prop("disabled", false);
             
          }
      
 }


     

}
// if (document.getElementById(subEstaciones[i]).disabled
//     $("#Estacion"+subEstaciones[i].prop("checked")))
//       {
//       document.getElementById(subEstaciones[i]).disabled = false;
// }else{
//       document.getElementById(subEstaciones[i]).disabled = true;
//       document.getElementById(subEstaciones[i]).checked = false;
//  }

// }
     

// }

function bloquearTodo(Estaciones){
 var cadena = Estaciones;
  separador = "||", 
  subEstaciones = cadena.split(separador);

for(z=0; z<subEstaciones.length; z++){

    if ( $("#Estacion"+subEstaciones[z]).prop('checked') ) {
   document.getElementById("todos1").disabled = false;
   $("#todos1").prop("checked", false);
   break;
  }
  else 
  {
   document.getElementById("todos1").disabled=false;
  }

}


}

// $('#'+subEstaciones[z]).prop('checked')  || $('#'+subEstaciones[z]).prop('checked')

// function bloquearTodo(Estaciones){
//  var cadena = Estaciones;
//   separador = "||", 
//   subEstaciones = cadena.split(separador);

  
// if ( $('#poli1').prop('checked')|| $('#side1').prop('checked')  || $('#peri1').prop('checked') || $('#uman1').prop('checked')) {
//    document.getElementById("todos1").disabled = true;

//  }
//  else if($('#poli1').prop('checked',false) &&  $('#side1').prop('checked',false)  &&  $('#peri1').prop('checked',false) &&  $('#uman1').prop('checked',false))

//  {
//    document.getElementById("todos1").disabled=false;

// }

// }