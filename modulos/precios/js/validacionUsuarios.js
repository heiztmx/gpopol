function privilegios_usuarios(modulos) {
	// body...
	submodulos=modulos.split("||");
	submodulos.pop();
	parametro=[];
	for(i=0; i<submodulos.length; i++){
	    	//variables globales se pueden usar en toda la ventana
	    	window["arreglochk"+submodulos[i]]= $('[name="'+submodulos[i]+'[]"]:checked').map(function(){
	    		return this.value;
	    	}).get();
	    	parametro[""+submodulos[i]] = window["arreglochk"+submodulos[i]]
	    }

	   


	}