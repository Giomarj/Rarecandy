function comprobar_informe_impagos()
{	
	if(document.form_add_impagos.fecha_inicio.value=='')
	{	
		alert("El campo Fecha Inicio es obligatorio.");		
		document.form_add_impagos.fecha_inicio.focus();
	}
	else if(document.form_add_impagos.fecha_fin.value=='')
	{	
		alert("El campo Fecha Fin es obligatorio.");		
		document.form_add_impagos.fecha_fin.focus();
	}	
	else
	{
		document.form_add_impagos.submit();							
	}
}//fin del function comprobar_informe_impagos()
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
function comprobar_informe_vencimientos_futuros()
{	
	if(document.form_add_vencimientos_futuros.fecha_inicio.value=='')
	{	
		alert("El campo Fecha Inicio es obligatorio.");		
		document.form_add_vencimientos_futuros.fecha_inicio.focus();
	}
	else if(document.form_add_vencimientos_futuros.fecha_fin.value=='')
	{	
		alert("El campo Fecha Fin es obligatorio.");		
		document.form_add_vencimientos_futuros.fecha_fin.focus();
	}	
	else
	{
		document.form_add_vencimientos_futuros.submit();							
	}
}//fin del function comprobar_informe_vencimientos_futuros()

function comprobar_informe_ventas()
{	
	if(document.form_add_ventas.fecha_inicio.value=='')
	{	
		alert("El campo Fecha Inicio es obligatorio.");		
		document.form_add_ventas.fecha_inicio.focus();
	}
	else if(document.form_add_ventas.fecha_fin.value=='')
	{	
		alert("El campo Fecha Fin es obligatorio.");		
		document.form_add_ventas.fecha_fin.focus();
	}	
	else
	{
		document.form_add_ventas.submit();							
	}
}//fin del function comprobar_informe_ventas()


function comprobar_cliente_tipo()
{	
	if(document.form_add.titulo.value=='')
	{	
		alert("El campo Titulo es obligatorio.");		
		document.form_add.titulo.focus();
	}
	else if(document.form_add.hoja_estilo.value=='')
	{	
		alert("El campo Hoja de Estilo es obligatorio.");		
		document.form_add.hoja_estilo.focus();
	}
	else if(document.form_add.email.value=='')
	{	
		alert("El campo Email de Envio es obligatorio.");		
		document.form_add.email.focus();
	}
	else
	{
		document.form_add.submit();							
	}
}//fin del function comprobar_cliente_tipo()

function soloNumeros(e)
{
	var key = window.Event ? e.which : e.keyCode
	return (key <= 13 || (key >= 48 && key <= 57) || key==46);
}

function comprobar_anadir_pago()
{
	if(document.form_anadir_pago.importe.value=='')
	{	
		alert("El campo Importe es obligatorio.");		
	}
	else
	{
		document.form_anadir_pago.submit();							
	}
}
function comprobarFechaArchivo()
{	
	if(document.form_add.archivo.value=='')
	{	
		alert("El campo Archivo es obligatorio.");		
	}
	else
	{
		document.form_add.submit();							
	}
}//fin del function comprobarFechaArchivo()

function comprobar_informe_grupo_clientes_acceso()
{	
	if(document.form_add_grupo_cliente.fecha_inicio.value=='')
	{	
		alert("El campo Fecha Inicio es obligatorio.");		
		document.form_add_grupo_cliente.fecha_inicio.focus();
	}
	else if(document.form_add_grupo_cliente.fecha_fin.value=='')
	{	
		alert("El campo Fecha Fin es obligatorio.");		
		document.form_add_grupo_cliente.fecha_fin.focus();
	}	
	else
	{
		document.form_add_grupo_cliente.submit();							
	}
}//fin del function comprobar_informe_grupo_clientes_acceso()

