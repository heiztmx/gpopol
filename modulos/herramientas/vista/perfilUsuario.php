<?php 
session_start();
if(isset($_SESSION['user']) &&  $_SESSION['logeado'] == true){

   
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Informacion de usuario</title>
	<link rel="stylesheet" href="../bootstrapcss/estiloPerfil.css">
	
<!-- 		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<script src="../javascript/jquery-3.3.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
<script src="../sweetAlert2/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="../sweetAlert2/dist/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
	
</head>
<body>
	<br>
	<br>
	<br>
	<br>
	<br>
	
	<h4 style="text-align: center; position: relative; top: -25px;">Perfil de usuario</h4>
	<?php 
	include '../menu/menu2.php';
	// include '../webprecios/metodosweb.php';
	
		$objeto = new metodosweb();
		$usuario =$objeto->perfilUsuario($_SESSION["user"]);
		$user = ibase_fetch_assoc($usuario);
	 ?>
	
	
	 
	<div class=" container mx-auto m-4 d-flex flex-wrap" style="">
			<div class="  d-flex flex-column col-lg-6" style="">
				<div class="form-group  d-flex flex-wrap">
				    <label for="inputEmail3" class="col-sm-2 col-form-label">Nombre</label>
				    <div class="col-lg-10">
				      <input type="email" class="form-control col-lg-10" id="nombreperfil" placeholder="Email" value="<?php echo $user["NOMBRE"]; ?>" disabled="">
				    </div>
				</div>	
			
				<div class="form-group  d-flex flex-wrap">
				    <label for="inputEmail3" class="col-sm-2 col-form-label">Usuario</label>
				    <div class="col-lg-10">
				      <input type="email" class="form-control col-lg-10" id="usuarioperfil" placeholder="Email" value="<?php echo $user["USUARIO"]  ?>" disabled="">
				    </div>
				</div>
			</div>

			<div  class="d-flex flex-column col-lg-6">
				<div class="form-group  d-flex flex-wrap">
				    <label for="inputEmail3" class="col-sm-2 col-form-label">Password</label>
				    <div class="col-lg-10">
				      <input type="password" class="form-control col-lg-10" id="passwperfil" placeholder="Email" value="<?php echo $user["PASSWORD"] ?>"  disabled="">
				    </div>
				</div>
				<div class="form-group  d-flex flex-wrap">
				    <label for="inputEmail3" class="col-sm-2 col-form-label">Fecha</label>
				    <div class="col-lg-10">
				      <input type="email" class="form-control col-lg-10" id="fechaPerfil" placeholder="Email" value="<?php echo $user["FECHA"] ?>" disabled="">
				    </div>
				</div>
			</div>


	</div>
	<h6 style="text-align: center; font-weight: bold;">Tabla de permisos recibidos</h6>
	<div class="container d-flex flex-wrap table-responsive-sm table-responsive-md">

		<table class="table table-hover">
			 
			 <thead class="thead-dark">
			 	<tr class="">
			 		<th scope="col" class="tpermisos colorLetra">Modulo1</th>
			 		<th scope="col" class="tpermisos colorLetra">Modulo2</th>
			 		<th scope="col" class="tpermisos colorLetra">Modulo3</th>
			 		<th scope="col" class="tpermisos colorLetra">Modulo4</th>
			 	</tr>
			 </thead>
			 <tbody>
			 	<tr>
	<?php 
   		for ($i=1; $i <=4; $i++) { 
   			if($user["MODULO".$i] == "Modulo".$i."1"){
   				echo " <td class='tpermisos' >A</td>";

   			}elseif ($user["MODULO".$i] == "Modulo".$i."2") {
   				echo " <td class='tpermisos' >O</td>";
   			}elseif ($user["MODULO".$i] == "Modulo".$i."3") {
   				echo " <td class='tpermisos' >C</td>";
   			}else{
   				echo " <td class='tpermisos' >-</td>";
   			}
   		}
   		 ?>
			 	</tr>
			 </tbody>
		</table>
	</div>

</body>
</html>

<?php 
} else {
    header('location:../index.php');
}
?>