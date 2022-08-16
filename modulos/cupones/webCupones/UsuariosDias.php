<?php 
include '../metCupones/metodosCupones.php';

$fecha =isset($_POST["fecha"]) ? $_POST["fecha"] : "";
$fecha=$fecha." 00:00";

 $objetoCup = new Cupones();
                  $nombres=$objetoCup->UsuariosCupones($fecha);
               
                  
                  // // $arreglo = explode(" " , $tabla);
                  // // $nombre=array();
                  // // $ip=array();
                  // // $nombre =explode("||", $arreglo[0]);
                  // // $ips = explode("||", $arreglo[1]);

                  for($i=0; $i<count($ipIGAS); $i++)
                  {

                    $respuesta.="<option  value='".$r["NOMBRE"]."'>".$r["NOMBRE"]."</option>";
                  }

print_r($respuesta);

 ?>