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

			$pdf->SetMargins($pdf->left = 12, $pdf->top = 4, $pdf->right = 10);

			$pdf->Ln(2);

			// DECLARAMOS LOS FONDOS QUE USAREMOS
			$pdf->AddFont('arialbd', '', 'arialbd.php');
			$pdf->SetFont('arialbd', '', 8);

			$pdf->AddFont('arial', '', 'arial.php');
			$pdf->SetFont('arial', '', 8);

			$rptcabecara = array();

			// CEBECERA (NRO BOLETA)
			$col = array();
			$col[] = array('text' => utf8_decode("BOLETA DE PAGO MENSUAL NRO: # " . $boletas_cabecera[0]['NBRBOLETA']), 'width' => '188', 'height' => '6', 'align' => 'L', 'font_name' => 'arialbd', 'font_size' => '12', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
			$rptcabecara[] = $col;

			$pdf->SetMargins($pdf->left = 12, $pdf->top = 4, $pdf->right = 10);

			$pdf->WriteTable($rptcabecara);

			$pdf->Ln(2);

			$rptsubcabecara = array();
			// SUBCABECERA (EMPRESA, RAZON Y OTROS)
			$col = array();
			$col[] = array('text' => utf8_decode("RUC"), 'width' => '47', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode("RAZON SOCIAL"), 'width' => '47', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode("RÉGIMEN"), 'width' => '47', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode("PERIODO"), 'width' => '47', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$rptsubcabecara[] = $col;

			// DATOS SUBCABECERA
			$col = array();
			$col[] = array('text' => $boletas_cabecera[0]['RUC'], 'width' => '47', 'height' => '4', 'align' => 'C', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode($boletas_cabecera[0]['RAZONSOCIAL']), 'width' => '47', 'height' => '4', 'align' => 'C', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode($boletas_cabecera[0]['REGIMEN']), 'width' => '47', 'height' => '4', 'align' => 'C', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => $boletas_cabecera[0]['PERIODO'], 'width' => '47', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$rptsubcabecara[] = $col;

			$pdf->WriteTable($rptsubcabecara);

			$pdf->Image('./public/dist/img/titulo.png', 130, 10, 70, 8, "png");

			$pdf->Ln(4);

			///////////////////////////// BEGIN /////////////////////////////

			$pdf->SetXY(153, 36);

			$controldiascab = array();
			// CONTROL DE DIAS DEL PERSONAL (CABCERA)
			$col = array();
			$col[] = array('text' => utf8_decode("CONTROL DE DIAS"), 'width' => '47', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$controldiascab[] = $col;
			$pdf->WriteTable($controldiascab);

			$controldiasdet1 = array();
			// CONTROL DE DIAS (LABORADOS)
			$pdf->SetXY(153, 40);
			$col = array();
			$col[] = array('text' => utf8_decode("LABORADOS :"), 'width' => '37', 'height' => '4', 'align' => 'L', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LT');
			$col[] = array('text' => intval($boletas_cabecera[0]['DLABORADOS']), 'width' => '10', 'height' => '4', 'align' => 'R', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'TR');
			$controldiasdet1[] = $col;
			$pdf->WriteTable($controldiasdet1);

			$controldiasdet2 = array();
			// CONTROL DE DIAS (FALTAS)
			$pdf->SetXY(153, 44);
			$col = array();
			$col[] = array('text' => utf8_decode("FALTAS :"), 'width' => '37', 'height' => '4', 'align' => 'L', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'L');
			$col[] = array('text' => intval($boletas_cabecera[0]['FALTAS']), 'width' => '10', 'height' => '4', 'align' => 'R', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'R');
			$controldiasdet2[] = $col;
			$pdf->WriteTable($controldiasdet2);

			$controldiasdet3 = array();
			// CONTROL DE DIAS (VACACIONES)
			$pdf->SetXY(153, 48);
			$col = array();
			$col[] = array('text' => utf8_decode("VACACIONES :"), 'width' => '37', 'height' => '4', 'align' => 'L', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'L');
			$col[] = array('text' => intval($boletas_cabecera[0]['VACACIONES']), 'width' => '10', 'height' => '4', 'align' => 'R', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'R');
			$controldiasdet3[] = $col;
			$pdf->WriteTable($controldiasdet3);

			$controldiasdet4 = array();
			// CONTROL DE DIAS (PERMISO)
			$pdf->SetXY(153, 52);
			$col = array();
			$col[] = array('text' => utf8_decode("PERMISO :"), 'width' => '37', 'height' => '4', 'align' => 'L', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'L');
			$col[] = array('text' => intval($boletas_cabecera[0]['DPERMISO']), 'width' => '10', 'height' => '4', 'align' => 'R', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'R');
			$controldiasdet4[] = $col;
			$pdf->WriteTable($controldiasdet4);

			$controldiasdet5 = array();
			// CONTROL DE DIAS (LCGH)
			$pdf->SetXY(153, 56);
			$col = array();
			$col[] = array('text' => utf8_decode("LCGH :"), 'width' => '37', 'height' => '4', 'align' => 'L', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'L');
			$col[] = array('text' => intval($boletas_cabecera[0]['DLCGH']), 'width' => '10', 'height' => '4', 'align' => 'R', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'R');
			$controldiasdet5[] = $col;
			$pdf->WriteTable($controldiasdet5);

			$controldiasdet6 = array();
			// CONTROL DE DIAS (LSGH)
			$pdf->SetXY(153, 60);
			$col = array();
			$col[] = array('text' => utf8_decode("LSGH :"), 'width' => '37', 'height' => '4', 'align' => 'L', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'L');
			$col[] = array('text' => intval($boletas_cabecera[0]['DLSGH']), 'width' => '10', 'height' => '4', 'align' => 'R', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'R');
			$controldiasdet6[] = $col;
			$pdf->WriteTable($controldiasdet6);

			$controldiasdet7 = array();
			// CONTROL DE DIAS (SCGH)
			$pdf->SetXY(153, 64);
			$col = array();
			$col[] = array('text' => utf8_decode("SCGH :"), 'width' => '37', 'height' => '4', 'align' => 'L', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'L');
			$col[] = array('text' => intval($boletas_cabecera[0]['SUSPECGH']), 'width' => '10', 'height' => '4', 'align' => 'R', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'R');
			$controldiasdet7[] = $col;
			$pdf->WriteTable($controldiasdet7);

			$controldiasdet8 = array();
			// CONTROL DE DIAS (SSGH)
			$pdf->SetXY(153, 68);
			$col = array();
			$col[] = array('text' => utf8_decode("SSGH :"), 'width' => '37', 'height' => '4', 'align' => 'L', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'L');
			$col[] = array('text' => intval($boletas_cabecera[0]['SUSPESGH']), 'width' => '10', 'height' => '4', 'align' => 'R', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'R');
			$controldiasdet8[] = $col;
			$pdf->WriteTable($controldiasdet8);

			$controldiasdet9 = array();
			// CONTROL DE DIAS (DES. MEDICO)
			$pdf->SetXY(153, 72);
			$col = array();
			$col[] = array('text' => utf8_decode("DES. MÉDICO :"), 'width' => '37', 'height' => '4', 'align' => 'L', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'L');
			$col[] = array('text' => intval($boletas_cabecera[0]['DMEDICO']), 'width' => '10', 'height' => '4', 'align' => 'R', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'R');
			$controldiasdet9[] = $col;
			$pdf->WriteTable($controldiasdet9);

			$controldiasdet10 = array();
			// CONTROL DE DIAS (OTROS)
			$pdf->SetXY(153, 76);
			$col = array();
			$col[] = array('text' => utf8_decode("OTROS :"), 'width' => '37', 'height' => '4', 'align' => 'L', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'L');
			$col[] = array('text' => intval($boletas_cabecera[0]['DOTROS']), 'width' => '10', 'height' => '4', 'align' => 'R', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'R');
			$controldiasdet10[] = $col;
			$pdf->WriteTable($controldiasdet10);

			$controldiasdet11 = array();
			// CONTROL DE DIAS (INCP / ENFER)
			$pdf->SetXY(153, 80);
			$col = array();
			$col[] = array('text' => utf8_decode("INCP / ENFER :"), 'width' => '37', 'height' => '4', 'align' => 'L', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'L');
			$col[] = array('text' => intval($boletas_cabecera[0]['SUBINCAPACIDAD']), 'width' => '10', 'height' => '4', 'align' => 'R', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'R');
			$controldiasdet11[] = $col;
			$pdf->WriteTable($controldiasdet11);

			$SUB_MATERNO = "";
			$NOM_MATERNO = "";
			if ($boletas_cabecera[0]['SEXO'] == "H") {
				$SUB_MATERNO = "";
				$NOM_MATERNO = "";
			} else {
				$SUB_MATERNO = $boletas_cabecera[0]['SUBMATERNO'];
				$NOM_MATERNO = utf8_decode("MATERNIDAD : ");
			};

			$controldiasdet12 = array();
			// CONTROL DE DIAS (MATERNIDAD)
			$pdf->SetXY(153, 84);
			$col = array();
			$col[] = array('text' => $NOM_MATERNO, 'width' => '37', 'height' => '4', 'align' => 'L', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LB');
			$col[] = array('text' => $SUB_MATERNO, 'width' => '10', 'height' => '4', 'align' => 'R', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'BR');
			$controldiasdet12[] = $col;
			$pdf->WriteTable($controldiasdet12);

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

			$controldiasdet13 = array();
			// CONTROL DE DIAS (TOTAL)
			$pdf->SetXY(153, 88);
			$col = array();
			$col[] = array('text' => utf8_decode("TOTAL DÍAS :"), 'width' => '37', 'height' => '4', 'align' => 'L', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'T');
			$col[] = array('text' => array_sum($suma), 'width' => '10', 'height' => '4', 'align' => 'R', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'T');
			$controldiasdet13[] = $col;

			$pdf->WriteTable($controldiasdet13);
			///////////////////////////// END /////////////////////////////

			$pdf->Ln(3);

			$pdf->SetXY(15, 31);

			$datostrabajador = array();
			// DATOS DEL TRABAJADOR 188
			$col = array();
			$col[] = array('text' => utf8_decode("1. DATOS DEL TRABAJADOR"), 'width' => '100', 'height' => '4', 'align' => 'L', 'font_name' => 'arialbd', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
			$datostrabajador[] = $col;

			$pdf->WriteTable($datostrabajador);

			$pdf->Ln(1);

			$datostrabajadorcab = array();
			// DATOS DEL TRABAJADOR DETALLE (CABECERA)
			$col = array();
			$col[] = array('text' => utf8_decode($boletas_cabecera[0]['TDOCUMENTO']), 'width' => '20', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode("NOMBRES"), 'width' => '40', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode("APELLIDO PATERNO"), 'width' => '40', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode("APELLIDO MATERNO"), 'width' => '40', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$datostrabajadorcab[] = $col;

			$pdf->WriteTable($datostrabajadorcab);

			$datostrabajadordet = array();

			$pernombre = str_split($boletas_cabecera[0]['PERNOMBRE'], 38); // SUBAREA
			$a = 0;
			foreach ($pernombre as $pernom) {
				$a++;
			}

			$perpaterno = str_split($boletas_cabecera[0]['PERPATERNO'], 46); // SUBAREA
			$b = 0;
			foreach ($perpaterno as $perpat) {
				$b++;
			}

			$permaterno = str_split($boletas_cabecera[0]['PERMATERNO'], 46); // SUBAREA
			$c = 0;
			foreach ($permaterno as $permat) {
				$c++;
			}

			$enterppp = max(array($a, $b, $c)) > 1 ? (max(array($a, $b, $c)) - 1) : 0;

			// DATOS DEL TRABAJADOR DETALLE (DATOS)
			$col = array();
			$col[] = array('text' => $boletas_cabecera[0]['DNI'], 'width' => '20', 'height' => '4', 'align' => 'C', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode(html_caracteres($boletas_cabecera[0]['PERNOMBRE'])), 'width' => '40', 'height' => '4', 'align' => 'C', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode(html_caracteres($boletas_cabecera[0]['PERPATERNO'])), 'width' => '40', 'height' => '4', 'align' => 'C', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode(html_caracteres($boletas_cabecera[0]['PERMATERNO'])), 'width' => '40', 'height' => '4', 'align' => 'C', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$datostrabajadordet[] = $col;

			$pdf->WriteTable($datostrabajadordet);

			$datostrabajadorcab1 = array();
			// DATOS DEL TRABAJADOR DETALLE (CABECERA)
			$col = array();
			$col[] = array('text' => utf8_decode("PAÍS"), 'width' => '20', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode("FEC. NACIMIENTO"), 'width' => '40', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$datostrabajadorcab1[] = $col;

			$pdf->WriteTable($datostrabajadorcab1);

			$datostrabajadordet1 = array();
			// DATOS DEL TRABAJADOR DETALLE (DATOS)
			$col = array();
			$col[] = array('text' => utf8_decode(html_caracteres($boletas_cabecera[0]['PAIS'])), 'width' => '20', 'height' => '4', 'align' => 'C', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => $boletas_cabecera[0]['FNACIMIENTO'], 'width' => '40', 'height' => '4', 'align' => 'C', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$datostrabajadordet1[] = $col;

			$pdf->WriteTable($datostrabajadordet1);

			$pdf->Ln(4);

			$datostrabajador = array();
			// DATOS DEL TRABAJADOR VINCULADOS A LA RELACION LABORAL
			$col = array();
			$col[] = array('text' => utf8_decode("2. DATOS DEL TRABAJADOR VINCULADOS A LA RELACION LABORAL"), 'width' => '100', 'height' => '4', 'align' => 'L', 'font_name' => 'arialbd', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
			$datostrabajador[] = $col;

			$pdf->WriteTable($datostrabajador);

			$pdf->Ln(2);

			$datostrabajadorvincab = array();
			// DATOS DEL TRABAJADOR VINCULADOS A LA RELACION LABORAL (CABECERA)
			$col = array();
			$col[] = array('text' => utf8_decode("TIPO TRABAJADOR"), 'width' => '32', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode("FEC. INGRESO"), 'width' => '30', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode("ÁREA"), 'width' => '78', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$datostrabajadorvincab[] = $col;

			$pdf->WriteTable($datostrabajadorvincab);

			$datostrabajadorvindet = array();

			$ttrabajador = str_split($boletas_cabecera[0]['TTRABAJADOR'], 18); // SUBAREA
			$d = 0;
			foreach ($ttrabajador as $tta) {
				$d++;
			}

			$area = str_split($boletas_cabecera[0]['AREA'], 46); // SUBAREA
			$e = 0;
			foreach ($area as $are) {
				$e++;
			}

			$enterta = max(array($d, $e)) > 1 ? (max(array($d, $e)) - 1) : 0;

			// DATOS DEL TRABAJADOR VINCULADOS A LA RELACION LABORAL (DETALLE)
			$col = array();
			$col[] = array('text' => utf8_decode($boletas_cabecera[0]['TTRABAJADOR']), 'width' => '32', 'height' => '4', 'align' => 'C', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => $boletas_cabecera[0]['FINGRESO'], 'width' => '30', 'height' => '4', 'align' => 'C', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode($boletas_cabecera[0]['AREA']), 'width' => '78', 'height' => '4', 'align' => 'C', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$datostrabajadorvindet[] = $col;

			$pdf->WriteTable($datostrabajadorvindet);

			$datostrabajadorvincab1 = array();
			// DATOS DEL TRABAJADOR VINCULADOS A LA RELACION LABORAL (CABECERA)
			$col = array();
			$col[] = array('text' => utf8_decode("SUB ÁREA"), 'width' => '65', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode("CARGO"), 'width' => '75', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$datostrabajadorvincab1[] = $col;

			$pdf->WriteTable($datostrabajadorvincab1);

			$datostrabajadorvindet1 = array();

			$subarea = str_split($boletas_cabecera[0]['SUBAREA'], 38); // SUBAREA
			$f = 0;
			foreach ($subarea as $sba) {
				$f++;
			}

			$subcargo = str_split($boletas_cabecera[0]['CARGO'], 44); // SUBAREA
			$g = 0;
			foreach ($subcargo as $sbca) {
				$g++;
			}

			$enterac = max(array($f, $g)) > 1 ? (max(array($f, $g)) - 1) : 0;

			// DATOS DEL TRABAJADOR VINCULADOS A LA RELACION LABORAL (DETALLE)
			$col = array();
			$col[] = array('text' => utf8_decode($boletas_cabecera[0]['SUBAREA']), 'width' => '65', 'height' => '4', 'align' => 'C', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode($boletas_cabecera[0]['CARGO']), 'width' => '75', 'height' => '4', 'align' => 'C', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$datostrabajadorvindet1[] = $col;

			$pdf->WriteTable($datostrabajadorvindet1);

			$datostrabajadorvincab2 = array();
			// DATOS DEL TRABAJADOR VINCULADOS A LA RELACION LABORAL (CABECERA)
			$col = array();
			$col[] = array('text' => utf8_decode("REMUNERACIÓN"), 'width' => '47', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode("MODO DE PAGO"), 'width' => '46', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode("BÁSICO TEÓRICO"), 'width' => '47', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$datostrabajadorvincab2[] = $col;

			$pdf->WriteTable($datostrabajadorvincab2);

			$datostrabajadorvindet2 = array();
			// DATOS DEL TRABAJADOR VINCULADOS A LA RELACION LABORAL (DETALLE)
			$col = array();
			$col[] = array('text' => utf8_decode($boletas_cabecera[0]['REMUNERACION']), 'width' => '47', 'height' => '4', 'align' => 'C', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode($boletas_cabecera[0]['TIPO_PAGO']), 'width' => '46', 'height' => '4', 'align' => 'C', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => number_format($boletas_cabecera[0]['BASICO'], 2), 'width' => '47', 'height' => '4', 'align' => 'C', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$datostrabajadorvindet2[] = $col;

			$pdf->WriteTable($datostrabajadorvindet2);

			$datostrabajadorvincab3 = array();
			// DATOS DEL TRABAJADOR VINCULADOS A LA RELACION LABORAL (CABECERA)
			$col = array();
			$col[] = array('text' => utf8_decode("AFP / SNP"), 'width' => '70', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode("CUSPP"), 'width' => '70', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$datostrabajadorvincab3[] = $col;

			$pdf->WriteTable($datostrabajadorvincab3);

			$datostrabajadorvindet3 = array();
			// DATOS DEL TRABAJADOR VINCULADOS A LA RELACION LABORAL (DETALLE)
			$col = array();
			$col[] = array('text' => utf8_decode($boletas_cabecera[0]['AFPNOMBRE']), 'width' => '70', 'height' => '4', 'align' => 'C', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => $boletas_cabecera[0]['NUMAFP'], 'width' => '70', 'height' => '4', 'align' => 'C', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$datostrabajadorvindet3[] = $col;

			$pdf->WriteTable($datostrabajadorvindet3);

			$datostrabajadorvincab4 = array();
			// DATOS DEL TRABAJADOR VINCULADOS A LA RELACION LABORAL (CABECERA)
			$col = array();
			$col[] = array('text' => utf8_decode("BANCO"), 'width' => '75', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode("NRO. CUENTA SUELDO"), 'width' => '65', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$datostrabajadorvincab4[] = $col;

			$pdf->WriteTable($datostrabajadorvincab4);

			$datostrabajadorvindet4 = array();
			// DATOS DEL TRABAJADOR VINCULADOS A LA RELACION LABORAL (DETALLE)
			$col = array();
			$col[] = array('text' => utf8_decode($boletas_cabecera[0]['BANCO']), 'width' => '75', 'height' => '4', 'align' => 'C', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => $boletas_cabecera[0]['CTABANCARIA'], 'width' => '65', 'height' => '4', 'align' => 'C', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$datostrabajadorvindet4[] = $col;

			$pdf->WriteTable($datostrabajadorvindet4);

			$datostrabajadorvincab5 = array();
			// DATOS DEL TRABAJADOR VINCULADOS A LA RELACION LABORAL (CABECERA)
			$col = array();
			$col[] = array('text' => utf8_decode("HR. LABORABLES"), 'width' => '35', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode("HR. SOBRETIEMPO"), 'width' => '35', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode("F. INICIO CORTE"), 'width' => '35', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode("F. FIN CORTE"), 'width' => '35', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$datostrabajadorvincab5[] = $col;

			$pdf->WriteTable($datostrabajadorvincab5);

			$datostrabajadorvindet5 = array();
			// DATOS DEL TRABAJADOR VINCULADOS A LA RELACION LABORAL (DETALLE)
			$col = array();
			$col[] = array('text' => $boletas_cabecera[0]['HLABORADAS'], 'width' => '35', 'height' => '4', 'align' => 'C', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => $boletas_cabecera[0]['HSOBRETIEMPO'], 'width' => '35', 'height' => '4', 'align' => 'C', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => $boletas_cabecera[0]['FCORTEINICIO'], 'width' => '35', 'height' => '4', 'align' => 'C', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => $boletas_cabecera[0]['FCORTEFIN'], 'width' => '35', 'height' => '4', 'align' => 'C', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$datostrabajadorvindet5[] = $col;

			$pdf->WriteTable($datostrabajadorvindet5);

			$pdf->Ln(4);

			// $pdf->SetXY(12,114);
			$datostrabajador = array();
			// DATOS DEL TRABAJADOR VINCULADOS A LA RELACION LABORAL
			$col = array();
			$col[] = array('text' => utf8_decode("3. TABLA DE BENEFICIOS Y/O CONCEPTOS REMUNERATIVOS"), 'width' => '100', 'height' => '4', 'align' => 'L', 'font_name' => 'arialbd', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => '');
			$datostrabajador[] = $col;

			$pdf->WriteTable($datostrabajador);

			$pdf->Ln(2);

			$pdf->AddFont('arialbd', '', 'arialbd.php');
			$pdf->SetFont('arialbd', '', 8);

			// TABLA DE CONCEPTOS (INICIO)
			$col = array();
			$col[] = array('text' => utf8_decode("CÓDIGO"), 'width' => '20', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode("CONCEPTOS"), 'width' => '93', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode("INGRESOS"), 'width' => '25', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode("DESCUENTOS"), 'width' => '25', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => utf8_decode("APORTES"), 'width' => '25', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
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
					$col[] = array('text' => utf8_decode($rs['RUBID']), 'width' => '20', 'height' => '4', 'align' => 'C', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LR');
					$col[] = array('text' => utf8_decode(html_caracteres($rs['RUBDESC'])), 'width' => '93', 'height' => '4', 'align' => 'J', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LR');
					$col[] = array('text' => utf8_decode($valor01), 'width' => '25', 'height' => '4', 'align' => 'R', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LR');
					$col[] = array('text' => utf8_decode($valor02), 'width' => '25', 'height' => '4', 'align' => 'R', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LR');
					$col[] = array('text' => utf8_decode($valor03), 'width' => '25', 'height' => '4', 'align' => 'R', 'font_name' => 'arial', 'font_size' => '7', 'font_style' => '', 'fillcolor' => '255,255,255', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LR');
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
			$col[] = array('text' => utf8_decode("TOTAL (S/)"), 'width' => '113', 'height' => '4', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => number_format($boletas_cabecera[0]['INGRESOS'], 2), 'width' => '25', 'height' => '4', 'align' => 'R', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => number_format($boletas_cabecera[0]['DESCUENTOS'], 2), 'width' => '25', 'height' => '4', 'align' => 'R', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => number_format($boletas_cabecera[0]['APORTES'], 2), 'width' => '25', 'height' => '4', 'align' => 'R', 'font_name' => 'arialbd', 'font_size' => '7', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
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
			$col[] = array('text' => utf8_decode("NETO A PAGAR (S/)"), 'width' => '163', 'height' => '5', 'align' => 'C', 'font_name' => 'arialbd', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$col[] = array('text' => number_format($pago_neto, 2), 'width' => '25', 'height' => '5', 'align' => 'R', 'font_name' => 'arialbd', 'font_size' => '8', 'font_style' => 'B', 'fillcolor' => '208,208,208', 'textcolor' => '0,0,0', 'drawcolor' => '0,0,0', 'linewidth' => '0.4', 'linearea' => 'LTBR');
			$neto[] = $col;

			$pdf->WriteTable($neto);
			// TABLA DE NETO A PAGAR (INICIO)

			$pdf->Ln(4);

			$extenson = explode(".", $boletas_cabecera[0]['FIRMA']);

			$ejeYimg = 125 + ($i * 5) + (($enterppp + $enterta + $enterac) * 5);
			$ejeYline = 152 + ($i * 5) + (($enterppp + $enterta + $enterac) * 5);
			$ejeYfirma = 156 + ($i * 5) + (($enterppp + $enterta + $enterac) * 5);

			if ($extenson[1] == "jpg" || $extenson[1] == "jpeg") {
				$pdf->MultiCell(
					190,
					5,
					// $pdf->Image('./public/dist/img/firma_cesar.jpg', 35, 220, 60, 35, "jpg"),
					// $pdf->Image($boletas_cabecera[0]['FIRMA'], 35, 220, 60, 35, "jpg"),
					$pdf->Image($boletas_cabecera[0]['FIRMA'], 35, $ejeYimg, 60, 35, "jpg"),
					$pdf->Cell(3),
					$pdf->SetFont('Arial', 'B', 7),
					// $pdf->SetXY(124, 246),
					$pdf->SetXY(124, $ejeYline),
					$pdf->Cell(50, 3, "________________________________", 0, 0, "C"),
					// $pdf->SetXY(124, 250),
					$pdf->SetXY(124, $ejeYfirma),
					$pdf->SetFont('Arial', 'B', 7),
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
					$pdf->Image($boletas_cabecera[0]['FIRMA'], 35, $ejeYimg, 60, 35, "png"),
					$pdf->Cell(3),
					$pdf->SetFont('Arial', 'B', 7),
					// $pdf->SetXY(124, 246),
					$pdf->SetXY(124, $ejeYline),
					$pdf->Cell(50, 3, "________________________________", 0, 0, "C"),
					// $pdf->SetXY(124, 250),
					$pdf->SetXY(124, $ejeYfirma),
					$pdf->SetFont('Arial', 'B', 7),
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
