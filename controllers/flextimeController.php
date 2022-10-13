<?php

class flextimeController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('asistencia','flextime');

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
					//toastr
					'plugins/toastr/toastr.min',
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
					//toastr
					'plugins/toastr/toastr.min',
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
				'id' 		=> 1, // cargar grilla
				'idflex' 	=> 0, // no se usa aqui
				'zona'		=> 0,
				'local'		=> 0,
			);

			$result1 = $soap->ListarFlexTime($params);
			$flex = json_decode($result1->ListarFlexTimeResult, true);

			$params2 = array(
				'id' => 0,
				'zona' => 0,
			);

			$result2 = $soap->ListarZona($params2);
			$zona = json_decode($result2->ListarZonaResult, true);

			$this->_view->flex = $flex;
			$this->_view->zona = $zona;

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
			$soap = new SoapClient($wsdl, $options);

			$param = array(
				"id" => 1,
				"zona" => $zona,
			);

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

	public function data_local()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");
			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$id = $_POST['id'];

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
				'id' 		=> 2, // cargar grilla
				'idflex' 	=> $id,
				'zona'		=> 0,
				'local'		=> 0,
			);

			$result1 = $soap->ListarFlexTime($params);
			$flexdata = json_decode($result1->ListarFlexTimeResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"id" 			=> $flexdata[0]['i_id'],
					"nombre" 		=> $flexdata[0]['v_nombre'],
					"horainicio" 	=> $flexdata[0]['v_hora_inicio'],
					"horafin" 		=> $flexdata[0]['v_hora_fin'],
					"tolerancia"	=> $flexdata[0]['v_tolerancia'],
					"estado" 		=> $flexdata[0]['i_estado'],
					"zona" 			=> $flexdata[0]['i_zona'],
					"local" 		=> $flexdata[0]['i_local'],
				)
			);

		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function mantenimiento_flextime()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$post = $_POST['post'];
			$id = $_POST['id'];
			$nombre = $_POST['nombre'];
			$estado = $_POST['estado'];
			$horaini = $_POST['horaini'];
			$horafin = $_POST['horafin'];
			$tolerancia = $_POST['tolerancia'];
			$idzona = $_POST['idzona'];
			$idlocal = $_POST['idlocal'];

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
				'post' => $post,
				'id' => $id,
				'nombre' => $nombre,
				'estado' => $estado,
				'hinicio' => $horaini,
				'hfin' => $horafin,
				'htolerancia' => $tolerancia,
				'zona' => $idzona,
				'local' => $idlocal,
				'user' => $_SESSION['dni'],
			);

			$soap = new SoapClient($wsdl, $options);
			$result = $soap->MantFlexTime($params);
			$flextimenew = json_decode($result->MantFlexTimeResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"vicon" 		=> $flextimenew[0]['v_icon'],
					"vtitle" 		=> $flextimenew[0]['v_title'],
					"vtext" 		=> $flextimenew[0]['v_text'],
					"itimer" 		=> $flextimenew[0]['i_timer'],
					"icase" 		=> $flextimenew[0]['i_case'],
					"vprogressbar" 	=> $flextimenew[0]['v_progressbar'],
				)
			);
		}else{
			$this->redireccionar('index/logout');
		}

    }
}

?>