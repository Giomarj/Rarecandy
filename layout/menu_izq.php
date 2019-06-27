<?php 
    $sql="SELECT * FROM cliente WHERE cliente_Login='".$_SESSION['usuario_salto']."' AND cliente_Pass='".$_SESSION['password_salto']."' AND cliente_Estado='Activo'";
    $res=$conexion->BD_Consulta($sql);
    $vector=$conexion->BD_GetTupla($res);
	
	if($vector==NULL)
	{
		print("<script>document.location.href='index.php'</script>");
		exit();	 
	}
	
	$tipo=$vector['tipo'];
	
print("<div class=\"menu_izq\" >
	<ul class=\"menu\">");
	
	if(strcmp($tipo,"admin")==0)
	{

			
		$sqlInci="SELECT COUNT(*) AS Num FROM cliente_incidencia_web WHERE incidencia_Leido='No'";
		$resInci=$conexion->BD_Consulta($sqlInci);
		$tuplaInci=$conexion->BD_GetTupla($resInci);
		
		$cadena_incidencias="";
		
		if($tuplaInci!=NULL && $tuplaInci['Num']>0)
			$cadena_incidencias=$tuplaInci['Num'] . " <i class=\"fa fa-envelope\" style=\"font-size:18px; padding-bottom: 3px;\"></i>";
			
		if(trim($cadena_incidencias)!="")
			$cadena_incidencias="<span style=\"color:#FF0000; padding-left: 2%; font: bold 18px;\"><b>" . $cadena_incidencias . "</b></span>";

		print("<li><a href=\"clientes.php\"><i class=\"icono izq fa fa-users\" style=\"font-size:27px; padding-bottom: 3px;\"></i><b>Clientes</b></a></li>");
		print("<li><a href=\"incidencias.php\"><i class=\"icono izq fa fa-exclamation-circle\" style=\"font-size:35px\"></i><b>Incidencias</b>" . $cadena_incidencias . "</a></li>");
	}
		print("<li><a href=\"jornadas.php\"><i class=\"icono izq fa fa-address-card\" style=\"font-size:27px\"></i><b>Jornadas</b></a></li>");
		print("<li><a href=\"mis-consultas.php\"><i class=\"icono izq fa fa-envelope\" style=\"font-size:30px\"></i><b>Consultas</b></a></li>");
	
		print("</ul>
 </div>");
 ?>



