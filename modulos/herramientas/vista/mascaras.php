<?php 

include "../../../conexion/sesion.php";


$ses = new sesion();

$permisos = $ses->validar_sesion();


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Herramientas</title>
  <script src="../../../javascript/jquery-3.3.1.min.js"></script>
  <script src="../jsHerramientas/Mascaras.js"></script>

</head>
<body>
  <?php 
  include '../../../menu/menu2.php';
  include '../../cartera/metGASOLINERA/metodosGASOLINERA.php';

  $objeto = new GASOLINERA();
  $arrayMascaras = $objeto->Mascaras();
  $cadena="";


  




  ?>

  <nav id="opcion1" class="navbar navbar-expand-lg navbar-light bg-light m-5 fixed-top col-lg-12 mx-auto" style="border:1px #EBEDEF solid; margin-top:25px;">
    <div class="row col-lg-10 mx-auto " >

      <ul class="nav  mx-auto ">
    <!--    <li class="nav-item">
 
    <a id="portada" class="nav-link   fas fa-home iconosSubmenu fa-lg  " href="#" role="button" 
       aria-haspopup="true" aria-expanded="false"></a>
     </li> -->

     <li class='nav-item'>
      
      <a id='agregarPrecio' style="color: #007BFF" class='btn btn-link   fas fa-plus-circle iconosSubmenu fa-lg' data-toggle="modal" data-target=".bd-example-modal-lg"></a>
    </li>
    
    
    <li class="nav-item dropdown">

      <a class="nav-link dropdown-toggle fas fa-cogs fa-lg  iconosSubmenu " data-toggle="dropdown" href="#" role="button" 
      aria-haspopup="true" aria-expanded="false"> 
    </a>
    <ul class="dropdown-menu">
      <li id=""  class="dropdown-item" style="cursor: pointer;" data-toggle="modal" data-target="#modal_canceladas_mascaras">Mascaras desactivadas</li>
      <li id="listadoEstaciones" class="dropdown-item" href="#">Opción 2 </li>
      <li id="Agregarcredito"  class="dropdown-item" href="#">Opción 3</li>
      
    </ul>
  </li>

  

  
</ul>
</div>
</nav>
<br>
<br>
<br>
<br>
<br>
<br>


<div id="formulario_mascaras">
  
</div>
<div id="Herramientas">
  

  <h4 style=" font-weight: bold; position: relative; top: -25px;">Catalogo de mascaras de tarjetas </h4>

  <div class="col-lg-12 mb-5 " >
    <div class="form-inline mx-auto col-lg-6" style="display: flex;justify-content: center;align-items: center;">
     <button class="btn btn-primary" style="margin-right: 5%" onclick="Activar_mascara()">
      Predeterminar
    </button>
    <select class="custom-select my-1 mr-sm-2" id="listaMascaras">
      <?php 
      for($i=0;  $i<count($arrayMascaras);  $i++){
        
        if ($arrayMascaras[$i]["ESTATUS"] == "P") {
          echo "<option selected value=".$arrayMascaras[$i]["MASCARA"].">".$arrayMascaras[$i]["MASCARA"]."</option>";
        }else{
         echo "<option  value=".$arrayMascaras[$i]["MASCARA"].">".$arrayMascaras[$i]["MASCARA"]."</option>";
       }
       
     }

     ?>


   </select>
   
 </div>
