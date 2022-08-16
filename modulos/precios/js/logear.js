$(document).ready(function() {
    $('body').keyup(function(e) {
        if (e.which == 13) {
            //ejecuto algo
            logear();
        }
    });
});

function logear() {
    // body...

    var user = $('#user').val();
    var password = $('#contr').val();
    var parametros = {
        "user": user,
        "contr": password
    }

    $.ajax({
        type: 'POST',
        url: 'modulos/precios/webprecios/login.php',
        data: parametros,
        success: function(resp) {
            console.log(resp);

            var cadena = resp,
            separador = " ",
            arregloDeSubCadenas = cadena.split(separador);
            links=arregloDeSubCadenas[1].split("||");

            if (arregloDeSubCadenas[0] === "Correcto") {

                for(i=0; i<links.length; i++)
                {
                    if(links[i] != "")
                    {  
                        limpiar = links[i].replace("..","");
                        window.location.href="../gpopol/modulos"+limpiar

                        console.log(limpiar);
                        break;
                    }
                }


            } else {
                $('#errorlogin').css({ "display": "block","text-align": "center","color": "red" });
                 // $('#errorlogin').css({  });
                 // $('#errorlogin').css({  });
                $('#errorlogin').html("Usuario o contraseña incorrectos");
                // setTimeout(borrar,2000);

            }
            // $('#errorlogin').html(arregloDeSubCadenas[0]);
        }
    }); //fin del ajax
    return false
}

function borrar() {
    $('input[type="text"]').val('');
    $('input[type="password"]').val('');
    $('#errorlogin').css({ "display": "none" });
    $("#user").focus();

}