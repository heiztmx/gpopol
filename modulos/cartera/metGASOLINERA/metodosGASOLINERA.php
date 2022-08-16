<?php
/**
 *
 */
// session_start();
require_once '../../../conexion.php';
require_once '../../../general/funciones.php';
require_once '../../../conexionGAS.php';
include '../../../ConexionADMON.php';
require_once '../../../PHPExcel/Classes/PHPExcel.php';

class GASOLINERA
{
  public function conectarLocal()
  {
    $con = new conexion();
    $conexion =$con->conectar();
    return $conexion;
  }
  public function conectarGasolinera()
  {
      # code...
    $con = new conexionGAS();
    $conexion = $con->conectarGAS();
    return $conexion;
  }


  public function conectarGasolinera_p()
  {
      # code...
    $con = new conexionGAS();
    $conexion = $con->conectarGAS_p();
    return $conexion;
  }
  public function conectarADMON()
  {
      # code...
    $cone      = new conexionADMON();
    $coneAdmon = $cone->conectarADMON();
    return $coneAdmon;
  }




  public function limClieCredito()
  {
    $c        = new conexionGAS();
    $conexion = $c->conectarGAS();
    $resul    = "SELECT NOCLIE, LIMITECREDITO FROM DGASSALD WHERE TIPOTARJETA = 'CR' AND  NOCLIE != 0  ORDER BY NOCLIE ASC";
    $array_datos=array();
    $datos = ibase_query($conexion, $resul);
    while ($clie = ibase_fetch_assoc($datos)) {
      $array_datos[$clie["NOCLIE"]] = $clie["LIMITECREDITO"];
    }
    ibase_free_result($datos); 
    ibase_close($conexion);
    return $array_datos;


  }



  public function conectarADM1()
  {
      # code...
    $cone      = new conexionADMON();
    $coneAdmon = $cone->conectarADM();
    return $coneAdmon;
  }
  public function listadoClientes()
  {
    $c        = new conexionADMON();
    $conexion = $c->conectarADMON();
    $resul    = "SELECT * FROM DGENCLIE WHERE ACTIVO  ='Si' ORDER BY NOCLIE ASC";

    $privilegios = ibase_query($conexion, $resul);
    ibase_free_result($privilegios); 
    ibase_close($conexion);
    return $privilegios;


  }

