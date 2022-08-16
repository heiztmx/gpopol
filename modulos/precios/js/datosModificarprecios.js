$(document).ready(function(){


$('#btnmostrarModal').click(function(){
	var foliofrm =$('#foliofrm').val();
	var fechafrm =$('#date3').val();
	var estacionfrm =$('#estacionfrm').val();
	var magnafrm =$('#magna').val();
	var premiumfrm=$('#premium').val();
	var dieselfrm=$('#diesel').val();
if(foliofrm != "" && fechafrm != "" && estacionfrm != "" && magnafrm != "" && premiumfrm != "" && dieselfrm != ""){

// var id=$(this).val();
	$('#folioMP').val(foliofrm);
	$('#fechaMP').val(fechafrm);
	$('#estacionMP').val(estacionfrm);
	$('#magnaMP').val(magnafrm);
	$('#PremiumMP').val(premiumfrm);
	$('#dieselMP').val(dieselfrm);
}else{
	alertify.error("Favor de llenar todos los campos :(");
}
});


$('#btnsiMP').click(function(){

	var folio =$('#folioMP').val();
	var fecha=$('#fechaMP').val();
	var estacion=$('#estacionMP').val();
	var magna=$('#magnaMP').val();
	var premium=$('#PremiumMP').val();
	var diesel=$('#dieselMP').val();

	parametros={
		"folio":folio,
		"date3":fecha,
		"magna":magna,
		"premium":premium,
		"diesel":diesel
					}
		$.ajax({
			type:'POST',
			url:'../webprecios/modPrecios.php',
			data:parametros,
			success:function(modificado){
				if(modificado == "modificado"){
					$('#btnsiMP').css({"display": "none"});
					$('#btnnoMP').css({"display" : "none"});
					$('#btnOK').css({"display":"block"});
					alertify.success("Modificacion Exitosa :) ");
					setTimeout("location.href = '../webprecios/general.php'",2500);
				}else{
					// $('#errormodificar').html(modificado);
					$('#btnsiMP').css({"display": "none"});
					$('#btnnoMP').css({"display" : "none"});
					$('#btnOK').css({"display":"block"});
					alertify.error("it's can't modify please you call to system departament")
				}
			}
					}); // fin del ajax
		return false;
	});
});