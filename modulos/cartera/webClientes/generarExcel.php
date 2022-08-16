<?php 	
require_once '../../../PHPExcel/Classes/PHPExcel.php';

$tarjetas = $_GET["tarjetas"];
$nips = $_GET["nips"];
$nombre =$_GET["nombre"];
$noclie =$_GET["noclie"];
$usuario= $_GET["usuario"];
$tipo_cliente=$_GET["tipo_cliente"];
$num_vehiculos=$_GET["num_vehiculos"];
$reparado_nombre="";
if(!mb_detect_encoding($nombre,"UTF-8",true)){
    $reparado_nombre = utf8_encode($nombre);
}else{
    $reparado_nombre=$nombre;
}
$p_asignar=$reparado_nombre;
// print_r($p_asignar);
// $array_tarjetas=array("6122000620161072","6122000620161073","6122000620161074","6122000620161075","6122000620161076","6122000620161077","6122000620161078","6122000620161079","6122000620161080","6122000620161081","6122000620161082","6122000620161083","6122000620161084","6122000620161085","6122000620161086","6122000620161087","6122000620161088","6122000620161089","6122000620161090","6122000620161091","6122000620161092","6122000620161093","6122000620161094","6122000620161095","6122000620161096","6122000620161097","6122000620161098","6122000620161099","6122000620161100","6122000620161101","6122000620161102","6122000620161103","6122000620161104","6122000620161105","6122000620161106","6122000620161107","6122000620161108","6122000620161109","6122000620161110","6122000620161111","6122000620161112","6122000620161113","6122000620161114","6122000620161115","6122000620161116","6122000620161117","6122000620161118","6122000620161119","6122000620161120","6122000620161121","6122000620161122","6122000620161123","6122000620161124","6122000620161125","6122000620161126");
// $array_nips=array("7184","8944","8491","8389","5872","8652","4929","6280","7607","7946","7041","6914","8702","8139","9852","7261","6761","3352","7608","5497","7024","1720","2513","4884","4425","7284","3132","1497","8855","5096","6117","7350","7069","6988","3100","4301","3362","9695","6725","5377","8408","9078","3651","3243","7951","1059","5672","6979","3548","6839","4265","8926","4164","9342","7898");
// $noclie="3325";
// $nombre="CORPORACIONDEDESARROLLOINMOBILIARIO,S.ADEC.V";
// $usuario ="Admin";
// $tipo_cliente="CR";


// $caracteres=array(" ", ".", ",");

// for ($i=0; $i <count($caracteres) ; $i++) { 
//     # code...
//   $nombre =  str_replace($caracteres[$i] , "_", $nombre);
// }

$documento ="DOCUMENTO GPO ".$tipo_cliente." ".$noclie;
$array_tarjetas = explode( '||', $tarjetas );
$array_nips = explode( '||', $nips );
$vehiculos = explode( '||', $num_vehiculos );
 // fecha en que se genera el excel 
$timestamp = date("m.d.y"); 
date_default_timezone_set('UTC');
date_default_timezone_set("America/Mexico_City");
$hora = strftime("%I:%M:%S %p", strtotime($timestamp));
setlocale(LC_TIME, 'spanish');
$fecha = utf8_encode(strftime("%A %d de %B del %Y", strtotime($timestamp)));
$datetime=$fecha;
$hoy = date("Y-m-d H:i:s");

$cli_nom_id = $noclie." - ".$nombre;
$cont =0;

$por_hoja = 20;
$ope2 = count($array_tarjetas) % $por_hoja;
$sheets=0;
$br=0;

if($ope2 != 0)
{
	$ope = count($array_tarjetas) / $por_hoja;
	$res = explode(".",$ope);
	$sheets = $res[0]+ 1;

}else{
	$sheets = count($array_tarjetas) / $por_hoja;

}

//elimina ultimo dato del array de tarjetas, sirver para que no escriba un chofer sin datos. 
//ALV no lo borren y ya :v
$ultimo = array_pop($array_tarjetas);


$objPHPExcel = new PHPExcel();




$objReader = PHPExcel_IOFactory::createReader("Excel2007");
$conte_arrays_tar = array_chunk($array_tarjetas, 20);
$conte_arrays_nip = array_chunk($array_nips, 20);
$conte_arrays_veh = array_chunk($vehiculos, 20);
// asort($conte_arrays_tar);
// asort($conte_arrays_nips);

