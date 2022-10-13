<?php

class documentospagoController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('documentopay','documentospago');

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
				//"cache_wsdl"=> WSDL_CACHE_BOTH,
				"connection_timeout" => 60,
				"trace" => false,
				"encoding" => "UTF-8",
				"exceptions" => false,
			);

			$params = array(
				'dni' => trim($_SESSION['dni']),
			);

			$soap = new SoapClient($wsdl, $options);
			// consulta de boletas mensuales
			$result = $soap->Listaboletapago($params);
			$boletas = json_decode($result->ListaboletapagoResult, true);

			$params1 = array(
				'anhio' => 0,
				'dni' => trim($_SESSION['dni']),
			);
			
			$soap1 = new SoapClient($wsdl, $options);
			$result1 = $soap1->CertificadoUtilidades($params1);
			$certificadouti = json_decode($result1->CertificadoUtilidadesResult, true);

			$params2 = array(
				'post'=> 0,
				'dni' => trim($_SESSION['dni']),
				'periodo' =>'202105'
			);
			
			$soap2 = new SoapClient($wsdl, $options);
			$result2 = $soap2->CertificadoCts($params2);
			$certificadocts = json_decode($result2->CertificadoCtsResult, true);

			// NOTIFICACIONES TOTAL
			$param100 = array(
				"post"	=> 2,  	// consultar por DNI para obtener cantidad de notificaciones
				"top"	=> 0,	// no se usa para esta consulta
				"dni"	=> $_SESSION['dni'],
			);

			$result100 = $soap->ListarPaNotificaciones($param100);
			$countnoti = json_decode($result100->ListarPaNotificacionesResult, true);

			$_SESSION['num_notificaciones'] = intval($countnoti[0]['i_delay']);

			$this->_view->boletas = $boletas;
			$this->_view->certificadouti = $certificadouti;
			$this->_view->certificadocts = $certificadocts;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function guardar_log()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$boleta = $_POST['boleta'];
			$ip = $_POST['ip'];

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
				'dni' => $_SESSION['dni'],
				'nroboleta' => $boleta,
				'ip' => $ip,
			);

			$soap = new SoapClient($wsdl, $options);
			$result = $soap->LogBoletas($params);
			$logboletas = json_decode($result->LogBoletasResult, true);

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"vicon" 		=> $logboletas[0]['v_icon'],
					"vtitle" 		=> $logboletas[0]['v_title'],
					"vtext" 		=> $logboletas[0]['v_text'],
					"itimer" 		=> $logboletas[0]['i_timer'],
					"icase" 		=> $logboletas[0]['i_case'],
					"vprogressbar" 	=> $logboletas[0]['v_progressbar'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function guardar_log_uti()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$periodo = $_POST['periodo'];
			$ip = $_POST['ip'];

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
				'dni' => $_SESSION['dni'],
				'periodo' => $periodo,
				'ip' => $ip,
			);

			$soap = new SoapClient($wsdl, $options);
			$result = $soap->LogUtilidades($params);
			$logutilidades = json_decode($result->LogUtilidadesResult, true);

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"vicon" 		=> $logutilidades[0]['v_icon'],
					"vtitle" 		=> $logutilidades[0]['v_title'],
					"vtext" 		=> $logutilidades[0]['v_text'],
					"itimer" 		=> $logutilidades[0]['i_timer'],
					"icase" 		=> $logutilidades[0]['i_case'],
					"vprogressbar" 	=> $logutilidades[0]['v_progressbar'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function guardar_log_cts()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$periodo = $_POST['periodo'];
			$ip = $_POST['ip'];

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
				'dni' => $_SESSION['dni'],
				'periodo' => $periodo,
				'ip' => $ip,
			);

			$soap = new SoapClient($wsdl, $options);
			$result = $soap->LogCTS($params);
			$logcts = json_decode($result->LogCTSResult, true);

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"vicon" 		=> $logcts[0]['v_icon'],
					"vtitle" 		=> $logcts[0]['v_title'],
					"vtext" 		=> $logcts[0]['v_text'],
					"itimer" 		=> $logcts[0]['i_timer'],
					"icase" 		=> $logcts[0]['i_case'],
					"vprogressbar" 	=> $logcts[0]['v_progressbar'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function boleta($boleta)
	{
		if (isset($_SESSION['usuario'])) {

			function html_caracteres($string)
			{
				$string = str_replace(
					array('&amp;', '&Ntilde;', '&Aacute;', '&Eacute;', '&Iacute;', '&Oacute;', '&Uacute;'),
					array('&', 'Ñ', 'Á', 'É', 'Í', 'Ó', 'Ú'),
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
				'nroboleta' => $boleta,
			);

			$soap = new SoapClient($wsdl, $options);

			$result1 = $soap->Listaboletacabecera($params);
			$boletas_cabecera = json_decode($result1->ListaboletacabeceraResult, true);

			$result2 = $soap->Listaboletadetalle($params);
			$boletas_detalle = json_decode($result2->ListaboletadetalleResult, true);

			//var_dump($boletas_cabecera);exit;

			$dni = $boletas_cabecera[0]['DNI'];
			// var_dump($boletas_cabecera);

			$this->getLibrary('fpdf/fpdf');

			$pdf = new FPDF('P', 'mm', 'A4');
			$pdf->AddPage();

			$pdf->Cell(2);
			$pdf->SetMargins(8, 1, 10);
			$pdf->Cell(0, 23, "", 1, 0, "C");

			$pdf->SetFont('Arial', 'B', 12);
			$pdf->MultiCell(
				190,
				-2,
				"",
				0,
				"L",
				false
			);
			$pdf->MultiCell(190, 10, "BOLETA DE PAGO MENSUAL NRO: # " . $boletas_cabecera[0]['NBRBOLETA'], 0, "C", false);

			$pdf->Ln(1);

			$pdf->MultiCell(
				190,
				5,
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(5),
				$pdf->Cell(27, 5, "RAZON SOCIAL : ", 0, 0, "L"),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(80, 5, $boletas_cabecera[0]['RAZONSOCIAL'], 0, 0, "L"),
				0,
				"L",
				false
			);

			$pdf->MultiCell(
				190,
				5,
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(5),
				$pdf->Cell(27, 3, "R.U.C. : ", 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(80, 3, $boletas_cabecera[0]['RUC'], 0, 0, "L"),
				0,
				"L",
				false
			);

			$pdf->MultiCell(
				190,
				5,
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(5),
				$pdf->Cell(27, 2, "PERIODO : ", 0, 0, "L"),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(80, 2, $boletas_cabecera[0]['PERIODO'], 0, 0, "L"),
				0,
				"L",
				false
			);

			$pdf->Image('./public/dist/img/logo_boleta.jpg', 128, 17, 70, 14, "jpg");

			$pdf->Ln(2);

			$pdf->Cell(72);
			$pdf->SetMargins(8, 2, 56);
			$pdf->SetLineWidth(0.5);
			$pdf->Cell(0, 53, "", 1, 0, "C"); // CUADRO DE REGIMEN, BANCO Y REMUNERACION

			$pdf->SetFont('Arial', 'B', 12);
			$pdf->MultiCell(
				190,
				0,
				"",
				0,
				"L",
				false
			);

			$pdf->Cell(147);
			$pdf->SetMargins(8, 2, 10);
			$pdf->SetLineWidth(0.5);
			$pdf->Cell(0, 72, "", 1, 0, "C"); // CUADRO DE CONTROL DE DIAS

			$pdf->Ln(3);

			$pdf->MultiCell(
				190,
				5,
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(3),
				$pdf->Cell(32, 3, "TIPO TRABAJADOR : ", 0, 0, "L"),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(31, 3, $boletas_cabecera[0]['TTRABAJADOR'], 0, 0, "L"),
				$pdf->Cell(2),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(32, 3, "REG. LABORAL : ", 0, 0, "R"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(48, 3, $boletas_cabecera[0]['REGIMEN'], 0, 0, "L"),
				$pdf->SetFont('Arial', 'BU', 8),
				$pdf->Cell(32, 3, "CONTROL DE DIAS", 0, 0, "L"),
				0,
				"L",
				false
			);

			$pdf->MultiCell(
				190,
				5,
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(3),
				$pdf->Cell(32, 3, utf8_decode("PAÍS : "), 0, 0, "L"),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(31, 3, utf8_decode(html_caracteres($boletas_cabecera[0]['PAIS'])), 0, 0, "L"),
				$pdf->Cell(2),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(32, 3, "AFP / SNP : ", 0, 0, "R"),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(48, 3, $boletas_cabecera[0]['AFPNOMBRE'], 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(35, 3, "LABORADOS : ", 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(6, 3, $boletas_cabecera[0]['DLABORADOS'], 0, 0, "R"),
				0,
				"L",
				false
			);

			$pdf->SetLineWidth(0.5);
			$pdf->Line(12, 48, 78, 48); // LINEA DEBAJO DE PAIS

			$pdf->SetLineWidth(0.5);
			$pdf->Line(80, 55, 154, 55); //LINEA DEBAJO DE CUSPP

			$pdf->MultiCell(
				190,
				5,
				$pdf->Cell(3),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(32, 3, "TIPO DOCUMENTO : ", 0, 0, "L"),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(31, 3, $boletas_cabecera[0]['TDOCUMENTO'], 0, 0, "L"),
				$pdf->Cell(2),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(32, 3, "CUSPP : ", 0, 0, "R"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(48, 3, $boletas_cabecera[0]['NUMAFP'], 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(35, 3, "FALTAS : ", 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(6, 3, $boletas_cabecera[0]['FALTAS'], 0, 0, "R"),
				0,
				"L",
				false
			);

			$pdf->MultiCell(
				190,
				5,
				$pdf->Cell(3),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(32, 3, "NRO. DOCUMENTO : ", 0, 0, "L"),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(31, 3, $boletas_cabecera[0]['DNI'], 0, 0, "L"),
				$pdf->Cell(2),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(32, 3, "", 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(48, 3, "", 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(35, 3, "VACACIONES : ", 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(6, 3, $boletas_cabecera[0]['VACACIONES'], 0, 0, "R"),
				0,
				"L",
				false
			);

			$pdf->SetLineWidth(0.5);
			$pdf->Line(12, 58, 78, 58); //LINEA DEBAJO DE DNI

			$pdf->MultiCell(
				190,
				5,
				$pdf->Cell(3),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(32, 3, "NOMBRES : ", 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(31, 3, utf8_decode(html_caracteres($boletas_cabecera[0]['PERNOMBRE'])), 0, 0, "L"),
				$pdf->Cell(2),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(32, 3, "BANCO : ", 0, 0, "R"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(48, 3, $boletas_cabecera[0]['BANCO'], 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(35, 3, "PERMISO : ", 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(6, 3, $boletas_cabecera[0]['DPERMISO'], 0, 0, "R"),
				0,
				"L",
				false
			);

			$pdf->MultiCell(
				190,
				5,
				$pdf->Cell(3),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(32, 3, "APELLIDO PATENO : ", 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(31, 3, utf8_decode(html_caracteres($boletas_cabecera[0]['PERPATERNO'])), 0, 0, "L"),
				$pdf->Cell(2),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(32, 3, "NRO. CUENTA : ", 0, 0, "R"),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(48, 3, $boletas_cabecera[0]['CTABANCARIA'], 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(35, 3, "LCGH : ", 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(6, 3, $boletas_cabecera[0]['DLCGH'], 0, 0, "R"),
				0,
				"L",
				false
			);

			$pdf->MultiCell(
				190,
				5,
				$pdf->Cell(3),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(32, 3, "APELLIDO MATERNO : ", 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(35, 3, utf8_decode(html_caracteres($boletas_cabecera[0]['PERMATERNO'])), 0, 0, "L"),
				$pdf->Cell(2),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(32, 3, "", 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(44, 3, "", 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(35, 3, "LSGH : ", 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(6, 3, $boletas_cabecera[0]['DLSGH'], 0, 0, "R"),
				0,
				"L",
				false
			);

			$pdf->SetLineWidth(0.5);
			$pdf->Line(12, 73, 78, 73); // LINEA DEBAJO DE APELLIDO MATERNO

			$pdf->SetLineWidth(0.5);
			$pdf->Line(80, 70, 154, 70); // LINEA DEBAJO DE NUMERO DE CUENTA

			$pdf->MultiCell(
				190,
				5,
				$pdf->Cell(3),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(32, 3, "FEC. INGRESO : ", 0, 0, "L"),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(31, 3, $boletas_cabecera[0]['FINGRESO'], 0, 0, "L"),
				$pdf->Cell(2),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(32, 3, utf8_decode("REMUNERACIÓN : "), 0, 0, "R"),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(48, 3, $boletas_cabecera[0]['REMUNERACION'], 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(35, 3, "SCGH : ", 0, 0, "L"),
				$pdf->Cell(6, 3, $boletas_cabecera[0]['SUSPECGH'], 0, 0, "R"),
				0,
				"L",
				false
			);

			$pdf->MultiCell(
				190,
				5,
				$pdf->Cell(3),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(32, 3, "FIN DE CONTRATO : ", 0, 0, "L"),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(31, 3, $boletas_cabecera[0]['FIN_CONTRATO'], 0, 0, "L"),
				$pdf->Cell(2),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(32, 3, "MODO DE PAGO : ", 0, 0, "R"),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(48, 3, $boletas_cabecera[0]['TIPO_PAGO'], 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(35, 3, "SSGH : ", 0, 0, "L"),
				$pdf->Cell(6, 3, $boletas_cabecera[0]['SUSPESGH'], 0, 0, "R"),
				0,
				"L",
				false
			);

			$pdf->MultiCell(
				190,
				5,
				$pdf->Cell(3),
				$pdf->Cell(32, 3, "", 0, 0, "L"),
				$pdf->Cell(31, 3, "", 0, 0, "L"),
				$pdf->Cell(2),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(32, 3, utf8_decode("BÁSICO TEÓRICO : "), 0, 0, "R"),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(48, 3, number_format($boletas_cabecera[0]['BASICO'],2), 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(35, 3, "DES. MEDICO : ", 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(6, 3, $boletas_cabecera[0]['DMEDICO'], 0, 0, "R"),
				0,
				"L",
				false
			);

			$pdf->MultiCell(
				190,
				5,
				$pdf->Cell(3),
				$pdf->Cell(32, 3, "", 0, 0, "L"),
				$pdf->Cell(31, 3, "", 0, 0, "L"),
				$pdf->Cell(2),
				$pdf->Cell(32, 3, "", 0, 0, "L"),
				$pdf->Cell(48, 3, "", 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(35, 3, "OTROS : ", 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(6, 3, $boletas_cabecera[0]['DOTROS'], 0, 0, "R"),
				0,
				"L",
				false
			);

			$pdf->MultiCell(
				190,
				5,
				$pdf->Cell(3),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(32, 3, utf8_decode("ÁREA :"), 0, 0, "L"),
				$pdf->Cell(50, 3, $boletas_cabecera[0]['AREA'], 0, 0, "L"),
				$pdf->Cell(2),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(32, 3, "HR. LABORABLES : ", 0, 0, "L"),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(29, 3, $boletas_cabecera[0]['HLABORADAS'], 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(35, 3, "INCP / ENFER. : ", 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(6, 3, $boletas_cabecera[0]['SUBINCAPACIDAD'], 0, 0, "R"),
				0,
				"L",
				false
			);

			$SUB_MATERNO = "";
			$NOM_MATERNO = "";
			if ($boletas_cabecera[0]['SEXO'] == "H") {
				$SUB_MATERNO = "";
				$NOM_MATERNO = "";
			} else {
				$SUB_MATERNO = $boletas_cabecera[0]['SUBMATERNO'];
				$NOM_MATERNO = "MATERNIDAD : ";
			};

			$pdf->MultiCell(
				190,
				5,
				$pdf->Cell(3),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(32, 3, utf8_decode("SUB ÁREA : "), 0, 0, "L"),
				$pdf->Cell(50, 3, $boletas_cabecera[0]['SUBAREA'], 0, 0, "L"),
				$pdf->Cell(2),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(32, 3, "HR. SOBRETIEMPO : ", 0, 0, "L"),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(29, 3, $boletas_cabecera[0]['HSOBRETIEMPO'], 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(35, 3, $NOM_MATERNO, 0, 0, "L"),
				// $pdf->Cell(35, 3, "MATERNIDAD : ", 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(6, 3, $SUB_MATERNO, 0, 0, "R"),
				// $pdf->Cell(6, 3, 0, 0, 0, "R"),
				0,
				"L",
				false
			);

			$suma = array(
				intval($boletas_cabecera[0]['DLABORADOS']),
				intval($boletas_cabecera[0]['FALTAS']),
				intval($boletas_cabecera[0]['VACACIONES']),
				intval($boletas_cabecera[0]['DPERMISO']),
				intval($boletas_cabecera[0]['DLCGH']),
				intval($boletas_cabecera[0]['DLSGH']),
				intval($boletas_cabecera[0]['SUSPECGH']),
				intval($boletas_cabecera[0]['SUSPESGH']),
				intval($boletas_cabecera[0]['DMEDICO']),
				intval($boletas_cabecera[0]['DOTROS']),
				intval($boletas_cabecera[0]['SUBINCAPACIDAD']),
				intval($boletas_cabecera[0]['SUBMATERNO'])
			);

			$pdf->MultiCell(
				190,
				5,
				$pdf->SetLineWidth(0.5),
				$pdf->Line(12, 91, 150, 91), // LINEA DEBAJO DE CUADRO REGIMEN, BANCO Y REMUNERACION
				$pdf->Cell(3),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(32, 3, "CARGO : ", 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(35, 3, $boletas_cabecera[0]['CARGO'], 0, 0, "L"),
				$pdf->Cell(2),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(35, 3, "", 0, 0, "L"),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(41, 3, "", 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(35, 3, utf8_decode("TOTAL DÍAS : "), 0, 0, "L"),
				// $pdf->Cell(35, 3, "MATERNIDAD : ", 0, 0, "L"),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(6, 3, array_sum($suma), 0, 0, "R"),
				// $pdf->Cell(6, 3, 0, 0, 0, "R"),
				0,
				"L",
				false
			);

			$pdf->SetLineWidth(0.5);
			$pdf->Line(94, 108, 94, 91); // LINEA VERTICAL DE SEPARACION DE CARGO Y HORAS

			$pdf->SetLineWidth(0.5);
			$pdf->Line(157, 103, 197, 103); // LINEA DEBAJO DE SUBSIDIO PARA TOTAL

			$pdf->SetLineWidth(0.5);
			$pdf->Line(12, 108, 150, 108); // LINE DE DIVISION DE DEBAJO DE CARGO

			$pdf->SetLineWidth(0.5);
			$pdf->Line(63, 108, 63, 112); // LINEA VERTICAL DE SEPARACION DE CARGO Y HORAS

			$pdf->MultiCell(
				190,
				5,
				$pdf->Cell(3),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(34, 3, "FECHA INICIO CORTE : ", 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(20, 3, $boletas_cabecera[0]['FCORTEINICIO'], 0, 0, "L"),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(30, 3, "FECHA FIN CORTE : ", 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(61, 3, $boletas_cabecera[0]['FCORTEFIN'], 0, 0, "L"),
				$pdf->SetFont('Arial', '', 8),
				$pdf->Cell(35, 3, '', 0, 0, "L"),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(
					6,
					3,
					'',
					0,
					0,
					"R"
				),
				0,
				"L",
				false
			);

			$pdf->Ln(4);

			$pdf->Cell(4);
			$pdf->SetMargins(8, 2, 10);
			$pdf->SetLineWidth(0.5);
			$pdf->Cell(0, 7, "", 1, 0, "C"); // CUADRO QUE REDONDEA LA CABECERA DE LA TABLA DE RUBROS

			$pdf->SetFont('Arial', 'B', 12);
			$pdf->MultiCell(
				190,
				0,
				"",
				0,
				"L",
				false
			);

			$pdf->Ln(2);

			$pdf->MultiCell(
				190,
				5,
				$pdf->Cell(3),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(32, 3, utf8_decode("CÓDIGO"), 0, 0, "C"),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(50, 3, utf8_decode("CONCEPTOS"), 0, 0, "L"),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(54, 3, utf8_decode("INGRESOS"), 0, 0, "R"),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(27, 3, utf8_decode("DESCUENTOS"), 0, 0, "R"),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(25, 3, utf8_decode("APORTES"), 0, 0, "R"),
				0,
				"L",
				false
			);

			// DATOS INICIO
			$filas = "";
			if (isset($boletas_detalle)) {

				$pdf->Ln(2);

				$contador1 = 0;
				$contador2 = 0;
				$contador3 = 0;

				// $item = count($boletas_detalle);
				foreach ($boletas_detalle as $filas) {

					// PARA INGRESOS
					if ($filas['RUBTIPO'] == "02" || $filas['RUBTIPO'] == "04") {
						$valor01 = number_format($filas['CANTIDAD'], 2);
						$contador1 = $contador1 + 1;
					} else {
						$valor01 = "";
					};

					// PARA DESCUENTOS
					if ($filas['RUBTIPO'] == "03") {
						$valor02 = number_format($filas['CANTIDAD'], 2);
						$contador2 = $contador2 + 1;
					} else {
						$valor02 = "";
					};

					// PARA APORTES
					if ($filas['RUBTIPO'] == "01") {
						$valor03 = number_format($filas['CANTIDAD'], 2);
						$contador3 = $contador3 + 1;
					} else {
						$valor03 = "";
					};

					$pdf->MultiCell(
						190,
						5,
						$pdf->Cell(3),
						$pdf->SetFont('Arial', '', 8),
						$pdf->Cell(32, 3, $filas['RUBID'], 0, 0, "C"),
						$pdf->SetFont('Arial', '', 8),
						$pdf->Cell(50, 3, utf8_decode(html_caracteres($filas['RUBDESC'])), 0, 0, "L"),
						$pdf->SetFont('Arial', '', 8),
						$pdf->Cell(54, 3, $valor01, 0, 0, "R"),
						$pdf->SetFont('Arial', '', 8),
						$pdf->Cell(27, 3, $valor02, 0, 0, "R"),
						$pdf->SetFont('Arial', '', 8),
						$pdf->Cell(25, 3, $valor03, 0, 0, "R"),
						0,
						"L",
						false
					);
				}
			};
			// DATOS FIN

			$ingresos = intval($contador1);
			$descuentos = array(intval($contador1), intval($contador2));
			$aportes = array(intval($contador1), intval($contador2), intval($contador3));

			$pdf->Rect(12, 125, 188, $ingresos * 5.1); // PARA INGRESOS
			$pdf->Rect(12, 125, 188, (array_sum($descuentos) * 5.1)); // PARA DESCUENTOS
			$pdf->Rect(12, 125, 188, (array_sum($aportes) * 5.1)); // PARA APORTES

			$pdf->Ln(1);

			$pdf->Cell(4);
			$pdf->SetMargins(8, 2, 10);
			$pdf->SetLineWidth(0.5);
			$pdf->Cell(0, 7, "", 1, 0, "C");

			$pdf->SetFont('Arial', 'B', 12);
			$pdf->MultiCell(
				190,
				0,
				"",
				0,
				"L",
				false
			);

			$pdf->Ln(2);

			$pdf->MultiCell(
				190,
				5,
				$pdf->Cell(3),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(32, 3, "", 0, 0, "C"),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(50, 3, "TOTAL S/", 0, 0, "R"),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(54, 3, number_format($boletas_cabecera[0]['INGRESOS'], 2), 0, 0, "R"),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(27, 3, number_format($boletas_cabecera[0]['DESCUENTOS'], 2), 0, 0, "R"),
				$pdf->SetFont('Arial', 'B', 8),
				$pdf->Cell(25, 3, number_format($boletas_cabecera[0]['APORTES'], 2), 0, 0, "R"),
				0,
				"L",
				false
			);

			// $pdf->SetXY(0,0);
			// $pdf->SetLineWidth(0.5);
			// $pdf->Line(118, 161, 118, 168);
			// AQUI FALTA COMPLETAR LA LINEA

			$pdf->Ln(2);

			$pdf->Cell(4);
			$pdf->SetMargins(8, 2, 10);
			$pdf->SetLineWidth(0.5);
			$pdf->Cell(0, 7, "", 1, 0, "C");

			// $pdf->SetFont('Arial', 'B', 12);
			// $pdf->MultiCell(
			// 	190,
			// 	0,
			// 	"",
			// 	0,
			// 	"L",
			// 	false
			// );

			$pdf->Ln(2);

			$pago_neto = ($boletas_cabecera[0]['INGRESOS'] - $boletas_cabecera[0]['DESCUENTOS']);

			// $pdf->MultiCell(
			// 	190,
			// 	5,
				$pdf->Cell(4);
				$pdf->SetFont('Arial', 'B', 8);
				$pdf->Cell(158, 3, "NETO A PAGAR (S/)", 0, 0, "C");
				$pdf->Cell(29, 3, number_format($pago_neto, 2), 0, 0, "R");
			// 	0,
			// 	"L",
			// 	false
			// );

			$pdf->Ln(2);
			
			$extenson = explode(".",$boletas_cabecera[0]['FIRMA']);

			if ($extenson[1] == "jpg" || $extenson[1] == "jpeg"){
				$pdf->MultiCell(
					190,
					5,
					// $pdf->Image('./public/dist/img/firma_cesar.jpg', 35, 220, 60, 35, "jpg"),
					// $pdf->Image($boletas_cabecera[0]['FIRMA'], 35, 220, 60, 35, "jpg"),
					$pdf->Image($boletas_cabecera[0]['FIRMA'], 35, 230, 60, 35, "jpg"),
					$pdf->Cell(3),
					$pdf->SetFont('Arial', 'B', 8),
					// $pdf->SetXY(124, 246),
					$pdf->SetXY(124, 256),
					$pdf->Cell(50, 3, "________________________________", 0, 0, "C"),
					// $pdf->SetXY(124, 250),
					$pdf->SetXY(124, 260),
					$pdf->SetFont('Arial', 'B', 10),
					$pdf->Cell(50, 3, "Firma del Trabajador", 0, 0, "C"),
					0,
					"L",
					false
				);
			} else {
				$pdf->MultiCell(
					190,
					5,
					// $pdf->Image('./public/dist/img/firma_cesar.jpg', 35, 220, 60, 35, "jpg"),
					// $pdf->Image($boletas_cabecera[0]['FIRMA'], 35, 220, 60, 35, "png"),
					$pdf->Image($boletas_cabecera[0]['FIRMA'], 35, 230, 60, 35, "png"),
					$pdf->Cell(3),
					$pdf->SetFont('Arial', 'B', 8),
					// $pdf->SetXY(124, 246),
					$pdf->SetXY(124, 256),
					$pdf->Cell(50, 3, "________________________________", 0, 0, "C"),
					// $pdf->SetXY(124, 250),
					$pdf->SetXY(124, 260),
					$pdf->SetFont('Arial', 'B', 10),
					$pdf->Cell(50, 3, "Firma del Trabajador", 0, 0, "C"),
					0,
					"L",
					false
				);
			}

			// $pdf->MultiCell(
			// 	190,
			// 	5,
			// 	// $pdf->Image('./public/dist/img/firma_cesar.jpg', 35, 220, 60, 35, "jpg"),
			// 	$pdf->Image($boletas_cabecera[0]['FIRMA'], 35, 220, 60, 35, "jpg"),
			// 	$pdf->Cell(3),
			// 	$pdf->SetFont('Arial', 'B', 8),
			// 	$pdf->SetXY(124, 239),
			// 	$pdf->Cell(50, 3, "________________________________", 0, 0, "C"),
			// 	$pdf->SetXY(124, 244),
			// 	$pdf->SetFont('Arial', 'B', 10),
			// 	$pdf->Cell(50, 3, "Firma del Trabajador", 0, 0, "C"),
			// 	0,
			// 	"L",
			// 	false
			// );

			$nombre = $boletas_cabecera[0]['PERNOMBRE'];
			$paterno = $boletas_cabecera[0]['PERPATERNO'];
			$materno = $boletas_cabecera[0]['PERMATERNO'];

			// $pdf->SetLineWidth(0.5);
			// $pdf->Line(118, 161, 118, 168);
			$pdf->Output("BOLETA-$dni-$nombre $paterno $materno.pdf",'I');

		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function certificadoutilidades($anhio)
	{
		if (isset($_SESSION['usuario'])) {

			function html_caracteres($string)
			{
				$string = str_replace(
					array('&amp;', '&Ntilde;', '&Aacute;', '&Eacute;', '&Iacute;', '&Oacute;', '&Uacute;'),
					array('&', 'Ñ', 'Á', 'É', 'Í', 'Ó', 'Ú'),
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
				'anhio' => $anhio,
				'dni' => $_SESSION['dni'],
			);

			$soap = new SoapClient($wsdl, $options);

			$result1 = $soap->CertificadoUtilidades($params);
			$certificado = json_decode($result1->CertificadoUtilidadesResult, true);

			$ruc = $certificado[0]['RUC'];
			$razon = html_caracteres($certificado[0]['RAZON']);
			$direccion = html_caracteres($certificado[0]['DIRECCION']);
			$representante = html_caracteres($certificado[0]['REPRESENTANTE']);
			$decreto = html_caracteres($certificado[0]['DECRETO']);
			$nombre = html_caracteres($certificado[0]['NOMBRES']);
			$anhio = $certificado[0]['ANHIO'];
			$montodis = $certificado[0]['MONTODIS'];
			$porcentaje = $certificado[0]['PORCENTAJE'];

			$diaslaboradosemp = $certificado[0]['DIASLABORADOS'];
			$diaslaboradostrabajador = $certificado[0]['DIASLABORADOSEJERCICIO'];
			$participaciondias = $certificado[0]['PARTICIPACIONDIAS'];

			$remuneracionestotales = $certificado[0]['REMUNERACIONESTOTALES'];
			$remuneracionpercibida = $certificado[0]['REMUNERACIONCOMPUTABLE'];
			$participacionremunerativo = $certificado[0]['PARTICIPACIONREMUNERACION'];

			$remanenteutilidades = $certificado[0]['REMANENTEUTILIDADES'];
			$remanentetope = $certificado[0]['REMANENTETOPE'];
			$remanentefondo = $certificado[0]['REMANENTEFONDOEMPLEADO'];
			
			$rentaquinta = $certificado[0]['RENTAQTAUTILIDADES'];
			$rentajudicial = $certificado[0]['RETENCIONJUDICIAL'];
			$prestamos = $certificado[0]['PRESTAMOS'];
			$reintegros = $certificado[0]['REINTEGRO'];

			$fechapago = $certificado[0]['FECHAPAGO'];

			$nrocuenta = $certificado[0]['NROCUENTA'];
			$banco = $certificado[0]['ENTIDADBANCARIA'];
			$monedadescr = $certificado[0]['MONEDA'];
			$tipocambio = $certificado[0]['TIPOCAMBIO'];


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
			$pdf->MultiCell(160, 4, utf8_decode("LIQUIDACIÓN DE DISTRIBUCIÓN DE UTILIDADES"), 0, "C", false);

			$pdf->SetXY(25, 21);
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
			debidamente representada por $representante, en su calidad de empleador y en cumplimiento de lo 
			dispuesto por el $decreto, deja constancia de la determinación, distribución y pago de 
			la participación en las utilidades del trabajador <vb>$nombre</vb>, correspondiente al ejercicio <vb>$anhio</vb>, 
			con fecha depósito <vb>$fechapago</vb>, en la cuenta N° <vb>$nrocuenta</vb> del <vb>$banco $monedadescr</vb>.</p>
			");
			$pdf->WriteTag(0,4,$txt,0,"J",0,5);

			$pdf->Ln(2);

			$pdf->SetXY(25, 50);
			$txt2=utf8_decode("<p><vb>CÁLCULO DEL MONTO DE LA PARTICIPACIÓN EN LAS UTILIDADES</vb></p>");
			$pdf->WriteTag(0,4,$txt2,0,"J",0,5);

			// PARTE 1
			$pdf->SetXY(25, 58);
			$txt3=utf8_decode("<p><vb>1. UTILIDAD POR DISTRIBUIR</vb></p>");
			$pdf->WriteTag(0,4,$txt3,0,"J",0,5);

			$pdf->SetXY(33, 70);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(122, 4, utf8_decode("- Renta anual de la empresa antes de impuestos:"), 0, 0, 'L', false);
			$pdf->Cell(23, 4, "S/ ".number_format(($montodis)*10,2), 0, 0, 'R', false);

			$pdf->SetXY(33, 74);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(122, 4, utf8_decode("- Porcentaje a distribuir:"), 0, 0, 'L', false);
			$pdf->Cell(23, 4, $porcentaje." %", 0, 0, 'R', false);

			$pdf->SetXY(33, 78);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(122, 4, utf8_decode("- Monto a distribuir:"), 0, 0, 'L', false);
			$pdf->Cell(23, 4, "S/ ".number_format(($montodis),2), 0, 0, 'R', false);

			// PARTE 2
			$pdf->SetXY(25, 80);
			$txt4=utf8_decode("<p><vb>2. CALCULO DE LA PARTICIPACION</vb></p>");
			$pdf->WriteTag(0,4,$txt4,0,"J",0,5);

			$pdf->SetXY(28, 84);
			$txt5=utf8_decode("<p><vb>2.1. Según los dias laborados</vb></p>");
			$pdf->WriteTag(0,4,$txt5,0,"J",0,5);

			$pdf->SetXY(33, 94);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(122, 4, utf8_decode("- Número total de días laborados durante el ejercicio $anhio por todos"), 0, 0, 'L', false);

			$pdf->SetXY(33, 98);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(122, 4, utf8_decode("  los trabajadores de la empresa con derecho a percibir utilidades:"), 0, 0, 'L', false);
			$pdf->Cell(23, 4, number_format(($diaslaboradosemp),0), 0, 0, 'R', false);

			$pdf->SetXY(33, 102);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(122, 4, utf8_decode("- Número de días laborados durante el ejercicio $anhio por el trabajador:"), 0, 0, 'L', false);
			$pdf->Cell(23, 4, number_format(($diaslaboradostrabajador),0), 0, 0, 'R', false);

			$pdf->SetXY(33, 106);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(122, 4, utf8_decode("- Participación del trabajador según los días laborados:"), 0, 0, 'L', false);
			$pdf->Cell(23, 4, "S/ ".number_format(($participaciondias),2), 0, 0, 'R', false);
			
			$pdf->SetXY(28, 108);
			$txt6=utf8_decode("<p><vb>2.2. Según las remuneracion percibidas</vb></p>");
			$pdf->WriteTag(0,4,$txt6,0,"J",0,5);

			$pdf->SetXY(33, 118);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(122, 4, utf8_decode("- Remuneración computable total pagada durante el ejercicio $anhio a todos"), 0, 0, 'L', false);

			$pdf->SetXY(33, 122);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(122, 4, utf8_decode("  los trabajadores de la empresa:"), 0, 0, 'L', false);
			$pdf->Cell(23, 4, "S/ ".number_format(($remuneracionestotales),2), 0, 0, 'R', false);

			$pdf->SetXY(33, 126);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(122, 4, utf8_decode("- Remuneración computable percibida durante el ejercicio $anhio por el trabajador:"), 0, 0, 'L', false);
			$pdf->Cell(23, 4, "S/ ".number_format(($remuneracionpercibida),2), 0, 0, 'R', false);

			$pdf->SetXY(33, 130);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(122, 4, utf8_decode("- Participación del trabajador según las remuneraciones percibidas:"), 0, 0, 'L', false);
			$pdf->Cell(23, 4, "S/ ".number_format(($participacionremunerativo),2), 0, 0, 'R', false);

			// PARTE 3
			$pdf->SetXY(25, 132);
			$txt7=utf8_decode("<p><vb>3. MONTO DE LA PARTICIPACIÓN A PERCIBIR POR EL TRABAJADOR</vb></p>");
			$pdf->WriteTag(0,4,$txt7,0,"J",0,5);

			$pdf->SetXY(33, 144);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(122, 4, utf8_decode("- Participación según los días laborados:"), 0, 0, 'L', false);
			$pdf->Cell(23, 4, "S/ ".number_format($participaciondias,2), 0, 0, 'R', false);

			$pdf->SetXY(33, 148);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(122, 4, utf8_decode("- Participación según las remuneraciones percibidas:"), 0, 0, 'L', false);
			$pdf->Cell(23, 4, "S/ ".number_format($participacionremunerativo,2), 0, 0, 'R', false);

			$pdf->SetXY(33, 152);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(122, 4, utf8_decode("- Total de la participación del trabajador en las utilidades:"), 0, 0, 'L', false);
			$pdf->Cell(23, 4, "S/ ".number_format(($participaciondias+$participacionremunerativo),2), 0, 0, 'R', false);

			// PARTE 4
			$pdf->SetXY(25, 154);
			$txt8=utf8_decode("<p><vb>4. MONTO DEL REMANENTE GENERADO POR EL TRABAJADOR</vb></p>");
			$pdf->WriteTag(0,4,$txt8,0,"J",0,5);

			$pdf->SetXY(33, 166);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(122, 4, utf8_decode("- Total de la participación del trabajador en las utilidades:"), 0, 0, 'L', false);
			$pdf->Cell(23, 4, "S/ ".number_format($remanenteutilidades,2), 0, 0, 'R', false);

			$pdf->SetXY(33, 170);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(122, 4, utf8_decode("- Tope de 18 remuneraciones del trabajador:"), 0, 0, 'L', false);
			$pdf->Cell(23, 4, "S/ ".number_format($remanentetope,2), 0, 0, 'R', false);

			$pdf->SetXY(33, 174);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(122, 4, utf8_decode("- Remanente destinado al FONDOEMPLEO:"), 0, 0, 'L', false);
			$pdf->Cell(23, 4, "S/ ".number_format($remanentefondo,2), 0, 0, 'R', false);

			// PARTE 5
			$pdf->SetXY(29, 182);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',8);
			$pdf->Cell(126, 4, utf8_decode("5. RETENCIÓN RENTA DE QUINTA CATEGORÍA"), 0, 0, 'L', false);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(23, 4, "S/ - ".number_format($rentaquinta,2), 0, 0, 'R', false);

			// PARTE 6
			$pdf->SetXY(29, 189);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',8);
			$pdf->Cell(126, 4, utf8_decode("6. PRÉSTAMOS AL PERSONAL"), 0, 0, 'L', false);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(23, 4, "S/ - ".number_format($prestamos,2), 0, 0, 'R', false);

			// PARTE 7
			$pdf->SetXY(29, 196);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',8);
			$pdf->Cell(126, 4, utf8_decode("7. REINTEGRO UTILIDADES"), 0, 0, 'L', false);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(23, 4, "S/ ".number_format($reintegros,2), 0, 0, 'R', false);

			// PARTE 8
			$pdf->SetXY(29, 203);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',8);
			$pdf->Cell(126, 4, utf8_decode("8. RETENCIÓN JUDICIAL"), 0, 0, 'L', false);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',8);
			$pdf->Cell(23, 4, "S/ - ".number_format($rentajudicial,2), 0, 0, 'R', false);

			// PARTE 9
			$pdf->SetXY(29, 210);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',8);
			$pdf->Cell(126, 4, utf8_decode("9. IMPORTE PAGADO"), 0, 0, 'L', false);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',8);
			$pdf->Cell(23, 4, "S/ ".number_format((((($participaciondias+$participacionremunerativo+$reintegros)-$rentaquinta)-$rentajudicial)-$prestamos),2), 0, 0, 'R', false);

			// $pdf->Image('./public/dist/img/firmamaster.png', 40, 223, 65, 23, "png");
			//$pdf->Image('./public/dist/img/firmamaster.png', 15, 222, 105, 0, "png");

			if ($anhio < '2021'){
				$pdf->Image('./public/dist/img/firmamaster.png', 15, 222, 105, 0, "png");
			} else {
				$pdf->Image('./public/dist/img/firmamaster2.png', 30, 222, 75, 0, "png");
			}

			$pdf->SetXY(40, 244);
			$pdf->Cell(50, 3, "_________________________________________", 0, 0, "C");
			$pdf->SetXY(40, 248);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',8);
			$pdf->Cell(50, 3, strtoupper($representante), 0, 0, "C");

			// FIRMA DEL TRABAJADOR
			//$pdf->Image('./public/doc/firmas/72130767_20210426_150641.png', 117, 230, 55, 22, "png");
			$pdf->SetXY(120, 244);
			$pdf->Cell(50, 3, "_________________________________________", 0, 0, "C");
			$pdf->SetXY(120, 248);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',8);
			$pdf->Cell(50, 3, strtoupper("$nombre"), 0, 0, "C");

			$pdf->Output("CERTIFICADO UTILIDADES $anhio - $nombre.pdf",'I');

		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function certificadocts($periodo)
	{
		if (isset($_SESSION['usuario'])) {

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
				'dni' => trim($_SESSION['dni']),
				'periodo' =>$periodo
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