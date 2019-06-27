<?php 
session_start();
    include "/clases/fun_aux_menu.php";
    include "/clases/conexion.php";
    include "/clases/seguridad.php";

    $conexion = new conexion();
    
    Seguridad();
 ?>
<!DOCTYPE html>
<html>
<head>
<?php require "./layout/header.php"; ?>
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
		      <h1><i class="fa fa-car fa-lg"></i>Hello papajera!!</h1>
		      
		    </div>
		  </div>
		</div>

</div>

<?php require "./layout/footer.php"; ?>
</body>
</html>