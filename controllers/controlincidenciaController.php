<?php

class controlincidenciaController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		if (isset($_SESSION['usuario'])) {

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
		} else {
			$this->redireccionar('index/logout');
		}
	}

	// CARGAR TABLA PARA JEFATURA Y REVISAR LAS INCIDENCIAS DE SU PERSONAL A CARGO
	public function cargar_table()
	{

		if (isset($_SESSION['usuario'])) {
			$dni = $_POST['dni'];
			// $dni ='40572017';
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
			$result1 = $soap->Listadocontrolincidenciajefe($params);
			$incidencias = json_decode($result1->ListadocontrolincidenciajefeResult, true);

			$this->_view->incidencias = $incidencias;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	// PARA ACTUALIZAR INCIDENCIA (APROBAR O DESAPROBAR INCIDENCIA)
	public function gestion_incidencia()
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
				"codigo" => $codigo,
				"dni" => $dni,
				"indice" => $indice,
			);

			$soap = new SoapClient($wsdl, $options);
			$result = $soap->GestionIncidencia($param);
			$data = json_decode($result->GestionIncidenciaResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"data" => $data['respuesta'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}
}

?>