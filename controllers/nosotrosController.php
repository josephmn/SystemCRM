<?php

class nosotrosController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}


	public function index()
	{

		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('home', 'nosotros');

			$this->_view->setCss_Specific(
				array(
					'plugins/fontawesome-free/css/all.min',
					'plugins/overlayScrollbars/css/OverlayScrollbars.min',
					'dist/css/adminlte',
					'dist/css/efecto',
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

	public function mensaje()
	{
		if (isset($_SESSION['usuario'])) {

			date_default_timezone_set("America/Lima");

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");
			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$cumple = $_SESSION['cumpleanios'];
			//$cumple = "2022-07-13";
			$dia =  strval(date("Y-m-d"));

			if ($_SESSION['icumple'] !== 0) {
				if ($dia == $cumple) {

					header('Content-type: application/json; charset=utf-8');
					echo $json->encode(
						array(
							"vicon" 		=> "success",
							"vtitle" 		=> "Mensaje para cumpleaños",
							"icase"			=> 3,
							"vnombre"		=> $_SESSION['nombre'],
							"vmensaje"		=> "",
						)
					);
				}
			} else {
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

				$param = array(
					"dni" => $_SESSION['dni'],
				);

				$soap = new SoapClient($wsdl, $options);
				$result = $soap->ActualizacionDatos($param);
				$insertperfil = json_decode($result->ActualizacionDatosResult, true);

				header('Content-type: application/json; charset=utf-8');
				echo $json->encode(
					array(
						"vicon" 		=> $insertperfil[0]['v_icon'],
						"vtitle" 		=> $insertperfil[0]['v_title'],
						"icase"			=> $insertperfil[0]['i_case'],
						"vnombre"		=> $_SESSION['nombre'],
						"vmensaje"		=> "",
					)
				);
			}
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function cambiarclave()
	{
		if (isset($_SESSION['usuario'])) {
			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");
			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"vicon" 		=> "warning",
					"vtitle" 		=> "Cambiar la clave por seguridad",
					"icase"			=> $_SESSION['igualclave'],
					"vnombre"		=> $_SESSION['nombre'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function numero_push()
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

			// consultamos la cantidad de anuncios actuales
			$param1 = array(
				"post"	=> 2,  	// consultar por anuncios actuales
				"top"	=> 0,	// no se usa para esta consulta
				"dni"	=> $_SESSION['dni'],
			);

			$result1 = $soap->ListarPaNotificaciones($param1);
			$countnoti = json_decode($result1->ListarPaNotificacionesResult, true);

			$validador = intval($countnoti[0]['i_delay']);

			echo $validador;
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function notificacion_push()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$tope = $_POST['tope'];

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

			// consultamos la cantidad de anuncios actuales
			$param1 = array(
				"post"	=> 2,  	// consultar por DNI para obtener cantidad de notificaciones
				"top"	=> 0,	// no se usa para esta consulta
				"dni"	=> $_SESSION['dni'],
			);

			$result1 = $soap->ListarPaNotificaciones($param1);
			$countnoti = json_decode($result1->ListarPaNotificacionesResult, true);

			$validador = intval($countnoti[0]['i_delay']);

			// consultar notificaciones
			$param3 = array(
				"post"	=> 3,  // consultar por sku para obtener precio
				"top"	=> $tope,
				"dni"	=> $_SESSION['dni'],
			);

			$result3 = $soap->ListarPaNotificaciones($param3);
			$notificacion = json_decode($result3->ListarPaNotificacionesResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"class"			=> $notificacion[0]['v_class'],
					"title" 		=> $notificacion[0]['v_title'],
					"subtitle" 		=> $notificacion[0]['v_subtitle'],
					"body" 			=> $notificacion[0]['v_body'],
					"autohide" 		=> $notificacion[0]['i_autohide'],
					"delay" 		=> $notificacion[0]['i_delay'],
					"total_push" 	=> $validador,
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function ultimo_push()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

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

			$param3 = array(
				"post"	=> 4,  // consultar ultima notificacion
				"top"	=> 0,
				"dni"	=> $_SESSION['dni'],
			);

			$result3 = $soap->ListarNotificaciones($param3);
			$notificacion = json_decode($result3->ListarNotificacionesResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"class"			=> $notificacion[0]['v_class'],
					"title" 		=> $notificacion[0]['v_title'],
					"subtitle" 		=> $notificacion[0]['v_subtitle'],
					"body" 			=> $notificacion[0]['v_body'],
					"autohide" 		=> $notificacion[0]['i_autohide'],
					"delay" 		=> $notificacion[0]['i_delay'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function obtenerimg_cumple()
	{
		if (isset($_SESSION['usuario'])) {

			date_default_timezone_set("America/Lima");

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

			$params = array(
				'id' => $id,
			);

			// consulta para recontruir tabla
			$soap = new SoapClient($wsdl, $options);
			$result = $soap->ListarNotificumpleTexto($params);
			$listanotificumpledisenio = json_decode($result->ListarNotificumpleTextoResult, true);

			$parm1 = array(
				'post' 	=> 2, //0 -- consuta publicados, 1 --consultar todos, otro numero --consulta x id
				'id'	=> $id, // id para armar el div de imagen
			);

			$result1 = $soap->ListarNotificumpleanios($parm1);
			$imgcumple = json_decode($result1->ListarNotificumpleaniosResult, true);

			$div_new = "";

			if (count($listanotificumpledisenio) > 0) {
				// si hay datos contruimos ya la imagen

				$nombre =  strval(date("YmdHis"));

				function datos_globales($string)
				{
					$string = str_replace(
						array(
							'[usuario]', '[dni]', '[nombre]', '[perfil]', '[razon]', '[ruc]', '[nombrecomercial]',
							'[fecha]', '[fechahora]', '[cargo]', '[nombres]', '[apellidos]'
						),
						array(
							$_SESSION['usuario'], $_SESSION['dni'], $_SESSION['nombre'], $_SESSION['perfil'], 'VERDUM PERÚ S.A.C.',
							ruc, nombrecomercial, fechasis, fechahorasis, $_SESSION['cargo'], $_SESSION['nombres'], $_SESSION['apellidos']
						),
						$string
					);
					return $string;
				}

				$img2 = imagecreatefromjpeg($imgcumple[0]['v_ventana']);

				// foreach
				foreach ($listanotificumpledisenio as $dsn) {

					$color = $dsn['v_color'];
					$colornew = str_replace("#", "", $color);

					$split = str_split($colornew, 2);
					$r = hexdec($split[0]);
					$g = hexdec($split[1]);
					$b = hexdec($split[2]);

					$textnew = datos_globales($dsn['v_texto']);
					$black = imagecolorallocate($img2, $r, $g, $b);

					$fuente =  __DIR__ . "/fonts/" . $dsn['v_fuente'] . ".ttf";

					if ($dsn['i_alineacion'] == "Centrado") {

						// longitud del texto
						$xtext = imageftbbox($dsn['i_tamanio'], $dsn['i_angulo'], $fuente, $textnew);

						// posiscion del texto centrado
						$x = $xtext[0] + (imagesx($img2) / 2) - ($xtext[4] / 2) - (($dsn['i_tamanio']) / 2);
						// $y = $xtext[1] + (imagesy($img2) / 2) - ($xtext[5] / 2) - (($dsn['i_tamanio'])/2);

						imagettftext($img2, $dsn['i_tamanio'], $dsn['i_angulo'], $x, $dsn['i_posiciony'], $black, $fuente, $textnew);
					} else {
						imagettftext($img2, $dsn['i_tamanio'], $dsn['i_angulo'], $dsn['i_posicionx'], $dsn['i_posiciony'], $black, $fuente, $textnew);
					}
				}

				$salida = "public/dist/img/cumpleanios/" . $nombre . ".jpg";

				imagejpeg($img2, $salida);
				imagedestroy($img2);

				$div_new = "
				<img class='card-img-top' style='-webkit-border-radius: 10px;' src='" . BASE_URL . $salida . "'>
				";
			} else {
				// obtener imagen principal
				$div_new = "
				<img class='card-img-top' style='border:1px solid black; -webkit-border-radius: 10px;' src='" . BASE_URL . $imgcumple[0]['v_ventana'] . "'>
				";
			}

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"div" 		=> $div_new,
					"imagen"	=> $nombre,
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function deshacer_imagen()
	{
		if (isset($_SESSION['usuario'])) {

			$nombre = $_POST['nombre'];
			unlink("public/dist/img/cumpleanios/" . $nombre . ".jpg");
		} else {
			$this->redireccionar('index/logout');
		}
	}
}
