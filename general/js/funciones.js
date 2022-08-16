

function reset_password(argument) {

	datos = $("#datos").val();
	password1 = $("#pass").val();
	password2= $("#pass_confirmacion").val()

	parametros = {
		"datos":datos,
		"password":password1,
		"opcion": "reset"
	}
	if ((password1 != "" && password2 != "")  && (password1.length >0  && password2.length > 0)) {


		if (password1 === password2) {


			$.ajax({
				type: 'POST',
				url: 'usuarios/request_usuarios.php',
				data: parametros,
				success: function(respuesta) {
					console.log(respuesta)
					data = JSON.parse(respuesta)

					if (data["status"] === "success") 
					{

						$("#formulario_contrasenia").css({"display" : "none"})
						$("#respuesta_contrasenia").css({"display": "inline"});
						$("#titulo").html("Cambio de contraseña exitoso");
						animations_lottie("success",true, "contenedor_animacion_contrasenia")
						$("#explicacion").html("La contraseña ha sida cambiada exitosamente, puede acceder de manera normal a su cuenta")
						// $("#correo_txt").html(" "+correo+" ")
					}
					else
					{

						$("#formulario_contrasenia").css({"display" : "none"})
						$("#respuesta_contrasenia").css({"display": "inline"});
						$("#titulo").html(""+data["mensaje"]);
						animations_lottie("error",true, "contenedor_animacion_contrasenia")
						$("#explicacion").html("Tuvimos errores al querer cambiar la contraseña :(")
					}


				}
			}); 
		}else{
			Swal(
				'Contraseña',
				'Las contraseñas deben ser iguales',
				'error'
				)
		}
	}else{
		Swal(
			'Contraseña',
			'Contraseñas vacias',
			'error'
			)
	}
}

function enviar_email() {
	correo = $("#email").val();
	confirmacion = $("#email_confirmacion").val();
	validar1 = validarEmail(correo)
	validar2 = validarEmail(confirmacion)
	// console.log(validar2)
	if (validar1 === true  && validar2 === true) {
		if (correo === confirmacion) {
			parametros = {
				"correo":correo,
				"opcion": "recuperar"
			}
			$("#enviando_wait").css({"display": "inline"});
			$("#btnlogin").css({"display": "none"});

			$.ajax({
				type: 'POST',
				url: 'usuarios/request_usuarios.php',
				data: parametros,
				success: function(respuesta) {
					console.log(respuesta)
					data = JSON.parse(respuesta)

					if (data["status"] === "success") 
					{
						$("#explicacion").html("Se enviado un correo  a la direccíon <strong id='correo_txt'></strong>.De no encontrarlo en su bandeja de entrada , verificar su carpeta de spam")
						$("#formulario_password").css({"display" : "none"})
						$("#respuesta_email").css({"display": "inline"});
						$("#titulo_email").html("Correo enviado");
						animations_lottie("success",false,"contenedor_animacion_email")
						$("#correo_txt").html(" "+correo+" ")
						$("#enviando_wait").css({"display": "none"});
					}

					else if(data["status"] === "no_existe"){

						Swal('Contraseña','El email no coincide con ningun usuario','error')
									$("#enviando_wait").css({"display": "none"});
									$("#btnlogin").css({"display": "inline"});

					}	
					else 
					{
						$("#explicacion").html("No se pudo enviar el correo favor de intentarlo mas tarde. Si el problema persiste favor de llamar al departamento de sistemas")
						$("#formulario_password").css({"display" : "none"})
						$("#respuesta_email").css({"display": "inline"});
						$("#titulo_email").html("Error al enviar el correo");
						animations_lottie("error",true,"contenedor_animacion_email")
						$("#enviando_wait").css({"display": "none"});
					}

				}
              }); //fin del ajax

		}else{
			Swal(
				'Contraseña',
				'Las direcciones de correo no coinciden',
				'error'
				)
		}
	}else{
		Swal(
			'Contraseña',
			'Formato incorrecto de correo',
			'error'
			)
	}
}



function validarEmail(email) {
	if (/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(email)){
		return true;
	} else {
		return false;
	}
}



function animations_lottie(imagen,ciclo="",contenedor) {

	lottie.loadAnimation({
		container: document.getElementById(''+contenedor), // the dom element that will contain the animation
		renderer: 'svg',
		loop: ciclo,
		autoplay: true,
		path: 'assets/'+imagen+'.json' // the path to the animation json
	});

}