function comprobar_informe_acceso()
{	
	if(document.form_add_acceso.fecha_inicio.value=='')
	{	
		alert("El campo Fecha Inicio es obligatorio.");		
		document.form_add_acceso.fecha_inicio.focus();
	}
	else if(document.form_add_acceso.fecha_fin.value=='')
	{	
		alert("El campo Fecha Fin es obligatorio.");		
		document.form_add_acceso.fecha_fin.focus();
	}	
	else
	{
		document.form_add_acceso.submit();							
	}
}//fin del function comprobar_informe_acceso()

function comprobar_informe_clientes()
{	
	if(document.form_add.fecha_inicio.value=='')
	{	
		alert("El campo Fecha Inicio es obligatorio.");		
		document.form_add.fecha_inicio.focus();
	}
	else if(document.form_add.fecha_fin.value=='')
	{	
		alert("El campo Fecha Fin es obligatorio.");		
		document.form_add.fecha_fin.focus();
	}	
	else
	{
		document.form_add.submit();							
	}
}//fin del function comprobar_informe_clientes()

function comprobar_paquete_anadir_documentacion()
{	
	if(document.form_add.titulo.value=='')
	{	
		alert("El campo Titulo es obligatorio.");		
		document.form_add.titulo.focus();
	}
	else
	{
		document.form_add.submit();							
	}
}//fin del function comprobar_paquete_anadir_documentacion()

function cliente_insertar_saldo_bien_paga()
{	
	if(document.form_add_saldo.saldo_envio.value=='')
	{	
		alert("El campo Email es obligatorio.");		
		document.form_add_saldo.saldo_envio.focus();
	}
	else
	{
		document.form_add_saldo.submit();							
	}
}//fin del function cliente_insertar_saldo_bien_paga()

function cliente_enviar_datos_acceso()
{	
	if(document.form_add_claves.email_envio.value=='')
	{	
		alert("El campo Email es obligatorio.");		
		document.form_add_claves.email_envio.focus();
	}
	else if(!correcto_email(document.form_add_claves.email_envio.value))
	{	
		alert("El campo E-mail no es correcto.");			
		document.form_add_claves.email_envio.focus();
	}
	else
	{
		document.form_add_claves.submit();							
	}
}//fin del function cliente_enviar_datos_acceso()

function comprobar_paquete_anadir_seguro()
{	
	if(document.form_add.titulo.value=='')
	{	
		alert("El campo Titulo es obligatorio.");		
		document.form_add.titulo.focus();
	}
	else
	{
		document.form_add.submit();							
	}
}//fin del function comprobar_paquete_anadir_seguro()

function comprobar_paquete_anadir_fecha_new()
{	
	if(document.form_add.fecha.value=='')
	{	
		alert("El campo Fecha es obligatorio.");		
		document.form_add.fecha.focus();
	}
	else if(document.form_add.fecha_Fin.value=='')
	{	
		alert("El campo Fecha Fin es obligatorio.");		
		document.form_add.fecha_Fin.focus();
	}
	else
	{
		document.form_add.submit();							
	}
}//fin del function comprobar_paquete_anadir_fecha_new()

function comprobar_paquete_add()
{
	if(document.form_add.titulo.value=='')
	{	
		alert("El campo Titulo es obligatorio.");		
		document.form_add.titulo.focus();
	}
	else if (isNaN(parseFloat(document.form_add.precio_tasas.value))==true)
	{
		alert("El campo Precio Tasas debe ser de tipo numerico.");
		document.form_add.precio_tasas.focus();
	}	
	else if(document.form_add.fecha_inicio.value=='')
	{	
		alert("El campo Fecha de Inicio es obligatorio.");		
		document.form_add.fecha_inicio.focus();
	}
	else if(document.form_add.fecha_fin.value=='')
	{	
		alert("El campo Fecha de Fin es obligatorio.");		
		document.form_add.fecha_fin.focus();
	}
	else
	{
		document.form_add.submit();							
	}
}//fin del function comprobar_paquete_add()

function habitacion_anadir()
{	
	if(document.form_add.nombre.value=='')
	{	
		alert("El campo nombre es obligatorio.");		
		document.form_add.nombre.focus();
	}
	else
	{
		document.form_add.submit();							
	}
}//fin del function habitacion_anadir()

