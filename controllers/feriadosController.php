<?php

class feriadosController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('asistencia','feriados');

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
					//InputMask
					'plugins/moment/moment.min',
					'plugins/inputmask/min/jquery.inputmask.bundle.min',
					//bootstrap color picker y Tempusdominus Bootstrap 4
					'plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min',
					'plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min',
					//sweetalert2
					'plugins/sweetalert2/sweetalert2.all',
					//toastr
					'plugins/toastr/toastr.min',
					//inputmask
					'plugins/inputmask/jquery.inputmask.min'
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
				"post"=> 4, //mostrar años para feriados
			);

			$result1 = $soap->Listarmeses($param1);
			$anhios = json_decode($result1->ListarmesesResult, true);

			// consultar horarios
			$param2 = array(
				"post"		=> 1,  // listar datos en grilla
				"id"		=> 0,
				"anhio"		=> date("Y"),
			);

			$result2 = $soap->ListarFeriado($param2);
			$feriados = json_decode($result2->ListarFeriadoResult, true);

			// construimos la tabla
			$filas="";
			foreach($feriados as $tb){
				$filas.="
				<tr>
					<td class='text-center'>".$tb['i_id']."</td>
					<td class='text-left'>".$tb['v_descripcion']."</td>
					<td class='text-center'>".$tb['d_fecha']."</td>
					<td class='text-center'><span class='badge bg-info'> ".$tb['i_anhio']."</span></td>
					<td class='text-center'><span class='badge bg-primary'> ".$tb['v_mes']."</span></td>
					<td class='text-center'><span class='badge bg-".$tb['v_color_estado']."'>".$tb['v_estado']."</span></td>
					<td class='text-center'>".$tb['d_fregistro']."</td>
					<td class='text-center'>".$tb['d_factualiza']."</td>
					<td class='text-center'>
						<a id='".$tb['i_id']."' class='btn btn-warning btn-sm text-white editar'><i class='fa fa-edit'></i></a>
					</td>
					<td class='text-center'>
						<a id='".$tb['i_id']."' class='btn btn-danger btn-sm text-white eliminar'><i class='fa fa-trash-alt'></i></a>
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
			$this->_view->filas = $filas;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
		}else{
			$this->redireccionar('index/logout');
		}
    }

	public function get_feriado()
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

			$param2 = array(
				"post"		=> 2,  // listar datos en grilla
				"id"		=> $id,
				"anhio"		=> date("Y"),
			);

			$result2 = $soap->ListarFeriado($param2);
			$feriados = json_decode($result2->ListarFeriadoResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"id" 			=> $feriados[0]['i_id'],
					"descripcion" 	=> $feriados[0]['v_descripcion'],
					"fferiado" 		=> $feriados[0]['d_fecha'],
					"estado" 		=> $feriados[0]['i_estado'],
				)
			);

		} else {
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

			$param2 = array(
				"post"		=> 1,  // listar datos en grilla
				"id"		=> 0,
				"anhio"		=> $anhio,
			);

			$result2 = $soap->ListarFeriado($param2);
			$feriados = json_decode($result2->ListarFeriadoResult, true);

			// construimos la tabla
			$filas="";
			foreach($feriados as $tb){
				$filas.="
				<tr>
					<td class='text-center'>".$tb['i_id']."</td>
					<td class='text-left'>".$tb['v_descripcion']."</td>
					<td class='text-center'>".$tb['d_fecha']."</td>
					<td class='text-center'><span class='badge bg-info'> ".$tb['i_anhio']."</span></td>
					<td class='text-center'><span class='badge bg-primary'> ".$tb['v_mes']."</span></td>
					<td class='text-center'><span class='badge bg-".$tb['v_color_estado']."'>".$tb['v_estado']."</span></td>
					<td class='text-center'>".$tb['d_fregistro']."</td>
					<td class='text-center'>".$tb['d_factualiza']."</td>
					<td class='text-center'>
						<a id='".$tb['i_id']."' class='btn btn-warning btn-sm text-white editar'><i class='fa fa-edit'></i></a>
					</td>
					<td class='text-center'>
						<a id='".$tb['i_id']."' class='btn btn-danger btn-sm text-white eliminar'><i class='fa fa-trash-alt'></i></a>
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

	public function mantenimiento_feriado()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$post = $_POST['post'];
			$id = $_POST['id'];
			$descripcion = $_POST['descripcion'];
			$fferiado = $_POST['fferiado'];
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
				'post' 			=> $post,
				'id' 			=> $id,
				'descripcion' 	=> $descripcion,
				'fferiado' 		=> $fferiado,
				'estado' 		=> $estado,
				'user' 			=> $_SESSION['dni'],
			);

			$soap = new SoapClient($wsdl, $options);
			$result = $soap->MantFeriado($params);
			$flextimenew = json_decode($result->MantFeriadoResult, true);

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