  public function CantidadPrepago()
  {
   $con = new conexionGAS();
   $conexion =$con->conectarGAS();
   $query ="SELECT NOCLIE ,ABONOSPREP,CARGOSPREP,ABONOSPREP - CARGOSPREP AS MOVEPP FROM DGASSALD WHERE TIPOTARJETA = 'PP' ";
   $datos =ibase_query($conexion,$query);

        // ibase_free_result($datos);  
        // ibase_close($conexion);
   return $datos;
 }
 public function clientesPrepago($id)
 {
  $ad      = new conexionADMON();
  $admon   = $ad->conectarADMON();
  $gene = new generales();
  $query ="SELECT NOMBRE FROM DGENCLIE WHERE NOCLIE ='$id' ";
  $datos =ibase_query($admon,$query);
  $nombre = ibase_fetch_assoc($datos);
  ibase_free_result($datos);  
  ibase_close($admon);
  $nombre1 = $gene->reparar_utf8($nombre["NOMBRE"]);
  return $nombre1;
}


public function noFacturadoTarjetas()
{
        # code..
  $c= new conexionGAS();
  $conexion  = $c->conectarGAS();
  $re ="SELECT SUM(TOTAL) AS NOFACTURADO, CLIENTE FROM DGASTRAN 
  WHERE TIPOVENTA = 'CR'  AND FACTURADO = 'No' GROUP BY CLIENTE";
  $ejecutar = ibase_query($conexion,$re);
  $array_facturado = array();

  while ($nofacturado = ibase_fetch_assoc($ejecutar)) {
    $array_facturado[$nofacturado["CLIENTE"]] = $nofacturado["NOFACTURADO"];
  }
  
  ibase_free_result($ejecutar);  
  ibase_close($conexion);
  return $array_facturado;

}

public function noFacturadoVales()
{
  $c= new conexionGAS();
  $conexion  = $c->conectarGAS();
  $re ="SELECT SUM(TOTAL) AS NOVALES,CLIENTE FROM DGASPVAL 
  WHERE   FACTURADO = 'No' GROUP BY CLIENTE";
  $ejecutar = ibase_query($conexion,$re);
  $array_vales = array();
  while (  $no_vales = ibase_fetch_assoc($ejecutar)) {
    $array_vales[$no_vales["CLIENTE"]]= $no_vales["NOVALES"];
  }

  ibase_free_result($ejecutar);  
  ibase_close($conexion);
  return $array_vales;
}

public function DCXCSCXC()
{
        # code...ConexionVentas
 $c= new conexionADMON();
 $conexion  = $c->conectarADMON();
 $re ="SELECT SUM(TOTALCARGOS) AS CARGOS,SUM(TOTALABONOS) AS ABONOS ,NOCLIE FROM DCXCSCXC GROUP BY NOCLIE";
 $array_dcx=array();
 $ejecutar = ibase_query($conexion,$re);
 while ($cant = ibase_fetch_assoc($ejecutar)) {
   $total = $cant["CARGOS"] - $cant["ABONOS"];
   $array_dcx[$cant["NOCLIE"]] =$total;
 }


 ibase_free_result($ejecutar);  
 ibase_close($conexion);
 return $array_dcx;
}



public function datos_clientes()
{
  $ad      = new conexionADMON();
  $admon   = $ad->conectarADMON();
  $clie    = "SELECT NOCLIE,NOMBRE,DIRECCION,POBLACION,RFC,FECHAALTA,APELLIDOPATERNO,APELLIDOMATERNO,NOMBREPERSONA,EMAIL,CLASIFICA FROM DGENCLIE  WHERE CREDITO = 'Si' ORDER BY NOCLIE ASC";
  $cliente = ibase_query($admon, $clie);
  $nombres= array();
  $gene = new generales();
  while ($clie = ibase_fetch_assoc($cliente)) {
    $nombre= $gene->reparar_utf8($clie["NOMBRE"]);
    $datos = array(
      "noclie" =>$clie["NOCLIE"],
      "nombre" => $nombre,
      "direccion" =>$clie["DIRECCION"],
      "poblacion" =>$clie["POBLACION"],
      "rfc" =>$clie["FECHAALTA"],
      "apellidopaterno" =>$clie["APELLIDOPATERNO"],
      "apellidomaterno" => $clie["APELLIDOMATERNO"],
      "nombrepersona" =>$clie["NOMBREPERSONA"],
      "email" =>$clie["EMAIL"],
      "clasifica" =>$clie["CLASIFICA"]);
    $clientes[] = $datos;
  }
  ibase_free_result($cliente);  
  ibase_close($admon);
  return $clientes;
}

public function ClientesMONTO($id)
{
  $ad      = new conexionGAS();
  $admon   = $ad->conectarGAS();
  $clie    = "SELECT LIMITECREDITO,TIPOTARJETA,CARGOSPREP,ABONOSPREP FROM DGASSALD WHERE NOCLIE ='$id'";
  $cliente = ibase_query($admon, $clie);
  return $cliente;
}

public function tarjetaClientes($id)
{
  $ad        = new conexionGAS();
  $admon     = $ad->conectarGAS();
  $clie      = "SELECT COUNT(*) AS TARJETAS FROM DGASTARJ WHERE NOCLIE ='$id' AND ESTATUS = 'Activa'";
  $registros = ibase_query($admon, $clie);

  return $registros;
}

public function buscador_clientes_credito($nombre)
{
  if ($nombre == "") {
    $resultado = "";
  } else {

    $cone      = new conexionADMON();
    $coneAdmon = $cone->conectarADMON();
    if(ctype_digit($nombre))
    {
      (int)$nombre;
      $cliente   = "SELECT FIRST(20) * FROM DGENCLIE WHERE (ACTIVO = 'Si' )
      AND ( NOCLIE = '$nombre') ";

    }else{
     $cliente   = "SELECT FIRST(20) * FROM DGENCLIE WHERE (ACTIVO = 'Si' )
     AND (UPPER(NOMBRE) CONTAINING UPPER('$nombre') OR  UPPER(NOMBRE)  LIKE UPPER('%" . $nombre . "%')) ";
   }

   $query     = ibase_query($coneAdmon, $cliente);
   $contar    = 1;
   $resultado = "";
   if ($contar == 0) {
    $resultado = "No se encontraron resultado con el nombre proporcionado";

  } else {
    while ($row = ibase_fetch_assoc($query)) {
      $nombre          = $row["NOMBRE"];
      $nombrec          = $row["NOMBRECOMERCIAL"];
      if ($nombrec == NULL || $nombrec == ""){  $nombreresult = $row["NOMBRE"];  }
      else{ $nombreresult =  $row["NOMBRECOMERCIAL"];  }
      $id              = $row["NOCLIE"];
                    // $objeto          = new GASOLINERA();
      $monto           = $this->ClientesMONTO($id);
      $mon = ibase_fetch_assoc($monto);
      $cantidad  =$mon["LIMITECREDITO"];
      $tipoTar =$mon["TIPOTARJETA"];
      $cargos=$mon["CARGOSPREP"];
      $abonos=$mon["ABONOSPREP"];
      if ($cargos == NULL) {
        $cargos = 0;
                                            # code...
      }
      if ($abonos == NULL) {
                        # code...
        $abonos = 0;
      }
      $saldoDis=$abonos - $cargos;  
      $saldoDis =number_format($saldoDis,2,'.',',');

      $registros       = $this->tarjetaClientes($id);
      $tarjetaClientes = ibase_fetch_assoc($registros);
      $tipo="";
      if($row["CLASIFICA"] == 1){
        $tipo="1";
      }elseif ($row["CLASIFICA"] == 2) {
                        # code...
        $tipo="2";
      }elseif ($row["CLASIFICA"] == 3) {
                        # code...
        $tipo ="3";
      }else{
        $tipo="NINGUNO";
      }


      if($mon["TIPOTARJETA"] == "CO"){
        $tipoTar="CO";
      }elseif ($mon["TIPOTARJETA"] == "CR") {
                        # code...
        $tipoTar="CR";
      }elseif ($mon["TIPOTARJETA"] == "PP") {
                        # code...
        $tipoTar ="PP";
      }else{
        $tipoTar="NINGUNO";
      }
      $CT=$tipo."||".$tipoTar;
      $datosCliente = $row["NOCLIE"] . "||" . $row["NOMBRE"] . "||" . $row["DIRECCION"] . "||" . $row["POBLACION"] . "||" .
      $row["APELLIDOPATERNO"] . "||" . $row["APELLIDOMATERNO"] . "||" . $row["NOMBREPERSONA"] . "||" . $row["EMAIL"] . "||" . $tarjetaClientes["TARJETAS"];

      $nombreCompleto = $row["APELLIDOPATERNO"] . " " . $row["APELLIDOMATERNO"] . " " . $row["NOMBREPERSONA"] . " " . $mon["LIMITECREDITO"];
      $direccionfinal =$row["DIRECCION"].", ".$row["POBLACION"].". ".$row["ESTADO"].". ".$row["PAIS"].".";

      $nombre_utf="";
      if(!mb_detect_encoding($nombre,"UTF-8",true)){
        $nombre_utf = utf8_encode($nombre);
      }else{
        $nombre_utf=$nombre;
      }

      $nombrec_utf="";
      if(!mb_detect_encoding($nombreresult,"UTF-8",true)){
        $nombrec_utf = utf8_encode($nombreresult);
      }else{
        $nombrec_utf=$nombreresult;
      }

      $resultado .= "<tbody>
      <tr  id='contenido_clientes' style='cursor:pointer;' >

      <td  id='heading".$id."' scope ='row' style='text-align: left;'  class=' letras  card-header'>".$id."
      </td>

      <td  id='heading" . $id . "' scope ='row' style='text-align: left;'  class=' letras  card-header'>

      <a class='' data-toggle='collapse' data-target='#collapse".$id."' id='nombre_cliente".$id."' aria-expanded='true' aria-controls='collapse".$id."' 
      onclick ='tipoCT(".$id.")'>
      ".$nombre_utf."
      </a>
      <div id='collapse" . $id . "' class='collapse' aria-labelledby='heading" . $id . "' data-parent='#contenido_clientes'>
      <div class='card-body'>
      <h5 style='text-align: center;'>Informacion General</h5>
      <div class='d-flex flex-wrap justify-content-between col-lg-12 mx-auto' >
      <div class='form-group col-md-4 '>
      <label for=''>No. Cliente</label>
      <input type='text' class='form-control' id='noclie".$id."' disabled='' value='" . $id . "'>
      </div>
      <input style='display:none' id='grupof".$id."' value='" . $tipo . "'>
      <input style='display:none' id ='tipoc".$id."' value='" . $tipoTar . "'>
      <input id ='metodopagDEF".$id."' class='d-none' value='". $row["METODOPAGODEFAULT"]."'>



      <div class='form-group col-md-4' >
      <label for='grupoFac'>Grupo de facturacion</label>
      <select class='form-control' id='grupoFac".$id."' disabled>
      <option value='3'>Prepago</option>
      <option value='2'>Credito</option>
      <option value='1'>Contado</option>
      </select>
      </div>

      <div class='form-group col-md-4'>
      <label for='tipoCliente'>Tipo de cliente</label>
      <select class='form-control' id='tipoCliente".$id."' onchange ='ocultarMontoCredito(".$id.")'>
      <option value='PP'>Prepago</option>
      <option value='CR'>Credito</option>
      <option  value='CO'>Contado</option>
      </select>
      </div>



      </div>
      <div class='d-flex flex-wrap justify-content-end col-lg-12 mx-auto'  id='contenedorcredito".$id."'>
      <div class='form-group col-md-4 ' id='tituloCredito".$id."'>
      <label  for=''>Monto asignado</label>
      <input id='montoCredito".$id."' style='text-align: center;' type='' class='form-control' id='montoCredito' placeholder='' value='" . $mon["LIMITECREDITO"] . "' >
      </div>
      <div class='form-group col-md-4 ' id='Clienteprepago".$id."'>
      <label  for=''>Saldo Disponible</label>
      <input id='montoCredito".$id."'  style='text-align: center;' type='' class='form-control' disabled='' id='montoPrepago".$id."' placeholder='' value='" . $saldoDis. "' >
      </div>
      </div>
      <div class='d-flex flex-wrap justify-content-between col-lg-12 mx-auto' >
      <div class='form-group col-md-6 col-lg-6'>
      <label for=''>Direccion</label>
      <textarea type='text' class='form-control' id='' disabled='' >" .$direccionfinal. "</textarea>
      </div>
      <div class='form-group col-md-6'>
      <label for='formapagodefault'>Forma de pago default</label>
      <select class='form-control' id='formapagodefault".$id."'>
      <option value='1'>Efectivo</option>
      <option value='2'>Cheque nominativo</option>
      <option  value='3'>Transferencia electronica de fondos</option>
      <option  value='4'>Tarjeta de Credito</option>
      <option  value='5'>Monedero Electronico</option>
      <option  value='6'>Dinero electronico</option>
      <option  value='8'>Vales de despensa</option>

      <option  value='28'>Tarjeta de Debito</option>
      <option  value='29'>Tarjeta de Servicio</option>
      <option  value='98'>NA</option>
      <option  value='99'>NA</option>
      </select>
      </div>
      </div>
      <div class='d-flex flex-wrap justify-content-between col-lg-12 mx-auto' >
      <div class='form-group col-md-6 col-lg-6'>
      <label for=''>Contacto</label>
      <input type='text' class='form-control' id='inputEmail4'  value='" . $row["CONTACTO"] . "' disabled='' >
      </div>
      <div class='form-group col-md-6 '>
      <label for=''>Email</label>
      <input type='' class='form-control' id='inputEmail4' placeholder='' value='" .
      $row["EMAIL"] . " ' disabled=''>
      </div>
      </div>
      <div class='d-flex flex-wrap justify-content-between col-lg-12 mx-auto' >
      <div class='form-group col-md-6 col-lg-6'>
      <label for=''>Tarjetas en uso</label>
      <input type='text' class='form-control' id='inputEmail4'  value='" . $tarjetaClientes["TARJETAS"] . "' disabled='' >
      </div>
      <div class='form-group col-md-6 '>
      <div class='d-flex flex-wrap'>
      <label  for='Mastarjetas'>Asignar Tarjetas</label>
      <input onclick='bloqueAsignarTarjetas(".$id.")' class='form-check-input' type='checkbox' value='' id='Mastarjetas".$id."'>

      </div>

      <input type='' class='form-control' id='cajaTarjetas".$id."' placeholder='Numero de tarjetas' value='' disabled=''>
      <br>
      
      <label for=''>Nombre Comercial <font color='#FF0000' size=1>(Informacion impresa en la tarjeta)</font></label>
      <input type='' class='form-control ' id='nombrecliente1".$id."' placeholder='Nombre de tarjetas' value='".$nombrec_utf."' >
      <input id='nombrecliente1".$id."' style='display:none' value='".$nombreresult."'
      
      </div>
      </div>
      <div class='d-flex flex-nowrap justify-content-between col-lg-3 mx-auto' >

      <i  class='  fas fa-file-excel fa-2x' onclick='modal_excel(".$id.")'  data-toggle='modal' data-target='#generadorExcel' data-whatever='@getbootstrap' ></i>
      <i   onclick='enviarDGASSALD(".$id.")' class='fas fa-save fa-2x' ></i>
      <i  class='fas fa-ban fa-2x'></i>

      </div>

      </div>
      </div>
      </td>





      </tr>
      </tbody>
      ";

    }

  }
}
return $resultado;
}

