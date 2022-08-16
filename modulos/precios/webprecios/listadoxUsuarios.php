 
<?php 
 session_start();
   

if(isset($_SESSION['user']) &&  $_SESSION['logeado']== true){




 ?> 
	<meta charset="UTF-8">
	<title>Listado de Usuarios</title>
	<link rel="stylesheet" href="../css/normalize.css">
	<link rel="stylesheet" href="../css/styleprecios.css">
	<link rel="stylesheet" href="../css/styleListadoUsuarios.css">
	<link rel="stylesheet" href="../css/stylemodificarUser.css">
	<link rel="stylesheet" href="../cssmovil/movilUser.css">
	<link rel="stylesheet" href="../cssmovil/movilModificarUser.css">

	<link href="https://fonts.googleapis.com/css?family=Gugi|Roboto+Condensed" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Patua+One|Teko" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Russo+One" rel="stylesheet">
	<link rel="stylesheet" href="../alertifyjs/css/alertify.css">
	<link rel="stylesheet" href="../alertifyjs/css/themes/default.css">
	<script src="../alertifyjs/alertify.js"></script>
	<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="../js/mobiscroll-1.5.1.js" type="text/javascript"></script>
	<script src="../js/modUserJs.js"></script>
	<!-- --------------SweetAlert no las borren es un pedo despues :v ------------------- -->
<script src="../javascript/jquery-3.3.1.min.js"></script>
<link href="../sweetalert-master/src/sweetalert.css" type="text/css">
<script src="../sweetalert-master/docs/assets/sweetalert/sweetalert.min.js"></script>


</head>

<body>
	<?php 
	include 'metodosweb.php';
	include 'elegir-encabezado.php';
	include '../modals/modal-BUs.php';
	$x = new  encabezados();
	$enca = $x->elegir_enca();
	$met = new metodosweb();
	$metodo =$met->traerUsuarios()
	
	 ?>
	<h2 style="margin-top: 80px; font-family:'Roboto Condensed', sans-serif; margin-left: 15px;">Lista de Usuarios Registrados</h2>
	<a class="enlace" href="#modal3">Nuevo Usuario</a>
	<table id="tabla-conte">
	
		<tr>
			<th style="text-align: center; color: black;" colspan="5">
				<h3 class="titulo-tabla" >USUARIOS </h3>
			</th>
		</tr>
		<tr id="titulo">
			<td class="columnas">IDUSUARIO</td>
			<td class="columnas">NOMBRE</td>
			<td class="columnas">USUARIO</td>
			<td class="columnas">PRIVILEGIO</td>
			<td class="columnas" style="display: none;">PASSWORD</td>
			<td class="columnas">AUTORIZO</td>
			<!-- <td>PASSWORD</td> -->
		</tr>
		
	<?php while ($row =ibase_fetch_object($metodo)) { 
			$datos=$row->IDUSUARIO."||".
			$row->NOMBRE."||".
			$row->USUARIO."||".
			$row->PRIVILEGIO."||".
			$row->PASSWORD."||".
			$row->AUTORIZO;


		?>
		<tr id="cajas">

			<td id="idusuarioUS" ><input type="text" class="cajausuario" value="<?php echo $row->IDUSUARIO; ?>" readonly="">
				</td>
			<td id="nombreUS" > <input type="text"  class="cajausuario " value="<?php echo $row->NOMBRE; ?>" readonly=""></td>
		
			<td id="usuarioUS"  > <input type="text" class="cajausuario" value="<?php echo $row->USUARIO; ?>" readonly=""></td>
			
			<td id="privilegioUS"> <input type="text"  class="cajausuario" value="<?php echo $row->PRIVILEGIO; ?>"readonly="" ></td>
			
			<td style="display: none;" id="passwordUS" ><input type="text" class="cajausuario" value="<?php echo $row->PASSWORD; ?>" readonly=""></td>
		
			<td id="autorizoUS" >  <input type="text" class="cajausuario" value="<?php echo $row->AUTORIZO; ?>" readonly=""></td>

	<td ><a style="text-decoration: none; color: black; padding: 10px;" href="#modificarUsuario" id="modificarUser" onclick="obtenerDatos('<?php echo $datos; ?>');"><i class="fas fa-pencil-alt"></i></a></td>
	
<td><a style="color:black; text-decoration: none;"   onclick="obtenerDatosEliminar('<?php echo $datos; ?>')">
			<i class="fas fa-trash"></i></a></td>


			
		</tr>
	<?php } ?>
	</table>

	<?php include '../modals/modificarUser-modal.php'; ?>
<script src="../js/guardarUsuarioAjax.js"></script>
	<!-- ----------------modal---------------------- -->
	<div id="modal3" class="modalmask">
    <div class="modalbox resize">
        <a href="#close" title="Close" class="close">X</a>
     <form id="formulariousu" name="formulariousu" method="POST">
	<h2>Registro de Usuarios Nuevos</h2>
			<h3>Tipo de usuario:</h3>
			<div id="privilegios">
			 <label class="tipos" for="">
				<input  type="radio" id="priv1" name="privilegio" value="0" class="radios" >Consulta
			</label>

			<label class="tipos" for="">
				<input  type="radio" id="priv2" name="privilegio" value="2" class="radios" >Operador
			</label>

			<label class="tipos" for="">
				<input  type="radio" id="priv3" name="privilegio" value="1"  class="radios">Administrador
			</label>
		
	</div>
		<p id="respUsuariov" style="color: #008558; text-align: center; font-weight: bold"></p>
		<p id="respUsuariox" style="color: red; text-align: center;"></p>

		<div id="informacionUsuario">
			
			<div class="datos">
				<input class="contenedor " type="text" name="usuario" placeholder="Usuario" id="usuariomodal" >
			</div>
				<div class="datos">
				<input class="contenedor "  type="password" name="password" placeholder="Password" id="passwordmodal" >
			</div>
				<div class="datos">
				<input class="contenedor " type="text" name="nombre" placeholder="Nombre completo" id="nombremodal" >
			</div>
		</div>

		<div id="botonesUsurio">
			<input type="submit" value="Guardar" class="botonUsuario" id="aceptarUsuario">

		</div>

	</form>  
    </div>
</div>
</body>
</html>
<?php 
} else {
header("location:../index.php");
}

 ?> 