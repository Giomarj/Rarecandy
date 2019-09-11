<?php
session_start();
    include "clases/fun_aux_menu.php";
	include_once "clases/conexion.php";
	include_once "clases/fechas.php";
	include_once "clases/seguridad.php";
	include_once "clases/paginacion_intranet.php";
	include_once "clases/cliente.php";	
	include_once "clases/provincia.php";
	include_once "clases/bib_emailBoletin.php";
	include_once "clases/fun_correo_intranet.php";

	Seguridad();
	Admin();

	$cliente = new cliente();
	$conexion = new conexion();
	$provincia = new provincia();
	
	
	if (isset($_GET['codPK']) || isset($_POST['codPK']))
	{
		if (isset($_GET['codPK']))
			$codPK=$_GET['codPK'];
		
		if (isset($_POST['codPK']))
			$codPK=$_POST['codPK'];
	}
	else
	{
		print("<script>document.location.href='index.php'</script>");
		exit();
	}
	
	
	$provincia_procedeFK_buscar=0;
	
	if(isset($_GET['provincia_procedeFK']) && trim($_GET['provincia_procedeFK'])!="")
		$provincia_procedeFK_buscar=$_GET['provincia_procedeFK'];
	
	$nombre_cliente_buscar="";

	if(isset($_GET['nombre_cliente']))
		$nombre_cliente_buscar=$_GET['nombre_cliente'];
		
	$estado_busqueda="Activo";
	if(isset($_GET['estado_busqueda']))
		$estado_busqueda=$_GET['estado_busqueda'];
		
	$parametros_busqueda="";
			
	$parametros_busqueda=$parametros_busqueda . "&estado_busqueda=".$estado_busqueda;
	
	if(trim($provincia_procedeFK_buscar)!=0)
	    $parametros_busqueda=$parametros_busqueda . "&provincia_procedeFK=".$provincia_procedeFK_buscar;			
	
	if(trim($nombre_cliente_buscar)!="")
	    $parametros_busqueda=$parametros_busqueda . "&nombre_cliente_buscar=".$nombre_cliente_buscar;
	
	if(isset($_GET['pg']))
	    $parametros_busqueda=$parametros_busqueda . "&pg=".$_GET['pg'];
	
	
	
	$sqlDatos="SELECT * FROM cliente
		WHERE cliente_CodPK=".$codPK;
	$resDatos=$conexion->BD_Consulta($sqlDatos);
	$vectorDatos=$conexion->BD_GetTupla($resDatos);
	
	if($vectorDatos==NULL)
	{
		print("<script>document.location.href='inicio-logado.php'</script>");
		exit();
	}
	
	$cliente_Nombre=$vectorDatos['cliente_Nombre'];
	$cliente_DNI=$vectorDatos['cliente_DNI'];
	$cliente_Direccion=$vectorDatos['cliente_Direccion'];
	$cliente_Numero=$vectorDatos['cliente_Numero'];
	$cliente_Portal=$vectorDatos['cliente_Portal'];
	$cliente_Piso=$vectorDatos['cliente_Piso'];
	$cliente_Letra=$vectorDatos['cliente_Letra'];
	$cliente_CodigoPostal=$vectorDatos['cliente_CodigoPostal'];
	$cliente_ProvinciaFK=$vectorDatos['cliente_ProvinciaFK'];
	$cliente_Poblacion=$vectorDatos['cliente_Poblacion'];
	$cliente_Movil=$vectorDatos['cliente_Movil'];
	$cliente_Email=$vectorDatos['cliente_Email'];
	$cliente_Email2=$vectorDatos['cliente_Email2'];
	$cliente_Telefono=$vectorDatos['cliente_Telefono'];
	$cliente_ComentariosOtraInformacion=$vectorDatos['cliente_ComentariosOtraInformacion'];	
	$cliente_Login=$vectorDatos['cliente_Login'];
	$cliente_Pass=$vectorDatos['cliente_Pass'];
	$cliente_TipoFK=$vectorDatos['cliente_TipoFK'];
	
	
	$from="info@saltotech.com";
	
	//modificacion datos de acceso
	if(isset($_POST['aux']))
	{
		$errores="";
		
		$pass=str_replace("'","\"",$_POST['pass']);		
		$login=str_replace("'","\"",$_POST['login']);
		
		if(trim($pass)=="")
			$errores = $errores . "El campo pass no puede ser vacio.";
		if(trim($login)=="")
			$errores = $errores . "El campo login no puede ser vacio.";
			
		//vemos si hay clientes con el mismo login		
		$condicionDatos="WHERE cliente_Login='".$login."' AND cliente_CodPK!=" . $codPK;
		$orderDatos="";

		$resDatos=$cliente->obtenerConFiltro($condicionDatos,$orderDatos);
		$vectorDatos=$cliente->conexion->BD_GetTupla($resDatos);
		
		if($vectorDatos!=NULL)
			$errores = $errores . "El campo login esta repetido.";
			
		if(trim($errores)=="")
		{
			$cliente->modificarLogin($login, $codPK);
			$cliente->modificarPass($pass, $codPK);
			
			/*//envio del email al cliente notificando que se han modificado los datos de acceso
			$direccionMail=$cliente_Email;						
			
			if($cliente_TipoFK==1)
			{
				$asunto=utf8_decode($vectorDatos['tipo_Nombre'] . " .- Modificacion de claves");
			
				$ficheroAEnviar="";// va con un enlace al ser un boletin
				$nombreAMostrar="";			
		
				$mensaje="Claves del su usuario.";
				$cuerpo =correoModificacion($vectorDatos['tipo_CodPK'],$cliente_Nombre, $mensaje); //esta en fun_correo			
				
				//print($cuerpo);
				$envio= email($direccionMail,$from,$asunto,$cuerpo,$ficheroAEnviar,$nombreAMostrar);
			}//fin del if($cliente_TipoFK==1)*/
			
			$cliente_Pass=$pass;
			$cliente_Login=$login;
		}//fin del if(trim($errores)!="")
	}//fin del if(isset($_POST['aux']))
	
	if(isset($_POST['aux_claves']))
	{
		$errores="";
				
		$email_envio=str_replace("'","\"",$_POST['email_envio']);
		
		if(trim($email_envio)=="")
			$errores = $errores . "El email de envio no puede ser vacio.";
			
		if(trim($errores)=="")
		{	
			$direccionMail=$email_envio;						
			
			$asunto=utf8_decode("Saltotech .- Envio de Claves de Saltotech");
			
			$ficheroAEnviar="";// va con un enlace al ser un boletin
			$nombreAMostrar="";			
		
			$cuerpo =correoEnvioClaves($cliente_Nombre, $cliente_Login, $cliente_Pass);  //esta en fun_correo
				
			$envio= email($direccionMail,$from,$asunto,$cuerpo,$ficheroAEnviar,$nombreAMostrar);
			//print($cuerpo);
		}//fin del if(trim($errores)!="")
	}//fin del if(isset($_POST['aux_claves']))
