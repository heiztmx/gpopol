<nav id=""  class="navbar navbar-expand-lg navbar-light bg-light m-5 fixed-top col-lg-12 mx-auto" style="border:0px #343A40 solid; margin-top:25px;  ">

   <div class="row col-lg-10 mx-auto " >

    

 
     <ul class="nav  mx-auto ">
      <?php 
       $objeto->traer_permiso_x_usuario_submenu($_SESSION["user"],"PRODUCTOS",'contenedor_productos');

      ?>

    </ul>

  

  </div>
</nav>