    // Aqui comienza los metodos para las tarjetas

public function mascaraEnUso()
{
      // enviarDGASSALD()
      // bloqueAsignarTarjetas()
  $ad       = new conexion();
  $admon    = $ad->conectar();
  $num      = "SELECT MASCARA,NUMINICIAL FROM TABLAPOOLS WHERE ESTATUS ='P'";
  $numero   = ibase_query($admon, $num);
  $numfinal = ibase_fetch_assoc($numero);
  (string) $numfinal["NUMINICIAL"];
  $resultado = $numfinal["MASCARA"] . " " . $numfinal["NUMINICIAL"];
  return $resultado;
}

public function folioMaximo($tabla)
{
  $ad       = new conexion();
  $admon    = $ad->conectar();
  $folio    = "SELECT MAX(ID) AS ID FROM $tabla";
  $f        = ibase_query($admon, $folio);
  $foliomax = ibase_fetch_assoc($f);

  $resultado = $foliomax["ID"];
  return $resultado;
}

public function UltimoPoolUsado($mascara)
{
  $ad    = new conexion();
  $admon = $ad->conectar();
  $max   = "SELECT FIRST(1) IDPOOLS FROM ASIGNARPOOLS WHERE IDPOOLS
  CONTAINING '$mascara' AND   ID = (SELECT MAX(ID) FROM ASIGNARPOOLS WHERE IDPOOLS
  CONTAINING '$mascara')";

  if ($max != NULL) {
                # code...
    $fo        = ibase_query($admon, $max);
    $masc      = ibase_fetch_assoc($fo);
    $subcadena = substr($masc["IDPOOLS"], 12);
    $pool      = (int) $subcadena;
  }else{
    $pool = 0;
  }


  return $pool;
}

public function insertarCreditosLocales($noclie,$credito,$usuario,$movimiento)
{
  $objetoclass = new GASOLINERA();
  $foliomax = $objetoclass->folioMaximo("ASIGNARCREDITOS");
  $foliomax =$foliomax + 1;
  $objetoLocal   = new conexion();
  $conexionLocal = $objetoLocal->conectar();
  $trlocal = ibase_trans("IBASE_WRITE", $conexionLocal);

  $fecha = date("Y/m/d");
  $guardar = "INSERT INTO ASIGNARCREDITOS(ID,NOCLIE,MONTO,MOVIMIENTO,FECHA,USUARIO)
  VALUES ('$foliomax','$noclie','$credito','
  $movimiento','$fecha','$usuario')";
  $veri1   = ibase_query($trlocal, $guardar);
  $estado1 = ibase_commit($trlocal);
  return $estado1;

}


public function crear_usuario_web_igas($id)
{
      # code...
                //admin
  $admin_pass ="ee877a31f5fd20df80205904f655675f664cbec97c18fd6d7d3735da3a4edca989016fca8259d5c6463cc78a644c05d8bc222304d64f29aa9f885c37d027d10c";
                //consulta
  $consu_pass ="ee877a31f5fd20df80205904f655675f664cbec97c18fd6d7d3735da3a4edca989016fca8259d5c6463cc78a644c05d8bc222304d64f29aa9f885c37d027d10c";
  $fecha_hora=date("Y-m-d H:i");
  $archivo_ad = '<root>
  <Consultas>
  <CConsultas name="Resumen Consumo Flotilla" value="Si" />
  <CConsultas name="Detalle Consumo Flotilla" value="Si" />
  <CConsultas name="Integracion Consumos" value="Si" />
  <CConsultas name="Integracion Saldos Pendientes" value="Si" />
  <CConsultas name="Auxiliar de Movimientos" value="Si" />
  <CConsultas name="Auxiliar de Consumo de Clientes" value="Si" />
  <CConsultas name="Facturar Electronicas" value="Si" />
  <CConsultas name="Detalle Consumo Facturas" value="Si" />
  <CConsultas name="Saldos por Unidad" value="Si" />
  <CConsultas name="Administrar Usuarios" value="Si" />
  <CConsultas name="Administrar Choferes" value="Si" />
  <CConsultas name="Administrar Tarjetas" value="Si" />
  <CConsultas name="Administrar Vehiculos" value="Si" />
  <CConsultas name="Consultar Cupones" value="Si" />
  </Consultas>
  <Administracion>
  <Usuarios>
  <PUsuarios name="Agregar" value="Si" />
  <PUsuarios name="Modificar" value="Si" />
  <PUsuarios name="Eliminar" value="Si" />
  </Usuarios>
  <Tarjetas>
  <PTarjetas name="Agregar" value="Si" />
  <PTarjetas name="Modificar" value="Si" />
  <PTarjetas name="Eliminar" value="Si" />
  </Tarjetas>
  <Choferes>
  <PChoferes name="Agregar" value="Si" />
  <PChoferes name="Modificar" value="Si" />
  <PChoferes name="Eliminar" value="Si" />
  </Choferes>
  <Vehiculos>
  <PVehiculos name="Agregar" value="Si" />
  <PVehiculos name="Modificar" value="Si" />
  <PVehiculos name="Eliminar" value="Si" />
  </Vehiculos>
  </Administracion>
  </root>';
  $archiv_co='<root>
  <Consultas>
  <CConsultas name="Resumen Consumo Flotilla" value="Si" />
  <CConsultas name="Detalle Consumo Flotilla" value="Si" />
  <CConsultas name="Integracion Consumos" value="Si" />
  <CConsultas name="Integracion Saldos Pendientes" value="Si" />
  <CConsultas name="Auxiliar de Movimientos" value="Si" />
  <CConsultas name="Auxiliar de Consumo de Clientes" value="Si" />
  <CConsultas name="Facturar Electronicas" value="Si" />
  <CConsultas name="Detalle Consumo Facturas" value="Si" />
  <CConsultas name="Saldos por Unidad" value="Si" />
  <CConsultas name="Administrar Usuarios" value="No" />
  <CConsultas name="Administrar Choferes" value="Si" />
  <CConsultas name="Administrar Tarjetas" value="No" />
  <CConsultas name="Administrar Vehiculos" value="No" />
  <CConsultas name="Consultar Cupones" value="Si" />
  </Consultas>
  <Administracion>
  <Usuarios>
  <PUsuarios name="Agregar" value="No" />
  <PUsuarios name="Modificar" value="No" />
  <PUsuarios name="Eliminar" value="No" />
  </Usuarios>
  <Tarjetas>
  <PTarjetas name="Agregar" value="No" />
  <PTarjetas name="Modificar" value="No" />
  <PTarjetas name="Eliminar" value="No" />
  </Tarjetas>
  <Choferes>
  <PChoferes name="Agregar" value="No" />
  <PChoferes name="Modificar" value="No" />
  <PChoferes name="Eliminar" value="No" />
  </Choferes>
  <Vehiculos>
  <PVehiculos name="Agregar" value="No" />
  <PVehiculos name="Modificar" value="No" />
  <PVehiculos name="Eliminar" value="No" />
  </Vehiculos>
  </Administracion>
  </root>';


  $sql ="SELECT COUNT(*) AS USUARIO FROM DGASUSUA WHERE CLIENTE = '$id'";

  $existe = ibase_query($this->conectarGasolinera(),$sql);
  $exi =ibase_fetch_assoc($existe);
  // print_r();
  if ( $exi["USUARIO"]== 0) {

    $ind ="SELECT MAX(INDICE) AS INDICE FROM DGASUSUA";
    $indexe = ibase_query( $this->conectarGasolinera(),$ind);
    $maximo =ibase_fetch_assoc($indexe);
    $ind_adm= $maximo["INDICE"] + 1;
    $ind_cons = $maximo["INDICE"] + 2;
    ibase_free_result($indexe); 
    ibase_close($this->conectarGasolinera());

    $wrgasA = ibase_trans("IBASE_WRITE", $this->conectarGasolinera());
    $guardar_admin = "INSERT INTO DGASUSUA(CLIENTE,INDICE,USUARIOWEB,PASSWORDWEB,ADMINISTRADOR,CORREOELECTRONICO,TELEFONO,CELULAR,FECHAALTA,USUARIOALTA,VARINI)
    VALUES ('$id','$ind_adm','ADMIN','$admin_pass','Si','','','','$fecha_hora','Admin','$archivo_ad')";
    $veri_admin   = ibase_query($wrgasA, $guardar_admin);
    $estado_admin = ibase_commit($wrgasA);

    ibase_close($this->conectarGasolinera());

    if ($estado_admin == 1) {
      $wrgasC = ibase_trans("IBASE_WRITE", $this->conectarGasolinera());
      $guardar_consul = "INSERT INTO DGASUSUA(CLIENTE,INDICE,USUARIOWEB,PASSWORDWEB,ADMINISTRADOR,CORREOELECTRONICO,TELEFONO,CELULAR,FECHAALTA,USUARIOALTA,VARINI)
      VALUES ('$id','$ind_cons','CONSULTA','$consu_pass','No','','','','$fecha_hora','Admin','$archiv_co')";
      $veri_consul   = ibase_query($wrgasC, $guardar_consul);
      $estado_sonsul = ibase_commit($wrgasC);
      ibase_close($this->conectarGasolinera());
      if ($estado_sonsul== 1) {

      }
    }
    if ($estado_admin > 0 && $estado_sonsul > 0) {
      return "creado";
    }
  }else{
    return "existe";
  }
}
public function insertDGASSALD($id,$nombreClienteCC,$credito,$usuario,$metodoPago,$tipoCliente,$grupofac)

{
 $this->crear_usuario_web_igas($id);
 $objeto    = new conexionGAS();
 $conexion  = $objeto->conectarGAS();
 $coneV  = new conexionADMON();
 $conexionV =  $coneV->conectarADMON();



 $queryVeri = "SELECT  COUNT(*) AS EXISTE FROM DGASSALD WHERE NOCLIE ='$id'";
 $query     = ibase_query($conexion, $queryVeri);
 $existente = ibase_fetch_assoc($query);
 $tr        = ibase_trans("IBASE_WRITE", $conexion);
 $trV       = ibase_trans("IBASE_WRITE",$conexionV);
 $mensaje   = "";
 $cero=0;
 switch ($tipoCliente) {
  case "CR":
  if($existente["EXISTE"] == 0)
  {
    try {
      $sql    = "INSERT INTO  DGASSALD(NOCLIE,IMPRIMESALDO,LIMITECREDITO,ADEUDOFACTURAS,ADEUDOVALES,CARGOSPREP,ABONOSPREP,TIPOTARJETA,NIVELVEHICULO,APLICACOMISION,BLOQUEADA,NIVELCHOFER,CODIGO_SEGURIDAD,TIPOPAGO) VALUES('$id','Si','$credito','$cero','$cero','$cero','$cero','CR','No','No','No','No','No',0);";
      $veri   = ibase_query($tr, $sql);
      $estado = ibase_commit($tr);
      if ($estado == 1) {
       $insertLocal = $this->insertarCreditosLocales($id,$credito,$usuario,"Insert");
       if ($insertLocal == 1)
       {
        return $mensaje = "insertCredito";
      }else{
       throw new Exception("No se pudo guardar en localmente");
     }

   }else{
    throw new Exception("No se pudo guardar en DGASSALD");
  }

} catch (Exception $e) {
  return  $mensaje=$e->getMessage();
}
}else
{
                        //update

                        //DGASSALD GASOLINERA
  try{
   $modif = "UPDATE DGASSALD dgas
   SET LIMITECREDITO ='$credito' ,TIPOTARJETA ='CR'  WHERE NOCLIE = '$id'";
   $veri   = ibase_query($tr, $modif);   
   $estado = ibase_commit($tr);
   if ($estado  ==  1 ) {
                                # code... 
                                // DGENCLIE VENTAS
     $modif2 = "UPDATE  DGENCLIE dge
     SET CLASIFICA = 2 , METODOPAGODEFAULT = '$metodoPago', NOMBRECOMERCIAL='$nombreClienteCC' WHERE NOCLIE = '$id'";
     $veri   = ibase_query($trV, $modif2);   
     $estado2 = ibase_commit($trV);
   }


   if($estado == 1 || $estado2 == 1)
   {
     $insertLocal = $this->insertarCreditosLocales($id,$credito,$usuario,"Update");
     if($insertLocal == 1)
     {
       return $mensaje = "updateCredito";
     }else{
       throw new Exception("No se pudo  guardar la modificacion localmente");
     }
   }else{
    throw new Exception("No se pudo actualizar el credito al cliente");
  }
}catch(Exception $e)
{
 return  $mensaje=$e->getMessage();   
}

}
break;
case "PP":
if($existente["EXISTE"] == 0)
{
  try {

    $sql    = "INSERT INTO  DGASSALD(NOCLIE,IMPRIMESALDO,ADEUDOFACTURAS,ADEUDOVALES,CARGOSPREP,ABONOSPREP,TIPOTARJETA,NIVELVEHICULO,APLICACOMISION,BLOQUEADA,NIVELCHOFER,CODIGO_SEGURIDAD,TIPOPAGO) VALUES('$id','Si','$cero','$cero','$cero','$cero','PP','No','No','No','No','No',0);";
    $veri   = ibase_query($tr, $sql);
    $estado = ibase_commit($tr);
    if ($estado == 1) {
     $insertLocal = $this->insertarCreditosLocales($id,$credito,$usuario,"Insert");
     if ($insertLocal == 1)
     {
      return $mensaje = "insertCredito";
    }else{
     throw new Exception("No se pudo guardar en localmente");
   }

 }else{
  throw new Exception("No se pudo guardar en DGASSALD");
}

} catch (Exception $e) {
  return  $mensaje=$e->getMessage();
}
}else
{
                        //update
  try{
                                //dos conexiones primero DGASSALD despues DGENCLIE
   $modif = "UPDATE DGASSALD dgas
   SET TIPOTARJETA ='PP'  WHERE NOCLIE = '$id'";
   $veri   = ibase_query($tr, $modif);   
   $estado = ibase_commit($tr);
   if ($estado  ==  1 ) {
                                # code... 
                                // DGENCLIE VENTAS
     $modif2 = "UPDATE  DGENCLIE
     SET CLASIFICA = 3 ,CREDITO = 'No' , LIMITE_CRED = 0, METODOPAGODEFAULT = '$metodoPago', NOMBRECOMERCIAL='$nombreClienteCC'  WHERE NOCLIE = '$id'";
     $veri   = ibase_query($trV, $modif2);   
     $estado2 = ibase_commit($trV);
   }

   if($estado == 1 || $estado2 == 1)
   {
     $insertLocal = $this->insertarCreditosLocales($id,$credito,$usuario,"Update");
     if($insertLocal == 1)
     {
       return  $mensaje = "updateCredito";
     }else{
       throw new Exception("No se pudo  guardar la modificacion localmente");
     }
   }else{
    throw new Exception("No se pudo actualizar el credito al cliente");
  }
}catch(Exception $e)
{
 return  $mensaje=$e->getMessage();   
}

}
break;
case "CO":
if($existente["EXISTE"] == 0)
{
  try {
    $sql    = "INSERT INTO  DGASSALD(NOCLIE,IMPRIMESALDO,ADEUDOFACTURAS,ADEUDOVALES,CARGOSPREP,ABONOSPREP,TIPOTARJETA,NIVELVEHICULO,APLICACOMISION,BLOQUEADA,NIVELCHOFER,CODIGO_SEGURIDAD,TIPOPAGO) VALUES('$id','Si','$cero','$cero','$cero','$cero','CO','No','No','No','No','No',0);";
    $veri   = ibase_query($tr, $sql);
    $estado = ibase_commit($tr);
    if ($estado == 1) {
     $insertLocal = $this->insertarCreditosLocales($id,$credito,$usuario,"Insert");
     if ($insertLocal == 1)
     {
      return $mensaje = "insertCredito";
    }else{
     throw new Exception("No se pudo guardar en localmente");
   }

 }else{
  throw new Exception("No se pudo guardar en DGASSALD");
}

} catch (Exception $e) {
  return  $mensaje=$e->getMessage();
}
}else
{
                        //update
  try{
   $modif = "UPDATE DGASSALD dgas
   SET TIPOTARJETA ='CO'  WHERE NOCLIE = '$id'";
   $veri   = ibase_query($tr, $modif);   
   $estado = ibase_commit($tr);
   if ($estado  ==  1 ) {
                                # code... 
                                // DGENCLIE VENTAS
     $modif2 = "UPDATE  DGENCLIE 
     SET CLASIFICA = 1 ,CREDITO = 'No' , LIMITE_CRED = 0, METODOPAGODEFAULT = '$metodoPago', NOMBRECOMERCIAL='$nombreClienteCC'  WHERE NOCLIE = '$id'";
     $veri   = ibase_query($trV, $modif2);   
     $estado2 = ibase_commit($trV);
   }

   if($estado == 1 || $estado2 == 1) 
   {
     $insertLocal = $this->insertarCreditosLocales($id,$credito,$usuario,"Update");
     if($insertLocal == 1)
     {
       return  $mensaje = "updateCredito";
     }else{
       throw new Exception("No se pudo  guardar la modificacion localmente");
     }
   }else{
    throw new Exception("No se pudo actualizar el credito al cliente");
  }
}catch(Exception $e)
{
 return  $mensaje=$e->getMessage();   
}

}
break;
}


}

public function reemplazar_caracteres($nombre)
{
 $gene = new generales();
 
 $nombre = $gene->reparar_utf8($nombre);
 $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò",
  "Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã",
  "ÃŠ","ÃŽ","Ã","Ã›","ü","Ã¶","Ã–","Ã¯",
  "Ã¤","«","Ò","Ã","Ã","Ã‹","Ñ","*","%");
 $permitidas= array ("a","e","i","o","u","A","E","I",
  "O","U","n","N","A","E","I","O","U",
  "a","e","i","o","u","c","C","a","e","i",
  "o","u","A","E","I","O","U","u","o","O",
  "i","a","e","U","I","A","E","N",".",".");
 $reparado_nombre = str_replace($no_permitidas, $permitidas ,$nombre);

 return $reparado_nombre;
}

public function insertarLocalTarjetas($idsig,$tarjetafinal, $idCliente, $usuario,$noeconomico,$codigotarjeta,$alias,$placas,$track1,$track2,$track3,$vehiculo,$vencimiento,$tipotarjeta)
{


  $objetoLocal   = new conexion();
  $conexionLocal = $objetoLocal->conectar();
  $trlocal = ibase_trans("IBASE_WRITE", $conexionLocal);
// Activa
  $fecha = date("Y/m/d");
  $nombre_reparado =$this-> reemplazar_caracteres($alias);
  $insertASIGNAPOOLS = "INSERT INTO ASIGNARPOOLS(ID,IDPOOLS,NOCLIE,FECHA,ESTATUS,USUARIO,NOECONOMICO,CODIGOTARJETA,NOMBRECLIENTE,PLACAS,TRACK1,TRACK2,TRACK3,VEHICULO,VENCIMIENTO,TIPOTARJETA) 
  VALUES ('$idsig','$tarjetafinal','$idCliente','$fecha','Activa','$usuario','$noeconomico','$codigotarjeta','$nombre_reparado','$placas','$track1','$track2','$track3','$vehiculo','$vencimiento','$tipotarjeta')";
  $veri1   = ibase_query($trlocal, $insertASIGNAPOOLS);
  $estado1 = ibase_commit($trlocal);
  return $estado1;

}
public function ultimo_indice_usuariosIweb()
{
 $indice = "SELECT  MAX(INDICE) AS MAYOR FROM DGASUSUA";
 $resul_ind = ibase_query($conexion, $indice);
 $max = ibase_fetch_assoc($resul_ind);
 return $max["MAYOR"];
}
public function usuarios_Igasweb($idCliente,$conexion,$usuario)
{

       //conexion
  $fechaalta  = date('Y/m/d h:i');
  $tr = ibase_trans("IBASE_WRITE", $conexion);
        // crear archivo .txt

  $archivo = fopen("VARINI.txt", "a");
        // fwrite($archivo, PHP_EOL ."$contenido");
        // fclose($archivo);
  $ultimoIndice =$this->ultimo_indice_usuariosIweb();

   // archivo .txt

  $sqlExiste = "SELECT  COUNT(*) AS EXISTE FROM DGASUSUA WHERE CLIENTE = '$idCliente'";
  $resul_Exi = ibase_query($conexion, $sqlExiste);
  $existe = ibase_fetch_assoc($resul_Exi);
  ibase_free_result($resul_Exi); 
  if ($existe["EXISTE"] == 0) {
   try{
    $sql_ins_adm = "INSERT INTO DGASUSUA (CLIENTE,INDICE,USUARIOWEB,PASSWORDWEB,ADMINISTRADOR,ACTIVO,CORREOELECTRONICO,TELEFONO,CELULAR,FECHAALTA,USUARIOALTA,VARINI) 
    VALUES ('$idCliente','$ultimoIndice','ADMIN','$passwordweb','Si','Si','','','','$fechaalta','$usuario',$archivo)";
    $sql_ins_con = "INSERT INTO DGASUSUA (CLIENTE,INDICE,USUARIOWEB,PASSWORDWEB,ADMINISTRADOR,ACTIVO,CORREOELECTRONICO,TELEFONO,CELULAR,FECHAALTA,USUARIOALTA,VARINI) 
    VALUES ('$idCliente','$ultimoIndice','CONSULTA','$passwordweb','Si','Si','','','','$fechaalta','$usuario',$archivo)";
    $ins_adm   = ibase_query($tr, $sql_ins_adm);
    ibase_free_result($$ins_adm); 
    $ins_con   = ibase_query($tr, $sql_ins_con);
    ibase_free_result($ins_con); 
    $estado_adm = ibase_commit($tr);
    $estado_con=ibase_commit($tr);
  }catch(Exception $e){

  }
}


}
public function lista_de_password($idCliente,$conexion)
{
         # code...
 $selectnum = "SELECT  CONFIDENCIAL  FROM DGASTARJ WHERE NOCLIE ='$idCliente' ";
 $n= ibase_query($conexion, $selectnum);
 $cadenapass ="";
 while ( $pass  = ibase_fetch_assoc($n) ){
  $cadenapass.=$pass["CONFIDENCIAL"]." "; 
}
return $cadenapass;

}

public function insertTarjetas($numTarjetas, $idCliente,$usuario,$alias,$tipoCliente)
{
  $objeto   = new conexionGAS();
  $conexion = $objeto->conectarGAS();
        // $gas           = new GASOLINERA();

  $resultadoMasc = $this->mascaraEnUso();

        //tarer la mascara en uso
  $subString  = explode(" ", $resultadoMasc);
        $mascara    = $subString[0]; //612200062016
        $numInicial = $subString[1]; //0000

        //taer el ultimo pools usado en toda la tabla  520
        $ultimopool = $this->UltimoPoolUsado($mascara);

        if (($numTarjetas + $ultimopool) <= 9999) {

          $fechainicial = date("Y/m/d");
          $ultimafecha  = date('Y/m/d h:i:s');
          $fechafinal   = strtotime('+5 year', strtotime($fechainicial));
          $fechafinal   = date("Y/m/d", $fechafinal);



          $contadorDGAS  = 0;
          $contadorlocal = 0;
          $arrayTarjetas = "";
          $array_nip="";
          $num_vehiculos="";
          $foliomax = $this->folioMaximo("ASIGNARPOOLS");
          $cadenapass =$this->lista_de_password($idCliente,$conexion);

          for ($i = 1; $i<= $numTarjetas; $i++) {


            $selectnum = "SELECT MAX(VEHIC) AS VEHIC   FROM DGASTARJ WHERE NOCLIE ='$idCliente' ";
            $n         = ibase_query($conexion, $selectnum);
            $vehiculo  = ibase_fetch_assoc($n);




                //validar si el nip se repite en el cliente
            $random_number; 
            $ok = false;
            while($ok == false){
              $random_number = intval(rand(1, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9));
              (string)$random_number;
              $pos = strpos($cadenapass, $random_number);
              if($pos != "")
              {
                $ok = false;
              }else{
                $ok= true;
                $cadenapass.=" ".$random_number;
              }
            }

            $random_number = (string) $random_number;
            $numVehiculo   = $vehiculo["VEHIC"] + $i;
                $nextMascara   = $ultimopool + $i; //0520
                $nextMascara   = (string) $nextMascara;
                $caracteres    = strlen($nextMascara);

                if ($caracteres == 3) {
                  $tarjetafinal = $mascara . "0" . $nextMascara;
                } elseif ($caracteres == 2) {
                  $tarjetafinal = $mascara . "00" . $nextMascara;
                } elseif ($caracteres == 1) {
                    # code...
                  $tarjetafinal = $mascara . "000" . $nextMascara;
                } else {
                  $tarjetafinal = $mascara . "" . $nextMascara;
                }
                $vacio="";
                $idsig = $foliomax + $i;
                $descripcion = "Vehiculo ".$numVehiculo;
                $choferdef = "Chofer ".$numVehiculo;
                $insertDGASTARJ = "INSERT INTO DGASTARJ(NOCLIE,VEHIC,CODIGO,DESCRIPCION,PLACAS,CONFIDENCIAL,KILOMETRAJE,CHOFER,CONDUCTOR,DOMINGO,LUNES,MARTES,MIERCOLES,JUEVES,VIERNES,SABADO,TIPOMONTO,ESTATUS,PRODUCTOS,ACEPTAACEITES,NOECONOMICO,FECHAINICIAL,FECHAFINAL,RESTRINGE_KMS,RANGO_KMS,HORARIOCARGA,TODASESTACIONES,ESTACION,ULTIMAFECHA,SOLICITA_CHOFER,FLUJO,PASS_HUELLA,VALIDA_KM,RESTRINGE_FH,HEXHASH,TOPESEMANAL)

                VALUES('$idCliente','$numVehiculo','$tarjetafinal','$descripcion','S/N','$random_number','No',0,'$choferdef','Si','Si','Si','Si','Si','Si','Si','Importe','Activa','01 Magna;02 Premium;03 Diesel;','Si','$numVehiculo','$fechainicial','$fechafinal','No',500,'00:00 a 23:59','Si',0,'$ultimafecha','No',-1,'No','Si','No','$vacio',0)";

                
                $tr = ibase_trans("IBASE_WRITE", $conexion);
                $veri   = ibase_query($tr, $insertDGASTARJ);
                $estado = ibase_commit($tr);

                if ($estado == 1) {
                  $contadorDGAS++;
                  $sub = substr($tarjetafinal, 12);
                  (string)$idCliente;
                  (string)$numVehiculo;
                  $codigotarjeta=$idCliente."-".$sub;
                  $track1="R".$tarjetafinal."^TARJETA^2801725";
                  $track2=$tarjetafinal."=2801725";
                  $track3="";
                  $vehiculo="Vehiculo".$numVehiculo;
                  $arrayTarjetas.=$tarjetafinal."||";
                  $array_nip.=$random_number."||";
                  $num_vehiculos.=$numVehiculo."||";
                    // array_push($arrayTarjetas,$tarjetafinal);
                    // array_push($array_nip, $random_number );
                  $in = $this->insertarLocalTarjetas($idsig, $tarjetafinal, $idCliente, $usuario,$numVehiculo,$codigotarjeta,$alias,'S/N',$track1,$track2,$track3,$vehiculo,$fechafinal,$tipoCliente);


                  if($in  == 1 ){
                   $contadorlocal++;
                 }
               }
               } // fin del For

               if ($contadorDGAS == $contadorlocal) {

                $resul_metodo_Tarj = array("tarjetas" => "Tarjetas", "arrayTarjetas" => $arrayTarjetas,"arrayNip" =>$array_nip, "numerosVehiculos" => $num_vehiculos);

                return $resul_metodo_Tarj;
              } else {
                return "Solo se pudieron asignar " . $estado . " tarjetas verifique los resultados";
              }


            }

        //fin del if <=9999
            else {

              $TarjetasDisponobles = ($numTarjetas + $ultimopool) - 9999;

              return "El numero de tarjetas que desea, sobrepasa el permitido en esta mascara, la disponiblidad de tarjetas es: " . $TarjetasDisponobles;
            }

          }


