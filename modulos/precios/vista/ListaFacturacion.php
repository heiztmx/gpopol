<?php

include "../../../conexion/sesion.php";


$ses = new sesion();

$permisos = $ses->validar_sesion();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Lista Facturacion</title>
</head>
<link rel="stylesheet" href="../../../bootstrapcss/estiloFactura.css">
<body>
  <?php 
  include '../../../menu/menu2.php';
  $priv = $objeto->ElegirPrivilegios($_SESSION['user']);
  // $digito = substr($privilegio["MODULO1"], -1,1);
  $find_permiso = $objeto->permisos_del_upd($_SESSION["user"],"PRECIOS");
  ?>
  <script src="../js/clickModulo1.js"></script>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  
  
  <h5 style="text-align: left; font-weight: bold; position: relative; top: -75px;">Listado Facturacion</h5>


  <div id="buscadorOperadores" class="col-lg-12 subir">
    <small id="emailHelp " class="form-text text-muted">Escribe el dato que desee filtrar</small>
    <input onclick="buscarFacturaFecha()" class="form-control " type="text" id="myInput" name="Buscar" placeholder="Buscar">
  </div>


  <br>
  <table class="table table-hover table-sm" id="myTable">
    <thead class="thead-dark">
      <tr>
        <th scope="col"  style="text-align: center;">Est</th>
        <th scope="col"  style="text-align: center;">Fecha</th>
        <!--   <th scope="col" class="ocultarHora" style="text-align: center;">Hora</th> -->
        <th scope="col" style="text-align: center;">Magna</th>
        <th scope="col" style="text-align: center;">Premium</th>
        <th scope="col" style="text-align: center;">Diesel</th>
       <!-- <th scope="col" style="text-align: center;">IVA</th>
       -->        <!-- <th scope="col" style="text-align: center;"></th> -->
     </tr>
   </thead>
   <tbody>
     <?php 
     $objeto = new metodosweb();
     $factura = $objeto->comprimirFacturacion();
     
  // print_r( $factura);
     for($i=0; $i<count($factura); $i++)
     {
      $datos =explode("||", $factura[$i]);
      $time = explode(" ",$datos[0]);
      $magna = $datos[0];
      $premium= $datos[1];
      $diesel =$datos[2];
      $estacion =$datos[3];
      $fecha =$datos[4];
      
      $parametros=$datos[0]."||".$datos[1]."||".$datos[2]."||".$datos[3]."||".$datos[4];

      //fecha que se muestra en la tabla 
      $fecha2 = new DateTime($fecha);
      $fechatabla = $fecha2->format('d/m/Y H:i:s');

      
   //strtotime es para poder comparar las fechas
      $fecha_aux = date("Y-m-d H:i:00",time());
      $fech_aux2 = explode(" ",$fecha_aux);
      $x =$fech_aux2[0]. " 00:00:00";


      $fechabd = strtotime($datos[4]);
      $fecha_actual =strtotime($x);
// print_r( $fechabd);




  //   if( $fechabd >$fecha_actual ) 
  // {}
      
      ?>
      
      <tr id="tabla_factura" <?php 

      if( $fechabd > $fecha_actual){ echo "style ='color:red'";} ?>
      >
      <th scope="row"  style="text-align: center;"><?php echo $estacion ?></th>
      <td scope="row"  style="text-align: center;"><?php echo $fechatabla ?></td>
      
      <td style="text-align: center;"><?php echo $magna ?></td>
      <td style="text-align: center;"><?php echo $premium ?></td>
      <td style="text-align: center;"><?php echo $diesel ?></td>
      
      
      <?php 
      if( ( $find_permiso == true) &&  ($fechabd > $fecha_actual) ){            
        ?>
        <td style='text-align: center; cursor: pointer;'><i onclick='BorrarFacturacion("<?php echo $parametros ?>")' class='fas fa-trash-alt'></i></td>
      <?php }else{
        echo "<td style='text-align: center' ></td>";
      }?>
      
    </tr>

    <?php 
    
  }
  ?>
</tbody>
</table>
</body>
</html>




