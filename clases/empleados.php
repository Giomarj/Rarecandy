<?PHP 
//Clase generada automaticamente por Awisoft Software y Sistemas SL

include_once("conexion.php");

class empleados {

var $conexion;

function empleados(){
	$this->conexion= new conexion();
}	

	function obtener(){
		$consulta  = "SELECT e.empresa_id,e.empresa_nombre, t.Anio,t.Trimestre, u.user_Din, u.user_name,t.Fecha, f.fact_fecha_reg, f.fact_fecha_ini,f.fact_fecha_fin, totalhoras, u.user_Comment 
			FROM cliente, stp_ifact_table f, stp_tiempo t, stp_users u, stp_empresa e";
		$res = $this->conexion->BD_Consulta($consulta);
		return($res);	
	}
	
	
	function obtenerConFiltro($condicion,$order){
		 if($condicion=="" && $order!="")
				$consulta  = "SELECT u.user_gender, u.user_CodPK, e.empresa_id,e.empresa_nombre, t.Anio,t.Trimestre, u.user_Din, u.user_name,t.Fecha, f.fact_fecha_reg, f.fact_fecha_ini,f.fact_fecha_fin, totalhoras, u.user_Comment 
					FROM cliente, stp_ifact_table f, stp_tiempo t, stp_users u, stp_empresa e $order";				
		 else{
			 if($order=="" && $condicion!="")
					$consulta  = "SELECT u.user_gender, u.user_CodPK, e.empresa_id,e.empresa_nombre, t.Anio,t.Trimestre, u.user_Din, u.user_name,t.Fecha, f.fact_fecha_reg, f.fact_fecha_ini,f.fact_fecha_fin, totalhoras, u.user_Comment 
						FROM cliente, stp_ifact_table f, stp_tiempo t, stp_users u, stp_empresa e $condicion";				
			 else{
				  if($order!="" && $condicion!="")		 
					$consulta  = "SELECT u.user_gender, u.user_CodPK, e.empresa_id,e.empresa_nombre, t.Anio,t.Trimestre, u.user_Din, u.user_name,t.Fecha, f.fact_fecha_reg, f.fact_fecha_ini,f.fact_fecha_fin, totalhoras, u.user_Comment 
						FROM cliente, stp_ifact_table f, stp_tiempo t, stp_users u, stp_empresa e $condicion $order";
					else{
						if($order=="" && $condicion=="")		 
							$consulta  = "SELECT u.user_gender, u.user_CodPK, e.empresa_id,e.empresa_nombre, t.Anio,t.Trimestre, u.user_Din, u.user_name,t.Fecha, f.fact_fecha_reg, f.fact_fecha_ini,f.fact_fecha_fin, totalhoras, u.user_Comment 
								FROM cliente, stp_ifact_table f, stp_tiempo t, stp_users u, stp_empresa e";
						}				
			  }
		}
									  
		$res = $this->conexion->BD_Consulta($consulta);
		return($res);	
	}
	
	
	function obtenerPaginados(){
		$consulta  = "SELECT u.user_gender, u.user_CodPK, e.empresa_id,e.empresa_nombre, t.Anio,t.Trimestre, u.user_Din, u.user_name,t.Fecha, f.fact_fecha_reg, f.fact_fecha_ini,f.fact_fecha_fin, totalhoras, u.user_Comment 
			FROM cliente, stp_ifact_table f, stp_tiempo t, stp_users u, stp_empresa e";
		return($consulta);	
	}
	
	
	function obtenerPaginadosConFiltro($condicion,$order){
		 if($condicion=="" && $order!="")
				$consulta  = "SELECT u.user_gender, u.user_CodPK, e.empresa_id,e.empresa_nombre, t.Anio,t.Trimestre, u.user_Din,
									 u.user_name,t.Fecha, f.fact_fecha_reg, f.fact_fecha_ini,f.fact_fecha_fin, totalhoras, 
									 u.user_Comment 
								FROM cliente, stp_ifact_table f, stp_tiempo t, stp_users u, stp_empresa e  $order";				
		 else{
			 if($order=="" && $condicion!="")
					$consulta  = "SELECT u.user_gender, u.user_CodPK, e.empresa_id,e.empresa_nombre, t.Anio,t.Trimestre, u.user_Din, u.user_name,t.Fecha, f.fact_fecha_reg, f.fact_fecha_ini,f.fact_fecha_fin, totalhoras, u.user_Comment 
						FROM cliente, stp_ifact_table f, stp_tiempo t, stp_users u, stp_empresa e $condicion";				
			 else{
				  if($order!="" && $condicion!="")		 
					$consulta  = "SELECT u.user_gender, u.user_CodPK, e.empresa_id,e.empresa_nombre, t.Anio,t.Trimestre, u.user_Din, u.user_name,t.Fecha, f.fact_fecha_reg, f.fact_fecha_ini,f.fact_fecha_fin, totalhoras, u.user_Comment 
						FROM cliente, stp_ifact_table f, stp_tiempo t, stp_users u, stp_empresa e $condicion $order";
					else{
						if($order=="" && $condicion=="")		 
							$consulta  = "SELECT u.user_gender, u.user_CodPK, e.empresa_id,e.empresa_nombre, t.Anio,t.Trimestre, u.user_Din, u.user_name,t.Fecha, f.fact_fecha_reg, f.fact_fecha_ini,f.fact_fecha_fin, totalhoras, u.user_Comment 
								FROM cliente, stp_ifact_table f, stp_tiempo t, stp_users u, stp_empresa e";
						}				
			  }
		}
		return($consulta);	
	}
}
?>