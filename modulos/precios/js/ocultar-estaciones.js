function ocultar_Estaciones(estaciones){

cadena = estaciones;
dividir ="||";
subestaciones = cadena.split(dividir);

$('#todas').click(function()
        {
     for(i=0; i<subestaciones.length; i++){
         $("tabla"+subestaciones[i]).hide();
     }
       
      });


}


//  $( document ).ready(function() 
//  {

// 	// $('#tabla1').hide();
// 	// $('#tabla2').hide();
// 	// $('#tabla3').hide();
// 	// $('#tabla4').hide();
// // CLIP
//     $('#todas').click(function()
//         {
//        // $("#selector").css({"box-shadow" : " 0 0 5px #cacaca"});
       
//       });


//       $('#side').click(function()
// 	  {
//        // $("#selector").css({"box-shadow" : " 0 0 5px #cacaca"});
//        $('#tabla1').show();
//       $('#tabla2').hide();
//       $('#tabla3').hide();
//       $('#tabla4').hide();
//       });



//       $('#uman').click(function()
// 	  {
      
     
//       $('#tabla2').show();
//       $('#tabla1').hide();
//       $('#tabla3').hide();
//       $('#tabla4').hide();
//       });



//       $('#san-pedro').click(function()
// 	  {
      
       
//       $('#tabla3').show();
//        $('#tabla2').hide();
//       $('#tabla1').hide();
//       $('#tabla4').hide();
//       });


//        $('#poli').click(function()
// 	  {
      
  
//       $('#tabla4').show();
//       $('#tabla2').hide();
//       $('#tabla3').hide();
//       $('#tabla1').hide();
//       });

// 	  // $('#date3').click(function() 
// 	  // {
// 	  //  $("#selector").css({"box-shadow" : " 0 0 0 #cacaca"
// 	  // });
//  });
    