
function confirmarModal(estaciones) {

    cadena1 = estaciones;
    limitador = "||";
    subEstaciones = cadena1.split(limitador);
    parametrosEnviar = new Array();
    arregloVerificar = [];







    $("#botonfinal2").css({ "display": "none" });
    $("#btncancelar2").css({ "display": "none" });

    if ($('#todos1').prop('checked')) {

        for (y = 0; y < subEstaciones.length; y++) {
            arregloVerificar.push(subEstaciones[y]);
            $('#loaderphone' + subEstaciones[y]).css({ "display": "inline" });
        }

    } else {
        for (y = 0; y < subEstaciones.length; y++) {
            if ($('#' + subEstaciones[y]).prop('checked')) {

                arregloVerificar.push(subEstaciones[y]);
                $('#loaderphone' + subEstaciones[y]).css({ "display": "inline" });
            } else {

                arregloVerificar.push("");
                $("#loaderphone" + subEstaciones[y]).css({ display: "none" });
                $("#imagenphone" + subEstaciones[y]).css({ display: "none" });
            }

        }

    }
    var parametros = {

        "Uman": arregloVerificar[0],
        "Poliforum": arregloVerificar[1],
        "Siderurgica": arregloVerificar[2],
        "Perioriente": arregloVerificar[3],
        "date3": $("#date3").val(),
        "magna": $("#magna").val(),
        "premium": $("#premium").val(),
        "diesel": $("#diesel").val()
    }



    $.ajax({
        type: 'POST',
        url: '../web-services/WSset.php',
        data: parametros,
        success: function(data) {
            cadena = data,
                separador = " ",
                arregloDeSubCadenas = cadena.split(separador);
            var contador = 0;
            var testeo = [];
            for (w = 0; w < subEstaciones.length; w++) {


                if ($('#' + subEstaciones[w]).prop('checked') == true) {


                    if (subEstaciones[w] === arregloDeSubCadenas[w]) {

                        $('#loaderphone' + subEstaciones[w]).css({ "display": "none" });
                        $("#imagenphone" + subEstaciones[w]).attr("src", "../imagenes/v01.png");
                        $("#imagenphone" + subEstaciones[w]).css({ "display": "inline" });
                        contador++;

                    } else {
                        $('#loaderphone' + subEstaciones[w]).css({ "display": "none" });
                        $("#imagenphone" + subEstaciones[w]).attr("src", "../imagenes/x01.png");
                        $("#imagenphone" + subEstaciones[w]).css({ "display": "inline" });

                    }
                }
            }
            for (x = 0; x < subEstaciones.length; x++) {
                if ($("#imagenphone" + subEstaciones[w]).css({ "display": "none" })) {
                    $("#btnOK2").css({ "display": "inline" });
                }
            }
            if (contador > 0) {
                $("#facturacion2").html("Se han Actualizados los precios en Facturacion");
                $("#facturacion2").css({ "color": "green" });

            } else {
                $("#facturacion2").html("No se pudieron Actualizar los precios en Facturacion");
                $("#facturacion2").css({ "color": "red" });
            }
            console.log(data);
            if (data == 0) {
                $('#errorfatal2').html("Sin exito al insertar los precios en las estaciones, si el problema persiste favor de llamar al administrador de la pagina");
            }

        }
    });
    return false;







}