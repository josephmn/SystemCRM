<?php

Class asistenciapersonalController extends Controller{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){

		if(isset($_SESSION['usuario'])){

			$this->_view->conctructor_menu('asistencia','asistenciapersonal');

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
				"uri"=> $wsdl,
				"style"=> SOAP_RPC,
				"use"=> SOAP_ENCODED,
				"soap_version"=> SOAP_1_1,
				//"cache_wsdl"=> WSDL_CACHE_BOTH,
				"connection_timeout"=> 60,
				"trace"=> false,
				"encoding"=> "UTF-8",
				"exceptions"=> false,
				);

			$soap = new SoapClient($wsdl,$options);

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

	Public function cargar_table(){

		if(isset($_SESSION['usuario'])){

			$this->_view->setCss_Specific(
				array(
					'plugins/fontawesome-free/css/all.min',
					'plugins/overlayScrollbars/css/OverlayScrollbars.min',
					'dist/css/adminlte',
					//DataTables>
					'plugins/datatables-responsive/css/responsive.bootstrap4.min',
					'plugins/datatables-net/css/jquery.dataTables.min',
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

			$finicio = $_POST['finiciodate'];
			$ffin = $_POST['ffindate'];
	
			// $finicio = '17/02/2021';
			// $ffin = '17/02/2021';
	
			$wsdl = 'http://localhost:81/PAWEB/WSRecursos.asmx?WSDL';
	
			$options = array(
				"uri"=> $wsdl,
				"style"=> SOAP_RPC,
				"use"=> SOAP_ENCODED,
				"soap_version"=> SOAP_1_1,
				//"cache_wsdl"=> WSDL_CACHE_BOTH,
				"connection_timeout"=> 60,
				"trace"=> false,
				"encoding"=> "UTF-8",
				"exceptions"=> false,
				);

			$soap = new SoapClient($wsdl,$options);
			
			$params = array(
				'finicio'=>$finicio,
				'ffin'=>$ffin,
			);
				
			$result = $soap->Listadoasistencia($params);
			$filas = json_decode($result->ListadoasistenciaResult,true);

			// NOTIFICACIONES TOTAL
			$param100 = array(
				"post"	=> 2,  	// consultar por DNI para obtener cantidad de notificaciones
				"top"	=> 0,	// no se usa para esta consulta
				"dni"	=> $_SESSION['dni'],
			);

			$result100 = $soap->ListarPaNotificaciones($param100);
			$countnoti = json_decode($result100->ListarPaNotificacionesResult, true);

			$_SESSION['num_notificaciones'] = intval($countnoti[0]['i_delay']);
	
			$this->_view->filas = $filas;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
		}else{
			$this->redireccionar('index/logout');
		}

	}

}

?>