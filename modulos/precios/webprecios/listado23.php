<?php 
session_start();
if(isset($_SESSION['user']) &&  $_SESSION['logeado']== true){




 ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<!-- 	LINKS DE JQUERY UI -->


 
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Listado de Precios</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
	<link rel="stylesheet" href="../css/normalize.css">
	<link rel="stylesheet" href="../css/styleprecios.css">
	<!-- <link rel="stylesheet" href="css/styleprecios2.css"> -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Gugi" rel="stylesheet">

	<link rel="stylesheet" href="../css/stylelistado.css">

<script src="../javascript/jquery-3.3.1.min.js"></script>
<!-- <script src="../js/irmodificar.js"></script> -->
<script>
	 $(document).ready(function(){
	$(function () {
        $(".menu-anclas").click(function (e) {
            e.preventDefault();
            var ancla = $(this).attr("href");
            $('html,body').animate({
                scrollTop: $(ancla).offset().top
            }, 400);
            // $('#menu').find('ul').toggleClass('open-menu');
        });
    });
});

	  function pasarVariables(folio) {
   
  var pagina ="frmModificar-precios.php?folio=";
  // pagina +="?folio=";
 pagina += folio;
  location.href=pagina;
}

</script>

</head>


<body>
 <!--  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script>
  $( function() {
   $("#accordion").accordion();
  } );
</script> -->

<!-- <script src="../javascript/jquery-3.3.1.min.js"></script> -->


<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
  integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
  crossorigin="anonymous">




	


	 $( function() {
    $( "#accordion" ).accordion({
    	// 'header':'h3',
    	// 'fillspace':true,
    	// 'active':1
    });
  } );
</script>

	 <?php
	 include 'metodosweb.php';
		include 'elegir-encabezado.php';
		$x = new  encabezados();
		$enca = $x->elegir_enca();


	 ?>

		<h1 class="h1">Precios Por Estacion</h1>

		<script src="../js/ocultar-estaciones.js"></script>
		<div id="menu-anclas1">
			<a id="side">Siderurgica</a>
			<a id="uman" >Uman</a>
			<a id="san-pedro">San Pedro</a>
			<a id="poli">Poliforum</a>
		<!-- href="#poliforum" 	class="menu-anclas" -->

		</div>
		<!-- tabla -->
		<table id="tabla1"><a id="siderurgica"></a>
		<tr id="titulo">

		<th colspan="8" id="h3">
			<figure><img src="../imagenes/SINFONDO/siderurgica.png" alt=""></figure>
			<h3>Estación de Servicio Siderúrgica, S.A. de C.V.</h3>
		</th>
		</tr> 
		<tr id="nombres">
			
									<td id="td">FOLIO</td>
									<td id="td">FECHA</td>
									<td id="td">HORA</td>	
									<td id="td">MAGNA</td>
									<td id="td">PREMIUM</td>
									<td id="td">DIESEL</td>
									<td id="td">APLICADO</td>
									<td id="td">USUARIO</td>
		</tr>
<?php 
 $metodos = new metodosweb();
 $met = $metodos->porEstacion(10,'SIDE');

while ($row =ibase_fetch_object($met)) {
	$datosSide = $row->FOLIO."||".
				$row->FECHA."||".
				$row->HORA."||".
				$row->MAGNA."||".
				$row->PREMIUM."||".
				$row->DIESEL."||".
				$row->APLICADO."||".
				$row->USUARIO;

  ?>
	
			<tr id="cajas">
			<td><input type="text"  readonly value="<?php echo $row->FOLIO; ?>"></td>
				<td><input type="text"  readonly value="<?php echo $row->FECHA;?>"></td>
				<td><input type="text"  readonly value="<?php echo $row->HORA; ?>"></td>
				<td><input class="letra" type="text" value="<?php print number_format($row->MAGNA,2,'.',','); ?>" readonly></td>
				<td><input class="letra" type="text" value="<?php print number_format($row->PREMIUM,2,'.',','); ?>" readonly></td>
				<td><input class="letra" type="text" value="<?php print number_format($row->DIESEL,2,'.',','); ?>" readonly ></td>
				<td><input type="text"  readonly value="<?php echo $row->APLICADO; ?>"></td>
				<td><input type="text"  readonly value="<?php echo $row->USUARIO; ?>"></td>
				<!-- <td><a onclick="irmodificar('<?php //echo $datosSide; ?>')" class="op"><i class="fas fa-pencil-alt"></i></a></td> -->
				 <td><button style="border :0px; background-color:white"><a style="border :0px;" href="frmModificar-precios.php?folio=<?php echo $row->FOLIO ?>"><i class="fas fa-pencil-alt"></i></a></button></td>
				<!--
				<td><button><a  href="eliminarPreciosxEstacion.php?folio=<?php //echo $row->FOLIO ?>" onclick="return confirm('Seguro de querer borrar el registro?');">
			<i class="fas fa-trash"></i></a></button></td> -->
					</tr>
				
						<?php 
}
				 ?>

</table>
				

			
				
				
				
		
			


	
	
			<!-- tabla -->
		<table id="tabla2"><a id="uman"></a>
		<tr id="titulo">

		<th colspan="8" id="h3">
			<figure><img  src="../imagenes/SINFONDO/uman.png" alt=""></figure>
			<h3>Servicio Industrial Umán S.A de C.V. </h3>
		</th>
		</tr> 
		<tr id="nombres">
			
									<td id="td">Folio</td>
									<td id="td">Fecha</td>
									<td id="td">Hora</td>	
									<td id="td">Magna</td>
									<td id="td">Premium</td>
									<td id="td">Diesel</td>
									<td id="td">Aplicado</td>
									<td id="td">Usuario</td>
		</tr>
					<?php 
 $metodos = new metodosweb();
 $met = $metodos->porEstacion(10,'UMAN');

while ($row =ibase_fetch_object($met)) {
		$datosUman = $row->FOLIO."||".
				$row->FECHA."||".
				$row->HORA."||".
				$row->MAGNA."||".
				$row->PREMIUM."||".
				$row->DIESEL."||".
				$row->APLICADO."||".
				$row->USUARIO;

  ?>
					<tr id="cajas">
			<td><input type="text"  readonly value="<?php echo $row->FOLIO; ?>"></td>
				<td><input type="text"  readonly value="<?php echo $row->FECHA;?>"></td>
				<td><input type="text"  readonly value="<?php echo $row->HORA; ?>"></td>
				<td><input class="letra" type="text" value="<?php print number_format($row->MAGNA,2,'.',','); ?>" readonly></td>
				<td><input class="letra" type="text" value="<?php print number_format($row->PREMIUM,2,'.',','); ?>" readonly></td>
				<td><input class="letra" type="text" value="<?php print number_format($row->DIESEL,2,'.',','); ?>" readonly ></td>
				<td><input type="text"  readonly value="<?php echo $row->APLICADO; ?>"></td>
				<td><input type="text"  readonly value="<?php echo $row->USUARIO; ?>"></td>
				<!-- <td><a onclick="irmodificar('<?php //echo $datosUman; ?>')" class="op"><i class="fas fa-pencil-alt"></i></a></td> -->
				 <td><button style="border :0px; background-color:white"><a style="border :0px;" href="frmModificar-precios.php?folio=<?php echo $row->FOLIO ?>"><i class="fas fa-pencil-alt"></i></a></button></td>
				
				<!-- <td><button><a  href="eliminarPreciosxEstacion.php?folio=<?php// echo $row->FOLIO ?>" onclick="return confirm('Seguro de querer borrar el registro?');">
			<i class="fas fa-trash"></i></a></button></td>  -->					</tr>


						<?php 
}
				 ?>

				</table>
				
				
				
				
				
				
			<!-- 
				</div>

				</div> -->

		<!-- tabla -->
		<table id="tabla3"><a id="san-pedro"></a>
		<tr id="titulo">

		<th colspan="8" id="h3">
			<figure><img  src="../imagenes/SINFONDO/PER.png" alt=""></figure>
			<h3>Servicio Perioriente, S.A. de C.V. </h3>
		</th>
		</tr> 
		<tr id="nombres">
			
									<td id="td">Folio</td>
									<td id="td">Fecha</td>
									<td id="td">Hora</td>	
									<td id="td">Magna</td>
									<td id="td">Premium</td>
									<td id="td">Diesel</td>
									<td id="td">Aplicado</td>
									<td id="td">Usuario</td>
		</tr>
					<?php 
 $metodos = new metodosweb();
 $met = $metodos->porEstacion(10,'PERI');

while ($row =ibase_fetch_object($met)) {
	$datosPeri = $row->FOLIO."||".
				$row->FECHA."||".
				$row->HORA."||".
				$row->MAGNA."||".
				$row->PREMIUM."||".
				$row->DIESEL."||".
				$row->APLICADO."||".
				$row->USUARIO;

  ?>
					<tr id="cajas">
			<td><input type="text"  readonly value="<?php echo $row->FOLIO; ?>"></td>
				<td><input type="text"  readonly value="<?php echo $row->FECHA;?>"></td>
				<td><input type="text"  readonly value="<?php echo $row->HORA; ?>"></td>
				<td><input class="letra" type="text" value="<?php print number_format($row->MAGNA,2,'.',','); ?>"readonly></td>
				<td><input class="letra" type="text" value="<?php print number_format($row->PREMIUM,2,'.',','); ?>"readonly></td>
				<td><input class="letra" type="text" value="<?php print number_format($row->DIESEL,2,'.',','); ?>"readonly ></td>
				<td><input type="text"  readonly value="<?php echo $row->APLICADO; ?>"></td>
				<td><input type="text"  readonly value="<?php echo $row->USUARIO; ?>"></td>
				<!-- <td><a onclick="irmodificar('<?php //echo $datosPeri; ?>')" class="op"><i class="fas fa-pencil-alt"></i></a></td> -->
			 <td><button style="border :0px; background-color:white"><a style="border :0px;" href="frmModificar-precios.php?folio=<?php echo $row->FOLIO ?>"><i class="fas fa-pencil-alt"></i></a></button></td>
				
				<!--<td><button><a  href="eliminarPreciosxEstacion.php?folio=<?php //echo $row->FOLIO ?>" onclick="return confirm('Seguro de querer borrar el registro?');">
			<i class="fas fa-trash"></i></a></button></td> -->
					</tr>
										<?php 
}
				 ?>

				</table>
				
				
				
				
				
				
			
				<!-- </div>

				</div> -->

					<!-- tabla1 -->
				<table id="tabla4"> <a id="poliforum"></a>
		<tr id="titulo">

		<th colspan="8" id="h3">
			<figure><img  src="../imagenes/SINFONDO/poliforum.png" alt=""></figure>
			<h3>Combustibles y Lubricantes Poliforum, SA de CV. </h3>
		</th>
		</tr> 
		<tr id="nombres">
			
									<td id="td">Folio</td>
									<td id="td">Fecha</td>
									<td id="td">Hora</td>	
									<td id="td">Magna</td>
									<td id="td">Premium</td>
									<td id="td">Diesel</td>
									<td id="td">Aplicado</td>
									<td id="td">Usuario</td>
		</tr>
										<?php 
 $metodos = new metodosweb();
 $met = $metodos->porEstacion(10,'POLI');

while ($row =ibase_fetch_object($met)) {
	$datosPoli = $row->FOLIO."||".
				$row->FECHA."||".
				$row->HORA."||".
				$row->MAGNA."||".
				$row->PREMIUM."||".
				$row->DIESEL."||".
				$row->APLICADO."||".
				$row->USUARIO;


  ?>		
  			<tr id="cajas">
			<td><input type="text"  readonly value="<?php echo $row->FOLIO; ?>"></td>
				<td><input type="text"  readonly value="<?php echo $row->FECHA;?>"></td>
				<td><input type="text"  readonly value="<?php echo $row->HORA; ?>"></td>
				<td><input class="letra" type="text" value="<?php print number_format($row->MAGNA,2,'.',','); ?>" readonly></td>
				<td><input class="letra" type="text" value="<?php print number_format($row->PREMIUM,2,'.',','); ?>" readonly></td>
				<td><input class="letra" type="text" value="<?php print number_format($row->DIESEL,2,'.',','); ?>"readonly ></td>
				<td><input type="text"  readonly value="<?php echo $row->APLICADO; ?>"></td>
				<td><input type="text"  readonly value="<?php echo $row->USUARIO; ?>"></td>
				<!-- <td><a onclick="irmodificar('<?php //echo $datosPoli; ?>')" class="op"><i class="fas fa-pencil-alt"></i></a></td> -->
				 <td><button style="border :0px; background-color:white"><a style="border :0px;" href="frmModificar-precios.php?folio=<?php echo $row->FOLIO ?>"><i class="fas fa-pencil-alt"></i></a></button></td>
				
				<!--<td><button><a  href="eliminarPreciosxEstacion.php?folio=<?php //echo $row->FOLIO; ?>" onclick="return confirm('Seguro de querer borrar el registro?');">
			<i class="fas fa-trash"></i></a></button></td> -->
					</tr>
										<?php 
}
				 ?>

				</table>
				
				
				
				
				
				
			<!-- 
			</div>

				</div> -->
	</div>





	</form>
	</div> 
<!-- <footer>
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente in nihil at minima laboriosam laborum nesciunt rem odio tempora officiis, impedit deserunt voluptates, inventore aliquam! Obcaecati qui laborum, dicta asperiores? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Incidunt perspiciatis nihil animi temporibus dolor eligendi molestiae, a obcaecati veniam quos fugit ex voluptatibus dolorem rerum, assumenda natus at optio dolorum!</p>
</footer> -->
</body>



</html>

<?php 
} else {
	header("location:../index.php");
}

 ?>