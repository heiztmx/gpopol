<?php 


require_once '../../../NuSOAP/lib/nusoap.php';
include '../metOperadores/metodosOperadores.php';
$id =isset($_POST["idOperador"]) ? $_POST["idOperador"] : "";
$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
$estacion =isset($_POST["estacion"]) ? $_POST["estacion"] : "";
$password =isset($_POST["password"]) ? $_POST["password"] : "";
$activo =isset($_POST["activo"]) ? $_POST["activo"] : "";
$jefe = isset($_POST["jefe"]) ? $_POST["jefe"] : "";
$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
$id = (int)$id;
$estacion=(int)$estacion;


try {
  $client = new nusoap_client("http://172.16.0.13:9092/BD.asmx?WSDL",true);
  
} catch (Exception $e) {
  print_r("Error al conectarse al Web Services comunicarse con el administrador del sistema".$e);

}

$objeto = new Operadores();
$ips = array();
$estacionesID =array();
$estacionesNombre=array();
$resultados="";
$contador=0;
$xx="";




$estas=$objeto->tablaEstaciones();
while($r = ibase_fetch_assoc($estas))
{
  array_push($ips, $r["IP"]);
  array_push($estacionesID, $r["ID"]);
  array_push($estacionesNombre, $r["ESTACION"]);
}

$ExistePass = $objeto->VerificarPassword($password,$nombre,$id);
if ($ExistePass > 0) {
  print_r("ExistePassword");
}else{

  if ($tipo  == "Global") {

    for ($i =0; $i<count($ips); $i++) { 

      $paraDESPA=array(); 
      $paraDESPA['IPESTACION']=$ips[$i];
      $paraDESPA['CLAVE']=$id;                         
      $paraDESPA['NOMBRE']=$nombre;
      $paraDESPA['ESTACION']=$estacion;
      $paraDESPA['PASSW']=$password;
      $paraDESPA['ACTIVO']=$activo;
      $paraDESPA['ESJEFEDETURNO']=$jefe;
      $paraDESPA['TIPO_DESPACHADOR']=$tipo;

      $resul=$client->call('UdpDespachador',$paraDESPA);
// $resul['UdpDespachadorResult']  == NULL || $resul['UdpDespachadorResult']  == ""
      if ($resul['UdpDespachadorResult']  == "NoExiste" ) {
        $resul=$client->call('SetDespachador',$paraDESPA);
        if($resul['SetDespachadorResult'] == "Agregado")
        {
          $resuldados.=$estacionesNombre[$i]."||";
          $contador++;
        }else{
          $resuldados.=$resul['UdpDespachadorResult']."||";
        }
      }else{


        if ($resul['UdpDespachadorResult'] == "Actualizado") {
          $resultados.=$estacionesNombre[$i]."||";
          $contador++;
        }
      }

    }  
    if ($contador > 0) {
      $modificado = $objeto->ModificacionOper($id,$nombre,$estacion,$password,$activo,$jefe,$tipo);
              // ModificacionOper($id,$nombre,$estacion,$password,$activo,$jefe,$tipo)
      if($modificado == 1){
        $resultados.="||actualizado";
        print_r($resultados);
      }else{
        $resultados.="||Error_Local";
        print_r($resultados);
      }
    }else{
      print_r("Error");
    }

  }else{
            //if local
    for($i=0; $i<count($ips); $i++)
    { 
      $activo1 ="";
      
      if($activo == "Si")
      {

        if($estacionesID[$i] == $estacion)
        {
          $activo1 ="Si";
        }else{
          $activo1="No";
        } 
      }else{
        $activo1="No";
      }

      $paraDESPA=array(); 
      $paraDESPA['IPESTACION']=$ips[$i];
      $paraDESPA['CLAVE']=$id;                         
      $paraDESPA['NOMBRE']=$nombre;
      $paraDESPA['ESTACION']=$estacion;
      $paraDESPA['PASSW']=$password;
      $paraDESPA['ACTIVO']=$activo1;
      $paraDESPA['ESJEFEDETURNO']=$jefe;
      $paraDESPA['TIPO_DESPACHADOR']=$tipo;
      $resul=$client->call('UdpDespachador',$paraDESPA);

      if ($resul['UdpDespachadorResult']  != "Actualizado") {

        $resul=$client->call('SetDespachador',$paraDESPA);
        if ($resul['SetDespachadorResult' == "Agregado"]) {
          $contador++;
        } 
      } elseif($resul['UdpDespachadorResult'] == "Actualizado")
      {
        $contador++;
      }
    }

    if($contador > 0)
    {
      $modificado = $objeto->ModificacionOper($id,$nombre,$estacion,$password,$activo,$jefe,$tipo);
      if ($modificado == 1) {
       print_r("UpdateLocal");
     }else{
      print_r("Error_Local");
    }
  }else{
   print_r("Error");

 }












}    
}
?>