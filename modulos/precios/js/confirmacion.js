function confirmarPC(estaciones) {

    cadena1 = estaciones;
    limitador = "||";
    subEstaciones = cadena1.split(limitador);
    parametrosEnviar = new Array();
    arregloVerificar = [];






subEstaciones.pop();
    $("#btnCancelarModal").css({ "display": "none" });
    $("#btnEnviarModal").css({ "display": "none" });
    $("#tacha").css({ "display": "none" });

    if ($('#todos1').prop('checked') == true) {

        for (y = 0; y < subEstaciones.length; y++) {
             arregloVerificar.push(subEstaciones[y]);
            $('#loader' + subEstaciones[y]).css({ "display": "inline" });
        }

    } else {
        for (y = 0; y < subEstaciones.length; y++) {
            if ($('#Estacion' + subEstaciones[y]).prop('checked') == true) {

                 arregloVerificar.push(subEstaciones[y]);
                $('#loader' + subEstaciones[y]).css({ "display": "inline" });
            } else {

                arregloVerificar.push("x");
                $("#loader" + subEstaciones[y]).css({ display: "none" });
                $("#imagen" + subEstaciones[y]).css({ display: "none" });
            }

        }




    }
  var estaciones1="";
for(w=0; w<arregloVerificar.length;w++){

     estaciones1 = estaciones1.concat(arregloVerificar[w]+"||");
}
   parametros = {
         "Estaciones": estaciones1,
        "date3": $("#date3").val(),
        "magna": $("#magnamodal").val(),
        "premium": $("#premiummodal").val(),
        "diesel": $("#dieselmodal").val()
    }




// console.log(estaciones1);

    $.ajax({
        type: 'POST',
        url: '../web-services/WSset.php',
        data: parametros,
        success: function(data) {
            // console.log(data);
            // cadena = data,
            //     separador = " ",
            //     arregloDeSubCadenas = cadena.split(separador);
            var contador = 0;
            var testeo = [];
           json1 = JSON.parse(data)
            console.log(json1)
            for (w = 0; w < subEstaciones.length; w++) {
     

                if (arregloVerificar[w] != "x" || $('#todos1').prop('checked') == true) {

                 
                    if (subEstaciones[w] === json1[""+subEstaciones[w]]) {
                             
                        $('#loader' + subEstaciones[w]).css({ "display": "none" });
                        $("#imagen" + subEstaciones[w]).attr("src", "../imagenes/v01.png");
                        $("#imagen" + subEstaciones[w]).css({ "display": "inline" });
                        contador++;

                    } else {
                        $('#loader' + subEstaciones[w]).css({ "display": "none" });
                        $("#imagen" + subEstaciones[w]).attr("src", "../imagenes/x01.png");
                        $("#imagen" + subEstaciones[w]).css({ "display": "inline" });

                    }


                }
            }
            for (x = 0; x < subEstaciones.length; x++) {
                if ($("#imagen" + subEstaciones[w]).css({ "display": "none" })) {
                    
                }
            }
            if (contador > 0) {
                $("#facturacion").html("Programación de Precios para las estaciones y Facturación Exítosa");
                $("#facturacion").css({ "color": "green" });
                $("#btnOK").css({ "display": "inline" });

            } else {
                $("#facturacion").html("No se programaron los precios en Facturacion, favor de intentarlo nuevamente");
                $("#facturacion").css({ "color": "red" });
                $("#btnOK").css({ "display": "inline" });
            }
            // console.log(data);
            if (data == 0) {
                // $("#btnOK").css({ "display": "inline" });
                 $("#errorFatal").css({ "color": "red" });
                $("#errorFatal").html("Programación de Precios no Exitosa, intentelo de nuevo, si el problema persiste Favor de llamar a sistemas");
               
            }

        }
    });
    return false;






}



function resetear(argument) {


 
 }