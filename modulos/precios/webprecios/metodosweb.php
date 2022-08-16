<?php 

include '../../../conexion.php';
include '../../../conexionGasproduccion.php';
// include '../../../ConexionADMON.php';

function activar($a,$b){ 
	$a= strtoupper($a);
	$b= strtoupper($b);
	return ($a==$b ? ' active' : ''); 
	}
 function activar_alt($a,$b){ 
	echo ($a==$b ? ' active' : ''); 
	}

class metodosweb 
{

	public function validar_existe($conexion,$tabla,$campo,$dato,$extra)
	{
		$existe = "SELECT COUNT(*) AS EXISTE FROM ".$tabla." WHERE ".$campo." = '$dato' ".$extra;

		$resul =ibase_query($conexion,$existe);
		$resultado = ibase_fetch_assoc($resul);
		return $resultado["EXISTE"];

	}
	public function traer_permiso_x_usuario_submenu($usuario,$modulo,$contenedor)
	{
		$c= new conexion();
		$conexion = $c->conectar();
		$usuario = ibase_query($conexion,"SELECT IDUSUARIO  FROM USUARIOS WHERE USUARIO = '$usuario'");
		$datos = ibase_fetch_assoc($usuario);
		$id_usuario = $datos["IDUSUARIO"];
		$agrupacion=array();
		$icono_menu_dropdown = "";
		$agrupacion_personalizada=array();
		$array_validar_crear_documento  = array();
		$permisos_usu=ibase_query($conexion,"SELECT * FROM PERMISOS_USUARIOS WHERE IDUSUARIO = '$id_usuario' AND MODULO = '$modulo' AND PERMISO != 'PERMISOS_DEL_UPDPRECIOS' ORDER BY  ORDENADO ASC");
		// print_r($permisos_usu);
		while ($permisos = ibase_fetch_assoc($permisos_usu)) {
			$per = $permisos["PERMISO"];
			$icono = $permisos["ICONO"];
			
			// if($per ==BORRARPRECIOS)
        if($permisos["TYPE_CASCADA"]  == "0") //icono loader
        {
// confirmarPC()

        	$url = $permisos["LINK_PERMISO"];
        	echo "  <li class='nav-item' >
        	<style>a:hover{color:white !important;} a{color:rgba(255,255,255,.5) !important;} </style> <a id='' title ='".$permisos["NOMBRE_PERMISO"]."'  class='nav-link   ".$icono." iconosSubmenu fa-lg  ' href='#' role='button' 
        	aria-haspopup='true' aria-expanded='false' onclick=loader_seccion('".$url."','".$contenedor."')></a>
        	</li>";


        	// $contenedor es el nombre del div donde se iran alojando las diferentes pantallas esto se hace con el loader de jquery


        }

      elseif($permisos["TYPE_CASCADA"] == "1"){ // cascada loader
      	$agrupacion[$per] = $permisos;
      	$icono_menu_dropdown = $permisos["ICONO"];

      }


      elseif($permisos["TYPE_CASCADA"] == "2"){ //icono con funcion 
      	$funcion_icono =$permisos["FUNCION"] ; 
      	$parametro_funcion=$permisos["PARAMETROS"];

      	// sirve para validar que no se repita el icno de crear requisicion y orden de compra
      	if ($permisos["PERMISO"] == "ADDREQUISICION" || $permisos["PERMISO"] =="ADDORDENCOM" || $permisos["PERMISO"] =="RECCUPON") {
      		
      		if (count($array_validar_crear_documento) == 0 ) {
      			echo " <li class='nav-item'>
      			<style>a:hover{color:white !important;} a{color:rgba(255,255,255,.5) !important;} </style> <a id='' title ='".$permisos["NOMBRE_PERMISO"]."'   class='nav-link   ".$icono." iconosSubmenu fa-lg  ".$parametro_funcion."' href='#' role='button' 
      			aria-haspopup='true' aria-expanded='false'  onclick=".$funcion_icono."('".$parametro_funcion."')> </a>
      			</li>";
      		}
      		array_push($array_validar_crear_documento, $permisos["PERMISO"]);
      	}

      	if ($permisos["PERMISO"] !=  "ADDREQUISICION" && $permisos["PERMISO"] !="ADDORDENCOM" && $permisos["PERMISO"] !="RECCUPON") {
      		
      	    /* if ($permisos["PERMISO"] ==  "RECCUPON") {
				$url = $permisos["LINK_PERMISO"];
      		echo " <li class='nav-item'>
      		<a id='' title ='".$permisos["NOMBRE_PERMISO"]."'   class='nav-link   ".$icono." iconosSubmenu fa-lg  ".$parametro_funcion."' href='#' role='button' 
      		aria-haspopup='true' aria-expanded='false'  onclick=loader_seccion('".$url."','".$contenedor."')> </a>
      		</li>";
      	     }else{*/
      		echo " <li class='nav-item'>
      		<style>a:hover{color:white !important;} a{color:rgba(255,255,255,.5) !important;} </style> <a id='' title ='".$permisos["NOMBRE_PERMISO"]."'   class='nav-link   ".$icono." iconosSubmenu fa-lg  ".$parametro_funcion."' href='#' role='button' 
      		aria-haspopup='true' aria-expanded='false'  onclick=".$funcion_icono."('".$parametro_funcion."')> </a>
      		</li>";
      		//}
      	}



      	

      	// print_r($parametro_funcion);


      	 // <div class="tooltip">Hover over me <span class="tooltiptext">Tooltip text</span> </div>
      	// echo " <li class='nav-item'>
      	// <a id='' title ='".$permisos["NOMBRE_PERMISO"]."'   class='nav-link   ".$icono." iconosSubmenu fa-lg  ".$parametro_funcion."' href='#' role='button' 
      	// aria-haspopup='true' aria-expanded='false'  onclick=".$funcion_icono."('".$parametro_funcion."')> </a>
      	// </li>";
      }



      elseif($permisos["TYPE_CASCADA"] == "3") // cascada con funcion 
      {
      	$agrupacion_personalizada[$per] = $permisos;
      	$icono_menu_dropdown = $permisos["ICONO"];
      }

  }




  if(count($agrupacion) > 0)
  {
  	
  	$submenu = "";
  	$submenu.=" <li class='nav-item dropdown'>
  	<a id='' class='nav-link dropdown-toggle ".$icono_menu_dropdown." fa-lg  iconosSubmenu ' data-toggle='dropdown' href='#' role='button' aria-haspopup='true' aria-expanded='false'></a> 
  	<div class='dropdown-menu'>";

  	foreach($agrupacion as $key=>$value) 
  	{ 
  		
  		
  		$nombre_permiso = $value["NOMBRE_PERMISO"];
  		$url = $value["LINK_PERMISO"];
  		$submenu.= "<a  onclick=loader_seccion('".$url."','".$contenedor."') class='dropdown-item' href='#'>". ucfirst(strtolower($nombre_permiso))."</a>";


  	}
  	echo $submenu."</div></li>"; 
  }






  if(count($agrupacion_personalizada) > 0)
  {
  	
  	$submenuper = "";
  	$submenuper.=" <li class='nav-item dropdown'>
  	<a id='' class='nav-link dropdown-toggle ".$icono_menu_dropdown." fa-lg  iconosSubmenu ' data-toggle='dropdown' href='#' role='button' aria-haspopup='true' aria-expanded='false'></a> 
  	<div class='dropdown-menu'>";

  	foreach($agrupacion_personalizada as $key=>$value1) 
  	{ 

  		
  		$nombre_permiso = $value["NOMBRE_PERMISO"];
  		$funcion=$value1["FUNCION"];
  		$url = $value1["LINK_PERMISO"];

  		if ($value1["PARAMETROS_FUNCION"] != "" ) {
  			$parametros= $value["PARAMETROS_FUNCION"];
  			$submenuper.= "<a  onclick=".$funcion."('".$parametros."') class='dropdown-item' href='#'>". ucfirst(strtolower($nombre_permiso))."</a>";
  		}else{
        	//en caso de no tener un parametro definido aunque se observa que lo espera es porque puede ser un 
        	//paramatro que se tiene que crear porque puede ser un select de la bd y que se tiene que pasar al js para se5r dinamico todo esto dependera de la situacion y el funcionamiento de la "funcion" que se desee hacer
  			$submenuper.= "<a  onclick=".$funcion."('') class='dropdown-item' href='#'>". ucfirst(strtolower($nombre_permiso))."</a>";
  		}



  	}
  	echo $submenuper."</div></li>"; 
  }


}
public function numero_registros($conexion,$tabla)
{
	$select123 = "SELECT COUNT(*) AS CANTIDAD FROM ".$tabla;
	$rows123 = ibase_query($conexion,$select123);
	$r123=ibase_fetch_assoc($rows123);
	$identificador123 = $r123["CANTIDAD"];
	return $identificador123;
}
public function existe_usuario($conexion,$tabla,$id_usuario)
{
	$select = "SELECT COUNT(*) AS EXISTE FROM ".$tabla." WHERE IDUSUARIO = ".$id_usuario;
	$row = ibase_query($conexion,$select);
	$r=ibase_fetch_assoc($row);
	$identificador = $r["EXISTE"];
	return $identificador;
}
public function permisos_especiales($conexion123,$id_usuario,$per_array,$modulo,$id_permiso,$movimiento)
{


	$identificador = $this->numero_registros($conexion123,"PERMISOS_ESPECIALES");
	
	$inputs =["peres_estacion","peres_elaboro","peres_estatus"];
	for ($i=0; $i <count($per_array) ; $i++) { 

		if ($per_array[$i] !== "xxx") {
			
			
			$permiso_separados = explode(",", $per_array[$i]);

			if ($movimiento  == "insertar") {
				for ($z=0; $z<count($permiso_separados) ; $z++) { 
					$identificador++;
					$trans123=ibase_trans("IBASE_WRITE",$conexion123);

					$query123 ="INSERT INTO PERMISOS_ESPECIALES(ID,IDUSUARIO,PERMISO_ESPECIAL,MODULO,PERMISO,INPUT) 
					VALUES ('$identificador','$id_usuario','$permiso_separados[$z]','$modulo','$id_permiso','$inputs[$i]');";
					$insert =ibase_query($trans123,$query123);
					$estado123= ibase_commit($trans123);

				}
			}
			if ($movimiento == "actualizar") {
				$borrar3="DELETE FROM PERMISOS_ESPECIALES WHERE IDUSUARIO = '$id_usuario'";
				$borrar_permisos3= ibase_query($conexion123,$borrar3);
				if ($borrar_permisos3 >0) {
					for ($z=0; $z<count($permiso_separados) ; $z++) { 
						$trans123=ibase_trans("IBASE_WRITE",$conexion123);

						$query123 ="INSERT INTO PERMISOS_ESPECIALES(ID,IDUSUARIO,PERMISO_ESPECIAL,MODULO,PERMISO,INPUT) 
						VALUES ('$identificador','$id_usuario','$permiso_separados[$z]','$modulo','$id_permiso','$inputs[$i]');";
						$insert =ibase_query($trans123,$query123);
						$estado123= ibase_commit($trans123);
					}
				}

			}

		}else{
			$this->eliminar_permisos_especiales($conexion123,$id_usuario,$id_permiso,$inputs[$i],$movimiento);
		}
	}

}
public function eliminar_permisos_especiales($conexion_local123,$id_usuario,$permiso,$input, $movimiento)
{
	if ($movimiento == "actualizar") {
		$borrar_vacios="DELETE FROM PERMISOS_ESPECIALES WHERE IDUSUARIO = '$id_usuario' AND PERMISO =  '$permiso'  AND INPUT = '$input'";
		$borrar_permisos3= ibase_query($conexion_local123,$borrar_vacios);
	}
}
public function permisos_del_upd($usuario,$modulo)
{
	$c= new conexion();
	$conexion = $c->conectar();
	$usuario = ibase_query($conexion, "SELECT FIRST(1) *  FROM USUARIOS  WHERE USUARIO = '$usuario'");
	$datos_usuario = ibase_fetch_assoc($usuario);
	$id_usuario = $datos_usuario["IDUSUARIO"];
	$permisos = ibase_query($conexion,"  SELECT COUNT(*) AS BORRAR_MODIFICAR FROM PERMISOS_USUARIOS  WHERE   substring(PERMISO from 1 for 16 )  = 'PERMISOS_DEL_UPD' AND MODULO = '$modulo' AND IDUSUARIO = '$id_usuario'");
	$permisos_existe = ibase_fetch_assoc($permisos);
	$find_permiso;
	if ($permisos_existe["BORRAR_MODIFICAR"] > 0) {
		$find_permiso = true;
	}else
	{
		$find_permiso = false;
	}
	return $find_permiso;
}
public function nombre_permiso($permiso)
{
	$c= new conexion();
	$conexion = $c->conectar();
	$permisos = ibase_query($conexion,"SELECT * FROM MODULOS");
	$array_nombres= array();
	while ($nombre = ibase_fetch_assoc($permisos)) {
		if($nombre["PERMISO_JS"] == $permiso){
			return $nombre["PERMISO_JS"];
			break;
		}
	}
	

}

public function VerificacionHora($hora,$fecha,$estacion)
{
	$c= new conexion();
	$conexion = $c->conectar();
	// $select="SELECT * ESTACION FROM PRECIOSGAS WHERE HORA = '$' AND  HORA = '$hora";
	$select="SELECT  ESTACION FROM PRECIOSGAS WHERE  FECHA = '$fecha'   AND HORA ='$hora' AND ESTACION = '$estacion'";
	$resultado = ibase_query($conexion,$select);

	$estaciones=ibase_fetch_assoc($resultado);

	if ($estaciones["ESTACION"] != "") {
		return "Existente";
		# code...
	}else{
		return "Adelante";
	}

}
public function ElegirPrivilegios($usuario)
{
	$c = new conexion();
	$conexion=$c->conectar();
	$resul = "SELECT  * FROM USUARIOS WHERE USUARIO ='$usuario'";
	$privilegios =ibase_query($conexion,$resul);
	return  $privilegios;
}
public function perfilUsuario($usuario)
{
	$c = new conexion();
	$conexion=$c->conectar();
	$resul = "SELECT * FROM USUARIOS WHERE USUARIO ='$usuario'";
	$privilegios =ibase_query($conexion,$resul);
	return  $privilegios;
}

public function traerNombre($user){
	$c=new conexion();
	$conexion = $c->conectar();
	$usuario ="SELECT NOMBRE  FROM USUARIOS WHERE USUARIO = '$user' ";
	$resuluser = ibase_query($conexion,$usuario);

	$row = ibase_fetch_assoc($resuluser);
	$nombre = $row['NOMBRE'];
	return $nombre;

}

public function tablaEstaciones(){
	$c=new conexion();
	$conexion = $c->conectar();
	$usuario ="SELECT *  FROM ESTACIONES ORDER BY ID ASC";
	$estaciones = ibase_query($conexion,$usuario);
	ibase_free_result($estaciones); 
	ibase_close($conexion);
	return $estaciones;
}

public function tablaEstaciones2($clave_suc_dep){
	$c=new conexion();
	$conexion = $c->conectar();
	$usuario ="SELECT *  FROM ESTACIONES where ID = '$clave_suc_dep' ORDER BY ID ASC";
	$estaciones = ibase_query($conexion,$usuario);
	ibase_free_result($estaciones); 
	ibase_close($conexion);
	return $estaciones;
}





public function opciones_Herramientas($usuario)
{
	$c= new conexion();
	$conexion = $c->conectar();
	// $usuario = ibase_query($conexion,"SELECT IDUSUARIO  FROM USUARIOS WHERE USUARIO = '$usuario'");
	// $datos = ibase_fetch_assoc($usuario);
	$id_usuario = $_SESSION["id"];
	$menu="";

	$permisos_herramientas=ibase_query($conexion,"SELECT * FROM PERMISOS_USUARIOS WHERE IDUSUARIO = '$id_usuario' AND MODULO = 'HERRAMIENTAS' ");
	$menu .= '<li class="nav-item dropdown">
	<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	Herramientas
	</a>
	<style>.dropdown-item:focus, .dropdown-item:hover{background-color:#ff0006 !important;}</style>
	<div class="dropdown-menu" aria-labelledby="navbarDropdown" style="background-color:#e22d2b !important;">';
	$cont=0;


	while ($herr = ibase_fetch_object($permisos_herramientas)) {
		$nombre_permiso =$herr->NOMBRE_PERMISO;
		$link =$herr->LINK_PERMISO;
		if ($herr->PERMISO == "BLOQLIQ") {
			$menu.= "<a class='dropdown-item' style='cursor:pointer' onclick='".$link."'>".ucfirst(strtolower($nombre_permiso))."</a>";
			
		}else{
			
			$menu.=  '<a class="dropdown-item" href="'.$link.'">'.ucfirst(strtolower($nombre_permiso)).'</a>';	
		}
		
		$cont++;
	}
	$menu.='
	</div></li>';
	ibase_free_result($permisos_herramientas);
	ibase_close($conexion);
	if ($cont > 0) {

		echo $menu;

	}
}

public function insertarPrecios($datos)
{

	$c= new conexion();
	$conexion = $c->conectar();

	$tr=ibase_trans("IBASE_WRITE",$conexion);
	$datos[0] = (int) $datos[0];
	$sql="INSERT INTO  PRECIOSGAS(FOLIO,FECHA,HORA,ESTACION,MAGNA,PREMIUM,DIESEL,APLICADO,USUARIO,IP) VALUES('$datos[0]','$datos[1]','$datos[2]','$datos[3]','$datos[4]','$datos[5]','$datos[6]','$datos[7]','$datos[8]','$datos[9]');";
	$veri=ibase_query($tr,$sql); 
	$estado=ibase_commit($tr);


	return $estado;

}



public function Buscador_General($fecha,$folio,$estacion,$opcion){
	$conexion = new conexion();
	$conexion =$conexion->conectar();
	switch ($opcion) {
		case 1:

		$resultado1 ="SELECT * FROM PRECIOSGAS WHERE  FOLIO = '$folio'";
		$resultado1 =ibase_query($resultado1);

		return $resultado1;
		break;

		case 2:

		$resultado2 = "SELECT * FROM PRECIOSGAS WHERE  ESTACION = '$estacion'";
		$resultado2 =ibase_query($resultado2);
		return $resultado2;
		break;

		case 3:

		$resultado3 = "SELECT * FROM PRECIOSGAS WHERE FECHA = '$fecha'";
		$resultado3 = ibase_query($resultado3);
		return $resultado3;
		break;

		case 4:

		$resultado4 ="SELECT  * FROM PRECIOSGAS WHERE FECHA = '$fecha' AND ESTACION = '$estacion'";
		$resultado4 =ibase_query($resultado4);
		return $resultado4;
		break;

		case 5:
		break;

		case 6:


		$resultado6 ="SELECT * FROM PRECIOGAS WHERE APLICADO = SI  AND FECHA = '$fecha'";
		$resultado6 =ibase_query($resultado6);
		return $resultado6;
		break;

		case 7:

		$resultado7 ="SELECT * FROM PRECIOSGAS  WHERE APLICADO = SI AND ESTACION = '$estacion'";
		$resultado7=ibase_query($resultado7);
		return $resultado7;


	}

}



public function agregarUsuarios($nombre,$usuario1,$passIncri,$modulo1,$modulo2, $modulo3,$modulo4,$aplico){

	$c= new conexion();
	$conexion = $c->conectar();

	$newuser="SELECT MAX(IDUSUARIO) FROM USUARIOS";
	$usuario=ibase_query($conexion,$newuser);
	$folio_pre =ibase_fetch_assoc($usuario);

	foreach ( $folio_pre as $max)
	{

		$cont = $max;
	}
	$id=$cont + 1;
	$id =(int)$id;
	$fecha=date("Y/m/d");

	$exisUser = "SELECT USUARIO FROM USUARIOS WHERE USUARIO = '$usuario1'";
	$resulU =ibase_query($conexion,$exisUser);
	$xx = ibase_fetch_assoc($resulU);

	if($xx["USUARIO"] == $usuario1){
		return "Existente";
	}else{

		$trans=ibase_trans("IBASE_WRITE",$conexion);
		$query ="INSERT INTO USUARIOS(IDUSUARIO,NOMBRE,USUARIO,PASSWORD,MODULO1,MODULO2,MODULO3,MODULO4,AUTORIZO,FECHA) 
		VALUES ('$id','$nombre','$usuario1','$passIncri','$modulo1','$modulo2','$modulo3','$modulo4','$aplico','$fecha');";	

		$veri=ibase_query($trans,$query);
		$estado= ibase_commit($trans);
		return $estado;
	}




}

public function traerDatos($id){
	$con=new conexion();
	$conexion=$con->conectar();
	$consulta="SELECT  FOLIO,FECHA,HORA,MAGNA,PREMIUM,DIESEL,ESTACION,IP FROM PRECIOSGAS WHERE FOLIO ='$id'";
	$resul =ibase_query($conexion,$consulta);

	return $resul;

}


public function modificarPrecios($newPrecios){

	$con= new conexion();
	$conexion =$con->conectar();

	$trans=ibase_trans("IBASE_WRITE",$conexion);
	$modif="UPDATE PRECIOSGAS 
	SET FECHA ='$newPrecios[0]',HORA ='$newPrecios[1]',MAGNA = '$newPrecios[2]',PREMIUM ='$newPrecios[3]',DIESEL='$newPrecios[4]',USUARIO= '$newPrecios[6]'  WHERE FOLIO = '$newPrecios[5]';";
	$veri=ibase_query($trans,$modif);
	$estado=ibase_commit($trans);
	return $veri;


}

public function modificarUsuarios($datosUser){
	$con= new conexion();
	$conexion=$con->conectar();
	$proc=ibase_trans("IBASE_WRITE",$conexion);
	$fecha=date("Y/m/d");

	if($datosUser[2] != ""){
		$modifUser="UPDATE USUARIOS
		SET NOMBRE='$datosUser[1]',PASSWORD='$datosUser[2]',MODULO1='$datosUser[3]',MODULO2='$datosUser[4]',MODULO3 ='$datosUser[5]',MODULO4='$datosUser[6]', AUTORIZO='$datosUser[7]',FECHA='$fecha' WHERE IDUSUARIO='$datosUser[0]';";
	}else{
		$modifUser="UPDATE USUARIOS
		SET NOMBRE='$datosUser[1]',MODULO1='$datosUser[3]',MODULO2='$datosUser[4]',MODULO3 ='$datosUser[5]',MODULO4='$datosUser[6]', AUTORIZO='$datosUser[7]',FECHA='$fecha' WHERE IDUSUARIO='$datosUser[0]';";
	}

	$accion=ibase_query($proc,$modifUser);
	$estado=ibase_commit($proc);
	return $accion;

}

public function eliminarPrecios($folio){

	$con= new conexion();
	$conexion = $con->conectar();

	$borrar ="DELETE FROM PRECIOSGAS WHERE FOLIO = '$folio';";
	$resul=ibase_query($conexion,$borrar);

	return $resul;


}

public function eliminar_usuario()
{
	$con= new conexion();
	$conexion = $con->conectar();
	$folio =  isset($_POST['idusuario']) ? $_POST['idusuario']  : "No hay folio";

	$folio=(int)$folio;
	$borrar ="DELETE FROM USUARIOS WHERE IDUSUARIO = '$idusuario';";
	$resul=ibase_query($conexion,$borrar);
	if ($resul ==1) {
		$borrar2="DELETE FROM PERMISOS_USUARIOS WHERE IDUSUARIO = '$idusuario";
		$borrar_permisos= ibase_query($conexion,$borrar2);
		if($borrar_permisos > 0){
			print_r("Eliminado");
		}
	} else {
		print_r($met);
	}

}

public	function consultaGeneral()

{
	$con=new conexion();
	$conexion= $con->conectar();

	$selec="SELECT FIRST(100) *  FROM PRECIOSGAS ORDER BY FECHA DESC , HORA DESC";
	$devol =ibase_query($conexion,$selec);

	return $devol;

}

public	function modulos()

{
	$con=new conexion();
	$conexion= $con->conectar();

	$selec="SELECT * FROM MODULOS";
	$modulos =ibase_query($conexion,$selec);
	$modulosArray =array();
	$modulosArray_js =array();
	$permisos =array();
	$todo = ibase_fetch_assoc($modulos);
	$cont=0;
	while ($mod = ibase_fetch_assoc($modulos)) {
			# code...

		if(!in_array($mod["NOMBRE"],$modulosArray))
		{
			$modulosArray[] = $mod["NOMBRE"];
		}

		if(!in_array($mod["NOMBRE_JS"],$modulosArray_js))
		{
			$modulosArray_js[] = $mod["NOMBRE_JS"];
		}

		array_push($permisos, $mod);	
		$cont++;


	}

	$arrays =["permisos" => $permisos, "modulos"=> $modulosArray,"modulos_js"=> $modulosArray_js];
	return $arrays;



}



public function ultimosDatos(){
	$con = new conexion();
	$conexion =$con->conectar();
	$si="SI";
	$selec="SELECT MAGNA,PREMIUM,DIESEL FROM preciosgas WHERE FECHA =
	(SELECT MAX(FECHA)
	FROM (SELECT  FIRST(10) *  FROM  PRECIOSGAS WHERE APLICADO = 'Si' ))";

	$precios =ibase_query($conexion,$selec);
	return $precios;
}

public function UltimoPrecio(){
	$con = new conexion();
	$conexion =$con->conectar();
	$si="SI";
	$selec="SELECT MAGNA,PREMIUM,DIESEL FROM preciosgas WHERE FOLIO =
	(SELECT MAX(FOLIO)
	FROM  PRECIOSGAS WHERE ESTACION  = 'Poliforum' AND APLICADO = 'Si')";

	$precios =ibase_query($conexion,$selec);
	return $precios;
}


public function porEstacion($TRes, $Est){
	$con = new conexion();
	$conexion =$con->conectar();
	$TRes =(int)$TRes;
	$selec ="SELECT * FROM ( SELECT  FIRST($TRes) FOLIO, FECHA, HORA, MAGNA, PREMIUM, DIESEL,APLICADO,USUARIO,IP,ESTACION  FROM  PRECIOSGAS WHERE ESTACION = '$Est' ORDER BY FOLIO DESC)
	ORDER BY FOLIO DESC";
	$topq =ibase_query($selec);

	return $topq;

}
 // Agregar precios en siderurgica
public function insertarSIDE($datos)
{

	$c= new conexion();
	$conexion = $c->conectar();



	$newuser="SELECT MAX(FOLIO) FROM SIDERURGICA";
	$user=ibase_query($conexion,$newuser);

	$folio =ibase_fetch_assoc($user);
	foreach ($folio as $max) {
		# code...
		$valor =$max;
	}
	$id= $valor + 1;

// -------------------------
	$tr=ibase_trans("IBASE_WRITE",$conexion);

	$sql="INSERT INTO  SIDERURGICA(FOLIO,FECHA,HORA,ESTACION,MAGNA,PREMIUM,DIESEL,APLICADO,USUARIO) VALUES('$id','$datos[0]','$datos[1]','$datos[2]','$datos[3]','$datos[4]','$datos[5]','$datos[6]','$datos[7]');";

	$veri=ibase_query($tr,$sql); 
	$estado=ibase_commit($tr);


	return $estado;

}

	// agregar precios en Poliforum
public function insertarPOLI($datos)
{

	$c= new conexion();
	$conexion = $c->conectar();



	$newuser="SELECT MAX(FOLIO) FROM POLIFORUM";
	$user=ibase_query($conexion,$newuser);

	$folio =ibase_fetch_assoc($user);
	foreach ($folio as $max) {
		# code...
		$valor =$max;
	}
	$id= $valor + 1;

// -------------------------
	$tr=ibase_trans("IBASE_WRITE",$conexion);

	$sql="INSERT INTO  POLIFORUM(FOLIO,FECHA,HORA,ESTACION,MAGNA,PREMIUM,DIESEL,APLICADO,USUARIO) VALUES('$id','$datos[0]','$datos[1]','$datos[2]','$datos[3]','$datos[4]','$datos[5]','$datos[6]','$datos[7]');";

	$veri=ibase_query($tr,$sql); 
	$estado=ibase_commit($tr);


	return $estado;

}


		// agregar precios en uman
public function insertaruman($datos)
{

	$c= new conexion();
	$conexion = $c->conectar();



	$newuser="SELECT MAX(FOLIO) FROM UMAN";
	$user=ibase_query($conexion,$newuser);

	$folio =ibase_fetch_assoc($user);
	foreach ($folio as $max) {
		# code...
		$valor =$max;
	}
	$id= $valor + 1;

// -------------------------
	$tr=ibase_trans("IBASE_WRITE",$conexion);

	$sql="INSERT INTO  UMAN(FOLIO,FECHA,HORA,ESTACION,MAGNA,PREMIUM,DIESEL,APLICADO,USUARIO) VALUES('$id','$datos[0]','$datos[1]','$datos[2]','$datos[3]','$datos[4]','$datos[5]','$datos[6]','$datos[7]');";

	$veri=ibase_query($tr,$sql); 
	$estado=ibase_commit($tr);


	return $estado;

}

public function insertarperi($datos)
{

	$c= new conexion();
	$conexion = $c->conectar();



	$newuser="SELECT MAX(FOLIO) FROM PERIORIENTE";
	$user=ibase_query($conexion,$newuser);

	$folio =ibase_fetch_assoc($user);
	foreach ($folio as $max) {
		# code...
		$valor =$max;
	}
	$id= $valor + 1;

// -------------------------
	$tr=ibase_trans("IBASE_WRITE",$conexion);

	$sql="INSERT INTO  PERIORIENTE(FOLIO,FECHA,HORA,ESTACION,MAGNA,PREMIUM,DIESEL,APLICADO,USUARIO) VALUES('$id','$datos[0]','$datos[1]','$datos[2]','$datos[3]','$datos[4]','$datos[5]','$datos[6]','$datos[7]');";

	$veri=ibase_query($tr,$sql); 
	$estado=ibase_commit($tr);


	return $estado;

}







public function preciosPortada1($estacion){

	$c = new conexion();
	$conexion =$c->conectar();
// $estaciones = "SELECT * FROM  ESTACIONES ";

	$consulta="SELECT Pr.MAGNA,Pr.PREMIUM, Pr.DIESEL , Es.ESTACION, Es.IMAGEN, Pr.FECHA,Pr.HORA  FROM PRECIOSGAS Pr, ESTACIONES Es  WHERE Pr.FOLIO=( SELECT MAX(Pr.FOLIO)  FROM PRECIOSGAS Pr WHERE  Pr.APLICADO = 'Si'   AND Pr.ESTACION = Es.ESTACION AND Pr.ESTACION ='$estacion' ) 
	AND Pr.FECHA = (SELECT MAX(Pr.FECHA) FROM PRECIOSGAS Pr  WHERE Pr.APLICADO = 'Si' AND Pr.ESTACION ='$estacion'  ) ";

	$resul=ibase_query($conexion,$consulta);
	// ibase_free_result($resul); 
	// ibase_close($conexion);
	return $resul;

} 
public function preciosProgramados($estacion){
	$c = new conexion();
	$conexion =$c->conectar();
	$consulta="SELECT MAGNA,PREMIUM, DIESEL , ESTACION, FECHA,HORA  FROM PRECIOSGAS  WHERE
	FECHA =( SELECT MAX(FECHA) FROM PRECIOSGAS  WHERE  APLICADO = 'NO' AND ESTACION = '$estacion') AND HORA = (SELECT MAX(HORA) FROM PRECIOSGAS WHERE APLICADO = 'NO' AND ESTACION = '$estacion')
	AND ESTACION  = '$estacion' AND FECHA >= CURRENT_DATE AND FOLIO = (SELECT MAX(FOLIO) FROM PRECIOSGAS WHERE ESTACION  = '$estacion' AND APLICADO  = 'NO')";
	$resul=ibase_query($conexion,$consulta);
	// ibase_free_result($resul); 
	// ibase_close($conexion);
	return $resul;
}




public function traerUsuarios($usuario){

	$c= new conexion();
	$conexion =$c->conectar();

	if($usuario == "Admin"){
		$traer ="SELECT DISTINCT * FROM USUARIOS ORDER BY IDUSUARIO ASC ";
	}else{
		$traer ="SELECT DISTINCT  *  FROM USUARIOS WHERE USUARIO != 'Admin' ORDER BY IDUSUARIO ASC ";
	}
	$usuarios =ibase_query($traer);
	return $usuarios;

}






public function ValidarSINO($folio,$aplicado,$estacion){


	$folio=(int)$folio;
	$aplicado =(string)$aplicado;
	$estacion =(string)$estacion;

	$con= new conexion();
	$conexion=$con->conectar();
	$proc=ibase_trans("IBASE_WRITE",$conexion);


	$modifUser="UPDATE  PRECIOSGAS
	SET APLICADO='$aplicado' WHERE FOLIO='$folio' AND IP ='$estacion';";
	$accion=ibase_query($proc,$modifUser);
	$estado=ibase_commit($proc);
	return $accion;	







}



public function comprimirFacturacion()
{
	$c = new conexionGASProduccion();
	$conexion = $c->produccionGas();
	// Heizt 072020
	//$query = "SELECT FIRST(12) DISTINCT  FECHA,ESTACION FROM DGASPRECEST  ORDER BY FECHA DESC";
	$query = "SELECT FIRST(12) DISTINCT  HORA_APLICA,ESTACION FROM DGASPRECEST  ORDER BY HORA_APLICA DESC";

	$comprimido =ibase_query($conexion,$query);

	$datosFactura ="";
	$preciosCadena="";
	$resultados =array();

	while($d = ibase_fetch_assoc($comprimido))
	{

		$fecha=$d["HORA_APLICA"];
		$estacion = $d["ESTACION"];
		$combustibles ="SELECT PRECIO FROM DGASPRECEST	 WHERE HORA_APLICA ='$fecha' AND ESTACION = '$estacion'";
		$precios =ibase_query($conexion,$combustibles);
		while($com =ibase_fetch_assoc($precios))
		{	
				// $preciosCadena="";
			(string)$com["PRECIO"];
			$preciosCadena.=$com["PRECIO"]."||";
		}
		$preciosCadena.=$estacion."||".$fecha;
			// $datosFactura.=."||";
		array_push($resultados, $preciosCadena);
			//$datosFactura.=$preciosCadena;
		$preciosCadena="";


			// print_r($resultados);
	}

	return $resultados;

}


public function preciosCombustibles($fecha)
{
	$c = new conexionGASProduccion();
	$conexion = $c->produccionGas();

	$query = "SELECT PRECIO  FROM DGASPREC WHERE FECHA = '$fecha'";
	$precios =ibase_query($conexion,$query);

	return $precios;
}


public function eliminarFactura($fecha,$estacion)
{
	$con= new conexionGASProduccion();
	$conexion = $con->produccionGas();
	$verificar= "SELECT FIRST(1) APLICADO FROM DGASPRECEST WHERE FECHA = '$fecha' AND ESTACION = '$estacion'";
	$verificar2= "SELECT FIRST(1) APLICADO FROM DGASPREC WHERE FECHA = '$fecha'";
	$ban1=0;
	$ban2=0;

	$respuesta =ibase_query($conexion,$verificar);
	$Val =ibase_fetch_assoc($respuesta);
	if($Val["APLICADO"] == "Si")
	{
		$borrar ="DELETE FROM DGASPRECEST WHERE FECHA = '$fecha' AND ESTACION = '$estacion' ";
		$borrado=ibase_query($conexion,$borrar);


		$respuesta2 =ibase_query($conexion,$verificar2);
		$Val2 =ibase_fetch_assoc($respuesta2);
		if($Val2["APLICADO"] == "No")
		{
			$borrar2 ="DELETE FROM DGASPREC WHERE FECHA = '$fecha'";
			$borrado2=ibase_query($conexion,$borrar2);
			$ban1=1;

		}

		$ban2=1;

	}

	if ($ban2==1)
	{
		return $borrado;
	}else{
		$mensaje ="Los precios que desea eliminar ya fueron aplicados en las estaciones no se pueden Eliminar";
		return $mensaje;
	}





}





public function sincronizar($Estaciones)
{
	require_once '../../../NuSOAP/lib/nusoap.php';





	try {
		$client = new nusoap_client("http://172.16.0.13:9092/BD.asmx?WSDL",true);
	} catch (Exception $e) {
		print_r("Error al conectarse al Web Services comunicarse con el administrador del sistema".$client);
	}

	// $Estaciones=array();
	// $este =$this->tablaEstaciones();
	// while ($row=ibase_fetch_assoc($este)) {
	// 	array_push($Estaciones, $row["IP"]);
	// }	





	$FOLIO =array();
	$APLICADO =array();
	$returnResultado =array();

	for ($k=0; $k <count($Estaciones); $k++) { 
		try{	
			$Est=array();
			$Est['Est']=$Estaciones[$k];
			$resultado=$client->call('AplicadoSINO',$Est);
			$json = json_decode($resultado['AplicadoSINOResult']);
			$inter = (int) count($json);

			for ($i=0; $i < $inter ; $i++) { 



				array_push($FOLIO, $json[$i]->FOLIO);
				array_push($APLICADO,$json[$i]->APLICADO);

			}

			$array_folio=array_values(array_unique($FOLIO));
			$array_aplicado=$APLICADO;


			for ($z=0; $z <count($array_folio); $z++) { 

				$xxxxx=$this->ValidarSINO($array_folio[$z],$array_aplicado[$z],$Estaciones[$k]);

			}



			

		}

		catch(Exception $e){
			
		}
	}

}

public function permisos_cancelar_requisiciones($id_usuario)
{
	$c= new conexion();
	$conexion = $c->conectar();
	$sql = "SELECT COUNT(*) as PERMISOCANCELARREQ FROM PERMISOS_USUARIOS  WHERE PERMISO = 'RECHAZARREQ' AND IDUSUARIO = '$id_usuario'";
	$resultado  =  ibase_query($conexion,$sql);
	$dato  = ibase_fetch_assoc($resultado);

	$sql = "SELECT COUNT(*) as PERMISOCANCELARORDEN FROM PERMISOS_USUARIOS WHERE PERMISO = 'RECHAZARORDENCOM' AND IDUSUARIO = '$id_usuario'";
	$resultado = ibase_query($conexion,$sql);
	$datos2 = ibase_fetch_assoc($resultado);



	return $array  =array("reqrechazada" => $dato["PERMISOCANCELARREQ"], "ordenrechazada"=>$datos2["PERMISOCANCELARORDEN"]);
}




}

?>