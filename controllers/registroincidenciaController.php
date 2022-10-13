<?php

class registroincidenciaController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{

		if (isset($_SESSION['usuario'])) {
			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	// CARGAR TABLA DE ASISTENCIA X DNI (ESTO VIENE DESDE EL LOGUEO)
	public function cargar_table()
	{

		if (isset($_SESSION['usuario'])) {

			$dni = $_POST['dni'];
			$finicio = $_POST['finiciodate'];
			$ffin = $_POST['ffindate'];

			// $dni = '72130767';
			// $finicio = '22/02/2021';
			// $ffin = '25/02/2021';

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

			//Envio del request
			$soap = new SoapClient($wsdl, $options);

			$result1 = $soap->Listadoasistenciadni($params);
			$filas = json_decode($result1->ListadoasistenciadniResult, true);

			$result2 = $soap->Listadoincidenciaxdni($params);
			$incidencias = json_decode($result2->ListadoincidenciaxdniResult, true);

			$this->_view->filas = $filas;
			$this->_view->incidencias = $incidencias;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	//CARGAR COMBO EN EL MODAL
	public function cargarcombosustento()
	{

		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.UTF-8");
			putenv("NLS_LANG=CHARACTERSET.UTF-8");

			$this->getLibrary("json_php/JSON");
			$json = new Services_JSON();

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

			//Envio del request
			$soap = new SoapClient($wsdl, $options);
			//Llamada a la funcion del servicio --no requiere parametro--
			$result = $soap->Listadotiposustento();
			//convertir en json en array
			$cbosustento = json_decode($result->ListadotiposustentoResult, true);

			$filas = "";
			foreach ($cbosustento as $de) {
				$filas .= "<option value='" . $de['i_id'] . "'>" . $de['v_nombre'] . "</option>";
			}

			header('Content-type:application/json; charset=utf-8');
			echo $json->encode(
				array(
					"filas" => $filas,
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	//CARDAR INPUT CON DIFERENCIA DE HORA
	public function diferenciahora()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.UTF-8");
			putenv("NLS_LANG=CHARACTERSET.UTF-8");

			$this->getLibrary("json_php/JSON");
			$json = new Services_JSON();

			$id = $_POST['id'];
			//$id = 'OFI00000012748';

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
				'codigo' => $id,
			);

			//Envio del request
			$soap = new SoapClient($wsdl, $options);
			//Llamada a la funcion del servicio --no requiere parametro--
			$result = $soap->Listadomodalxcodigo($params);
			//convertir en json en array
			$dato = json_decode($result->ListadomodalxcodigoResult, true);

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"dato" => $dato[0]['DIFERENCIA'],
					"fecha" => $dato[0]['FECHA'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	// PARA REGISTRAR INCIDENCIA
	public function registrar_incidencia()
	{

		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$codigo = $_POST['codigo'];
			$dni = $_POST['dni'];
			$tipo_sustento = $_POST['tipo_sustento'];
			$fecha_incidencia = $_POST['fecha_incidencia'];
			$comentario = $_POST['comentario'];
			$diferencia_hora = $_POST['diferencia_hora'];
			$usuario = $_POST['usuario'];


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
				"tipo_sustento" => $tipo_sustento,
				"fecha" => $fecha_incidencia,
				"comentario" => $comentario,
				"diferencia_hora" => $diferencia_hora,
				"usuario" => $usuario,
			);

			//Envio del request
			$soap = new SoapClient($wsdl, $options);
			//Llamada a la funcion del servicio --no requiere parametro--
			$result = $soap->Registrarincidencia($param);
			//convertir en json en array
			$data = json_decode($result->RegistrarincidenciaResult, true);

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

	// PARA REGISTRAR INCIDENCIA
	public function eliminar_incidencia()
	{

		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");
			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$codigo = $_POST['codigo'];

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
			);
			//Envio del request
			$soap = new SoapClient($wsdl, $options);
			//Llamada a la funcion del servicio --no requiere parametro--
			$result = $soap->Eliminarincidencia($param);
			//convertir en json en array
			$data = json_decode($result->EliminarincidenciaResult, true);
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