<?php 


/**
 * 
 */

require_once '../../../NuSOAP/lib/nusoap.php';

class classWS
{

	public function ConexionToWS()
	{
		# code...
		try {
			$servidor = new nusoap_client("http://172.16.0.13:9092/BD.asmx?WSDL",true);
				return $servidor;
		} catch (Exception $error) {
			 return $error;

		}
	}

		public function ConexionMetodos($ip_WSgpopol)
	{
		# code...
		try {
			$servidor = new nusoap_client("http://".$ip_WSgpopol."/WSgpopol/Metodos.asmx?WSDL",true);

				return $servidor;
		} catch (Exception $error) {
			 return $error;

		}
	}
	
	
	public function Agregar_precios($ipe,$magna,$premium,$diesel,$fechacompleta,$usuario,$fecha,$hora,$estacion)
	{


  # code...
		$error="error";
		$paraWS=array();
		$paraWS['estacion']=$ipe;
		$paraWS['com1']=$magna;
		$paraWS['com2']=$premium;
		$paraWS['com3']=$diesel;
		$paraWS['fecha']=$fechacompleta;
		$paraWS['usuario']=$usuario;
		try{
			$po = $this->ConexionToWS()->call('SetPrecios',$paraWS);
			$longitud =strlen($po["SetPreciosResult"]);

			(int)$po['SetPreciosResult'];


			if($po['SetPreciosResult'] > 0){

				require_once '../webprecios/metodosweb.php';
				  $metodos = new metodosweb();

				$parametrosLocal=array($po['SetPreciosResult'],
					$fecha,$hora,$estacion,$magna,$premium,$diesel,"NO",$usuario,$ipe);
				
				$insert=$metodos->insertarPrecios($parametrosLocal);
				if($insert == 1){
					return $estacion;

				}else{
					return $error."localInsert ".$ipe;
				}

//aqui estan los errores de ws no se pudo conectar o su metodo de ws no esta guardando
			}else{
				return $error."wsInsert ".$ipe;
				// return $po['SetPreciosResult'] ;
			}

		}catch(Exception $ex){
			return $error."wsconexion ".$ipe;
		}
      // $contador++;

	}


	public function Facturacion($ip_facturacion,$id_estacion,$magna,$premium,$diesel,$fecha,$usuario,$hora)
	{
  # code...


		$paraFACTURA=array();      
  $paraFACTURA['estacion']=$ip_facturacion;                   //Heizt
  $paraFACTURA['estacionID']=$id_estacion;
  $paraFACTURA['com1']=$magna;
  $paraFACTURA['com2']=$premium;
  $paraFACTURA['com3']=$diesel;
  $paraFACTURA['fecha']=$fecha;
  $paraFACTURA['usuario']=$usuario;
  $paraFACTURA['hora']=$hora;
  //print_r($hora);
  $po1 =$this->ConexionToWS()->call('SetPreciosFacturaEst',$paraFACTURA);


  if ($po1['SetPreciosFacturaEstResult'] == "Actualizado" || $po1['SetPreciosFacturaEstResult'] == "Agregado"){
  	return 1;
  }else{
  	return 0;
  }

}

}

?>