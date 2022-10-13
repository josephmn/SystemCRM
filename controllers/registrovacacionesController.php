<?php

class registrovacacionesController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('solicitudes','registrovacaciones');

			$this->_view->setCss_Specific(
				array(
					'plugins/fontawesome-free/css/all.min',
					'plugins/overlayScrollbars/css/OverlayScrollbars.min',
					'dist/css/adminlte',
					//DataTables>
					'plugins/datatables-responsive/css/responsive.bootstrap4.min',
					'plugins/datatables-net/css/jquery.dataTables.min',
					'plugins/datatables-net/css/responsive.dataTables.min',
					//Bootstrap Color Picker y Tempusdominus Bootstrap 4
					'plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min',
					'plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min',
					//Select2
					'plugins/select2/css/select2.min',
					'plugins/select2-bootstrap4-theme/select2-bootstrap4.min',
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
					//Select2
					'plugins/select2/js/select2.full.min',
					//Optional 
					'dist/js/demo',
					//InputMask
					'plugins/moment/moment.min',
					'plugins/inputmask/min/jquery.inputmask.bundle.min',
					//bootstrap color picker y Tempusdominus Bootstrap 4
					'plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min',
					'plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min',
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

			$param = array(
				"dni" => $_SESSION['dni']
			);
			
			$result = $soap->Listarvacacionesxdni($param);
			$tbvacaciones = json_decode($result->ListarvacacionesxdniResult, true);

			// construimos la tabla
			$filas="";
			foreach($tbvacaciones as $tb){

				// revisar pdf
				if ($tb['i_estado'] == 2){
					$a2 = "<a id='".$tb['i_id']."' href='".BASE_URL."registrovacaciones/imprimir_pdf/".$tb['i_id']."' target='_blank' class='btn btn-danger btn-sm text-white'><i class='fa fa-file-pdf'></i></a>";
				} else {
					$a2 = "";
				}

				// eliminar
				if ($tb['i_estado'] == 1){
					$a = "<a id='".$tb['i_id']."' class='btn btn-danger btn-sm text-white delete'><i class='fa fa-trash-alt'></i></a>";
				} else {
					$a = "";
				}

				$filas.="
				<tr>
					<td class='text-center'>".$tb['i_id']."</td>
					<td class='text-center'><span class='badge bg-info'>".$tb['v_mes']."</span></td>
					<td class='text-center'>".$tb['d_finicio']."</td>
					<td class='text-center'>".$tb['d_ffin']."</td>
					<td class='text-center'>".$tb['i_dias']."</td>
					<td class='text-center'><span class='badge bg-".$tb['v_color_tipo']."'>".$tb['v_tipo']."</span></td>
					<td class='text-center'><span class='badge bg-".$tb['v_color']."'>".$tb['v_estado']."</span></td>
					<td class='text-center'>
						".$a2."
					</td>
					<td class='text-center'>".$tb['d_fregistro']."</td>
					<td class='text-center'>".$tb['d_faprobacion']."</td>
					<td class='text-center'>
						".$a."
					</td>
				</tr>
				";
			};

			// NOTIFICACIONES TOTAL
			$param100 = array(
				"post"	=> 2,  	// consultar por DNI para obtener cantidad de notificaciones
				"top"	=> 0,	// no se usa para esta consulta
				"dni"	=> $_SESSION['dni'],
			);

			$result100 = $soap->ListarPaNotificaciones($param100);
			$countnoti = json_decode($result100->ListarPaNotificacionesResult, true);

			$_SESSION['num_notificaciones'] = intval($countnoti[0]['i_delay']);

			$this->_view->vacaciones = $filas;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');

		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function alert()
	{
		if (isset($_SESSION['usuario'])) {

			function html_caracteres($string)
			{
				$string = str_replace(
					array('&amp;', '&ntilde;', '&aacute;', '&eacute;', '&iacute;', '&oacute;', '&uacute;'),
					array('&', 'ñ', 'á', 'é', 'í', 'ó', 'ú'),
					$string
				);
				return $string;
			}

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

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

			$param = array(
				"dni" => $_SESSION['dni']
			);

			//Envio del request
			$soap = new SoapClient($wsdl, $options);
			$result = $soap->MostrarAlert($param);
			$vacaciones = json_decode($result->MostrarAlertResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"vicon" => $vacaciones[0]['v_icon'],
					"vtitle" => $vacaciones[0]['v_title'],
					"vtext" => $vacaciones[0]['v_text'],
					"icase" => intval($vacaciones[0]['i_case'])
				)
			);

		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function toasts()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$post = $_POST['mensaje'];

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

			$param = array(
				"post" 	=> $post,
				"dni" 	=> $_SESSION['dni']
			);

			//Envio del request
			$soap = new SoapClient($wsdl, $options);
			$result = $soap->MostrarToast($param);
			$toast = json_decode($result->MostrarToastResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"id"		=> intval($toast[0]['id']),
					"class"		=> $toast[0]['classe'],
					"title"		=> $toast[0]['title'],
					"subtitle"	=> $toast[0]['subtitle'],
					"body"		=> $toast[0]['body'],
				)
			);

		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function registrarvacacion()
	{
		if (isset($_SESSION['usuario'])) {

			function html_caracteres($string)
			{
				$string = str_replace(
					array('&amp;', '&ntilde;', '&aacute;', '&eacute;', '&iacute;', '&oacute;', '&uacute;'),
					array('&', 'ñ', 'á', 'é', 'í', 'ó', 'ú'),
					$string
				);
				return $string;
			}

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$fini = $_POST['dateinicio'];
			$ffin = $_POST['datefin'];
			$dni = $_POST['dni'];
			$tipovac = $_POST['tipovac'];

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

			$param = array(
				"dateinicio" => $fini,
				"datefin" => $ffin,
				"dni" => $dni,
				"tipovac" => $tipovac,
			);

			//Envio del request
			$soap = new SoapClient($wsdl, $options);
			$result = $soap->solicitudvacaciones($param);
			$data = json_decode($result->solicitudvacacionesResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"vicon" 		=> $data[0]['v_icon'],
					"vtitle" 		=> $data[0]['v_title'],
					"vtext" 		=> html_caracteres($data[0]['v_text']),
					"itimer" 		=> $data[0]['i_timer'],
					"icase" 		=> $data[0]['i_case'],
					"vprogressbar" 	=> $data[0]['v_progressbar'],
				)
			);

		} else {
			$this->redireccionar('index/logout');
		}
	}

	// PARA REGISTRAR INCIDENCIA
	public function eliminar_registro()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");
			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$codigo = $_POST['codigo'];
			$dni = $_POST['dni'];
			$codigo = $_POST['codigo'];
			$codigo = $_POST['codigo'];

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

			$param = array(
				"id" => 1, // eliminar
				"codigo" => $codigo,
				"dni" => $dni,
				"indice" => 0, // no se lleva por que no es autorizacion ni rechazo sino eliminacion
			);

			$soap = new SoapClient($wsdl, $options);
			$result = $soap->MantenimientoVacaciones($param);
			$data = json_decode($result->MantenimientoVacacionesResult, true);
			
			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"vicon" 		=> $data[0]['v_icon'],
					"vtitle" 		=> $data[0]['v_title'],
					"vtext" 		=> $data[0]['v_text'],
					"itimer" 		=> $data[0]['i_timer'],
					"icase" 		=> $data[0]['i_case'],
					"vprogressbar" 	=> $data[0]['v_progressbar'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	// IMPRIMIR PDF DE VACACIONES
	public function imprimir_pdf($id)
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

			$param = array(
				"post" 	=> 1, //para vacaciones programadas / excepcioanles
				"id" 	=> $id
			);
			$soap = new SoapClient($wsdl, $options);
			$result = $soap->Listavacacionesdni($param);
			$vacacion = json_decode($result->ListavacacionesdniResult, true);

			$this->getLibrary('fpdf/fpdf');
			$this->getLibrary('fpdf/makefont/makefont');
			// $this->getLibrary('fpdf/makefont/makefont/GOTHIC');

			$pdf = new FPDF('P', 'mm', 'A4');
			
			$pdf->AddPage();
			$pdf->SetMargins(12, 4, 12);
			$pdf->Image('./public/dist/img/banner.png', 16, 12, 180, 18, "png");
			
			$pdf->Ln(30);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','U',18);
			$pdf->MultiCell(190, 5, utf8_decode("SOLICITUD DE VACACIONES"), 0, "C", false);

			// DATOS DEL TRABAJADOR
			$pdf->SetXY(18, 55);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',11);
			$pdf->SetFillColor(146,208,80);
			$pdf->SetTextColor(255,255,255);
			$pdf->Cell(175, 6, utf8_decode("DATOS DEL TRABAJADOR"), 1, 0, 'C', true);

			$pdf->SetXY(18, 61);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',9);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell(30, 6, utf8_decode($vacacion[0]['v_dni']), 1, 0, 'C', true);
			$pdf->Cell(105, 6, utf8_decode(html_caracteres($vacacion[0]['v_nombres'])), 1, 0, 'C', true);
			$pdf->Cell(40, 6, utf8_decode($vacacion[0]['d_ingreso']), 1, 0, 'C', true);

			$pdf->SetXY(18, 67);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',7);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFillColor(229, 229, 229);
			$pdf->Cell(30, 4, utf8_decode("DNI"), 1, 0, 'C', true);
			$pdf->Cell(105, 4, utf8_decode("APELLIDOS Y NOMBRES"), 1, 0, 'C', true);
			$pdf->Cell(40, 4, utf8_decode("FECHA DE INGRESO"), 1, 0, 'C', true);

			$pdf->SetXY(18, 71);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',9);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell(75, 6, utf8_decode(html_caracteres($vacacion[0]['v_area'])), 1, 0, 'C', true);
			$pdf->Cell(100, 6, utf8_decode(html_caracteres($vacacion[0]['v_cargo'])), 1, 0, 'C', true);

			$pdf->SetXY(18, 77);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',7);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFillColor(229, 229, 229);
			$pdf->Cell(75, 4, utf8_decode("AREA"), 1, 0, 'C', true);
			$pdf->Cell(100, 4, utf8_decode("CARGO"), 1, 0, 'C', true);

			// ESPECIFICACIONES
			$pdf->SetXY(18, 81);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',11);
			$pdf->SetFillColor(146,208,80);
			$pdf->SetTextColor(255,255,255);
			$pdf->Cell(175, 6, utf8_decode("ESPECIFICACIONES (DE USO DE RR.HH.)"), 1, 0, 'C', true);

			$pdf->SetXY(18, 87);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',9);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell(30, 6, utf8_decode($vacacion[0]['v_periodo']), 1, 0, 'C', true);
			$pdf->Cell(70, 6, utf8_decode(html_caracteres("")), 1, 0, 'C', true);
			$pdf->Cell(75, 6, utf8_decode(html_caracteres("")), 1, 0, 'C', true);

			$pdf->SetXY(18, 93);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',7);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFillColor(229, 229, 229);
			$pdf->Cell(30, 4, utf8_decode("PERIODO"), 1, 0, 'C', true);
			$pdf->Cell(70, 4, utf8_decode("PERIODO LEGAL DE GOZE"), 1, 0, 'C', true);
			$pdf->Cell(75, 4, utf8_decode("ROL OFICINA PROGRAMADO (MES DE PAGO)"), 1, 0, 'C', true);

			$pdf->SetXY(18, 97);
			$pdf->Cell(175, 12, utf8_decode(""), 1, 0);

			$pdf->SetXY(18, 94);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',7);
			$pdf->Cell(175, 12, utf8_decode("Observaciones del rol oficial programado:"), 0, 0, 'L');

			// DESCANSO FISICO
			$pdf->SetXY(18, 109);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',11);
			$pdf->SetFillColor(146,208,80);
			$pdf->SetTextColor(255,255,255);
			$pdf->Cell(175, 6, utf8_decode("DESCANSO FÍSICO"), 1, 0, 'C', true);

			$pdf->SetXY(18, 115);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',7);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFillColor(229, 229, 229);
			$pdf->Cell(30, 4, utf8_decode("FECHA INICIO (1)"), 1, 0, 'C', true);
			$pdf->Cell(30, 4, utf8_decode("FECHA INICIO (1)"), 1, 0, 'C', true);
			$pdf->Cell(28, 4, utf8_decode("DÍAS GOZADOS"), 1, 0, 'C', true);
			$pdf->Cell(30, 4, utf8_decode("FECHA INICIO (2)"), 1, 0, 'C', true);
			$pdf->Cell(30, 4, utf8_decode("FECHA INICIO (2)"), 1, 0, 'C', true);
			$pdf->Cell(27, 4, utf8_decode("DÍAS GOZADOS"), 1, 0, 'C', true);

			$pdf->SetXY(18, 119);
			$pdf->AddFont('CenturyGothic','','GOTHIC.php');
			$pdf->SetFont('CenturyGothic','',9);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell(30, 6, utf8_decode($vacacion[0]['d_finicio']), 1, 0, 'C', true);
			$pdf->Cell(30, 6, utf8_decode($vacacion[0]['d_ffin']), 1, 0, 'C', true);
			$pdf->Cell(28, 6, utf8_decode($vacacion[0]['i_dias']), 1, 0, 'C', true);
			$pdf->Cell(30, 6, utf8_decode("--/--/----"), 1, 0, 'C', true);
			$pdf->Cell(30, 6, utf8_decode("--/--/----"), 1, 0, 'C', true);
			$pdf->Cell(27, 6, utf8_decode("--"), 1, 0, 'C', true);

			$pdf->SetXY(18, 125);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell(44, 30, utf8_decode(""), 1, 0, 'C', true);
			$pdf->Cell(44, 30, utf8_decode(""), 1, 0, 'C', true);
			$pdf->Cell(44, 30, utf8_decode(""), 1, 0, 'C', true);
			$pdf->Cell(43, 30, utf8_decode(""), 1, 0, 'C', true);

			$pdf->SetXY(18, 155);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',7);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFillColor(229, 229, 229);
			$pdf->Cell(44, 9, utf8_decode(""), 1, 0, 'C', true);
			$pdf->Cell(44, 9, utf8_decode("Firma del Trabajador"), 1, 0, 'C', true);

			$pdf->Image('./'.$vacacion[0]['v_firma_personal'], 63, 130, 42, 20, "png");

			$pdf->Cell(44, 9, utf8_decode(""), 1, 0, 'C', true);
			$pdf->Cell(43, 9, utf8_decode("Firma del Trabajador"), 1, 0, 'C', true);

			// firma
			//$pdf->Image('./public/doc/firmas/07258243_20210412_213119.png', 18, 130, 43, 20, "png");
			$pdf->Image('./'.$vacacion[0]['v_firma_jefe'], 19, 130, 42, 20, "png");
			
			// primera firma jefe inmediato
			$pdf->SetXY(18, 154);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',7);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell(44, 8, utf8_decode("Autorizado por:"), 0, 0, 'C');

			$pdf->SetXY(18, 157);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',7);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell(44, 8, utf8_decode("(Firma del Jefe Inmediato)"), 0, 0, 'C');

			// segunda firma jefe inmediato
			$pdf->SetXY(106, 154);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',7);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell(44, 8, utf8_decode("Autorizado por:"), 0, 0, 'C');

			$pdf->SetXY(106, 157);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',7);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell(44, 8, utf8_decode("(Firma del Jefe Inmediato)"), 0, 0, 'C');

			// OBSERVACIONES DEL DESCANSO FÍSICO
			$pdf->SetXY(18, 164);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',11);
			$pdf->SetFillColor(146,208,80);
			$pdf->SetTextColor(255,255,255);
			$pdf->Cell(175, 6, utf8_decode("Observaciones del descanso físico: (de uso de RR.HH.)"), 1, 0, 'L', true);

			$pdf->SetXY(18, 170);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',9);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell(175, 7, utf8_decode(" 1."), 1, 0, 'L', true);

			$pdf->SetXY(18, 177);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',9);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell(175, 7, utf8_decode(" 2."), 1, 0, 'L', true);

			$pdf->SetXY(18, 184);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',9);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell(175, 7, utf8_decode(" 3."), 1, 0, 'L', true);

			$pdf->SetXY(18, 191);
			$pdf->AddFont('CenturyGothic-Bold','','GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold','',9);
			$pdf->SetTextColor(0,0,0);
			$pdf->SetFillColor(255,255,255);
			$pdf->Cell(175, 7, utf8_decode(" 4."), 1, 0, 'L', true);

			$xperiodo = utf8_decode($vacacion[0]['v_periodo']);
			$xnombres = utf8_decode(html_caracteres($vacacion[0]['v_nombres']));

			//$pdf->Output();
			$pdf->Output("VACACIONES - $xperiodo - $xnombres.pdf",'I');
			
		}else{
			$this->redireccionar('index/logout');
		}
	}

	// SUBIR ARCHIVO FIRMADO
	public function subir_archivo()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");
	
			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			if (is_array($_FILES) && count($_FILES) > 0) {

				$mime_permitidos = array('application/pdf');
				$mime = $_FILES['archivo']['type'];

				if (in_array($mime, $mime_permitidos)) {

					$id = $_POST['idvacaciones'];

					$fecha_hora = date("Ymd_His", time());
					$destino = "public/doc/pdf_vacaciones/". ltrim(rtrim($_SESSION['dni'])) . "_" . $fecha_hora . ".pdf";

					// 3145728 -> 3MB ..... 3245728 se le asigo un poco mas de peso para que pueda subir y no sea tan exacto
					// 2097152 -> 2MB
					if ($_FILES['archivo']['size'] < 3245728) {
						
						if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)) {

							$wsdl = 'http://localhost:81/PAWEB/WSRecursos.asmx?WSDL';

							$options = array(
								"uri" => $wsdl,
								"style" => SOAP_RPC,
								"use" => SOAP_ENCODED,
								"soap_version" => SOAP_1_1,
								//"cache_wsdl"=> WSDL_CACHE_BOTH,
								"connection_timeout" => 15,
								"trace" => false,
								"encoding" => "UTF-8",
								"exceptions" => false,
							);

							$param = array(
								"id" => $id,
								"dni" => ltrim(rtrim($_SESSION['dni'])),
								"directorio" => $destino,
							);

							$soap = new SoapClient($wsdl, $options);
							$result1 = $soap->Listapdfvacaciones($param);
							$subirpdf = json_decode($result1->ListapdfvacacionesResult, true);

							// 0 documento no te pertenece
							// 1 doucmento ya cargado anteriormente
							// 2 archivo cargado
							header('Content-type: application/json; charset=utf-8');
							echo $json->encode(
								array(
									"vicon" => $subirpdf[0]['v_icon'],
									"vtitle" => $subirpdf[0]['v_title'],
									"vtext" => $subirpdf[0]['v_text'],
									"icase" => intval($subirpdf[0]['i_case'])
									)
							);
							
						} else {
							header('Content-type: application/json; charset=utf-8');
							echo $json->encode(
								array(
									"vicon" => "error",
									"vtitle" => "Archivo no guardado...",
									"vtext" => "No se pudo guardar en ruta de destino!",
									"icase" => 3 //"archivo no se pudo guardar em ruta destino";
									)
							);
						}

					}else{
						header('Content-type: application/json; charset=utf-8');
						echo $json->encode(
							array(
								"vicon" => "info",
								"vtitle" => "Archivo muy pesado...",
								"vtext" => "Archivo debe pesar mas de 3 MB!",
								"icase" => 4 //"archivo muy pesado, solo 3 MB";
								)
						);
					}

				}else{
					header('Content-type: application/json; charset=utf-8');
					echo $json->encode(
						array(
							"vicon" => "info",
							"vtitle" => "Archivo no permitido...",
							"vtext" => "Favor de cargar solo archivo en PDF!",
							"icase" => 5 //"tipo de archivo no permitido , solo PDF";
							)
					);
				}

			} else {
				header('Content-type: application/json; charset=utf-8');
				echo $json->encode(
					array(
						"vicon" => "info",
						"vtitle" => "Archivo no existe...",
						"vtext" => "No se encontro ruta de origen para cargar archivo!",
						"icase" => 6 //"archivo no existe";
						)
				);
			}
			
		} else {
			$this->redireccionar('index/logout');
		}
	}

}

?>