<script src="../js/clickModulo1.js"></script>

<div class="container mx-auto d-flex flex-wrap"  id="formulario">

	

	<form class="col-lg-6" >
    <div class="form-group col-lg-12 mx-auto">
      <input type="text" id="idUsuarioM" style="display: none;">
      <label for="exampleInputEmail1">Nombre</label>
      <input type="email" class="form-control" id="nombreM" aria-describedby="emailHelp" placeholder="Nombre" >

    </div>
    <div class="form-group col-lg-12 mx-auto">
      <label for="exampleInputPassword1">Usuario</label>
      <input type="text" class="form-control" id="usuarioM" placeholder="Usuario" readonly="">
    </div>
    <div class="form-group col-lg-12 mx-auto">
      <label for="exampleInputPassword1">Email</label>
      <input type="email" class="form-control" id="emailM" placeholder="correo electronico" >
    </div>
    <div class="form-group col-lg-12 mx-auto">
      <label for="exampleInputPassword1">Password</label>
      <input type="password" class="form-control" id="passwordM" placeholder="Password">
      <small id="emailHelp" class="form-text text-muted">Usa una contraseña que contenga letras y numeros</small>
    </div>
  </form>
  <div class="col-lg-6 mx-auto">

    <div id="accordion">
     <?php 

     $onclick="";
     

     for($i=0; $i<count($modulos["modulos"]); $i++)
     {
  // array_push($arrayjs, $modulos["modulos_js"][$i]);
       
       ?> 
       <div class="card">
        <div class="card-header" id="heading<?php echo $modulos["modulos_js"][$i]  ?>">
          <h5 class="mb-0">

           <button class="btn btn-link collapsed"  data-toggle="collapse" data-target="#collapse<?php echo $modulos["modulos_js"][$i]."M"  ?>" aria-expanded="false" aria-controls="collapse<?php echo $modulos["modulos_js"][$i]."M"  ?>">
            <?php  echo $modulos["modulos"][$i]?>
          </button>

        </h5>
      </div>
      <div id="collapse<?php echo $modulos["modulos_js"][$i]."M"  ?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
        <div class="card-body">

         <div class="form-check">

          <label class="form-check-label" for="preciosx">Permisos  <?php 

          echo ucfirst(strtolower($modulos["modulos"][$i])) ?></label>
        </div>
        <div class="d-flex flex-wrap justify-content-between  flex-column-reverse m-2">
          <?php 
          for ($z=0; $z < count($modulos["permisos"]); $z++) { 
            if($modulos["permisos"][$z]["NOMBRE_JS"] == $modulos["modulos_js"][$i])
            {
              $nomcheck=$modulos["permisos"][$z]["PERMISO_JS"];
              $nombre_permiso =$modulos["permisos"][$z]["PERMISO"];
              if ($nomcheck == "AUT1COMPRA" || $nomcheck == "AUT2COMPRA") {
                $onclick="onclick='validar_autorizador_update()'";
              }
              if($nomcheck == "ALLORDENCOMPFIL" ){
                $all1= "ALLORDENCOMPFIL";
                $all2= "ALLORDENCOMP";
                $onclick = "onclick=bloquear_check('".$all1."M','".$all2."M')";
              }
              if($nomcheck == "ALLREQFIL" ){
                $all1= "ALLREQFIL";
                $all2= "ALLREQ";
                $onclick = "onclick=bloquear_check('".$all1."M','".$all2."M')";
              }
              if($nomcheck == "RECCUPONFIL" ){
                $all1= "RECCUPONFIL";
                $all2= "RECCUPON";
                $onclick = "onclick=bloquear_check('".$all1."M','".$all2."M')";
              }
              if($nomcheck == "REPCUPONFIL" ){
                $all1= "REPCUPONFIL";
                $all2= "REPCUPON";
                $onclick = "onclick=bloquear_check('".$all1."M','".$all2."M')";
              }              
              ?>
              <div class="form-check ">
                <input class="form-check-input" type="checkbox" <?php echo $onclick; ?> name="<?php echo $modulos["modulos_js"][$i]."M" ?>[]" id="check<?php echo $nomcheck."M"  ?>" value="<?php echo $nomcheck ?>">
                <label class="form-check-label" for="check<?php echo $nomcheck."M"   ?>">
                  <?php echo  ucfirst(strtolower($nombre_permiso)) ?>
                </label>
                <?php 
                if ($nomcheck == "ALLORDENCOMPFIL" || $nomcheck == "ALLREQFIL" || $nomcheck == "RECCUPONFIL" || $nomcheck == "REPCUPONFIL") {
                  echo     $boton_toggle ='<i class="fas fa-sort-down" data-toggle="collapse" href="#div'.$nomcheck.'M" role="button" aria-expanded="false" aria-controls="div'.$nomcheck.'M" style="margin-left:15px;"></i> ';

                  $contPES++;
                  echo "
                  <div class='collapse' id='div".$nomcheck."M'>
                  <div class='card card-body'>
                  <div class='form-group col-lg-12'>
                  <label for=''>Estaciones</label>
                  <input type='text' class='form-control' id='peres_estacion".$nomcheck."M' placeholder='Ver estaciones'>
                  </div>
                  <div class='form-group col-lg-12'>
                  <label for=''>Elaboro</label>
                  <input type='text' class='form-control' id='peres_elaboro".$nomcheck."M' placeholder='Ver elaboro'>
                  </div>
                  <div class='form-group col-lg-12'>
                  <label for=''>Estatus</label>
                  <input type='text' class='form-control' id='peres_estatus".$nomcheck."M'  placeholder='Ver estatus'>
                  </div>
                  </div>
                  </div>";

                }
                ?>
              </div>

            <?php   }

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