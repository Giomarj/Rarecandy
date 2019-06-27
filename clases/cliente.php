<?PHP 
//Clase generada automaticamente por Awisoft Software y Sistemas SL

	
include_once("conexion.php");

class cliente {

var $conexion;

function cliente(){
	$this->conexion= new conexion();
}	
	
	
	function insertar($cliente_Nombre, $cliente_DNI, $cliente_Direccion, $cliente_Numero, $cliente_Portal, $cliente_Piso, $cliente_Letra, $cliente_CodigoPostal, $cliente_ProvinciaFK, $cliente_Poblacion, $cliente_Movil, $cliente_Email, $cliente_Email2, $cliente_Telefono, $cliente_ComentariosOtraInformacion, $cliente_Login, $cliente_Pass, $cliente_Logo) {
		$cliente_Estado="Activo";
		$cliente_NumeroMensajesPorLeer=0;
		$consulta = "INSERT INTO cliente(cliente_Nombre, cliente_DNI, cliente_Direccion, cliente_Numero, cliente_Portal, cliente_Piso, cliente_Letra, cliente_CodigoPostal, cliente_ProvinciaFK, cliente_Poblacion, cliente_Movil, cliente_Email, cliente_Email2, cliente_Telefono, cliente_ComentariosOtraInformacion, cliente_Login, cliente_Pass, cliente_Logo, cliente_Estado, cliente_NumeroMensajesPorLeer)
			VALUES('$cliente_Nombre', '$cliente_DNI', '$cliente_Direccion', '$cliente_Numero', '$cliente_Portal', '$cliente_Piso', '$cliente_Letra', '$cliente_CodigoPostal', '$cliente_ProvinciaFK', '$cliente_Poblacion', '$cliente_Movil', '$cliente_Email', '$cliente_Email2', '$cliente_Telefono', '$cliente_ComentariosOtraInformacion', '$cliente_Login', '$cliente_Pass', '$cliente_Logo', '$cliente_Estado', '$cliente_NumeroMensajesPorLeer')";
		$res = $this->conexion->BD_Consulta($consulta);
		return($res);
	}

	
	function eliminar($condicion) {
		$order="";
		$resultado = $this->obtenerConFiltro($condicion,$order);
		if ($resultado!= NULL){
			$tupla = $this->conexion->BD_GetTupla($resultado);
			while ($tupla != NULL)
			{
				if(trim($tupla['cliente_Logo'])!=""){	
					$nombreFichero = "../imagen/cliente/" . $tupla['cliente_Logo'];
					unlink ($nombreFichero);
				}
				$tupla = $this->conexion->BD_GetTupla($resultado);
			}
		}
		
		$consulta = "DELETE FROM cliente $condicion";
		$res = $this->conexion->BD_Consulta($consulta);
		return($res);		
	}
	
	function modificar($cliente_Nombre, $cliente_DNI, $cliente_Direccion, $cliente_Numero, $cliente_Portal, $cliente_Piso, $cliente_Letra, $cliente_CodigoPostal, $cliente_ProvinciaFK, $cliente_Poblacion, $cliente_Movil, $cliente_Email, $cliente_Email2, $cliente_Telefono, $cliente_ComentariosOtraInformacion, $cliente_Estado, $cliente_CodPK) {
		$consulta = "UPDATE cliente SET cliente_Nombre='$cliente_Nombre', cliente_DNI='$cliente_DNI', cliente_Direccion='$cliente_Direccion', cliente_Numero='$cliente_Numero', cliente_Portal='$cliente_Portal', cliente_Piso='$cliente_Piso', cliente_Letra='$cliente_Letra', cliente_CodigoPostal='$cliente_CodigoPostal', cliente_ProvinciaFK='$cliente_ProvinciaFK', cliente_Poblacion='$cliente_Poblacion', cliente_Movil='$cliente_Movil', cliente_Email='$cliente_Email', cliente_Email2='$cliente_Email2', cliente_Telefono='$cliente_Telefono', cliente_ComentariosOtraInformacion='$cliente_ComentariosOtraInformacion', cliente_Estado='$cliente_Estado'  WHERE cliente_CodPK='$cliente_CodPK'";
		$res = $this->conexion->BD_Consulta($consulta);
		return($res);
	}
	
