<?php   session_start(); 


if(isset($_SESSION['user']) &&  $_SESSION['logeado']== true){

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
<title>Modificar Precios</title>
<link rel="stylesheet" href="../css/styleModificarPrecios.css" />
<link rel="stylesheet" href="../css/styleprecios.css" />
<link href="../css/mobiscroll-1.5.css" rel="stylesheet" type="text/css" />

<link href="https://fonts.googleapis.com/css?family=Gugi|Roboto+Condensed" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Patua+One|Teko" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Russo+One" rel="stylesheet">
<link rel="stylesheet" href="../alertifyjs/css/alertify.css">
<link rel="stylesheet" href="../alertifyjs/css/themes/default.css">
<!-- links para movil -->
<link rel="stylesheet" href="../cssmovil/movilModificarPrecios.css" />
 <!-- Buenas librerias hasta ahora -------------- -->
<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="../js/mobiscroll-1.5.1.js" type="text/javascript"></script>
<!-- --------------------------------------------- -->
<script src="../alertifyjs/alertify.js"></script>
<script src="../js/datosModificarprecios.js"></script>
<link href="../sweetalert-master/src/sweetalert.css" type="text/css">
<script src="../sweetalert-master/docs/assets/sweetalert/sweetalert.min.js"></script>
<script src="../js/irmodificar.js"></script>
<script src="../js/links.js"></script>

    <script type="text/javascript">
         
 
        $(document).ready(function () {
            $('#date1').scroller();
            $('#date2').scroller({ preset: 'time' });
            $('#date3').scroller({ preset: 'datetime' });
            $('#date4').scroller({ preset: 'datetime' });
            wheels = [];
            wheels[0] = { 'PESOS': {} };
            wheels[1] = { 'CENTAVOS': {} };
            for (var i = 0; i < 100; i++) {
                if (i < 100) wheels[0]['PESOS'][i] = (i < 10) ? ('0' + i) : i;
                wheels[1]['CENTAVOS'][i] = (i < 10) ? ('0' + i) : i;
            }
            $('#diesel').scroller({
                width: 90,
                wheels: wheels,
                showOnFocus: false,
                formatResult: function (d) {
                    return ((d[0] - 0) + ((d[1] - 0) / 100)).toFixed(2);
                },
                parseValue: function (s) {
                    var d = s.split('.');
                    d[0] = d[0] - 0;
                    d[1] = d[1] ? ((('0.' + d[1]) - 0) * 10) : 0;
                    return d;
                }
            });
            $('#diesel').click(function() { $(this).scroller('show'); });

            // --------------------------------------

              $('#magna').scroller({
                width: 90,
                wheels: wheels,
                showOnFocus: false,
                formatResult: function (d) {
                    return ((d[0] - 0) + ((d[1] - 0) / 100)).toFixed(2);
                },
                parseValue: function (s) {
                    var d = s.split('.');
                    d[0] = d[0] - 0;
                    d[1] = d[1] ? ((('0.' + d[1]) - 0) * 10) : 0;
                    return d;
                }
            });
            $('#magna').click(function() { $(this).scroller('show'); });
            // -------------------------------------------


              $('#premium').scroller({
                width: 90,
                wheels: wheels,
                showOnFocus: false,
                formatResult: function (d) {
                    return ((d[0] - 0) + ((d[1] - 0) / 100)).toFixed(2);
                },
                parseValue: function (s) {
                    var d = s.split('.');
                    d[0] = d[0] - 0;
                    d[1] = d[1] ? ((('0.' + d[1]) - 0) * 10) : 0;
                    return d;
                }
            });
            $('#premium').click(function() { $(this).scroller('show'); });

                    // ------------------------------------
            $('#disable').click(function() {
                if ($('#date2').scroller('isDisabled')) {
                    $('#date2').scroller('enable');
                    $(this).text('Disable');
                }
                else {
                    $('#date2').scroller('disable');
                    $(this).text('Enable');
                }
                return false;
            });

            $('#get').click(function() {
                alert($('#date2').scroller('getDate'));
                return false;
            });

            $('#set').click(function() {
                $('#date1').scroller('setDate', new Date(), true);
                return false;
            });

            $('#theme, #mode').change(function() {
                var t = $('#theme').val();
                var m = $('#mode').val();
                $('#date1').scroller('destroy').scroller({ theme: t, mode: m });
                $('#date2').scroller('destroy').scroller({ preset: 'time', theme: t, mode: m });
                $('#date3').scroller('destroy').scroller({ preset: 'datetime', theme: t, mode: m });
                 $('#date4').scroller('destroy').scroller({ preset: 'datetime', theme: t, mode: m });
                 $('#negro').scroller('option', { theme: t, mode: m });
                $('#magna').scroller('option', { theme: t, mode: m });
                $('#premium').scroller('option', { theme: t, mode: m });
                

            });
        });

        /*$(function () {
        $('#numero').mobiscroll().number({theme: 'material', maxWidth:100});

            }  );*/
    </script>
        



<!-- ----------------------------------------------------- -->



<?php 
$folio= $_GET['folio'];
 echo $folio;
include 'metodosweb.php';
include 'elegir-encabezado.php';
include '../modals/modificarPrecios-modal.php';

$x = new  encabezados();
$enca = $x->elegir_enca();
$metodos =new metodosweb();
$folio=(int)$folio;
$traer = $metodos->traerDatos($folio);

$row = ibase_fetch_object($traer);
$horabuena=date_create($row->HORA);
$hora =date_format($horabuena,'g:i a');
$fechacompleta = $row->FECHA." ".$hora;

 ?>
<body>
 
        
<input type="text" value="<?php echo $_SESSION['user'] ?>" id="usuariomodifico" style="display: none;" />
            <h1 class="h1">Modificar Precios </h1>
                <form id="formulario" action="modPrecios.php" method="POST">

                   <div id="folio">
                    <label for="">Folio</label>
                    <input type="text" value="<?php echo $row->FOLIO; ?>" readonly="" class="dt" name="folio" id="foliofrm"/>

                   </div>
                    <div id="folyDT">
                    
                    <label for="date3">Fecha</label>
                    <input type="text" name="date3" id="date3" class="mobiscroll"  value="<?php echo $fechacompleta; ?>"/>
                </div>
               <div id="estacion1">
                    <label for="">Estacion</label>
                    <input type="text" value="<?php echo $row->ESTACION; ?>" readonly="" class="dt" id="estacionfrm"/>
                   </div>
                <div id="combustibles">
                    <div id="verde">
                    
                         <h2>PEMEX MAGNA</h2>
                   
                 <input type="text" name="magna" id="magna" class="mobiscroll vm"  value="<?php print number_format($row->MAGNA,2,'.',','); ?>"/>
                    </div>

                    <div id="rojo">
                        <h2>PEMEX PREMIUM</h2>
                       <input type="text" name="premium" id="premium" class="mobiscroll rp" value="<?php print number_format($row->PREMIUM,2,'.',','); ?>" />
                    </div>
                    <div id="negro">
                        <h2>PEMEX DIESEL</h2>
                    <!-- <input type="text" name="date4" id="date4" class="mobiscroll "/> -->
                    <input type="text" name="diesel" id="diesel" class="mobiscroll nd" value="<?php print number_format($row->DIESEL,2,'.',','); ?>" />
                    </div>

                                        
                </div>




       <div id="botones">
         <a onclick="RegistroGeneral()" >Cancelar</a>
       <a id="btnmostrarModal" onclick="confirmarModificacion()">Aplicar</a>

      </div> 



            </form>
           
            
      
</body>
</html>
<?php 
} else {
    header("location:../index.php");
}