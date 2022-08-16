 $(document).ready(function() {


     $('body').keyup(function(e) {
         if (e.which == 13) {
             //ejecuto algo
             buscador_clientes_modi();
             buscadorClientescredito();

         }
     });
     $("#CargadorClienteCreditos").load("loading.php");

     $("#CargadorClienteCreditos").load("clientesCredito.php");


  

     $('#opcion2').css({ "display": "inline" });

     if (screen.width <= 991) {
         $('#tm2').css({ "display": "inline" });

     }




 });

//  function usuariosxxx() {
//     // body...
//         var materias = $('[name="PRECIOS[]"]:checked').map(function(){
//     return this.value;
//   }).get();
//        console.log(materias)
// }