
    <?php 

$name = isset($_POST["nombre"]) ? $_POST["nombre"]: "x";
$email=isset( $_POST["correo"]) ? $_POST["correo"]: "x";
$phone= isset( $_POST["telefono"]) ? $_POST["telefono"]: "x";
$message= isset( $_POST["mensaje"]) ? $_POST["mensaje"]: "x";



$respuesta ="";

$destinatario = "jesusku@techsystems.com.mx"; 
$asunto = "Contacto Velazquez y Aguilar Abogados"; 
$cuerpo = ' 
<html> 
<head> 
<title>Cor</title> 
</head> 
<body> 
<h1>Contacto Velazquez y Aguilar Abogados</h1> 
<p> 
<table style="width:100%">
 <tr>
 </tr>
 <tr><td>Nombre: '.$name.'</td></tr>

 <tr><td>Email: '.$email.'</td></tr>
 <tr><td>phone: '.$phone.'</td></tr>

 <tr><td>Mensaje: '.$message.'</td></tr>


 
</table>
</p> 
</body> 
</html> 
'; 

//para el envío en formato HTML 
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

//dirección del remitente 
$headers .= "From:<jesusku@techsystems.com.mx>\r\n"; 

//dirección de respuesta, si queremos que sea distinta que la del remitente 
// $headers .= "Reply-To: mariano@desarrolloweb.com\r\n"; 

//ruta del mensaje desde origen a destino 
// $headers .= "Return-path: holahola@desarrolloweb.com\r\n"; 

//direcciones que recibián copia 
$headers .= "Cc:jesusku@techsystems.com.mx\r\n"; 

//direcciones que recibirán copia oculta 
// $headers .= "Bcc: pepe@pepe.com,juan@juan.com\r\n"; 


if (@mail($destinatario,$asunto,$cuerpo,$headers))
{	
	$respuesta="enviado";
    print_r($respuesta);
}else{
 $respuesta "error";
 print_r($respuesta);
 
}
?>
