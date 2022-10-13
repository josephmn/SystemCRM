<?php

class conflextimeController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('controlper','conflextime');

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

			$param1 = array(
				"post"=> 3, //mostrar años
			);

			$result3 = $soap->Listarmeses($param1);
			$anhios = json_decode($result3->ListarmesesResult, true);

			$param2 = array(
				"post"=> 2, //mostrar los meses
			);

			$result = $soap->Listarmeses($param2);
			$meses = json_decode($result->ListarmesesResult, true);

			// consultar horarios
			$param3 = array(
				"dnijefe"	=> $_SESSION['dni'],
				"anhio"		=> date("Y"),
				"mes"		=> date("n"),
			);

			$result4 = $soap->ControlFlexTime($param3);
			$controltbflex = json_decode($result4->ControlFlexTimeResult, true);

			// construimos la tabla
			$filas="";
			foreach($controltbflex as $tb){

				if ($tb['i_estado'] == 1) {
					$a = "<a id='".$tb['i_id']."' class='btn btn-warning btn-sm text-white aprobar'><i class='fa fa-check'></i></a>";
				} else {
					$a = "";
				}

				$filas.="
				<tr>
					<td class='text-center'>".$tb['i_id']."</td>
					<td class='text-center'>".$tb['v_dni']."</td>
					<td class='text-center'>".$tb['v_nombre']."</td>
					<td class='text-center'>".$tb['i_semana']."</td>
					<td class='text-center'>".$tb['v_descripcion']."</td>
					<td class='text-center'><span class='badge bg-".$tb['v_color']."'>".$tb['v_estado']."</span></td>
					<td class='text-center'>".$tb['SEMANA1']."</td>
					<td class='text-center'>".$tb['SEMANA2']."</td>
					<td class='text-center'>".$tb['SEMANA3']."</td>
					<td class='text-center'>".$tb['SEMANA4']."</td>
					<td class='text-center'>".$tb['SEMANA5']."</td>
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

			$this->_view->anhios = $anhios;
			$this->_view->meses = $meses;
			$this->_view->filas = $filas;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
		}else{
			$this->redireccionar('index/logout');
		}
	}

	public function construir_tabla()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$anhio = $_POST['anhio'];
			$mes = $_POST['mes'];

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

			// consultar horarios
			$param3 = array(
				"dnijefe"	=> $_SESSION['dni'],
				"anhio"		=> $anhio,
				"mes"		=> $mes,
			);

			$result4 = $soap->ControlFlexTime($param3);
			$controltbflex = json_decode($result4->ControlFlexTimeResult, true);

			// construimos la tabla
			$filas="";
			foreach($controltbflex as $tb){
				$filas.="
				<tr>
					<td class='text-center'>".$tb['i_id']."</td>
					<td class='text-center'>".$tb['v_dni']."</td>
					<td class='text-center'>".$tb['v_nombre']."</td>
					<td class='text-center'>".$tb['i_semana']."</td>
					<td class='text-center'>".$tb['v_descripcion']."</td>
					<td class='text-center'><span class='badge bg-".$tb['v_color']."'>".$tb['v_estado']."</span></td>
					<td class='text-center'>".$tb['SEMANA1']."</td>
					<td class='text-center'>".$tb['SEMANA2']."</td>
					<td class='text-center'>".$tb['SEMANA3']."</td>
					<td class='text-center'>".$tb['SEMANA4']."</td>
					<td class='text-center'>".$tb['SEMANA5']."</td>
					<td class='text-center'>".$tb['d_faprobacion']."</td>
					<td class='text-center'>
						<a id='".$tb['i_id']."' class='btn btn-warning btn-sm text-white aprobar'><i class='fa fa-check'></i></a>
					</td>
				</tr>
				";
			};

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"div" => $filas,
					)
			);

		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function mantenimiento_horario()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$post = $_POST['post'];
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
				'post' 		=> $post,
				'id' 		=> $id,
				'user' 		=> $_SESSION['dni'],
			);
			$result = $soap->MantControlFlexTime($params);
			$tbcontrolflex = json_decode($result->MantControlFlexTimeResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"vicon" 		=> $tbcontrolflex[0]['v_icon'],
					"vtitle" 		=> $tbcontrolflex[0]['v_title'],
					"vtext" 		=> $tbcontrolflex[0]['v_text'],
					"itimer" 		=> $tbcontrolflex[0]['i_timer'],
					"icase" 		=> $tbcontrolflex[0]['i_case'],
					"vprogressbar" 	=> $tbcontrolflex[0]['v_progressbar'],
				)
			);

		} else {
			$this->redireccionar('index/logout');
		}
	}
}
?>