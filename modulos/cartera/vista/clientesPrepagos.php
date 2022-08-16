

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Clientes Prepagos</title>
	<?php include '../metGASOLINERA/metodosGASOLINERA.php';?>
  <link rel="stylesheet" href="../bootstrapcss/limclientes.css">
</head>
<body>


  <h5 style="text-align: left; font-weight: bold; position: relative; top: 0px;">Clientes de prepago</h5>
  



  <div class="m-1">
    <small id="emailHelp" class="form-text text-muted">Escribe el nombre o el folio del cliente  que desee buscar</small>
  </div>
  <div class=" d-flex flex-wrap">
    <!-- <input class="form-control col-lg-3 " type="text" id="bFolio" name="Buscar" placeholder="Buscar numero"> -->	
    <input class="form-control  col-lg-12" type="text" id="buscadorNombre" onclick="buscadorPP()" name="Buscar nombre" placeholder="Buscar nombre" >	

  </div>




  <br>
  <table class="table table-hover table-sm" id="myTablePP">
    <thead class="thead-dark">
      <tr>
        <th  class="letras" scope="col"s style="text-align: center;">No.Cliente</th>
        <th  class="letras" scope="col" style="text-align: left">Nombre</th>
        <th  class="letras" scope="col">Abonos</th>
        <th  class="letras" scope="col">Cargos</th>
        <th  class="letras" scope="col">Disponible</th>
      </tr>
    </thead>
    <tbody>
     <?php 
     $cont=0;
     $obj = new Gasolinera();
     $pp =$obj->CantidadPrepago();
     while ($row=ibase_fetch_assoc($pp)) {
       
       ?>
       <tr id="contenido_clientesPP">
         
        <th class="letras"  scope="row" style="text-align: center;"><?php echo $row["NOCLIE"]; ?></th>
        <td class="letras" style="text-align: left;"><?php 
        $nombre =$obj->clientesPrepago($row["NOCLIE"]);
        echo $nombre;
        ?></td>
        <td class="letras"  style="text-align: right;"><?php print number_format($row["ABONOSPREP"],2,'.',',');   ?></td>
        <td  class="letras" style="text-align: right;"><?php print number_format($row["CARGOSPREP"] ,2,'.',',');?></td>
        <td  class="letras" style="text-align: right;"><?php 
        $Disponible =0;
        if ($row["MOVEPP"] > 0){
          // 
         
         

         print number_format($row["MOVEPP"] ,2,'.',','); 
       }else{
        print number_format($Disponible  ,2,'.',','); 
        
      }
      


      ?></td>


      
    </tr>
    <?php
    
  } ?>
  
</tbody>
</table>
</body>
</html>