</div>
<div id="accordion">
	<?php 
   for($i=0;  $i<count($arrayMascaras);  $i++)
  { 
   
    ?>
    <div class="card">
      <div class="card-header" id="headin<?php echo $arrayMascaras[$i]["ID"];?>">
        <h5 class="mb-0">
          <button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?php echo $arrayMascaras[$i]["ID"] ?>" aria-expanded="true" aria-controls="collapse<?php echo $arrayMascaras[$i]["ID"] ?>"  onclick="Usadas_mascaras('<?php echo $arrayMascaras[$i]["MASCARA"]."||".$arrayMascaras[$i]["NUMINICIAL"]."||".$arrayMascaras[$i]["NUMFINAL"] ?>')">
          	<?php echo $arrayMascaras[$i]["MASCARA"] ;
            
            ?>
          </button>
          <?php if($arrayMascaras[$i]["ESTATUS"] == "P"):
            echo "<i class='fab fa-product-hunt'></i>";
          endif;
          ?>
        </h5>
      </div>

      <div id="collapse<?php echo $arrayMascaras[$i]["ID"] ?>" class="collapse" aria-labelledby="heading<?php echo $arrayMascaras[$i]["ID"] ?>" data-parent="#accordion">
        <div class="card-body">
        	<form class="d-flex flex-wrap mx-auto col-lg-12 justify-content-lg-between align-items-lg-center justify-content-lg-center" id="formulario">
            <div class="form-group col-lg-2">
              <label class="col-lg-12 text-center" >Inicial</label>
              <input  type="text" class="form-control text-center" id="numInicial"  readonly="" placeholder="Example input" value="<?php echo "1";?>">
            </div>
            <div class="form-group col-lg-2">
              <label class="col-lg-12 text-center"  >Final</label>
              <input type="text" class="form-control text-center" id="numFinal" readonly=""  placeholder="Another input" value="<?php echo $arrayMascaras[$i]["NUMFINAL"] ?>">
            </div>
            <div class="form-group col-lg-2">
              <label class="col-lg-12 text-center"  >Usados</label>
              <input type="text" class="form-control text-center" id="usados<?php echo $arrayMascaras[$i]["MASCARA"] ?>" readonly="" >
            </div>
            
            <div class="form-group col-lg-2">
              <label class="col-lg-12 text-center" >Disponibles</label>
              
              <input type="text" class="form-control text-center" id="disponibles<?php echo $arrayMascaras[$i]["MASCARA"] ?>" readonly=""  value="" placeholder="Another input">
            </div>

            <div class="col-lg-1 d-flex flex-nowrap">
             
             
             <i class="fas fa-trash col-lg-6  fa-lg" style="cursor: pointer;" onclick="delete_mascara('<?php echo $arrayMascaras[$i]["ID"]  ?>')"></i>
           </div>
           
         </form>
       </div>
     </div>
   </div>
   <?php 
 } // fin del while ?>
</div>
</div>

<!-- modal nuevas mascaras -->


<div style="z-index: 100000" >
  <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"style="margin-top: 5%">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Creación de nueva mascara</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group col-lg-6 mx-auto d-flex flex-wrap">
              <label for="recipient-name" class="col-form-label col-lg-4">Mascara</label>
              <input type="text" maxlength="12" class="form-control col-lg-8"  placeholder="Maximo 12 digitos" id="mascara_new">
            </div>
            <div class="container d-flex flex-wrap">
              <div class="form-group col-lg-6 d-flex flex-wrap">
                <label for="recipient-name" class="col-form-label col-lg-4">Inicial</label>
                <input type="text" maxlength="12" class="form-control col-lg-8"  value="0" id="inicial" disabled="">
              </div>
              <div class="form-group col-lg-6 d-flex flex-wrap">
                <label for="recipient-name" class="col-form-label col-lg-4" >Final</label>
                <input type="text" maxlength="4" class="form-control col-lg-8"  id="final" placeholder="Numero maximo 9999">
              </div>
            </div>
     <!--      <div class="form-group">
            <label for="message-text" class="col-form-label">sessage:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div> -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="nuevas_mascaras()">Guardar</button>
      </div>
    </div>
  </div>
</div>
</div>

<!-- modal mascaras canceladas -->
<!--      <button type="button" class="btn btn-primary" >
  Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="modal_canceladas_mascaras" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #007BFF; color: white">
        <h5 class="modal-title" id="exampleModalLongTitle">Mascaras Canceladas</h5>
        <button style="color: white" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-inline mx-auto col-lg-12 mx-auto"  >
<!--            <button class="btn btn-primary  col-lg-3" style="margin-right: 5%" >
            Activar
          </button> -->
          <select class="custom-select my-1 mr-sm-2 mx-auto col-lg-12" id="listaMascaras_canceladas">
            <?php 
            $mas_canceladas= $objeto->Mascaras_canceladas();
            while ($canc= ibase_fetch_assoc($mas_canceladas)) {
              
              echo "<option selected value=".$canc["MASCARA"].">".$canc["MASCARA"]."</option>";

              
            }

            ?>


          </select>
          
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="reactivar_mascaras()">Reactivar</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>


