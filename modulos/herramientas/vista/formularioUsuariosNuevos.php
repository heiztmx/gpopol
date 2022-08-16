<script src="../js/clickModulo1.js"></script>

<div class="container mx-auto d-flex flex-wrap"  id="formulario">

	

	<form class="col-lg-6" >
    <div class="form-group col-lg-12 mx-auto">
      <input type="text" id="idUsuario" style="display: none;">
      <label for="exampleInputEmail1">Nombre</label>
      <input type="email" class="form-control" id="nombre" aria-describedby="emailHelp" placeholder="Nombre">

    </div>
    <div class="form-group col-lg-12 mx-auto">
      <label for="exampleInputPassword1">Usuario</label>
      <input type="text" class="form-control" id="usuario" placeholder="Usuario">
    </div>
    <div class="form-group col-lg-12 mx-auto">
      <label for="exampleInputPassword1">Email</label>
      <input type="email" class="form-control" id="email" placeholder="correo electronico" >
    </div>
    <div class="form-group col-lg-12 mx-auto">
      <label for="exampleInputPassword1">Password</label>
      <input type="password" class="form-control" id="password" placeholder="Password" >
      <small id="emailHelp" class="form-text text-muted">Usa una contraseña que contenga letras y numeros</small>
    </div   >
  </form>
  <div class="col-lg-6 mx-auto">

    <div id="accordion">
     <?php 

     $onclick="";
     $contPES=0;
     $boton_toggle ='';
     for($i=0; $i<count($modulos["modulos"]); $i++)
     {
  // array_push($arrayjs, $modulos["modulos_js"][$i]);

       ?> 
       <div class="card">
        <div class="card-header" id="heading<?php echo $modulos["modulos_js"][$i]  ?>">
          <h5 class="mb-0">

           <button class="btn btn-link collapsed"  data-toggle="collapse" data-target="#collapse<?php echo $modulos["modulos_js"][$i]  ?>" aria-expanded="false" aria-controls="collapse<?php echo $modulos["modulos_js"][$i]  ?>">
            <?php  echo $modulos["modulos"][$i]?>
          </button>

        </h5>
      </div>
      <div id="collapse<?php echo $modulos["modulos_js"][$i]  ?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
        <div class="card-body">

         <div class="form-check">
           <!-- 	<input class="form-check-input" type="checkbox" id="preciosx" value="Modulo1" onclick="BloquearOpcPrecios('<?php //echo $modulos["modulos_js"][$i] ?>');" > -->
           <!-- <label class="form-check-label" for="preciosx"> -->
        <!--      <input type="checkbox" onclick="bloquear(<?php //echo $modulos["modulos"][$i] ?>)">
         <label for="">Todos</label> -->
     <!--     <?php 
          // strtolower($modulos["modulos"][$i]);

        //echo ucfirst(strtolower($modulos["modulos"][$i])) ?> --><!-- </label> -->

      </div>
      <div class="d-flex flex-wrap justify-content-between  flex-column-reverse m-2">
        <?php 
        for ($z=0; $z < count($modulos["permisos"]); $z++) { 
          if($modulos["permisos"][$z]["NOMBRE_JS"] == $modulos["modulos_js"][$i])
          {
            $nomcheck=$modulos["permisos"][$z]["PERMISO_JS"];
            $nombre_permiso =$modulos["permisos"][$z]["PERMISO"];
            if ($nomcheck == "AUT1COMPRA" || $nomcheck == "AUT2COMPRA") {
              $aut1 ="AUT1COMPRA"; 
              $aut2="AUT2COMPRA";
              $onclick="onclick=bloquear_check('".$aut1."','".$aut2."')";
            }
            if($nomcheck == "ALLORDENCOMPFIL" ){
              $all1= "ALLORDENCOMPFIL";
              $all2= "ALLORDENCOMP";
              $onclick = "onclick=bloquear_check('".$all1."','".$all2."')";
            }
            if($nomcheck == "ALLREQFIL" ){
              $all1= "ALLREQFIL";
              $all2= "ALLREQ";
              $onclick = "onclick=bloquear_check('".$all1."','".$all2."')";
            }
            if($nomcheck == "RECCUPONFIL" ){
              $all1= "RECCUPONFIL";
              $all2= "RECCUPON";
              $onclick = "onclick=bloquear_check('".$all1."','".$all2."')";
            }
            if($nomcheck == "REPCUPONFIL" ){
              $all1= "REPCUPONFIL";
              $all2= "REPCUPON";
              $onclick = "onclick=bloquear_check('".$all1."','".$all2."')";
            }
            ?>
            <div class="form-check ">
             <input class="form-check-input" type="checkbox" <?php echo $onclick; ?> name="<?php echo $modulos["modulos_js"][$i] ?>[]" id="check<?php echo $nomcheck  ?>" value="<?php echo $nomcheck ?>">

             <label class="form-check-label" for="check<?php echo $nomcheck   ?>">
              <?php echo  ucfirst(strtolower($nombre_permiso ) );?>
            </label>
            <?php 
            if ($nomcheck == "ALLORDENCOMPFIL" || $nomcheck == "ALLREQFIL" || $nomcheck == "RECCUPONFIL"  || $nomcheck == "REPCUPONFIL" ) {
              echo     $boton_toggle ='<i class="fas fa-sort-down" data-toggle="collapse" href="#div'.$nomcheck.'" role="button" aria-expanded="false" aria-controls="div'.$nomcheck.'" style="margin-left:15px;"></i> ';
              
              $contPES++;
              echo "
              <div class='collapse' id='div".$nomcheck."'>
              <div class='card card-body'>
              <div class='form-group col-lg-12'>
              <label for=''>Estaciones</label>
              <input type='text' class='form-control' id='peres_estacion".$nomcheck."'placeholder='Ver estaciones'>
              </div>
              <div class='form-group col-lg-12'>
              <label for=''>Elaboro</label>
              <input type='text' class='form-control' id='peres_elaboro".$nomcheck."' placeholder='Ver elaboro'>
              </div>
              <div class='form-group col-lg-12'>
              <label for=''>Estatus</label>
              <input type='text' class='form-control' id='peres_estatus".$nomcheck."'  placeholder='Ver estatus'>
              </div>
              </div>
              </div>";

            }
            ?>
          </div>

          <?php  


        }

      } ?>


    </div>

  </div>
</div>
</div>

<?php } ?>
<script type="text/javascript">

</script>

</div>

</div>
</div>




<div class="col">
  <div class="collapse multi-collapse" id="multiCollapseExample1">
    <div class="card card-body">
      Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
    </div>
  </div>
</div>
<div class="col">
  <div class="collapse multi-collapse" id="multiCollapseExample2">
    <div class="card card-body">
      Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
    </div>
  </div>
</div>
