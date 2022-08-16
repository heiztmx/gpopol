<?php 
session_start();
if(isset($_SESSION['user']) &&  $_SESSION['logeado'] == true){

  
 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
   <meta charset="UTF-8">
   <title>Lista Facturacion</title>
 </head>
 <link rel="stylesheet" href="../bootstrapcss/estiloFactura.css">
 <body>
  <?php 
  include '../menu/menu2.php';
  $priv = $objeto->ElegirPrivilegios($_SESSION['user']);
  $digito = substr($privilegio["MODULO1"], -1,1);
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
        <th scope="col" class="ocultarHora" style="text-align: center;">Hora</th>
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
     $c = new conexion();
     $conexion = $c->conectar();
     $query = "SELECT ID, ESTACION FROM ESTACIONES ORDER BY ID ASC";
     $totalest =ibase_query($conexion,$query);
     
    //$factura = $objeto->comprimirFacturacion(1);
     
     
     for($i=0; $i<5; $i++)
     {
      while($d = ibase_fetch_assoc($totalest))
      {
        
        $factura = $objeto->comprimirFacturacion((int)$d["ID"]);

        $datos =explode("||", $factura[$i]);
     // print_r( $datos);
        $time = explode(" ",$datos[0]);

        $parametros=$datos[0]."||".$datos[2]."||".$datos[3]."||".$datos[4]."||".$datos[1]."||".(string)$d["ID"];

      //fecha que se muestra en la tabla 
        $fecha = new DateTime($time[0]);
        $fechatabla = $fecha->format('d/m/Y');

        
   //strtotime es para poder comparar las fechas
        $fecha_aux = date("Y-m-d H:i:00",time());
        $fech_aux2 = explode(" ",$fecha_aux);
        $x =$fech_aux2[0]. " 00:00:00";


        $fechabd = strtotime($datos[0]);
//$fecha_actual =strtotime($x);
        $fecha_actual=$x;
// print_r( $fechabd);
 //print_r($x);
// print_r( $fecha_actual);
 // echo $datos[0];

  //   if( $fechabd >$fecha_actual ) 
  // {}
  // echo $parametros;
    //print_r( $factura);
        ?>
        
        <tr id="tabla_factura" <?php 

        if( $fechabd > $fecha_actual){ echo "style ='color:red'";} ?>
        >
        <th scope="row"  style="text-align: center;"><?php echo (string)$d["ID"] ?></th>
        <td scope="row"  style="text-align: center;"><?php echo $fechatabla ?></td>
        <td class="ocultarHora" style="text-align: center;"><?php echo $time[1] ?></td>
        <td style="text-align: center;"><?php echo $datos[2] ?></td>
        <td style="text-align: center;"><?php echo $datos[3] ?></td>
        <td style="text-align: center;"><?php echo $datos[4] ?></td>
        <!-- 	<td style="text-align: center;"><?php //echo $datos[1] ?></td> -->
        <td style="text-align: center;"></td>
        
        <?php 
        if( ($digito == 1 || $digito == 2) &&  ($fechabd > $fecha_actual) ){            
          ?>
          <td style='text-align: center; cursor: pointer;'><i onclick='BorrarFacturacion("<?php echo $parametros ?>")' class='fas fa-trash-alt'></i></td>
        <?php }else{
          echo "<td style='text-align: center' ></td>";
        }?>
        
      </tr>

      <?php 
    }
  }
  ?>
</tbody>
</table>
</body>
</html>




<?php 
} else {
 header('location:../index.php');
}
?>