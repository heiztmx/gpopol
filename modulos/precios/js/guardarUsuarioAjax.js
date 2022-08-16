
$(document).ready(function() {
 validar_autorizador_update()
 // bloquear_check("","")


});




function Formulario(modulos) {

  document.getElementById('save').setAttribute("onclick", "guardarUsuarios('" + modulos + "');");

  $("#cargadorfrm").css({ "display": "inline" });

  $("#save").css({ "display": "inline" });
  $("#new").css({ "display": "none" });
  $("#list").css({ "display": "inline" });
}


function OcultarFormulario() {

  setTimeout("location.href = 'usuarios.php'", 0);

}


function taer_datos_usuarios(datos) {

  subdatos = datos.split("***");
      // estaciones = subdatos[0].split("||");
      datosusuario = subdatos[1].split("||");
      document.getElementById('save').setAttribute("onclick", "modificarUsuarios('" + datos + "');");
      var usuario = $('#usuarioM').val(datosusuario[2]);
      var password = $('#passwordM').val();
      var nombre = $('#nombreM').val(datosusuario[1]);
      var correo = $("#emailM").val(datosusuario[3])

      $("#save").css({ "display": "inline" });
      $("#new").css({ "display": "none" });
      $("#list").css({ "display": "inline" });
      $("#cargadorfrmModificar").css({ "display": "inline" });


      window.scrollTo(0, 0);
      parametros={"opcion":"buscar_permisos",
      "id":datosusuario[0]}
      $("input[type=checkbox]").prop('checked', false);
      $.ajax({
        type: 'POST',
        url: '../metHerramientas/herramientas.php',
        data: parametros,
        success: function(permisos1) {
         todos_permisos = JSON.parse(permisos1);
         for ( i =0; i< todos_permisos["permisos"].length; i++) {

           $("#check"+todos_permisos["permisos"][i]+"M").prop("checked", true);
         }
         $inputs =["peres_estacion","peres_elaboro","peres_estatus"];

         if (todos_permisos["estaciones_odc"] != "") {
          $("#peres_estacionALLORDENCOMPFILM").val(todos_permisos["estaciones_odc"]);
        }

        if (todos_permisos["elaboro_odc"] != "") {
         $("#peres_elaboroALLORDENCOMPFILM").val(todos_permisos["elaboro_odc"])
       }

       if (todos_permisos["estatus_odc"] != "") {
        $("#peres_estatusALLORDENCOMPFILM").val(todos_permisos["estatus_odc"])
      }

      if (todos_permisos["estaciones_req"] != "") {
       $("#peres_estacionALLREQFILM").val(todos_permisos["estaciones_req"])
     }

     if (todos_permisos["elaboro_req"] != "") {
      $("#peres_elaboroALLREQFILM").val(todos_permisos["elaboro_req"])
    }

    if (todos_permisos["estatus_req"] !="") {
     $("#peres_estatusALLREQFILM").val(todos_permisos["estatus_req"])
   }

    if (todos_permisos["estaciones_reccupon"] != "") {
       $("#peres_estacionRECCUPONFILM").val(todos_permisos["estaciones_reccupon"])
     }

     if (todos_permisos["elaboro_reccupon"] != "") {
      $("#peres_elaboroRECCUPONFILM").val(todos_permisos["elaboro_reccupon"])
    }

    if (todos_permisos["estatus_reccupon"] !="") {
     $("#peres_estatusRECCUPONFILM").val(todos_permisos["estatus_reccupon"])
   }

       if (todos_permisos["estaciones_repcupon"] != "") {
       $("#peres_estacionREPCUPONFILM").val(todos_permisos["estaciones_repcupon"])
     }

     if (todos_permisos["elaboro_repcupon"] != "") {
      $("#peres_elaboroREPCUPONFILM").val(todos_permisos["elaboro_repcupon"])
    }

    if (todos_permisos["estatus_repcupon"] !="") {
     $("#peres_estatusREPCUPONFILM").val(todos_permisos["estatus_repcupon"])
   }




           // console.log(permisos1)
           // $("#checkLISTADOGENEMM").prop("checked", true);
         }
       });






    }





    function guardarUsuarios(modulos) {


      submodulos = modulos.split("||");
      submodulos.pop();
      permisos = [];
      permisos_cadena = ""
      cont = 0;
      erroresPE=0;

      var usuario = $('#usuario').val();
      var password = $('#password').val();
      var nombre = $('#nombre').val();
      var correo = $("#email").val();
      val_correo = validarEmail(correo);
      for (i = 0; i < submodulos.length; i++) {

        window["arreglochk" + submodulos[i]] = $('[name="' + submodulos[i] + '[]"]:checked').map(function() {
          return this.value;

        }).get();

        if (window["arreglochk" + submodulos[i]].length > 0) {
          permisos_cadena += submodulos[i] + "||";
          permisos.push(window["arreglochk" + submodulos[i]])
          cont++;
        } else {
          x = "xxx"
          permisos_cadena += x + "||";
          permisos.push(x);
        }
      }

      erroresODC=0;
      array_odc_pe=[];
      if ($('#checkALLORDENCOMPFIL').prop('checked')) {
        idpermiso ="ALLORDENCOMPFIL";
        retorno= validar_permisos_especiales(window["arreglochkCOMPRAS"],idpermiso,"")
        erroresODC= retorno["errores"];
        array_odc_pe = retorno["permisos"]

      }
      erroresREQ = 0;
      array_req_pe=[]
      if ( $('#checkALLREQFIL').prop('checked')) {
        idpermiso ="ALLREQFIL";
        retorno =  validar_permisos_especiales(window["arreglochkCOMPRAS"],idpermiso,"")
        erroresREQ = retorno["errores"];
        array_req_pe = retorno["permisos"]
      }
      erroresRECCUPON = 0;
      array_reccupon_pe=[]
      if ( $('#checkRECCUPONFIL').prop('checked')) {
        idpermiso ="RECCUPONFIL";
        retorno =  validar_permisos_especiales(window["arreglochkCUPONES"],idpermiso,"")
        erroresRECCUPON = retorno["errores"];
        array_reccupon_pe = retorno["permisos"]
      }
      erroresREPCUPON = 0;
      array_repcupon_pe=[]
      if ( $('#checkREPCUPONFIL').prop('checked')) {
        idpermiso ="REPCUPONFIL";
        retorno =  validar_permisos_especiales(window["arreglochkCUPONES"],idpermiso,"")
        erroresREPCUPON = retorno["errores"];
        array_repcupon_pe = retorno["permisos"]
      }       
      // console.log(erroresODC)
      // console.log(erroresREQ)
      erroresPE = erroresODC + erroresREQ + erroresRECCUPON + erroresREPCUPON ;
      console.log(erroresPE)


      if (val_correo === true) {


        if (nombre != "" && usuario != "" && nombre != "") {
          if (cont > 0) {


            datos = {
              "nombre": nombre,
              "usuario": usuario,
              "password": password,
              "permisos": permisos,
              "correo":correo,
              "permisos_cadena": permisos_cadena,
              "pe_req":array_req_pe,
              "pe_odc":array_odc_pe,
              "pe_reccupon":array_reccupon_pe,
              "pe_repcupon":array_repcupon_pe
            }
            console.log(datos)
            $.ajax({
              type: 'POST',
              url: '../../precios/webprecios/insertUser.php',
              data: datos,
              success: function(respuesta) {
                // console.log(respuesta)
                if (respuesta == "guardado") {
                 type_message = "success"
                 title = "Usuario"
                 texts = "Usuario guardado"
                 footer = ""
                 message(type_message, title, texts, footer)
                 setTimeout("location.href = 'usuarios.php'", 5000);
               }else{
                type_message = "error"
                title = "Error"
                texts = ""+respuesta
                footer = ""
                message(type_message, title, texts, footer)
              }
            }
              }); //fin del ajax


          } else {
            type_message = "error"
            title = "Permisos vacios"
            texts = "Favor de elegir al menos un permiso para el usuario"
            footer = "Para mas informacion contactar a sistemas"
            message(type_message, title, texts, footer)
          }

        } else {
          type_message = "error"
          title = "Campos vacios"
          texts = "Favor de llenar todos los campos"
          footer = ""
          message(type_message, title, texts, footer)
        }

      }else{
        type_message = "error"
        title = "Correo"
        texts = "Formato incorrecto"
        footer = ""
        message(type_message, title, texts, footer)
      }



    }



    function validarEmail(email) {
      if (/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(email)){
        return true;
      } else {
        return false;
      }
    }
    function validar_permisos_especiales(arreglo,permiso,mov) {
      errores=0;
      especiales=0;
      arraypermisos =[];
      retorno = new Array();
      inputs =["peres_estacion","peres_elaboro","peres_estatus"];
      console.log(arreglo)
      for(i=0; i<arreglo.length; i++)
      {

        if (arreglo[i] === permiso ) {
          for(z=0; z<inputs.length; z++)
          {
           if ($("#"+inputs[z]+""+permiso+""+mov).val() === "") {
            arraypermisos.push("xxx");

          }else{
            per =$("#"+inputs[z]+""+permiso+""+mov).val()
            arraypermisos.push(per)
            errores++
          } 
        }
        especiales++;
      }

    }
    retorno["permisos"]=arraypermisos;
    retorno["errores"] = errores;
    return retorno;
  }



  function modificarUsuarios(datos) {
    subdatos=datos.split("***")
    submodulos = subdatos[0].split("||");
    datos_usuario = subdatos[1].split("||");
    submodulos.pop();
    permisos = [];
    permisos_cadena = ""
    cont = 0;

    var usuario = $('#usuarioM').val();
    var password = $('#passwordM').val();
    var nombre = $('#nombreM').val();
    var correo = $("#emailM").val();
    for (i = 0; i < submodulos.length; i++) {
      window["arreglochk" + submodulos[i]+"M"] = $('[name="' + submodulos[i]+'M[]"]:checked').map(function() {
        return this.value;
      }).get();

      if (window["arreglochk" + submodulos[i]+"M"].length > 0) {
        permisos_cadena += submodulos[i] + "||";
        permisos.push(window["arreglochk" + submodulos[i]+"M"])
        cont++;
      } else {
        x = "xxx"
        permisos_cadena += x + "||";
        permisos.push(x);
      }
    }

    erroresODC=0;
    array_odc_pe=[];
    if ($('#checkALLORDENCOMPFILM').prop('checked')) {
      idpermiso ="ALLORDENCOMPFIL";
      retorno= validar_permisos_especiales(window["arreglochkCOMPRASM"],idpermiso,"M")
      erroresODC= retorno["errores"];
      array_odc_pe = retorno["permisos"]

    }
    erroresREQ = 0;
    array_req_pe=[];
    if ( $('#checkALLREQFILM').prop('checked')) {
      idpermiso ="ALLREQFIL";
      retorno =  validar_permisos_especiales(window["arreglochkCOMPRASM"],idpermiso,"M")
      erroresREQ = retorno["errores"];
      array_req_pe = retorno["permisos"]
    }
    erroresRECCUPON = 0;
    array_reccupon_pe=[];
    if ( $('#checkRECCUPONFILM').prop('checked')) {
      idpermiso ="RECCUPONFIL";
      retorno =  validar_permisos_especiales(window["arreglochkCUPONESM"],idpermiso,"M")
      erroresRECCUPON = retorno["errores"];
      array_reccupon_pe = retorno["permisos"]
    }    
    erroresREPCUPON = 0;
    array_repcupon_pe=[];
    if ( $('#checkREPCUPONFILM').prop('checked')) {
      idpermiso ="REPCUPONFIL";
      retorno =  validar_permisos_especiales(window["arreglochkCUPONESM"],idpermiso,"M")
      erroresREPCUPON = retorno["errores"];
      array_repcupon_pe = retorno["permisos"]
    }  

    erroresPE = erroresODC + erroresREQ + erroresRECCUPON + erroresREPCUPON;


    console.log(datos)
    val_correo = validarEmail(correo);
    if (val_correo === true ) {


      if (nombre != "" && usuario != "" ) {
        if (cont > 0) {

         datos = {
          "idUsuario":datos_usuario[0],
          "nombre": nombre,
          "usuario": usuario,
          "password": password,
          "permisos": permisos,
          "correo":correo,
          "permisos_cadena": permisos_cadena,
          "pe_req":array_req_pe,
          "pe_odc":array_odc_pe,
          "pe_reccupon":array_reccupon_pe,
          "pe_repcupon":array_repcupon_pe
        }
        // console.log(parametros)
        $.ajax({
          type: 'POST',
          url: '../../precios/webprecios/modUser.php',
          data: datos,
          success: function(respuesta) {
            // console.log(respuesta)
            if (respuesta === "update") {
              type_message = "success"
              title = "Actualización"
              texts = "Usuario modificado exitosamente"
              footer = "Para mas informacion contactar a sistemas"
              message(type_message, title, texts, footer)
            }else{
              type_message = "info"
              title = "Informacion"
              texts = ""+respuesta
              footer = "si el problema persiste llamar a sistemas"
              message(type_message, title, texts, footer)
            }
          }
              }); //fin del ajax


      } else {
        type_message = "error"
        title = "Permisos vacios"
        texts = "Favor de elegir al menos un permiso para el usuario"
        footer = "Para mas informacion contactar a sistemas"
        message(type_message, title, texts, footer)
      }

    } else {
      type_message = "error"
      title = "Campos vacios"
      texts = "Favor de llenar todos los campos"
      footer = ""
      message(type_message, title, texts, footer)
    }

   
  }  else{
        type_message = "error"
        title = "Correo"
        texts = "Formato incorrecto"
        footer = ""
        message(type_message, title, texts, footer)
    }


}



  function EliminarUsuarios(datosEliminar) {

    datos = datosEliminar.split('||');


    Swal({
      title: 'Eliminar usuario',
      text: "¿Esta seguro que desea eliminar al usuario?",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si,Eliminarlo!'
    }).then((result) => {
      if (result.value) {
        var parametros = { "idusuario": datos[0] }

        $.ajax({
          type: 'POST',
          url: '../../precios/webprecios/eliminarUsuario.php',
          data: parametros,
          success: function(eliminado) {
            console.log(eliminado)
            if (eliminado == "Eliminado") {

              Swal({ type: 'success', title: 'Usuario eliminado', showConfirmButton: true });
              setTimeout("location.href = 'usuarios.php'", 4000);





            } else {
              Swal({
                type: 'error',
                title: 'Oops...',
                text: 'Tenemos problemas para eliminar al usuario!',
                footer: '<a href="#">Si el problema persiste favor de llamar a sistemas</a>'
              })
            }
          }
              }); //fin del ajax
        return false;


      } else {
              //modifica
            }
          })



  }

  function message(type_message, title, texts, footer = "") {
      // body...
      Swal({
        type: '' + type_message,
        title: '' + title,
        text: '' + texts,
        footer: '' + footer
      })
    }



    function bloquear_check(id1="",id2="") {

      var autorizador1 = document.getElementById("check"+id1);
      var autorizador2 = document.getElementById("check"+id2); 

      autorizador1.onclick = function(){ 
        if(autorizador1.checked != false){ 
          autorizador2.checked =null; }
        } 
        autorizador2.onclick = function(){ 
          if(autorizador2.checked != false){ 
            autorizador1.checked=null;
          }
        } 

      }



      function validar_autorizador_update() {

        var autorizador1 = document.getElementById("checkAUT1COMPRAM");
        var autorizador2 = document.getElementById("checkAUT2COMPRAM"); 

        autorizador1.onclick = function(){ 
          if(autorizador1.checked != false){ 
            autorizador2.checked =null; }
          } 
          autorizador2.onclick = function(){ 
            if(autorizador2.checked != false){ 
              autorizador1.checked=null;
            }
          } 

        }


     // function validad_all_req() {

     //  var all_req = document.getElementById("checkALLREQ");
     //  var autorizador2 = document.getElementById("checkALLREQFIL"); 

     //  autorizador1.onclick = function(){ 
     //    if(autorizador1.checked != false){ 
     //      autorizador2.checked =null; }
     //    } 
     //    autorizador2.onclick = function(){ 
     //      if(autorizador2.checked != false){ 
     //        autorizador1.checked=null;
     //      }
     //    } 

     //  }

     // function validad_all_req_update() {

     //  var all_req = document.getElementById("checkALLREQM");
     //  var autorizador2 = document.getElementById("checkALLREQFILM"); 

     //  autorizador1.onclick = function(){ 
     //    if(autorizador1.checked != false){ 
     //      autorizador2.checked =null; }
     //    } 
     //    autorizador2.onclick = function(){ 
     //      if(autorizador2.checked != false){ 
     //        autorizador1.checked=null;
     //      }
     //    } 

     //  }

        // function toggle_permisos_especiales(permiso) {
        //   $( "#div"+permiso ).toggle( "slow" );
        // }