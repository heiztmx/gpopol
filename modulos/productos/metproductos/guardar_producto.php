<?php 

include 'productos.php';

$obj = new productos();
$conexion_gas = $obj->conexionGas();
$conexion_ven = $obj->conexionVentas();
$datos  = $_POST;




// print_r($_POST);
// Array
// (
//     [codigobarras_producto] => 7502271010014
//     [estaciones] => 1
//     [nombre_pro] => AK PREMIUM 20W50
//     [linea_producto] => 1|AKRON
//     [sublinea_producto] => 1
//     [unidad_producto] => PIEZA
//     [CVEPRODSAT] => 15121500
//     [CVEUISAT] => H87
//     [marca_producto] => 1
//     [iva_producto] => 1
// )
$div_linea = explode("|",$_POST["linea_producto"]);
$codigo_barras = $_POST["codigobarras_producto"];
(int)$estacion =$_POST["estaciones"];
$descripcion = $_POST["nombre_pro"];
(int)$linea  =$div_linea[0];
$sublinea =$_POST["sublinea_producto"];
$unidad = strtoupper($_POST["unidad_producto"]);
$cveprodsat =$_POST["CVEPRODSAT"];
$cveuisat = $_POST["CVEUISAT"];
(int)$marca = $_POST["marca_producto"];
(int)$iva = $_POST["iva_producto"];
$clase= "Producto";
$descarga_venta = "Si";
$unidad_embarque = "";
$sql  = "SELECT COUNT(*) as EXISTE FROM DGASPROD WHERE CODIGO_BARRA =  '$codigo_barras'";
$arreglo =array();