function comprobar_encuesta_campana()
{	
	if(document.form_add.titulo.value=='')
	{	
		alert("El campo Titulo es obligatorio.");		
		document.form_add.titulo.focus();
	}
	else if(document.form_add.fecha_inicio.value=='')
	{	
		alert("El campo Fecha de Inicio es obligatorio.");		
		document.form_add.fecha_inicio.focus();
	}
	else if(document.form_add.fecha_fin.value=='')
	{	
		alert("El campo Fecha de Fin es obligatorio.");		
		document.form_add.fecha_fin.focus();
	}
	else
	{
		document.form_add.submit();							
	}
}//fin del function comprobar_encuesta_campana()

function comprobar_paquete_compania()
{	
	if(document.form_add.titulo.value=='')
	{	
		alert("El campo Titulo es obligatorio.");		
		document.form_add.titulo.focus();
	}
	else
	{
		document.form_add.submit();							
	}
}//fin del function comprobar_paquete_compania()


function comprobar_promocion_icono()
{	
	if(document.form_add.titulo.value=='')
	{	
		alert("El campo Titulo es obligatorio.");		
		document.form_add.titulo.focus();
	}
	else
	{
		document.form_add.submit();							
	}
}//fin del function comprobar_promocion_icono()

function comprobar_caracteristica_icono()
{	
	if(document.form_add.titulo.value=='')
	{	
		alert("El campo Titulo es obligatorio.");		
		document.form_add.titulo.focus();
	}
	else
	{
		document.form_add.submit();							
	}
}//fin del function comprobar_caracteristica_icono()

function cliente_modificar_datos_acceso()
{	
	if(document.form_add.pass.value=='')
	{	
		alert("El campo Contrasena es obligatorio.");			
		document.form_add.pass.focus();
	}
	else if(document.form_add.pass.value.length<4)
	{	
		alert("El campo Contrasena debe tener como minimo 4 caracteres.");			
		document.form_add.pass.focus();
	}
	else
	{
		document.form_add.submit();							
	}
}//fin del function cliente_modificar_datos_acceso()

function cliente_anadir()
{	
	if(document.pedido_form.nombre.value=='')
	{	
		alert("El campo Nombre es obligatorio.");		
		document.pedido_form.nombre.focus();
	}	
	else if(document.pedido_form.dni.value=='')
	{	
		alert("El campo DNI, CIF es obligatorio.");		
		document.pedido_form.dni.focus();
	}
	else if(document.pedido_form.direccion.value=='')
	{	
		alert("El campo Direccion es obligatorio.");		
		document.pedido_form.direccion.focus();
	}
	else if(document.pedido_form.numero.value=='')
	{	
		alert("El campo Numero es obligatorio.");		
		document.pedido_form.numero.focus();
	}
	else if(document.pedido_form.cp.value=='')
	{	
		alert("El campo Codigo Postal es obligatorio.");		
		document.pedido_form.cp.focus();
	}			
	else if(document.pedido_form.poblacion.value=='')
	{	
		alert("El campo Poblacion es obligatorio.");		
		document.pedido_form.poblacion.focus();
	}
	else if(document.pedido_form.movil.value=='')
	{	
		alert("El campo Movil es obligatorio.");		
		document.pedido_form.movil.focus();
	}
	else if(document.pedido_form.email.value=='')
	{	
		alert("El campo Email es obligatorio.");		
		document.pedido_form.email.focus();
	}
	else if(!correcto_email(document.pedido_form.email.value))
	{	
		alert("El campo E-mail no es correcto.");			
		document.pedido_form.email.focus();
	}
	else if(document.pedido_form.email.value!=document.pedido_form.email_repe.value)
	{	
		alert("Los E-mails introducidos deben ser iguales.");		
		document.pedido_form.email.focus();
	}
	else if(document.pedido_form.email2.value!='' && !correcto_email(document.pedido_form.email2.value))
	{	
		alert("El campo Email2 no es correcto.");		
		document.pedido_form.email2.focus();
	}
	else
	{
		document.pedido_form.submit();
	}
}//fin del function cliente_anadir()

