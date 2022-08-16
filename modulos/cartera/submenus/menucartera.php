
<script src="../../precios/js/cambioSubmenu.js"></script>
<nav id="opcion2" class="navbar navbar-expand-lg navbar-light bg-light m-5 fixed-top col-lg-12 mx-auto" style="border:0px #343A40 solid;  display: inline;">
  <div class="row col-lg-10 mx-auto ">

    <ul class="nav  mx-auto ">
      <?php 


      // usuario , modulo , contenedor donde se ccargaran las demas paginas
      
       $objeto->traer_permiso_x_usuario_submenu($_SESSION["user"],"CARTERA",'CargadorClienteCreditos');


      ?>




    </ul>
  </div>
</nav>