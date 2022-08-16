<?php
session_start();
include "../conexion/sesion.php";
$usuario = $_SESSION['user'];
$logeado = $_SESSION['logeado'];
$ses = new sesion();
$permisos = $ses->validar_sesion($usuario, $logeado);

  ?>
  <!DOCTYPE html>
  <html>

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Listado General</title>


    <link rel="stylesheet" href="../bootstrapcss/estiloListado.css">
    <link rel="stylesheet" href="../bootstrapcss/limclientes.css">

    <script src="../jsClientes/cambioSeccion.js"></script>
    <script src="../jsClientes/buscadorclientes.js"></script>
    <script src="../jsClientes/asignacionTarjetas.js"></script>
    <script src="../jsClientes/opcionesBuscar.js"></script>


    <!-- <script src="../jsClientes/datosClientes.js"></script> -->

  </head>

  <body>
    <?php
    include '../menu/menu2.php';


    ?>
    <script src="../js/clickModulo2.js"></script>


    <div id="CargadorClienteCreditos">

</div>

    <div class="modal fade bd-example-modal-lg" id="generadorExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 3%">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header" style="background-color: #007BFF; color: white">
            <h5 class="modal-title" id="exampleModalLabel">Generar documento de entrega de tarjetas</h5>
            <button type="button" class="close" style="color: white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="col-lg-12">
              <div class="form-group d-flex flex-wrap">
                <label for="recipient-name" class="col-form-label col-lg-4">ID:</label>
                <input type="text" class="form-control col-lg-4" id="id_excel" readonly="">
              </div>
              <div class="form-group d-flex flex-wrap">
                <label for="recipient-name" class="col-form-label col-lg-4">Nombre Comercial <p><font color="#FF0000" size=1>(Informacion impresa en la tarjeta)</font> </p></label>
                <input type="text" class="form-control col-lg-8" id="nombre_excel">
                <input type="text" style="display: none;" id="tipoCli_excel">
              </div>
              <div class="form-group d-flex flex-wrap">
                <label for="recipient-name" class="col-form-label col-lg-4">Mascaras Usadas:</label>
                <select id="mascaras_usadas" class="form-control">

                </select>
              </div>
              <div class=" d-flex flex-wrap col-lg-12">
                <div class="form-group col-lg-6 d-flex flex-wrap ">

                  <div class="form-group col-md-12">
                    <label for="inputState">Inicio</label>
                    <!--   <input type="text" class="form-control col-lg-12" id="tarjetas_inicial"> -->
                    <select id="tar_inicial" class="form-control">

                    </select>
                  </div>
                </div>
                <div class="form-group col-lg-6 d-flex flex-wrap">

                  <div class="form-group col-md-12">
                    <label for="inputState">Final</label>
                    <!--  <input type="text" class="form-control col-lg-12" id="tarjetas_final"> -->
                    <select id="tar_final" class="form-control">

                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" onclick="datos_excel()">Generar Excel</button>
          </div>
        </div>
      </div>
    </div>
  </body>

  </html>