?>
<!DOCTYPE html>
<html>
<head>
<?php require "./layout/header.php"; ?>
        <link href="css/reset.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <script src="js.js" type="text/javascript"></script>
</head>
<body class="home page-template-default page page-id-9 custom-background wp-custom-logo">
	<header id="home" class="header" itemscope="itemscope" itemtype="http://schema.org/WPHeader">
	<?php require "./layout/nav_logado.php"; ?>
	</header>
<div id="content" class="site-content">
		<div class="container">
		  <div class="row">
		    <div class="col-md-2 menul3">
				<?php require "./layout/menu_izq.php"; ?>
		    </div>
		    <div class="col-md-10 contenido">
		      






         <div id="derecha">
        
           <div class="modulo_basico">
           <span class="titulo">Cliente: <?PHP print($cliente_Nombre . " | " . $cliente_DNI);?></span>

           
             
           <ul class="tabs">
                    <?PHP /*<li><a href="cliente_estado_beca.php?codPK=<?PHP print($codPK);?>"><img src="images/i_estado_beca.png" class="icono_tab" />Estado de su beca</a></li> */ ?>
                    <li><a href="cliente_datos_contacto.php?codPK=<?PHP print($codPK . $parametros_busqueda);?>"><i class="fa fa-address-card" aria-hidden="true" style="padding-right: 5px;"></i>Datos contacto</a></li>
                    <li  class="active"><a href="cliente_datos_acceso.php?codPK=<?PHP print($codPK . $parametros_busqueda);?>"><i class="fa fa-share" aria-hidden="true" style="padding-right: 5px;"></i>Datos acceso</a></li>
                    <?PHP /*<li><a href="cliente_cursos.php?codPK=<?PHP print($codPK);?>"><img src="images/i_curso.png" class="icono_tab"/>Cursos</a></li> */ ?>
                    <?PHP /*<li><a href="cliente_cobros.php?codPK=<?PHP print($codPK);?>"><img src="images/i_cobreo.png" class="icono_tab"/> Cobros</a></li> */ ?>
                    <?PHP /*<li><a href="cliente_documentacion.php?codPK=<?PHP print($codPK);?>"><img src="images/i_docu.png" class="icono_tab"/>Documentación requerida </a></li> */ ?>
	   </ul>
    		<div class="tab_container">
        	<div style="display: block;" id="tab1" class="tab_content">
            
	    <form class="form" name="form_add_claves" id="form_add_claves" method="post" action="cliente_datos_acceso.php?codPK=<?PHP print($codPK . $parametros_busqueda);?>" style="clear:both" enctype="multipart/form-data">
		<input type="hidden" name="aux_claves" id="aux_claves" />
		
		<div class="item">
		<label for="nombre" class="label">Email Envio</label>
		<input type="text" class="input" name="email_envio" id="email_envio" value="<?PHP print($cliente_Email);?>" />
		<span class="explicacion">Email al que se enviaran las claves del cliente</span>
		</div>
		
		<a class="submit buscar" href="#" title="Enviar claves Email" style="clear:none !important; float:right !important" onclick="cliente_enviar_datos_acceso();"><span>Enviar claves Email</span></a>
	    </form>
	    
	    
	    
	    <form class="form" name="form_add_extranet" id="form_add_extranet" target="_blank" method="post" action="login.php" style="clear:both" enctype="multipart/form-data">
		<input type="hidden" name="username-salto" id="username-salto" value="<?PHP print($cliente_Login);?>" />
		<input type="hidden" name="password-salto" id="password-salto" value="<?PHP print($cliente_Pass);?>" />
			
			<a class="submit buscar" href="#" title="Acceso Extranet" style="clear:none !important; float:right !important" onclick="document.form_add_extranet.submit();"><span>Acceso Extranet</span></a>
	    </form>
	    
	     <br /><br /><br /><br /><br /><br /><br />
	    
            
	    
            <form class="form" name="form_add" id="form_add" method="post" action="cliente_datos_acceso.php?codPK=<?PHP print($codPK . $parametros_busqueda);?>" style="clear:both" enctype="multipart/form-data">
		<input type="hidden" name="aux" id="aux" />
		
            <div class="item">
            <label class="label">Usuario</label><input name="login" id="login" type="text" class="input" value="<?PHP print($cliente_Login);?>"  />
            </div>
	    
            <div class="item">
            <label class="label">Contraseña</label><input type="text" class="input" name="pass" id="pass" value="<?PHP print($cliente_Pass);?>" />
	    <span class="explicacion">Debe tener mas de 4 caracteres</span>
            </div>
           
            
            
            <div class="item">
            <a class="submit buscar" href="#" title="Modificar Datos Acceso" onclick="cliente_modificar_datos_acceso();"><span>Modificar</span></a>
	    <span class="explicacion">Al modificar los datos nunca se enviara un mail.<!--, se le enviara un mail al cliente solo si es de Tipo Saltotech.--></span>
	    </div>
            </form>
		
		<?PHP
		if($cliente_TipoFK>1)
		{
			//si es de tipo caratula diferente a saltotech

				print("<br /><br /><br /><br /><br /><br /><br />
				<p>Datos acceso login unico: <strong>http://www.saltotech.com/login.php?tipoFK=2&username-salto=" . $cliente_Login . "&password-salto=" . $cliente_Pass . "</strong></p>");
		}//fin del if($cliente_TipoFK>1)
		?>
          
        	</div>
       		
                    
            
           </div>
           <!-- acaba mideel contenido gris--></div>
           <!-- acaba derecha--></div>








		    </div>
		  </div>
		</div>

</div>

<?php require "./layout/footer.php"; ?>
</body>
</html>
<?PHP
	if(isset($_POST['aux']))
	{
		if(trim($errores)!="")
		{
			print("<script>ventana_nn('ventana_mensaje.php?cadena=" . $errores . "');</script>");
		}//fin del if(trim($errores)!="")
		else
		{
			$cadena="Se ha modificado la informacion correctamente.";
			print("<script>ventana_nn('ventana_mensaje.php?cadena=" . $cadena . "');</script>");
		}//fin del else del  if(trim($errores)!="")
	}//fin del if(isset($_POST['aux']))	
?>