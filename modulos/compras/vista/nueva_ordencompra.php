


<?php 
include "../../../conexion/sesion.php";
$ses = new sesion();
$permisos = $ses->validar_sesion();
include '../../../menu/menu2.php' ;


?>
<link rel="stylesheet" href="../../../bootstrapcss/comprascss.css">
<script type="text/javascript" src="../jsCompras/nueva_req.js"></script>
<script type="text/javascript" src="../jsCompras/funCompras.js"></script>
<?php include "../submenus/menu_crear_doc.php"; ?>


<?php 
// include  '../modals/requisiciones.php';
include  '../modals/ordenes_compra.php';
include  '../modals/buscador_productos.php';
include  '../modals/buscador_proveedores.php';
include '../modals/opciones_crear_documentos.php';
include "../metCompras/metCompras.php";
$obj= new Compras();
if ($_SESSION["idgas"] == Null || $_SESSION["idgas"] == "") {
  echo "<div class = 'div_contenedor'>
  <h4  >Usuario web, sin usuario igas en la tabla usuarios</h4></div>";
  exit();
}
$permisos =$obj->permisos_igas($_SESSION["idgas"]);
$gen = $permisos["general"];
?>
<!DOCTYPE html>
<html>
<head>
  <title>Crear requisición</title>

</head>


<body>
  <br>
  <br>
  <br>
  <br>
  <div  class="d-flex col-lg-12 justify-content-start align-items-start ">
    <h4 style="text-align: center;">Nueva orden de pago</h4>
  </div>

  <br><br>
  <form  id="datafiles" method="post" >


    <script type="text/javascript">

    </script>
    <!-- <br><br><br><br><br> -->
    <div class="d-flex col-lg-12 container justify-content-center align-items-center" style="justify-content: center;align-items: center;">

      <div class="form-group col-lg-3">
        <label for="empresas">Empresas</label>
        <select class="form-control" id="empresas" onchange="empresa1()">
          <!-- <option selected=""></option> -->
          <?php 
          for ($i=0; $i < count($permisos["sucursales_dep"]); $i++) { 
            $sucursal = $permisos["sucursales_dep"][$i]["SUCURSAL"];
            $clave_suc_dep =$permisos["sucursales_dep"][$i]["CLAVESUC"];
            echo "<option value=".$clave_suc_dep.">".$gen->reparar_utf8($sucursal)."</option>";
          }
          ?>


        </select>
      </div>
      <div class="form-group col-lg-3">
        <label for="urgencia">Urgencia</label>
        <select class="form-control" id="urgencia">
          <option value="3" selected="">Bajo</option>
          <option value="2">Medio</option>
          <option value="1">Alto</option>
        </select>
      </div>
      <div class="form-group col-lg-3">
        <label for="afectacion">Afectación</label>
        <select class="form-control" id="afectacion">
          <option value="1">Directo al gasto</option>
          <option value="2">Almacen</option>
          <option value="3">Otros</option>

        </select>
      </div>
      <div class="form-group col-lg-3">
        <label for="concepto1">Proveedor</label>
        <input type="text" class="form-control"  id="elegido_proveedores"  tabindex="1" data-toggle="modal" data-target="#modal-proveedores" >
      </div>

      <!-- se guarda el almacen no se necesita mostrar pero si necesita tomar el dato -->
      <div class="form-group col-lg-3 d-none">
        <label for="almacen">Almacen</label>
        <select class="form-control" id="almacen" disabled="" >
          <?php 
          for ($i=0; $i < count($permisos["almacenes"]); $i++) { 
            $sucursal = $permisos["almacenes"][$i]["NOMBRE"];
            $clave = $permisos["almacenes"][$i]["CLAVE"];
            $suc_almacen =$permisos["almacenes"][$i]["SUCURSAL"];
            $combinacion = $clave. "|".$suc_almacen;
            echo "<option value=".$suc_almacen.">00".$clave."-".$gen->reparar_utf8($sucursal)."</option>";
          }
          ?>
          <option value="">Sin almacén</option>
        </select>
      </div>


    </div>
    <div class="d-flex container col-lg-12">
      <!-- <div class="col-lg-12 d-flex" > -->
        <div class="form-group col-lg-3" >
          <label for="departamento">Departamento</label>
          <select class="form-control " id="departamento" disabled="">
            <?php 
            for ($i=0; $i < count($permisos["sucursales_dep"]); $i++) { 
              $sucursal = $permisos["sucursales_dep"][$i]["DEPARTAMENTO"];
              $clave_suc_dep =$permisos["sucursales_dep"][$i]["CLAVESUC"];
              echo "<option value=".$clave_suc_dep.">".$gen->reparar_utf8($sucursal)."</option>";
            }
            ?>

          </select>
        </div>
        <div class="form-group col-lg-3">
          <label for="moneda">Moneda</label>
          <select class="form-control" id="moneda">
            <?php 
            for ($i=0; $i <count($permisos["monedas"]) ; $i++) { 
              $nombre =$permisos["monedas"][$i]["NOMBRE"];
              $clave =$permisos["monedas"][$i]["CLAVE"];
              if ($clave == "MN") {
                echo "<option selected value=".$clave.">".$gen->reparar_utf8($nombre)."</option>";
              }else{
                echo "<option value=".$clave.">".$gen->reparar_utf8($nombre)."</option>";
              }

            }

            ?>
          </select>
        </div>
        <div class="form-group col-lg-3">
          <label for="concepto">Concepto</label>
          <!-- -->
          <textarea class="form-control rounded-0" id="concepto" rows="3" maxlength="79"></textarea>
          <!-- <input type="text" class="form-control"  id="concepto" tabindex="1"> -->

        </div>
        <div class="col-lg-3 d-flex justify-content-center align-items-center">
          <button style="margin-top: -37px;margin-left: -150px;" type="button" class="btn btn-primary" onclick="guardardatos('tabla_nueva_ordenes_compra')" >Guardar</button>

          <!-- onclick="enviar_archivo('tabla_nueva_ordenes_compra')" -->
        </div>
        <!-- </div> -->
      </div>

      <div class="d-flex justify-content-end align-items-end col-lg-12">
        <div class="col-lg-6 d-flex  justify-content-end align-items-end">
         <div class="col-lg-6 mt-1" style="margin-right: 80px">
          <input type="file" name="archivos" id="archivo">
        </div>
        <div class="d-flex justify-content-center align-items-center">


          <div class="col-lg-3" onclick="agregar_registro('tabla_nueva_ordenes_compra')">
            <i class="fas fa-plus-circle fa-2x"></i>
          </div>

          <div class="col-lg-3">
            <i class="fas fa-edit fa-2x "></i>
          </div>

          <div class="col-lg-3 fa-2x" onclick="eliminar_registro('tabla_nueva_ordenes_compra')">
            <i class="fas fa-minus-circle"></i>
          </div>

        </div>
      </div>

    </div>
    <br>
  </form> 
  <table id="tabla_nueva_ordenes_compra" class="display" style="width:100%">
    <thead>
      <tr>
        <th>#</th>
        <th>PDA</th>
        <th>Cod. Prod</th>
        <th>Descripcion</th>
        <th>Cantidad</th>
        <th>Precio Estimado</th>
        <th>Total</th>
      </tr>
    </thead>

  </table>
  <?php

  ?>
</body>
</html>