$exe = ibase_query($conexion_gas,$sql);
$existe = ibase_fetch_assoc($exe);
// print_r($existe);
if ($existe["EXISTE"] > 0 ) {
    $d_dgasprod=$obj->find_by("DGASPROD","CODIGO_BARRA", $codigo_barras,$conexion_gas);
    $d_dgenprod = $obj->find_by("DGENPROD","CLAVE",$d_dgasprod["CODIGO"],$conexion_ven);
    // print_r($d_dgenprod);
    
    
    $sql  = "UPDATE DGASPROD SET DESCRIPCION = '$descripcion' , UNIDAD = '$unidad'
    ,CLAVEIVA = '$iva', LINEA = '$linea',  ACTIVO  ='Si', CODIGO_BARRA = '$codigo_barras'
    ,CVEPRODSAT ='$cveprodsat', CVEUNISAT  = '$cveuisat'  WHERE CODIGO_BARRA = '$codigo_barras'";
    // print_r($sql);
    $upd  = ibase_query($conexion_gas,$sql);
    if (ibase_affected_rows($conexion_gas) > 0) {
        $clave  = $d_dgenprod["CLAVE"];
        $sql  = "UPDATE  DGENPROD  SET DESCRIPCION = '$descripcion'
        ,LINEA = '$linea'
        , SUBLINEA =  '$sublinea'
        ,UNIDAD = '$unidad'
        ,MARCA  = '$marca'
        ,CLAVEIVA = '$iva'
        ,ACTIVO  = 'Si' WHERE CLAVE  =  '$clave'  ";
        // print_r($sql);
        $upd = ibase_query($conexion_ven,$sql);
        if (ibase_affected_rows($conexion_ven)>0) {
            $arreglo=["estatus"=>"success","mensaje"=>"Producto guardado"];
            $json =json_encode($arreglo);
            echo $json;
            exit;
        }else{
            $arreglo = ["estatus"=>"error","mensaje"=>"Hubo un error al querer guardar el producto en DGENPROD"];
            $json = json_encode($arreglo);
            echo $json;
            exit;
        }
    }else{
        $arreglo = ["estatus"=>"error","mensaje"=>"Hubo un error al querer guardar el producto DGASPROD"];
        $json = json_encode($arreglo);
        echo $json;
        exit;
    }

    
}else{


        $sql  ="SELECT CLAVE FROM DGENPROD ";
        $exe = ibase_query($conexion_ven,$sql);
        $claves = array();
        while($r=ibase_fetch_assoc($exe))
        {
            $c  = (int)$r["CLAVE"];
            array_push($claves,$c);
        }

        $clave = max($claves);
        $clave  = $clave + 1 ;
        (String)$clave;
        // print($clave);

        $agrupado = "No";
        $miembro_grupo = 0;
        $acepta_descuento  = "Si";
        $inventario_por_turno = "No";
        $maneja_receta = "No";
        $manejaunidad2= "Si";
        $factor = 1.00;
        $control_fisico ="Estricto";
        $fraccion_en_unidades = "Si";
        $maneja_series = "No";
        $cigarros  = "No";
        $pieza_cigarros  = 0;
        $imprime_etiqueta = "No";
        $captura_peso ="No";
        $prod_alterno = "";
        $maneja_lotes = "No";
        $modo_impresion_etiqueta = "Por Unidad";
        $ieps = 0;
        $iepsc = 0;
        $ieps_tipo ="Importe";
        $iepsc_tipo ="Importe";
        $iepsgiva = "No";
        $ieps_costeo = "No";
        $activo = "Si";
        $cuenta_cnt= "";
        $sql  = "INSERT INTO DGENPROD (
        CLAVE
        ,DESCRIPCION
        ,LINEA
        ,SUBLINEA
        ,UNIDAD
        ,MARCA
        ,CLASE
        ,CLAVEIVA
        ,UNIDADEMBARQUE
        ,ACTIVO
        ,DESCARGAVENTA
        ,AGRUPADO
        ,MIEMBROSGRUPO
        ,ACEPTADESCUENTO
        ,INVENTARIO_POR_TURNO
        ,MANEJARECETA
        ,MANEJAUNIDAD2
        ,UNIDAD2
        ,FACTOR
        ,CONTROLFISICO
        ,FRACCIONENUNIDADES
        ,MANEJASERIES
        ,CIGARROS
        ,PIEZAS_CIGARROS
        ,IMPRIMEETIQUETA
        ,CAPTURAPESO
        ,PROD_ALTERNO
        ,CUENTA_CNT
        ,MANEJALOTES
        ,MODO_IMPRESION_ETIQUETA
        ,IEPS
        ,IEPSC
        ,IEPS_TIPO
        ,IEPSC_TIPO
        ,IEPSGIVA
        ,IEPSCOSTEO)
        VALUES (
        '$clave'
        ,'$descripcion'
        ,'$linea'
        ,'$sublinea'
        ,'$unidad'
        ,'$marca'
        ,'$clase'
        ,'$iva'
        ,'$unidad_embarque'
        ,'$activo'
        ,'$descarga_venta'
        ,'$agrupado'
        ,'$miembro_grupo'
        ,'$acepta_descuento'
        ,'$inventario_por_turno'
        ,'$maneja_receta'
        ,'$manejaunidad2'
        ,'$unidad'
        ,'$factor'
        ,'$control_fisico'
        ,'$fraccion_en_unidades'
        ,'$maneja_series'
        ,'$cigarros'
        ,'$pieza_cigarros'
        ,'$imprime_etiqueta'
        ,'$captura_peso'
        ,'$prod_alterno'
        ,'$cuenta_cnt'
        ,'$maneja_lotes'
        ,'$modo_impresion_etiqueta'   
        ,'$ieps'
        ,'$iepsc'
        ,'$ieps_tipo'
        ,'$iepsc_tipo'
        ,'$iepsgiva'
        ,'$ieps_costeo')
        ";
        // print($sql);
        // print($clave);
        $transaccion=ibase_trans("IBASE_WRITE",$conexion_ven);
        $veri=ibase_query($transaccion,$sql);
        $estado= ibase_commit($transaccion);	

        if (!$estado) {
            $arreglo = ["estatus"=>"error","mensaje"=>"Hubo un error al querer guardar el producto en DGENPROD"];
            $json = json_encode($arreglo);
            echo $json;
            exit;
        }
      
        $sql  =  "SELECT  MAX(CLAVE) as CLAVE_GAS FROM DGASPROD";
        $exe = ibase_query($conexion_gas,$sql);
        $r = ibase_fetch_assoc($exe);
        $clave_gas = $r["CLAVE_GAS"] + 1;
        (int)$clave;
        $comision = 0.00;
        $sql  = "INSERT INTO DGASPROD
        (CLAVE
        ,DESCRIPCION
        ,UNIDAD
        ,CLAVEIVA
        ,CODIGO
        ,LINEA
        ,ACTIVO
        ,ESTACION
        ,CODIGO_BARRA
        ,COMISION
        ,CVEPRODSAT
        ,CVEUNISAT)
        VALUES
        ('$clave_gas'
        ,'$descripcion'
        ,'$unidad'
        ,'$iva'
        ,'$clave'
        ,'$linea'
        ,'$activo'
        ,'$estacion'
        ,'$codigo_barras'
        ,'$comision'
        ,'$cveprodsat'
        ,'$cveuisat')";
        $trans_gas=ibase_trans("IBASE_WRITE",$conexion_gas);
        $veri_gas=ibase_query($trans_gas,$sql);
        $estado_gas= ibase_commit($trans_gas);
    

        if (!$estado_gas ) {
            $clave  = strval($clave);
            $sql  = "DELETE FROM DGENPROD WHERE CLAVE = '$clave' ";
            ibase_query($conexion_ven,$sql);
            $arreglo = ["estatus"=>"error","mensaje"=>"Hubo un error al querer guardar el producto en DGASPROD"];
            $json = json_encode($arreglo);
            echo $json;
            exit;
        }
        $arreglo=["estatus"=>"success","mensaje"=>"Producto guardado"];
        $json =json_encode($arreglo);
        echo $json;
        exit;
        // print_r($estado);


}






 ?>