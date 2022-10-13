<?php

class certificadoutilidadesController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('planillas','certificadoutilidades');

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

	public function cargar_utilidades()
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

			$anhio = $_POST['anio'];

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

			$params2 = array(
				'anhio' => $anhio
			);

			$result = $soap->ListarUtilidades($params2);
			$listarutilidades = json_decode($result->ListarUtilidadesResult, true);

			$this->_view->listarutilidades = $listarutilidades;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function certificadoutilidades()
	{
		if (isset($_SESSION['usuario'])) {

			$perid = $_GET['dni'];
			$anhio = $_GET['anhio'];

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
				'dni' => $perid,
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
			$txt3=("<p><vb>1. UTILIDAD POR DISTRIBUIR</vb></p>");
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

			//$pdf->Image('./public/dist/img/firmamaster.png', 40, 223, 65, 23, "png");
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

}

?>