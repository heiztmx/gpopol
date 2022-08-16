

// $(document).ready(function(){   
//  });


    
function elegirOpcion1(){
var opcion =document.getElementById("opciones").value;

if (opcion == "1"){
  // document.getElementById('boton').onclick="buscar_folio()";
    folio =$('#caja-buscar').val();
   opcion1 =1;
  document.getElementById('boton').setAttribute( "onclick","buscar_folio(opcion1,folio);");
}
if(opcion == "2"){
  // document.getElementById('boton').onclick="buscar_estacion()";
   estacion =$('#caja-buscar').val();
  opcion =2;
  document.getElementById('boton').setAttribute( "onclick","buscar_estacion();");
}
if (opcion == "3") {
   fecha =$('#caja-fecha').val();
  opcion =2;
document.getElementById('boton').setAttribute( "onclick","buscar_fecha(opcion,fecha);");
}
if(opcion == "4"){
  estacion  = $("#caja-fecha");
  fecha =$("#caja-fecha");
  opcion =4;
  document.getElementById('boton').setAttribute("onclick","buscar_fecha_estacion(opcion,fecha,estacion);");
}

// if(opcion == "5"){
  
//   document.getElementById('boton').setAttribute("onclick","buscar_usuario_estacion();");

// }
if(opcion == "6"){

  var fecha =$("#caja-fecha").val();
  opcion = 6;
  document.getElementById('boton').setAttribute("onclick","buscar_aplicados_fecha(opcion,fecha);");
}

if(opcion == "7"){
  var estacion =$("#caja-estacion");
  opcion =7;
  document.getElementById('boton').setAttribute("onclick","buscar_aplicados_estacion(opcion,estacion);");
}

}




function buscar_folio(opcion,folio){
 folio = $("#caja-folio").val();
  var  parametros ={
    "folio":folio,
    "opcion":opcion
  }
  $.ajax({
    url :"../buscador/buscador_general.php",
    type:'POST',
    dataType:'html',
    data:parametros,
  })

  .done(function(respuesta){
   if (respuesta === "Sin_Resultados") {
      swal({
  title: "¡Aviso!",
  text: "¡No se encontraron Registros con los datos proporcionados!",
  icon: "warning",
  button: "Aceptar!",
});

    }else{
       $("#tabla-mostrar").html(respuesta);
    }
    
  })
  .fail(function(){
    // console.log("error");

  });

}



function buscar_estacion(opcion,estacion){
estacion = $("#caja-estacion").val();
  
  var parametros ={
    "estacion":estacion,
    "opcion":opcion }
    $.ajax({
    url :"../buscador/buscarEstacion.php",
    type:'POST',
    dataType:'html',
    data:parametros,
  })
.done(function(respuesta){
    $("#tabla-mostrar").html(respuesta);

  })
  .fail(function(){
    console.log("error");
  });
  }

function buscar_fecha(opcion,fecha){

  
  var parametros ={
    "fecha":fecha,
    "opcion":opcion}
    $.ajax({
    url :"../buscador/buscarFecha.php",
    type:'POST',
    data:parametros, 
})
   .done(function(respuesta){

    $("#tabla-mostrar").html(respuesta);

  })
  .fail(function(){
    console.log("error");
  });
  }



function buscar_fecha_estacion(opcion,fecha,estacion){
   var fecha = $("#caja-fecha").val();
   var estacion= $("#caja-estacion").val();

   var parametros ={
    "fecha":fecha,
    "estacion":estacion,
    "opcion":opcion
   }
   $.ajax({
    url:"../buscador/buscar_fecha_estacion.php",
    type:"POST",
    data:parametros,
   })
   .done(function(respuesta){
   $("#tabla-mostrar").html(respuesta); 
   })
   .fail(function(){
     console.log("error");
  });
}

function buscar_aplicados_fecha(opcion,fecha){

  var fecha =$("#caja-fecha").val();

  var parametros ={
    "fecha":fecha,
    "opcion":opcion
  }
  $.ajax({
    url :"../buscador/buscador_general.php",
    type:"POST",
    data:parametros
  })
  .done(function(respuesta){
    $("#tabla-mostrar").html(respuesta);
  })
  .fail(function(){
    console.log("error");
  });

}


function buscar_aplicados_estacion(opcion,fecha){

var fecha  = $("#caja-fecha").val();
var estacion  =$("#caja-estacion").val();
 var parametros={
  "fecha":fecha,
  "estacion":estacion,
  "opcion":opcion
 }

$.ajax({
  url:"../buscador/buscador_general.php",
  type:"POST",
  data:parametros
})
.done(function(respuesta){
  $("#tabla-mostrar").html(respuesta);
})
.fail(function(){
console.log("Error");
});
}
