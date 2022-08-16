<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />


<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8 " />


<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="../../../bootstrapcss/limclientes.css">


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!-- --------------SweetAlert no las borren es un pedo despues :v ------------------- -->
<script src="../../../javascript/jquery-3.3.1.min.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
<script src="../../../sweetAlert2/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="../../../sweetAlert2/dist/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>

<!-- JavaScript -->
<script src="../../../alertifyjs/alertify.js"></script>
<script src="../../../alertifyjs/alertify.min.js"></script>


<link rel="stylesheet" href="../../../alertifyjs/css/alertify.min.css"/>

<link rel="stylesheet" href="../../../alertifyjs/css/themes/default.min.css"/>
<link rel="stylesheet" href="../../../alertifyjs/css/themes/semantic.min.css"/>
<link rel="stylesheet" href="../../../alertifyjs/css/themes/bootstrap.min.css"/>
<!-- <link rel="stylesheet" href="../../../alertifyjs/css/alertify.rtl.min.css"/>
<link rel="stylesheet" href="../../../alertifyjs/css/themes/default.rtl.min.css"/>
<link rel="stylesheet" href="../../../alertifyjs/css/themes/semantic.rtl.min.css"/>
<link rel="stylesheet" href="../../../alertifyjs/css/themes/bootstrap.rtl.min.css"/>
-->


<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.0/css/all.css" integrity="sha384-aOkxzJ5uQz7WBObEZcHvV5JvRW3TUc2rNPA7pe3AwnsUohiw1Vj2Rgx2KSOkF5+h" crossorigin="anonymous">
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<!-- <script src="../../jsHerramientas/Mascaras.js"></script>
  <script src="../../jsCompras/funCompras.js"></script> -->
  <!-- <script src="../js/mensajePerfil.js"></script> -->
  <!-- <script src="../js/fechainput.js"></script> -->
  <!-- <script src="../js/inactividad.js"></script> -->
  <!-- --------------datepicker bt4------------------- -->

  <!-- data tables libreria -->
<!-- <script src="https://code.jquery.com/jquery-3.3.1.js
  "></script> -->
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js
  "></script>
  <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js
  "></script>
  <script src="https://cdn.datatables.net/fixedcolumns/3.3.0/js/dataTables.fixedColumns.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css
  ">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css
  ">
 

  <link rel="stylesheet" href="../../../contextMenu/jquery.contextMenu.min.css">  
  <script src="../../../contextMenu/jquery.contextMenu.min.js"></script>
  <script src="../../../contextMenu/jquery.ui.position.js"></script>
  <!-- scripts de la seccion de Operadores -->

  <script src="../../../lottie/player/lottie.min.js"></script>
  <script>
    async  function bloquear_liquidacion() {
      ventana_ancho = $(window).width();
      if (ventana_ancho < 1000) {
        $("#boton_menu_responsivo").click()
      }
      const { value: fruit } = await Swal({
        title: 'Interruptor de liquidaciones',
        input: 'select',
        inputOptions: {
          bloquear: 'Bloquear',
          desbloquear: 'Desbloquear'
        },
        inputPlaceholder: '¿Qu\u00E9 desea hacer?',
        showCancelButton: true,
        inputValidator: (value) => {
          return new Promise((resolve) => {

            if (value === 'bloquear') {
             request = ajax_envio("bloquear")
             resolve(request)
           } else if(value === "desbloquear") {
             request =  ajax_envio("desbloquear")
             resolve(request)
           }else{
             resolve('Debes de elegir una acción')
           }
         })
        }
      })

// if (fruit) {
//   Swal('You selected: ' + fruit)
// }
}


