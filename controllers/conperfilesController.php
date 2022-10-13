<?php

class conperfilesController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('configuracion','conperfiles');

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
				"post" => 1, //lista los perfiles
				"perfil" => 0, //no se usa
			);

			$result = $soap->ConPerfiles($param);
			$perfiles = json_decode($result->ConPerfilesResult, true);

			// NOTIFICACIONES TOTAL
			$param100 = array(
				"post"	=> 2,  	// consultar por DNI para obtener cantidad de notificaciones
				"top"	=> 0,	// no se usa para esta consulta
				"dni"	=> $_SESSION['dni'],
			);

			$result100 = $soap->ListarPaNotificaciones($param100);
			$countnoti = json_decode($result100->ListarPaNotificacionesResult, true);

			$_SESSION['num_notificaciones'] = intval($countnoti[0]['i_delay']);

			$this->_view->perfiles = $perfiles;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function configuracionperfil()
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
					'plugins/datatables-net/js/dataTables.responsive.min',
					//sweetalert2
					'plugins/sweetalert2/sweetalert2.all',
				)
			);

			$perfil = $_GET["perfil"];
			$nombreperfil = $_GET["nombreperfil"];

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
				"post" => 0,
				"perfil" => $perfil,
				"menu" => 0, //no se usa para este caso
			);

			$result = $soap->ConPerfilesAccesos($param1);
			$menu = json_decode($result->ConPerfilesAccesosResult, true);

			$param2 = array(
				"post" => 1,
				"perfil" => $perfil,
				"menu" => 0, //no se usa para este caso
			);

			$result = $soap->ConPerfilesAccesos($param2);
			$submenu = json_decode($result->ConPerfilesAccesosResult, true);

			$this->_view->perfil = $perfil;
			$this->_view->nombreperfil = $nombreperfil;
			$this->_view->menu = $menu;
			$this->_view->submenu = $submenu;

			$this->_view->setJs(array('configuracionperfil'));
			$this->_view->renderizar('configuracionperfil');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function combomenu()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");
			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$perfil = $_POST["perfil"];

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
				"post" => 2,
				"perfil" => $perfil,
				"menu" => 0, //no se usa para este caso
			);

			$result = $soap->ConPerfilesAccesos($param);
			$combomenu = json_decode($result->ConPerfilesAccesosResult, true);

			$filas="";
			foreach($combomenu as $dv){
				$filas.="<option ".$dv['v_default']." value=".$dv['i_submenu'].">".$dv['v_menu']."</option>";
			};
			
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

	public function combosubmenu()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");
			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$perfil = $_POST["codperfil"];
			$menu = $_POST["menu"];

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
				"post" => 3,
				"perfil" => $perfil,
				"menu" => $menu, //se trae el id del menu para cargar los submenu asociados
			);

			$result = $soap->ConPerfilesAccesos($param);
			$combomenu = json_decode($result->ConPerfilesAccesosResult, true);

			$filas="";
			foreach($combomenu as $dv){
				$filas.="<option ".$dv['v_default']." value=".$dv['i_submenu'].">".$dv['v_submenu']."</option>";
			};
			
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

	public function mantenimiento_accesos()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");
			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$post = $_POST["post"];
			$menu = $_POST["menu"];
			$submenu = $_POST["submenu"];
			$perfil = $_POST["perfil"];
			$tipo = $_POST["tipo"];

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
				"post" 		=> $post,
				"menu" 		=> $menu,
				"submenu" 	=> $submenu,
				"perfil" 	=> $perfil,
				"tipo" 		=> $tipo,
				"user"		=> $_SESSION['dni']
			);

			$result = $soap->MantPerfilesAccesos($param);
			$mantperfiles = json_decode($result->MantPerfilesAccesosResult, true);

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"vicon" 		=> $mantperfiles[0]['v_icon'],
					"vtitle" 		=> $mantperfiles[0]['v_title'],
					"vtext" 		=> $mantperfiles[0]['v_text'],
					"itimer" 		=> $mantperfiles[0]['i_timer'],
					"icase" 		=> $mantperfiles[0]['i_case'],
					"vprogressbar" 	=> $mantperfiles[0]['v_progressbar'],
				)
			);

		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function mantenimiento_perfil()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");
			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$post = $_POST["post"];
			$nombre = $_POST["nombre"];
			$estado = $_POST["estado"];
			$perfil = $_POST["perfil"];

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
				"post" 		=> $post,
				"nombre" 	=> $nombre,
				"estado" 	=> $estado,
				"perfil" 	=> $perfil,
				"user" 		=> $_SESSION['dni'],
			);

			$result = $soap->MantPerfiles($param);
			$mantperfiles = json_decode($result->MantPerfilesResult, true);

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"vicon" 		=> $mantperfiles[0]['v_icon'],
					"vtitle" 		=> $mantperfiles[0]['v_title'],
					"vtext" 		=> $mantperfiles[0]['v_text'],
					"itimer" 		=> $mantperfiles[0]['i_timer'],
					"icase" 		=> $mantperfiles[0]['i_case'],
					"vprogressbar" 	=> $mantperfiles[0]['v_progressbar'],
				)
			);

		} else {
			$this->redireccionar('index/logout');
		}
	}

}
?>