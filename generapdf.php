<?PHP
	session_start();
    
	include_once "./clases/conexion.php";
	include_once "./clases/seguridad_web.php";
	include_once "./clases/fechas.php";
	require('./clases/fpdf/fpdf.php');
	
	$conexion = new conexion();
    
	Seguridad();
    
	define ('FPDF_FONTPATH','font/');
	define ('EURO', chr(128) );
	
	$vectorUser=NULL;
        
	if(isset($_SESSION['usuario_salto']) && isset($_SESSION['password_salto']))
	{
		$sqlUser="SELECT * FROM cliente
			LEFT OUTER JOIN provincia ON provincia_CodPK=cliente_ProvinciaFK
			WHERE cliente_Login='".$_SESSION['usuario_salto']."' AND cliente_Pass='".$_SESSION['password_salto']."'";    
		$resUser=$conexion->BD_Consulta($sqlUser);
		$vectorUser=$conexion->BD_GetTupla($resUser);
	}//fin del if(isset($_SESSION['usuario_salto']) && isset($_SESSION['password_salto']))
	
	$caratula_Cliente_Tupla=caratula();
		
	// $error=false;
	
	// if(isset($_POST['habitaciones_formateado_modal']))
	// 	$habitaciones_formateado_modal=$_POST['habitaciones_formateado_modal'];
	// else
	// 	$error=true;
		
	// //en caso de venir las habitaciones vacias
	// if(trim($habitaciones_formateado_modal)=="")
	// 	$error=true;
		
		
	// if(isset($_POST['extras_formateado_modal']))
	// 	$extras_formateado_modal=$_POST['extras_formateado_modal'];
	// else
	// 	$error=true;
		
	// if(isset($_POST['tipo_incremento_plaza']))
	// 	$tipo_incremento_plaza=$_POST['tipo_incremento_plaza'];
	// else
	// 	$error=true;
		


	// 	$pedido="PEDIDO";
	// 	$datosagencia="DATOS AGENCIA";
	// 	$nombre="NOMBRE";
	// 	$cif="CIF";
	// 	$direccion="DIRECCION";
	// 	$cp="CP";
	// 	$provincia="PROVINCIA";
	// 	$poblacion="POBLACION";
	// 	$email="EMAIL";
	// 	$telefono="TELEFONO";
	// 	$presupuestocliente="PRESUPUESTO CLIENTE";
	// 	$emitido="EMITIDO";
	// 	$realizadopor="REALIZADO POR";
	// 	$compania="COMPAÑIA";
	// 	$paquete="PAQUETE";
	// 	$finicio="F. INICIO";
	// 	$ffin="F. FIN";
	// 	$nombrecliente="NOMBRE CLIENTE";
	// 	$emailcliente="EMAIL";
	// 	$nombre2="Nombre";
	// 	$cantidad="Cantidad";
	// 	$precioletra="Precio";
	// 	$totalletra="Total";
	// 	$habitaciones="HABITACIONES";
	// 	$plazastotales="Plazas Totales";
	// 	$preciototalletra="Precio Total";
	// 	$tasasincluidas="Tasas Incluidas";
	// 	$proforma="PROFORMA";
	// 	$presupuesto="PRESUPUESTO";
	// 	$agencia="AGENCIA";
	// 	$extras="EXTRAS";
	// 	$tipo="TIPO";
	// 	$politicacancelacion="Política Cancelación";
	// 	$politicacontratacion="Política Contratación";
	// 	$ImporteparaBloquearLetra="Importe para Bloquear";

	// if($error || $vectorUser==NULL)
	// {
	// 	print("<script>document.location.href='index.php'</script>");
	// 	exit();
	// }//fin del if($error || $vectorUser==NULL)
	// else
	// {
		
		
		
		/*********************** PREPARACION DE PARAMETROS PARA GENERAR PDF ***************/		
		class PDF extends FPDF
		{
			//Cabecera de página
			function Header()
			{
				global $imagen_cabecera;
				
				//Movernos a la derecha
				$this->Cell(50);
				
				
				$this->Image($imagen_cabecera,5,5,199);
				
				//Salto de línea
				$this->Ln(10);
				//Calibri bold 15
				$this->SetFont('Calibri','B',15);
				//Movernos a la derecha
				$this->Cell(120);			
				//Salto de línea
				$this->Ln(20);
			}	
			
			//Pie de página
			function Footer()
			{
				$caratula_Cliente_Tupla=caratula();
				
				$pie_presupuesto=$caratula_Cliente_Tupla['tipo_PiePresupuesto'];
				
				//Posición: a 1,5 cm del final
				$this->SetY(-15);
				//Calibri italic 8
				$this->SetFont('Calibri','I',8);
				//Número de página
				$this->SetTextColor(0,0,0);
				$this->SetFillColor(242,242,242);
				$this->Cell(0,10,utf8_decode($pie_presupuesto),0,0,'C',1);
			}
			
			function rellenarTabla5ColumnasTitulo($dato1,$dimension1,$dato2,$dimension2,$dato3,$dimension3,$dato4,$dimension4,$dato5,$dimension5)
			{				
				$this->SetFillColor(242,242,242);
				
				$this->SetFont('Calibri','',10);
				$this->Cell($dimension1,6,utf8_decode($dato1),'LBT',0,'C',1);				
				$this->Cell($dimension2,6,utf8_decode($dato2),'LBT',0,'C',1);
				$this->Cell($dimension3,6,utf8_decode($dato3),'LBT',0,'C',1);
				$this->Cell($dimension4,6,utf8_decode($dato4),'LBT',0,'C',1);				
				$this->Cell($dimension5,6,utf8_decode($dato5),'RLBT',0,'C',1);
				
				
				$this->Ln();								
			}
			
			function rellenarTabla5Columnas($dato1,$dimension1,$dato2,$dimension2,$dato3,$dimension3,$dato4,$dimension4,$dato5,$dimension5)
			{	
				$this->SetTextColor(0,0,0);
				$this->SetFillColor(242,242,242);
				
				$this->SetFont('Calibri','',10);
				$this->Cell($dimension1,6,utf8_decode($dato1),'LBT',0,'L');				
				$this->Cell($dimension2,6,utf8_decode($dato2),'LBT',0,'C');
				$this->Cell($dimension3,6,utf8_decode($dato3),'LBT',0,'C');
				$this->Cell($dimension4,6,utf8_decode($dato4) . " " . EURO,'LBT',0,'C');				
				$this->Cell($dimension5,6,utf8_decode($dato5) . " " . EURO,'RLBT',0,'C');
				$this->SetTextColor(0,0,0);
				
				$this->Ln();	
			}
			
			function rellenarTabla4ColumnasTitulo($dato1,$dimension1,$dato2,$dimension2,$dato3,$dimension3,$dato4,$dimension4)
			{				
				$this->SetFillColor(242,242,242);
				
				$this->SetFont('Calibri','',10);
				$this->Cell($dimension1,6,utf8_decode($dato1),'LBT',0,'C',1);
				$this->Cell($dimension2,6,utf8_decode($dato2),'LBT',0,'C',1);
				$this->Cell($dimension3,6,utf8_decode($dato3),'LBT',0,'C',1);
				$this->Cell($dimension4,6,utf8_decode($dato4),'RLBT',0,'C',1);				
				
				
				$this->Ln();								
			}
			
			function rellenarTabla4Columnas($dato1,$dimension1,$dato2,$dimension2,$dato3,$dimension3,$dato4,$dimension4)
			{	
				$this->SetTextColor(0,0,0);
				$this->SetFillColor(242,242,242);
				
				$this->SetFont('Calibri','',10);
				$this->Cell($dimension1,6,utf8_decode($dato1),'LBT',0,'L');
				$this->Cell($dimension2,6,utf8_decode($dato2),'LBT',0,'C');
				$this->Cell($dimension3,6,utf8_decode($dato3) . " " . EURO,'LBT',0,'C');
				$this->Cell($dimension4,6,utf8_decode($dato4) . " " . EURO,'RLBT',0,'C');
				$this->SetTextColor(0,0,0);
				
				$this->Ln();	
			}
		}//fin del class PDF extends FPDF			
			
			
		$prespuesto_numero="";
		
		//Creación del objeto de la clase heredada
		$format=array(209,296); 
		
		if ($_SESSION["language"] == 'es') {
			$imagen_cabecera="./img/logo_pdf.jpg";
		} else {
			$imagen_cabecera="./img/logo_pt_pdf.jpg";
		}
		
		if(trim($caratula_Cliente_Tupla['tipo_Imagen_Cabecera_PresupuestoCliente'])!="")
			$imagen_cabecera="./imagen/cliente_tipo/" . $caratula_Cliente_Tupla['tipo_Imagen_Cabecera_PresupuestoCliente'];
			
		$pdf=new PDF('P','mm',$format);
		$pdf->AddFont('Calibri','','calibri.php');
		$pdf->AddFont('Calibri','B','calibrib.php');
		$pdf->AddFont('Calibri','I','calibrii.php');
		$pdf->AddFont('Calibri','BI','calibribi.php');
		
		
		//*******************************************************************************/
		
		$pdf->SetTextColor(51,51,51);
	
		$pdf->SetSubject($pedido);
		
		$pdf->AddPage();
		
		$x=200;
		$y=10;
		
		
		$pdf->SetX(5);
		$pdf->Cell(20,10,"       ",0,0,'L');	
		$pdf->SetFont('Calibri','BU',14);		
		
		
		$pdf->Ln(6);	
		$pdf->Ln(6);
		
				
		$pdf->SetFont('Calibri','B',15);
		$pdf->Cell(70,6,utf8_decode($datosagencia),0,0,'L');
		$pdf->Ln(6);
		$pdf->SetFont('Calibri','',10);
		$pdf->Cell(129,6,$nombre.': ' . utf8_decode($vectorUser['cliente_Nombre']),'RLBT',0,'L');				
		$pdf->Cell(65,6,$cif.': ' . utf8_decode($vectorUser['cliente_DNI']),'RLBT',0,'L');
		$pdf->Ln();
		$pdf->Cell(129,6,utf8_decode($direccion).': ' . utf8_decode($vectorUser['cliente_Direccion']) . " " . utf8_decode($vectorUser['cliente_Numero']) . " " . utf8_decode($vectorUser['cliente_Portal']) . " " . utf8_decode($vectorUser['cliente_Piso']) . " " . utf8_decode($vectorUser['cliente_Letra']),'RLBT',0,'L');
		$pdf->Cell(65,6,$cp.': ' . utf8_decode($vectorUser['cliente_CodigoPostal']),'RLBT',0,'L');
		$pdf->Ln();
		$pdf->Cell(129,6,utf8_decode($provincia).': ' . utf8_decode($vectorUser['provincia_Nombre']),'RLBT',0,'L');				
		$pdf->Cell(65,6,utf8_decode($poblacion).': ' . utf8_decode($vectorUser['cliente_Poblacion']),'RLBT',0,'L');
		$pdf->Ln();
		$pdf->Cell(129,6,$email.': ' . utf8_decode($vectorUser['cliente_Email']) . " " . utf8_decode($vectorUser['cliente_Email2']),'RLBT',0,'L');				
		$pdf->Cell(65,6,$telefono.': ' . utf8_decode($vectorUser['cliente_Telefono']) . " " . utf8_decode($vectorUser['cliente_Movil']),'RLBT',0,'L');
		$pdf->Ln(6);
		$pdf->Ln(6);
		
		
		$pdf->SetFont('Calibri','B',15);
		$pdf->Cell(70,6,utf8_decode($presupuestocliente),0,0,'L');								
		/*$pdf->SetFont('Calibri','',10);
		$pdf->Cell(35,6,'PRESUPUESTO Nº:',0,0,'R');
		$pdf->SetFont('Calibri','B',15);
		$pdf->Cell(15,6,$prespuesto_numero,0,0,'L');*/
		$pdf->Cell(35,6,'',0,0,'R');		
		$pdf->Cell(15,6,'',0,0,'L');
		$pdf->SetFont('Calibri','',10);
		$pdf->Cell(50,6,$emitido.': ',0,0,'R');
		$pdf->Cell(24,6,date("d/m/Y"),'RLBT',0,'L');	
		$pdf->Ln(6);
		
		$sqlPaquete="SELECT * FROM paquete_union_habitacion_fecha
				INNER JOIN paquete_fecha ON paqHabiFecha_FechaFK=fecha_CodPK
				INNER JOIN paquete ON paquete_CodPK=paqHabiFecha_PaqueteFK
				INNER JOIN paquete_compania ON compania_CodPK=paquete_CompaniaFK
				WHERE '" . date("Y-m-d") ."' BETWEEN paquete_FechaInicio AND paquete_FechaFin
				AND paquete_Estado='Visible'
				AND fecha_Estado='Visible'
				AND paqHabiFecha_NumeroHabitaciones>0
				AND paqHabiFecha_FechaFK=" . $fechaFK ."
				GROUP BY fecha_CodPK
				ORDER BY paqHabiFecha_Precio";
		//print($sqlPaquete);
		$resPaquete=$conexion->BD_Consulta($sqlPaquete);
		$tuplaPaquete=$conexion->BD_GetTupla($resPaquete);
		
		if($tuplaPaquete==NULL)
		{
		    print("<script>document.location.href='inicio-logado.php'</script>");
		    exit();
		}
		
		$tipo_compania=$tuplaPaquete['compania_Tipo'];
		if(strcmp($tipo_compania, "Programacion_Especial")==0)
			$tipo_compania="Programacion Especial";
		
			
		$pdf->Cell(129,6,$realizadopor.': ' . utf8_decode($realizado_por),'RLBT',0,'L');		
		//$pdf->Cell(65,6,'TIPO: ' . utf8_decode($tipo_compania),'RLBT',0,'L');
		$pdf->Cell(65,6,utf8_decode($compania).': ' . utf8_decode($tuplaPaquete['compania_Nombre']),'RLBT',0,'L');
		$pdf->Ln();		
		$pdf->Cell(129,6,$paquete.':' . utf8_decode($tuplaPaquete['paquete_Nombre']),'RLBT',0,'L');
		
		if(trim($tuplaPaquete['fecha_Fin'])!="" && strcmp($tuplaPaquete['fecha_Fin'],"0000-00-00")!=0)
		{
			$pdf->Cell(35,6,$finicio.':' . cambiaf_a_normal($tuplaPaquete['fecha_Fecha']),'RLBT',0,'L');
			$pdf->Cell(30,6,$ffin.':' . cambiaf_a_normal($tuplaPaquete['fecha_Fin']),'RLBT',0,'L');
		}
		else
			$pdf->Cell(65,6,$finicio.':' . cambiaf_a_normal($tuplaPaquete['fecha_Fecha']),'RLBT',0,'L');
			
		$pdf->Ln();		
		$pdf->Cell(129,6,$nombrecliente.': ' . utf8_decode($nombre_cliente),'RLBT',0,'L');
		$pdf->Cell(65,6,$emailcliente.':' . utf8_decode($email_cliente),'RLBT',0,'L');
		
		
		$pdf->Ln(6);
		$pdf->Ln(6);
		
		//tamaño 194
		$dimension1=94;		
		$dimension2=25;		
		$dimension3=25;
		$dimension4=25;
		$dimension5=25;
		
		//HABITACIONES
		if(trim($habitaciones_formateado_modal)!="")
		{
			//recorremos las habitaciones para ver el numero total de plazas y subir un incremento proporcional a cada una de ellas
			$pax_totales=0;
			
			$tok = strtok($habitaciones_formateado_modal, "|");
			while ($tok !== false)
			{
				$cadena_division = preg_split("/\/|-/",$tok);
				
				$sqlHabFechas="SELECT * FROM paquete_union_habitacion_fecha
				INNER JOIN habitacion ON habitacion_CodPK=paqHabiFecha_HabitacionFK
				WHERE paqHabiFecha_CodPK=" . $cadena_division[0];
				$resHabFechas=$conexion->BD_Consulta($sqlHabFechas);
				$tuplaHabFechas=$conexion->BD_GetTupla($resHabFechas);
										
				$numero_plazas_habitacion=$tuplaHabFechas['habitacion_NumPersonas'] * $cadena_division[1];
				
				
				$dato2=$numero_plazas_habitacion;
				
				
				$pax_totales=$pax_totales + $dato2;				
				//echo "Word=$tok<br />";
				$tok = strtok("|");
			}//fin del while ($tok !== false)						
		}//fin del if(trim($habitaciones_formateado_modal)!="")
		
		//incremento extra de las plazas
		$incremento_extra_plazas=$incremento_extra/$pax_totales;
		$incremento_extra_plazas=round($incremento_extra_plazas,2);
		
		if(trim($habitaciones_formateado_modal)!="")
		{
			$dato1=$nombre2;
			$dato2="Nº Pax";
			$dato3=$cantidad;	
			$dato4=$precioletra." Pax";
			$dato5=$totalletra;		
			$pdf->SetFont('Calibri','B',10);
			$pdf->Cell(40,7,$habitaciones,0,2,'L');
			
			
			
			$pdf->rellenarTabla5ColumnasTitulo($dato1,$dimension1,$dato2,$dimension2,$dato3, $dimension3,$dato4,$dimension4,$dato5,$dimension5);
			
			$tok = strtok($habitaciones_formateado_modal, "|");
			while ($tok !== false)
			{
				$cadena_division = preg_split("/\/|-/",$tok);
				
				$sqlHabFechas="SELECT (paqHabiFecha_Precio+(paqCliente_PrecioIncremento*habitacion_NumPersonas)) as paqHabiFecha_Precio, paqCliente_PrecioIncremento, habitacion_NumPersonas, habitacion_Nombre
				FROM paquete_union_habitacion_fecha
				INNER JOIN paquete_fecha_union_grupo_clientes ON paqCliente_FechaFK=paqHabiFecha_FechaFK
				INNER JOIN habitacion ON habitacion_CodPK=paqHabiFecha_HabitacionFK
				WHERE paqHabiFecha_CodPK=" . $cadena_division[0] . "
				AND paqCliente_GrupoClienteFK IN (SELECT cliGrupo_GrupoClienteFK FROM cliente_union_grupo WHERE cliGrupo_ClienteFK=" . $vectorUser['cliente_CodPK'] . ")";
				$resHabFechas=$conexion->BD_Consulta($sqlHabFechas);
				$tuplaHabFechas=$conexion->BD_GetTupla($resHabFechas);
				
				//calculo de los precios + las tasas de cada tipo
				$precio= porcentaje11($tuplaHabFechas['paqHabiFecha_Precio'],$porcentaje) + ($tuplaPaquete['paquete_PrecioTasas']*$tuplaHabFechas['habitacion_NumPersonas']) + ($tuplaPaquete['paquete_PrecioPropi']*$tuplaHabFechas['habitacion_NumPersonas']);
				$numero_plazas_habitacion=$tuplaHabFechas['habitacion_NumPersonas'] * $cadena_division[1];
				
				//incrementamos el precio dependiendo si es por % o por plaza
				$tipo_incremento_plaza=$_POST['tipo_incremento_plaza'];
				$incremento_valor_plaza=$_POST['incremento_valor_plaza'];
				
				if(strcmp($tipo_incremento_plaza,"porcentaje_plaza")==0)
				{
					$valor_incremento=1+($incremento_valor_plaza/100);
					$precio=$precio*$valor_incremento;
				}//fin del if(strcmp($tipo_incremento_plaza,"porcentaje_plaza")==0)
								
				
				$dato1=$tuplaHabFechas['habitacion_Nombre'];
				$dato2=$numero_plazas_habitacion;
				$dato3=$cadena_division[1];				
				$dato4=round($precio/$tuplaHabFechas['habitacion_NumPersonas'],2);
				$dato5=round($precio*$dato3,2);
				
				if(strcmp($tipo_incremento_plaza,"euros_plaza")==0)
				{
					$dato4=round($dato4 + $incremento_valor_plaza,2);
					$dato5=round($dato5 + ($incremento_valor_plaza*$numero_plazas_habitacion),2);
				}//fin del if(strcmp($tipo_incremento_plaza,"euros_plaza")==0)
				
				//sumamos el incremento a cada dato
				$dato4=$dato4 + $incremento_extra_plazas;
				$dato5=$dato5 + ($incremento_extra_plazas*$dato2);
								
				$pdf->rellenarTabla5Columnas($dato1,$dimension1,$dato2,$dimension2,$dato3,$dimension3, number_format($dato4, 2, '.', ''),$dimension4,number_format($dato5, 2, '.', ''),$dimension5);
				//echo "Word=$tok<br />";
				$tok = strtok("|");
			}//fin del while ($tok !== false)
			
			//plazas totales
			$pdf->Cell(144,6,'');
			$pdf->Cell(50,6,utf8_decode($plazastotales.": " . $pax_totales),'RLBT',0,'C');
			
			
		}//fin del if(trim($habitaciones_formateado_modal)!="")
		
		
		//SEGUROS  tamaño 194
		$dimension1=119;		
		$dimension2=25;
		$dimension3=25;
		$dimension4=25;
		if(trim($extras_formateado_modal)!="")
		{
			$pdf->Ln(6);
			$pdf->Ln(6);
		
			$dato1=$nombre2;
			$dato2=$cantidad;
			$dato3=$precioletra;
			$dato4=$totalletra;
			$pdf->SetFont('Calibri','B',10);
			$pdf->Cell(40,7,$extras,0,2,'L');
			
			
			$pdf->rellenarTabla4ColumnasTitulo($dato1,$dimension1,$dato2,$dimension2,$dato3,$dimension3,$dato4,$dimension4);
			
			$tok = strtok($extras_formateado_modal, "|");
			while ($tok !== false)
			{
				$cadena_division = preg_split("/\/|-/",$tok);
				
				$sqlSeguros="SELECT * FROM paquete_union_seguro			   
					WHERE paqSeguro_CodPK=" . $cadena_division[0];
				$resSeguros=$conexion->BD_Consulta($sqlSeguros);
				$tuplaSeguros=$conexion->BD_GetTupla($resSeguros);
				
				$dato1=$tuplaSeguros['paqSeguro_Titulo'];
				$dato2=$cadena_division[1];
				//obtenemos el importe_pvp_seguro_ y lo dividimos entre el numero
				$cadena="importe_pvp_seguro_" . $tuplaSeguros['paqSeguro_CodPK'];
				$dato3=round($_POST[$cadena]/$dato2,2);			
				$dato4=round($_POST[$cadena]*1,2);
				
				$pdf->rellenarTabla4Columnas($dato1,$dimension1,$dato2,$dimension2, number_format($dato3, 2, '.', ''),$dimension3,number_format($dato4, 2, '.', ''),$dimension4);
				//echo "Word=$tok<br />";
				$tok = strtok("|");
			}//fin del while ($tok !== false)
		}//fin del if(trim($extras_formateado_modal)!="")
		
		
		//precio total
		$pdf->Ln(6);
		$pdf->Ln(6);
		$pdf->Cell(114,6,'');
		$importe_pvp=str_replace("€", "", $importe_pvp);
		$pdf->SetFont('Calibri','B',10);
		
		if($tuplaPaquete['paquete_PrecioTasas']>0)
			$pdf->Cell(40,6,utf8_decode($preciototalletra.": " . $importe_pvp) . EURO . " (".utf8_decode($tasasincluidas).")");
		else
			$pdf->Cell(40,6,utf8_decode($preciototalletra.": " . $importe_pvp) . EURO);
		
		/* QUITAMOS DEL PRESUPUESTO CLIENTE LAS POLITICAS
		if(trim($tuplaPaquete['paquete_PoliticaCancelacion'])!="")
		{
			$pdf->Ln(6);
			$politica_cancelacion=str_replace("<br/>","\n",$tuplaPaquete['paquete_PoliticaCancelacion']);
			$pdf->SetFont('Calibri','B',7);
			$pdf->MultiCell(0,3,utf8_decode("Política Cancelación: "));
			$pdf->SetFont('Calibri','',7);
			$pdf->MultiCell(0,3,utf8_decode($politica_cancelacion));
		}
		
		if(trim($tuplaPaquete['paquete_PoliticaContratacion'])!="")
		{
			$pdf->Ln(6);
			$politica_contratacion=str_replace("<br/>","\n",$tuplaPaquete['paquete_PoliticaContratacion']);
			$pdf->SetFont('Calibri','B',7);
			$pdf->MultiCell(0,3,utf8_decode("Política Contratación: "));
			$pdf->SetFont('Calibri','',7);
			$pdf->MultiCell(0,3,utf8_decode($politica_contratacion));
		}*/
		
		
		
		$valor_rand=rand(0,100000);
		$nombreFichero="./archivo/generar_pedidos/" . $valor_rand . "-" . $valor_rand . ".pdf";
		$pdf->Output($nombreFichero);
		
		
		//GENERACION DE LA PROFORMA
		
				//Creación del objeto de la clase heredada
				$format=array(209,296); 
				
				if ($_SESSION["language"] == 'es') {
					$imagen_cabecera="./img/logo_proforma_pdf.jpg";
				} else {
					$imagen_cabecera="./img/logo_pt_proforma_pdf.jpg";
				}
				
				if(trim($caratula_Cliente_Tupla['tipo_Imagen_Cabecera_ProformaCliente'])!="")
					$imagen_cabecera="./imagen/cliente_tipo/" . $caratula_Cliente_Tupla['tipo_Imagen_Cabecera_ProformaCliente'];
			
				$pdf_proforma=new PDF('P','mm',$format);
				$pdf_proforma->AddFont('Calibri','','calibri.php');
				$pdf_proforma->AddFont('Calibri','B','calibrib.php');
				$pdf_proforma->AddFont('Calibri','I','calibrii.php');
				$pdf_proforma->AddFont('Calibri','BI','calibribi.php');
				
				$importe_para_bloquear=0;
				
				
				$pdf_proforma->SetTextColor(51,51,51);
			
				$pdf_proforma->SetSubject($proforma);
				
				$pdf_proforma->AddPage();
				
				$x=200;
				$y=10;
				
				
				$pdf_proforma->SetX(5);
				$pdf_proforma->Cell(20,10,"       ",0,0,'L');	
				$pdf_proforma->SetFont('Calibri','BU',14);		
				
				
				$pdf_proforma->Ln(6);	
				$pdf_proforma->Ln(6);
				
						
				$pdf_proforma->SetFont('Calibri','B',15);
				$pdf_proforma->Cell(70,6,utf8_decode($presupuesto),0,0,'L');												
				$pdf_proforma->Cell(35,6,'',0,0,'R');		
				$pdf_proforma->Cell(15,6,'',0,0,'L');
				$pdf_proforma->SetFont('Calibri','',10);
				$pdf_proforma->Cell(50,6,utf8_decode($emitido).': ',0,0,'R');
				$pdf_proforma->Cell(24,6,date("d/m/Y"),'RLBT',0,'L');	
				$pdf_proforma->Ln(6);
				
				$sqlPaquete="SELECT * FROM paquete_union_habitacion_fecha
						INNER JOIN paquete_fecha ON paqHabiFecha_FechaFK=fecha_CodPK
						INNER JOIN paquete ON paquete_CodPK=paqHabiFecha_PaqueteFK
						INNER JOIN paquete_compania ON compania_CodPK=paquete_CompaniaFK
						WHERE '" . date("Y-m-d") ."' BETWEEN paquete_FechaInicio AND paquete_FechaFin
						AND paquete_Estado='Visible'
						AND fecha_Estado='Visible'
						AND paqHabiFecha_NumeroHabitaciones>0
						AND paqHabiFecha_FechaFK=" . $fechaFK ."
						GROUP BY fecha_CodPK
						ORDER BY paqHabiFecha_Precio";
				//print($sqlPaquete);
				$resPaquete=$conexion->BD_Consulta($sqlPaquete);
				$tuplaPaquete=$conexion->BD_GetTupla($resPaquete);
				
				if($tuplaPaquete==NULL)
				{
				    print("<script>document.location.href='inicio-logado.php'</script>");
				    exit();
				}
				
				$tipo_compania=$tuplaPaquete['compania_Tipo'];
				if(strcmp($tipo_compania, "Programacion_Especial")==0)
					$tipo_compania="Programacion Especial";
				
					
				$pdf_proforma->Cell(64,6,$realizadopor. ': ' . utf8_decode($realizado_por),'RLBT',0,'L');		
				$pdf_proforma->Cell(65,6,$tipo.': ' . utf8_decode($tipo_compania),'RLBT',0,'L');
				$pdf_proforma->Cell(65,6,utf8_decode($compania).': ' . utf8_decode($tuplaPaquete['compania_Nombre']),'RLBT',0,'L');
				$pdf_proforma->Ln();		
				$pdf_proforma->Cell(129,6,$paquete. ': ' . utf8_decode($tuplaPaquete['paquete_Nombre']),'RLBT',0,'L');
				
				if(trim($tuplaPaquete['fecha_Fin'])!="" && strcmp($tuplaPaquete['fecha_Fin'],"0000-00-00")!=0)
				{
					$pdf_proforma->Cell(35,6,$finicio.': ' . cambiaf_a_normal($tuplaPaquete['fecha_Fecha']),'RLBT',0,'L');
					$pdf_proforma->Cell(30,6,$ffin.': ' . cambiaf_a_normal($tuplaPaquete['fecha_Fin']),'RLBT',0,'L');
				}
				else
					$pdf_proforma->Cell(65,6,$finicio.': ' . cambiaf_a_normal($tuplaPaquete['fecha_Fecha']),'RLBT',0,'L');
					
				$pdf_proforma->Ln();		
				$pdf_proforma->Cell(129,6,$nombrecliente.': ' . utf8_decode($nombre_cliente),'RLBT',0,'L');
				$pdf_proforma->Cell(65,6,$emailcliente.': ' . utf8_decode($email_cliente),'RLBT',0,'L');
				$pdf_proforma->Ln();		
				$pdf_proforma->Cell(194,6,utf8_decode($agencia).': ' . utf8_decode($vectorUser['cliente_Nombre']),'RLBT',0,'L');
				
				
				$pdf_proforma->Ln(6);
				$pdf_proforma->Ln(6);
				
				//tamaño 194
				$dimension1=94;		
				$dimension2=25;		
				$dimension3=25;
				$dimension4=25;
				$dimension5=25;
				
				
				
				if(trim($habitaciones_formateado_modal)!="")
				{
					$dato1=$nombre2;
					$dato2="Nº Pax";
					$dato3=$cantidad;	
					$dato4=$precioletra." Pax";
					$dato5=$totalletra;		
					$pdf_proforma->SetFont('Calibri','B',10);
					$pdf_proforma->Cell(40,7,$habitaciones,0,2,'L');
					
					
					
					$pdf_proforma->rellenarTabla5ColumnasTitulo($dato1,$dimension1,$dato2,$dimension2,$dato3, $dimension3,$dato4,$dimension4,$dato5,$dimension5);
					
					$tok = strtok($habitaciones_formateado_modal, "|");
					while ($tok !== false)
					{
						$cadena_division = preg_split("/\/|-/",$tok);
						
						$sqlHabFechas="SELECT (paqHabiFecha_Precio + (paqCliente_PrecioIncremento*habitacion_NumPersonas)) as paqHabiFecha_Precio, paqCliente_PrecioIncremento, habitacion_NumPersonas, habitacion_Nombre, paqHabiFecha_ImporteDeposito
						FROM paquete_union_habitacion_fecha
						INNER JOIN paquete_fecha_union_grupo_clientes ON paqCliente_FechaFK=paqHabiFecha_FechaFK
						INNER JOIN habitacion ON habitacion_CodPK=paqHabiFecha_HabitacionFK
						WHERE paqHabiFecha_CodPK=" . $cadena_division[0] . "
						AND paqCliente_GrupoClienteFK IN (SELECT cliGrupo_GrupoClienteFK FROM cliente_union_grupo WHERE cliGrupo_ClienteFK=" . $vectorUser['cliente_CodPK'] . ")";
						//print($sqlHabFechas);
						$resHabFechas=$conexion->BD_Consulta($sqlHabFechas);
						$tuplaHabFechas=$conexion->BD_GetTupla($resHabFechas);
						
						//calculo de los precios + las tasas de cada tipo
						$precio=porcentaje11($tuplaHabFechas['paqHabiFecha_Precio'],$porcentaje) + ($tuplaPaquete['paquete_PrecioTasas']*$tuplaHabFechas['habitacion_NumPersonas']) + ($tuplaPaquete['paquete_PrecioPropi']*$tuplaHabFechas['habitacion_NumPersonas']);
						$numero_plazas_habitacion=$tuplaHabFechas['habitacion_NumPersonas'] * $cadena_division[1];
						$importe_para_bloquear=$importe_para_bloquear + ($tuplaHabFechas['paqHabiFecha_ImporteDeposito']*$cadena_division[1]);	
						
						$dato1=$tuplaHabFechas['habitacion_Nombre'];
						$dato2=$numero_plazas_habitacion;
						$dato3=$cadena_division[1];				
						$dato4=round($precio/$tuplaHabFechas['habitacion_NumPersonas'],2);
						$dato5=round($precio*$dato3,2);
						
										
						$pdf_proforma->rellenarTabla5Columnas($dato1,$dimension1,$dato2,$dimension2,$dato3,$dimension3, number_format($dato4, 2, '.', ''),$dimension4,number_format($dato5, 2, '.', ''),$dimension5);
						//echo "Word=$tok<br />";
						$tok = strtok("|");
					}//fin del while ($tok !== false)
					
					//plazas totales
					$pdf_proforma->Cell(144,6,'');
					$pdf_proforma->Cell(50,6,utf8_decode($plazastotales.": " . $pax_totales),'RLBT',0,'C');
					
					
				}//fin del if(trim($habitaciones_formateado_modal)!="")
				
				
				//SEGUROS  tamaño 194
				$dimension1=119;		
				$dimension2=25;
				$dimension3=25;
				$dimension4=25;
				if(trim($extras_formateado_modal)!="")
				{
					$pdf_proforma->Ln(6);
					$pdf_proforma->Ln(6);
				
					$dato1=$nombre2;
					$dato2=$cantidad;
					$dato3=$precioletra;
					$dato4=$totalletra;
					$pdf_proforma->SetFont('Calibri','B',10);
					$pdf_proforma->Cell(40,7,$extras,0,2,'L');
					
					
					$pdf_proforma->rellenarTabla4ColumnasTitulo($dato1,$dimension1,$dato2,$dimension2,$dato3,$dimension3,$dato4,$dimension4);
					
					$tok = strtok($extras_formateado_modal, "|");
					while ($tok !== false)
					{
						$cadena_division = preg_split("/\/|-/",$tok);
						
						$sqlSeguros="SELECT * FROM paquete_union_seguro			   
							WHERE paqSeguro_CodPK=" . $cadena_division[0];
						$resSeguros=$conexion->BD_Consulta($sqlSeguros);
						$tuplaSeguros=$conexion->BD_GetTupla($resSeguros);
						
						$dato1=$tuplaSeguros['paqSeguro_Titulo'];
						$dato2=$cadena_division[1];
						$importe_para_bloquear=$importe_para_bloquear + ($tuplaSeguros['paqSeguro_ImporteDeposito']*$cadena_division[1]);
						//$importe_para_bloquear=$importe_para_bloquear . " " . $dato1 . " - " . $tuplaSeguros['paqSeguro_ImporteDeposito'] . " - ". $cadena_division[1]  . " - ".($tuplaSeguros['paqSeguro_ImporteDeposito']*$cadena_division[1]);
						
						//obtenemos el importe_pvp_seguro_ y lo dividimos entre el numero
						$cadena="importe_neto_seguro_" . $tuplaSeguros['paqSeguro_CodPK'];
						$dato3=round($_POST[$cadena]/$dato2,2);			
						$dato4=round($_POST[$cadena]*1,2);
						
						$pdf_proforma->rellenarTabla4Columnas($dato1,$dimension1,$dato2,$dimension2, number_format($dato3, 2, '.', ''),$dimension3,number_format($dato4, 2, '.', ''),$dimension4);
						//echo "Word=$tok<br />";
						$tok = strtok("|");
					}//fin del while ($tok !== false)
				}//fin del if(trim($extras_formateado_modal)!="")
				
				
				//precio total
				$pdf_proforma->Ln(6);
				$pdf_proforma->Ln(6);
				$pdf_proforma->Cell(114,6,'');
				$importe_neto=str_replace("€", "", $importe_neto);
				$pdf_proforma->SetFont('Calibri','B',10);
				
				if($tuplaPaquete['paquete_PrecioTasas']>0)
					$pdf_proforma->Cell(40,6,utf8_decode($preciototalletra.": " . $importe_neto) . EURO . " (".utf8_decode($tasasincluidas).")");
				else
					$pdf_proforma->Cell(40,6,utf8_decode($preciototalletra.": " . $importe_neto) . EURO);
				
				
				//Importe para Bloquear
				$pdf_proforma->Ln(6);
				$pdf_proforma->Ln(6);
				$pdf_proforma->Cell(140,6,'');				
				$pdf_proforma->SetFont('Calibri','B',10);
				$pdf_proforma->Cell(40,6,utf8_decode($ImporteparaBloquearLetra.": " . $importe_para_bloquear) . " " . EURO);
				
				
				if(trim($tuplaPaquete['paquete_PoliticaCancelacion'])!="" || trim($tuplaPaquete['paquete_PoliticaCancelacionPt'])!="")
				{
					$pdf_proforma->Ln(6);
					if ($_SESSION["language"] == 'es') {
					$politica_cancelacion=str_replace("<br/>","\n",$tuplaPaquete['paquete_PoliticaCancelacion']);
					}else{
					$politica_cancelacion=str_replace("<br/>","\n",$tuplaPaquete['paquete_PoliticaCancelacionPt']);	
					}
					$pdf_proforma->SetFont('Calibri','B',7);
					$pdf_proforma->MultiCell(0,3,utf8_decode($politicacancelacion.": "));
					$pdf_proforma->SetFont('Calibri','',7);
					$pdf_proforma->MultiCell(0,3,utf8_decode($politica_cancelacion));
				}
				
				if(trim($tuplaPaquete['paquete_PoliticaContratacion'])!="" || trim($tuplaPaquete['paquete_PoliticaContratacionPt'])!="")
				{
					$pdf_proforma->Ln(6);
					if ($_SESSION["language"] == 'es') {
					$politica_contratacion=str_replace("<br/>","\n",$tuplaPaquete['paquete_PoliticaContratacion']);
					}else{
					$politica_contratacion=str_replace("<br/>","\n",$tuplaPaquete['paquete_PoliticaContratacionPt']);
					}
					$pdf_proforma->SetFont('Calibri','B',7);
					$pdf_proforma->MultiCell(0,3,utf8_decode($politicacontratacion.": "));
					$pdf_proforma->SetFont('Calibri','',7);
					$pdf_proforma->MultiCell(0,3,utf8_decode($politica_contratacion));
				}
				
				
				$nombreFichero_proforma="./archivo/generar_pedidos/proforma_" . $valor_rand . "-" . $valor_rand . ".pdf";
				$pdf_proforma->Output($nombreFichero_proforma);
		//FIN GENERACION DE LA PROFORMA
				
		//enseñar el PDF
		$pdf->Output();
	//}//fin del else del if($error || $vectorUser==NULL)
?>