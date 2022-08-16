<?php

include "../../../conexion/sesion.php";


$ses = new sesion();
$permisos = $ses->validar_sesion();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Portada</title>
</head>

<body>  

    <script src="../../../javascript/jquery-3.3.1.min.js"></script>

    <script src="../js/cambioSubmenu.js"></script>
    <script src="../js/links.js"></script>
    <script src="../js/cerrarSesion.js"></script>
    <script src="../js/manejoCheckbox.js"></script>
    <script src="../js/DatosModal.js"></script>
    <script src="../js/confirmacion.js"></script>
    <script src="../js/irmodificar.js"></script>
    <script src="../js/llamarValidarSiNo.js"></script>
    <script src="../js/formatoNumeros.js"></script>
    <script src="../js/opcionRegistro2.js"></script>
    <script src="../js/facturacion.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="../js/cambioSubmenu.js" async="async"></script>
    <link rel="stylesheet" href="../../../bootstrapcss/Estiloportada.css">
    <script src="../js/opcionRegistro.js"></script>
    <script src="../js/clickModulo1.js"></script>
    <?php
    include '../../../menu/menu2.php';
    include '../submenus/menuprecios.php';
    ?>

    <div class="m-5"></div>
    
    <br>
        <?php


        // $objeto->sincronizar($ips_sincronizar);

        $arrayestaciones = array();
        //arreglos precios Aplicados
        $Arfecha = array();
        $Armagna = array();
        $Arpremium = array();
        $Ardiesel = array();
        //$Arfolio=array();
        // arreglos precios Programados
        $ArfechaPr = array();
        $ArmagnaPr = array();
        $ArpremiumPr = array();
        $ArdieselPr = array();
        //ArfolioPr = array();
        for ($i=0; $i<count($estaciones_check); $i++) {
            array_push($arrayestaciones, $estaciones_check[$i]);
        }

        for ($i = 0; $i < count($arrayestaciones); $i++) {
            // preciosPortada1
            $metodoApli = $objeto->preciosPortada1($arrayestaciones[$i]);

            while ($aplicados = ibase_fetch_assoc($metodoApli)) {
                array_push($Arfecha, $aplicados['FECHA']);
                array_push($Armagna, $aplicados['MAGNA']);
                array_push($Arpremium, $aplicados['PREMIUM']);
                array_push($Ardiesel, $aplicados['DIESEL']);
            }
            $metodoProg = $objeto->preciosProgramados($arrayestaciones[$i]);

            while ($programados = ibase_fetch_assoc($metodoProg)) {
                array_push($ArfechaPr, $programados['FECHA']);
                array_push($ArmagnaPr, $programados['MAGNA']);
                array_push($ArpremiumPr, $programados['PREMIUM']);
                array_push($ArdieselPr, $programados['DIESEL']);
            }
        }


        ?>

