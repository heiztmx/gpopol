<?php 

 
 include  '../metGASOLINERA/metodosGASOLINERA.php';

$nombre=isset($_POST["nombre"]) ? $_POST["nombre"] :"";

$objeto = new GASOLINERA();

$resultado = $objeto->buscadorTiempoRealContado($nombre);
print_r( " <table class='table table-hover mx-auto table-sm' id='myTable'>
				<thead>

					<tr style='background-color: #F7F7F9'>
						<th  id='estacion' class='letras'  style='text-align: left;font-weight: bold;  scope='col'>ID</th>
						<th  id='estacion' class='letras'  style='text-align: center;font-weight: bold;' scope='col'>Nombre</th>
						
					</tr>
				</thead>".$resultado."</table>");

 ?>