$ch=0;
$contador=1;
$objPHPExcel = $objReader->load('Plantilla.xlsx');
for ($y=0; $y<$sheets; $y++) { 


    $paginas =$contador." de ".$sheets;
    $objHoja = $objPHPExcel->getSheet($y);
    $objHoja->setTitle("Hoja ".$contador); //Establecer nombre 

    
    
    $objHoja->setCellValue('H11', $datetime);
    $objHoja->setCellValue('C16', $cli_nom_id);
    $objHoja->setCellValue('D18', $nombre);
    $objHoja->setCellValue('F20', $noclie);
    $objHoja->setCellValue('G12', $usuario);

    for ($i=0; $i<count($conte_arrays_tar[$y]); $i++) { 
        $f =$i+26;
        $ch++;
        $cont++;

        $shut_tarjeta  = substr($conte_arrays_tar[$y][$i], -4); 
        $new_tarjeta = $noclie."-".$shut_tarjeta;

        $objHoja->setCellValue("C12",$paginas);
        $objHoja->setCellValue("B10",$documento);
        $objHoja->setCellValue('B'.$f, $new_tarjeta);

        $objHoja->setCellValue('E'.$f, "S/N");
        $objHoja->setCellValue('F'.$f, $conte_arrays_veh[$y][$i]);
    // $objHoja->setCellValue('F'.$f, "NA");

        $objHoja->setCellValue('G'.$f, "Chofer".$ch);
        $objHoja->setCellValue('J'.$f, $conte_arrays_nip[$y][$i]);



    }
    $contador++;
}



    $para_for=7-$sheets;  //6

    if($para_for > 0):

        for ($i=0; $i <$para_for; $i++) { 
            $sh = $i + $sheets;
            $objPHPExcel->setActiveSheetIndexByName('hoja'.$sh);
            $sheetIndex = $objPHPExcel->getActiveSheetIndex();
            $objPHPExcel->removeSheetByIndex($sheetIndex);


        }
    endif;



    $archivo =$p_asignar." ".$hoy;

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$archivo.'.xlsx"');
    header('Cache-Control: max-age=0');
    $objwriter = PHPExcel_IOFactory::createWriter($objPHPExcel,"Excel2007");
    $objwriter->save('php://output');


//********************************EMAIL**********************************
// //Recipiente
// $to = 'soporte@poligas.com.mx';

// //remitente del correo
// $from = 'remitente@miexample.com';
// $fromName = 'Tarjetas Asignadas';

// //Asunto del email
// $subject = 'Correo electrónico PHP con datos adjuntos de BaulPHP'; 

// //Ruta del archivo adjunto

// $file =$archivo;

// //Contenido del Email
// $htmlContent = '<h1>Correo electrónico PHP con datos adjuntos de BaulPHP</h1>
//     <p>Este correo electrónico ha enviado desde script PHP con datos adjuntos.</p>';

// //Encabezado para información del remitente
// $headers = "De: $fromName"." <".$from.">";

// //Limite Email
// $semi_rand = md5(time()); 
// $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

// //Encabezados para archivo adjunto 
// $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 

// //límite multiparte
// $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
// "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n"; 

// //preparación de archivo
// if(!empty($file) > 0){
//     if(is_file($file)){
//         $message .= "--{$mime_boundary}\n";
//         $fp =    @fopen($file,"rb");
//         $data =  @fread($fp,filesize($file));

//         @fclose($fp);
//         $data = chunk_split(base64_encode($data));
//         $message .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\n" . 
//         "Content-Description: ".basename($files[$i])."\n" .
//         "Content-Disposition: attachment;\n" . " filename=\"".basename($file)."\"; size=".filesize($file).";\n" . 
//         "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
//     }
// }
// $message .= "--{$mime_boundary}--";
// $returnpath = "-f" . $from;

// //Enviar EMail
// $mail = @mail($to, $subject, $message, $headers, $returnpath); 

// //Estado de envío de correo electrónico
// echo $mail?"<h1>Correo enviado.</h1>":"<h1>El envío de correo falló.</h1>";

    ?>