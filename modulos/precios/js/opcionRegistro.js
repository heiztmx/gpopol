

function borrar_precios(datos) {
    subDatos=datos.split("||")
    estacion =subDatos[9];
    folio =subDatos[0];
    tabla ="<table class='table'><thead><tr><th scope='col'>Folio</th><th scope='col'>Estacion</th></tr></thead> <tbody> <tr scope='row'><td>"+estacion+"</td> <td>"+folio+"</td></tr> </tbody></table>"

    Swal({
      title: '¿Eliminar los precios?',
      html: ""+tabla,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si,eliminarlo'
  }).then((result) => {
      if (result.value) {
        parametros = {
            "folio": subDatos[0],
            "ip": subDatos[8]
        }
        $.ajax({
            type: 'POST',
            url: '../webprecios/eliminarPrecios.php',
            data: parametros,
            success: function(eliminado) {
                if (eliminado === "Eliminado") {
                    Swal({

                        type: 'success',
                        title: 'Registro Eliminado Exitosamente',
                        showConfirmButton: true,
                                        // timer: 1500
                                    })
                    .then((aceptar) => {
                        if (aceptar) {
                            cargarTablas();
                        } else {
                                            // cargarTablas();
                                        }
                                    });


                } else {
                    swal("" + eliminado, {
                        icon: "error",
                    });
                }


            }
                    }); //fin del ajax;
        return false;
    }
})
}

function cargarTablas() {
    // body...


    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("cargador").innerHTML =
            this.responseText;
        }
    };
    xhttp.open("GET", "listado.php", true);
    xhttp.send();

}

function Enviarfolio1(folio, fechacompleta) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("cargador").innerHTML =
            this.responseText;
        }
        x = "folio=" + folio;
        $("#magna1").on({
            "focus": function(event) {
                $(event.target).select();
            },
            "keyup": function(event) {
                $(event.target).val(function(index, value) {
                    return value.replace(/\D/g, "")
                    .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                    .replace(/\B(?=(\d{2})+(?!\d)\.?)/g, ",");
                });
            }
        });

        $("#premium1").on({
            "focus": function(event) {
                $(event.target).select();
            },
            "keyup": function(event) {
                $(event.target).val(function(index, value) {
                    return value.replace(/\D/g, "")
                    .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                    .replace(/\B(?=(\d{2})+(?!\d)\.?)/g, ",");
                });
            }
        });


        $("#diesel1").on({
            "focus": function(event) {
                $(event.target).select();
            },
            "keyup": function(event) {
                $(event.target).val(function(index, value) {
                    return value.replace(/\D/g, "")
                    .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                    .replace(/\B(?=(\d{2})+(?!\d)\.?)/g, ",");
                });
            }
        });



    };
    xhttp.open("POST", "frmModificar.php", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send(x);

}

function ponerFecha(fechaHora) {
    var dateControl = document.querySelector('input[type="datetime-local"]');
    dateControl.value = fechaHora;
}

function Formato_numeros(argument) {
    // body...
    $("#magna1").on({
        "focus": function(event) {
            $(event.target).select();
        },
        "keyup": function(event) {
            $(event.target).val(function(index, value) {
                return value.replace(/\D/g, "")
                .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                .replace(/\B(?=(\d{2})+(?!\d)\.?)/g, ",");
            });
        }
    });

    $("#premium1").on({
        "focus": function(event) {
            $(event.target).select();
        },
        "keyup": function(event) {
            $(event.target).val(function(index, value) {
                return value.replace(/\D/g, "")
                .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                .replace(/\B(?=(\d{2})+(?!\d)\.?)/g, ",");
            });
        }
    });


    $("#diesel1").on({
        "focus": function(event) {
            $(event.target).select();
        },
        "keyup": function(event) {
            $(event.target).val(function(index, value) {
                return value.replace(/\D/g, "")
                .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                .replace(/\B(?=(\d{2})+(?!\d)\.?)/g, ",");
            });
        }
    });

}