          public function MascarasExistentes()
          {
            $ad    = new conexion();
            $admon = $ad->conectar();
            $max   = "SELECT *  FROM TABLAPOOLS WHERE CANCELADO = 'F' ";

            $mascaras = ibase_query($admon, $max);
        // $mascaras  = ibase_fetch_assoc($fo);
            ibase_free_result($mascaras); 
            ibase_close($admon);
            return $mascaras;
          }

          public function Mascaras_canceladas()
          {
            $con    = new conexion();
            $conexion = $con->conectar();
            $max   = "SELECT *  FROM TABLAPOOLS WHERE CANCELADO = 'V' ";

            $mascaras_can = ibase_query($conexion, $max);
        // $mascaras  = ibase_fetch_assoc($fo);
            ibase_free_result($mascaras); 
            ibase_close($conexion);
            return $mascaras_can;
          }

          public function reactivar_mascaras($mascara)
          {
        # code...
            $sql ="UPDATE TABLAPOOLS SET CANCELADO ='F'  WHERE MASCARA  ='$mascara' AND CANCELADO = 'V' ";
            $reactivar =ibase_query($this->conectarLocal(),$sql);
            if($reactivar == 1)
            {
              return "success**La mascara fue reactivada exitosamente";
            }else{
              return "error**Hubo problema para la reactivacion de la mascara**Si el problema persiste favor de llamar a sistemas";
            }
          }

