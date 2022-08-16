function cerrar(){

swal("","¿Seguro que desea cerrar sesion?", {
  buttons: {
    cancel: "NO",
    catch: {
      text: "Cerrar sesion",
      value: "Si",
    },
   
  },
})
.then((value) => {
  switch (value) {
 
    case "defeat":
      swal("Continua la sesion!", "success");

      break;
 
    case "Si":
      swal("Bye!", "Sesion Cerrada!", "warning");
      setTimeout("location.href = '../webprecios/cerrar-sesion.php'",100000);

      break;
 
    default:
      // swal("Continua la sesion!",{ icon:"success",});
  }
});




const swalWithBootstrapButtons = Swal.mixin({
  confirmButtonClass: 'btn btn-success',
  cancelButtonClass: 'btn btn-danger',
  buttonsStyling: false,
})

swalWithBootstrapButtons({
  title: 'Cerrar sesion',
  text: "¿Seguro que deseas cerrar sesion?",
  type: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Si ',
  cancelButtonText: 'No',
  reverseButtons: true
}).then((result) => {
  if (result.value) {
    
      setTimeout("location.href = '../webprecios/cerrar-sesion.php'",100000);
     } else if (
    // Read more about handling dismissals
    result.dismiss === Swal.DismissReason.cancel
  ) {
    
  }
})

}