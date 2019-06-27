<?PHP
    ini_set("session.cookie_lifetime","7200");
    ini_set("session.gc_maxlifetime","7200");
    
    session_start();
    
    include_once "/clases/conexion.php";
    include_once "/clases/fechas.php";
    include_once "/clases/seguridad.php";
    include_once "/clases/fun_aux_menu.php";
    include_once "/clases/paginacion_intranet.php";
    include_once "/clases/cliente_incidencia_web.php";
    include_once "/clases/cliente_incidencia_respuesta_web.php";
    include_once "/clases/bib_emailBoletin.php";
    include_once "/clases/fun_correo_intranet.php";
    include_once "/clases/cliente.php";
	    
    Seguridad();
    Admin();
    
    $cliente_incidencia_web = new cliente_incidencia_web();
    $cliente_incidencia_respuesta_web = new cliente_incidencia_respuesta_web();
    $conexion = new conexion();
    $paginacion = new paginacion_intranet();
    $cliente = new cliente();
	    
    $sql="SELECT * FROM cliente WHERE cliente_Login='".$_SESSION['usuario_salto']."' AND cliente_Pass='".$_SESSION['password_salto']."' AND cliente_Estado='Activo'";
    $res=$conexion->BD_Consulta($sql);
    $vector=$conexion->BD_GetTupla($res);


    if($vector==NULL)
    {
	print("<script>document.location.href='inicio-logado.php'</script>");
	exit();
    }
	
    if (isset($_GET['codPK']) || isset($_POST['codPK']))
    {
	if (isset($_GET['codPK']))
	    $codPK=$_GET['codPK'];
	
	if (isset($_POST['codPK']))
	    $codPK=$_POST['codPK'];
    }
    else
    {
	print("<script>document.location.href='inicio-logado.php'</script>");
	exit();
    }
    
    
    $errores="";
    $usuario_logueadoFK=$vector['cliente_CodPK'];
    
    if(isset($_GET['leido']))
    {
	$consulta="UPDATE cliente_incidencia_web SET incidencia_Leido='Si' WHERE incidencia_CodPK=" . $codPK;
	$res=$conexion->BD_Consulta($consulta);
    }//fin del if(isset($_GET['leido']))
    
    if(isset($_GET['cerrar']))
    {
	$consulta="UPDATE cliente_incidencia_web SET incidencia_Estado='Cerrado', incidencia_Leido='Si', incidencia_FechaCierre='" . date("Y-m-d") . "' WHERE incidencia_CodPK=" . $codPK;
	$res=$conexion->BD_Consulta($consulta);
    }//fin del if(isset($_GET['cerrar']))
    
    
	    
	    
    $sqlDatos="SELECT * FROM cliente_incidencia_web
	INNER JOIN cliente ON cliente_CodPK=incidencia_ClienteLoginFK
	WHERE incidencia_CodPK=".$codPK;	
    $resDatos=$conexion->BD_Consulta($sqlDatos);
    $vectorDatos=$conexion->BD_GetTupla($resDatos);
    
    //print($sqlDatos);
    if($vectorDatos==NULL)
    {
	print("<script>document.location.href='index.php'</script>");
	exit();
    }
    
    $incidencia_FechaApertura=cambiaf_a_normal($vectorDatos['incidencia_FechaApertura']);
    $incidencia_FechaCierre=cambiaf_a_normal($vectorDatos['incidencia_FechaCierre']);
    $incidencia_Estado=$vectorDatos['incidencia_Estado'];
    $incidencia_Leido=$vectorDatos['incidencia_Leido'];
    $incidencia_ClienteLoginFK=$vectorDatos['incidencia_ClienteLoginFK'];
    $incidencia_Mensaje=$vectorDatos['incidencia_Mensaje'];
    $cliente_nombre=$vectorDatos['cliente_Nombre'];
    $cliente_email=$vectorDatos['cliente_Email'];
    $cliente_pass=$vectorDatos['cliente_Pass'];
    $cliente_NumeroMensajesPorLeer=$vectorDatos['cliente_NumeroMensajesPorLeer'];
    $cliente_CodPK=$vectorDatos['cliente_CodPK'];

    
    $incidencia_Mensaje=str_replace("<br />","\n",$incidencia_Mensaje);
    
   			
    //enviamos los datos
    if(isset($_POST['aux_insercion_linea']) && strcmp($incidencia_Estado,"Abierto")==0)
    {
	//insercion de los diferentes productos
	if(isset($_POST['fecha_producto']))
	{			
	    $fecha_producto=$_POST['fecha_producto'];	
	    $observaciones_producto=$_POST['observaciones_producto'];
				    
	    $res=false;
	    
		    
	    if(isset($_POST['fecha_producto']) && trim($_POST['observaciones_producto'])!="")
	    {
		$respuesta_Fecha=cambiaf_a_mysql($fecha_producto);
		$respuesta_Mensaje=$observaciones_producto;
		$respuesta_Leido="No";
		$respuesta_IncidenciaFK=$codPK;
		$respuesta_OrigenRespuesta="Saltotech";
		
		$respuesta_Mensaje=str_replace("'","",$respuesta_Mensaje);
		$respuesta_Mensaje=str_replace("\n","<br />",$respuesta_Mensaje);
		
		//evitamos insercion duplicada por actualizacion de la pagina
		$sqlInciRespuestaWeb="SELECT * FROM cliente_incidencia_respuesta_web WHERE respuesta_Fecha='" . $respuesta_Fecha . "'
					AND respuesta_Mensaje='" . $respuesta_Mensaje . "'
					AND respuesta_IncidenciaFK='" . $respuesta_IncidenciaFK . "'
					AND respuesta_OrigenRespuesta='" . $respuesta_OrigenRespuesta . "'";
		//print($sqlInciRespuestaWeb);
		$resInciRespuestaWeb=$conexion->BD_Consulta($sqlInciRespuestaWeb);
		$tuplaInciRespuestaWeb=$conexion->BD_GetTupla($resInciRespuestaWeb);
		
		if($tuplaInciRespuestaWeb==NULL)
		{
		    $res=$cliente_incidencia_respuesta_web->insertar($respuesta_Fecha, $respuesta_Mensaje, $respuesta_Leido, $respuesta_IncidenciaFK, $respuesta_OrigenRespuesta, $usuario_logueadoFK);		    
		}//fin del if($tuplaInciRespuestaWeb==NULL)
		
		//envio de email a cliente
		if($res==true)
		{
		    //damos por leidas todas las incidencias_respuestas del expediente
		    $sqlUpdateRespuesta="UPDATE cliente_incidencia_respuesta_web SET respuesta_Leido='Si' WHERE respuesta_IncidenciaFK=" . $respuesta_IncidenciaFK;
		    $resUpdateRespuesta=$conexion->BD_Consulta($sqlUpdateRespuesta);
		    
		    $from="info@saltotech.com";
		    $direccionMail=$cliente_email;
		    $asunto=utf8_decode("Saltotech .- Envio de Consulta");	    
		    $ficheroAEnviar="";// va con un enlace al ser un boletin
		    $nombreAMostrar="";			
		    $cuerpo =correoConsultaRespuesta($cliente_nombre, $incidencia_Mensaje, $respuesta_Mensaje);    
		    $envio= email($direccionMail,$from,$asunto,$cuerpo,$ficheroAEnviar,$nombreAMostrar);
			    
		    //aumentamos el 1 el numero de mensajes por leer
		    $cliente->modificarMensajesPorLeer(($cliente_NumeroMensajesPorLeer+1), $cliente_CodPK);
		    //print($cuerpo);
		}//fin del if($res==true)		    
	    }
	    
	    if($res==false )
		$errores="Error al insertar la linea o contenido de fecha y mensaje duplicado.";			
	}//fin del if(isset($_POST['fecha_producto']))		
    }//fin dl if(isset($_POST['aux_insercion_linea']) && strcmp($incidencia_Estado,"Abierto")==0)
    
    
    if(isset($_GET['campo_busqueda_buscador']))	    
	    $campo_busqueda_buscador=$_GET['campo_busqueda_buscador'];
    else
	    $campo_busqueda_buscador="";			
	
    if(isset($_GET['estado_envio_buscador']))	    
	    $estado_envio_buscador=$_GET['estado_envio_buscador'];
    else
	    $estado_envio_buscador="Todos";
    
    if(isset($_GET['tipo_envio_buscador']))	    
	    $tipo_envio_buscador=$_GET['tipo_envio_buscador'];
    else
	    $tipo_envio_buscador="Todos";
    
    if(isset($_GET['pagina_envio_buscador']))	    
	    $pagina_envio_buscador=$_GET['pagina_envio_buscador'];
    else
	    $pagina_envio_buscador="Todos";
	
	
    $parametros_busqueda="";
		
    if(trim($campo_busqueda_buscador)!="")
	    $parametros_busqueda=$parametros_busqueda . "&campo_busqueda_buscador=".$campo_busqueda_buscador;			

    if(strcmp($estado_envio_buscador,"Todos")!=0)
	    $parametros_busqueda=$parametros_busqueda . "&estado_envio_buscador=".$estado_envio_buscador;
    
    if(strcmp($tipo_envio_buscador,"Todos")!=0)
	    $parametros_busqueda=$parametros_busqueda . "&tipo_envio_buscador=".$tipo_envio_buscador;
    
    if(strcmp($pagina_envio_buscador,"Todos")!=0)
	    $parametros_busqueda=$parametros_busqueda . "&pagina_envio_buscador=".$pagina_envio_buscador;
	
    if(isset($_GET['pg']))
	    $parametros_busqueda=$parametros_busqueda . "&pg=".$_GET['pg'];

    if(isset($_GET['orden_fecha']))
	    $parametros_busqueda=$parametros_busqueda . "&orden_fecha=".$_GET['orden_fecha'];
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
           <span class="titulo">Gestión de Incidencias - Modificar Incidencia</span>
           <form class="form" name="form_add" id="form_add" method="post" action="incidencias_mod.php?ruta=1<?PHP print($parametros_busqueda);?>" style="clear:both" enctype="multipart/form-data">
		<input type="hidden" name="aux" id="aux" />
		<input type="hidden" name="codPK" id="codPK" value="<?PHP print($codPK);?>" />
		<div class="item">
		<label class="label">Número Incidencia</label><input type="text" class="input"  name="numero_pedido" id="numero_pedido" value="<?PHP print($codPK);?>" readonly="readonly"/>
		</div>
		<div class="item">
		<label class="label">Fecha Apertura</label><input type="text" class="input"  name="fecha_apertura" id="fecha_apertura" value="<?PHP print($incidencia_FechaApertura);?>" readonly="readonly"/>
		</div>
		<div class="item">
		<label class="label">Estado</label><input type="text" class="input"  name="estado" id="estado" value="<?PHP print($incidencia_Estado);?>" readonly="readonly"/>		
		<?PHP
		if(strcmp($incidencia_Estado,"Cerrado")==0)
		{
			print("</div>
			      <div class=\"item\">
				<label class=\"label\">Fecha Cierre</label><input type=\"text\" class=\"input\"  name=\"fecha_cierre\" id=\"fecha_cierre\" value=\"" . $incidencia_FechaCierre . "\" readonly=\"readonly\"/>
				</div>");
		}//fin del if(strcmp($incidencia_Estado,"Cerrado")==0)
		else
		{
			print("<a href=\"#\" onclick=\"if(confirm('Seguro que desea cerrar dicha incidencia?.'))document.location.href='incidencias_mod.php?codPK=" . $codPK . "&cerrar=1" . $parametros_busqueda . "'\">
			<p style=\"clear:both; color: #FF0000 !important; font-size: 12px !important\">
			[Cerrar Incidencia]
			</p>
			</a>
			</div>");
		}//fin del else del if(strcmp($incidencia_Estado,"Cerrado")==0)
		?>
		<div class="item">
		<label class="label">Leido</label><input type="text" class="input"  name="leido" id="leido" value="<?PHP print($incidencia_Leido);?>" readonly="readonly"/>
		<?PHP
		if(strcmp($incidencia_Leido,"No")==0)
			print("<a href=\"#\" onclick=\"if(confirm('Seguro que desea dar por leida dicha incidencia?.'))document.location.href='incidencias_mod.php?codPK=" . $codPK . "&leido=1" . $parametros_busqueda . "'\">
			<p style=\"clear:both; color: #FF0000 !important; font-size: 12px !important\">
			[Leer Incidencia]
			</p>
			</a>");
		?>
		</div>
		<?PHP
		print("<div class=\"item\">
			<label class=\"label\">Cliente Logueado</label><input type=\"text\" class=\"input\"  name=\"cliente_logueado\" id=\"cliente_logueado\" value=\"" . $cliente_nombre . "\" readonly=\"readonly\"/>
			</div>
			<div class=\"item\">
			<label class=\"label\">Email Logueado</label><input type=\"text\" class=\"input\"  name=\"email_logueado\" id=\"email_logueado\" value=\"" . $cliente_email . "\" readonly=\"readonly\"/>
			</div>");
		?>
		
		
		
		<div class="item grande">
		<label class="label">Mensaje</label>
		<textarea style="font-size: 12px !important; padding-left: 7px !important; height: 50px !important"  class="textareagrande_mas_alto" name="observaciones" id="observaciones" readonly="readonly"><?PHP print(utf8_encode($incidencia_Mensaje));?></textarea>
		</div>
		
		<div style="clear: both; height: 25px !important"></div>
		
		<span class="titulo2">Historico Incidencias</span>
		
		<table id="tabla_reservas" style="font-size:14px">   
		<tr>
		    <td class="encabezado" style=" width:60px; font-size: 12px !important">Fecha</td>
		    <td class="encabezado" style=" width:450px; font-size: 12px !important">Mensaje</td>
		    <td class="encabezado" style=" width:150px; font-size: 12px !important">Origen</td>
		    <!--<td class="encabezado" style=" width:50px; font-size: 12px !important">Leido por el Cliente</td>-->
		</tr>
		
		<?PHP
		
		$sqlRespuestas="SELECT * FROM cliente_incidencia_respuesta_web
		    WHERE respuesta_IncidenciaFK=" . $codPK . " ORDER BY respuesta_CodPK";
		$resRespuestas=$conexion->BD_Consulta($sqlRespuestas);
		$tuplaRespuestas=$conexion->BD_GetTupla($resRespuestas);		
		
		while($tuplaRespuestas!=NULL)
		{
		    $leida_respuesta="--";
		    if(strcmp($tuplaRespuestas['respuesta_OrigenRespuesta'],"Cliente")==0)
			$leida_respuesta=$tuplaRespuestas['respuesta_Leido'];
			    
		    
		    $origen_respuesta="Saltotech";
		    if(strcmp($tuplaRespuestas['respuesta_OrigenRespuesta'],"Cliente")==0)
			$origen_respuesta="Cliente";
			    
		    //if(trim($tuplaRespuestas['cliente_Nombre'])!="")
		    //$origen_respuesta= $origen_respuesta . " - User: " . $tuplaRespuestas['cliente_Nombre'];
			    
		    print("<tr>
			  <td>" . cambiaf_a_normal($tuplaRespuestas['respuesta_Fecha']) . "</td>
			  <td>" . $tuplaRespuestas['respuesta_Mensaje'] . "</td>
			  <td>" . $origen_respuesta . "</td>
			  <!--<td>" . $leida_respuesta . "</td>-->
			  </tr>");
		    
		    $tuplaRespuestas=$conexion->BD_GetTupla($resRespuestas);
		}//fin del while($tuplaRespuestas!=NULL)
		
		print("</table>
			</form>");
			
		
		if(strcmp($incidencia_Estado,"Abierto")==0)
		{
			print("<form class=\"form\" method=\"post\" name=\"form_anadir\" id=\"form_anadir\" action=\"incidencias_mod.php?codPK=" . $codPK . $parametros_busqueda . "\">
			      <input type=\"hidden\" name=\"anadir_linea\" id=\"anadir_linea\" />");
			
				
			print("<div class=\"item\">
				<label class=\"label\">&nbsp;</label>
				<input type=\"button\" value=\"Añadir Linea\" class=\"button\" onclick=\"document.form_anadir.submit();\" />
				</div>
				<div style=\"clear:both\">Para contestar una Incidencia, hace falta que se escriba un nuevo mensaje.</div>				
			</form>");			
		}//fin del if(strcmp($incidencia_Estado,"Abierto")==0)
				
		
		if(strcmp($incidencia_Estado,"Abierto")==0 && isset($_POST['anadir_linea']))
		{	
		    $texto_observaciones="";
		    
		    print("<form class=\"form\" name=\"form_contestar\" id=\"form_contestar\" method=\"post\" action=\"incidencias_mod.php?codPK=" . $codPK . $parametros_busqueda . "\" style=\"clear:both\" enctype=\"multipart/form-data\">
			<input type=\"hidden\" name=\"aux_insercion_linea\" id=\"aux_insercion_linea\" />
			<div class=\"conjunto_formulario\" style=\"width:950px !important; height: 300px !important\">				
			<div class=\"item\">
			    <label class=\"label\">Fecha</label><input type=\"text\" class=\"input\" name=\"fecha_producto\" id=\"fecha_producto\" value=\"" . date("d/m/Y") . "\" readonly=\"readonly\" />
			</div>");
		    
		    
		    print("<div class=\"item grande\">
			    <label class=\"label\">Mensaje</label>
			    <textarea style=\"font-size: 12px !important; padding-left: 7px !important; height: 50px !important\"  class=\"textareagrande_mas_alto\" name=\"observaciones_producto\" id=\"observaciones_producto\">" . $texto_observaciones . "</textarea>");	    
			    
		    print("</div>");
		    if(comprobar_email(strtolower($cliente_email))==1)
			print("<span class=\"explicacion\" style=\"padding-left: 22%;\">Se enviara el email a: " . $cliente_email . "</span>");
		    else
			print("<span class=\"explicacion\" style=\"color:#FF0000 !important; padding-left: 22%;\">NO Se enviara el email a: " . $cliente_email . ", por no tener formato de email.</span>");				  
			print("<div style=\"clear: both\"></div>
			  <div class=\"item\">
			  <br /><br />
			<a class=\"buscar\" href=\"#\" title=\"Añadir\" onclick=\"document.form_contestar.submit();\" style=\"color:#FFf\"><span>Añadir Linea</span></a>
			</div>
			</form>");
		}//fin del if(strcmp($incidencia_Estado,"Abierto")==0 && isset($_GET['anadir_linea']))		
		?>
            
       		
                    
            
           </div>
        
	<a href="incidencias.php?ruta=1<?PHP print($parametros_busqueda);?>" class="submit buscar">Atrás</a>

           <!-- acaba mideel contenido gris--></div>
           <!-- acaba derecha--></div>
     








		    </div>
		  </div>
		</div>

</div>

<?php require "./layout/footer.php"; ?>
</body>
</html>