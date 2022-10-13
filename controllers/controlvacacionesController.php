<?php

class controlvacacionesController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('controlper','controlvacaciones');

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
					'plugins/datatables-net/js/dataTables.searchPanes.min',
					'plugins/datatables-net/js/dataTables.select.min',
					'plugins/datatables-net/js/dataTables.buttons.min',
					'plugins/datatables-net/js/buttons.flash.min',
					'plugins/datatables-net/js/jszip.min',
					'plugins/datatables-net/js/pdfmake.min',
					'plugins/datatables-net/js/vfs_fonts',
					'plugins/datatables-net/js/buttons.html5.min',
					'plugins/datatables-net/js/buttons.print.min',
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

	// CARGAR TABLA PARA JEFATURA Y REVISAR LAS VACACIONES DE SU PERSONAL A CARGO
	public function cargar_table()
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
					'plugins/datatables-net/css/searchPanes.dataTables.min',
					'plugins/datatables-net/select.dataTables.min',
					'plugins/datatables-net/css/buttons.dataTables.min',
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
					'plugins/datatables-net/js/dataTables.searchPanes.min',
					'plugins/datatables-net/js/dataTables.select.min',
					'plugins/datatables-net/js/dataTables.buttons.min',
					'plugins/datatables-net/js/buttons.flash.min',
					'plugins/datatables-net/js/jszip.min',
					'plugins/datatables-net/js/pdfmake.min',
					'plugins/datatables-net/js/vfs_fonts',
					'plugins/datatables-net/js/buttons.html5.min',
					'plugins/datatables-net/js/buttons.print.min',
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

			$dni = $_POST['dni'];
			// $dni ='40684961';
			$finicio = $_POST['finiciodate'];
			$ffin = $_POST['ffindate'];

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
				'dni' => $dni,
				'finicio' => $finicio,
				'ffin' => $ffin,
			);

			$soap = new SoapClient($wsdl, $options);

			$result = $soap->Listadocontrolvacacionesjefe($params);
			$vacaciones = json_decode($result->ListadocontrolvacacionesjefeResult, true);

			// construimos la tabla vacaciones programadas / excepcional
			$filasvac="";
			foreach($vacaciones as $tb){

				// eliminar
				if ($tb['i_estado'] == 1){
					$a = "<a id='".$tb['i_id']."' vnombre='".$tb['v_nombre']."' class='btn btn-warning btn-sm text-black aprobar'><i class='fa fa-check'></i><b>&nbsp;&nbsp;Aprobar</b></a>";
				} else {
					$a = "";
				}

				$filasvac.="
				<tr>
					<td class='text-center'>".$tb['i_id']."</td>
					<td class='text-center'>".$tb['v_dni']."</td>
					<td class='text-left'>".$tb['v_nombre']."</td>
					<td class='text-center'><span class='badge bg-".$tb['v_color_tipo']."'>".$tb['v_tipo']."</td>
					<td class='text-center'>".$tb['d_finicio']."</td>
					<td class='text-center'>".$tb['d_ffin']."</td>
					<td class='text-center'>".$tb['d_registro']."</td>
					<td class='text-center'>
						<a style='display: ".$tb['v_style_fechaproceso']."' class='text-center'>".$tb['d_aprobacion']."</a>
					</td>
					<td class='text-center'><span class='badge bg-".$tb['v_estado_color']."'>".$tb['v_estado']."</span></td>

					<td class='text-center'>
						".$a."
					</td>
				</tr>
				";
			};

			$result = $soap->Listadovacacionescumplejefe($params);
			$cumpleaniosvac = json_decode($result->ListadovacacionescumplejefeResult, true);

			// construimos la tabla vacaciones por cumpleaños
			$filascum="";
			foreach($cumpleaniosvac as $ct){

				// eliminar
				if ($ct['i_estado'] == 1){
					$b = "<a id='".$ct['i_id']."' vnombre='".$ct['v_nombre']."' class='btn btn-warning btn-sm text-black cumple'><i class='fa fa-check'></i><b>&nbsp;&nbsp;Aprobar</b></a>";
				} else {
					$b = "";
				}

				$filascum.="
				<tr>
					<td class='text-center'>".$ct['i_id']."</td>
					<td class='text-center'>".$ct['v_dni']."</td>
					<td class='text-left'>".$ct['v_nombre']."</td>
					<td class='text-center'><span class='badge bg-".$ct['v_color_tipo']."'>".$ct['v_tipo']."</td>
					<td class='text-center'>".$ct['d_finicio']."</td>
					<td class='text-center'>".$ct['d_ffin']."</td>
					<td class='text-center'>".$ct['d_registro']."</td>
					<td class='text-center'>
						<a style='display: ".$ct['v_style_fechaproceso']."' class='text-center'>".$ct['d_aprobacion']."</a>
					</td>
					<td class='text-center'><span class='badge bg-".$ct['v_estado_color']."'>".$ct['v_estado']."</span></td>

					<td class='text-center'>
						".$b."
					</td>
				</tr>
				";
			};


			$this->_view->filasvac = $filasvac;
			$this->_view->filascum = $filascum;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	// PARA ACTUALIZAR LAS VACACIONES (APROBAR O DESAPROBAR VACACIONES)
	public function gestion_vacaciones()
	{

		if (isset($_SESSION['usuario'])) {
			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$codigo = $_POST['codigo'];
			$dni = $_POST['dni'];
			// $dni = '40572017';
			$indice = $_POST['indice'];

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
				"codigo" 	=> $codigo,
				"dni" 		=> $dni,
				"indice" 	=> $indice,
			);

			$soap = new SoapClient($wsdl, $options);
			$result = $soap->GestionVacaciones($param);
			$data = json_decode($result->GestionVacacionesResult, true);

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

}
?>