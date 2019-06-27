function enviar_form_responder()
{	
    if(document.form_responder.respuesta.value=='')
    {	
	alert("El campo Respuesta es obligatorio.");		
	document.form_responder.respuesta.focus();
    }
    else
    {
	document.form_responder.submit();
    }
}//fin del function enviar_form_responder()

function envio_nueva_consulta()
{	
    if(document.form_consulta.consulta.value=='')
    {	
	alert("El campo Consulta es obligatorio.");		
	document.form_consulta.consulta.focus();
    }
    else
    {
	document.form_consulta.submit();
    }
}//fin del function envio_nueva_consulta()

function comprobar_ContactaXXXXXXXX()
{
    if(document.contacto_form.nombre.value=='')
    {	
        alert("El campo Nombre debe estar relleno.");
        document.contacto_form.nombre.focus();
    }
    else if(document.contacto_form.telefono.value=='')
    {	
        alert("El campo Telefono debe estar relleno.");		
        document.contacto_form.telefono.focus();
    }
    else if(!correcto_email(document.contacto_form.email.value))
    {	
        alert("El campo Email no es correcto.");		
        document.contacto_form.email.focus();
    }	
    else if(document.contacto_form.comentario.value=='')
    {	
        alert("El campo Comentario debe estar relleno.");		
        document.contacto_form.comentario.focus();
    }
    else if(document.contacto_form.validador_suma.value=='')
    {	
        alert("El campo Suma debe estar relleno.");		
        document.contacto_form.validador_suma.focus();
    }
    else if(document.contacto_form.checkbox.checked==0)	   
    {
        alert("Debe aceptar la Politica de privacidad.");		
    }
    else
    {
        document.contacto_form.submit();						
    }
}//fin del function comprobar_Contacta()

function correcto_email(emailIntro)
{ 
	var separateEmailsBy = ", "; 
	var email = "<none>"; // if no match, use this 
	var emailsArray = emailIntro.match(/([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9._-]+)/gi); 
	
	if (emailsArray) 
	{ 
		email = ""; 
		
		for (var i = 0; i < emailsArray.length; i++) 
		{ 
			if (i != 0) email += separateEmailsBy; 
			email += emailsArray[i]; 
		  } 
	} 
	
	if(emailIntro==email)
		return true;
	else
		return false;
}

function caracteres_Solo_Numeros(e)
{
	var charCode
	
	if (navigator.appName == "Netscape") // me fijo 
	charCode = e.which // leo la tecla en ASCII que ingreso
	else
	charCode = e.keyCode // leo la tecla en ASCII que ingreso
	
	//caracteres que vamos a prohibir:
	//aquellos que su charCode sea menor que 128, es decir: ñ, Ñ, ó, Ó , ....
	
	if( !( (charCode>=48 && charCode <=57) || (charCode==8) || (charCode==9) || (charCode==0) ||  (charCode==11) || (charCode==127)))
	{
		alert(" El caracter que ha intentado introducir esta prohibido. Debe anadir solo numeros. ")		
		
		window.event.keyCode=0
		
		return false				
	}
	
	return true
}