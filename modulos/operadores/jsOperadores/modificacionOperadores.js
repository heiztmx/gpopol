  function formularioOperadores(datosOperador, estaciones, ids) {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
              document.getElementById("cargadorOperadores").innerHTML =
                  this.responseText;
          }
        document.getElementById('saveOperadores').setAttribute("onclick", "GuardarModifiOperador('"+estaciones1+"');");

          datosFormulario(datosOperador, estaciones, ids);
      };
      xhttp.open("GET", "frmOperadores.php", true);
      xhttp.send();


      $("#saveOperadores").css({ "display": "inline" });
      $(".botonAgregar").css({ "display": "none" });
     
      $("#buscadorOperadores").css({ "display": "none" });
      $("#tituloOperadores").css({ "display": "none" });

      window.scrollTo(0, 0);

  }

  function formularioNewUsuario(botonAgregar) {

      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
              document.getElementById("cargadorOperadores").innerHTML =
                  this.responseText;
          }
          ultimoFolio();
      };
      xhttp.open("GET", "frmOperadores.php", true);
      xhttp.send();
      $("#saveOperadores").css({ "display": "inline" });
      document.getElementById('saveOperadores').setAttribute("onclick", "GuardarNuevoOperador('"+estaciones1+"');");

     
      $("#impresionOperadores").css({ "display": "none" });
      $("."+botonAgregar).css({ "display": "none" });
      $("#buscadorOperadores").css({ "display": "none" });
      $("#tituloOperadores").css({ "display": "none" });


      window.scrollTo(0, 0);

  }

  function ultimoFolio() {
      parametros = {};
      $.ajax({
          type: 'POST',
          url: '../webOperadores/ultimoFolDespachador.php',
          data: parametros,
          success: function(respuesta) {
              $("#inputIDOperador").val(respuesta);
          }
      });
  }

  function datosFormulario(datosOperador, estaciones, ids) {

      subDatos = datosOperador.split("||");
      subEstaciones = estaciones.split("--");
      subIds = ids.split('/');
      subIds.pop();
      subEstaciones.pop();
      for (i = 0; i < subEstaciones.length; i++) {
          if (subDatos[2] == subEstaciones[i]) {
              $("#selectEstacion").val(subIds[i]);
              break;
          }
      }
      $("#inputIDOperador").val(subDatos[0]);
      $("#inputNombreOperador").val(subDatos[1]);
      $("#inputPasswordOperador").val(subDatos[6]);


      if (subDatos[3] == "Si") {
          $("#chbActivo").prop("checked", true);

      } else {
          $("#chbActivo").prop("checked", false);
      }

      if (subDatos[4] == "Si") {
          $("#chbJefe").prop("checked", true);

      } else {
          $("#chbJefe").prop("checked", false);
      }

      if (subDatos[5] == "Global") {
          $("#tipo").val("Global");

      } else {
          $("#tipo").val("Local");
      }



  }

  function GuardarNuevoOperador(estaciones) {

      subEstaciones = estaciones.split("||");
      subEstaciones.pop();
      id = $("#inputIDOperador").val();
      nombre = $("#inputNombreOperador").val();
      password = $("#inputPasswordOperador").val();
      estacion = $("#selectEstacion option:selected").val();
      activo = "";
      jefe = "";
      tablaRespuesta = "";
      if ($("#chbActivo").prop("checked") == true) {
          activo = "Si";
      } else {
          activo = "No";
      }

      if ($("#chbJefe").prop("checked") == true) {
          jefe = "Si";
      } else {
          jefe = "No";
      }

      tipo = $("#tipo option:selected").val();

      if (nombre != "" && password != "") {
          loadPag();
          parametros = {
              "idOperador": id,
              "nombre": nombre,
              "estacion": estacion,
              "password": password,
              "activo": activo,
              "jefe": jefe,
              "tipo": tipo
          }

          $.ajax({
              type: 'POST',
              url: '../webOperadores/insertOperadores.php',
              data: parametros,
              success: function(respuesta) {
                  console.log(respuesta)
                  subRespuestas = respuesta.split("||");
                  paloma = "<img src='../imagenes/v01.png' class ='imagenesTabla'>";
                  tacha = "<img src='../imagenes/x01.png' class ='imagenesTabla'>";

                  var ultimoDato = subRespuestas.pop();

                  if (respuesta == "Error") {
                      Swal({
                          type: 'error',
                          title: 'Oops...',
                          text: 'No se ha podido realizar la accion intentelo de nuevo',
                          footer: '<a href ="#">Si el problema persiste favor de llamar a sistemas</a>'
                      })
                      setTimeout("location.href = 'Operadores_Estaciones.php'", 3000);
                  } else if ((subRespuestas.length > 0) && (ultimoDato === "insertado" || ultimoDato === "actualizado")) {

                      tablaRespuesta = "<table class='table table-sm'><thead><tr><th scope='col'>Estacion</th><th scope='col'>Resultado</th></tr></thead>" +
                          "<tbody>";
                      // subEstaciones.pop();
                      for (i = 0; i < subEstaciones.length; i++) {
                          tablaRespuesta += "<tr>";
                          if (subEstaciones[i] == subRespuestas[i]) {
                              tablaRespuesta += "<td scope='row'>" + subEstaciones[i] + "</td>";
                              tablaRespuesta += "<td scope='row'>" + paloma + "</td>"
                          } else {
                              tablaRespuesta += "<td scope='row'>" + subEstaciones[i] + "</td>";
                              tablaRespuesta += "<td scope='row'>" + tacha + "</td>"
                          }
                          tablaRespuesta += "</tr>";
                      }

                      tablaRespuesta += " </tbody></table>";

                      Swal({
                          type: 'success',
                          title: 'Guardado en:',
                          html: '' + tablaRespuesta,
                          footer: '<a href>para alguna duda, confirmar con sistemas</a>'
                      });
                      setTimeout("location.href = 'Operadores_Estaciones.php'", 8000);
                  } else if (respuesta == "InsertadoLocal" || respuesta == "UpdateLocal") {
                      Swal('Datos ', 'Datos guardados Existosamente', "success");
                      setTimeout("location.href = 'Operadores_Estaciones.php'", 8000);
                  } else if (ultimoDato === "Error_Local" || respuesta === "Error_Local") {
                      Swal({
                          type: 'info',
                          title: 'Oops...',
                          text: 'No se pudo guardar para el modulo de liquidaciones, intentelo de nuevo',
                          footer: '<a href ="#">Si el problema persiste favor de llamar a sistemas</a>'
                      });
                      setTimeout("location.href = 'Operadores_Estaciones.php'", 8000);
                  } else if (respuesta === "ExistePassword") {
                      Swal({
                          type: 'info',
                          title: 'Oops...',
                          text: 'El NIP ya existe',
                          footer: '<a href ="#">Si el problema persiste favor de llamar a sistemas</a>'
                      });
                      // setTimeout("location.href = 'Operadores_Estaciones.php'",3000);
                  } else {
                      Swal({
                          type: 'error',
                          title: 'Oops...',
                          text: 'Problemas con la conexion a las estaciones',
                          footer: '<a href ="#">Si el problema persiste favor de llamar a sistemas</a>'
                      })
                  }



              }
          });
          return false;

      } else {
          Swal('Oops', 'Favor de llenar el campo nombre y/o password', 'warning');
      }

  }

  function GuardarModifiOperador(estaciones) {
      loadPag();
      subEstaciones = estaciones.split("||");
      id = $("#inputIDOperador").val();
      nombre = $("#inputNombreOperador").val();
      estacion = $("#selectEstacion option:selected").val();
      password = $("#inputPasswordOperador").val();

      if ($("#chbActivo").prop("checked") == true) {
          activo = "Si";
      } else {
          activo = "No";
      }

      if ($("#chbJefe").prop("checked") == true) {
          jefe = "Si";
      } else {
          jefe = "No";
      }

      tipo = $("#tipo option:selected").val();

      if (nombre != "" && password != "") {

          parametros = {
              "idOperador": id,
              "nombre": nombre,
              "estacion": estacion,
              "password": password,
              "activo": activo,
              "jefe": jefe,
              "tipo": tipo
          }

          $.ajax({
              type: 'POST',
              url: '../webOperadores/modiOperadores.php',
              data: parametros,
              success: function(respuesta) {
                  console.log(respuesta);
                  paloma = "<img src='../imagenes/v01.png' class ='imagenesTabla'>";
                  tacha = "<img src='../imagenes/x01.png' class ='imagenesTabla'>";


                  subRespuestas = respuesta.split("||");


                  var ultimoDato = subRespuestas.pop();

                  if (respuesta == "Error") {
                      Swal({
                          type: 'error',
                          title: 'Oops...',
                          text: 'No se ha podido realizar la accion intentelo de nuevo',
                          footer: '<a href ="#">Si el problema persiste favor de llamar a sistemas</a>'
                      });
                      setTimeout("location.href = 'Operadores_Estaciones.php'", 3000);
                  } else if ((subRespuestas.length > 0) && (ultimoDato === "insertado" || ultimoDato === "actualizado")) {

                      tablaRespuesta = "<table class='table table-sm'><thead><tr><th scope='col'>Estacion</th><th scope='col'>Resultado</th></tr></thead>" +
                          "<tbody>";
                      subEstaciones.pop();

                      for (i = 0; i < subEstaciones.length; i++) {
                          tablaRespuesta += "<tr>";
                          if (subEstaciones[i] == subRespuestas[i]) {
                              tablaRespuesta += "<td scope='row'>" + subEstaciones[i] + "</td>";
                              tablaRespuesta += "<td scope='row'>" + paloma + "</td>"
                          } else {
                              tablaRespuesta += "<td scope='row'>" + subEstaciones[i] + "</td>";
                              tablaRespuesta += "<td scope='row'>" + tacha + "</td>"
                          }
                          tablaRespuesta += "</tr>";
                      }

                      tablaRespuesta += " </tbody></table>";

                      Swal({
                          type: 'success',
                          title: 'Actualizado en',
                          html: '' + tablaRespuesta,
                          footer: '<a href>para alguna duda, confirmar con sistemas</a>'
                      });
                      // setTimeout("location.href = 'Operadores_Estaciones.php'", 3000);
                  } else if (respuesta == "InsertadoLocal" || respuesta == "UpdateLocal") {
                      Swal('Datos ', 'Datos guardados Existosamente', "success");
                      // setTimeout("location.href = 'Operadores_Estaciones.php'", 3000);
                  } else if (ultimoDato === "insertado" || ultimoDato === "actualizado") {
                      Swal({
                          type: 'info',
                          title: 'Oops...',
                          text: 'No se pudo guardar para el modulo de liquidaciones, intentelo de nuevo',
                          footer: '<a href ="#">Si el problema persiste favor de llamar a sistemas</a>'
                      })
                      // setTimeout("location.href = 'Operadores_Estaciones.php'", 3000);
                  } else if (respuesta === "ExistePassword") {
                      Swal({
                          type: 'info',
                          title: 'Oops...',
                          text: 'El NIP ya existe',
                          footer: '<a href ="#">Si el problema persiste favor de llamar a sistemas</a>'
                      });
                      // setTimeout("location.href = 'Operadores_Estaciones.php'",3000);
                  } else {
                      Swal({
                          type: 'error',
                          title: 'Oops...',
                          text: 'Problemas con la conexion a las estaciones',
                          footer: '<a href ="#">Si el problema persiste favor de llamar a sistemas</a>'
                      });
                      // setTimeout("location.href = 'Operadores_Estaciones.php'", 3000);

                  }
              }
          });
          return false;

      } else {
          Swal('Oops', 'Verifica los campos nombre y/o password alguno esta vacio', 'warning');
      }

  }


  function loadPag(argument) {
      // body...
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
              document.getElementById("cargadorOperadores").innerHTML =
                  this.responseText;
          }
          $("#contenedor_tabla").css({ "display": "none" });
      };
      xhttp.open("GET", "loading.php", true);
      xhttp.send();




  }