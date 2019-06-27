<?PHP
		$dato1="";
		$dato2="";
		$dato3="";
		$dato4="";
		$dato5="";
		$dato6="";
		$dato7="";
		$dato8="";
		$dato9="";
		$dato10="";
		$datoimg="";


function correoEnvioClaves($nombre, $login, $pass)
{

		$dato1="Envio Claves";
		$dato2="Estimado/a";
		$dato3="Acaba de reservar satisfactoriamente su viaje en modo Bloqueo, por favor no olvide desbloquear las plazas en las siguientes 48 horas";
		$dato4="Numero de cuenta";
		$dato5="Usuario";
		$dato6="Contraseña";
		$dato7="En caso de no poder abrir el adjunto, por favor pulse";
		$dato8="Si no desea seguir recibiendo este correo o lo est&aacute; recibiendo por error, notifiquenoslo respondiendo a este mismo correo.";
		$dato9="Acceso al Cliente";
		$dato10="A continuación, te facilitamos tus datos para poder entrar al área de";
		$datoimg="superior.jpg";
	
	$cadena="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
	     <html xmlns=\"http://www.w3.org/1999/xhtml\">
	     <head>
	     <meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
	     <title>Saltotech - ". $dato1 ."</title>
	     
	     </head>
	     
	     <body>
	     <table width=\"496\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
	       <tr>
		     <td><img src=\"http://www.saltotech.com/correos/boletin/graficos/" . $datoimg . "\" alt=\"Saltotech, ". $dato1 ."\" width=\"496\" height=\"133\" /></td>
	       </tr>
	       <tr>
		     <td style=\"background-image:url(http://www.saltotech.com/correos/boletin/graficos/fondo.jpg); background-repeat:repeat-y;\">
		     <div style=\"padding:10px 20px 10px 20px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px; color:#666666;\">	
				<p><strong>Saltotech</strong>.</p>
				<p>". $dato2 .": " . $nombre . "<br /><br />				
				". $dato10 ." <a target=\"_blank\" href=\"http://www.saltotech.com/index.php?tipoFK=1\">". $dato9 ."</a><br /><br />
				". $dato5 .": " . $login . "<br />
				". $dato6 .": " . $pass . "<br /><br /><br />				
				</p>
		       </div>
			     <div style=\"padding:10px 20px 10px 20px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px; color:#666666;\">
			       <p align=\"left\">". $dato8 ."</p>	
		     </div>	</td>
	       </tr>
	       <tr>
		     <td><img src=\"http://www.saltotech.com/correos/boletin/graficos/inferior.jpg\" width=\"496\" height=\"39\" /></td>
	       </tr>
	     </table>
	     </body>";
	     
	return $cadena;
}//fin del function correoEnvioClaves($tipoCaratulaFK, $nombre, $login, $pass)


function correoConsultaAbierta( $nombre, $mensaje)
{

		$dato1="El cliente";
		$dato2="ha insertado la siguiente consulta";
		$dato3="Mensaje";
		$datoimg="superior.jpg";


	$cadena="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns=\"http://www.w3.org/1999/xhtml\">
		<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
		<title>Saltotech</title>
	     
		</head>
	     
		<body>
		<table width=\"496\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
		<tr>
		     <td><img src=\"http://www.saltotech.com/correos/boletin/graficos/" . $datoimg . "\" alt=\"Saltotech\" width=\"496\" height=\"133\" /></td>
		</tr>
		<tr>
			<td style=\"background-image:url(http://www.saltotech.com/correos/boletin/graficos/fondo.jpg); background-repeat:repeat-y;\">
			<div style=\"padding:10px 20px 10px 20px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px; color:#666666;\">	
				<p><strong>Saltotech</strong>.</p>
				<p>". $dato1 .": " . $nombre . ", ". $dato2 .":<br /></p>
				<p><strong>". $dato3 .":</strong>" . $mensaje . "</p>
			</div>
			</td>
		</tr>
		<tr>
		     <td><img src=\"http://www.saltotech.com/correos/boletin/graficos/inferior.jpg\" width=\"496\" height=\"39\" /></td>
		</tr>
		</table>
		</body>";
	     
	return $cadena;
}//fin del function correoConsultaAbierta($caratula_Cliente_Tupla, $nombre, $mensaje)

function correoConsultaRespuesta($nombre, $pregunta, $respuesta)
{

		$dato2="Estimado/a";
		$dato3="se ha insertado la siguiente respuesta";
		$dato4="Pregunta";
		$dato5="Respuesta";
		$datoimg="superior.jpg";
	
	$cadena="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
		<html xmlns=\"http://www.w3.org/1999/xhtml\">
		<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
		<title>Saltotech</title>
	     
		</head>
	     
		<body>
		<table width=\"496\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">
		<tr>
		     <td><img src=\"http://www.saltotech.com/correos/boletin/graficos/" . $datoimg . "\" alt=\"Saltotech\" width=\"496\" height=\"133\" /></td>
		</tr>
		<tr>
			<td style=\"background-image:url(http://www.saltotech.com/correos/boletin/graficos/fondo.jpg); background-repeat:repeat-y;\">
			<div style=\"padding:10px 20px 10px 20px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px; color:#666666;\">	
				<p><strong>Saltotech</strong>.</p>
				<p>". $dato2 .": " . $nombre . ", ". $dato3 .":<br /></p>
				<p><strong>". $dato4 .":</strong>" . $pregunta . "</p>
				<p><strong>". $dato5 .":</strong>" . $respuesta . "</p>
			</div>
			</td>
		</tr>
		<tr>
		     <td><img src=\"http://www.saltotech.com/correos/boletin/graficos/inferior.jpg\" width=\"496\" height=\"39\" /></td>
		</tr>
		</table>
		</body>";
	     
	return $cadena;
}//fin del function correoConsultaRespuesta($tipoCaratulaFK, $nombre, $pregunta, $respuesta)
?>