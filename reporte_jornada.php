<?PHP

	session_start();

	include_once "/clases/conexion.php";
	include_once "/clases/seguridad.php";
	include_once "/clases/fechas.php";
	require('/clases/fpdf/fpdf.php');
	
	$conexion = new conexion();

	Seguridad();

	define ('FPDF_FONTPATH','font/');
	define ('EURO', chr(128) );
	
	$daterange="";
	$daterange2="";
	$cod_empleado="";
	
	$error=false;
	
	if(isset($_POST['daterange']) || isset($_GET['daterange']))
		$daterange=$_GET['daterange'];
	else
		$error=true;
		
	if(isset($_POST['daterange2']) || isset($_GET['daterange2']))
		$daterange2=$_GET['daterange2'];
	else
		$error=true;
		
	if(isset($_POST['cod_empleado']) || isset($_GET['cod_empleado']))
		$cod_empleado=$_GET['cod_empleado'];
	else
		$error=true;
	
	if($error)
	{
		print("<script>document.location.href='index.php'</script>");
		exit();
	}//fin del if($error || $vectorUser==NULL)
	else
	{

	$sql="SELECT * FROM cliente WHERE cliente_Login='".$_SESSION['usuario_salto']."' AND cliente_Pass='".$_SESSION['password_salto']."'";
	$res=$conexion->BD_Consulta($sql);
	$vector=$conexion->BD_GetTupla($res);

	$imagen_cabecera="./img/WhatsApp-Image-2019-05-29-at-4.04.07-PM.jpeg";
	if(trim($vector['cliente_Logo'])!="")
		$imagen_cabecera="./img/cliente/" . $vector['cliente_Logo'];

	class PDF extends FPDF
	{
		function Header()
		{
			global $imagen_cabecera;
			$this->Image($imagen_cabecera, 10, 5, 35 );
			$this->SetFont('Arial','B',15);
			$this->Cell(30);
			$this->Cell(120,10, 'Reporte De Jornada',0,0,'C');
			$this->Ln(20);
		}
		
		function Footer()
		{
			$this->SetY(-25);
			$this->SetFont('Arial','I', 8);
			$this->Cell(100,10, 'Sello y firma de la Empresa',0,0,'C' );
			$this->Cell(5,10, '',0,0,'C' );
			$this->Cell(0,10, 'Firma del Trabajador',0,0,'C' );

		}
		function rellenarTabla4ColumnasTitulo($dato1,$dimension1,$dato2,$dimension2,$dato3,$dimension3,$dato4,$dimension4)
		{
			$this->SetFillColor(242,242,242);
			
			$this->SetFont('Arial','',8);
			$this->Cell($dimension1,6,utf8_decode($dato1),0,0,'C',0);
			$this->Cell($dimension2,6,utf8_decode($dato2),1,0,'C',0);
			$this->Cell($dimension3,6,utf8_decode($dato3),0,0,'C',0);
			$this->Cell($dimension4,6,utf8_decode($dato4),1,1,'C',0);				
			
			
			$this->Ln();
										
		}
	}
	$pdf = new PDF();
	$pdf->SetMargins(15, 15 , 20);
	$pdf->AliasNbPages();
	$pdf->AddPage();
	

	$pdf->SetFont('Arial','',10);

		$sqlPaquete="SELECT c.cliente_CodPK ,c.cliente_Nombre,c.cliente_Email,
					e.empresa_id,e.empresa_nombre, e.empresa_nit,
					t.Anio,t.Trimestre, u.user_Din, u.user_name,t.Fecha, f.fact_fecha_reg, f.fact_fecha_ini,f.fact_fecha_fin, TIME(f.fact_fecha_ini) hora_ini,TIME(f.fact_fecha_fin) hora_fin, f.totalhoras,
					u.`user_gender` 'Sexo',u.`user_Comment`, CASE WHEN u.`user_LockedOut` = 0 THEN 'Activo' ELSE ' Inactivo' END Estatus
					FROM `stp_ifact_table` f, stp_tiempo t, stp_users u, stp_empresa e, cliente c
					where t.Fecha= f.fact_fecha_reg
					and u.user_Din = f.fact_din
					and e.empresa_CodPK = f.fact_empresaid
					and e.empresa_CodPK = c.cliente_empresaid
					and u.user_CodPK = ".$cod_empleado."
					AND t.Fecha BETWEEN '".$daterange."' AND '".$daterange2."'
					order by 11";
		$resPaquete=$conexion->BD_Consulta($sqlPaquete);
		$tuplaPaquete=$conexion->BD_GetTupla($resPaquete);

	$dimension1=25;		
	$dimension2=65;
	$dimension3=20;
	$dimension4=65;

	$pdf->rellenarTabla4ColumnasTitulo('EMPRESA:',$dimension1,$tuplaPaquete['empresa_nombre'],$dimension2,'CIF:',$dimension3,$tuplaPaquete['empresa_nit'],$dimension4);
	$pdf->rellenarTabla4ColumnasTitulo('TRABAJADOR:',$dimension1,$tuplaPaquete['user_name'],$dimension2,'NIF:',$dimension3,'',$dimension4);


		$pdf->Cell(22,6,date('M Y', strtotime($tuplaPaquete['Fecha'])),1,1,'C',1);
		$pdf->Cell(22,6,'Dias',1,0,'C',1);
		$pdf->Cell(66,6,'Entrada',1,0,'C',1);
		$pdf->Cell(66,6,'Salida',1,0,'C',1);
		$pdf->Cell(22,6,'Horas Totales',1,1,'C',1);



	while($tuplaPaquete!=NULL)
	{
		$nombreEmpleado=$tuplaPaquete['user_name'];
		$pdf->Cell(22,6,date('d', strtotime($tuplaPaquete['Fecha'])),1,0,'C');
		$pdf->Cell(66,6,date('H:i', strtotime($tuplaPaquete['hora_ini']))."h",1,0,'C');
		$pdf->Cell(66,6,date('H:i', strtotime($tuplaPaquete['hora_fin']))."h",1,0,'C');
		$pdf->Cell(22,6,$tuplaPaquete['totalhoras']."h",1,1,'C');

		$tuplaPaquete=$conexion->BD_GetTupla($resPaquete);
	}


		$sqlPaquete="SELECT SUM(totalhoras) AS hours 
					FROM `stp_ifact_table` f, stp_tiempo t, stp_users u, stp_empresa e, cliente c 
					where t.Fecha= f.fact_fecha_reg 
					and u.user_Din = f.fact_din 
					and e.empresa_CodPK = f.fact_empresaid 
					and e.empresa_CodPK = c.cliente_empresaid
					and u.user_CodPK = ".$cod_empleado."
					AND t.Fecha BETWEEN '".$daterange."' AND '".$daterange2."'";
		$resPaquete=$conexion->BD_Consulta($sqlPaquete);
		$tuplaTime=$conexion->BD_GetTupla($resPaquete);

		$pdf->Cell(88,6,'',0,0,'C');
		$pdf->Cell(66,6,'Totales del mes',1,0,'C',1);
		$pdf->Cell(22,6,$tuplaTime['hours']."h",1,1,'C',1);
		$pdf->Ln();
		$pdf->Ln();


	$valor_rand=rand(0,100000);
	$nombreSalida="jornada_" . $nombreEmpleado . "-" . $valor_rand . ".pdf";
	$pdf->Output();
	}
?>