function comprobar_cliente_grupo()
{	
	if(document.form_add.titulo.value=='')
	{	
		alert("El campo Titulo es obligatorio.");		
		document.form_add.titulo.focus();
	}
	else
	{
		document.form_add.submit();							
	}
}//fin del function comprobar_cliente_grupo()

function usuario_anadir()
{	
	if(document.form_add.nombre.value=='')
	{	
		alert("El campo nombre es obligatorio.");		
		document.form_add.nombre.focus();
	}
	else if(document.form_add.user.value=='')
	{	
		alert("El campo Usuario es obligatorio.");		
		document.form_add.user.focus();
	}	
	else if(document.form_add.user.value.length<4)
	{	
		alert("El campo Usuario debe tener como minimo 4 caracteres.");			
		document.form_add.user.focus();
	}
	else if(document.form_add.pass.value=='')
	{	
		alert("El campo Contrasena es obligatorio.");			
		document.form_add.pass.focus();
	}
	else if(document.form_add.pass.value.length<4)
	{	
		alert("El campo Contrasena debe tener como minimo 4 caracteres.");			
		document.form_add.pass.focus();
	}
	else
	{
		document.form_add.submit();							
	}
}//fin del function usuario_anadir()

function comprobar_login()
{	
	if(document.login.username.value=='')
	{	
		alert("El campo Usuario es obligatorio.");		
		document.login.username.focus();
	}
	else if(document.login.password.value=='')
	{	
		alert("El campo Password es obligatorio.");		
		document.login.password.focus();
	}	
	else
	{
		document.login.submit();							
	}
}//fin del function comprobar_login()

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

function comprobar_dni(dni)
{
	if(dni=='')
	{
		return false;
	}//fin del if(dni=='')
	else
	{
		numero = dni.substr(0,dni.length-1);
		letraDNI = dni.substr(dni.length-1,1);
		numero = numero % 23;
		letra='TRWAGMYFPDXBNJZSQVHLCKET';
		letra=letra.substring(numero,numero+1);
		if (letra!=letraDNI)		
			return true;
		else
			return false;  
	} //fin del else del if(dni=='')
}//fin del function comprobar_dni(dni)

function validaNie(control) 
{	
	if (control.value=="")
		return false;	
 
	var a=control;		
	var temp=a.value.toUpperCase();
	var cadenadni="TRWAGMYFPDXBNJZSQVHLCKET";
	var v1 = new Array(0,2,4,6,8,1,3,5,7,9);
	var posicion=0;
	var letra=" ";
	
	//Residente en España	
	if (a.value.length==9)
	{
		if (temp.substr(0,1)=="X" || temp.substr(0,1)=="Y")
		{
			if(temp.substr(0,1)=="X")
				var temp1=temp.substr(1,7);
			else
				var temp1=parseInt(10000000) + parseInt(temp.substr(1,7));
 
			posicion = temp1 % 23; /*Resto de la division entre 23 es la posicion en la cadena*/
			letra = cadenadni.substring(posicion,posicion+1);
			if (!/^[A-Za-z0-9]{9}$/.test(temp))
			{ 
				return true;  
			}
			else
			{ 
				//Tiene los 9 dígitos, comprobamos si la letra esta bien
				if(temp.substr(0,1)=="X")
					var temp1=temp.substr(1,7);
				else
					var temp1=parseInt(10000000) + parseInt(temp.substr(1,7));
					
				posicion = temp1 % 23; /*Resto de la division entre 23 es la posicion en la cadena*/
				letra = cadenadni.charAt(posicion);
				var letranie=temp.charAt(8);
				if (letra != letranie){			
					return true;  		
				}				
			}
		}
		else
		{
			return true;  		
		}		
	}else if (a.value.length==14){//14 caracteres, los 2 primeros letras
		var temp1=temp.substr(0,2);
		if (isAlphabetic(temp1)!=true)	
			{
			return true;  	
			}
	}
	else
	{
			return true;  			
 
	}
	
	return false;	
	
}