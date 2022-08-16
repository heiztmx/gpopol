



function cargarTablas2() {
    // body...


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



function Enviarfolio(folio) {
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