          public function Activar_mascara($mascara)
          {
        # code...
        // $mascara =isset($_POST["mascara"]) ?   $_POST["mascara"] : "";
            $objeto = new conexion();
            $conexion =$objeto->conectar();

            $desac ="UPDATE TABLAPOOLS SET ESTATUS=''  WHERE ESTATUS  ='P' ";
            $desactivado =ibase_query($conexion,$desac);

            if($desactivado == 1){
              $act ="UPDATE TABLAPOOLS SET ESTATUS='P'  WHERE MASCARA  ='$mascara'";
              $activado =ibase_query ($conexion,$act);
              if($activado == 1){
                return "success**Activacion Exitosa";
              }
            }else{
              return "error**No se pudo actualizar la mascara seleccionada, intente mas tarde";
            }

          }
          public function mascaras_Usadas($mascara)
          {
            $ad    = new conexion();
            $admon = $ad->conectar();


            $can = "SELECT COUNT(*) as USADAS FROM ASIGNARPOOLS WHERE IDPOOLS CONTAINING  '$mascara'";
            $usadas = ibase_query($admon,$can);
            $r=ibase_fetch_assoc($usadas);
            ibase_free_result($usadas); 
            ibase_close($admon);
            return $r["USADAS"];

          }

          public function delete_mascaras($id)
          {
        # code...
            $con = new conexion();
            $conexion = $con->conectar();

            $sql ="UPDATE  TABLAPOOLS SET CANCELADO = 'V'  WHERE ESTATUS != 'P' AND ID = '$id'";
            $update =ibase_query($conexion,$sql);

            if($update == 1){
              return "success**La mascara ha sido eliminada exitosamente";
            }elseif($update == NULL) {
              return "error**No puedes eliminar una mascara, elegida como predeterminada";
            }
            else{
              return "error**Hubo problemas para eliminar la mascara, intentalo mas tarde";
            }
          }



