function confirmarCierre() {
    //le doy un tiempo a la funcion cerrar sesion para que el usuario tenga un tiempo para confirmar, sino lo hizo en el tiempo se cerrara la sesion automaticamente
    var cerrar = setTimeout(cerrarSesion,180000);//5 segs de prueba
    var ignorado = setTimeout(cerrarSesion,180000);


 			
 


let timerMin;
let timerSeg ;

tm = 3;
ts = tm * 60000; //3min


Swal({
  title: 'Alerta de inactividad',
  html: 'la sesion se cerrar automaticamente en  <strong style="color:red"> </strong>: <strong3 style="color:red"></strong3><strong2 style="color:red"></strong2> minutos.',
  timer: ts,
  type:'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Continuar',
  onBeforeOpen: () => {



    c_s=59;
    c_m=3;
    cronometro=setInterval(function(){
    	if (c_s==59)
    	{
    	    c_s=59;	
    		c_m--;
    	Swal.getContent().querySelector('strong') 
        .textContent = c_m;
    	}

    		if(c_s <10){
    	Swal.getContent().querySelector('strong3') 
        .textContent = "0";
    		}else{
    			Swal.getContent().querySelector('strong3') 
        .textContent = "";
    		}

    		Swal.getContent().querySelector('strong2') 
        .textContent = c_s;

		if(c_s > 0){
    		c_s--;
    		}
    	else{c_s=59;	}
    	
    		if (c_s == 0 && c_m == 0){
    			cerrarSesion();
    		}

    	
	
    },1000);
    
   

   
  },
  onClose: () => {
    clearInterval(cronometro)
    // clearInterval(timerSeg)

  }
}).then((result) => {
   if (result) {
            //si presiona OK
            clearTimeout(cerrar); //elimino el tiempo a la funcion cerrarSesion
            clearTimeout(temp); //elimino el tiempo a la funcion confirmarCierre
            clearTimeout(ignorado);
            temp = setTimeout(confirmarCierre, 180000); //y aca le doy un nuevo tiempo a la funcion confirmarCierre (5 segs)
           
        
  }else{
  	cerrarSesion();
  }
})

 // timerInterval = setInterval(() => {
 //      Swal.getContent().querySelector('strong')
 //        .textContent = (Swal.getTimerLeft() / 1000)
 //          .toFixed(0)
 //    }, 100)
        

        // function(){
             //si presiono Cancel, pues ejecuta la funcion cerrarSesion y posteriormente la cierra.
        // }
    // );
}

function cerrarSesion() {
	// alert("sesion cerrada");
    window.location.href = "../webprecios/cerrarSesion.php";
    //window.location = "/logout";
     //coloco una notificacion para observar el momento en el q se ejecuta
   
}

// se llamará a la función que confirmar Cierre después de 10 segundos
var temp = setTimeout(confirmarCierre, 10000);


$( document ).on('click keyup keypress keydown blur change', function(e) {
     temp = setTimeout(confirmarCierre,10000);
    ignorado = setTimeout(cerrarSesion,10000);
    clearTimeout(temp);
    clearTimeout(ignorado);
   
    console.log('actividad detectada');
});





  $(document).on('mousemove', function() {
     temp = setTimeout(confirmarCierre,10000);
    ignorado = setTimeout(cerrarSesion,10000);
    clearTimeout(temp);
    clearTimeout(ignorado);
   
    console.log('actividad detectada');

  });















// function confirmarCierre() {
//     //le doy un tiempo a la funcion cerrar sesion para que el usuario tenga un tiempo para confirmar, sino lo hizo en el tiempo se cerrara la sesion automaticamente
//     var cerrar = setTimeout(cerrarSesion,5000);//5 segs de prueba
//     var ignorado = setTimeout(cerrarSesion,5000);
//    $("#btnInactividad").trigger("click");


 			
 
// }



// function continuar() {
// 	var cerrar = setTimeout(cerrarSesion,5000);//5 segs de prueba
//     var ignorado = setTimeout(cerrarSesion,5000);
// 	clearTimeout(cerrar); //elimino el tiempo a la funcion cerrarSesion
//             clearTimeout(temp); //elimino el tiempo a la funcion confirmarCierre
//             clearTimeout(ignorado);
//             temp = setTimeout(confirmarCierre, 5000); //y aca le doy un nuevo tiempo a la funcion confirmarCierre (5 segs)
// }


        

   

// function cerrarSesion() {
// 	alert("sesion cerrada");
//     // window.location.href = "../webprecios/cerrarSesion.php";
 
   
// }


// var temp = setTimeout(confirmarCierre, 10000);


// $( document ).on('click keyup keypress keydown blur change', function(e) {
//      temp = setTimeout(confirmarCierre,10000);
//     ignorado = setTimeout(cerrarSesion,10000);
//     clearTimeout(temp);
//     clearTimeout(ignorado);
   
//     console.log('actividad detectada');
// });


//   $(document).on('mousemove', function() {
//      temp = setTimeout(confirmarCierre,10000);
//     ignorado = setTimeout(cerrarSesion,10000);
//     clearTimeout(temp);
//     clearTimeout(ignorado);
   
//     console.log('actividad detectada');

//   });
