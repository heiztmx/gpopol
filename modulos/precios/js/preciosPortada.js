 function DesplegarPrecios(datosEstacion){

cadena = datosEstacion;
limitador="||";
SubDatos = cadena.split(limitador);


swal({
    title: "Precios Aplicados "+SubDatos[0],
    text: "Fecha:"+SubDatos[5]+"\n "
+"Magna:"+SubDatos[2]+"\n "+
"Premium:"+SubDatos[3]+"\n "+
"Diesel:"+SubDatos[4],
    icon: SubDatos[1],
  });

}

 
  
