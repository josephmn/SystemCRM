<?php

class personalController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('planillas','personal');

			$this->_view->setCss_Specific(
				array(
					'plugins/fontawesome-free/css/all.min',
					'plugins/overlayScrollbars/css/OverlayScrollbars.min',
					'dist/css/adminlte',
					//DataTables>
					'plugins/datatables-responsive/css/responsive.bootstrap4.min',
					'plugins/datatables-net/css/jquery.dataTables.min',
					'plugins/datatables-net/css/searchPanes.dataTables.min',
					'plugins/datatables-net/select.dataTables.min',
					'plugins/datatables-net/css/buttons.dataTables.min',
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
					'plugins/datatables-net/js/dataTables.searchPanes.min',
					'plugins/datatables-net/js/dataTables.select.min',
					'plugins/datatables-net/js/dataTables.buttons.min',
					'plugins/datatables-net/js/buttons.flash.min',
					// 'plugins/datatables-net/js/jszip.min',
					// 'plugins/datatables-net/js/pdfmake.min',
					'plugins/datatables-net/js/vfs_fonts',
					'plugins/datatables-net/js/buttons.html5.min',
					'plugins/datatables-net/js/buttons.print.min',
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

			$param = array(
				"post"=> 0,
				"dni" => "",
				"local" => 0,
			);

			$result = $soap->ListarPersonal($param);
			$personal = json_decode($result->ListarPersonalResult, true);

			$param1 = array(
				"id"=> 0,
				"zona" => 0,
			);

			$result1 = $soap->ListarZona($param1);
			$zona = json_decode($result1->ListarZonaResult, true);
			
			$result2 = $soap->ListarGrupoArea();
			$grupoarea = json_decode($result2->ListarGrupoAreaResult, true);

			$result3 = $soap->ListarGrupoCargo();
			$grupocargo = json_decode($result3->ListarGrupoCargoResult, true);

			// NOTIFICACIONES TOTAL
			$param100 = array(
				"post"	=> 2,  	// consultar por DNI para obtener cantidad de notificaciones
				"top"	=> 0,	// no se usa para esta consulta
				"dni"	=> $_SESSION['dni'],
			);

			$result100 = $soap->ListarPaNotificaciones($param100);
			$countnoti = json_decode($result100->ListarPaNotificacionesResult, true);

			$_SESSION['num_notificaciones'] = intval($countnoti[0]['i_delay']);

			$this->_view->personal = $personal;
			$this->_view->zona = $zona;
			$this->_view->grupoarea = $grupoarea;
			$this->_view->grupocargo = $grupocargo;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function buscar_personal()
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

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");
			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$dni = $_POST['dni'];

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
				"post"=> 1, //post consulta por dni
				"dni" => $dni,
				"local" => 0,
			);
			$soap = new SoapClient($wsdl, $options);
			
			$result = $soap->ListarPersonal($param);
			$personal = json_decode($result->ListarPersonalResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"vdni" => $personal[0]['v_dni'],
					"vnombres" => $personal[0]['v_nombres'],
					"vapellidos" => html_caracteres($personal[0]['v_paterno']).' '.html_caracteres($personal[0]['v_materno']),
					"izona" => intval($personal[0]['id_zona']),
					"ilocal" => intval($personal[0]['id_local']),
					"iarea" => intval($personal[0]['id_area']),
					"icargo" => intval($personal[0]['id_cargo']),
					"iturno" => intval($personal[0]['i_turno']),
					"iflex" => intval($personal[0]['i_flex']),
					"iremoto" => intval($personal[0]['i_remoto']),
					"imarcacion" => intval($personal[0]['i_marcacion']),
					"iventa" => intval($personal[0]['i_venta']),
				)
			);

		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function cargar_local()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");
			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$zona = $_POST['zona'];

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
				"id" => 1,
				"zona" => $zona,
			);

			$soap = new SoapClient($wsdl, $options);
			$result = $soap->ListarLocal($param);
			$local = json_decode($result->ListarLocalResult, true);

			$c=0;
			$filas="";
			foreach($local as $lc){
				$filas.="<option value=".$lc['i_codigo'].">".$lc['v_descripcion']."</option>";
			$c++;
			}

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"data" => $filas,
				)
			);

		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function mantenimientoindicador()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");
			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$dni = $_POST['dni'];
			$zona = $_POST['zona'];
			$local = $_POST['local'];
			$area = $_POST['area'];
			$cargo = $_POST['cargo'];
			$turno = $_POST['turno'];
			$flex = $_POST['flex'];
			$remoto = $_POST['remoto'];
			$marcacion = $_POST['marcacion'];
			$venta = $_POST['venta'];

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
				"dni" => $dni,
				"zona" => $zona,
				"local" => $local,
				"area" => $area,
				"cargo" => $cargo,
				"turno" => $turno,
				"flex" => $flex,
				"remoto" => $remoto,
				"marcacion" => $marcacion,
				"venta" => $venta,
				"user" => $_SESSION['dni'],
			);

			$soap = new SoapClient($wsdl, $options);
			$result = $soap->MantIndicadorPersonal($param);
			$data = json_decode($result->MantIndicadorPersonalResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"vicon" => $data[0]['v_icon'],
					"vtitle" => $data[0]['v_title'],
					"vtext" => $data[0]['v_text'],
					"itimer" => $data[0]['i_timer'],
					"icase" => $data[0]['i_case'],
					"vprogressbar" 	=> $data[0]['v_progressbar'],
				)
			);

		} else {
			$this->redireccionar('index/logout');
		}
	}

}
