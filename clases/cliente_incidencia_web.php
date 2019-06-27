<?PHP 
//Clase generada automaticamente por Awisoft Software y Sistemas SL

	
include_once("conexion.php");

class cliente_incidencia_web {

var $conexion;

function cliente_incidencia_web(){
	$this->conexion= new conexion();
}	
	
	
	function insertar($incidencia_FechaApertura, $incidencia_FechaCierre, $incidencia_Estado, $incidencia_Leido, $incidencia_ClienteLoginFK, $incidencia_Mensaje) {
		$consulta = "INSERT INTO cliente_incidencia_web(incidencia_FechaApertura, incidencia_FechaCierre, incidencia_Estado, incidencia_Leido, incidencia_ClienteLoginFK, incidencia_Mensaje) VALUES('$incidencia_FechaApertura', '$incidencia_FechaCierre', '$incidencia_Estado', '$incidencia_Leido', '$incidencia_ClienteLoginFK', '$incidencia_Mensaje')";
		$res = $this->conexion->BD_Consulta($consulta);
		return($res);
	}
	
	
	function eliminar($condicion) {
		$consulta = "DELETE FROM cliente_incidencia_web $condicion";
		$res = $this->conexion->BD_Consulta($consulta);
		return($res);	
	}
	
	function modificar($incidencia_FechaApertura, $incidencia_FechaCierre, $incidencia_Estado, $incidencia_Leido, $incidencia_ClienteLoginFK, $incidencia_Mensaje, $incidencia_CodPK) {
		$consulta = "UPDATE cliente_incidencia_web SET incidencia_FechaApertura='$incidencia_FechaApertura', incidencia_FechaCierre='$incidencia_FechaCierre', incidencia_Estado='$incidencia_Estado', incidencia_Leido='$incidencia_Leido', incidencia_ClienteLoginFK='$incidencia_ClienteLoginFK', incidencia_Mensaje='$incidencia_Mensaje'  WHERE incidencia_CodPK='$incidencia_CodPK'";
		$res = $this->conexion->BD_Consulta($consulta);
		return($res);
	}
	
	
	function obtener(){
		$consulta  = "SELECT incidencia_CodPK, incidencia_FechaApertura, incidencia_FechaCierre, incidencia_Estado, incidencia_Leido, incidencia_ClienteLoginFK, incidencia_Mensaje FROM cliente_incidencia_web";
		$res = $this->conexion->BD_Consulta($consulta);
		return($res);	
	}
	
	
	function obtenerConFiltro($condicion,$order){
		 if($condicion=="" && $order!="")
				$consulta  = "SELECT incidencia_CodPK, incidencia_FechaApertura, incidencia_FechaCierre, incidencia_Estado, incidencia_Leido, incidencia_ClienteLoginFK, incidencia_Mensaje FROM cliente_incidencia_web $order";				
		 else{
			 if($order=="" && $condicion!="")
					$consulta  = "SELECT incidencia_CodPK, incidencia_FechaApertura, incidencia_FechaCierre, incidencia_Estado, incidencia_Leido, incidencia_ClienteLoginFK, incidencia_Mensaje FROM cliente_incidencia_web $condicion";				
			 else{
				  if($order!="" && $condicion!="")		 
					$consulta  = "SELECT incidencia_CodPK, incidencia_FechaApertura, incidencia_FechaCierre, incidencia_Estado, incidencia_Leido, incidencia_ClienteLoginFK, incidencia_Mensaje FROM cliente_incidencia_web $condicion $order";
					else{
						if($order=="" && $condicion=="")		 
							$consulta  = "SELECT incidencia_CodPK, incidencia_FechaApertura, incidencia_FechaCierre, incidencia_Estado, incidencia_Leido, incidencia_ClienteLoginFK, incidencia_Mensaje FROM cliente_incidencia_web";
						}				
			  }
		}
									  
		$res = $this->conexion->BD_Consulta($consulta);
		return($res);	
	}
	
	
	function obtenerPaginados(){
		$consulta  = "SELECT incidencia_CodPK, incidencia_FechaApertura, incidencia_FechaCierre, incidencia_Estado, incidencia_Leido, incidencia_ClienteLoginFK, incidencia_Mensaje FROM cliente_incidencia_web";
		return($consulta);	
	}
	
	
	function obtenerPaginadosConFiltro($condicion,$order){
		 if($condicion=="" && $order!="")
				$consulta  = "SELECT incidencia_CodPK, incidencia_FechaApertura, incidencia_FechaCierre, incidencia_Estado, incidencia_Leido, incidencia_ClienteLoginFK, incidencia_Mensaje FROM cliente_incidencia_web $order";				
		 else{
			 if($order=="" && $condicion!="")
					$consulta  = "SELECT incidencia_CodPK, incidencia_FechaApertura, incidencia_FechaCierre, incidencia_Estado, incidencia_Leido, incidencia_ClienteLoginFK, incidencia_Mensaje FROM cliente_incidencia_web $condicion";				
			 else{
				  if($order!="" && $condicion!="")		 
					$consulta  = "SELECT incidencia_CodPK, incidencia_FechaApertura, incidencia_FechaCierre, incidencia_Estado, incidencia_Leido, incidencia_ClienteLoginFK, incidencia_Mensaje FROM cliente_incidencia_web $condicion $order";
					else{
						if($order=="" && $condicion=="")		 
							$consulta  = "SELECT incidencia_CodPK, incidencia_FechaApertura, incidencia_FechaCierre, incidencia_Estado, incidencia_Leido, incidencia_ClienteLoginFK, incidencia_Mensaje FROM cliente_incidencia_web";
						}				
			  }
		}
		return($consulta);	
	}
	
	
} 
?>