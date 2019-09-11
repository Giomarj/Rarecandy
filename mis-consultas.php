<?PHP	
    session_start();
    
    include_once "clases/fun_aux_menu.php";
    include_once "clases/conexion.php";
    include_once "clases/seguridad.php";
    include_once "clases/fechas.php";
    include_once "clases/bib_emailBoletin.php";
    include_once "clases/fun_correo_intranet.php";
    include_once "clases/cliente.php";
    include_once "clases/cliente_incidencia_web.php";
    include_once "clases/cliente_incidencia_respuesta_web.php";
    
    $conexion = new conexion();
    $cliente = new cliente();
    $cliente_incidencia_web = new cliente_incidencia_web();
    $cliente_incidencia_respuesta_web = new cliente_incidencia_respuesta_web();
    
    Seguridad();
    

    
    $sqlUser="SELECT * FROM cliente WHERE cliente_Login='".$_SESSION['usuario_salto']."' AND cliente_Pass='".$_SESSION['password_salto']."' AND cliente_Estado='Activo'";    
    $resUser=$conexion->BD_Consulta($sqlUser);
    $tuplaUsuario=$conexion->BD_GetTupla($resUser);
    
    if($tuplaUsuario==NULL)
    {
	print("<script>document.location.href='inicio-logado.php'</script>");
	exit();
    }
    
    
    
    //ponemos el contador de mensajes a 0
    $cliente->modificarMensajesPorLeer(0, $tuplaUsuario['cliente_CodPK']);
    
    $codPK=0;
    if(isset($_GET['codPK']))
	$codPK=$_GET['codPK'];
    else
    {
	//sino estamos entrando en una consulta especifica, entramos en la ultima consulta insertada
	$sqlUltimaConsulta="SELECT * FROM cliente_incidencia_web WHERE incidencia_ClienteLoginFK=" . $tuplaUsuario['cliente_CodPK'] . " ORDER BY incidencia_CodPK DESC";
	$resUltimaConsulta=$conexion->BD_Consulta($sqlUltimaConsulta);
	$tuplaUltimaConsulta=$conexion->BD_GetTupla($resUltimaConsulta);
	
	if($tuplaUltimaConsulta!=NULL)
	    $codPK=$tuplaUltimaConsulta['incidencia_CodPK'];
    }//fin del else del if(isset($_GET['codPK']))
    
    $mensaje_javascript="";
    
    if(isset($_POST['aux_nueva']))
    {	
	$incidencia_Mensaje=str_replace("'","\"",$_POST['consulta']);
	
	if(trim($incidencia_Mensaje)=="")
	    $mensaje_javascript="El campo descripcion debe estar relleno";
	
	if(trim($mensaje_javascript)=="")
	{
	    //esto es una incidencia nueva
	    $incidencia_FechaApertura=date("Y-m-d");
	    $incidencia_FechaCierre="0000-00-00";
	    $incidencia_Estado="Abierto";
	    $incidencia_Leido="No";
	    $incidencia_ClienteLoginFK=$tuplaUsuario['cliente_CodPK'];	    
	    $incidencia_Mensaje=$incidencia_Mensaje;
	    
	    $incidencia_Mensaje=str_replace("\n","<br />",$incidencia_Mensaje);
		
	    //la insertamos en caso de que no le hayamos dado a F5
	    $sqlActualizarIncidencia="SELECT * FROM cliente_incidencia_web WHERE incidencia_FechaApertura='" . $incidencia_FechaApertura . "'
				    AND incidencia_Estado='" . $incidencia_Estado . "'
				    AND incidencia_ClienteLoginFK='" . $incidencia_ClienteLoginFK . "'
				    AND incidencia_Mensaje='" . $incidencia_Mensaje . "'";
	    $resActualizarIncidencia=$conexion->BD_Consulta($sqlActualizarIncidencia);
	    $tuplaActualizarIncidencia=$conexion->BD_GetTupla($resActualizarIncidencia);
	  
	    if($tuplaActualizarIncidencia==NULL)
	    {
		$mensaje_javascript="Incidencia Insertada Correctamente";
	      
		$cliente_incidencia_web->insertar($incidencia_FechaApertura, $incidencia_FechaCierre, $incidencia_Estado, $incidencia_Leido, $incidencia_ClienteLoginFK, $incidencia_Mensaje);
	      
		//Obtener CodPK de la ultima Consulta
		$codPK = mysql_insert_id($conexion->BD);
		
		$from="info@saltotech.com";
		$direccionMail="info@saltotech.com";
		$asunto=utf8_decode("Saltotech .- Envio de Consulta");	    
		$ficheroAEnviar="";// va con un enlace al ser un boletin
		$nombreAMostrar="";			
		$cuerpo =correoConsultaAbierta($tuplaUsuario['cliente_Nombre'], utf8_decode($incidencia_Mensaje));  //esta en fun_correo		    
		$envio= email($direccionMail,$from,$asunto,$cuerpo,$ficheroAEnviar,$nombreAMostrar);
		
		//print($cuerpo);
		
	    }//fin del if($tuplaActualizarIncidencia==NULL)  	   
	}//fin del if(trim($mensaje_javascript)=="")
    }//fin del if(isset($_POST['aux_nueva']))
    
    if(isset($_POST['aux_responder']))
    {
	$respuesta=str_replace("'","\"",$_POST['respuesta']);
	
	if(trim($respuesta)=="")
	    $mensaje_javascript="El campo descripcion debe estar relleno";
	
	if(trim($mensaje_javascript)=="")
	{
	    //la insertamos en caso de que no le hayamos dado a F5
	    $sqlActualizarRespuesta="SELECT * FROM cliente_incidencia_respuesta_web WHERE respuesta_Fecha='" . date("Y-m-d") . "'
		    AND respuesta_Mensaje='" . $respuesta . "'
		    AND respuesta_Leido='No'
		    AND respuesta_IncidenciaFK='" . $codPK . "'
		    AND respuesta_OrigenRespuesta='Cliente'";
	    $resActualizarRespuesta=$conexion->BD_Consulta($sqlActualizarRespuesta);
	    $tuplaActualizarRespuesta=$conexion->BD_GetTupla($resActualizarRespuesta);
	  
	    if($tuplaActualizarRespuesta==NULL)
	    {
		$mensaje_javascript="Respuesta Insertada Correctamente";
		
		//esto es una respuesta      
		$cliente_incidencia_respuesta_web->insertar(date("Y-m-d"), $respuesta, "No", $codPK, "Cliente", 0);
		
		//siempre que haya una respuesta de un cliente a una incidencia, obligamos a la incidencia a abrirla
		$updateIncidencia="UPDATE cliente_incidencia_web SET incidencia_FechaCierre='0000-00-00', incidencia_Estado='Abierto' WHERE incidencia_CodPK=" . $codPK;
		$resIncidencia=$conexion->BD_Consulta($updateIncidencia);
		
		
	    }//fin del if($tuplaActualizarRespuesta==NULL)
	}//fin del if(trim($mensaje_javascript)=="")
    }//fin del if(isset($_POST['aux_responder']))
