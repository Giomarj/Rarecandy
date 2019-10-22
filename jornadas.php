<?php 
session_start();
    include "clases/fun_aux_menu.php";
	include_once "clases/conexion.php";
	include_once "clases/fechas.php";
	include_once "clases/seguridad.php";
	include_once "clases/paginacion_intranet.php";
	include_once "clases/paginacion.php";
	include_once "clases/cliente.php";
	include_once "clases/empleados.php";		
	include_once "clases/provincia.php";


	$cliente = new cliente();
	$empleados = new empleados();
	$paginacion = new paginacion();
	$conexion = new conexion();	
	$provincia = new provincia();
    
    Seguridad();
	Admin();
	$ocultarform="ocultarform";
	$daterange ="";
	$daterange3="";
	$daterange2 ="";
	$daterange4 ="";
	$provincia_procedeFK_buscar=0;

	if(isset($_POST['daterange3']) && trim($_POST['daterange3'])!="" && isset($_POST['daterange3']) && trim($_POST['daterange3'])!="")
		$ocultarform="";
	
	if(isset($_GET['provincia_procedeFK']) && trim($_GET['provincia_procedeFK'])!="")
		$provincia_procedeFK_buscar=$_GET['provincia_procedeFK'];

	if(isset($_POST['daterange2']) && trim($_POST['daterange2'])!="")
		$daterange4=$_POST['daterange2'];

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
<style type="text/css">
	.ocultarform{
		display: none;
	}
</style>
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
	    <form class="form" name="buscador_user" id="buscador_user" method="post" action="">
		<input type="hidden" name="aux_buscador" id="aux_buscador" />	
			<div class="resultados">
            <h2>Filtrar por fecha para ver resultados</h2>
            <br>
            		<div class="row">
								 
								 		<div class="form-group">
					           			 <div class='input-group date' id='datetimepicker'>
					           			 	<div class="col-md-2"></div>	
									 		<div class="col-md-5">
									 			<label style="float: left;"><i class="fa fa-calendar" style="padding-right:3px; padding-bottom: 4px;"></i> Desde: <?PHP print($daterange4);?></label>
					               				 <input type='text' class="form-control" name="daterange2" id="daterange2" value="<?PHP print($daterange4);?>" placeholder="Seleccione Rango de Fecha" style="padding: 6px 65px;" autocomplete="off" />									 			
									 		</div>
									 		<div class="col-md-5">
									 			<label style="float: left;"><i class="fa fa-calendar" style="padding-right:4px; padding-bottom: 4px;"></i>Hasta: <?PHP print($daterange3);?></label>
					               				 <input type='text' style="padding: 6px 65px;" class="form-control" name="daterange3" id="daterange3" value="<?PHP print($daterange3);?>" placeholder="Seleccione Rango de Fecha" autocomplete="off"/>									 			
									 		</div>

					            </div>
						        </div>

						    
				    </div>
	</div> 
<!-- 		<div class="item <?PHP print($ocultarform);?>" style="margin-right: 20px;">
					<div style="float: right;" for="cbmostrar">
			    		<br>
					  <input type="checkbox" name="cbmostrar" class="fantasma" />
					  Imprimir jornadas de todos los empleados
					</div>
		</div> -->

		<div class="item dvOcultar2 <?PHP print($ocultarform);?>" style="margin-left: 300px;">
		<label class="label">Nombre</label><input autofocus type="text" class="input" name="nombre_cliente" id="nombre_cliente" value="<?PHP print($nombre_cliente_buscar);?>"/>
		<span class="explicacion">Busca por cualquier dato de cliente, menos por observaciones, login y pass</span>
		</div>
