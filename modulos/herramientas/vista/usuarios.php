<!-- https://scrimba.com/g/gneuralnetworks -->


<?php 


include "../../../conexion/sesion.php";


$ses = new sesion();

$permisos = $ses->validar_sesion();


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Formulario Usuarios</title>
	<?php include '../../../menu/menu2.php'; 
  $obj = new metodosweb();
  $modulos = $obj->modulos();
  $arrayjs=array();
  $concatenado="";

  ?>
  <script src="../../../modulos/precios/js/guardarUsuarioAjax.js"></script>
  <link rel="stylesheet" href="../../../bootstrapcss/estiloListado.css">
 
</head>
<body>
  <div class="row" ></div>

  <!-- submenu para esta seccion de usuarios -->
<nav id="opcion2" class="navbar navbar-expand-lg m-5 fixed-top col-lg-12 mx-auto border-bottom " style="background-color:#ffc519; !important">
   <div class="row col-lg-8 mx-auto">
    <div class="container d-flex flex-row  col-lg-3 col-sm-6 mx-auto"  >
      <style>a:hover{color:white !important;} a{color:rgba(255,255,255,.5) !important;} </style>
      <a id="new" class="nav-link   far fa-file iconosSubmenu fa-lg  mx-auto" href="#" role="button" 
      aria-haspopup="true" aria-expanded="false"   onclick="Formulario('<?php
        foreach($modulos["modulos_js"] as $value) {
          echo $concatenado=$value."||";}
          
          ?>')"></a>


          <a id="save" class="nav-link   fas fa-save iconosSubmenu fa-lg mx-auto  " href="#" role="button" 
          aria-haspopup="true" aria-expanded="false"    style="display: none;"></a>

          <a id="list" class="nav-link  fas fa-list iconosSubmenu fa-lg mx-auto  " href="#" role="button" 
          aria-haspopup="true" aria-expanded="false"   onclick="OcultarFormulario()" style="display: none;"></a>
        </div>
      </div>
    </nav>

    <div class="m-5 row"></div>


    <div class="w-100 p-3 align-middle font-weight-normal">	
     Usuarios
   </div>

   <div id="cargadorfrm" style="display: none;">
    <?php include 'formularioUsuariosNuevos.php' ?>
  </div>	
  <div id="cargadorfrmModificar" style="display: none;">
    <?php include 'formularioUsuariosModificar.php' ?>
  </div>

  <br>
  <div class="container mx-auto" id="conteTable">
   <table class="table table-hover mx-auto table-sm font-weight-light " id="tablaUsuarios">
    <thead class="">
      <tr class="letras font-weight-bold" style="background-color: #e9ecef">
        <th  class="txtTablaUser font-weight-bold" scope="col">Nombre</th>
        <th class="txtTablaUser ocultar " scope="col">Usuario</th>
        <th class="txtTablaUser ocultar " scope="col">Autorizo</th>
        <th class="txtTablaUser ocultar " scope="col">Fecha</th>
        <th class="txtTablaUser " scope="col"></th>
        <th class="txtTablaUser " scope="col"></th>
        <!--   <th class="txtTablaUser " scope="col"></th> -->
      </tr>
    </thead>
    <tbody>

     <?php 
     $met = new metodosweb();
     $metodo =$met->traerUsuarios($_SESSION["user"]);
     while ($user=ibase_fetch_assoc($metodo)) {
      $usuario="";
		 	$usuario =$user["IDUSUARIO"]."||".$user["NOMBRE"]."||".$user["USUARIO"]."||".$user["EMAIL"];
		 	

      ?>

      <tr  style="cursor: pointer;"  >
        <th   class="txtTablaUser font-weight-normal"  scope="row"><?php echo $user["NOMBRE"]; ?></th>
        <td  class="ocultar txtTablaUser font-weight-normal" ><?php echo $user["USUARIO"]; ?></td>
        <td class="ocultar txtTablaUser font-weight-normal"><?php echo $user["AUTORIZO"]; ?></td>
        <td class="ocultar txtTablaUser font-weight-normal"><?php echo $user["FECHA"]; ?></td>
  
        <td><i onclick="taer_datos_usuarios('<?php foreach($modulos["modulos_js"] as $value) {
          echo $concatenado=$value."||";}echo "***".$usuario  ?>')"  id="modUser" class="fas fa-user-edit"></i></td> 
        <td><i onclick="EliminarUsuarios('<?php echo $usuario; ?>')"  class="fas fa-trash-alt"></i></td>
      </tr>
      <?php


    } ?>
  </tbody>
</table>
</div>

</body>
</html>

