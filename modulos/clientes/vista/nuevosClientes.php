<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Clientes</title>
</head>
<?php 
// $rfc = $_GET["rfc"]
?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.0/css/all.css" integrity="sha384-aOkxzJ5uQz7WBObEZcHvV5JvRW3TUc2rNPA7pe3AwnsUohiw1Vj2Rgx2KSOkF5+h" crossorigin="anonymous">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8 " />
<link rel="stylesheet" href="../../../bootstrapcss/clientes.css">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<body>
<script>
	function fileValidation(){
    var fileInput = document.getElementById('file');
    var filePath = fileInput.value;
    var allowedExtensions = /(.jpg|.jpeg|.png|.gif|.pdf)$/i;
    if(!allowedExtensions.exec(filePath)){
        alert('Please upload file having extensions .jpeg/.jpg/.png/.gif only.');
        fileInput.value = '';
        return false;
    }else{
        //Image preview
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            var pdf = /(.pdf)$/i;
            reader.onload = function(e) {
               if (pdf.exec(filePath)) {
               	document.getElementById('imagePreview').innerHTML = '<i class="far fa-file-pdf  fa-3x"></i>';
               }else{
               	 document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'"/>';
               }
            };
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
}
</script>


<!-- File input field -->
<input type="file" id="file" onchange="return fileValidation()"/>

<!-- Image preview -->
<div id="imagePreview"></div>
</body>
</html>