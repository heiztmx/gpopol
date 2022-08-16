 <?php 
        include 'metodosweb.php';
     
                     $metodos = new metodosweb();
                $bloqueador = $metodos->comprimirFacturacion();
                  
                    var_dump($bloqueador);
                       


                    
 ?>