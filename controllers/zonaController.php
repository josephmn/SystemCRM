<?php

class zonaController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('asistencia','zona');

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
				'id' => 1, //para listar todos los locales
				'zona' => 0, //para listar todos los locales
			);

			$soap = new SoapClient($wsdl, $options);
			$result1 = $soap->ListarZona($params);
			$zona = json_decode($result1->ListarZonaResult, true);

			// NOTIFICACIONES TOTAL
			$param100 = array(
				"post"	=> 2,  	// consultar por DNI para obtener cantidad de notificaciones
				"top"	=> 0,	// no se usa para esta consulta
				"dni"	=> $_SESSION['dni'],
			);

			$result100 = $soap->ListarPaNotificaciones($param100);
			$countnoti = json_decode($result100->ListarPaNotificacionesResult, true);

			$_SESSION['num_notificaciones'] = intval($countnoti[0]['i_delay']);

			$this->_view->zona = $zona;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
		}else{
			$this->redireccionar('index/logout');
		}
    }

	public function get_zona()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$id = $_POST['cod'];

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

			$params = array(
				'id' => 2, //para consultar y obtener datos de un local
				'zona' => $id, // codigo del local a obtener los datos
			);

			$soap = new SoapClient($wsdl, $options);
			$result2 = $soap->ListarZona($params);
			$zona = json_decode($result2->ListarZonaResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"nombre" => $zona[0]['v_descripcion'],
					"estado" => $zona[0]['i_estado'],
				)
			);

		}else{
			$this->redireccionar('index/logout');
		}
    }

	// MANTENIMIENTO ZONA
	public function mantenimiento_zona()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$id = $_POST['id'];
			$zona = $_POST['zona'];
			$nombre = $_POST['nombre'];
			$estado = $_POST['estado'];
			
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

			$params = array(
				'id' => $id,
				'zona' => $zona,
				'nombre' => $nombre,
				'estado' => $estado,
				'user' => $_SESSION['dni'],
			);

			$soap = new SoapClient($wsdl, $options);
			$result = $soap->MantZona($params);
			$zona = json_decode($result->MantZonaResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"vicon" 		=> $zona[0]['v_icon'],
					"vtitle" 		=> $zona[0]['v_title'],
					"vtext" 		=> $zona[0]['v_text'],
					"itimer" 		=> $zona[0]['i_timer'],
					"icase" 		=> $zona[0]['i_case'],
					"vprogressbar" 	=> $zona[0]['v_progressbar'],
				)
			);

		}else{
			$this->redireccionar('index/logout');
		}

    }

}

?>