<?PHP
	session_start();
	
	include_once "clases/conexion.php";
	include_once "clases/fechas.php";
	include_once "clases/fun_aux_menu.php";
	include_once "clases/seguridad.php";
	include_once "clases/paginacion_intranet.php";
	include_once "clases/cliente.php";
	include_once "clases/provincia.php";
	
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
	
	
	
	//enviamos los datos
	if(isset($_POST['aux']))
	{
		$errores = "";
		
		$nombre=str_replace("'","\"",$_POST['nombre']);
		$dni=str_replace("'","\"",$_POST['dni']);
		$direccion=str_replace("'","\"",$_POST['direccion']);
		$numero=str_replace("'","\"",$_POST['numero']);
		$portal=str_replace("'","\"",$_POST['portal']);
		$piso=str_replace("'","\"",$_POST['piso']);
		$letra=str_replace("'","\"",$_POST['letra']);
		$cp=str_replace("'","\"",$_POST['cp']);
		$provinciaFK=str_replace("'","\"",$_POST['provinciaFK']);
		$poblacion=str_replace("'","\"",$_POST['poblacion']);
		$movil=str_replace("'","\"",$_POST['movil']);
		$email=str_replace("'","\"",$_POST['email']);		
		$email2=str_replace("'","\"",$_POST['email2']);
		$telefono_urgencia=str_replace("'","\"",$_POST['telefono_urgencia']);

		$comentarios_otra_informacion=str_replace("'","\"",$_POST['comentarios_otra_informacion']);
		$cliente_Estado=str_replace("'","\"",$_POST['cliente_Estado']);
		
		$foto=$_FILES['foto']['name'];
		$imagen_ant=$_POST['imagen_ant'];
		
		//vemos si hay clientes con el mismo dni o con el mismo nie
		//PETICION DE SERGIO DIA 25/06/2015
		/*$condicionDatos="WHERE cliente_DNI='".$dni."' AND cliente_CodPK!=" . $codPK;
		$orderDatos="";

		$resDatos=$cliente->obtenerConFiltro($condicionDatos,$orderDatos);
		$vectorDatos=$cliente->conexion->BD_GetTupla($resDatos);
		
		if($vectorDatos!=NULL)
			$errores=$errores . "Ya existe un cliente dado de alta con el mismo DNI, CIF.";*/
		
		if(trim($nombre)=="")
			$errores = $errores . "El campo nombre no puede estar vacio. <br />";
		if(trim($dni)=="")
			$errores = $errores . "El campo DNI,CIF no puede estar vacio. <br />";	
		if(trim($direccion)=="")
			$errores = $errores . "El campo direccion no puede estar vacio. <br />";
		if(trim($numero)=="")
			$errores = $errores . "El campo numero no puede estar vacio. <br />";
		if(trim($cp)=="")
			$errores = $errores . "El campo cp no puede estar vacio. <br />";
		if(trim($provinciaFK)=="")
			$errores = $errores . "El campo provincia no puede estar vacio. <br />";
		if(trim($poblacion)=="")
			$errores = $errores . "El campo poblacion no puede estar vacio. <br />";
		if(trim($movil)=="")
			$errores = $errores . "El campo movil no puede estar vacio. <br />";
		if(trim($email)=="")
			$errores = $errores . "El campo email no puede estar vacio. <br />";
			
			
			
		if(trim($errores)=="")
		{			

			$cliente->modificar($nombre, $dni, $direccion, $numero, $portal, $piso, $letra, $cp, $provinciaFK, $poblacion, $movil, $email, $email2, $telefono_urgencia, $comentarios_otra_informacion, $cliente_Estado, $codPK);
				
			
			//Archivo
			if (trim($_FILES['foto']['name'])!="")
			{
				$separado = explode(".",$foto); 
				$ext1 = strtolower($separado[count($separado)-1]); //cogemos la extension (ya en minusculas) 					
			
				$foto=$cliente->subirImagen($_FILES['foto']['tmp_name'],$codPK,$ext1);
				
				$cliente->modificarLogo($foto, $codPK);
			}
			
			if (trim($_FILES['foto']['name'])!="" && trim($imagen_ant)!="")
				$cliente->eliminarImagen($imagen_ant);
			
		
		}//fin del if(trim($errores)!="")	
		
	}//fin dl if(isset($_POST['aux']))
	
	
	$condicionDatos=" WHERE cliente_CodPK=".$codPK;
	$orderDatos="";

	$resDatos=$cliente->obtenerConFiltro($condicionDatos,$orderDatos);
	$vectorDatos=$cliente->conexion->BD_GetTupla($resDatos);
	
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
	$imagen_ant=$vectorDatos['cliente_Logo'];
	$cliente_Estado=$vectorDatos['cliente_Estado'];


	if(isset($_GET['borrar_imagen']) && trim($_GET['borrar_imagen'])!="")
	{	
		$nombreFichero = "img/cliente/" . $imagen_ant;
		unlink ($nombreFichero);
				
		$imagen_ant="";
				
		$cliente->modificarLogo($imagen_ant, $codPK);
	}//fin del if(isset($_GET['borrar_imagen']) && trim($_GET['borrar_imagen'])!="")
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
                    <?PHP /*<li><a href="cliente_estado_beca.php?codPK=<?PHP print($codPK . $parametros_busqueda);?>"><img src="images/i_estado_beca.png" class="icono_tab" />Estado de su beca</a></li> */ ?>
                    <li class="active"><a href="cliente_datos_contacto.php?codPK=<?PHP print($codPK . $parametros_busqueda);?>"><i class="fa fa-address-card" aria-hidden="true" style="padding-right: 5px;"></i>Datos contacto</a></li>
                    <li><a href="cliente_datos_acceso.php?codPK=<?PHP print($codPK . $parametros_busqueda);?>"><i class="fa fa-share" aria-hidden="true" style="padding-right: 5px;"></i>Datos acceso</a></li>
 <!--                    <li><a href="cliente_la_bien_paga.php?codPK=<?PHP print($codPK . $parametros_busqueda);?>"><img src="images/i_cobreo.png" class="icono_tab"/>La Bien Paga</a></li> -->
                    <?PHP /*<li><a href="cliente_cobros.php?codPK=<?PHP print($codPK . $parametros_busqueda);?>"><img src="images/i_cobreo.png" class="icono_tab"/> Cobros</a></li> */ ?>
                    <?PHP /*<li><a href="cliente_documentacion.php?codPK=<?PHP print($codPK . $parametros_busqueda);?>"><img src="images/i_docu.png" class="icono_tab"/>Documentación requerida </a></li> */ ?>
		</ul>
    		<div class="tab_container">
        	<div style="display: block;" id="tab1" class="tab_content">
			
		<form class="form" name="pedido_form" id="pedido_form" method="post" action="cliente_datos_contacto.php?codPK=<?PHP print($codPK . $parametros_busqueda);?>" style="clear:both" enctype="multipart/form-data">
		<input type="hidden" name="aux" id="aux" />
		<input type="hidden" name="imagen_ant" id="imagen_ant" value="<?PHP print($imagen_ant); ?>"/>
		
		<div class="item">
		<label for="nombre" class="label">* Nombre</label>
		<input type="text" class="input" name="nombre" id="nombre" value="<?PHP print($cliente_Nombre);?>" />
		</div>
		
		<div class="item file">			
		<label class="label">Logo</label><input type="file" class="input" name="foto" id="foto" />
		<?PHP
		if (trim($imagen_ant)!='')
		{
			print("<span class=\"explicacion\">
				<a href=\"../imagen/cliente/" . $imagen_ant . "\" target=\"blank\" >[Ver Imagen]</a>
				<a href=\"#\" onclick=\"if(confirm('Seguro que desea eliminar la imagen?'))document.location.href='cliente_datos_contacto.php?codPK=" . $codPK . "&borrar_imagen=" . $codPK . "'\">[Eliminar Imagen]</a>
			</span>");
		}
		?>
		<span class="explicacion">Peso máx. 24KB. Tamaño: 45px x45 px</span>
		</div>
		
		<div class="item peq2">
		<label for="dni" class="label peq2" >* DNI/CIF</label>
		<input type="text" class="input peq2" name="dni" id="dni" maxlength="9" value="<?PHP print($cliente_DNI);?>" />
		</div>
		
		<div class="item direccion" >
		<label for="direccion" class="label ">* Direcci&oacute;n</label>
		<input type="text" class="input direccion" name="direccion" id="direccion" value="<?PHP print($cliente_Direccion);?>" /><!-- value="Direccion" onfocus="this.value=''" />-->
		</div>
		
		<div class="item peq">
		<label for="numero" class="label  peq">* Numero</label>
		<input type="text" class="input peq" name="numero" id="numero" value="<?PHP print($cliente_Numero);?>" /><!--value="Numero" onfocus="this.value=''" />-->
		</div>
		
		<div class="item peq">
		<label for="portal" class="label peq">Portal</label>
		<input type="text" class="input peq" name="portal" id="portal" value="<?PHP print($cliente_Portal);?>" />
		</div>
		
		<div class="item peq">
		<label for="piso" class="label  peq">Piso</label>
		<input type="text" class="input peq" name="piso" id="piso" value="<?PHP print($cliente_Piso);?>" />
		</div>
		
		<div class="item peq">
		<div >
		<label for="letra" class="label peq">Letra </label>
		<input type="text" class="input peq" name="letra" id="letra" value="<?PHP print($cliente_Letra);?>"/>
		</div>
		</div>
		
		<div class="item peq2">         
		<label for="cp" class="label ">* Código Postal</label>
		<input type="text" class="input peq" name="cp" id="cp" value="<?PHP print($cliente_CodigoPostal);?>" />     
		</div>
		
		<div class="item">
		<label for="provinciaFK" class="label">* Provincia</label>
		<select class="select" name="provinciaFK" id="provinciaFK">
		<?PHP
			$condicionProv="";
			$orderProv="ORDER BY provincia_Nombre";
		
			$resProv=$provincia->obtenerConFiltro($condicionProv,$orderProv);
			$vectorProv=$provincia->conexion->BD_GetTupla($resProv);
			
			while($vectorProv!=NULL)
			{
				if($cliente_ProvinciaFK==$vectorProv['provincia_CodPK'])
					print("<option selected=\"selected\" value=\"" . $vectorProv['provincia_CodPK'] . "\">" . $vectorProv['provincia_Nombre'] . ", ".$vectorProv['pais']."</option>");
				else
					print("<option value=\"" . $vectorProv['provincia_CodPK'] . "\">" . $vectorProv['provincia_Nombre'] . "</option>");
					
					
				$vectorProv=$provincia->conexion->BD_GetTupla($resProv);
			}//fin del while($vectorProv!=NULL)
		?>
		</select>
		</div>
		
		<div class="item">	 
		<label for="poblacion" class="label">* Poblacion</label>
		<input type="text" class="input" name="poblacion" id="poblacion" value="<?PHP print($cliente_Poblacion);?>" />
		</div>
		
		<div class="item">
		<label for="movil" class="label">* Móvil</label>
		<input type="text" class="input" name="movil" id="movil"  value="<?PHP print($cliente_Movil);?>" />
		</div>
		
		<div class="item">
	 	<label for="email" class="label">* Email 1</label>
		<input type="text" class="input" name="email" id="email" value="<?PHP print($cliente_Email);?>" />
		</div>
		
		<div class="item">
	 	<label for="email_repe" class="label">* Repetir Email 1</label>
		<input type="text" class="input" name="email_repe" id="email_repe" value="<?PHP print($cliente_Email);?>" />
		</div>
		
		<div class="item">
		<label for="email2" class="label">Email 2</label>
		<input type="text" class="input" name="email2" id="email2" value="<?PHP print($cliente_Email2);?>" /> 
		</div>
		
		<div style="clear: both"></div>
		
		<div class="item" >
		<label for="cliente_Estado" class="label">Estado</label>
		<select class="select" name="cliente_Estado" id="cliente_Estado">
		<?PHP
		if(strcmp($cliente_Estado,"Activo")==0)
			print("<option value=\"Activo\" selected=\"selected\">Activo</option>");
		else
			print("<option value=\"Activo\">Activo</option>");
			
		if(strcmp($cliente_Estado,"No_Activo")==0)
			print("<option value=\"No_Activo\" selected=\"selected\">No Activo</option>");
		else
			print("<option value=\"No_Activo\">No Activo</option>");
		?>
		</select>
		<span class="explicacion">En caso de ser No Activo, no podra acceder a la aplicación.</span>
		</div>
		
		<div class="item" >
		<label for="telefono_urgencia" class="label" style="width:400px">Otros Telefonos</label>
		<input type="text" class="input" name="telefono_urgencia" id="telefono_urgencia"  value="<?PHP print($cliente_Telefono);?>" />
		</div>
		
		<div style=" clear: both"></div>
			
		<h2 class=" titulo2">Otra información</h2>
		        
		<div class="item grande" >
		<label for="comentarios_otra_informacion" class="label">Comentarios:</label>
		<textarea class="textareagrande" style="font-size:12px; padding-left: 7px" name="comentarios_otra_informacion" id="comentarios_otra_informacion"><?PHP print($cliente_ComentariosOtraInformacion);?></textarea>
		</div>
		
		<div style=" clear: both"><br /><br /></div>
				
		
		<a class="submit buscar" href="#" title="Modificar Datos" onclick="cliente_anadir();"><span>Modificar</span></a>
		
		
		
            </form>
          
        	</div>
       		
		<a href="clientes.php?ruta=1<?PHP print($parametros_busqueda);?>" class="submit buscar" style="float: left;">Atrás</a>      
            
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