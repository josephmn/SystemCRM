<?php

class turnosController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index() //OK
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('asistencia','turnos');

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
				'id' => 0, //para listar todos los turnos
				'turno' => 0
			);
			//ListarGrupos
			$result = $soap->ListarTurno($params);
			$turnos = json_decode($result->ListarTurnoResult, true);

			$params2 = array(
				'post' => 1, // listar combo
				'user' => '', // no se usa aqui
			);

			$result2 = $soap->ListarSemana($params2);
			$semana = json_decode($result2->ListarSemanaResult, true);

			$params3 = array(
				'id' => 4,
				'zona' => 0,
			);
			$result3 = $soap->ListarLocal($params3);
			$local = json_decode($result3->ListarLocalResult, true);

			// NOTIFICACIONES TOTAL
			$param100 = array(
				"post"	=> 2,  	// consultar por DNI para obtener cantidad de notificaciones
				"top"	=> 0,	// no se usa para esta consulta
				"dni"	=> $_SESSION['dni'],
			);

			$result100 = $soap->ListarPaNotificaciones($param100);
			$countnoti = json_decode($result100->ListarPaNotificacionesResult, true);

			$_SESSION['num_notificaciones'] = intval($countnoti[0]['i_delay']);

			$this->_view->turnos = $turnos;
			$this->_view->semana = $semana;
			$this->_view->local = $local;


			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function mantenimiento_turnos() //OK
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$id = $_POST['id'];
			$semana = intval($_POST['semana']);
			$local = intval($_POST['local']);
			$anhio = intval($_POST['anhio']);

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
				'id' => $id,
				'semana' => $semana,
				'local' => $local,
				'anhio' => $anhio,
				'user' => $_SESSION['dni'],
			);

			$result = $soap->MantTurno($params);
			$turno = json_decode($result->MantTurnoResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"vicon" 		=> $turno[0]['v_icon'],
					"vtitle" 		=> $turno[0]['v_title'],
					"vtext" 		=> $turno[0]['v_text'],
					"itimer" 		=> $turno[0]['i_timer'],
					"icase" 		=> $turno[0]['i_case'],
					"vprogressbar" 	=> $turno[0]['v_progressbar'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function detalle_turnos() //OK
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

			$semana = $_GET['semana'];
			$descripcion = $_GET['descripcion'];
			$idsemana = $_GET['idsemana'];
			$idlocal = $_GET['idlocal'];
			$anhio = $_GET['anhio'];

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
				'id' => 1,
				'turno' => $idsemana,
			);

			$result2 = $soap->ListarTurno($params2);
			$listarturno = json_decode($result2->ListarTurnoResult, true);

			$params = array(
				'post' => 2,
				'dni' => 0,
				'local' => intval($listarturno[0]['id_local']),
			);

			$result = $soap->ListarPersonal($params);
			$listapersonal = json_decode($result->ListarPersonalResult, true);

			$params3 = array(
				'post' => 0, //consultar todo
				'semana' => $semana,
				'local' => $idlocal,
				'anhio' => $anhio, //año de la consulta anterior
				'dni' => '', //vacio por que son todos para la semana
			);
			$result3 = $soap->ListarTurnoDetalle($params3);
			$turnosdetalles = json_decode($result3->ListarTurnoDetalleResult, true);

			$this->_view->listapersonal = $listapersonal;
			$this->_view->semana = $semana;
			$this->_view->anhio = $anhio;
			$this->_view->descripcion = $descripcion;
			$this->_view->idlocal = $listarturno[0]['id_local'];
			$this->_view->localdescr = $listarturno[0]['v_local'];
			$this->_view->turnosdetalles = $turnosdetalles;

			$this->_view->setJs(array('detalleturnos'));
			$this->_view->renderizar('detalleturnos');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	// public function consulta_detalle() //OK
	// {
	// 	if (isset($_SESSION['usuario'])) {

	// 		putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
	// 		putenv("NLS_CHARACTERSET=AL32UTF8");

	// 		$this->getLibrary('json_php/JSON');
	// 		$json = new Services_JSON();

	// 		$dni = $_POST['id'];
	// 		$semana = $_POST['semana'];
	// 		$idlocal = $_POST['local'];
	// 		$anhio = intval($_POST['anhio']);

	// 		$wsdl = 'http://localhost:81/PAWEB/WSRecursos.asmx?WSDL';

	// 		$options = array(
	// 			"uri" => $wsdl,
	// 			"style" => SOAP_RPC,
	// 			"use" => SOAP_ENCODED,
	// 			"soap_version" => SOAP_1_1,
	// 			"connection_timeout" => 60,
	// 			"trace" => false,
	// 			"encoding" => "UTF-8",
	// 			"exceptions" => false,
	// 		);

	// 		$soap = new SoapClient($wsdl, $options);

	// 		$params = array(
	// 			'post' => 1, //consultar por dni
	// 			'semana' => $semana,
	// 			'local' => $idlocal,
	// 			'anhio' => $anhio,
	// 			'dni' => $dni, //con dato para consulta
	// 		);
	// 		$result = $soap->ListarTurnoDetalle($params);
	// 		$consultadetalle = json_decode($result->ListarTurnoDetalleResult, true);

	// 		header('Content-type: application/json; charset=utf-8');

	// 		echo $json->encode(
	// 			array(
	// 				"vdni" 			=> $consultadetalle[0]['v_dni'],
	// 				"vnombres" 		=> $consultadetalle[0]['v_pernombres'],
	// 			)
	// 		);
	// 	} else {
	// 		$this->redireccionar('index/logout');
	// 	}
	// }

	public function insertar_horarios() //OK
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$post = intval($_POST['post']);
			$check = $_POST['check'];
			$dias = $_POST['dias'];
			$semama = intval($_POST['semama']);
			$anhio = intval($_POST['anhio']);
			$horaini = $_POST['horaini'];
			$horafin = $_POST['horafin'];
			$tolerancia = $_POST['tolerancia'];
			$local = intval($_POST['local']);

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

			$i = 0;
			foreach ($check as $ch) {
				foreach ($dias as $di) {
					$params[$i] = array(
						'post'			=> intval($post),
						'dni' 			=> $ch,
						'dia' 			=> $di,
						'semana' 		=> intval($semama),
						'anhio' 		=> intval($anhio),
						'horainicio' 	=> $horaini,
						'horafin' 		=> $horafin,
						'tolerancia' 	=> $tolerancia,
						'local' 		=> intval($local),
						'user' 			=> trim($_SESSION['dni']),
					);
					$result = $soap->MantTurnoDetalle($params[$i]);
					$turnodetalle = json_decode($result->MantTurnoDetalleResult, true);
					$i++;
				}
			};

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"vicon" 		=> $turnodetalle[0]['v_icon'],
					"vtitle" 		=> $turnodetalle[0]['v_title'],
					"vtext" 		=> $turnodetalle[0]['v_text'],
					"itimer" 		=> $turnodetalle[0]['i_timer'],
					"icase" 		=> $turnodetalle[0]['i_case'],
					"vprogressbar" 	=> $turnodetalle[0]['v_progressbar'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function eliminar_horarios() //OK
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$post = intval($_POST['post']);
			$check = $_POST['check'];
			$dias = $_POST['dias'];
			$semama = intval($_POST['semama']);
			$anhio = intval($_POST['anhio']);
			$horaini = $_POST['horaini'];
			$horafin = $_POST['horafin'];
			$tolerancia = $_POST['tolerancia'];
			$local = intval($_POST['local']);

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
				'post'			=> intval($post),
				'dni' 			=> $check,
				'dia' 			=> $dias,
				'semana' 		=> intval($semama),
				'anhio' 		=> intval($anhio),
				'horainicio' 	=> $horaini,
				'horafin' 		=> $horafin,
				'tolerancia' 	=> $tolerancia,
				'local' 		=> intval($local),
				'user' 			=> trim($_SESSION['dni']),
			);

			$result = $soap->MantTurnoDetalle($params);
			$turnodetalle = json_decode($result->MantTurnoDetalleResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"vicon" 		=> $turnodetalle[0]['v_icon'],
					"vtitle" 		=> $turnodetalle[0]['v_title'],
					"vtext" 		=> $turnodetalle[0]['v_text'],
					"itimer" 		=> intval($turnodetalle[0]['i_timer']),
					"icase" 		=> intval($turnodetalle[0]['i_case']),
					"vprogressbar" 	=> $turnodetalle[0]['v_progressbar'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}
}
