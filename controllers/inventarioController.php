<?php

class inventarioController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('planillas','inventario');

			$this->_view->setCss_Specific(
				array(
					'plugins/fontawesome-free/css/all.min',
					'plugins/overlayScrollbars/css/OverlayScrollbars.min',
					'dist/css/adminlte',
					//DataTables>
					'plugins/datatables-responsive/css/responsive.bootstrap4.min',
					'plugins/datatables-net/css/jquery.dataTables.min',
					'plugins/datatables-net/css/responsive.dataTables.min',
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
		
			// consultar inventario
			$param1 = array(
				"post"		=> 1,  // listar datos en grilla
				"sku"		=> "",
			);

			$result1 = $soap->ListarInventario($param1);
			$inventario = json_decode($result1->ListarInventarioResult, true);

			// construimos la tabla
			$filas="";
			foreach($inventario as $tb){
				$filas.="
				<tr>
					<td class='text-center'>".$tb['i_id']."</td>
					<td class='text-center'>".$tb['v_sku']."</td>
					<td class='text-left'>".$tb['v_descripcion']."</td>
					<td class='text-center'>".$tb['v_marca']."</td>
					<td class='text-right'>".$tb['f_precio']."</td>
					<td class='text-center'><span class='badge bg-".$tb['v_color_estado']."'>".$tb['v_estado']."</span></td>
					<td class='text-center'>".$tb['d_fregistro']."</td>
					<td class='text-center'>".$tb['d_factualiza']."</td>
					<td class='text-center'>
						<a id='".$tb['v_sku']."' class='btn btn-warning btn-sm text-black editar'><i class='fa fa-edit'></i></a>
					</td>
					<td class='text-center'>
						<a id='".$tb['v_sku']."' class='btn btn-danger btn-sm text-white eliminar'><i class='fa fa-trash-alt'></i></a>
					</td>
				</tr>
				";
			};

			$result2 = $soap->GetInventario();
			$sku = json_decode($result2->GetInventarioResult, true);

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
			$this->_view->sku = $sku;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
		}else{
			$this->redireccionar('index/logout');
		}
    }

	public function get_inventario()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$sku = $_POST['sku'];

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
		
			// consultar inventario
			$param1 = array(
				"post"		=> 2,  // listar datos en grilla
				"sku"		=> $sku,
			);

			$result1 = $soap->ListarInventario($param1);
			$inventario = json_decode($result1->ListarInventarioResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"sku" 			=> $inventario[0]['v_sku'],
					"descripcion" 	=> $inventario[0]['v_descripcion'],
					"estado" 		=> $inventario[0]['i_estado'],
				)
			);

		}else{
			$this->redireccionar('index/logout');
		}
    }

	// MANTENIMIENTO INVENTARIO
	public function mantenimiento_inventario()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$post = $_POST['post'];
			$sku = $_POST['sku']; // array sku
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

			$soap = new SoapClient($wsdl, $options);

			//array sku
			$i = 0;
			foreach ($sku as $di) {
				$params[$i] = array(
					'post' 		=> $post,
					'sku' 		=> $di,
					'estado' 	=> $estado,
					'user' 		=> $_SESSION['dni'],
				);
				$result = $soap->MantInventario($params[$i]);
				$tbsku = json_decode($result->MantInventarioResult, true);
				$i++;
			}

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"vicon" 		=> $tbsku[0]['v_icon'],
					"vtitle" 		=> $tbsku[0]['v_title'],
					"vtext" 		=> $tbsku[0]['v_text'],
					"itimer" 		=> $tbsku[0]['i_timer'],
					"icase" 		=> $tbsku[0]['i_case'],
					"vprogressbar" 	=> $tbsku[0]['v_progressbar'],
				)
			);

		}else{
			$this->redireccionar('index/logout');
		}

    }

	// MANTENIMIENTO INVENTARIO (UPDATE Y DELETE)
	public function mantenimiento_inventario2()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$post = $_POST['post'];
			$sku = $_POST['sku']; // array sku
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

			$soap = new SoapClient($wsdl, $options);

			$params = array(
				'post' 		=> $post,
				'sku' 		=> $sku,
				'estado' 	=> $estado,
				'user' 		=> $_SESSION['dni'],
			);
			$result = $soap->MantInventario($params);
			$tbsku = json_decode($result->MantInventarioResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"vicon" 		=> $tbsku[0]['v_icon'],
					"vtitle" 		=> $tbsku[0]['v_title'],
					"vtext" 		=> $tbsku[0]['v_text'],
					"itimer" 		=> $tbsku[0]['i_timer'],
					"icase" 		=> $tbsku[0]['i_case'],
					"vprogressbar" 	=> $tbsku[0]['v_progressbar'],
				)
			);

		}else{
			$this->redireccionar('index/logout');
		}

    }

}

?>