<!-- 		<div class="item <?PHP print($ocultarform);?>" >
                <label class="label">Jornada</label>
			<select class="select" name="provincia_procedeFK" id="provincia_procedeFK">	
				<option value="0" selected="selected">Completa</option>
				<option value="1">media</option>			
			</select>
        </div> -->
		<div class="item <?PHP print($ocultarform);?>" >
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
<!-- 				<input type="submit" class="submit buscar dvOcultar" name="Jornada" value="Imprimir Jornadas" style="float: none; display: none;" onclick=this.form.action="generapdf.php"> -->
				<input type="submit" class="submit buscar dvOcultar2" name="enviar2" value="buscar" style="float: none;" onclick=this.form.action="jornadas.php">			
		</div>
		
		
	    </form>
        	<!-- acaba buscador-->
        </div>
            	
            <ul id="listado_listados" class="dvOcultar2 <?PHP print($ocultarform);?>">
		<?PHP
			if (isset($_POST['daterange2']) && isset($_POST['daterange3'])) {
				$date1 = strtr($_POST['daterange2'], '/', '-');
 				$daterange=date('Y-m-d', strtotime($date1));
				$date2 = strtr($_POST['daterange3'], '/', '-');
 				$daterange2=date('Y-m-d', strtotime($date2));
		    }

		 // 	   if ($_POST['daterange2']=="" && $_POST['daterange3']==""){
			// 		$swhere = " ";
			// 	} else {
			// 	$swhere = " AND t.Fecha BETWEEN '$daterange' AND '$daterange2'"; 
			// 	}
				
			// //paginacion de 50			
			// $condicion=", stp_empresa e, cliente c
			// 			WHERE e.empresa_CodPK = stp_users.user_empresaid 
			// 			AND e.empresa_CodPK = c.cliente_empresaid 
			// 			AND c.cliente_empresaid = ".$vector['cliente_empresaid']."
			// 			AND (stp_users.user_name LIKE '%" . $nombre_cliente_buscar . "%'
			// 			OR stp_users.user_gender LIKE '%" . $nombre_cliente_buscar . "%'
			// 			OR stp_users.user_CodPK LIKE '%" . $nombre_cliente_buscar . "%' OR
			// 			stp_users.user_Comment LIKE '%" . $nombre_cliente_buscar . "%')";
			
			// if(strcmp($estado_busqueda,"Todos")!="")
			// 	$condicion=$condicion . " AND (cliente_Estado='" . $estado_busqueda . "')";
			// //le añadimos el parametro del provincia de procedencia
			// if($provincia_procedeFK_buscar!=0)
			// 	$condicion=$condicion . " AND (cliente_ProvinciaFK=" . $provincia_procedeFK_buscar . ")";	
			$order="ORDER BY user_name";
		
			//print($condicion);
			// $sql= $empleados->obtenerPaginadosConFiltro($condicion,$order);
				$sql="SELECT user_CodPK, user_empresaid, user_id, user_Din, user_name, user_enroll_id, user_card_id, user_att_rules, user_att_default, user_default_weekend, user_gender, user_regsiter_date, user_id_no, user_phone, user_email, user_address, user_Comment, user_password, user_deptId, user_AttId, user_RuleId, user_WeekendId, user_LockedOut, user_IsApproved, user_LastLoginDate FROM stp_users, stp_empresa e, cliente c WHERE e.empresa_CodPK = stp_users.user_empresaid AND e.empresa_CodPK = c.cliente_empresaid AND c.cliente_empresaid = ".$vector['cliente_empresaid']." AND (stp_users.user_name LIKE '%" . $nombre_cliente_buscar . "%'
						OR stp_users.user_gender LIKE '%" . $nombre_cliente_buscar . "%'
						OR stp_users.user_CodPK LIKE '%" . $nombre_cliente_buscar . "%' OR
						stp_users.user_Comment LIKE '%" . $nombre_cliente_buscar . "%') ORDER BY user_name";	
			$paginacion->paginar($sql,30);
				
			// Mostrar resultados de la consulta
			$nfilas = mysql_num_rows ($paginacion->pagi_result);
			if($nfilas==0)		
				print("<li>No existen registros bajo los criterios de busqueda.</li>");
			
			for($i=0; $i<$nfilas;$i++)
			{
				$resultado = mysql_fetch_array($paginacion->pagi_result);
				
				if(fmod($i,2)==0)
					print("<li id=\"rayado\">");
				else
					print("<li>");
				
				print("<a href=\"reporte_jornada.php?daterange=". $daterange ."&daterange2=". $daterange2 ."&cod_empleado=" . $resultado['user_CodPK'] . "\" target=\"_blank\">" . $resultado['user_CodPK'] . " - " . $resultado['user_name'] . " | " . $resultado['user_Comment'] . " | " . $resultado['user_gender'] . "</a></li>");
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