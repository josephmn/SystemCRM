<?php

class localController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('asistencia','local');

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

			$params = array(
				'id' => 2,
				'zona' => 0,
			);

			$result1 = $soap->ListarLocal($params);
			$local = json_decode($result1->ListarLocalResult, true);

			$params2 = array(
				'id' => 0,
				'zona' => 0,
			);

			$result2 = $soap->ListarZona($params2);
			$zona = json_decode($result2->ListarZonaResult, true);

			// NOTIFICACIONES TOTAL
			$param100 = array(
				"post"	=> 2,  	// consultar por DNI para obtener cantidad de notificaciones
				"top"	=> 0,	// no se usa para esta consulta
				"dni"	=> $_SESSION['dni'],
			);

			$result100 = $soap->ListarPaNotificaciones($param100);
			$countnoti = json_decode($result100->ListarPaNotificacionesResult, true);

			$_SESSION['num_notificaciones'] = intval($countnoti[0]['i_delay']);

			$this->_view->local = $local;
			$this->_view->zona = $zona;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
		}else{
			$this->redireccionar('index/logout');
		}
    }

	public function get_local()
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
				'id' => 3, //para consultar y obtener datos de un local
				'zona' => $id, // codigo del local a obtener los datos
			);

			$soap = new SoapClient($wsdl, $options);
			$result2 = $soap->ListarLocal($params);
			$local = json_decode($result2->ListarLocalResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"nombre" => $local[0]['v_descripcion'],
					"horainicio" => $local[0]['v_hora_inicio'],
					"horafin" => $local[0]['v_hora_fin'],
					"horatolerancia" => $local[0]['v_tolerancia'],
					"tipoasistencia" => $local[0]['i_tipo_asistencia'],
					"zona" => intval($local[0]['i_zona']),
					"estado" => intval($local[0]['i_estado']),
					"abrev" => $local[0]['v_abreviatura'],
				)
			);

		}else{
			$this->redireccionar('index/logout');
		}
    }

	public function mantenimiento_local()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$id = $_POST['id'];
			$local = $_POST['local'];
			$nombre = $_POST['nombre'];
			$idzona = $_POST['idzona'];
			$estado = $_POST['estado'];
			$abrev = $_POST['abrev'];
			$horaini = $_POST['horaini'];
			$horafin = $_POST['horafin'];
			$tolerancia = $_POST['tolerancia'];
			$tipoasistencia = $_POST['tipoasistencia'];

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
				'local' => $local,
				'nombre' => $nombre,
				'zona' => $idzona,
				'estado' => $estado,
				'abrev' => $abrev,
				'user' => $_SESSION['dni'],
				'hinicio' => $horaini,
				'hfin' => $horafin,
				'htolerancia' => $tolerancia,
				'tipoasistencia' => $tipoasistencia,
			);

			$soap = new SoapClient($wsdl, $options);
			$result = $soap->MantLocal($params);
			$local = json_decode($result->MantLocalResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"vicon" 		=> $local[0]['v_icon'],
					"vtitle" 		=> $local[0]['v_title'],
					"vtext" 		=> $local[0]['v_text'],
					"itimer" 		=> $local[0]['i_timer'],
					"icase" 		=> $local[0]['i_case'],
					"vprogressbar" 	=> $local[0]['v_progressbar'],
				)
			);
		}else{
			$this->redireccionar('index/logout');
		}

    }
}

?>