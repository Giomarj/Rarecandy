<?php 
session_start();
    include "/clases/fun_aux_menu.php";
	include_once "/clases/conexion.php";
	include_once "/clases/fechas.php";
	include_once "/clases/seguridad.php";
	include_once "/clases/paginacion_intranet.php";
	include_once "/clases/cliente.php";	
	include_once "/clases/provincia.php";


	$cliente = new cliente();
	$paginacion = new paginacion_intranet();
	$conexion = new conexion();	
	$provincia = new provincia();
    
    Seguridad();
	Admin();
	
	$daterange3="";
	$daterange2="";
	$provincia_procedeFK_buscar=0;
	
	if(isset($_GET['provincia_procedeFK']) && trim($_GET['provincia_procedeFK'])!="")
		$provincia_procedeFK_buscar=$_GET['provincia_procedeFK'];

	if(isset($_POST['daterange2']) && trim($_POST['daterange2'])!="")
		$daterange2=$_POST['daterange2'];

	if(isset($_POST['daterange3']) && trim($_POST['daterange3'])!="")
		$daterange3=$_POST['daterange3'];

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
 ?>
<!DOCTYPE html>
<html>
<head>
<?php require "./layout/header.php"; ?>
        <link href="css/reset.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="css/daterangepicker.css" />
        <script type="text/javascript" src="js/daterangepicker.js"></script>
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
           <span class="titulo">Jornada</span>
          
            
	    <!-- buscador-->
	    <div class="buscador">
	    <form class="form" name="buscador_user" id="buscador_user" method="get" action="">
		<input type="hidden" name="aux_buscador" id="aux_buscador" />	
			<div class="resultados">
            <center><h4>Filtrar Por Fecha:</h4></center>
            <br>
            		<div class="row">
								 
								 		<div class="form-group">
					           			 <div class='input-group date' id='datetimepicker'>
					           			 	<div class="col-md-2"></div>	
									 		<div class="col-md-5">
									 			<label style="float: left;"><i class="fa fa-calendar" style="padding-right:3px; padding-bottom: 4px;"></i> Desde:</label>
					               				 <input type='text' class="form-control" name="daterange2" id="daterange2" value="<?PHP print($daterange2);?>" placeholder="Seleccione Rango de Fecha" style="padding: 6px 65px;" />									 			
									 		</div>
									 		<div class="col-md-5">
									 			<label style="float: left;"><i class="fa fa-calendar" style="padding-right:4px; padding-bottom: 4px;"></i>Hasta:</label>
					               				 <input type='text' style="padding: 6px 65px;" class="form-control" name="daterange3" id="daterange3" value="<?PHP print($daterange3);?>" placeholder="Seleccione Rango de Fecha" />									 			
									 		</div>

					            </div>
						        </div>

						    
				    </div>
	</div> 
		<div class="item" style="margin-right: 20px;">
					<div style="float: right;" for="cbmostrar">
			    		<br>
					  <input type="checkbox" name="cbmostrar" class="fantasma" />
					  Imprimir jornadas de todos los empleados
					</div>
		</div>

		<div class="item dvOcultar2">
		<label class="label">Nombre</label><input autofocus type="text" class="input" name="nombre_cliente" id="nombre_cliente" value="<?PHP print($nombre_cliente_buscar);?>"/>
		<span class="explicacion">Busca por cualquier dato de cliente, menos por observaciones, login y pass</span>
		</div>
		<div class="item" >
                <label class="label">Jornada</label>
			<select class="select" name="provincia_procedeFK" id="provincia_procedeFK">				
			<?PHP
				if($provincia_procedeFK_buscar==0)
					print("<option value=\"0\" selected=\"selected\">Todas</option>");
				else
					print("<option value=\"0\">Todas</option>");
				
				$condicionProvincia="";
				$orderProvincia="ORDER BY provincia_Nombre";
		
				$resProvincia=$provincia->obtenerConFiltro($condicionProvincia,$orderProvincia);
				$vectorProvincia=$provincia->conexion->BD_GetTupla($resProvincia);
				
				while($vectorProvincia!=NULL)
				{
					if($provincia_procedeFK_buscar==$vectorProvincia['provincia_CodPK'])
						print("<option value=\"" . $vectorProvincia['provincia_CodPK'] . "\" selected=\"selected\">" . $vectorProvincia['provincia_Nombre'] . "</option>");
					else
						print("<option value=\"" . $vectorProvincia['provincia_CodPK'] . "\">" . $vectorProvincia['provincia_Nombre'] . "</option>");
					
					$vectorProvincia=$provincia->conexion->BD_GetTupla($resProvincia);
				}//fin del while($vectorProvincia!=NULL)
			?>
			</select>
                </div>
		<div class="item" >
		<label class="label">Estado</label>
			<select class="select" name="estado_busqueda" id="estado_busqueda">
			<?PHP
			if(strcmp($estado_busqueda,"Todos")==0)
				print("<option value=\"Todos\" selected=\"selected\">Todos</option>");
			else
				print("<option value=\"Todos\">Todos</option>");
				
			if(strcmp($estado_busqueda,"Activo")==0)
				print("<option value=\"Activo\" selected=\"selected\">Activo</option>");
			else
				print("<option value=\"Activo\">Activo</option>");
				
			if(strcmp($estado_busqueda,"No_Activo")==0)
				print("<option value=\"No_Activo\" selected=\"selected\">No Activo</option>");
			else
				print("<option value=\"No_Activo\">No Activo</option>");
			?>
			</select>
		</div>	
		<div>
				<input type="submit" class="submit buscar dvOcultar" name="Jornada" value="Imprimir Jornadas" style="float: none; display: none;" onclick=this.form.action="generapdf.php">
				<input type="submit" class="submit buscar dvOcultar2" name="enviar2" value="buscar" style="float: none;" onclick=this.form.action="jornadas.php">			
		</div>

		<?PHP
			//paginacion de 50			
			$condicion="WHERE (cliente_Nombre LIKE '%" . $nombre_cliente_buscar . "%'
						OR cliente_DNI LIKE '%" . $nombre_cliente_buscar . "%'
						OR cliente_Direccion LIKE '%" . $nombre_cliente_buscar . "%' OR
						cliente_Numero LIKE '%" . $nombre_cliente_buscar . "%' OR
						cliente_Portal LIKE '%" . $nombre_cliente_buscar . "%' OR
						cliente_Piso LIKE '%" . $nombre_cliente_buscar . "%' OR
						cliente_Letra LIKE '%" . $nombre_cliente_buscar . "%' OR
						cliente_CodigoPostal LIKE '%" . $nombre_cliente_buscar . "%' OR
						cliente_Poblacion LIKE '%" . $nombre_cliente_buscar . "%' OR
						cliente_Movil LIKE '%" . $nombre_cliente_buscar . "%' OR
						cliente_Email LIKE '%" . $nombre_cliente_buscar . "%' OR
						cliente_Email2 LIKE '%" . $nombre_cliente_buscar . "%' OR
						cliente_Telefono LIKE '%" . $nombre_cliente_buscar . "%')";
			
			if(strcmp($estado_busqueda,"Todos")!="")
				$condicion=$condicion . " AND (cliente_Estado='" . $estado_busqueda . "')";
			//le añadimos el parametro del provincia de procedencia
			if($provincia_procedeFK_buscar!=0)
				$condicion=$condicion . " AND (cliente_ProvinciaFK=" . $provincia_procedeFK_buscar . ")";	
		?>
		
		
	    </form>
        	<!-- acaba buscador-->
        </div>
            
         	
            <ul id="listado_listados" class="dvOcultar2">
		<?PHP
			$order="ORDER BY cliente_Nombre";
		
			//print($condicion);
			$sql= $cliente->obtenerPaginadosConFiltro($condicion,$order);
						
			$paginacion->paginar($sql,50);
				
			// Mostrar resultados de la consulta
			$nfilas = mysql_num_rows ($paginacion->pagi_result);
			
			if($nfilas==0)		
				print("<li>No existen registros bajo los criterios de busqueda.</li>");
			
			for($i=0; $i<$nfilas;$i++)
			{
				$resultado = mysql_fetch_array ($paginacion->pagi_result);
				
				if(fmod($i,2)==0)
					print("<li id=\"rayado\">");
				else
					print("<li>");
				
				print("<a href=\"cliente_datos_contacto.php?codPK=" . $resultado['cliente_CodPK'] . $parametros_busqueda . "\">" . $resultado['cliente_CodPK'] . " - " . $resultado['cliente_Nombre'] . " | " . $resultado['cliente_Movil'] . " | " . $resultado['cliente_Email'] . "</a></li>");
			}//fin del for($i=0; $i<$nfilas;$i++)
			
		?>		    
            </ul>

           
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
<script type="text/javascript">
 $(function(){//ocultar checkbox
	$('.fantasma').change(function(){
  	if(!$(this).prop('checked')){
    	$('.dvOcultar').hide();
    	$('.dvOcultar2').show();
    }else{
    	$('.dvOcultar').show();
    	$('.dvOcultar2').hide();
    }
  
  })

});


  $(document).ready(function(){
  var date_input=$('input[id="daterange2"],input[id="daterange3"]'); //our date input has the name "date"
  var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
  date_input.datepicker({
    format: 'dd/mm/yyyy',
    container: container,
    todayHighlight: true,
    autoclose: true,
    language: 'es'

  })
});	
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/locales/bootstrap-datepicker.es.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
</html>