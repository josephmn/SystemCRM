<?php
class timelinenotificacionController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('home','nosotros');

			$this->_view->setCss_Specific(
				array(
					'plugins/fontawesome-free/css/all.min',
					'plugins/overlayScrollbars/css/OverlayScrollbars.min',
					'dist/css/adminlte',
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

			$soap = new SoapClient($wsdl, $options);

			// ACTUALIZA A VISTO LAS NOTIFICACIONES QUE NO CONTENGAN UN LINK
			$param1 = array(
				"post"	=> 4,  	// consultar todos los
				"id"	=> 0,	// no se usa para esta consulta
				"dni"	=> $_SESSION['dni'],
			);

			$soap->MantNotificacionesPersonal($param1);

			// MOSTRAR TIMELINE
			$param2 = array(
				"post"	=> 4,  	// consultar todos los
				"top"	=> 0,	// no se usa para esta consulta
				"dni"	=> $_SESSION['dni'],
			);

			$result2 = $soap->ListarPaNotificaciones($param2);
			$notify = json_decode($result2->ListarPaNotificacionesResult, true);

			$timeline = "";
			foreach ($notify as $ntf) {

				$boton = $ntf['v_link'] == null || $ntf['v_link'] == '' ? '' : 
				"<div class='timeline-footer'>
					<a id=".$ntf['i_id']." href='".BASE_URL.'/'.$ntf['v_link']."/index"."' class='btn btn-success btn-sm revisar'>Ir a enlace</a>
				</div>";

				$texto_adicional = $ntf['v_description'] == null || $ntf['v_description'] == '' ? '' : 
				"<div class='dropdown-divider'></div>".$ntf['v_description'];

				$timeline.="
				<div>
					<i class='fas fa-comments ".$ntf['v_class']."'></i>
					<div class='timeline-item'>
						<span class='time'><i class='fas fa-clock'></i>&nbsp;&nbsp;".$ntf['v_subtitle']."</span>
						<h3 class='timeline-header'><b>".$ntf['v_title']."</b></h3>
						<div class='timeline-body'>
							".$ntf['v_body']."
							".$texto_adicional."
						</div>
						".$boton."
					</div>
				</div>
				";
			}

			// NOTIFICACIONES TOTAL
			$param100 = array(
				"post"	=> 2,  	// consultar por DNI para obtener cantidad de notificaciones
				"top"	=> 0,	// no se usa para esta consulta
				"dni"	=> $_SESSION['dni'],
			);

			$result100 = $soap->ListarPaNotificaciones($param100);
			$countnoti = json_decode($result100->ListarPaNotificacionesResult, true);

			$_SESSION['num_notificaciones'] = intval($countnoti[0]['i_delay']);

			$this->_view->timeline = $timeline;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
		}else{
			$this->redireccionar('index/logout');
		}
    }

	public function actualizar_notificacion()
	{
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
	
		// consultar notificacion por id
		$param1 = array(
			"post"	=> 2,  // actualizar
			"id"	=> $id,
			"dni"	=> $_SESSION['dni'], 
		);

		$soap->MantNotificacionesPersonal($param1);

	}
}

?>