          public function new_mascaras($mascara,$inicial,$final,$usuario)
          {
            $con= new conexion();
            $conexion=$con->conectar();
            $proc=ibase_trans("IBASE_WRITE",$conexion);
            $fecha=date("Y/m/d");
            $veri ="SELECT COUNT(*) as EXISTE,CANCELADO,ESTATUS,MASCARA  FROM TABLAPOOLS WHERE MASCARA = '$mascara'  GROUP BY CANCELADO,ESTATUS,MASCARA";
            $exi =ibase_query($conexion,$veri);
            $existente = ibase_fetch_assoc($exi);
            if($existente["EXISTE"] == 0){


              $select ="SELECT MAX(ID) as ID FROM TABLAPOOLS";
              $id = ibase_query($conexion,$select);
              $max_id = ibase_fetch_assoc($id);
              $max = $max_id["ID"] + 1;
              $agregar="INSERT INTO TABLAPOOLS (ID,MASCARA,NUMINICIAL,NUMFINAL,ESTATUS,USUARIO,CANCELADO)
              VALUES ('$max','$mascara','$inicial','$final', ' ','$usuario','F')";


              $accion=ibase_query($proc,$agregar);
              $estado=ibase_commit($proc);
              if($accion == 1){
                return "success**Mascara agregada";
              }else{
                return "error**Intente mas tarde, si el problema persiste llamar a sistemas";
              }

            }else{
              return "info**La mascara que desea agregar ya existe**".$existente["CANCELADO"]."**".$existente["ESTATUS"];
            }
          }


          public function mascaras_x_cliente($id,$empleado)
          {
        # code...

            $con= new conexionGAS();
            $conexion=$con->conectarGAS();
            $mascaras=array();
            $lisTarjetas="";
            $tarjetas="";
            $nips="";

            $gene = new generales();

            $placas=array();
            $choferes=array();
            $economico=array();

            $sql ="SELECT * FROM DGASTARJ WHERE NOCLIE = '$id' AND ESTATUS = 'Activa' ";
            $datos=ibase_query($conexion,$sql);


            #quitar acentos y caracteres raros a los nombre por porblemas en la impresion de tarjetas
            $nombre_reparadox = $this->nombrecomercial($id); /*nueva funcion para asignar nombre comercial*/
           
            while($d=ibase_fetch_assoc($datos))
            {

              $noeco=$d["NOECONOMICO"];
              $pla = $d["PLACAS"];
              $veh = $gene->reparar_utf8($d["DESCRIPCION"]);
              $tar=$d["CODIGO"];
              $vehiculo_sin_acentos =$this->reemplazar_caracteres($d["DESCRIPCION"]);


              $upd="UPDATE ASIGNARPOOLS SET NOMBRECLIENTE = '$nombre_reparadox' , NOECONOMICO = '$noeco', PLACAS = '$pla', VEHICULO='$vehiculo_sin_acentos', SINCRONIZADO = 'SI'  WHERE IDPOOLS = '$tar'";
              $act = ibase_query($this->conectarLocal(),$upd);
              $masc = substr($d["CODIGO"], 0,12);
              if( !in_array($masc, $mascaras))
              {
                array_push($mascaras, $masc );
              }
              
              $chofer= $gene->reparar_utf8($d["CONDUCTOR"]);
              $tarjetas.=$d["CODIGO"]."||";
              $nips.=$d["CONFIDENCIAL"]."||";
              $lisTarjetas.=$d["CODIGO"]."||";
              array_push($placas, $d["PLACAS"]);
              array_push($choferes,$chofer );
              array_push($economico, $d["NOECONOMICO"]);


            }

            $datos_clientes = array("mascaras" => $mascaras, "tarjetasArray" => $lisTarjetas, "tarjetasExcel" => $tarjetas, "nipsExcel" => $nips, "empleado" => $empleado,"placas"=>$placas,"choferes" => $choferes, "economico" => $economico);

            return $datos_clientes;
          }


          public function nombre_cliente($id)
          {
            $gene = new generales();
            $sql_nombre_cliente  = "SELECT NOMBRE FROM DGENCLIE WHERE NOCLIE ='$id'";
            $datos_clie = ibase_query($this->conectarADMON(),$sql_nombre_cliente);
            $asignado = ibase_fetch_assoc($datos_clie);
            // $nom = $gene->reparar_utf8(
            $nombre_reparado = $this->reemplazar_caracteres($asignado["NOMBRE"]);
            return  $nombre_reparado;
          }

          public function nombrecomercial($id)
          {
            $genec = new generales();
            $sql_nombrecomercial  = "SELECT NOMBRECOMERCIAL FROM DGENCLIE WHERE NOCLIE ='$id'";
            $datos_cliecomer = ibase_query($this->conectarADMON(),$sql_nombrecomercial);
            $asignadocomercial = ibase_fetch_assoc($datos_cliecomer);
            // $nom = $gene->reparar_utf8(
            $nombre_reparadox = $this->reemplazar_caracteres($asignadocomercial["NOMBRECOMERCIAL"]);
            return  $nombre_reparadox;
          }

