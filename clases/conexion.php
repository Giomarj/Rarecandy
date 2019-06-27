<?php
class conexion {

var $BD;

//Constructor
function conexion(){

	$bd_nombre="saltotech";
	$bd_usuario="root";
	$bd_password="";
	$bd_ubicacion="localhost";

	date_default_timezone_set('Europe/Madrid');
	/*
	date_default_timezone_set('Europe/Madrid');
	$bd_nombre="";
	$bd_usuario="user_gsgiopsklas";
	$bd_password="Aj8h?n34.la891ikasd";
	$bd_ubicacion="localhost";*/



	$bd=NULL;

	$bd=mysql_connect($bd_ubicacion, $bd_usuario, $bd_password);
	if($bd)
	{
		if(mysql_select_db($bd_nombre, $bd))
			$this->BD=$bd;
		else
			$this->BD=NULL;
	}
}


// Devuelve 1 si se ha cerrado la base de datos o NULL si hay error
function BD_Cerrar()
{
	if(mysql_close($this->BD))
		return (1);
	else
		return (NULL);
}

// Ejecuta una consulta en la base de datos. Devuelve NULL si hay error.
function BD_Consulta($consulta)
{
	$resultado=FALSE;
	$i=0;

	while(!$resultado AND $i<3)
	{
		$resultado=mysql_query($consulta, $this->BD);
		$i++;
	}

	if($resultado)
		return ($resultado);
	else
		return (NULL);
}

// Devuelve el numero de filas de una consulta
function BD_NumeroFilas($consulta)
{
	$filas=mysql_num_rows($consulta);

	return $filas;
}

// Devuelve un array con una tupla del resultado usando el nombre de campo como indice
// Devuelve NULL si no quedan m�s filas
function BD_GetTupla($resultado)
{
	$tupla = array();
	$tupla = mysql_fetch_array($resultado);

	return $tupla;

}

// Libera el resultado de una consulta
function BD_BorraResultado($resultado)
{
	mysql_free_result($resultado);
}
}?>