	function modificarDatosCliente($cliente_Nombre, $cliente_Direccion, $cliente_Email, $cliente_Telefono, $cliente_Pass, $cliente_CodPK) {
		$consulta = "UPDATE cliente SET cliente_Nombre='$cliente_Nombre', cliente_Direccion='$cliente_Direccion', cliente_Email='$cliente_Email', cliente_Telefono='$cliente_Telefono', cliente_Pass='$cliente_Pass'  WHERE cliente_CodPK='$cliente_CodPK'";
		$res = $this->conexion->BD_Consulta($consulta);
		return($res);
	}
	
	function modificarLogin($cliente_Login, $cliente_CodPK) {
		$consulta = "UPDATE cliente SET cliente_Login='$cliente_Login'  WHERE cliente_CodPK='$cliente_CodPK'";
		$res = $this->conexion->BD_Consulta($consulta);
		return($res);
	}
	
	function modificarPass($cliente_Pass, $cliente_CodPK) {
		$consulta = "UPDATE cliente SET cliente_Pass='$cliente_Pass'  WHERE cliente_CodPK='$cliente_CodPK'";
		$res = $this->conexion->BD_Consulta($consulta);
		return($res);
	}
	
	function modificarLogo($cliente_Logo, $cliente_CodPK) {
		$consulta = "UPDATE cliente SET cliente_Logo='$cliente_Logo'  WHERE cliente_CodPK='$cliente_CodPK'";
		$res = $this->conexion->BD_Consulta($consulta);
		return($res);
	}

	
	function modificarMensajesPorLeer($cliente_NumeroMensajesPorLeer, $cliente_CodPK) {
		$consulta = "UPDATE cliente SET cliente_NumeroMensajesPorLeer='$cliente_NumeroMensajesPorLeer'  WHERE cliente_CodPK='$cliente_CodPK'";
		$res = $this->conexion->BD_Consulta($consulta);
		return($res);
	}
	