<!--Carousel Wrapper-->
<div id="multi-item-example" class="carousel slide carousel-multi-item" data-ride="carousel" >
 
  <!--Indicators-->
  <ol class="carousel-indicators" >
    <li data-target="#multi-item-example" data-slide-to="0" class="active"></li>
    <li data-target="#multi-item-example" data-slide-to="1"></li>
 
  </ol>
  <!--/.Indicators-->

  <!--Slides-->
  <div class="carousel-inner" role="listbox">

    <!--First slide-->
    <div class="carousel-item active">
                         <br>
                        <table class="table " style="border:1px red solid">

                        </table>
                        <p style="text-align: left;position: relative; top: -5px; "><b>Precios vigentes al <?php echo strftime("%d de %B del %Y",strtotime(date_format(new DateTime($Arfecha[0]),"Y/m/d"))) ?></b></p>
   
    <div class="d-flex flex-row col-lg-7 col-sm-12 mx-auto center-block" >
                        <div  class=" d-flex flex-column ">
                            <p style=" text-align: left; "><b>Estaciones</b></p>
                            <?php for ($i = 0; $i < count($arrayestaciones); $i++) {
                                ?>
                                <p style=" text-align: left;"><?php echo $arrayestaciones[$i]; ?></p>
                                <?php
                            } ?>
                        </div>

                        <div class="d-flex flex-column col-lg-3 col-sm-6   letras_tabla" style="background-color: #008558;">
                            <p style="text-align: center;"><b>Magna</b></p>
                            <?php for ($i = 0; $i < count($Armagna); $i++) {
                                ?>
                                <p style="text-align: center;">
                                    <?php echo $Armagna[$i]; ?></p>
                                    <?php
                                } ?>
                            </div>

                            <div class="d-flex flex-column col-lg-3 col-sm-6  letras_tabla" style="background-color: #8C1937;">
                                <p style="text-align: center;"><b>Premium</b></p>
                                <?php for ($i = 0; $i < count($Arpremium); $i++) {
                                    ?>
                                    <p style="text-align: center;"><?php echo $Arpremium[$i]; ?></p>
                                    <?php
                                } ?>
                            </div>
                            <div class="d-flex flex-column col-lg-3 col-sm-6    letras_tabla" style="background-color: #343A40;">
                                <p style="text-align: center;"><b>Diesel</b></p>
                                <?php for ($i = 0; $i < count($Ardiesel); $i++) {
                                    ?>
                                    <p style="text-align: center;"><?php echo $Ardiesel[$i]; ?></p>
                                    <?php
                                } ?>
                            </div>

                        </div>


                        <!-- </div> -->

                    </div>




                    <div class="carousel-item">
                        <br>
                        <table class="table " style="border:1px red solid">

                        </table>
                         <?php
                                if (count($ArfechaPr) == 0) {
                                    
                                } else {
                         ?>
                        <p style="text-align: left;position: relative; top: -05px; "><b>Precios programados al <?php echo strftime("%d de %B del %Y",strtotime(date_format(new DateTime($ArfechaPr[0]),"Y/m/d"))) ?></b></p>

                         <?php }?>
                        
                        <div class="d-flex flex-row col-lg-7 col-sm-12 mx-auto center-block" style="border:1px black;">
                            <div class="d-flex flex-column  ">
                                <?php
                                if (count($ArfechaPr) == 0) {
                                    echo "No existen precios programados     ";
                                } else {

                                    
                                    ?>

                                    

                                    <p style=""><b>Estaciones</b></p>
                                    <?php for ($i = 0; $i < count($arrayestaciones); $i++) {
                                        ?>
                                        <p style=""><?php echo $arrayestaciones[$i]; ?></p>
                                        <?php
                                    } ?>
                                </div>

                                <div class="d-flex flex-column col-lg-3 col-sm-6 letras_tabla" style="background-color: #008558;">
                                    <p style="text-align: center;"><b>Magna</b></p>
                                    <?php for ($i = 0; $i < count($ArmagnaPr); $i++) {
                                        ?>
                                        <p style="text-align: center;"><?php echo $ArmagnaPr[$i]; ?></p>
                                        <?php
                                    } ?>
                                </div>

                                <div class="d-flex flex-column col-lg-3 col-sm-6 letras_tabla" style="background-color: #8C1937">
                                    <p style="text-align: center;"><b>Premium</b></p>
                                    <?php for ($i = 0; $i < count($ArpremiumPr); $i++) {
                                        ?>
                                        <p style="text-align: center;"><?php echo $ArpremiumPr[$i]; ?></p>
                                        <?php
                                    } ?>
                                </div>
                                <div class="d-flex flex-column col-lg-3 col-sm-6 letras_tabla" style="background-color: #343A40;">
                                    <p style="text-align: center;"><b>Diesel</b></p>
                                    <?php for ($i = 0; $i < count($ArdieselPr); $i++) {
                                        ?>
                                        <p style="text-align: center;"><?php echo $ArdieselPr[$i]; ?></p>
                                        <?php
                                    }
                                } ?>
                            </div>

                        </div>


    </div>
  </div>
  <!--/.Slides-->

    <!--Controls-->
  <div class="controls-top" style="text-align: center;">
    <a class="btn-floating" href="#multi-item-example" data-slide="prev"><i class="fas fa-chevron-left"></i></a>
    <a class="btn-floating" href="#multi-item-example" data-slide="next"><i
        class="fas fa-chevron-right"></i></a>
  </div>
  <!--/.Controls-->

</div>
<!--/.Carousel Wrapper-->




</body>

</html>


