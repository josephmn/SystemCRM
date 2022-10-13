<?php

class boletapagoController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('planillas', 'boletapago');

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

	public function cargar_boletas()
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

			$result = $soap->ListarBoletapago($params);
			$listarboletas = json_decode($result->ListarBoletapagoResult, true);

			$this->_view->listarboletas = $listarboletas;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
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
			$this->getLibrary('fpdf/makefont/makefont');

			$pdf = new FPDF('P', 'mm', 'A4');
			$pdf = new alphapdf();

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
				$pdf->Cell(48, 3, number_format($boletas_cabecera[0]['BASICO'], 2), 0, 0, "L"),
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

			$pdf->Ln(2);

			$pdf->SetX(12);
			$pdf->AddFont('arialbd', '', 'arialbd.php');
			$pdf->SetFont('arialbd', '', 8);

			// TABLA DE CONCEPTOS (INICIO)
			$col = array();
			$col[] = array('text' => utf8_decode("CÓDIGO"), 'width' => '20', 'height' => '5', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '97,194,80', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode("CONCEPTOS"), 'width' => '93', 'height' => '5', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '97,194,80', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode("INGRESOS"), 'width' => '25', 'height' => '5', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '97,194,80', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode("DESCUENTOS"), 'width' => '25', 'height' => '5', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '97,194,80', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode("APORTES"), 'width' => '25', 'height' => '5', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '97,194,80', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$colconceptos[] = $col;

			$pdf->WriteTable($colconceptos);

			$pdf->SetMargins($pdf->left = 12, $pdf->top = 4, $pdf->right = 10);

			$pdf->Ln(1);

			$i = 3;
			if (isset($boletas_detalle)) {
				foreach ($boletas_detalle as $rs) {
					// PARA INGRESOS
					if ($rs['RUBTIPO'] == "02" || $rs['RUBTIPO'] == "04") {
						$valor01 = number_format($rs['CANTIDAD'], 2);
					} else {
						$valor01 = "";
					};

					// PARA DESCUENTOS
					if ($rs['RUBTIPO'] == "03") {
						$valor02 = number_format($rs['CANTIDAD'], 2);
					} else {
						$valor02 = "";
					};

					// PARA APORTES
					if ($rs['RUBTIPO'] == "01") {
						$valor03 = number_format($rs['CANTIDAD'], 2);
					} else {
						$valor03 = "";
					};

					$pdf->AddFont('arial', '', 'arial.php');
					$pdf->SetFont('arial', '', 8);

					// ROW DATA COLUMN
					$col = array();
					$col[] = array('text' => utf8_decode($rs['RUBID']), 'width' => '20', 'height' => '5', 'align' => 'C', 'font_name' => 'arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LR');
					$col[] = array('text' => utf8_decode(html_caracteres($rs['RUBDESC'])), 'width' => '93', 'height' => '5', 'align' => 'J', 'font_name' => 'arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LR');
					$col[] = array('text' => utf8_decode($valor01), 'width' => '25', 'height' => '5', 'align' => 'R', 'font_name' => 'arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LR');
					$col[] = array('text' => utf8_decode($valor02), 'width' => '25', 'height' => '5', 'align' => 'R', 'font_name' => 'arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LR');
					$col[] = array('text' => utf8_decode($valor03), 'width' => '25', 'height' => '5', 'align' => 'R', 'font_name' => 'arial', 'font_size' => '8', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LR');
					$colconceptosdet[] = $col;
					$i++;
				}
			}

			$pdf->WriteTable($colconceptosdet);
			// TABLA DE CONCEPTOS (FIN)

			$pdf->SetMargins($pdf->left = 8, $pdf->top = 4, $pdf->right = 10);

			$pdf->Ln(1);

			$pdf->SetX(12);
			$pdf->AddFont('arialbd', '', 'arialbd.php');
			$pdf->SetFont('arialbd', '', 8);

			// TABLA DE TOTAL (INICIO)
			$col = array();
			$col[] = array('text' => utf8_decode("TOTAL (S/)"), 'width' => '113', 'height' => '5', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '97,194,80', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => number_format($boletas_cabecera[0]['INGRESOS'], 2), 'width' => '25', 'height' => '5', 'align' => 'R', 'font_name' => 'arialbd', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '97,194,80', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => number_format($boletas_cabecera[0]['DESCUENTOS'], 2), 'width' => '25', 'height' => '5', 'align' => 'R', 'font_name' => 'arialbd', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '97,194,80', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => number_format($boletas_cabecera[0]['APORTES'], 2), 'width' => '25', 'height' => '5', 'align' => 'R', 'font_name' => 'arialbd', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '97,194,80', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$total[] = $col;

			$pdf->WriteTable($total);
			// TABLA DE TOTAL (FIN)

			$pdf->Ln(1);

			$pago_neto = ($boletas_cabecera[0]['INGRESOS'] - $boletas_cabecera[0]['DESCUENTOS']);

			$pdf->SetX(12);
			$pdf->AddFont('arialbd', '', 'arialbd.php');
			$pdf->SetFont('arialbd', '', 8);

			// TABLA DE NETO A PAGAR (INICIO)
			$col = array();
			$col[] = array('text' => utf8_decode("NETO A PAGAR (S/)"), 'width' => '163', 'height' => '5', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '97,194,80', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => number_format($pago_neto, 2), 'width' => '25', 'height' => '5', 'align' => 'R', 'font_name' => 'arialbd', 'font_size' => '9', 'font_style' => 'B', 'fillcolor' => '97,194,80', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$neto[] = $col;

			$pdf->WriteTable($neto);
			// TABLA DE NETO A PAGAR (INICIO)

			$pdf->Ln(4);

			// $pdf->SetMargins($pdf->left=8, $pdf->top=4, $pdf->right=10);

			// $col = array();
			// $col[] = array('text' => $pdf->Image($boletas_cabecera[0]['FIRMA'], 35, 220, 60, 35, "jpg"), 'width' => '93', 'height' => '5', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '97,194,80', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			// $col[] = array('text' => number_format($pago_neto, 2), 'width' => '25', 'height' => '5', 'align' => 'R', 'font_name' => 'arialbd', 'font_size' => '9', 'font_style' => 'B', 'fillcolor' => '97,194,80', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			// $imagen[] = $col;

			// $pdf->WriteTable($imagen);

			$extenson = explode(".", $boletas_cabecera[0]['FIRMA']);

			$ejeYimg = 140 + ($i * 4.5);
			$ejeYline = 167 + ($i * 4.5);
			$ejeYfirma = 171 + ($i * 4.5);

			if ($extenson[1] == "jpg" || $extenson[1] == "jpeg") {
				$pdf->MultiCell(
					190,
					5,
					$pdf->Image($boletas_cabecera[0]['FIRMA'], 35, $ejeYimg, 60, 35, "jpg"),
					$pdf->Cell(3),
					$pdf->SetFont('Arial', 'B', 8),
					$pdf->SetXY(124, $ejeYline),
					$pdf->Cell(50, 3, "________________________________", 0, 0, "C"),
					$pdf->SetXY(124, $ejeYfirma),
					$pdf->SetFont('Arial', 'B', 8),
					$pdf->Cell(50, 3, "Firma del Trabajador", 0, 0, "C"),
					0,
					"L",
					false
				);
			} else {
				$pdf->MultiCell(
					190,
					5,
					$pdf->Image($boletas_cabecera[0]['FIRMA'], 35, $ejeYimg, 60, 35, "png"),
					$pdf->Cell(3),
					$pdf->SetFont('Arial', 'B', 8),
					$pdf->SetXY(124, $ejeYline),
					$pdf->Cell(50, 3, "________________________________", 0, 0, "C"),
					$pdf->SetXY(124, $ejeYfirma),
					$pdf->SetFont('Arial', 'B', 10),
					$pdf->Cell(50, 3, "Firma del Trabajador", 0, 0, "C"),
					0,
					"L",
					false
				);
			}

			$nombre = $boletas_cabecera[0]['PERNOMBRE'];
			$paterno = $boletas_cabecera[0]['PERPATERNO'];
			$materno = $boletas_cabecera[0]['PERMATERNO'];

			$pdf->Output("BOLETA-$dni-$nombre $paterno $materno.pdf", 'I');
		} else {
			$this->redireccionar('index/logout');
		}
	}
}