function ajax_envio(opcion) {
  parametros = {
    "opcion":"activacion_liquidaciones",
    "activacion":opcion
  }
  mensaje = ""
  mensaje2 = ""
  if (opcion === "bloquear") {
    mensaje = "Bloqueada"
    mensaje2 = "Bloquear"
  }
  if (opcion  === "desbloquear") {
    mensaje ="Desbloqueda";
    mensaje2 = "Desbloquear"
  }
  
  $.ajax({
    type:"POST",
    url:"../../../general/funciones.php",
    data:parametros,
    success:function(respuesta){
      console.log(respuesta)
      datos=JSON.parse(respuesta);
      if (datos["respuesta"] === "bien") {

        Swal({
          type: 'success',
          title: 'Liquidaciones',
          text: 'La liquidacion fue '+mensaje,
          footer: '<a href></a>'
        })
      }else{
       Swal({
        type: 'error',
        title: 'Liquidaciones.',
        text: 'No se pudo '+mensaje2,
        footer: '<a href>Favor de llamar a sistemas</a>'
      })
     }
   }
 });
  return resultado
}
</script>



<?php


include '../../precios/webprecios/metodosweb.php';


$objeto = new metodosweb();
$estaciones = $objeto->tablaEstaciones();
$arrayestaciones = array();
$arrayIP = array();
$estaciones_check =array();
$Estaciones ="";
$ips_sincronizar = array();
$ids_estaciones= array();
while ($row = ibase_fetch_assoc($estaciones)) {
  array_push($arrayestaciones, $row['ESTACION']);
  array_push($arrayIP, $row["IP"]);
  $Estaciones .= $row["ESTACION"];
  array_push($estaciones_check,$row['ESTACION']);
  array_push($ips_sincronizar, $row["IP"]);
  array_push($ids_estaciones, $row["ID"]);
}

?>
<link rel="stylesheet" href="../../../bootstrapcss/iconos.css">
<!-- z-index: 10000" -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top font-weight-bold" style="font-family: 'Poppins',Helvetica,Arial,Lucida,sans-serif;margin-bottom:50px;z-index:2000;background-color:#e22d2b !important;">
  <a class="navbar-brand" href="#">
    <img src="../../../imagenes/logo_normal.png" alt="Logo" style="width:150px;">
  </a>
  <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" id="boton_menu_responsivo">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">

      <?php

      // Sacar url completo y secciones actuales
      function seccionb(){
      $url = explode("/",$_SERVER["REQUEST_URI"]);
      $seccion = $url[3];
      $subseccion = $url[2];

      if($seccion == "") { $seccion = "inicio"; }
      return $seccion;
      }

      $contAdm = 0;
      $i = 1;


      $herramientas_nombre = array();
      $herramientas_link = array();
      for ($i = 0; $i < count($permisos["modulos_autorizados"]); $i++) {

        $link = $permisos["link_modulos"][$i];
        $nombre = $permisos["modulos_autorizados"][$i];
        if ($nombre  != "HERRAMIENTAS") {
          $newnombre= ucfirst(strtolower($nombre));                   
          $seccion=seccionb();
          $classm=activar($nombre,$seccion);
          //echo $seccion;
          echo " <li class='nav-item " . $classm . "'>
           <a   id=" . $nombre . " class='nav-link' href='../" . $link . "' >" . $newnombre . "<span class='sr-only'>(current)</span></a>
         </li>";
       }else{
        array_push($herramientas_nombre, $nombre);
        array_push($herramientas_link, $link);
       }

     }

     $objeto->opciones_Herramientas($_SESSION["user"])
     ?>



   </ul>
   <form class="form-inline my-2 my-lg-0">
    <label style="color: white;  margin-right: 25px;" for="">Bienvenido <a style="margin-left: 10px; color: white" href="#"><?php echo $_SESSION["user"]; ?></a></label>

    <button style="margin-left: 10px;" class="btn btn-outline-warning my-2 my-sm-0"><a href="../../../cerrarsesion.php" style="text-decoration:none; color: white">Cerrar Sesion</a></button>
  </form>

</div>

</nav>

<div class="row "></div>







<div class="row"></div>


<!-- 
<div class="row"></div>
-->
</nav>

