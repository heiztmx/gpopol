

function verificarSiNo() {
	
subIp=cadena.split("||");
console.log(cadena);
for(i=0; i<subIp.length; i++){
	console.log(subIp[i]);
}
subIp.pop();
// Swal('Espere un momento por favor','La informacion se esta actualizando...','info');
/*
Swal.fire({
  position: 'top-end',
  icon: 'success',
  title: 'Your work has been saved',
  showConfirmButton: false,
  timer: 1500
})
*/
let timerInterval
Swal.fire({
  title: 'Espere un momento por Favor',
  html: 'Sincronizando precios...<b></b>', /*<strong style="display:none;"></strong>',*/
  timer: 2000,
  //timerProgressBar: true,
  onBeforeOpen: () => {
    /*Swal.showLoading()
    timerInterval = setInterval(() => {
      Swal.getContent().querySelector('strong')
        .textContent = Swal.getTimerLeft()
    }, 100)*/
    Swal.showLoading()
    timerInterval = setInterval(() => {
      const content = Swal.getContent()
      if (content) {
        const b = content.querySelector('b')
        if (b) {
          b.textContent = Swal.getTimerLeft()
        }
      }
    }, 100)

  },
  onClose: () => {
     clearInterval(timerInterval)
  }
}).then((result) => {
  if (
    // Read more about handling dismissals
    result.dismiss === Swal.DismissReason.timer
  ) {
    // console.log('I was closed by the timer')
  }
})

var parametros={}
		$.ajax({
			type:"POST",
			url:"../web-services/WsValidarSiNo.php",
			data:parametros,

			success:function(arreglo){
        
				var correctos=0;
				// var ips = ["172.16.1.25","172.16.2.25","172.16.3.25","172.16.4.25"];
				
				
				
				
				for (var i = 0; i<subIp.length; i++) {
					
					find =arreglo.indexOf(subIp[i]);
					if (find != -1) {
						correctos ++;
					}
					
   				}
			console.log(correctos);
			if (correctos == subIp.length)
   				{
   					
   					Swal({
  type: 'success',
  title: 'Precios Sincronizados',
  //timerProgressBar: true,
  text: 'Redireccionando a la pagina...',
  showConfirmButton: false,
  timer: 2000
 
               });
       	//setTimeout("location.href = 'carrousel.php'", 2000);				// load("listado.php")
       	setTimeout("loader_seccion('carrousel.php','cargador')", 100);

   				}
   				else{
   				Swal({
				type: 'warning',
				title: 'Sincronización',
				text: 'Los precios de algunas estaciones no pudieron sincronizarse, intentelo mas tarde'
								 
				});
        //setTimeout("location.href = 'carrousel.php'", 2000); 
        setTimeout("loader_seccion('carrousel.php','cargador')", 100); 
   					  // load("listado.php")
   					
   				}
			}
		}); return false // final de ajax

}