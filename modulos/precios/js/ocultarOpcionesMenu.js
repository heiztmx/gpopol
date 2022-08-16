 $( document ).ready(function() 
 {
 	// $('#contenedor_menu').hide();
	$('#sub-precios').hide();

     
    $('#movil').click(function(){
    		$('#movil').css({"display":"none"});
    		$('#tacha').css({"display":"inline"});
    });

     $('#tacha').click(function(){
    		$('#movil').css({"display":"inline"});
    		$('#tacha').css({"display":"none"});
    });
		// $('#menu').click(function(){
		// $('#contenedor_menu').slideToggle();
		// });

      $('#conPrecios').click(function()
	  {
       
	  	 $(this).toggleClass("backcolor2");
       $('#sub-precios').slideToggle();
       $('#sub-precios').css({"background-color":"#cacaca"});


       $('#sub-precios').css({"opacity":"1"});
       $(".blue").css({"color": "black"});
       $(".blue").css({"background-color":"#cacaca"});
       
       		
      });


      $('#btn_1').click(function()
	  { 
	  	 $(this).toggleClass("backcolor2");
	  });

	   $('#btn_5').click(function()
	  { 
	  	 $(this).toggleClass("backcolor2");
	  });

		 $('#btn_6').click(function()
	  { 
	  	 $(this).toggleClass("backcolor2");
	  });
	 

	 // $('#btn_3').click(function()
	 //  { 
	 //  	 $(this).toggleClass("backcolorgris");
	 //  });
	 // 	 $('#btn_4').click(function()
	 //  { 
	 //  	 $(this).toggleClass("backcolorgris");
	 //  });
	 
	 
// $( "p" ).click(function() {
//   $( this ).toggleClass( "highlight" );
// });



     //  $('#').click(function(){
      		
  			// $(this).toggleClass(" btn-success");
	
      		
     //  });

	  // $('#date3').click(function() 
	  // {
	  //  $("#selector").css({"box-shadow" : " 0 0 0 #cacaca"
	  // });
 });