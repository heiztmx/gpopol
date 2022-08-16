

<nav id="opcion3" class="navbar navbar-expand-lg navbar-light bg-light m-5 fixed-top col-lg-12 mx-auto" style="border:0px #343A40 solid; margin-top:25px; ">
  <div class="row col-lg-10 mx-auto ">

    <ul class="nav  mx-auto ">
      <?php  

      $estacion="";
      foreach ( $arrayestaciones as $value) {
        $estacion.=$value."||";

      } 
      
      
      ?>

      
      <script>
        var estaciones1 ="<?php echo $estacion; ?>"
      </script>


      <li class="nav-item">
        <a id="saveOperadores" style="display: none;" class="nav-link   fas fa-save iconosSubmenu fa-lg " href="#" role="button" aria-haspopup="true" aria-expanded="false"></a>

      </li>


      <?php 


      $objeto->traer_permiso_x_usuario_submenu($_SESSION["user"],"OPERADORES",'');

      ?>



      <li class="nav-item">
        <a id="listaOperadores"  onclick="" class="nav-link   fas fa-list-ul iconosSubmenu fa-lg " href="index.php" role="button" aria-haspopup="true" aria-expanded="false"></a>

      </li>




    </ul>
  </div>
</nav>