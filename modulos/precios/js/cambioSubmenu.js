function listadoGeneral(datos) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("cargador").innerHTML =
            this.responseText;
        }
    };
    xhttp.open("GET", "loading.php", true);
    xhttp.send();

    cadena = datos;
    separador = "||";
    subDatos = cadena.split(separador);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("cargador").innerHTML =
            this.responseText;
        }
    };
    xhttp.open("GET", "listadoGeneral.php", true);
    xhttp.send();


}


function PreciosFacturacion() {

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("cargador").innerHTML =
            this.responseText;
        }
    };
    xhttp.open("GET", "loading.php", true);
    xhttp.send();
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("cargador").innerHTML =
            this.responseText;
        }
    };
    xhttp.open("GET", "ListaFacturacion.php", true);
    xhttp.send();


}


$(document).ready(function() {

    if (screen.width <= 991) {
        $('#tm1').css({ "display": "inline" });

    }



    $('#modulo1').click(function() {
        window.location.href = "portada.php";
        if (screen.width < 1000) {

            $('#opcion2').css({ "display": "none" });
            $('#opcion3').css({ "display": "none" });
            $('.navbar-toggler').click();
        } else {

            $('#opcion2').css({ "display": "none" });
            $('#opcion3').css({ "display": "none" });
        }


    });



    $('#modulo2').click(function() {

        if (screen.width < 1000) {
            $('#opcion1').css({ "display": "none" });
            $('#opcion2').css({ "display": "inline" });
            $('#opcion3').css({ "display": "none" });
            $('.navbar-toggler').click();
        } else {
            $('#opcion1').css({ "display": "none" });
            $('#opcion2').css({ "display": "inline" });
            $('#opcion3').css({ "display": "none" });
        }
    });



    $('#modulo3').click(function() {


        $('#opcion3').show();
        $('#opcion2').hide();
        $('#topcion1').hide();

    });


    $("#agregarPrecio").on('click', function(event) {

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("cargador").innerHTML =
                this.responseText;
            }
        };
        xhttp.open("GET", "loading.php", true);
        xhttp.send();

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {


            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("cargador").innerHTML =
                this.responseText;

            }


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
        xhttp.open("GET", "frmPrecios.php", true);
        xhttp.send();




    });


    $("#portada").on('click', function(event) {

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("cargador").innerHTML =
                this.responseText;
            }
        };
        xhttp.open("GET", "loading.php", true);
        xhttp.send();

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("cargador").innerHTML =
                this.responseText;
            }
        };

        xhttp.open("GET", "carrousel.php", true);
        xhttp.send();
    });






    $("#listadoEstaciones").on('click', function(datos) {

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("cargador").innerHTML =
                this.responseText;
            }
        };
        xhttp.open("GET", "loading.php", true);
        xhttp.send();
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("cargador").innerHTML =
                this.responseText;

            }

        };

        xhttp.open("GET", "listado.php", true);
        xhttp.send();



    });







});


function loader_seccion(link,contenedor) {


// dibujo loader
//  var xhttp = new XMLHttpRequest();
//  xhttp.onreadystatechange = function() {
//     if (this.readyState == 4 && this.status == 200) {
//         document.getElementById(contenedor).innerHTML =
//         this.responseText;
//     }
// };
// xhttp.open("GET", "loading.php", true);
// xhttp.send();
$("#"+contenedor).load("loading.php")

// pagina destino
var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        document.getElementById(contenedor).innerHTML =
        this.responseText;
    }
};
xhttp.open("GET", link, true);
xhttp.send()

}