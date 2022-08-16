  



  function seccionModificarCliente() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("CargadorClienteCreditos").innerHTML =
        this.responseText;
      }
    };
    xhttp.open("GET", "limClientesCredito.php", true);
    xhttp.send();
      // $("#CargadorClienteCreditos").load("limClientesCredito.php");
    }



    function consultaCredito1() {
      loading();


      $("#CargadorClienteCreditos").load("clientesCredito.php");
    }


    function AgregarCreditoCliente() {



      $("#CargadorClienteCreditos").load("asignarCreditoCli.php");

    }








    function TarjetasAsignadas() {

      $("#CargadorClienteCreditos").load("TarjetasAsignadas.php");


    }



    function consultaPrepago() {

      loading();


      $("#CargadorClienteCreditos").load("clientesPrepagos.php");


    }

    function loading() {
      // body...

      $("#CargadorClienteCreditos").load("loading.php");

    }

    function buscadorPP() {
      // body...

      $("#buscadorNombre").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTablePP #contenido_clientesPP").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    }


    function buscadorCO() {
      // body...

      $("#buscadorNombreCO").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTableCO #contenido_clientesConsultaCO").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    }

    
    function alertr() {
    // body...
    Swal({
      type: 'success',
      title: 'Exitoso',
      html: 'El monto del credito  fue guardado Exitosamente <br> El registro de tarjetas fue guardado Exitosamente',
      allowOutsideClick: false,
      footer: '<a id="enlace"  target="_blank">Excel</a>'
    }).then((result) => {
      if (result.value) {
        alert("hola ")
      }
    })
  }