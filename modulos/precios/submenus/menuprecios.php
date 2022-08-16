
<?php
    $cadena="";
      foreach($arrayIP as $ip){
        $cadena.=$ip."||";
      }
  ?>
  <script>
    var cadena = "<?php echo $cadena ;?>"

  </script>



<nav id="opcion1" class="navbar navbar-expand-lg navbar-light bg-light m-5 fixed-top col-lg-12 mx-auto" style="border:1px #EBEDEF solid; margin-top:25px; display: none; ">
  <div class="row col-lg-10 mx-auto " >

    <ul class="nav  mx-auto ">
      <?php 
     
  

      $objeto->traer_permiso_x_usuario_submenu($_SESSION["user"],"PRECIOS",'cargador');



    ?>

    


  </ul>
</div>
</nav>