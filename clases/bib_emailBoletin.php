<?php
include_once "class.phpmailer.php";

function email($Direccionmail,$from,$asunto,$cuerpo,$ficheroAEnviar,$nombreAMostrar)
{
//instanciamos un objeto de la clase phpmailer al que llamamos 
//por ejemplo mail
$mail = new phpmailer();

//Definimos las propiedades y llamamos a los métodos 
//correspondientes del objeto mail

//Con PluginDir le indicamos a la clase phpmailer donde se 
//encuentra la clase smtp que como he comentado al principio de 
//este ejemplo va a estar en el subdirectorio email
$mail->PluginDir = "";

//Con la propiedad Mailer le indicamos que vamos a usar un 
//servidor smtp
$mail->Mailer = "smtp";

//Asignamos a Host el nombre de nuestro servidor smtp
$mail->Host = "smtp.saltotech.com";

//Le indicamos que el servidor smtp requiere autenticación
$mail->SMTPAuth = true;

//Le decimos cual es nuestro nombre de usuario y password
$user="info@saltotech.com";

$pass="Saltotech2019";

$mail->Username = $user; 
$mail->Password = $pass;

//Indicamos cual es nuestra dirección de correo y el nombre que 
//queremos que vea el usuario que lee nuestro correo
$mail->From = $from;
$mail->FromName = $asunto;

//el valor por defecto 10 de Timeout es un poco escaso dado que voy a usar 
//una cuenta gratuita, por tanto lo pongo a 30  
$mail->Timeout=10;

//Indicamos cual es la dirección de destino del correo
$mail->AddAddress("" . $Direccionmail . "");


//Asignamos asunto y cuerpo del mensaje
//El cuerpo del mensaje lo ponemos en formato html, haciendo 
//que se vea en negrita
$mail->Subject = $asunto;
$mail->Body = $cuerpo;

//Definimos AltBody por si el destinatario del correo no admite 
//email con formato html
$mail->AltBody = $cuerpo;

/*
//Creamos el fichero
$fp=fopen("./ficherosAdjuntos/" . $cadenaUnica . ".htm","w");
fputs($fp,$cadenaDev);
fclose($fp);
*/

if(trim($ficheroAEnviar)!="")
{
	//Indicamos el fichero a adjuntar si el usuario seleccionó uno en el formulario
	//el fichero a Enviar ya tiene incluida la extension
	//$archivo="./ficherosAdjuntos/" . $ficheroAEnviar;

	//Obtener la extension
	$separado = explode(".",$ficheroAEnviar); 
	$ext = strtolower($separado[count($separado)-1]); //cogemos la extension (ya en minusculas)

	if ($ficheroAEnviar !="none") {
		$mail->AddAttachment($ficheroAEnviar,$nombreAMostrar);
	}
}

//se envia el mensaje, si no ha habido problemas 
//la variable $exito tendra el valor true
$exito = $mail->Send();
//$exito=true;
//print($cuerpo);

//Si el mensaje no ha podido ser enviado se realizaran 4 intentos mas como mucho 
//para intentar enviar el mensaje, cada intento se hara 5 segundos despues 
//del anterior, para ello se usa la funcion sleep	
$intentos=1; 
while ((!$exito) && ($intentos < 5)) {
sleep(5);	
	$exito = $mail->Send();
	$intentos=$intentos+1;	

}

return $exito;
}
?>