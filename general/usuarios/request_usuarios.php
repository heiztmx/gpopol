<?php 
include '../../conexion.php';



$datos =isset($_POST["datos"]) ? $_POST["datos"] : "fdfdfererererererererer||37";
$password = isset($_POST["password"])  ? $_POST["password"] : "";
$correo = isset($_POST["correo"]) ? $_POST["correo"] : "triplelmejiapoot@gm";
$opcion = isset($_POST["opcion"]) ? $_POST["opcion"] : "reset";

// print_r($correo);
// print_r($opcion);
$con = new conexion();
$conexion = $con->conectar();
switch ($opcion) {


	case 'recuperar':
	$resultado = array();
	$sql = "SELECT COUNT(*) AS EXISTE FROM USUARIOS WHERE EMAIL = '$correo'";
	$usuario = ibase_query($conexion,$sql);
	$resul  = ibase_fetch_assoc($usuario);
	$existe = $resul["EXISTE"];
	$data ="";

	if ($existe === 0) {
		$resultado =["status" => "no_existe", "mensaje" => "El email no coincide con ningun usuario"];
		echo json_encode($resultado);
		exit;
	}else{
		$sql = "SELECT * FROM USUARIOS WHERE EMAIL = '$correo'";
		$usuario = ibase_query($conexion,$sql);
		$data  = ibase_fetch_assoc($usuario);

	}
	$random = rand(0, 1000)."".rand(0, 1000)."".rand(0, 1000);
	$extra = $data["RECOVER_PASS"]."".$random;

	$link_pass = 'http://gpopol.dyndns.biz:8888/gpopol/general/contrasenia.php?clave='.md5($data["RECOVER_PASS"]).'&rp='.md5($extra).'&id='.$data["IDUSUARIO"];

	require_once ('../../PHPMailer/src/PHPMailer.php');
	require("../../PHPMailer/src/SMTP.php");
	require("../../PHPMailer/src/Exception.php");

	$texto = '
	<div style=" width:100%; height:auto;" align="center">
	<div style="width:600px; height:auto; padding-top:20px; padding-bottom:20px">
	<div style="width:100%; text-align:center; padding-top:10px;">
	<a href="http://poligas.com.mx/"><img src="http://gpopol.dyndns.biz:8888/gpopol/imagenes/img_correo.jpg" width="600" height="135" alt="POLIGAS"></a>
	<br><br>
	<span style="font-size: 18px;  color: #6c6c6c; font-family: Helvetica, Tahoma, Helvetica, sans-serif;">Hola '.htmlentities($data["NOMBRE"]).' tenemos una solicitud de <strong>&quot;contraseña olvidada&quot;</strong> para tu cuenta. Si no reconoce esta solicitud, simplemente puede ignorar este mensaje, su cuenta sigue siendo segura.</span>
	<br><br>
	<span style="font-size: 18px;  color: #6c6c6c; font-family: Helvetica, Tahoma, Helvetica, sans-serif;">Para cambiar su contraseña por favor de click <a href="'.$link_pass.'" style="color:#32790F;"><strong>aqu&iacute;</strong></a>.</span>
	<br><br>
	<span style="font-size: 16px;  color: #6c6c6c; font-family: Helvetica, Tahoma, Helvetica, sans-serif;">Si no puedes acceder a este enlace, comunicarse con el departamento de sistemas:<br><a href=""  style="font-size: 16px;  color: #6c6c6c; font-family: Helvetica, Tahoma, Helvetica, sans-serif;"></a></span>
	</div>
	<div style="height:30px"></div>
	<div style="height:1px; width:600px; background-color:#cfcfcf"></div>
	<div style="height:30px"></div>

	<div style="height:20px"></div>
	<div style="text-align:justify">
	<span style="font-size: 12px;  color: #a9a9a9; font-family: Helvetica, Tahoma, Helvetica, sans-serif;">&copy; '.date('Y').' .</span>
	</div>
	</div>
	';
//<img src="https://github.com/PoliDesarrollo/imagenes/blob/master/logo_normal.png" width="600" height="90" alt="Lendik">
	$mail = new PHPMailer\PHPMailer\PHPMailer();
	$mail->IsSMTP();
	$mail->CharSet = "UTF-8";
	$mail->Host       = "poligas.com.mx";
	$mail->SMTPDebug  = 0;
	$mail->SMTPAuth   = true;
	$mail->Port       = 587;
	$mail->Username   = "asistente.ti@poligas.com.mx";
	$mail->Password   = "Poligas#2018";
	$mail->setFrom("asistente.ti@poligas.com.mx", 'POLIGAS');
	$mail->addAddress($correo, "Usuario poligas web");
	$mail->Subject = "Solicitud de recuperación de contraseña - POLIGAS";

	$mail->msgHTML(stripslashes($texto));

	if (!$mail->send())
	{
					//echo "Mailer Error: " . $mail->ErrorInfo;
		$resultado =["status" => "error", "mensaje" => "Hubo un error al enviar el correo"];
		echo  json_encode($resultado);
		exit;

	} else {

		$resultado =["status" => "success", "mensaje" => "El correo a sido enviado para la restauracion de su contraseña"];
		echo json_encode($resultado);
		exit;
	}




	break;
	case 'reset':
	$resultado = array();
	$dato  = explode("||", $datos);
	$recover_pass = $dato[0];
	$id = $dato[1];
	(int)$id;
	$select  = "SELECT * FROM USUARIOS WHERE IDUSUARIO = '$id'";
	$execute = ibase_query($conexion,$select);
	$usuario =ibase_fetch_assoc($execute);
	$recover_bd = $usuario["RECOVER_PASS"];

	try {
		if ($recover_pass == md5($recover_bd)) {
			$passIncri = password_hash($password , PASSWORD_BCRYPT);
			$random = rand(0, 1000)."".rand(0, 1000)."".rand(0, 1000);
			$new_recover = $usuario["USUARIO"]."".$random;
			$recover_md5= md5($new_recover);
			$sql = "UPDATE USUARIOS  SET PASSWORD = '$passIncri' , RECOVER_PASS = '$recover_md5' WHERE IDUSUARIO = '$id'";
			$upd_exe = ibase_query($conexion,$sql);
			if ($upd_exe > 0) {
				$resultado=["status" => "success", "mensaje" => "contraseña restaurada"];
				echo json_encode($resultado);
			}else{
				$resultado=["status" => "error", "mensaje" => "Problemas al restaurar la contraseña"];
				echo json_encode($resultado);
			}
		}else{
			$resultado=["status" => "error", "mensaje" => "Este enlace ha expirado"];
			echo json_encode($resultado);
		}
	} catch (Exception $e) {
		$resultado=["status" => "error", "mensaje" => "Problemas al restaurar la contraseña"];
		echo json_encode($resultado);
	}
	break;
}




?>