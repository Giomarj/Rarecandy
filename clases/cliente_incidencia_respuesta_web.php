<?PHP 
//Clase generada automaticamente por Awisoft Software y Sistemas SL

	
include_once("conexion.php");

class cliente_incidencia_respuesta_web {

var $conexion;

function cliente_incidencia_respuesta_web(){
	$this->conexion= new conexion();
}	
	
	
	function insertar($respuesta_Fecha, $respuesta_Mensaje, $respuesta_Leido, $respuesta_IncidenciaFK, $respuesta_OrigenRespuesta, $respuesta_UserFK) {
		$consulta = "INSERT INTO cliente_incidencia_respuesta_web(respuesta_Fecha, respuesta_Mensaje, respuesta_Leido, respuesta_IncidenciaFK, respuesta_OrigenRespuesta, respuesta_UserFK) VALUES('$respuesta_Fecha', '$respuesta_Mensaje', '$respuesta_Leido', '$respuesta_IncidenciaFK', '$respuesta_OrigenRespuesta', '$respuesta_UserFK')";
		$res = $this->conexion->BD_Consulta($consulta);
		return($res);
	}
	
	
	function eliminar($condicion) {
		$consulta = "DELETE FROM cliente_incidencia_respuesta_web $condicion";
		$res = $this->conexion->BD_Consulta($consulta);
		return($res);	
	}
	
	function modificar($respuesta_Fecha, $respuesta_Mensaje, $respuesta_Leido, $respuesta_IncidenciaFK, $respuesta_OrigenRespuesta, $respuesta_UserFK, $respuesta_CodPK) {
		$consulta = "UPDATE cliente_incidencia_respuesta_web SET respuesta_Fecha='$respuesta_Fecha', respuesta_Mensaje='$respuesta_Mensaje', respuesta_Leido='$respuesta_Leido', respuesta_IncidenciaFK='$respuesta_IncidenciaFK', respuesta_OrigenRespuesta='$respuesta_OrigenRespuesta', respuesta_UserFK='$respuesta_UserFK'  WHERE respuesta_CodPK='$respuesta_CodPK'";
		$res = $this->conexion->BD_Consulta($consulta);
		return($res);
	}
	
	
	function obtener(){
		$consulta  = "SELECT respuesta_CodPK, respuesta_Fecha, respuesta_Mensaje, respuesta_Leido, respuesta_IncidenciaFK, respuesta_OrigenRespuesta, respuesta_UserFK FROM cliente_incidencia_respuesta_web";
		$res = $this->conexion->BD_Consulta($consulta);
		return($res);	
	}
	
	
	function obtenerConFiltro($condicion,$order){
		 if($condicion=="" && $order!="")
				$consulta  = "SELECT respuesta_CodPK, respuesta_Fecha, respuesta_Mensaje, respuesta_Leido, respuesta_IncidenciaFK, respuesta_OrigenRespuesta, respuesta_UserFK FROM cliente_incidencia_respuesta_web $order";				
		 else{
			 if($order=="" && $condicion!="")
					$consulta  = "SELECT respuesta_CodPK, respuesta_Fecha, respuesta_Mensaje, respuesta_Leido, respuesta_IncidenciaFK, respuesta_OrigenRespuesta, respuesta_UserFK FROM cliente_incidencia_respuesta_web $condicion";				
			 else{
				  if($order!="" && $condicion!="")		 
					$consulta  = "SELECT respuesta_CodPK, respuesta_Fecha, respuesta_Mensaje, respuesta_Leido, respuesta_IncidenciaFK, respuesta_OrigenRespuesta, respuesta_UserFK FROM cliente_incidencia_respuesta_web $condicion $order";
					else{
						if($order=="" && $condicion=="")		 
							$consulta  = "SELECT respuesta_CodPK, respuesta_Fecha, respuesta_Mensaje, respuesta_Leido, respuesta_IncidenciaFK, respuesta_OrigenRespuesta, respuesta_UserFK FROM cliente_incidencia_respuesta_web";
						}				
			  }
		}
									  
		$res = $this->conexion->BD_Consulta($consulta);
		return($res);	
	}
	
	
	function obtenerPaginados(){
		$consulta  = "SELECT respuesta_CodPK, respuesta_Fecha, respuesta_Mensaje, respuesta_Leido, respuesta_IncidenciaFK, respuesta_OrigenRespuesta, respuesta_UserFK FROM cliente_incidencia_respuesta_web";
		return($consulta);	
	}
	
	
	function obtenerPaginadosConFiltro($condicion,$order){
		 if($condicion=="" && $order!="")
				$consulta  = "SELECT respuesta_CodPK, respuesta_Fecha, respuesta_Mensaje, respuesta_Leido, respuesta_IncidenciaFK, respuesta_OrigenRespuesta, respuesta_UserFK FROM cliente_incidencia_respuesta_web $order";				
		 else{
			 if($order=="" && $condicion!="")
					$consulta  = "SELECT respuesta_CodPK, respuesta_Fecha, respuesta_Mensaje, respuesta_Leido, respuesta_IncidenciaFK, respuesta_OrigenRespuesta, respuesta_UserFK FROM cliente_incidencia_respuesta_web $condicion";				
			 else{
				  if($order!="" && $condicion!="")		 
					$consulta  = "SELECT respuesta_CodPK, respuesta_Fecha, respuesta_Mensaje, respuesta_Leido, respuesta_IncidenciaFK, respuesta_OrigenRespuesta, respuesta_UserFK FROM cliente_incidencia_respuesta_web $condicion $order";
					else{
						if($order=="" && $condicion=="")		 
							$consulta  = "SELECT respuesta_CodPK, respuesta_Fecha, respuesta_Mensaje, respuesta_Leido, respuesta_IncidenciaFK, respuesta_OrigenRespuesta, respuesta_UserFK FROM cliente_incidencia_respuesta_web";
						}				
			  }
		}
		return($consulta);	
	}
	
	
} 
?>