?>
<!DOCTYPE html>
<html>
<head>
<?php require "./layout/header.php"; ?>
        <link href="css/reset.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <script src="js.js" type="text/javascript"></script>
        <style type="text/css">
        	.kd-admin {
    float: left;
    width: 100%;
    background-color: #ffffff;
    border: 1px solid #e1e1e1;
    padding: 20px;
    box-shadow: 0 3px 3px 0 rgba(0, 0, 0, 0.1);
}
#kdcomments {
    float: left;
    width: 100%;
}
#kdcomments ul li .text {
    float: left;
    width: 100%;
    padding: 20px;
    border: 1px solid #e1e1e1;
    position: relative;
    margin-left: 30px;
}
#kdcomments ul li {
    float: left;
    width: 100%;
    list-style: none;
    margin-bottom: 25px;
}
.kd-widget-title h2 {
    text-transform: uppercase;
    font-weight: bold;
    position: relative;
    border-bottom: 1px solid #eee;
    float: left;
    padding: 0 0 7px;
}
h6{
	text-align: justify;
}
#kdcomments p{
	text-align: justify;
}
#respond form p textarea {
    height: 150px;
    border: 1px solid #e1e1e1;
    color: #333333;
    padding: 9px;
}
.kd-pagesection{
	padding-top: 1%;
}
.thbg-colorhover{
	margin: 1px;
    padding: 5px 20px 5px 20px;
    border: solid 1px;
    border-radius: 4px;
    /* color: #fff; */
    /* background-color: #e96656; */
    box-shadow: none;
    text-shadow: none;
    font-size: 14px;
    font-weight: 400;
    text-align: center;
    vertical-align: middle;
    white-space: nowrap;
    float: right;
    text-transform: uppercase;
}
        </style>
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
		    

      <section class="kd-pagesection consultas">

		<div class="row">
		<div class="col-md-8">
		    <?PHP
		    $sqlUltimaConsulta="SELECT * FROM cliente_incidencia_web WHERE incidencia_CodPK=" . $codPK . " AND incidencia_ClienteLoginFK=" . $tuplaUsuario['cliente_CodPK'];
		    $resUltimaConsulta=$conexion->BD_Consulta($sqlUltimaConsulta);
		    $tuplaUltimaConsulta=$conexion->BD_GetTupla($resUltimaConsulta);
		    
		    
		    if($tuplaUltimaConsulta!=NULL)
		    {
			$descripcion=$tuplaUltimaConsulta['incidencia_Mensaje'];
			$fecha_consulta=$tuplaUltimaConsulta['incidencia_FechaApertura'] . " 00:00:00";
			
			print("<div class=\"kd-admin thememargin\">
			    <div class=\"admin-info\">				    
				<div class=\"admin-info\">
				    <h5>" . $tuplaUsuario['cliente_Nombre'] . "</h5>
				    <time datetime=\"" . $fecha_consulta . "\"><i class=\"fa fa-calendar\"></i> " . cambiaf_a_normal($tuplaUltimaConsulta['incidencia_FechaApertura']) . " | Estado: " . $tuplaUltimaConsulta['incidencia_Estado'] . "</time>	
				    <hr>		    
				    <h6>" . $descripcion . "</h6>
				</div>
			    </div>
			</div>");
			
			//comprobamos que la ultima insercion de la incidencia sea de tipo SinFin
			
			$sqlHayComentarios="SELECT * FROM cliente_incidencia_respuesta_web WHERE respuesta_IncidenciaFK=" . $codPK . " ORDER BY respuesta_CodPK";
			$resHayComentarios=$conexion->BD_Consulta($sqlHayComentarios);
			$tuplaHayComentarios=$conexion->BD_GetTupla($resHayComentarios);
		    
			if($tuplaHayComentarios!=NULL)
			{
			    print("<div id=\"kdcomments\">
				<ul>");
			    
			    while($tuplaHayComentarios!=NULL)
			    {
				if(strcmp($tuplaHayComentarios['respuesta_OrigenRespuesta'],"Cliente")==0)
				{
				    $descripcion=$tuplaHayComentarios['respuesta_Mensaje'];
				    $fecha_consulta=$tuplaHayComentarios['respuesta_Fecha'] . " 00:00:00";
			
				    print("<li class=\"children\">
					<div class=\"text\">
					" . $tuplaUsuario['cliente_Nombre'] . " <time datetime=\"" . $fecha_consulta . "\"><i class=\"fa fa-calendar\"></i>" . cambiaf_a_normal($tuplaHayComentarios['respuesta_Fecha']) . "</time>
					<hr>
					<p>" . $descripcion . "</p>
					</div>				   
				    </li>
				    <li></li>");
				    
				    $tuplaHayComentarios=$conexion->BD_GetTupla($resHayComentarios);
				}//fin del if(strcmp($tuplaHayComentarios['respuesta_OrigenRespuesta'],"Cliente")==0)
				else
				{
				    $descripcion=$tuplaHayComentarios['respuesta_Mensaje'];
				    
				    print("<li>			  
					    <div class=\"text\">
					    Saltotech <time style=\"padding-left: 1%;\" datetime=\"" . $fecha_consulta . "\"><i class=\"fa fa-calendar\"></i>" . cambiaf_a_normal($tuplaHayComentarios['respuesta_Fecha']) . "</time>
					    <hr style=\"background: #eee;\">
					    <p>" . $descripcion . "</p>");
				    
				    $tuplaHayComentarios=$conexion->BD_GetTupla($resHayComentarios);
				    
				    if($tuplaHayComentarios==NULL)
				    {
					//en caos de que no hubiese otra respuesta, entonces esta es la ultima y se puede responder
					print("<a class=\"replay-btn thbg-colorhover\" href=\"#\" data-toggle=\"modal\" data-target=\"#modalresponder\">Responder</a>
					      <!-- Modal -->
					      <div class=\"modal fade kd-loginbox\" id=\"modalresponder\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\" aria-hidden=\"true\">
						    <div class=\"modal-dialog\">
						      <div class=\"modal-content\">
							    <div class=\"modal-body\">
								    <a href=\"#\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></a>
								      <div class=\"textarea-modal\">
									      <h2>Responder</h2>
									      <form name=\"form_responder\" id=\"form_responder\" method=\"post\" action=\"mis-consultas.php?codPK=" . $codPK . "\">
										    <input type=\"hidden\" name=\"aux_responder\" id=\"aux_responder\" />
										    <p class=\"kd-textarea\"><textarea style=\"width:100%; min-height:100px\" name=\"respuesta\" id=\"respuesta\" placeholder=\"Escribe aquí tu consulta\"></textarea></p>
										    <p class=\"kd-button\"><input type=\"button\" value=\"Enviar\" class=\"thbg-color btn btn-primary\" onclick=\"enviar_form_responder();\" /></p>
									      </form>
								     </div>
							    </div>
						      </div>
						    </div>
					      </div>
					    </div>");
				    }//fin del if($tuplaHayComentarios==NULL)
				    
				    print("</li>");
				}//fin del else del if(strcmp($tuplaHayComentarios['respuesta_OrigenRespuesta'],"Cliente")==0)
				
				
			    }//fin del while($tuplaHayComentarios!=NULL)
			    

			    
			    print("</ul>
				</div>");
			}//fin del if($tuplaHayComentarios!=NULL)
		    }//fin del if($tuplaUltimaConsulta!=NULL)

		    ?>
		    <div id="respond">
                      <h2>Haz tu consulta</h2>
                      <form name="form_consulta" id="form_consulta" method="post" action="mis-consultas.php">
			<input type="hidden" name="aux_nueva" id="aux_nueva" />
                        <p class="kd-textarea"><textarea name="consulta" id="consulta" placeholder="Escribe aquí tu consulta"></textarea></p>
                        <p class="kd-button"><input type="button" value="Enviar consulta" class="thbg-color" onclick="envio_nueva_consulta();" /></p>
                      </form>
		    </div>
		    <?PHP
		    //if($tuplaUltimaConsulta!=NULL)
			//print("</div>");
		    ?>
		</div>
		<aside class="col-md-4">
			<!--<div class="widget widget_search">
			  <form>
				<input type="text" placeholder="Buscar">
				<input type="submit" value="">
				<i class="fa fa-search"></i>
			  </form>
			</div>-->
			<div class="widget widget_categories ultimas-consultas">
			    <div class="kd-widget-title"><h2>Últimas consultas</h2></div>
			    <ul class="align-left">
			    <?PHP
			    //sino estamos entrando en una consulta especifica, entramos en la ultima consulta insertada
			    $sqlConsulta="SELECT * FROM cliente_incidencia_web WHERE incidencia_CodPK!=" . $codPK . " AND incidencia_ClienteLoginFK=" . $tuplaUsuario['cliente_CodPK'] . " ORDER BY incidencia_CodPK DESC";
			    $resConsulta=$conexion->BD_Consulta($sqlConsulta);
			    $tuplaConsulta=$conexion->BD_GetTupla($resConsulta);
			    
			    while($tuplaConsulta!=NULL)
			    {
				$mensaje=$tuplaConsulta['incidencia_Mensaje'];
				if(strlen($mensaje)>100)
				    $mensaje=substr($mensaje,0,100);
				    
				print("<li><a href=\"mis-consultas.php?codPK=" . $tuplaConsulta['incidencia_CodPK'] . "\">Estado: " . $tuplaConsulta['incidencia_Estado'] . " | " . cambiaf_a_normal($tuplaConsulta['incidencia_FechaApertura']) . " | " . $mensaje . "</a></li>");
				      
				$tuplaConsulta=$conexion->BD_GetTupla($resConsulta);
			    }//fin del while($tuplaConsulta!=NULL)
			    
			    /*<li><a href="#">¿Hola, tenéis algun paquete en oferta con destino Las Bahamas?</a></li>
				<li><a href="#">¿Hola, tenéis algun paquete en oferta con destino Las Bahamas?</a></li>
				<li><a href="#">¿Hola, tenéis algun paquete en oferta con destino Las Bahamas?</a></li>*/
			    ?>				
			    </ul>
			    </div>
		</aside>
		
		</div>

      </section>





		    </div>
		  </div>
		</div>

</div>

<?php require "./layout/footer.php"; ?>
</body>
</html>