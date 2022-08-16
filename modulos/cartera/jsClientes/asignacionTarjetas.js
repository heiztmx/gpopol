function bloqueAsignarTarjetas(id) {

    if ($("#Mastarjetas"+id).prop("checked") == true) {
        $("#cajaTarjetas"+id).prop("disabled", false);
        $("#alias"+id).prop("disabled", false);
        $("#cajaTarjetas"+id).focus();
    } else if ($("#Mastarjetas"+id).prop("checked") == false) {
        $("#cajaTarjetas"+id).prop("disabled", true);
        $("#alias"+id).prop("disabled", true);
    }
}

function enviarDGASSALD(id) {

    var nombreclientex = $("#nombrecliente1"+id).val();
    var noclie = $("#noclie"+id).val();
    var monto = $("#montoCredito"+id).val();
    var tarjetas = $("#cajaTarjetas"+id).val();
    var alias = $("#alias"+id).val();
    var tipoCliente =$("#tipoCliente"+id+" option:selected").val();// pp co cr jefe
    var grupofac = $("#grupofac"+id+"  option:selected").val(); // 1 2 3 depende
    var metodoPago =  $("#formapagodefault"+id+" option:selected").val();
    var checkTarjetas ="";
        mensajeTarj="";
    if($("#Mastarjetas"+id).prop("checked") == true)
    {
        checkTarjetas = "Si";
        mensajeTarj="El registro de tarjetas fue guardado Exitosamente";
    }
       

        if ($("#Mastarjetas"+id).prop("checked") == true) {
            num_tarjetas =isNaN(tarjetas);
            if (num_tarjetas === false && alias != "") {
                enviarDatos(noclie,monto,tarjetas,alias,tipoCliente,grupofac,metodoPago,nombreclientex,checkTarjetas,mensajeTarj);
                
            }else{
                Swal({ type: 'info', title: 'Información de tarjetas', text: 'Verifique el numero y/o nombre de las tarjetas', footer: '<a href></a>' })
            }

        }else{
            enviarDatos(noclie,monto,tarjetas,alias,tipoCliente,grupofac,metodoPago,nombreclientex,checkTarjetas,mensajeTarj);
        
        }

 
}

function enviarDatos(noclie,monto,tarjetas,alias,tipoCliente,grupofac,metodoPago,nombreclientex,checkTarjetas,mensajeTarj) {

          parametros = {
            "id": noclie,
            "credito": monto,
            "tarjetas": tarjetas,
            "alias": alias,
            "tipoCliente": tipoCliente,
            "grupofac": grupofac,
            "metodoPago":metodoPago,
            "nombreClientex":nombreclientex
        }
    // body...
        $.ajax({
            type: 'POST',
            url: '../webClientes/insertTarjetas.php',
            data: parametros,
            success: function(respuestas) {
                console.log(respuestas);
                subRespuesta = respuestas.split("**");
                console.log(subRespuesta);
                if ((subRespuesta[0] === "insertCredito" || subRespuesta[0] === "updateCredito") && subRespuesta[1] === "Tarjetas") {

                    Swal({
                        type: 'success',
                        title: 'Exitoso',
                        html: 'El monto del credito de $' + monto + ' fue guardado Exitosamente <br>'+mensajeTarj,
                        allowOutsideClick: false,
                        footer: '<a id="enlace"  target="_blank">Excel</a>'
                    }).then((result) => {
                          if (result.value) {
                                if(checkTarjetas == "Si"){
                           generarExcel(subRespuesta[2],subRespuesta[3],subRespuesta[4],subRespuesta[5],subRespuesta[6],subRespuesta[7],subRespuesta[8]);
                          }
                      }
                        })

                    // Swal({ type: 'success', title: 'El monto del credito y el numero de tarjetas fueron guardadas exitosamente', showConfirmButton: true });
                    setTimeout(cargaSeccion(), 3000);

                } else if ((subRespuesta[0] === "insertCredito" || subRespuesta[0] === "updateCredito") && subRespuesta[1] != "Tarjetas") {
                    Swal({
                        type: 'info',
                        title: 'Credito',
                        html: 'El monto del credito de $' + monto + ' fue guardado Exitosamente <br>' + subRespuesta[1],
                        allowOutsideClick: false,
                        footer: '<a href="#">Favor de verificar los resultados con sistemas por favor</a>'
                    }).then((result) => {
                          if (result.value) {
                                if(checkTarjetas == "Si"){
                           generarExcel(subRespuesta[2],subRespuesta[3],subRespuesta[4],subRespuesta[5],subRespuesta[6],subRespuesta[7],subRespuesta[8]);
                          }
                          }
                        })

                } else if ((subRespuesta[0] != "insertCredito" || subRespuesta[0] != "updateCredito") && subRespuesta[1] === "Tarjetas") {
                    Swal({
                        type: 'info',
                        title: 'Credito',
                        html: 'El numero de tarjetas ' + tarjetas + ' fue guardado Exitosamente <br>' + subRespuesta[0],
                        allowOutsideClick: false,
                        footer: '<a href="#">Favor de verificar los resultados con sistemas por favor</a>'
                    }).then((result) => {
                          if (result.value) {
                            if(checkTarjetas == "Si"){
                           generarExcel(subRespuesta[2],subRespuesta[3],subRespuesta[4],subRespuesta[5],subRespuesta[6],subRespuesta[7],subRespuesta[8]);
                            }
                          }
                        })
                } else {
                    Swal({
                        type: 'error',
                        title: 'Oops',
                        html: '' + subRespuesta[0] + '<br>' + subRespuesta[1],
                        allowOutsideClick: false,
                        footer: '<a href="#">Favor de verificar los resultados con sistemas por favor</a>'
                    }).then((result) => {
                          if (result.value) {
                        if(checkTarjetas == "Si"){
                           generarExcel(subRespuesta[2],subRespuesta[3],subRespuesta[4],subRespuesta[5],subRespuesta[6],subRespuesta[7],subRespuesta[8]);
                          }
                          }
                        })
                }
            }
        });
}
function cargaSeccion() {

    $("#CargadorClienteCreditos").load("asignarCreditoCli.php");
    

}

function generarExcel(tarjetas,nips,nombre,noclie,usuario,tipo_cliente,vehiculos) {

  
    //window.open("../webClientes/generarExcel.php?tarjetas="+tarjetas+"&nips="+nips+"&nombre="+nombre+"&noclie="+noclie+"&usuario="+usuario+"&tipo_cliente="+tipo_cliente+"", "_blank");
     window.open("../webClientes/generarExcel.php?tarjetas="+tarjetas+"&nips="+nips+"&nombre="+nombre+"&noclie="+noclie+"&usuario="+usuario+"&tipo_cliente="+tipo_cliente+"&num_vehiculos="+vehiculos+"", "_blank");
     
     
}

