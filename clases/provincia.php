<?PHP 
//Clase generada automaticamente por Awisoft Software y Sistemas SL

	
include_once("conexion.php");

class provincia {

var $conexion;

function provincia(){
	$this->conexion= new conexion();
}	
	
	
function insertar($provincia_Nombre) {
	$consulta = "INSERT INTO provincia(provincia_Nombre) VALUES('$provincia_Nombre')";	
	$res = $this->conexion->BD_Consulta($consulta);	
	return($res);
}
	
	
	
function eliminar($condicion) {
	$consulta = "DELETE FROM provincia $condicion";	
	$res = $this->conexion->BD_Consulta($consulta);	
	return($res);	
}
	
	
function modificar($provincia_Nombre, $provincia_CodPK) {
	$consulta = "UPDATE provincia SET provincia_Nombre='$provincia_Nombre' WHERE provincia_CodPK='$provincia_CodPK'";	
	$res = $this->conexion->BD_Consulta($consulta);	
	return($res);
}
	
	
function obtener(){
	$consulta  = "SELECT provincia_CodPK, provincia_Nombre FROM provincia";									  
	$res = $this->conexion->BD_Consulta($consulta);				
	return($res);	
}
	
	
function obtenerConFiltro($condicion,$order){
	 if($condicion=="" && $order!="")
			$consulta  = "SELECT provincia_CodPK, provincia_Nombre FROM provincia $order";				
	 else{
		 if($order=="" && $condicion!="")
				$consulta  = "SELECT provincia_CodPK, provincia_Nombre FROM provincia $condicion";				
		 else{
			  if($order!="" && $condicion!="")		 
				$consulta  = "SELECT provincia_CodPK, provincia_Nombre FROM provincia $condicion $order";
				else{
					if($order=="" && $condicion=="")		 
						$consulta  = "SELECT provincia_CodPK, provincia_Nombre FROM provincia";
					}				
		  }
	}								  
	$res = $this->conexion->BD_Consulta($consulta);				
	return($res);	
}
	
	
function obtenerPaginados(){
	$consulta  = "SELECT provincia_CodPK, provincia_Nombre FROM provincia";				
	return($consulta);	
}
	
	
function obtenerPaginadosConFiltro($condicion,$order){
	 if($condicion=="" && $order!="")
			$consulta  = "SELECT provincia_CodPK, provincia_Nombre FROM provincia $order";				
	 else{
		 if($order=="" && $condicion!="")
				$consulta  = "SELECT provincia_CodPK, provincia_Nombre FROM provincia $condicion";				
		 else{
			  if($order!="" && $condicion!="")		 
				$consulta  = "SELECT provincia_CodPK, provincia_Nombre FROM provincia $condicion $order";
				else{
					if($order=="" && $condicion=="")		 
						$consulta  = "SELECT provincia_CodPK, provincia_Nombre FROM provincia";
					}				
		  }
	}				
	return($consulta);	
}
	
	
} 
?>