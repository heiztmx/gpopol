


<?php 

require_once '../../../NuSOAP/lib/nusoap.php';
include '../webprecios/metodosweb.php';

$objeto = new metodosweb();



try {
	$client = new nusoap_client("http://172.16.0.13:9092/BD.asmx?WSDL",true);
} catch (Exception $e) {
	print_r("Error al conectarse al Web Services comunicarse con el administrador del sistema".$client);
}

$Estaciones=array();
$este =$objeto->tablaEstaciones();
while ($row=ibase_fetch_assoc($este)) {
	array_push($Estaciones, $row["IP"]);
}	





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
			
			$xxxxx=$objeto->ValidarSINO($array_folio[$z],$array_aplicado[$z],$Estaciones[$k]);
			
		}
		
		
		
		print_r($Estaciones[$k]);

	}
	
	catch(Exception $e){
		echo ":v";
	}
}






?>
