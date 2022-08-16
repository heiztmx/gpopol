<?php 



header('Content-Type: application/json'); 
$outData = upload(); 

echo json_encode($outData); 
exit(); 

function upload() {
	$preview = $config = $errors = [];
	$input = 'file-es'; 
  	$noclie  = $_POST["noclie"];
  	$nombre  = $_POST["nombre"];
  	$tipo_cliente = $_POST["tipo_cliente"];
  	// print_r($noclie);
	if (empty($_FILES[$input])) {
		return [];
	}
	$total = count($_FILES[$input]['name']); 
	$carpeta = $noclie."-".$nombre;

	if (!file_exists("../../../uploads/".$carpeta)) {
		mkdir("../../../uploads/".$carpeta,0777,true);
	}
	$path = '../../../uploads/'.$carpeta; 
	for ($i = 0; $i < $total; $i++) {

		$tmpFilePath = $_FILES[$input]['tmp_name'][$i]; 
		$fileName = $_FILES[$input]['name'][$i];
		$fileSize = $_FILES[$input]['size'][$i]; 



		if ($tmpFilePath != ""){

			$newFilePath = $path."/".$fileName;
			$newFileUrl = 'http://localhost:8888/gpopol/uploads/'.$carpeta."/". $fileName;

			if (file_exists("../../../uploads/".$carpeta)) {
				$movido =  move_uploaded_file($tmpFilePath, $newFilePath);
			}else{
				return [];

			}
			
			if($movido) {
				// $nombrefile = $_FILES[$input]['tmp_name'][$i];

				$fileId = $fileName . $i; 
				$preview[] = $newFileUrl;
				
				$config[] = [
					'key' => $fileId,
					'caption' => $fileName,
					'size' => $fileSize,
					'downloadUrl' => $newFileUrl, 
					'url' => 'http://localhost/gpopol/uploads/delete.php',
				];
			} else {
				$errors[] = $fileName;
			}
		} else {
			$errors[] = $fileName;
		}
	}
	$out = ['initialPreview' => $preview, 'initialPreviewConfig' => $config, 'initialPreviewAsData' => true];
	if (!empty($errors)) {
		$img = count($errors) === 1 ? 'file "' . $error[0]  . '" ' : 'files: "' . implode('", "', $errors) . '" ';
		$out['error'] = 'Oh snap! We could not upload the ' . $img . 'now. Please try again later.';
	}
	// print_r($out);
	return $out;
}
?>