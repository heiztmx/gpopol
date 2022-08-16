
$(document).ready(function(){
	$('#id_cliente').keyup(function(e) {
		if(e.which == 13){
		//ejecuto algo
buscadorID();
		}
	});
	});


function busquedaCliente() {
var opcion =document.getElementById("opcionCliente").value;

if (opcion == "pc"){
  
  $("#formu_cliente").css({"display" :"inline"});
  $("#id_cliente").focus();
   $("#id_cliente").val('');
   $("#nombre_cliente").val('');
  // document.getElementById('bNombre').setAttribute( "onclick","buscadorClientesprepago();");
}

if (opcion == "tc") {
	$("#formu_cliente").css({"display" :"none"});

	$("#id_cliente").val('');
	$("#nombre_cliente").val('');
}
}



function buscadorID(argument) {
	
	var id = $("#id_cliente").val();
			parametros ={"id_cliente" : id}
		   $.ajax({
          type:'POST',
          url: '../webCupones/buscadorClienteID.php',
          data:parametros,
          success:function(cliente){
           $("#nombre_cliente").val(cliente);
          }
        }); //fin del ajax;

}

function buscadorID(argument) {
	
	var id = $("#id_cliente").val();
			parametros ={"id_cliente" : id}
		   $.ajax({
          type:'POST',
          url: '../webCupones/buscadorClienteID.php',
          data:parametros,
          success:function(cliente){
           $("#nombre_cliente").val(cliente);
          }
        }); //fin del ajax;

}


Date.prototype.addDays = function(noOfDays){
    var tmpDate = new Date(this.valueOf());
    tmpDate.setDate(tmpDate.getDate() + noOfDays);
    return tmpDate;
}

function GenerarReporteCupones() {
  var estacion  =document.getElementById("estaciones").value;
  var usuario ="todosUsuarios";//document.getElementById("opcionCliente1").value;
  var fecha = $("#fecha_recuperacion").val();
  var fecha2 = $("#fecha_recuperacion2").val();
  var cliente = $("#id_cliente").val();


   var ipUsuario ="";
    if ($("#ipUsuario").prop('checked') ){
        ipUsuario="Siusuario"
    }else{
        ipUsuario="Nousuario"
    }
  // $("#tablas_cupones").empty("");
  // alert(usuario);

parametros={
  "fecha":fecha,
  "fecha2":fecha2,
  "estacion":estacion,
  "cliente":cliente,
  "ip":ipUsuario,
  "usuario":usuario
}
//console.log(parametros);
    //console.log("fecha", fecha+31);

let fechamod = new Date(fecha);
var fechalit =  formatDate(fechamod.addDays(63),2);

//console.log("fecha + dias : ", );

if(fecha>="2021-07-21" && fecha2 <= fechalit ){

if( fecha != "" && fecha2 >= fecha){


     $.ajax({
          type:'POST',
          url: '../webCupones/taerCupones.php',
          data:parametros,
          dataType:"html",
        beforeSend: function(){
                    //imagen de carga
                    $("#tablas_cupones").html("<div  id='loader' class='preloader mx-auto font-weight-light'></div>");
                    },
        error: function(){
                    Swal({type: 'warning',title: '',text: 'Algo salio mal con la busqueda',confirmButtonText: 'Ok',
    confirmButtonColor: "#fbbb1d",footer: '<a href ="#">Recarga la pagina si el problema persiste llamar a sistemas</a>'})
                    },
          success:function(data){

            $("#tablas_cupones").empty();
            $("#tablas_cupones").append(data);  
          }
        });
     return false;
   }else{
    Swal({type: 'warning',title: '',text: (fecha2 < fecha ? 'Verifique las fechas':'Verifique las fechas'), confirmButtonText: 'Ok',
    confirmButtonColor: "#fbbb1d",footer: '<a href ="#">Elige la fecha a consultar</a>'})
   }
}else{
    Swal({type: 'warning',title: '',text: ( fecha2 <= fechalit ? 'Valide su fecha inicial ya que solo se puede consultar información apartir del 21/07/2021':'Valide su fecha final, ya que solo se puede consultar 60 días como maximo'), confirmButtonText: 'Ok',
    confirmButtonColor: "#fbbb1d",footer: '<a href ="#">Elige la fecha a consultar</a>'})
    $("#tablas_cupones").empty();
   }

}

function formatDate(dateObj,format)
{
    var monthNames = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];
    var curr_date = dateObj.getDate();
    var curr_month = dateObj.getMonth();
    curr_month = curr_month + 1;
    var curr_year = dateObj.getFullYear();
    var curr_min = dateObj.getMinutes();
    var curr_hr= dateObj.getHours();
    var curr_sc= dateObj.getSeconds();
    if(curr_month.toString().length == 1)
    curr_month = '0' + curr_month;      
    if(curr_date.toString().length == 1)
    curr_date = '0' + curr_date;
    if(curr_hr.toString().length == 1)
    curr_hr = '0' + curr_hr;
    if(curr_min.toString().length == 1)
    curr_min = '0' + curr_min;

    if(format ==1)//dd-mm-yyyy
    {
        return curr_date + "-"+curr_month+ "-"+curr_year;       
    }
    else if(format ==2)//yyyy-mm-dd
    {
        return curr_year + "-"+curr_month+ "-"+curr_date;       
    }
    else if(format ==3)//dd/mm/yyyy
    {
        return curr_date + "/"+curr_month+ "/"+curr_year;       
    }
    else if(format ==4)// MM/dd/yyyy HH:mm:ss
    {
        return curr_month+"/"+curr_date +"/"+curr_year+ " "+curr_hr+":"+curr_min+":"+curr_sc;       
    }
}