          public function Mascaras()
          {
            $ad    = new conexion();
            $admon = $ad->conectar();
            $max   = "SELECT *  FROM TABLAPOOLS WHERE CANCELADO =  'F' ";
            $arraymascaras = array();
            $mascaras = ibase_query($admon, $max);
            $cont= 0;

            while ($masca = ibase_fetch_assoc($mascaras)) {

              $arraymascaras [$cont]= $masca;
              $cont++;
            }

            // ibase_free_result($mascaras); 
            // ibase_close($admon);
            
            return $arraymascaras;
          }
          public function accordionTarjetas($mascara)
          {
        # code...
            $ad    = new conexion();
            $admon = $ad->conectar();
            $max   = "SELECT *  FROM ASIGNARPOOLS WHERE  IDPOOLS CONTAINING '$mascara'";

            $filtro = ibase_query($admon, $max);

            return $filtro;
          }


          public function FormasdePago()
          {
        # code...
            $ad      = new conexionADMON();
            $admon   = $ad->conectarADMON();
            $max   = "SELECT *  FROM DGENMPAG";

            $filtro = ibase_query($admon, $max);
            ibase_free_result($filtro); 
            ibase_close($admon);
            return $filtro;
          }


          public function busquedaModificacion($nombre)
          {
        # code...

//aqui movi quite el containg por un =
           $cone      = new conexionADMON();
           $coneAdmon = $cone->conectarADMON();
           $resultado="";
           if($nombre == "")
           {
            return  $resultado = "";
          }else{


            if(ctype_digit($nombre)){
              $cliente   = "SELECT FIRST(20) * FROM DGENCLIE WHERE  NOCLIE = '$nombre' ";
            }else{
              $cliente   = "SELECT FIRST(20) * FROM DGENCLIE WHERE 
              (UPPER(NOMBRE) CONTAINING UPPER('$nombre')  
              OR  UPPER(NOMBRE)  LIKE UPPER('%" . $nombre . "%') ) ";
            }

            $query     = ibase_query($coneAdmon, $cliente);

            
            
            while ($row = ibase_fetch_assoc($query)){
              $direccionfinal =$row["DIRECCION"].", ".$row["POBLACION"].". ".$row["ESTADO"].". ".$row["PAIS"].".";

              $numerointerior="";
              if($row['NUMEROINT'] == "numInt" ||$row['NUMEROINT'] == "" ): $numerointerior =""; endif;
              $resultado.="<tbody>




              <tr  id='contenido_clientes' style='cursor:pointer;' >

              <td  id='heading".$row['NOCLIE']."' scope ='row' style='text-align: left;'  class=' letras  card-header'>".$row['NOCLIE']."
              </td>

              <td  id='heading" . $row['NOCLIE'] . "' scope ='row' style='text-align: left;'  class=' letras  card-header'>

              <a class='' data-toggle='collapse' data-target='#collapse".$row['NOCLIE']."' aria-expanded='true' aria-controls='collapse".$row['NOCLIE']."' 
              onclick ='Activo_Forma(".$row["NOCLIE"].")'>
              ".$row['NOMBRE']."
              </a>
              <div id='collapse" . $row['NOCLIE'] . "' class='collapse' aria-labelledby='heading" . $row['NOCLIE'] . "' data-parent='#contenido_clientes'>









              <div id='collapse  ".$row['NOCLIE']."  class='collapse' aria-labelledby='heading  ".$row['NOCLIE']." '' data-parent='#contenido_clientes'>
              <div class='card-body'>
              <h5 style='text-align: center;'>Informacion General</h5>
              <div class='d-flex flex-wrap justify-content-between col-lg-12 mx-auto' >

              <div class='form-group col-lg-6 '>
              <label for='inputEmail4'>NOCLIE</label>
              <input type='text' class='form-control' id='noclie".$row['NOCLIE']."' value='  ".$row['NOCLIE']." ' disabled>
              </div>

              <div class='form-group col-lg-6 '>
              <label for='inputEmail4'>Nombre</label>
              <input type='text' class='form-control' id='nombrecli".$row['NOCLIE']."' value='  ".$row['NOMBRE']." '>
              </div>


              </div>
              <div class='d-flex flex-wrap justify-content-between col-lg-12 mx-auto' >
              <div class='form-group col-md-6 col-lg-4'>
              <label for='inputEmail4'>Calle</label>
              <textarea type='text' class='form-control' id='callecli".$row['NOCLIE']."'  > ". $row['CALLE']."  </textarea>
              </div>
              <div class='form-group col-md-4 '>
              <label for='inputEmail4'>Numero exterior</label>
              <input type='' class='form-control' id='numeroExtcli".$row['NOCLIE']."' placeholder='' value='  ".$row['NUMEROEXT']." ' >
              </div>
              <div class='form-group col-md-4 '>
              <label for='inputEmail4'>Numero interior</label>
              <input type='' class='form-control' id='numeroIntcli".$row['NOCLIE']."' placeholder='' value='  ".$numerointerior." ' >
              </div>
              </div>
              <div class='d-flex flex-wrap justify-content-between col-lg-12 mx-auto' >
              <div class='form-group col-md-6 col-lg-4'>
              <label for=''>Pais</label>
              <input type='text' class='form-control' id='' disabled='' value='  ".$row['PAIS']."' >
              </div>
              <div class='form-group col-md-4 '>
              <label for='inputEmail4'>Estado</label>
              <input type='' class='form-control' id='' placeholder='' value='  ".$row['ESTADO']." ' disabled=''>
              </div>
              <div class='form-group col-md-4 '>
              <label for='inputEmail4'>Cod.postal</label>
              <input type='' class='form-control' id='cpcli".$row['NOCLIE']."' placeholder='' value='  ".$row['COD_POST']." ' >
              </div>
              </div>
              <div class='d-flex flex-wrap justify-content-between col-lg-12 mx-auto' >
              <div class='form-group col-md-6 col-lg-6'>
              <label for='inputEmail4'>Municipio</label>
              <input type='text' class='form-control' id='municipiocli".$row['NOCLIE']."'  value='  ".$row['MUNICIPIO']."' >
              </div>
              <div class='form-group col-md-6 '>
              <label for=''>Referencia</label>
              <input type='' class='form-control' id='xdass".$row['NOCLIE']."' disabled='' placeholder='' value=' ' >
              </div>

              </div>
              <div class='d-flex flex-wrap justify-content-between col-lg-12 mx-auto' >
              <div class='form-group col-md-6 col-lg-6'>
              <label for=''>Persona o contacto</label>
              <input type='text' class='form-control' id='contactocli".$row['NOCLIE']."'  value='  ".$row['PERSONA']."' >
              </div>
              <div class='form-group col-md-6 '>
              <label for='inputEmail4'>Correo</label>
              <input type='' class='form-control' id='correocli".$row['NOCLIE']."' placeholder='' value='  ".$row['EMAIL']."' >
              </div>

              </div>
              <div class='d-flex flex-wrap justify-content-between col-lg-12 mx-auto'                              
              <div class='form-group col-md-4 '>
              <input type='text' id ='metodopagoinput".$row['NOCLIE']."' class ='d-none' value='".$row["METODOPAGODEFAULT"]."'>
              <label for='metodoPago'>Metodos de pago</label>
              <select class='custom-select' id='metodopagocli".$row['NOCLIE']."'>


              <option value='1'>Efectivo</option>
              <option value='2'>Cheque nominativo</option>
              <option  value='3'>Transferencia electronica de fondos</option>
              <option  value='4'>Tarjeta de Credito</option>
              <option  value='5'>Monedero Electronico</option>
              <option  value='6'>Dinero electronico</option>
              <option  value='8'>Vales de despensa</option>
              <option  value='28'>Tarjeta de Debito</option>
              <option  value='29'>Tarjeta de Servicio</option>
              <option  value='98'>NA</option>
              <option  value='99'>NA</option> 


              </select>
              </div>
              <div class='form-group col-md-4 '>
              <label for=''></label>
              <input type='text' id ='activoinput".$row['NOCLIE']."' class='d-none' value='".$row["ACTIVO"]."'>
              <input class='form-check-input' type='checkbox' id='activocli".$row['NOCLIE']."' value='option1'>
              <label class='form-check-label' for='activocli".$row['NOCLIE']."'>Activo</label>
              </div>



              </div>
              <div class='d-flex flex-wrap justify-content-center col-lg-12 mx-auto'  >
              <div class='form-group '>
              <i class='fas fa-save fa-2x' onclick='modificacion_clientes(".$row['NOCLIE'].")'></i>

              </div>
              </div>

              </div>
              </div>
              </td>




              </tr>

              </tbody>";
            }
// modificacion_clientes()
            return $resultado;
          }
        }

        public function modificacionClientes($id,$nombre,$calle,$numExt,$numInt,$cp,$contacto,$correo,$metodoPago,$activo)

