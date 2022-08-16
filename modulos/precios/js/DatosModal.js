function VerificacionHora(estaciones) {
    fechacompleta = document.getElementById("date3").value;

    subEstaciones = estaciones.split("||");

    subEstaciones.pop();
    seleccionadas = [];
    if($('#todos1').prop('checked')  == true)
    {
      for(i = 0; i<subEstaciones.length; i++)
      {
        seleccionadas.push(subEstaciones[i]);
      }

    }else{
       for(i = 0; i<subEstaciones.length; i++)
      {
        if($('#Estacion'+subEstaciones[i]).prop('checked')  == true )
        {
          seleccionadas.push(subEstaciones[i]);
        }
      }
    }
   
    paraHora={
    "hora":fechacompleta
    ,"estaciones" :seleccionadas}
// alert(seleccionadas)

$.ajax({
   type:'POST',
   url:'../webprecios/VerificacionHora.php',
   data:paraHora,
   success:function (respuesta) {
    // console.log(respuesta)
   resultados = JSON.parse(respuesta)
       if (resultados["contador"] == 0) {
        mostrarModalPC(estaciones);
       }else{

        htmlp="";
        console.log(resultados["resultadosEstaciones"])
        htmlp +="Ya existen precios programados para la fecha y hora seleccionada, en las estaciones:"

        for(i = 0; i<resultados["resultadosEstaciones"].length; i++)
        {
            htmlp+= "<div style='font-weight: bold;'>"+resultados["resultadosEstaciones"][i]+"</div>";
            console.log(resultados["resultadosEstaciones"][i])
            // console.log(i)
        }
       

            Swal({
            type: 'error',
            title: 'Precios No Programados',
            html: ''+htmlp,
            footer: '<a href>Intenta no seleccionarlar las estaciones mencionadas o modifica la hora para programar nuevos precios</a>'
            })
        // Swal('Verificacion de Hora','Elija otra hora esta ya fue usada para esta fecha',"warning");
        
   }
  }
});
 return false;
}


function mostrarModalPC(estaciones) {



    var cadena = estaciones;
    caracter = "||";
    subEstaciones = cadena.split(caracter);



    clear_grafico(estaciones);
    var variablesEstaciones = [];
    var variables = [];



    fecha = document.getElementById("date3").value;
    magna = document.getElementById("magna1").value;
    premium = document.getElementById("premium1").value;
    diesel = document.getElementById("diesel1").value;
    todos = document.getElementById("todos1").value;





        if ($('#todos1').prop('checked') && fecha != "" && magna != "" && premium != "" && diesel != ""){
            $("#btn_modal").trigger("click");
            $('#fechamodal').val(fecha);
            $('#magnamodal').val(magna);
            $('#premiummodal').val(premium);
            $('#dieselmodal').val(diesel);
            $('#todosmodal').val(todos);

            for (i = 0; i <subEstaciones.length; i++) {

                $('#modal'+subEstaciones[i]).val(subEstaciones[i]);
                $('#modal'+subEstaciones[i]).css({ "display": "inline" });
                $('#loader'+subEstaciones[i]).css({ "display": "none" });
                $('#imagen'+subEstaciones[i]).css({ "display": "none" });

            }


        }

        // ---------------------------------------------
        else {


            for (z = 0; z<subEstaciones.length; z++) {
               
                if ($('#Estacion'+subEstaciones[z]).prop('checked') == true) {
                    variablesEstaciones.push(subEstaciones[z]);
                    $('#modal'+subEstaciones[z]).css({ "display": "inline" });
                    $('#loader'+subEstaciones[z]).css({ "display": "none" });
                    $('#imagen'+subEstaciones[z]).css({ "display": "none" });
                } else {
                    
                    $('#modal'+subEstaciones[z]).css({ "display": "none" });
                    $('#loader'+subEstaciones[z]).css({ "display": "none" });
                    $('#imagen'+subEstaciones[z]).css({ "display": "none" });
                    variablesEstaciones.push("");
                }




            }


            // fin del push
            vacios = 0;
            if (fecha != "" && magna != "" && premium != "" && diesel != "") {
                for (i = 0; i < subEstaciones.length; i++) {

                    if (variablesEstaciones[i] != "") {
                        vacios++
                    }
                }

            }
            if (vacios > 0) {
               $("#btn_modal").trigger("click");

                $('#fechamodal').val(fecha);
                $('#magnamodal').val(magna);
                $('#premiummodal').val(premium);
                $('#dieselmodal').val(diesel);
                for (v = 0; v <variablesEstaciones.length; v++) {
                    $('#modal'+subEstaciones[v]).val(variablesEstaciones[v]);
                }

            } else {
               Swal('Campos Vacios','Favor de llenar todos campos','warning');
                   var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
      document.getElementById("cargador").innerHTML =
      this.responseText;
    }
      };
      xhttp.open("GET", "frmPrecios.php", true);
      xhttp.send();
            }







        }







    } // deteccion de pantalla


  function clear_grafico(estaciones) {
    var cadena = estaciones;
    caracter = "||";
    subEstaciones = cadena.split(caracter);
       for(i=0; i<subEstaciones.length; i++){
        $('#modal'+subEstaciones[i]).css({ "display": "none" });
        $('#loader' + subEstaciones[i]).css({ "display": "none" });
        $("#imagen" + subEstaciones[i]).attr("src", "");
        $("#imagen" + subEstaciones[i]).css({ "display": "none" });
       }
    $("#btnCancelarModal").css({ "display": "inline" });
    $("#btnEnviarModal").css({ "display": "inline" });
    $("#tacha").css({ "display": "inline" });
    $("#btnOK").css({ "display": "none" });
     $("#facturacion").html("");
     $("#errorFatal").html("");
      
      fecha = $("#date3").val(),
       magna = $("#magnamodal").val(),
      premium=  $("#premiummodal").val(),
        diesel= $("#dieselmodal").val()
        fecha="";
        magna ="";
        premium="";
        diesel="";
   } 

// } //fin de la funcion
// });
