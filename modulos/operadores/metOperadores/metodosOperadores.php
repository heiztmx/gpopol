<?php 

/**
 * 
 */

require_once('../../../conexionGASproduccion.php');
require_once '../../../ConexionADMON.php';
require_once '../../../conexion.php';


class Operadores
{		

	 public function tablaEstaciones()
	 {
 		$c=new conexion();
 		$conexion = $c->conectar();
 		$usuario ="SELECT *  FROM ESTACIONES ORDER BY ID ASC";
 		$estaciones = ibase_query($conexion,$usuario);
 		return $estaciones;
 	}

	public function VerificarPassword($passw, $nombre,$id)
	{
		 $c = new conexionGASProduccion();
 		$conexion=$c->produccionGas();
 		$resul ="SELECT COUNT(*) AS EXISTENTE FROM DGASDESP  WHERE PASSW = '$passw' AND CLAVE != '$id'";	
 		$despa = ibase_query($conexion,$resul);
 		$resultado =ibase_fetch_assoc($despa);

 		return $resultado["EXISTENTE"];
	}


		public function Despachadores()
 	{
 		$c = new conexionGASProduccion();
 		$conexion=$c->produccionGas();
 		$resul ="SELECT CLAVE,NOMBRE, ESTACION, PASSW, ACTIVO,ES_JEFE_DE_TURNO,TIPO_DESPACHADOR FROM DGASDESP  ORDER BY NOMBRE ASC";	
 		$despa = ibase_query($conexion,$resul);
 		return $despa;
 	}

 	public function ModificacionOper($id,$nombre,$estacion,$password,$activo,$jefe,$tipo)
 	{
 		$con= new conexionGASProduccion();
		$conexion =$con->produccionGas();
		$trans=ibase_trans("IBASE_WRITE",$conexion);
		$modif="UPDATE DGASDESP 
	SET NOMBRE ='$nombre',ESTACION ='$estacion',PASSW = '$password',ACTIVO ='$activo',ES_JEFE_DE_TURNO='$jefe',TIPO_DESPACHADOR= '$tipo'  WHERE CLAVE = '$id';";
		 $veri=ibase_query($trans,$modif);
		 $estado=ibase_commit($trans);
		 return $veri;
 	}


 	public function ultimoFolioDespachador()
 	{
 		$con= new conexionGASProduccion();
		$conexion =$con->produccionGas();
		$select ="SELECT MAX(CLAVE) AS CLAVE FROM DGASDESP";
		$respuesta=ibase_query($conexion,$select);
		$ultimo =ibase_fetch_assoc($respuesta);
		$ultimo = $ultimo["CLAVE"] +1;
		return $ultimo;

 	}
 	public function insertNuevoUsuario($clave,$nombre,$estacion,$passw,$activo,$jefeTurno,$tipoDespachador)
 	{

// 
// tablaEstaciones
 		$con= new conexionGASProduccion();
		$conexion =$con->produccionGas();
		$insert="INSERT INTO DGASDESP(CLAVE,NOMBRE,CTACNT,ESTACION,PASSW,ACTIVO,ES_JEFE_DE_TURNO,ESJEFEMANTENIMIENTO,NUMTAG,TIPO_DESPACHADOR,HUELLA) VALUES ('$clave','$nombre','','$estacion','$passw','$activo','$jefeTurno','No','','$tipoDespachador', '')";
		$trans=ibase_trans("IBASE_WRITE",$conexion);
		 $veri=ibase_query($trans,$insert);
		 $estado=ibase_commit($trans);
		 return $estado;
 	}

}

 ?>