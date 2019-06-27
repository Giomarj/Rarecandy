<?PHP
//Clase generada automaticamente por Awisoft Software y Sistemas SL

	
include_once("conexion.php");

class usuario {

var $conexion;

function usuario(){
	$this->conexion= new conexion();
}	
	
	
	function insertar($usu_Nombre, $usu_Login, $usu_Pass, $usu_Tipo) {
		$consulta = "INSERT INTO usuario(usu_Nombre, usu_Login, usu_Pass, usu_Tipo) VALUES('$usu_Nombre', '$usu_Login', '$usu_Pass', '$usu_Tipo')";
		$res = $this->conexion->BD_Consulta($consulta);
		return($res);
	}
	
	
	function eliminar($condicion) {$consulta = "DELETE FROM usuario $condicion";
		$res = $this->conexion->BD_Consulta($consulta);
		return($res);	
	}
	
	function modificar($usu_Nombre, $usu_Login, $usu_Pass, $usu_Tipo, $usu_CodPK) {
		$consulta = "UPDATE usuario SET usu_Nombre='$usu_Nombre', usu_Login='$usu_Login', usu_Pass='$usu_Pass', usu_Tipo='$usu_Tipo'  WHERE usu_CodPK='$usu_CodPK'";
		$res = $this->conexion->BD_Consulta($consulta);
		return($res);
	}
	
	
	function obtener(){
		$consulta  = "SELECT usu_CodPK, usu_Nombre, usu_Login, usu_Pass, usu_Tipo FROM usuario";
		$res = $this->conexion->BD_Consulta($consulta);
		return($res);	
	}
	
	
	function obtenerConFiltro($condicion,$order){
		 if($condicion=="" && $order!="")
				$consulta  = "SELECT usu_CodPK, usu_Nombre, usu_Login, usu_Pass, usu_Tipo FROM usuario $order";				
		 else{
			 if($order=="" && $condicion!="")
					$consulta  = "SELECT usu_CodPK, usu_Nombre, usu_Login, usu_Pass, usu_Tipo FROM usuario $condicion";				
			 else{
				  if($order!="" && $condicion!="")		 
					$consulta  = "SELECT usu_CodPK, usu_Nombre, usu_Login, usu_Pass, usu_Tipo FROM usuario $condicion $order";
					else{
						if($order=="" && $condicion=="")		 
							$consulta  = "SELECT usu_CodPK, usu_Nombre, usu_Login, usu_Pass, usu_Tipo FROM usuario";
						}				
			  }
		}		
		
		$res = $this->conexion->BD_Consulta($consulta);
		return($res);	
	}
	
	
	function obtenerPaginados(){
		$consulta  = "SELECT usu_CodPK, usu_Nombre, usu_Login, usu_Pass, usu_Tipo FROM usuario";
		return($consulta);	
	}
	
	
	function obtenerPaginadosConFiltro($condicion,$order){
		 if($condicion=="" && $order!="")
				$consulta  = "SELECT usu_CodPK, usu_Nombre, usu_Login, usu_Pass, usu_Tipo FROM usuario $order";				
		 else{
			 if($order=="" && $condicion!="")
					$consulta  = "SELECT usu_CodPK, usu_Nombre, usu_Login, usu_Pass, usu_Tipo FROM usuario $condicion";				
			 else{
				  if($order!="" && $condicion!="")		 
					$consulta  = "SELECT usu_CodPK, usu_Nombre, usu_Login, usu_Pass, usu_Tipo FROM usuario $condicion $order";
					else{
						if($order=="" && $condicion=="")		 
							$consulta  = "SELECT usu_CodPK, usu_Nombre, usu_Login, usu_Pass, usu_Tipo FROM usuario";
						}				
			  }
		}
		return($consulta);	
	}
	
	
} 
?>