	function obtener(){
		$consulta  = "SELECT cliente_CodPK, cliente_Nombre, cliente_DNI, cliente_Direccion, cliente_Numero, cliente_Portal, cliente_Piso, cliente_Letra, cliente_CodigoPostal, cliente_ProvinciaFK, cliente_Poblacion, cliente_Movil, cliente_Email, cliente_Email2, cliente_Telefono, cliente_ComentariosOtraInformacion, cliente_Login, cliente_Pass, cliente_Logo, cliente_Estado, cliente_NumeroMensajesPorLeer FROM cliente";
		$res = $this->conexion->BD_Consulta($consulta);
		return($res);	
	}
	
	
	function obtenerConFiltro($condicion,$order){
		 if($condicion=="" && $order!="")
				$consulta  = "SELECT cliente_CodPK, cliente_Nombre, cliente_DNI, cliente_Direccion, cliente_Numero, cliente_Portal, cliente_Piso, cliente_Letra, cliente_CodigoPostal, cliente_ProvinciaFK, cliente_Poblacion, cliente_Movil, cliente_Email, cliente_Email2, cliente_Telefono, cliente_ComentariosOtraInformacion, cliente_Login, cliente_Pass, cliente_Logo, cliente_Estado, cliente_NumeroMensajesPorLeer FROM cliente $order";				
		 else{
			 if($order=="" && $condicion!="")
					$consulta  = "SELECT cliente_CodPK, cliente_Nombre, cliente_DNI, cliente_Direccion, cliente_Numero, cliente_Portal, cliente_Piso, cliente_Letra, cliente_CodigoPostal, cliente_ProvinciaFK, cliente_Poblacion, cliente_Movil, cliente_Email, cliente_Email2, cliente_Telefono, cliente_ComentariosOtraInformacion, cliente_Login, cliente_Pass, cliente_Logo, cliente_Estado, cliente_NumeroMensajesPorLeer FROM cliente $condicion";				
			 else{
				  if($order!="" && $condicion!="")		 
					$consulta  = "SELECT cliente_CodPK, cliente_Nombre, cliente_DNI, cliente_Direccion, cliente_Numero, cliente_Portal, cliente_Piso, cliente_Letra, cliente_CodigoPostal, cliente_ProvinciaFK, cliente_Poblacion, cliente_Movil, cliente_Email, cliente_Email2, cliente_Telefono, cliente_ComentariosOtraInformacion, cliente_Login, cliente_Pass, cliente_Logo, cliente_Estado, cliente_NumeroMensajesPorLeer FROM cliente $condicion $order";
					else{
						if($order=="" && $condicion=="")		 
							$consulta  = "SELECT cliente_CodPK, cliente_Nombre, cliente_DNI, cliente_Direccion, cliente_Numero, cliente_Portal, cliente_Piso, cliente_Letra, cliente_CodigoPostal, cliente_ProvinciaFK, cliente_Poblacion, cliente_Movil, cliente_Email, cliente_Email2, cliente_Telefono, cliente_ComentariosOtraInformacion, cliente_Login, cliente_Pass, cliente_Logo, cliente_Estado, cliente_NumeroMensajesPorLeer FROM cliente";
						}				
			  }
		}
									  
		$res = $this->conexion->BD_Consulta($consulta);
		return($res);	
	}
	
	
	function obtenerPaginados(){
		$consulta  = "SELECT cliente_CodPK, cliente_Nombre, cliente_DNI, cliente_Direccion, cliente_Numero, cliente_Portal, cliente_Piso, cliente_Letra, cliente_CodigoPostal, cliente_ProvinciaFK, cliente_Poblacion, cliente_Movil, cliente_Email, cliente_Email2, cliente_Telefono, cliente_ComentariosOtraInformacion, cliente_Login, cliente_Pass, cliente_Logo, cliente_Estado, cliente_NumeroMensajesPorLeer FROM cliente";
		return($consulta);	
	}
	
	
	function obtenerPaginadosConFiltro($condicion,$order){
		 if($condicion=="" && $order!="")
				$consulta  = "SELECT cliente_CodPK, cliente_Nombre, cliente_DNI, cliente_Direccion, cliente_Numero, cliente_Portal, cliente_Piso, cliente_Letra, cliente_CodigoPostal, cliente_ProvinciaFK, cliente_Poblacion, cliente_Movil, cliente_Email, cliente_Email2, cliente_Telefono, cliente_ComentariosOtraInformacion, cliente_Login, cliente_Pass, cliente_Logo, cliente_Estado, cliente_NumeroMensajesPorLeer FROM cliente $order";				
		 else{
			 if($order=="" && $condicion!="")
					$consulta  = "SELECT cliente_CodPK, cliente_Nombre, cliente_DNI, cliente_Direccion, cliente_Numero, cliente_Portal, cliente_Piso, cliente_Letra, cliente_CodigoPostal, cliente_ProvinciaFK, cliente_Poblacion, cliente_Movil, cliente_Email, cliente_Email2, cliente_Telefono, cliente_ComentariosOtraInformacion, cliente_Login, cliente_Pass, cliente_Logo, cliente_Estado, cliente_NumeroMensajesPorLeer FROM cliente $condicion";				
			 else{
				  if($order!="" && $condicion!="")		 
					$consulta  = "SELECT cliente_CodPK, cliente_Nombre, cliente_DNI, cliente_Direccion, cliente_Numero, cliente_Portal, cliente_Piso, cliente_Letra, cliente_CodigoPostal, cliente_ProvinciaFK, cliente_Poblacion, cliente_Movil, cliente_Email, cliente_Email2, cliente_Telefono, cliente_ComentariosOtraInformacion, cliente_Login, cliente_Pass, cliente_Logo, cliente_Estado, cliente_NumeroMensajesPorLeer FROM cliente $condicion $order";
					else{
						if($order=="" && $condicion=="")		 
							$consulta  = "SELECT cliente_CodPK, cliente_Nombre, cliente_DNI, cliente_Direccion, cliente_Numero, cliente_Portal, cliente_Piso, cliente_Letra, cliente_CodigoPostal, cliente_ProvinciaFK, cliente_Poblacion, cliente_Movil, cliente_Email, cliente_Email2, cliente_Telefono, cliente_ComentariosOtraInformacion, cliente_Login, cliente_Pass, cliente_Logo, cliente_Estado, cliente_NumeroMensajesPorLeer FROM cliente";
						}				
			  }
		}
		return($consulta);	
	}
	
	function subirImagen($directorio,$id,$ext){
		$nombreDirectorio = "img/cliente/";
		$idUnico = rand(0,time());
		$nombreFichero = $idUnico . "-" . $id . "." . $ext;		 
		if($nombreFichero != ''){
		 	move_uploaded_file ($directorio,$nombreDirectorio . $nombreFichero);
		 }	
		return ($nombreFichero);
	}
		
	function eliminarImagen($imagen) {
		if(trim($imagen)!=""){	
			$imagen2 = "img/cliente/" . $imagen;
			unlink ($imagen2);
		}	
	}
	
} 
?>