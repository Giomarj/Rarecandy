<?PHP
    ini_set("session.cookie_lifetime","7200");
    ini_set("session.gc_maxlifetime","7200");
    
    session_start();
    

    include "clases/fun_aux_menu.php";
	include_once "clases/conexion.php";
	include_once "clases/fechas.php";
	include_once "clases/seguridad.php";
	include_once "clases/paginacion_intranet.php";
    include_once "clases/cliente_incidencia_web.php";
    include_once "clases/cliente_incidencia_respuesta_web.php";
	    
    Seguridad();
    Admin();
    
    $cliente_incidencia_web = new cliente_incidencia_web();
    $cliente_incidencia_respuesta_web = new cliente_incidencia_respuesta_web();
    $conexion = new conexion();
    $paginacion = new paginacion_intranet();
	    
    $impresion_mensaje="";
	
    if(isset($_GET['elim_incidencia']))
    {
    	$sql="SELECT *
	    FROM cliente_incidencia_web
	    WHERE  incidencia_CodPK =" . $_GET['elim_incidencia'];
				
	$res=$conexion->BD_Consulta($sql);
	$tupla=$conexion->BD_GetTupla($res);
		
	if($tupla!=NULL) 
	{  
	    $impresion_mensaje="alert('Se ha eliminado la incidencia seleccionada.');";
	    $consulta="WHERE incidencia_CodPK=" . $_GET['elim_incidencia'];
	    $cliente_incidencia_web->eliminar($consulta);
	    
	    $consulta="WHERE respuesta_IncidenciaFK=" . $_GET['elim_incidencia'];
	    $cliente_incidencia_respuesta_web->eliminar($consulta);
    	}
	else
	    $impresion_mensaje="alert('La incidencia seleccionada no existe.');";
	//fin del if($tupla!=NULL)
    }//fin del if(isset($_GET['elim_incidencia']) && strcmp($_SESSION['username_intra_clp'],"admin")==0)
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
	     <?PHP
		if(isset($_GET['campo_busqueda_buscador']))	    
		    $campo_busqueda_buscador=$_GET['campo_busqueda_buscador'];
		else
		    $campo_busqueda_buscador="";			
			
		if(isset($_GET['estado_envio_buscador']))	    
		    $estado_envio_buscador=$_GET['estado_envio_buscador'];
		else
		    $estado_envio_buscador="Abierto";
		    
		
		$parametros_busqueda="";
				
		if(trim($campo_busqueda_buscador)!="")
		    $parametros_busqueda=$parametros_busqueda . "&campo_busqueda_buscador=".$campo_busqueda_buscador;			
		
		if(trim($estado_envio_buscador)!="")
		    $parametros_busqueda=$parametros_busqueda . "&estado_envio_buscador=".$estado_envio_buscador;
		    
		
		if(isset($_GET['pg']))
		    $parametros_busqueda=$parametros_busqueda . "&pg=".$_GET['pg'];
					
		$parametros_busqueda_sin_orden=$parametros_busqueda;
		
		
		if(isset($_GET['orden_fecha']))
		    $parametros_busqueda=$parametros_busqueda . "&orden_fecha=".$_GET['orden_fecha'];
	    ?>		    
           <div class="modulo_basico">
           <span class="titulo">Incidencias</span>
	   
	    <!-- buscador--><div class="buscador">            
	    
	    <form class="form" name="buscador_user" id="buscador_user" method="get" action="incidencias.php">
		<input type="hidden" name="aux_buscador" id="aux_buscador" />
		
		<div class="item buscador_proveedores">
                <label class="label">Incidencia</label>
		<input style=" font-size:12px" type="text" name="campo_busqueda_buscador" id="campo_busqueda_buscador" value="<?PHP print($campo_busqueda_buscador);?>" /><br />
		<span style=" font-size:9.5px">Busca: Nombre, Email, Teléfono, Provincia, Poblacion, Comentario</span>
                </div>		
		
		<div class="item buscador_proveedores">
                <label class="label">Estado Envío</label>
			<select style=" width:100px" class="select" name="estado_envio_buscador" id="estado_envio_buscador">				
                        <?PHP 
			if(strcmp($estado_envio_buscador,"Todos")==0)
			    print("<option value=\"Todos\" selected=\"selected\">Todos</option>");
			else
			    print("<option value=\"Todos\">Todos</option>");
			
			if(strcmp($estado_envio_buscador,"Abierto")==0)
			    print("<option value=\"Abierto\" selected=\"selected\">Abierto</option>");
			else
			    print("<option value=\"Abierto\">Abierto</option>");
			
			if(strcmp($estado_envio_buscador,"Cerrado")==0)
			    print("<option value=\"Cerrado\" selected=\"selected\">Cerrado</option>");
			else
			    print("<option value=\"Cerrado\">Cerrado</option>");			
			?>
			</select>
                </div>
		
		<?PHP
			//paginacion de 50			
			$sql="SELECT * FROM cliente_incidencia_web INNER JOIN cliente ON cliente_CodPK=incidencia_ClienteLoginFK
			    WHERE 1=1";			
			
			if(trim($campo_busqueda_buscador)!="")
			    $sql=$sql . " AND ( OR incidencia_Mensaje LIKE '%" . $campo_busqueda_buscador . "%'					    
					    OR cliente_Nombre LIKE '%" . $campo_busqueda_buscador . "%'					    
					    OR cliente_Login LIKE '%" . $campo_busqueda_buscador . "%'
					    OR cliente_Telefono LIKE '%" . $campo_busqueda_buscador . "%')";
			
			if(strcmp($estado_envio_buscador, "Todos")!=0)
			    $sql=$sql . " AND incidencia_Estado='" . $estado_envio_buscador . "'";
			    
			
			$orderby=" ORDER BY incidencia_CodPK DESC";
			
			
			
			//$sql=$sql . " GROUP BY ped_CodPK";
			
			$sql=$sql . $orderby;
			
			
			//print($sql);
			
			$paginacion->paginar($sql,50);
			
				
			// Mostrar resultados de la consulta
			$nfilas = mysql_num_rows ($paginacion->pagi_result);			
		?>	
		<p style="clear:both">Se han encontrado <?PHP print($nfilas);?> registros.</p>
		
               
		
		<input type="submit" class="submit buscar" value="buscar" />			
	    </form>
	    
        	<!-- acaba buscador--></div>
            
		
         	<table id="tabla_reservas" style="font-size:14px" >
		<thead>
		    <tr>
		    <td class="encabezado" style=" width:40px; font-size: 12px !important">
			Cod. Incidencia
		    </td>
		    <td class="encabezado" style=" width:120px; font-size: 12px !important">			
			F.Incidencia
		    </td>   
		    <td class="encabezado" style=" width:40px; font-size: 12px !important">
			Estado
		    </td>
		    <td class="encabezado" style=" width:100px; font-size: 12px !important">			
			Cliente
		    </td>		   
                    <td class="encabezado" style=" width:550px; font-size: 12px !important">
			Mensaje
		    </td>		                             
		    <td class="encabezado" style=" width:40px; font-size: 12px !important">&nbsp;</td>
                    <td class="encabezado" style=" width:40px; font-size: 12px !important">&nbsp;</td>
		</tr>
		</thead>
		<tbody>

				
		<?PHP
		if($nfilas==0)
		    print("<tr><td colspan=\"7\">No existen Incidencias bajo los criterios de busqueda.</td></tr>");
		
		for($i=0; $i<$nfilas;$i++)
		{
		    $resultado = mysql_fetch_array ($paginacion->pagi_result);
		   		    
		    $style_td="color:#000000; background-color: #FFFFFF !important";
		    
		    if(strcmp($resultado['incidencia_Leido'],"No")==0)	
			$style_td="color:#FFFFFF; background-color: #FF0000 !important";
			
		   
		    $incidencia_cliente=$resultado['cliente_Nombre'];
		    $incidencia_mensaje=$resultado['incidencia_Mensaje'];
		    
		    
		    $cadena_aux="<tr>
			    <td style=\"" . $style_td . "\">" . $resultado['incidencia_CodPK'] . "</td>
			    <td style=\"" . $style_td . "\">" . cambiaf_a_normal($resultado['incidencia_FechaApertura']) . "</td>			    
			    <td style=\"" . $style_td . "\">" . $resultado['incidencia_Estado'] . "</td>
			    <td style=\"" . $style_td . "\">" . $incidencia_cliente . "</td>			    
			    <td style=\"" . $style_td . "\">" . $incidencia_mensaje . "</td>
			    <td><a href=\"incidencias_mod.php?codPK=" . $resultado['incidencia_CodPK'] . $parametros_busqueda. "\"><i class=\"fa fa-reply\" style=\"font-size:24px; color:green; padding-left: 8px;\"></i></a></td>";
			  
		  
		    print($cadena_aux);
		    
		   
		    print("<td><a href=\"#\" onclick=\"if(confirm('Seguro que desea eliminar dicha incidencia junto a sus respuestas?.'))document.location.href='incidencias.php?elim_incidencia=" . $resultado['incidencia_CodPK'] . $parametros_busqueda . "'\"><i class=\"fa fa-trash\" style=\"font-size:24px; color:red; padding-left: 8px;\"></i></a></td>");
		   
			    
		    print("</tr>");
		}//fin del for($i=0; $i<$nfilas;$i++)
		?>
		</tbody>
		</table>
		
		
             <div id="paginador">
            	<ul>
		     <?PHP	      
			if($nfilas >= $paginacion->pagi_cuantos || $paginacion->pagi_actual > 1)
			{
			   //Incluimos la barra de navegación			
			   print($paginacion->pagi_navegacion);
			}
			
			
		?>
                </ul>
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