        {
          $objeto = new conexionADMON();
          $conexion =$objeto->conectarADMON();
          $id=(int)$id;
          $metodoPago=(int)$metodoPago;
          $cp = (int)$cp;

          $queryCam ="UPDATE DGENCLIE SET NOMBRE='$nombre',CALLE='$calle',NUMEROEXT='$numExt',NUMEROINT='numInt',COD_POST='$cp', PERSONA='$contacto',EMAIL='$correo',METODOPAGODEFAULT='$metodoPago',ACTIVO='$activo'  WHERE NOCLIE  ='$id'";
          $resultado =ibase_query ($conexion,$queryCam);
          return $resultado;
        }


        public function sincronizador_tarjetas($usuario)

        {

          $sql ="SELECT * FROM DGASTARJ";
          $registros = ibase_query($this->conectarGasolinera(),$sql);
          $cont =1;


          while($r=ibase_fetch_assoc($registros)){


            $sub = substr($r["CODIGO"], 12);
            (string)$r["NOCLIE"];
            $vehic="".$r["VEHIC"];
            $codigotarjeta=$r["NOCLIE"]."-".$sub;
            $track1="R".$r["CODIGO"]."^TARJETA^2801725";
            $track2=$r["CODIGO"]."=2801725";
            $track3="";
            $vehiculo="Vehiculo".$r["VEHIC"];
            (string)$r["FECHAFINAL"];
            $ff = explode(" ", $r["FECHAFINAL"]);
            $fechafinal=$ff[0];
                    // var_dump($r["NOCLIE"]);
            $clientes= $this->Clientes($r["NOCLIE"]);
            $rv =ibase_fetch_assoc($clientes);
            $tipocli ="";

            if($rv["CLASIFICA"] == 3):
              $tipocli="PREPAGO";

            elseif ($rv["CLASIFICA"] == 2): 
              $tipocli ="CREDITO";

            elseif($rv["CLASIFICA"] == 1):
              $tipocli ="CONTADO";

            else:
              $tipocli="DESCONOCIDO";

            endif;

                    // echo $r["CODIGO"]."<br>";

                    // $dt = new DateTime($fechafinal);
                    //  $fechaf = $dt->format('d/m/Y'); // imprime 29/03/2018
                    //  var_dump($fechaf)."<br>";
                    // var_dump($cont, $r["CODIGO"], $r["NOCLIE"], $usuario,$vehic,$codigotarjeta,$rv["NOMBRE"],$r["PLACAS"],$track1,$track2,$track3,$vehiculo,$fechafinal,$tipocli)."<br>";

            $this->insertarLocalTarjetas($cont, $r["CODIGO"], $r["NOCLIE"], $usuario,$vehic,$codigotarjeta,$rv["NOMBRE"],$r["PLACAS"],$track1,$track2,$track3,$vehiculo,$fechafinal,$tipocli,$r["ESTATUS"]);
            $cont++;

          }
          echo $cont;
// $fecha = date("Y/m/d");
// var_dump($fecha);
// $this->insertarLocalTarjetas(1, "0000000000000000", 1, "admin","1","1","nn","VGH-7671","R0001^TARJETA^2801725","0001=2801725","","Vehiculo1",$fecha ,"CONTADO");
        }

        public function estaciones()
        {
          $sql ="SELECT * FROM ESTACIONES";
          $estacion = ibase_query($this->conectarLocal(),$sql);
          $estaciones = array();
          while ($est = ibase_fetch_assoc($estacion)) {
            array_push($estaciones, $est);
          }
          ibase_free_result($estacion);
          ibase_close($this->conectarLocal());
          return $estaciones;
        }



        public function busqueda_liquidaciones_detallada($fecha,$estacion,$isla,$turno)
        {
          $fecha;
          (int)$estacion;
          (int)$isla;
          (int)$turno;
          $estaciones  = $this->estaciones();
          $estacion_nombre = "";
          $datos=array();
          $cont = 0;

          $date = new DateTime($fecha);
          $fecha_bd = $date->format('d.m.Y');
          $sql = "SELECT * FROM DGASLIQG WHERE  FECHA  = '$fecha_bd' AND ESTACION = '$estacion' AND ISLA = '$isla' AND TURNO = '$turno'";
          $liquidaciones = ibase_query($this->conectarGasolinera(),$sql);

          while ($liq = ibase_fetch_assoc($liquidaciones)) {

            for ($i=0; $i <count($estaciones) ; $i++) { 
              if ($liq["ESTACION"] == $estaciones[$i]["ID"]) {
                $estacion_nombre = $estaciones[$i]["ESTACION"];
                break;
              }
            }
            $fecha = explode(" ", $liq["FECHA"]);
            $borrar = $liq["FOLIO"]."*".$liq["ESTACION"]."*".$liq["TURNO"]."*".$fecha[0]."*".$liq["ISLA"];
            $datos_liqui= array(
              "estacion"=> $estacion_nombre,
              "folio"=>$liq["FOLIO"],
              "isla"=>$liq["ISLA"],
              "fecha"=>$liq["FECHA"],
              "turno"=>$liq["TURNO"],
              "total"=>$liq["TOTGRAL"],
              "borrar"=>$borrar

            );

            $datos["data"][] = $datos_liqui;
            $cont++;
          }

          if ($cont > 0) {
            return json_encode($datos);
          }else{
            $datos["data"]=[];
            return json_encode($datos);
          }
        }

        public function eliminar_liquidaciones($folio,$estacion,$turno,$fecha,$isla)
        {
          $contador = 0;
          $errores =array();
          (int)$folio;
          (int)$estacion;
          (int)$turno;
          $respuesta= array();
          $date = new DateTime($fecha);
          $fecha_bd = $date->format('d.m.Y');
          //conexion
          $conexion_gas  = $this->conectarGasolinera();
          
          $tablas = ["DGASDLIQC","DGASDLIQP", "DGASDLIQA","DGASLIQG"];
          for ($i=0; $i <count($tablas) ; $i++) { 




            if ($tablas[$i] == "DGASDLIQP") {

              $update = "UPDATE  " .$tablas[$i]. "  SET APLICADO = 'No' WHERE 
              FOLIO = '$folio' AND 
              ESTACION  = '$estacion' AND 
              TURNO = '$turno'  AND 
              FECHA = '$fecha_bd'  ";
            }else{

              $update = "UPDATE  " .$tablas[$i]. "  SET APLICADO = 'No' WHERE 
              FOLIO = '$folio' AND 
              ESTACION  = '$estacion' AND 
              TURNO = '$turno'  AND 
              FECHA = '$fecha_bd'  AND 
              ISLA = '$isla'";
            }
            // echo $update;
            $actualizado =ibase_query($conexion_gas,$update);

            if ($actualizado) {
              if ($tablas[$i] == "DGASDLIQP") {
               $borrar="DELETE FROM ".$tablas[$i]." WHERE APLICADO = 'No' AND FOLIO = '$folio' AND ESTACION  = '$estacion' AND TURNO = '$turno' AND FECHA = '$fecha_bd' ";
             }else{
               $borrar="DELETE FROM ".$tablas[$i]." WHERE APLICADO = 'No' AND FOLIO = '$folio' AND ESTACION  = '$estacion' AND TURNO = '$turno' AND FECHA = '$fecha_bd' AND ISLA = '$isla' ";
             }
             
             $borrado = ibase_query($conexion_gas,$borrar);
             if ($borrado) {

              $contador++;
            }else{
              array_push($errores, $tablas[$i]."** Borrar");
            }
          }else{
            array_push($errores, $tablas[$i]."** Actualizar");
          }


        } 
        //fdf
        $gene = new generales();

        if ($contador == count($tablas)) {
          $respuesta= ["tipo" => "success", "mensaje" => "Liquidacion eliminada"];
          
          $gene->monitoreo_movimientos($this->conectarLocal(),"HERRAMIENTAS","Borrar",$_SESSION["user"],"Eliminar Liquidaciones", "Exitoso");
          return json_encode($respuesta);
        }else{

         $gene->monitoreo_movimientos($this->conectarLocal(),"HERRAMIENTAS","Borrar",$_SESSION["user"],"Eliminar Liquidaciones", "Error");
         $respuesta= ["tipo" => "error", "mensaje" => "No se pudo eliminar en todas las tablas" ,"errores" => $errores];
         return json_encode($respuesta);
       }


     }



     public function eliminacion_conexion($ip)
     {

      // $query = "SELECT * FROM EMPLOYEES";
      // $p_sql = ibase_prepare($query);
      // $result = ibase_execute($p_sql);

      $sql = "SELECT * FROM  MON$ATTACHMENTS A WHERE A.MON$ATTACHMENT_ID <> CURRENT_CONNECTION  and  A.MON$REMOTE_ADDRESS = '$ip' AND A.MON$REMOTE_PROCESS = 'C:\Imagenco\PrgGas\Liq\PLIQMENU.exe'";
      $conexiones = ibase_query($this->conectarGasolinera_p(), $sql);
      // $conexiones = ibase_execute($consulta);
      return $this->conectarGasolinera_p();



    }







  }
