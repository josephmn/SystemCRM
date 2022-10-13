<?php

class certificadoctsController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('planillas','certificadocts');

			$this->_view->setCss_Specific(
				array(
					'plugins/fontawesome-free/css/all.min',
					'plugins/overlayScrollbars/css/OverlayScrollbars.min',
					'dist/css/adminlte',
					//DataTables>
					'plugins/datatables-responsive/css/responsive.bootstrap4.min',
					'plugins/datatables-net/css/jquery.dataTables.min',
					'plugins/datatables-net/css/responsive.dataTables.min',
				)
			);
	
			$this->_view->setJs_Specific(
				array(
					'plugins/jquery/jquery-3.5.1',
					'plugins/bootstrap/js/bootstrap.bundle.min',
					'plugins/jquery-ui/jquery-ui.min',
					'plugins/overlayScrollbars/js/jquery.overlayScrollbars.min',
					'dist/js/adminlte',
					//DataTables>
					'plugins/datatables-net/js/jquery.dataTables.min',
					'plugins/datatables-net/js/dataTables.responsive.min',
					//sweetalert2
					'plugins/sweetalert2/sweetalert2.all',
				)
			);

			$wsdl = 'http://localhost:81/PAWEB/WSRecursos.asmx?WSDL';

			$options = array(
				"uri" => $wsdl,
				"style" => SOAP_RPC,
				"use" => SOAP_ENCODED,
				"soap_version" => SOAP_1_1,
				"connection_timeout" => 60,
				"trace" => false,
				"encoding" => "UTF-8",
				"exceptions" => false,
			);

			$soap = new SoapClient($wsdl, $options);

			// NOTIFICACIONES TOTAL
			$param100 = array(
				"post"	=> 2,  	// consultar por DNI para obtener cantidad de notificaciones
				"top"	=> 0,	// no se usa para esta consulta
				"dni"	=> $_SESSION['dni'],
			);

			$result100 = $soap->ListarPaNotificaciones($param100);
			$countnoti = json_decode($result100->ListarPaNotificacionesResult, true);

			$_SESSION['num_notificaciones'] = intval($countnoti[0]['i_delay']);

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function cargar_cts()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->setCss_Specific(
				array(
					'plugins/fontawesome-free/css/all.min',
					'plugins/overlayScrollbars/css/OverlayScrollbars.min',
					'dist/css/adminlte',
					//DataTables>
					'plugins/datatables-responsive/css/responsive.bootstrap4.min',
					'plugins/datatables-net/css/jquery.dataTables.min',
					'plugins/datatables-net/css/responsive.dataTables.min',
				)
			);
	
			$this->_view->setJs_Specific(
				array(
					'plugins/jquery/jquery-3.5.1',
					'plugins/bootstrap/js/bootstrap.bundle.min',
					'plugins/jquery-ui/jquery-ui.min',
					'plugins/overlayScrollbars/js/jquery.overlayScrollbars.min',
					'dist/js/adminlte',
					//DataTables>
					'plugins/datatables-net/js/jquery.dataTables.min',
					'plugins/datatables-net/js/dataTables.responsive.min',
					//sweetalert2
					'plugins/sweetalert2/sweetalert2.all',
				)
			);

			$periodo = $_POST['periodo'];

			$wsdl = 'http://localhost:81/PAWEB/WSRecursos.asmx?WSDL';

			$options = array(
				"uri" => $wsdl,
				"style" => SOAP_RPC,
				"use" => SOAP_ENCODED,
				"soap_version" => SOAP_1_1,
				"connection_timeout" => 60,
				"trace" => false,
				"encoding" => "UTF-8",
				"exceptions" => false,
			);

			$soap = new SoapClient($wsdl, $options);

			$params = array(
				'periodo' => $periodo
			);

			$result = $soap->ListarCTS($params);
			$listarcts = json_decode($result->ListarCTSResult, true);

			$this->_view->listarcts = $listarcts;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function certificadocts()
	{
		if (isset($_SESSION['usuario'])) {

			$dni = $_GET['dni'];
			$periodo = $_GET['periodo'];

			function html_caracteres($string)
			{
				$string = str_replace(
					array('&amp;', '&Ntilde;', '&Aacute;', '&Eacute;', '&Iacute;', '&Oacute;', '&Uacute;'),
					array('&', 'Ñ', 'Á', 'É', 'Í', 'Ó', 'Ú'),
					$string
				);
				return $string;
			}

			function html_caracteresmin($string)
			{
				$string = str_replace(
					array('&amp;', '&ntilde;', '&aacute;', '&eacute;', '&iacute;', '&oacute;', '&uacute;'),
					array('&', 'ñ', 'á', 'é', 'í', 'ó', 'ú'),
					$string
				);
				return $string;
			}

			$wsdl = 'http://localhost:81/PAWEB/WSRecursos.asmx?WSDL';

			$options = array(
				"uri" => $wsdl,
				"style" => SOAP_RPC,
				"use" => SOAP_ENCODED,
				"soap_version" => SOAP_1_1,
				//"cache_wsdl"=> WSDL_CACHE_BOTH,
				"connection_timeout" => 60,
				"trace" => false,
				"encoding" => "UTF-8",
				"exceptions" => false,
			);

			$params = array(
				'post'=>1,
				'dni' => $dni,
				'periodo' => $periodo
			);
			
			$soap2 = new SoapClient($wsdl, $options);
			$result2 = $soap2->CertificadoCts($params);
			$impcts = json_decode($result2->CertificadoCtsResult, true);

			$ruc = $impcts[0]['RUC'];
			$razon = html_caracteres($impcts[0]['RAZON']);
			$direccion = html_caracteres($impcts[0]['DIRECCION']);
			$representante = html_caracteresmin($impcts[0]['REPRESENTANTE']);

			$articulo = $impcts[0]['ARTICULO'];
			$ley = $impcts[0]['LEY'];
			$decreto = $impcts[0]['DECRETO'];

			$dni = trim($impcts[0]['PERID']);
			$nombre = html_caracteres($impcts[0]['NOMBRES']);
			$nombrefirma = utf8_decode(html_caracteres($impcts[0]['NOMBRES']));

			$fechapago = $impcts[0]['FECHAPAGO'];
			$nrocuenta = trim($impcts[0]['NROCUENTA']);
			$entidadbancaria = trim($impcts[0]['ENTIDADBANCARIA']);
			$moneda = trim($impcts[0]['MONEDA']);
			$tipocambio = trim($impcts[0]['TIPOCAMBIO']);

			$fechainicio = trim($impcts[0]['FECHAINICIO']);
			$fechafin = trim($impcts[0]['FECHAFIN']);

			$basico = $impcts[0]['SUELDOBASICO'];
			$asigfamiliar = $impcts[0]['ASIGNACIONFAMILIAR'];
			$alimentacion = $impcts[0]['ALIMENTACION'];
			$comision = $impcts[0]['COMISION'];
			$horasextras = $impcts[0]['HORASEXTRAS'];
			$sextogra = $impcts[0]['SEXTOGRATIFICACION'];
			$meses = $impcts[0]['MESESCOMPUTABLES'];
			$dias = $impcts[0]['DIASCOMPUTABLES'];
			$retjudicial = $impcts[0]['RETENCIONJUD'];
			$ctsmeses = $impcts[0]['CTSMESES'];
			$ctsdias = $impcts[0]['CTSDIAS'];
			$ctstotal = $impcts[0]['CTSTOTAL'];

			// 
			// $decreto = utf8_decode(html_caracteres($impcts[0]['DECRETO']));
			
			// $anhio = $impcts[0]['ANHIO'];

			$this->getLibrary('fpdf/fpdf');
			$this->getLibrary('fpdf/makefont/makefont');
			
			$pdf = new FPDF('P', 'mm', 'A4');
			// $pdf=new PDF_WriteTag();

			$pdf->AddPage();
			$pdf->SetMargins(25, 4, 25);
			$pdf->Image('./public/dist/img/fondoagua.jpg', 0, 0, 210, 300, "jpg");

			$pdf->SetXY(25, 15);
			$pdf->AddFont('CenturyGothic-Bold', '', 'GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold', 'U', 12);
			$pdf->MultiCell(160, 4, utf8_decode("LIQUIDACION DE DEPÓSITO SEMESTRAL DE CTS"), 0, "C", false);

			$pdf->SetXY(25, 25);
			$pdf->AddFont('CenturyGothic', '', 'GOTHIC.php');
			// Stylesheet
			$pdf->SetStyle("p","CenturyGothic","",8,"0,0,0",0);
			$pdf->SetStyle("a","times","BU",9,"0,0,255");
			$pdf->SetStyle("pers","times","I",0,"255,0,0");
			$pdf->SetStyle("place","arial","U",0,"153,0,0");
			$pdf->SetStyle("vb","CenturyGothic-Bold","",0,"0,0,0");

			// Text
			$txt=utf8_decode(" 
			<p><vb>$razon</vb> con <vb>RUC Nº $ruc</vb>, domiciliado en $direccion, 
			representada por su Gerente General <vb>$representante</vb>, en aplicación del $articulo, 
			$ley aprobado mediante el $decreto, otorga a 
			<vb>$nombre</vb>, con DNI N° <vb>$dni</vb>, la presente constancia del depósito de su Compensación por 
			Tiempo de Servicio realizado el <vb>$fechapago</vb>, en la cuenta CTS N° <vb>$nrocuenta</vb> del <vb>$entidadbancaria $moneda</vb>, por los 
			siguientes montos y periodos:</p>");
			$pdf->WriteTag(0,4,$txt,0,"J",0,5);

			// PARTE 1
			$pdf->SetXY(25, 58);
			$txt3=utf8_decode("<p><vb>1. PERIODO(S) QUE SE LIQUIDA(N):</vb></p>");
			$pdf->WriteTag(0,4,$txt3,0,"J",0,5);

			$pdf->SetXY(33, 70);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(122, 4, utf8_decode("  Del $fechainicio al $fechafin"), 0, 0, 'L', false);

			// PARTE 2
			$pdf->SetXY(25, 73);
			$txt3=utf8_decode("<p><vb>2. REMUNERACIÓN COMPUTABLE:</vb></p>");
			$pdf->WriteTag(0,4,$txt3,0,"J",0,5);

			$pdf->SetXY(33, 84);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(122, 4, utf8_decode("- Sueldo Básico"), 0, 0, 'L', false);
			$pdf->Cell(23, 4, number_format($basico,2), 0, 0, 'R', false);

			$pdf->SetXY(33, 88);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(122, 4, utf8_decode("- Asignación Familiar"), 0, 0, 'L', false);
			$pdf->Cell(23, 4, number_format($asigfamiliar,2), 0, 0, 'R', false);

			// $pdf->SetXY(33, 92);
			// $pdf->AddFont('CenturyGothic','','GOTHIC.php');
			// $pdf->SetFont('CenturyGothic','',8);
			// $pdf->Cell(122, 4, utf8_decode("- Alimentación Principal"), 0, 0, 'L', false);
			// $pdf->Cell(23, 4, number_format($alimentacion,2), 0, 0, 'R', false);

			$pdf->SetXY(33, 92);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(122, 4, utf8_decode("- Comisión (promedio semestral)"), 0, 0, 'L', false);
			$pdf->Cell(23, 4, number_format($comision,2), 0, 0, 'R', false);

			$pdf->SetXY(33, 96);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(122, 4, utf8_decode("- Horas Extras (promedio semestral)"), 0, 0, 'L', false);
			$pdf->Cell(23, 4, number_format($horasextras,2), 0, 0, 'R', false);

			$pdf->SetXY(33, 100);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(122, 4, utf8_decode("- Sexto de Gratificacion"), 0, 0, 'L', false);
			$pdf->Cell(23, 4, number_format($sextogra,2), 0, 0, 'R', false);
			
			$pdf->Line(155, 104, 177, 104); //LINEA PARA EL TOTAL

			$montototal = $basico+$asigfamiliar+$alimentacion+$comision+$sextogra;

			$pdf->SetXY(33, 105);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',8);
			$pdf->Cell(115, 4, utf8_decode("Total :"), 0, 0, 'R', false);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(30, 4, "S/ ".number_format($montototal,2), 0, 0, 'R', false);

			// PARTE 3 (CALCULO)
			$pdf->SetXY(25, 112);
			$txt3=utf8_decode("<p><vb>CÁLCULO:</vb></p>");
			$pdf->WriteTag(0,4,$txt3,0,"J",0,5);

			$pdf->SetXY(33, 123);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(50, 4, utf8_decode("- Por meses completos"), 0, 0, 'L', false);
			$pdf->Cell(30, 4, number_format($montototal,2), 0, 0, 'R', false);
			$pdf->Cell(35, 4, utf8_decode(" / 12 x ( $meses meses )"), 0, 0, 'L', false);
			$pdf->Cell(30, 4, number_format($ctsmeses,2), 0, 0, 'R', false);

			$pdf->SetXY(33, 127);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(50, 4, utf8_decode("- Por dias completos"), 0, 0, 'L', false);
			$pdf->Cell(30, 4, number_format($montototal,2), 0, 0, 'R', false);
			$pdf->Cell(35, 4, utf8_decode(" / 12 / 30 x ( $dias dias )"), 0, 0, 'L', false);
			$pdf->Cell(30, 4, number_format($ctsdias,2), 0, 0, 'R', false);

			$pdf->Line(155, 132, 177, 132); //LINEA PARA EL TOTAL EN CALCULO

			$pdf->SetXY(33, 133);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',8);
			$pdf->Cell(115, 4, utf8_decode("Total :"), 0, 0, 'R', false);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(30, 4, "S/ ".number_format($ctstotal,2), 0, 0, 'R', false);

			// PARTE 4.0 (RETENCION JUDICIAL)
			$pdf->SetXY(25, 135);
			$txt3=utf8_decode("<p><vb>RETENCIÓN JUDICIAL:</vb></p>");
			$pdf->WriteTag(0,4,$txt3,0,"J",0,5);

			$pdf->SetXY(33, 146);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(50, 4, utf8_decode("- Monto por retencion judicial"), 0, 0, 'L', false);
			$pdf->Cell(95, 4, number_format($retjudicial*-1,2), 0, 0, 'R', false);

			$pdf->Line(155, 151, 177, 151); //LINEA PARA EL TOTAL EN CALCULO

			$pdf->SetXY(33, 152);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',8);
			$pdf->Cell(115, 4, utf8_decode("Total :"), 0, 0, 'R', false);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(30, 4, "S/ ".number_format($retjudicial*-1,2), 0, 0, 'R', false);


			if ($tipocambio != 1)
			{
				// PARTE 4.1 (TIPO DE CAMBIO)
				$pdf->SetXY(29, 160);
				$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
				$pdf->SetFont('CenturyGothic-Bold','',8);
				$pdf->Cell(119, 4, utf8_decode("TIPO DE CAMBIO : $tipocambio"), 0, 0, 'L', false);		
			}

			if ($tipocambio != 1)
			{ 
				$nuevomonto = "$ ".number_format(($ctstotal-$retjudicial)/$tipocambio,2);
			}else{
				$nuevomonto = "S/ ".number_format($ctstotal-$retjudicial,2);
			}

			// PARTE 5 (MONTO DEPOSITADO)
			$pdf->SetXY(29, 165);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',8);
			$pdf->Cell(69, 4, utf8_decode("MONTO DEPOSITADO :"), 0, 0, 'L', false);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);

			if ($retjudicial > 0){
				if ($tipocambio != 1){
					$pdf->Cell(50, 4, utf8_decode("( $ctstotal - $retjudicial) / $tipocambio"), 0, 0, 'L', false);
				}else{
					$pdf->Cell(50, 4, utf8_decode("( $ctstotal - $retjudicial)"), 0, 0, 'L', false);
				}
			}else{
				$pdf->Cell(50, 4, utf8_decode(""), 0, 0, 'L', false);
			}

			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',8);
			$pdf->Cell(30, 4, $nuevomonto, 0, 0, 'R', false);

			$pdf->Line(155, 170, 177, 170); //LINEA PARA EL TOTAL EN CALCULO
			$pdf->Line(155, 171, 177, 171); //LINEA PARA EL TOTAL EN CALCULO

			// FIRMA DEL REPRESENTANTE LEGAL
			//$pdf->Image('./public/dist/img/firmamaster.png', 40, 194, 65, 22, "png");
			if ($periodo < '202111'){
				$pdf->Image('./public/dist/img/firmamaster.png', 15, 192, 105, 0, "png");
			} else {
				$pdf->Image('./public/dist/img/firmamaster2.png', 30, 190, 75, 0, "png");
			}

			$pdf->SetXY(40, 214);
			$pdf->Cell(50, 3, "_________________________________________", 0, 0, "C");
			$pdf->SetXY(40, 218);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',8);
			$pdf->Cell(50, 3, strtoupper("$representante"), 0, 0, "C");

			// FIRMA DEL TRABAJADOR
			//$pdf->Image('./public/doc/firmas/72130767_20210426_150641.png', 117, 200, 55, 22, "png");

			$pdf->SetXY(120, 214);
			$pdf->Cell(50, 3, "_________________________________________", 0, 0, "C");
			$pdf->SetXY(120, 218);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',8);
			$pdf->Cell(50, 3, strtoupper("$nombrefirma"), 0, 0, "C");

			$pdf->Output("CERTIFICADO CTS $periodo - $nombrefirma.pdf",'I');

		} else {
			$this->redireccionar('index/logout');
		}
	}

}

?>