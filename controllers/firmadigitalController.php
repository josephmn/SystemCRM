<?php

class firmadigitalController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('home','firmadigital');

			$this->_view->setCss_Specific(
				array(
					'plugins/fontawesome-free/css/all.min',
					'plugins/overlayScrollbars/css/OverlayScrollbars.min',
					'dist/css/adminlte',
				)
			);
	
			$this->_view->setJs_Specific(
				array(
					'plugins/jquery/jquery-3.5.1',
					'plugins/bootstrap/js/bootstrap.bundle.min',
					'plugins/jquery-ui/jquery-ui.min',
					'plugins/overlayScrollbars/js/jquery.overlayScrollbars.min',
					'dist/js/adminlte',
					//bs-custom-file-input
					'plugins/bs-custom-file-input/bs-custom-file-input.min',
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

	public function subir_archivo()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");
	
			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			if (is_array($_FILES) && count($_FILES) > 0) {

				$fecha_hora = date("Ymd_His", time());

				$mime_permitidos = array('image/png');
				$mime = $_FILES['archivo']['type'];

				$destino = "public/doc/firmas/" . ltrim(rtrim($_SESSION['dni'])) . "_" . $fecha_hora . ".png";

				if (in_array($mime, $mime_permitidos)) {

					//1050576 --> 1 MB
					if ($_FILES['archivo']['size'] < 1050576) {
						
						if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino)) {

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

							$param = array(
								"dni"=>$_SESSION['dni'],
								"nombre"=>$_SESSION['nombre'],
								"ruta"=>$destino,
							);
				
							$soap = new SoapClient($wsdl, $options);
							$result = $soap->MantenimientoFirma($param);
							$fotoperfil = json_decode($result->MantenimientoFirmaResult, true);

							$_SESSION['firma'] = $destino;

							header('Content-type: application/json; charset=utf-8');
							echo $json->encode(
								array(
									"vicon" 		=> $fotoperfil[0]['v_icon'],
									"vtitle" 		=> $fotoperfil[0]['v_title'],
									"vtext" 		=> $fotoperfil[0]['v_text'],
									"itimer" 		=> $fotoperfil[0]['i_timer'],
									"icase" 		=> $fotoperfil[0]['i_case'],
									"vprogressbar" 	=> $fotoperfil[0]['v_progressbar'],
									"url"			=> BASE_URL.$destino,
									)
							);
						}

					}else{
						header('Content-type: application/json; charset=utf-8');
						echo $json->encode(
							array(
								"vicon" 		=> "info",
								"vtitle" 		=> "Archivo excede el tamaño máximo de subida...",
								"vtext" 		=> "Archivo debe pesar máximo 1 MB!",
								"itimer" 		=> 3000,
								"icase" 		=> 3, //"archivo muy pesado, solo 1 MB"
								"vprogressbar" 	=> true,
								"url"=>"",
								)
						);
					}

				}else{

					header('Content-type: application/json; charset=utf-8');
					echo $json->encode(
						array(
							"vicon" 		=> "error",
							"vtitle" 		=> "Formato de archivo incorrecto...",
							"vtext" 		=> "Subir archivo con extensión PNG!",
							"itimer" 		=> 3000,
							"icase" 		=> 4,// tipo archivo erroneo
							"vprogressbar" 	=> true,
							"url"=>"",
							)
					);
				}

			} else {
				header('Content-type: application/json; charset=utf-8');
				echo $json->encode(
					array(
						"vicon" 		=> "error",
						"vtitle" 		=> "Archivo no encontrado...",
						"vtext" 		=> "No se encontro archivo de origen!",
						"itimer" 		=> 3000,
						"icase" 		=> 5,// archivo no existe
						"vprogressbar" 	=> true,
						"url"=>"",
						)
				);
			}
			
		} else {
			$this->redireccionar('index/logout');
		}
	}

}
?>