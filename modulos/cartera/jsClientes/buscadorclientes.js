function buscadorClientescredito() {
    // body...

    var consulta;
    //hacemos focus al campo de búsqueda


    //comprobamos si se pulsa una tecla
    // $("#bCR").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#bCR").val();

        //hace la búsqueda
        parametro = {
            "nombre": consulta
        }
        $.ajax({
            type: "POST",
            url: "../webClientes/buscadorTR.php",
            data: parametro,
            dataType: "html",
            beforeSend: function() {
                //imagen de carga
                $("#tablaBusqueda").html("<div  id='loader' class='preloader mx-auto'></div>");
            },
            error: function() {
                Swal({ type: 'error', title: 'Oops...', text: 'Algo salio mal con la busqueda', footer: '<a href ="#">Recarga la pagina si el problema persiste llamar a sistemas</a>' })
            },
            success: function(data) {
                $("#tablaBusqueda").empty();
                $("#tablaBusqueda").append(data);
            }
        });
  
}









function modificacion_clientes(id) {

    nombre = $("#nombrecli"+id).val();
    calle = $("#callecli"+id).val();
    numExt = $("#numeroExtcli"+id).val();
    numInt = $("#numeroIntcli"+id).val();
    cp = $("#cpcli"+id).val();
    contacto = $("#contactocli"+id).val();
    correo = $("#correocli"+id).val();
    metodoPago = $("#metodopagocli"+id+" option:selected").val();

    if($("#activocli"+id).prop("checked"))
    {
        activo ="Si";
    }else{
        activo ="No";
    }
 
    noclie = $("#noclie"+id).val();

    parametros = {
        "nombre": nombre,
        "calle": calle,
        "numExt": numExt,
        "numInt": numInt,
        "cp": cp,
        "contacto": contacto,
        "correo": correo,
        "metodoPago": metodoPago,
        "activo": activo,
        "noclie": noclie

    }

    $.ajax({
        type: 'POST',
        url: '../webClientes/modificarClientes.php',
        data: parametros,
        success: function(respuesta) {
            // console.log(parametros);
            // console.log(respuesta);
            if (respuesta === "modificado") {

                Swal({

                    type: 'success',
                    title: 'Datos Guardados exitosamente',
                    showConfirmButton: true,
                    timer: 4500
                })
            } else {

                Swal({
                    type: 'error',
                    title: 'Error de modificación',
                    text: 'No se pudieron modificar los datos del cliente ',
                    footer: '<a href="#">Si el problema persiste favor de llamar a sistemas</a>'
                })

            }
        }
    });
    return false;

}


function buscador_clientes_modi() {
    // body...


    //obtenemos el texto introducido en el campo de búsqueda
    consulta = $("#bNombre").val();

    //hace la búsqueda
    parametro = {
        "nombre": consulta
    }
    $.ajax({
        type: "POST",
        url: "../webClientes/buscadorModificacion.php",
        data: parametro,
        dataType: "html",
        beforeSend: function() {
            //imagen de carga
            $("#tablaBusqueda").html("<div  id='loader' class='preloader mx-auto'></div>");
        },
        error: function() {
            Swal({ type: 'error', title: 'Oops...', text: 'Algo salio mal con la busqueda', footer: '<a href ="#">Recarga la pagina si el problema persiste llamar a sistemas</a>' })
        },
        success: function(data) {
            $("#tablaBusqueda").empty();
            $("#tablaBusqueda").append(data);
        }
    })


}

function  Activo_Forma(id) {
   activo =$("#activoinput"+id).val();
   pago = $("#metodopagoinput"+id).val();

   if (activo == "Si") {
    
     $("#activocli"+id).attr('checked', true);
   }else{

     $("#activocli"+id).attr('checked', false);
   }

     $("#metodopagocli"+id+" option[value="+pago+"]").attr("selected",true);

}

