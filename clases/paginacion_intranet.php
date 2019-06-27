<?PHP
class paginacion_intranet{

var $pagi_cuantos;
var $pagi_actual;
var $pagi_navegacion;
var $pagi_result;

	
function paginar($_pagi_sql,$pagi=20){

	$this->pagi_cuantos=$pagi;
	
	//Se debe haber definido una variable $_pagi_sql
	//que contenga una sentencia sql v�lida
	
	if(empty($_pagi_sql)){
		//Si no se defini� $_pagi_sql... error!
		die("<b>Error paginaci�n : </b>No se ha definido la variable \$_pagi_sql");
	}

	if (empty($_GET['pg'])){
		//Si no se ha hecho click a ninguna p�gina espec�fica
		//O sea si es la primera vez que se ejecuta el script
		//$_pagi_actual es la pagina actual-->ser� por defecto la primera.
		$this->pagi_actual = 1;
	}else{
		//Si se "pidi�" una p�gina espec�fica:
		//La p�gina actual ser� la que se pidi�.
		$this->pagi_actual = $_GET['pg'];
	}
	
	//Contamos el total de registros en la BD (para saber cu�ntas p�ginas ser�n)
	$_pagi_sqlConta = preg_replace("/SELECT (.*) FROM/", "SELECT COUNT(*) FROM", $_pagi_sql);
	$_pagi_result2 = mysql_query($_pagi_sqlConta) or die ("Error en la consulta de conteo de registros. Mysql dijo: <b>".mysql_error()."</b>");
	$_pagi_totalReg = mysql_result($_pagi_result2,0,0);//total de registros
	
	//Calculamos el n�mero de p�ginas (saldr� un decimal)
	//con ceil() redondeamos y $_pagi_totyalPags ser� el n�mero total (entero) de p�ginas que tendremos
	$_pagi_totalPags = ceil($_pagi_totalReg / $this->pagi_cuantos);
	
	
	//Creamos la navegaci�n a p�ginas espec�ficas. Una l�nea tipo: <<anterior 1 2 3 4 siguiente>>
	
	//La idea es pasar tambi�n en los enlaces las variables hayan llegado por url.
	$_pagi_enlace = $_SERVER['PHP_SELF'];
	$_pagi_query_string = "?";
	if(isset($_GET)){
		//Si ya se han pasado variables por url, escribimos el query string concatenando
		//los elementos del array $_GET excepto la variable $_GET['pg'] si es que existe.
		$_pagi_variables = $_GET;
		foreach($_pagi_variables as $_pagi_clave => $_pagi_valor){
			if($_pagi_clave != 'pg'){
				$_pagi_query_string .= $_pagi_clave."=".$_pagi_valor."&";
			}
		}
	}
	
	//A�adimos el query string a la url.
	$_pagi_enlace .= $_pagi_query_string;
	
	//La variable $_pagi_navegacion contendr� los enlaces a las p�ginas.
	$this->pagi_navegacion = '';
	
	if ($this->pagi_actual != 1){
		//Si no estamos en la p�gina 1. Ponemos el enlace "anterior"
		$_pagi_url = $this->pagi_actual - 1;//ser� el n�mero de p�gina al que enlazamos
		$this->pagi_navegacion .= "<li><a href='".$_pagi_enlace."pg=".$_pagi_url."' class=\"siguiente\">&laquo; Anterior</a>&nbsp;&nbsp;</li>";
	}
	
	//Enlaces a n�meros de p�gina:
	for ($_pagi_i = 1; $_pagi_i<=$_pagi_totalPags; $_pagi_i++){//Desde p�gina 1 hasta �ltima p�gina ($_pagi_totalPags)
		if ($_pagi_i == $this->pagi_actual) {
			//Si el n�mero de p�gina es la actual ($_pagi_actual). Se escribe el n�mero, pero sin enlace y en negrita.
			$this->pagi_navegacion .= "<li><a href=\"#\" class=\"este\">$_pagi_i</a></li>";
		}else{
			//Si es cualquier otro. Se escibe el enlace a dicho n�mero de p�gina.
			$this->pagi_navegacion .= "<li><a href='".$_pagi_enlace."pg=".$_pagi_i."' class=\"pagina\">".$_pagi_i."</a></li>";
		}
	}
	
	if ($this->pagi_actual < $_pagi_totalPags){
		//Si no estamos en la �ltima p�gina. Ponemos el enlace "Siguiente"
		$_pagi_url = $this->pagi_actual + 1;//ser� el n�mero de p�gina al que enlazamos
		$this->pagi_navegacion .= "<li><a href='".$_pagi_enlace."pg=".$_pagi_url."' class=\"siguiente\">Siguiente &raquo;</a></li>";
	}
	//Hasta ac� hemos completado la "barra de navegaci�n"
	
	//Calculamos desde qu� registro se mostrar� en esta p�gina
	//Recordemos que el conteo empieza desde CERO.
	$_pagi_inicial = ($this->pagi_actual-1) * $this->pagi_cuantos;
	
	//Consulta SQL. Devuelve $cantidad registros empezando desde $_pagi_inicial
	$_pagi_sqlLim = $_pagi_sql." LIMIT $_pagi_inicial,$this->pagi_cuantos";
	$this->pagi_result = mysql_query($_pagi_sqlLim) or die ("Error en la consulta limitada. Mysql dijo: <b>".mysql_error()."</b>");
	
	//A partir de aqu� quedan disponibles dos variables:
	//$_pagi_navegacion : que contiene los enlaces para navegar por las p�ginas
	//$_pagi_result : que contiene el id del resultado de la consulta a la BD para los registros de la p�gina actual.
	}
}	
?>

