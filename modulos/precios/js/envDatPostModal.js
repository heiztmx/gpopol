// $(document).on('ready',function(){
$(document).ready(function(){
 	$("#loaderpoli2").css({"display" : "none"});
    $('#loaderuman2').css({"display" : "none"});
    $('#loaderperi2').css({"display" : "none"});
    $('#loaderside2').css({"display" : "none"});

    $("#imagenpoliv2").css({"display" : "none"});
    $("#imagenumanv2").css({"display" : "none"});
    $("#imagenperiv2").css({"display" : "none"});
    $("#imagensidev2").css({"display" : "none"});

    $("#imagenpolix2").css({"display" : "none"});
    $("#imagensidex2").css({"display" : "none"});
    $("#imagenperix2").css({"display" : "none"});
    $("#imagenperix22").css({"display" : "none"});
    $("#imagenumanx2").css({"display" : "none"});
  $('#mostrar-modal').click(function(){

 


var id=$(this).val();
		var fecha=$('#date3'+id).val();
		var magna=$('#magna'+id).val();
		var premium=$('#premium'+id).val();
		var diesel=$('#diesel'+id).val();
		var poli;
		var uman;
		var peri;
		var side;
		var todos;


if( $('#todos1').prop('checked') ) {
 poli= "Poliforum";
   uman = "Uman";
    peri= "Perioriente";
     side= "Siderurgica";
    
}		
if( $('#poli1').prop('checked') ) {
    poli= "Poliforum";

}
		
if( $('#uman1').prop('checked') ) {
   uman = "Uman";
  
}
		
if( $('#peri1').prop('checked') ) {
    peri= "Perioriente";
 
}
if( $('#side1').prop('checked') ) {
    side= "Siderurgica";

}

if (fecha != "" && magna != "" && premium != "" && diesel != "" && $('#todos1').prop('checked') || $('#poli1').prop('checked') || $('#uman1').prop('checked') ||  $('#peri1').prop('checked') || $('#side1').prop('checked')  ) 
{
	
	  $("#popup").css({"display" : " inline"});
		$('#fechamodal2').val(fecha);
		$('#magnamodal2').val(magna);
		$('#premiummodal2').val(premium);
		$('#dieselmodal2').val(diesel);
		$('#polimodal2').val(poli);
		$('#umanmodal2').val(uman);
		$('#perimodal2').val(peri);
		$('#sidemodal2').val(side);
		$('#todosmodal2').val(todos);
	
}

else{


 swal("Favor de llenar todos los campos",{icon:"warning",})

}

	});
});


