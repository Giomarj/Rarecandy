<?php
session_start();
    include "clases/fun_aux_menu.php";
	include_once "clases/conexion.php";
	include_once "clases/fechas.php";
	include_once "clases/seguridad.php";
	include_once "clases/paginacion_intranet.php";
	include_once "clases/cliente.php";	
	include_once "clases/provincia.php";

	$conexion = new conexion();	
	$cliente = new cliente();
	$paginacion = new paginacion_intranet();
	$provincia = new provincia();


    Seguridad();

	Admin();

	$provincia_procedeFK_buscar=0;

	if(isset($_GET['provincia_procedeFK']) && trim($_GET['provincia_procedeFK'])!="")
		$provincia_procedeFK_buscar=$_GET['provincia_procedeFK'];
	
	$nombre_cliente_buscar="";

	if(isset($_GET['nombre_cliente']))
		$nombre_cliente_buscar=$_GET['nombre_cliente'];
		
	$parametros_busqueda="";
				
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
		
		
		$foto=$_FILES['foto']['name'];
		
		
		//vemos si hay clientes con el mismo dni o con el mismo nie
		//PETICION DE SERGIO DIA 25/06/2015
		/*$condicionDatos="WHERE cliente_DNI='".$dni."'";
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
			$cliente_Login=$dni;
			
			//vemos si hay clientes con el mismo login		
			$condicionDatos="WHERE cliente_Login='".$cliente_Login."'";
			$orderDatos="";
	
			$resDatos=$cliente->obtenerConFiltro($condicionDatos,$orderDatos);
			$vectorDatos=$cliente->conexion->BD_GetTupla($resDatos);
			
			while($vectorDatos!=NULL)
			{
				$cliente_Login=$cliente_Login . "X";
				
				$condicionDatos="WHERE cliente_Login='".$cliente_Login."'";
				$orderDatos="";
	
				$resDatos=$cliente->obtenerConFiltro($condicionDatos,$orderDatos);
				$vectorDatos=$cliente->conexion->BD_GetTupla($resDatos);
			}
		
			//Creacion de la Pass -> esta en fun_aux_menu.php
			$cliente_Pass=CreacionClave();
			
			
			$cliente->insertar($nombre, $dni, $direccion, $numero, $portal, $piso, $letra, $cp, $provinciaFK, $poblacion, $movil, $email, $email2, $telefono_urgencia, $comentarios_otra_informacion, $cliente_Login, $cliente_Pass, $foto);

		
			//Obtener CodPK del ultimo cliente insertado
			$clientePK = mysql_insert_id($conexion->BD);
			
			//Archivo
			if (trim($_FILES['foto']['name'])!="")
			{
			       $separado = explode(".",$foto); 
			       $ext2 = strtolower($separado[count($separado)-1]); //cogemos la extension (ya en minusculas) 					
			
				$foto=$cliente->subirImagen($_FILES['foto']['tmp_name'],$clientePK,$ext2);
				
				$cliente->modificarLogo($foto, $clientePK);
			}//fin del if (trim($_FILES['foto']['name'])!="")
			
		}//fin del if(trim($errores)!="")	
		
	}//fin dl if(isset($_POST['aux']))
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
           <span class="titulo">Gestión de clientes</span>
           <form class="form" name="pedido_form" id="pedido_form" method="post" action="cliente_add.php?aux=1<?PHP print($parametros_busqueda);?>" style="clear:both" enctype="multipart/form-data">
		<input type="hidden" name="aux" id="aux" />
		
		<div class="item">
		<label for="nombre" class="label">* Nombre</label>
		<input type="text" class="input" name="nombre" id="nombre" />
		</div>
		
		<div class="item file">			
		<label class="label">Logo</label><input type="file" class="input" name="foto" id="foto" />
		<span class="explicacion">Peso máx. 24KB. Tamaño: 45px x45 px</span>
		</div>
		
		<div class="item peq2">
		<label for="dni" class="label peq2" >* DNI/CIF</label>
		<input type="text" class="input peq2" name="dni" id="dni" maxlength="9"   />
		</div>
		
		<div class="item direccion" >
		<label for="direccion" class="label ">* Direcci&oacute;n</label>
		<input type="text" class="input direccion" name="direccion" id="direccion" /><!-- value="Direccion" onfocus="this.value=''" />-->
		</div>
		
		<div class="item peq">
		<label for="numero" class="label  peq">* Numero</label>
		<input type="text" class="input peq" name="numero" id="numero" /><!--value="Numero" onfocus="this.value=''" />-->
		</div>
		
		<div class="item peq">
		<label for="portal" class="label peq">Portal</label>
		<input type="text" class="input peq" name="portal" id="portal" />
		</div>
		
		<div class="item peq">
		<label for="piso" class="label  peq">Piso</label>
		<input type="text" class="input peq" name="piso" id="piso" />
		</div>
		
		<div class="item peq">
			<div >
			<label for="letra" class="label  peq">Letra <!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pais --></label>
			<input type="text" class="input peq" name="letra" id="letra" />
			</div>
<!-- 			<div style="display:inline !important; width: 50%"> 
			<select class="select" name="pais" id="pais" style="width: 45%; margin: 5px 0 0 6px;">
			<option value="">Selecione</option>
			<option value="Espana">España</option>
			<option value="Portugal">Portugal</option>
			</select>
			</div> -->
		</div>
		
		<div class="item peq2">         
		<label for="cp" class="label ">* Código Postal</label>
		<input type="text" class="input peq" name="cp" id="cp" />       
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
				print("<option value=\"" . $vectorProv['provincia_CodPK'] . "\">" . $vectorProv['provincia_Nombre'] . "</option>");
				$vectorProv=$provincia->conexion->BD_GetTupla($resProv);
			}//fin del while($vectorProv!=NULL)
		?>
		</select>
		</div>
		
		<div class="item">	 
		<label for="poblacion" class="label">* Poblacion</label>
		<input type="text" class="input" name="poblacion" id="poblacion"  />
		</div>
		
		<div class="item">
		<label for="movil" class="label">* Móvil</label>
		<input type="text" class="input" name="movil" id="movil"  />
		</div>
		
		<div class="item">
	 	<label for="email" class="label">* Email 1</label>
		<input type="text" class="input" name="email" id="email"  />
		</div>
		
		<div class="item">
	 	<label for="email_repe" class="label">* Repetir Email 1</label>
		<input type="text" class="input" name="email_repe" id="email_repe"  />
		</div>
		
		<div class="item">
		<label for="email2" class="label">Email 2</label>
		<input type="text" class="input" name="email2" id="email2"  />	 
		</div>
		
		<div class="item" >
		<label for="telefono_urgencia" class="label" style="width:400px">Otros Telefonos</label>
		<input type="text" class="input" name="telefono_urgencia" id="telefono_urgencia"  />
		</div>
		
		<div style=" clear: both"></div>
		
		<h2 class=" titulo2">Otra información</h2>
		        
		<div class="item grande" >
		<label for="comentarios_otra_informacion" class="label">Comentarios:</label>
		<textarea class="textareagrande" style="font-size:12px; padding-left: 7px" name="comentarios_otra_informacion" id="comentarios_otra_informacion"></textarea>
		</div>

		<a class="submit buscar" href="#" title="Añadir" onclick="cliente_anadir();"><span>Añadir</span></a>
            </form>
       		
                    
            
           </div>
        
	<a href="clientes.php?ruta=1<?PHP print($parametros_busqueda);?>" class="submit buscar" style="float: left;">Atrás</a>

           <!-- acaba mideel contenido gris--></div>








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
			$cadena="Se ha insertado la informacion correctamente.";
			print("<script>ventana_nn('ventana_mensaje.php?cadena=" . $cadena . "');</script>");
		}//fin del else del  if(trim($errores)!="")
	}//fin del if(isset($_POST['aux']))
?>