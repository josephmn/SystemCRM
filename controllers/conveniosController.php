<?php

class conveniosController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('planillas','convenios');

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

			$parm1 = array(
				'post' 	=> 1, //0 -- consulta publicados, 1 --consultar todos, otro numero --consulta x id
				'id'	=> 0, // no se usa aqui
			);
			// convenios
			$result1 = $soap->ListarConvenios($parm1);
			$convenios = json_decode($result1->ListarConveniosResult, true);

			$parm2 = array(
				'post' 	=> 1, //0 -- consuta publicados, 1 --consultar todos, otro numero --consulta x id
				'id'	=> 0, // no se usa aqui
			);
			// convenios educativos
			$result2 = $soap->ListarConveniosEducativos($parm2);
			$conveniosedu = json_decode($result2->ListarConveniosEducativosResult, true);

			// NOTIFICACIONES TOTAL
			$param100 = array(
				"post"	=> 2,  	// consultar por DNI para obtener cantidad de notificaciones
				"top"	=> 0,	// no se usa para esta consulta
				"dni"	=> $_SESSION['dni'],
			);

			$result100 = $soap->ListarPaNotificaciones($param100);
			$countnoti = json_decode($result100->ListarPaNotificacionesResult, true);

			$_SESSION['num_notificaciones'] = intval($countnoti[0]['i_delay']);

			$this->_view->convenios = $convenios;
			$this->_view->conveniosedu = $conveniosedu;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function mantenimiento_convenio_img()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$timezone = -5;
			$dia =  strval(gmdate("YmdHis", time() + 3600 * ($timezone + date("I"))));

			$post = $_POST['post'];
			$id = $_POST['id'];
			$condicion = $_POST['condicion'];
			$nombre = $_POST['nombre'];
			$estado = $_POST['estado'];
			$finicio = $_POST['finicio'];
			$ffin = $_POST['ffin'];
			$tarjeta = $_POST['tarjeta']; //explode("/", $_FILES["archivo"]["type"]);
			$ventana = $_POST['ventana']; //explode("/", $_FILES["archivo"]["type"]);

			$ext_tarjeta = explode("/", $_FILES["tarjeta"]["type"]);
			$ext_ventana = explode("/", $_FILES["ventana"]["type"]);

			$tipos_archivos = array('jpg','png','jpeg');

			if (in_array($ext_tarjeta[1],$tipos_archivos) && in_array($ext_ventana[1],$tipos_archivos)){

				// guardamos la imagen de tarjeta
				$destino_tarjeta = "public/dist/img/beneficios/convenios/tarjeta/" . $nombre.$dia . "." . $ext_tarjeta[1];
				// guardamos la imagen de ventana
				$destino_ventana = "public/dist/img/beneficios/convenios/ventana/" . $nombre.$dia . "." . $ext_ventana[1];

				if (move_uploaded_file($_FILES["tarjeta"]["tmp_name"], $destino_tarjeta) && move_uploaded_file($_FILES["ventana"]["tmp_name"], $destino_ventana)){

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
						'post' 		=> $post,
						'id'		=> $id,
						'condicion' => $condicion,
						'nombre' 	=> $nombre,
						'estado' 	=> $estado,
						'finicio' 	=> $finicio,
						'ffin' 		=> $ffin,
						'tarjeta'	=> $destino_tarjeta,
						'ventana'	=> $destino_ventana,
						'user' 		=> $_SESSION['dni'],
					);
		
					$soap = new SoapClient($wsdl, $options);
					$result = $soap->MantConvenios($params);
					$convenio = json_decode($result->MantConveniosResult, true);

					header('Content-type: application/json; charset=utf-8');
					echo $json->encode(
						array(
							"vicon" 		=> $convenio[0]['v_icon'],
							"vtitle" 		=> $convenio[0]['v_title'],
							"vtext" 		=> $convenio[0]['v_text'],
							"itimer" 		=> $convenio[0]['i_timer'],
							"icase" 		=> $convenio[0]['i_case'],
							"vprogressbar" 	=> $convenio[0]['v_progressbar'],
							)
					);

				} else {
					// error al guardar las imagenes en la ruta
					header('Content-type: application/json; charset=utf-8');
					echo $json->encode(
						array(
							"vicon" 		=> "error",
							"vtitle" 		=> "No se encontro ruta de destino para el archivo...",
							"vtext" 		=> "Ruta no encontrada!",
							"itimer" 		=> 3000,
							"icase" 		=> 4, //"ruta no encontrada en el servidor";
							"vprogressbar" 	=> true,
							)
					);
				}
			} else {
				//echo 'tipo de archivos no admitidos';
				header('Content-type: application/json; charset=utf-8');
				echo $json->encode(
					array(
						"vicon" 		=> "error",
						"vtitle" 		=> "Tipo de archivo no admitivo...",
						"vtext" 		=> "Favor de elegir otro tipo de archivo!",
						"itimer" 		=> 3000,
						"icase" 		=> 5, //"tipo de archivo no permitido";
						"vprogressbar" 	=> true,
						)
				);
			}

		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function mantenimiento_convenio_img_datos()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$timezone = -5;
			$dia =  strval(gmdate("YmdHis", time() + 3600 * ($timezone + date("I"))));

			$post = $_POST['post'];
			$id = $_POST['id'];
			$condicion = $_POST['condicion'];
			$nombre = $_POST['nombre'];
			$estado = $_POST['estado'];
			$finicio = $_POST['finicio'];
			$ffin = $_POST['ffin'];
			$tarjeta = $_POST['tarjeta']; //explode("/", $_FILES["archivo"]["type"]);
			$ventana = $_POST['ventana']; //explode("/", $_FILES["archivo"]["type"]);

			$ext_tarjeta = explode("/", $_FILES["tarjeta"]["type"]);
			$ext_ventana = explode("/", $_FILES["ventana"]["type"]);

			$tipos_archivos = array('jpg','png','jpeg');

			if ($post == 3){	// delete

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
					'post' 		=> $post,
					'id'		=> $id,
					'condicion' => $condicion,
					'nombre' 	=> $nombre,
					'estado' 	=> $estado,
					'finicio' 	=> $finicio,
					'ffin' 		=> $ffin,
					'tarjeta'	=> "",
					'ventana'	=> "",
					'user' 		=> $_SESSION['dni'],
				);
	
				$soap = new SoapClient($wsdl, $options);
				$result = $soap->MantConvenios($params);
				$convenio = json_decode($result->MantConveniosResult, true);

				header('Content-type: application/json; charset=utf-8');
				echo $json->encode(
					array(
						"vicon" 		=> $convenio[0]['v_icon'],
						"vtitle" 		=> $convenio[0]['v_title'],
						"vtext" 		=> $convenio[0]['v_text'],
						"itimer" 		=> $convenio[0]['i_timer'],
						"icase" 		=> $convenio[0]['i_case'],
						"vprogressbar" 	=> $convenio[0]['v_progressbar'],
						)
				);

			} else {

				if (($ext_tarjeta[1] == "" || $ext_tarjeta[1] == null) && ($ext_ventana[1] == "" || $ext_ventana[1] == null) && $post > 1){

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
						'post' 		=> $post,
						'id'		=> $id,
						'condicion' => $condicion,
						'nombre' 	=> $nombre,
						'estado' 	=> $estado,
						'finicio' 	=> $finicio,
						'ffin' 		=> $ffin,
						'tarjeta'	=> "",
						'ventana'	=> "",
						'user' 		=> $_SESSION['dni'],
					);
		
					$soap = new SoapClient($wsdl, $options);
					$result = $soap->MantConvenios($params);
					$convenio = json_decode($result->MantConveniosResult, true);

					header('Content-type: application/json; charset=utf-8');
					echo $json->encode(
						array(
							"vicon" 		=> $convenio[0]['v_icon'],
							"vtitle" 		=> $convenio[0]['v_title'],
							"vtext" 		=> $convenio[0]['v_text'],
							"itimer" 		=> $convenio[0]['i_timer'],
							"icase" 		=> $convenio[0]['i_case'],
							"vprogressbar" 	=> $convenio[0]['v_progressbar'],
							)
					);
					
				} else if (($ext_tarjeta[1] !== "" || $ext_tarjeta[1] !== null) && ($ext_ventana[1] == "" || $ext_ventana[1] == null) && $post > 1) {

					if (in_array($ext_tarjeta[1],$tipos_archivos)){

						// guardamos la imagen de tarjeta
						$destino_tarjeta = "public/dist/img/beneficios/convenios/tarjeta/" . $nombre.$dia . "." . $ext_tarjeta[1];
		
						if (move_uploaded_file($_FILES["tarjeta"]["tmp_name"], $destino_tarjeta)){
		
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
								'post' 		=> $post,
								'id'		=> $id,
								'condicion' => $condicion,
								'nombre' 	=> $nombre,
								'estado' 	=> $estado,
								'finicio' 	=> $finicio,
								'ffin' 		=> $ffin,
								'tarjeta'	=> $destino_tarjeta,
								'ventana'	=> "",
								'user' 		=> $_SESSION['dni'],
							);
							$soap = new SoapClient($wsdl, $options);

							// eliminar imagen anterior (tarjeta)
							$parm1 = array(
								'post' 	=> 2, //0 -- consuta publicados, 1 --consultar todos, otro numero --consulta x id
								'id'	=> $id, // no se usa aqui
							);
							// convenios
							$result1 = $soap->ListarConvenios($parm1);
							$idconvenios = json_decode($result1->ListarConveniosResult, true);

							unlink($idconvenios[0]['v_tarjeta']);
				
							$result = $soap->MantConvenios($params);
							$convenio = json_decode($result->MantConveniosResult, true);

							header('Content-type: application/json; charset=utf-8');
							echo $json->encode(
								array(
									"vicon" 		=> $convenio[0]['v_icon'],
									"vtitle" 		=> $convenio[0]['v_title'],
									"vtext" 		=> $convenio[0]['v_text'],
									"itimer" 		=> $convenio[0]['i_timer'],
									"icase" 		=> $convenio[0]['i_case'],
									"vprogressbar" 	=> $convenio[0]['v_progressbar'],
									)
							);
		
						} else {
							// error al guardar las imagenes en la ruta
							header('Content-type: application/json; charset=utf-8');
							echo $json->encode(
								array(
									"vicon" 		=> "error",
									"vtitle" 		=> "No se encontro ruta de destino para el archivo...",
									"vtext" 		=> "Ruta no encontrada!",
									"itimer" 		=> 3000,
									"icase" 		=> 4, //"ruta no encontrada en el servidor";
									"vprogressbar" 	=> true,
									)
							);
						}
					} else {
						//echo 'tipo de archivos no admitidos';
						header('Content-type: application/json; charset=utf-8');
						echo $json->encode(
							array(
								"vicon" 		=> "error",
								"vtitle" 		=> "Tipo de archivo no admitivo...",
								"vtext" 		=> "Favor de elegir otro tipo de archivo!",
								"itimer" 		=> 3000,
								"icase" 		=> 5, //"tipo de archivo no permitido";
								"vprogressbar" 	=> true,
								)
						);
					}

				} else if (($ext_tarjeta[1] == "" || $ext_tarjeta[1] == null) && ($ext_ventana[1] !== "" || $ext_ventana[1] !== null) && $post > 1) {
					
					if (in_array($ext_ventana[1],$tipos_archivos)){

						// guardamos la imagen de ventana
						$destino_ventana = "public/dist/img/beneficios/convenios/ventana/" . $nombre.$dia . "." . $ext_ventana[1];
		
						if (move_uploaded_file($_FILES["ventana"]["tmp_name"], $destino_ventana)){
		
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
								'post' 		=> $post,
								'id'		=> $id,
								'condicion' => $condicion,
								'nombre' 	=> $nombre,
								'estado' 	=> $estado,
								'finicio' 	=> $finicio,
								'ffin' 		=> $ffin,
								'tarjeta'	=> "",
								'ventana'	=> $destino_ventana,
								'user' 		=> $_SESSION['dni'],
							);
				
							$soap = new SoapClient($wsdl, $options);

							// eliminar imagen anterior (ventana)
							$parm1 = array(
								'post' 	=> 2, //0 -- consuta publicados, 1 --consultar todos, otro numero --consulta x id
								'id'	=> $id, // no se usa aqui
							);
							// convenios
							$result1 = $soap->ListarConvenios($parm1);
							$idconvenios = json_decode($result1->ListarConveniosResult, true);

							unlink($idconvenios[0]['v_ventana']);

							$result = $soap->MantConvenios($params);
							$convenio = json_decode($result->MantConveniosResult, true);
		
							header('Content-type: application/json; charset=utf-8');
							echo $json->encode(
								array(
									"vicon" 		=> $convenio[0]['v_icon'],
									"vtitle" 		=> $convenio[0]['v_title'],
									"vtext" 		=> $convenio[0]['v_text'],
									"itimer" 		=> $convenio[0]['i_timer'],
									"icase" 		=> $convenio[0]['i_case'],
									"vprogressbar" 	=> $convenio[0]['v_progressbar'],
									)
							);
		
						} else {
							// error al guardar las imagenes en la ruta
							header('Content-type: application/json; charset=utf-8');
							echo $json->encode(
								array(
									"vicon" 		=> "error",
									"vtitle" 		=> "No se encontro ruta de destino para el archivo...",
									"vtext" 		=> "Ruta no encontrada!",
									"itimer" 		=> 3000,
									"icase" 		=> 4, //"ruta no encontrada en el servidor";
									"vprogressbar" 	=> true,
									)
							);
						}
					} else {
						//echo 'tipo de archivos no admitidos';
						header('Content-type: application/json; charset=utf-8');
						echo $json->encode(
							array(
								"vicon" 		=> "error",
								"vtitle" 		=> "Tipo de archivo no admitivo...",
								"vtext" 		=> "Favor de elegir otro tipo de archivo!",
								"itimer" 		=> 3000,
								"icase" 		=> 5, //"tipo de archivo no permitido";
								"vprogressbar" 	=> true,
								)
						);
					}

				} else {

					if (in_array($ext_tarjeta[1],$tipos_archivos) && in_array($ext_ventana[1],$tipos_archivos)){

						// guardamos la imagen de tarjeta
						$destino_tarjeta = "public/dist/img/beneficios/convenios/tarjeta/" . $nombre.$dia . "." . $ext_tarjeta[1];
						// guardamos la imagen de ventana
						$destino_ventana = "public/dist/img/beneficios/convenios/ventana/" . $nombre.$dia . "." . $ext_ventana[1];
		
						if (move_uploaded_file($_FILES["tarjeta"]["tmp_name"], $destino_tarjeta) && move_uploaded_file($_FILES["ventana"]["tmp_name"], $destino_ventana)){
		
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
								'post' 		=> $post,
								'id'		=> $id,
								'condicion' => $condicion,
								'nombre' 	=> $nombre,
								'estado' 	=> $estado,
								'finicio' 	=> $finicio,
								'ffin' 		=> $ffin,
								'tarjeta'	=> $destino_tarjeta,
								'ventana'	=> $destino_ventana,
								'user' 		=> $_SESSION['dni'],
							);
				
							$soap = new SoapClient($wsdl, $options);

							// eliminar imagen anterior (tarjeta) y (ventana)
							$parm1 = array(
								'post' 	=> 2, //0 -- consuta publicados, 1 --consultar todos, otro numero --consulta x id
								'id'	=> $id, // no se usa aqui
							);
							// convenios
							$result1 = $soap->ListarConvenios($parm1);
							$idconvenios = json_decode($result1->ListarConveniosResult, true);

							unlink($idconvenios[0]['v_tarjeta']);
							unlink($idconvenios[0]['v_ventana']);

							$result = $soap->MantConvenios($params);
							$convenio = json_decode($result->MantConveniosResult, true);
		
							header('Content-type: application/json; charset=utf-8');
							echo $json->encode(
								array(
									"vicon" 		=> $convenio[0]['v_icon'],
									"vtitle" 		=> $convenio[0]['v_title'],
									"vtext" 		=> $convenio[0]['v_text'],
									"itimer" 		=> $convenio[0]['i_timer'],
									"icase" 		=> $convenio[0]['i_case'],
									"vprogressbar" 	=> $convenio[0]['v_progressbar'],
									)
							);
		
						} else {
							// error al guardar las imagenes en la ruta
							header('Content-type: application/json; charset=utf-8');
							echo $json->encode(
								array(
									"vicon" 		=> "error",
									"vtitle" 		=> "No se encontro ruta de destino para el archivo...",
									"vtext" 		=> "Ruta no encontrada!",
									"itimer" 		=> 3000,
									"icase" 		=> 4, //"ruta no encontrada en el servidor";
									"vprogressbar" 	=> true,
									)
							);
						}
					} else {
						//echo 'tipo de archivos no admitidos';
						header('Content-type: application/json; charset=utf-8');
						echo $json->encode(
							array(
								"vicon" 		=> "error",
								"vtitle" 		=> "Tipo de archivo no admitivo...",
								"vtext" 		=> "Favor de elegir otro tipo de archivo!",
								"itimer" 		=> 3000,
								"icase" 		=> 5, //"tipo de archivo no permitido";
								"vprogressbar" 	=> true,
								)
						);
					}

				}
			}
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function mantenimiento_convenio_pdf()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$timezone = -5;
			$dia =  strval(gmdate("YmdHis", time() + 3600 * ($timezone + date("I"))));

			$post = $_POST['post'];
			$id = $_POST['id'];
			$condicion = $_POST['condicion'];
			$nombre = $_POST['nombre'];
			$estado = $_POST['estado'];
			$finicio = $_POST['finicio'];
			$ffin = $_POST['ffin'];
			$tarjeta = $_POST['tarjeta']; //explode("/", $_FILES["archivo"]["type"]);
			$ventana = $_POST['ventana']; //explode("/", $_FILES["archivo"]["type"]);

			$ext_tarjeta = explode("/", $_FILES["tarjeta"]["type"]);
			$ext_ventana = explode("/", $_FILES["ventana"]["type"]);

			$tipos_archivos = array('jpg','png','jpeg');
			$tipos_archivos_v = array('pdf');

			if (in_array($ext_tarjeta[1],$tipos_archivos) && in_array($ext_ventana[1],$tipos_archivos_v)){

				// guardamos la imagen de tarjeta
				$destino_tarjeta = "public/dist/img/beneficios/convenios/tarjeta/" . $nombre.$dia . "." . $ext_tarjeta[1];
				// guardamos la imagen de ventana
				$destino_ventana = "public/dist/img/beneficios/convenios/ventana/" . $nombre.$dia . "." . $ext_ventana[1];

				if (move_uploaded_file($_FILES["tarjeta"]["tmp_name"], $destino_tarjeta) && move_uploaded_file($_FILES["ventana"]["tmp_name"], $destino_ventana)){

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
						'post' 		=> $post,
						'id'		=> $id,
						'condicion' => $condicion,
						'nombre' 	=> $nombre,
						'estado' 	=> $estado,
						'finicio' 	=> $finicio,
						'ffin' 		=> $ffin,
						'tarjeta'	=> $destino_tarjeta,
						'ventana'	=> $destino_ventana,
						'user' 		=> $_SESSION['dni'],
					);
		
					$soap = new SoapClient($wsdl, $options);
					$result = $soap->MantConvenios($params);
					$convenio = json_decode($result->MantConveniosResult, true);

					header('Content-type: application/json; charset=utf-8');
					echo $json->encode(
						array(
							"vicon" 		=> $convenio[0]['v_icon'],
							"vtitle" 		=> $convenio[0]['v_title'],
							"vtext" 		=> $convenio[0]['v_text'],
							"itimer" 		=> $convenio[0]['i_timer'],
							"icase" 		=> $convenio[0]['i_case'],
							"vprogressbar" 	=> $convenio[0]['v_progressbar'],
							)
					);

				} else {
					// error al guardar las imagenes en la ruta
					header('Content-type: application/json; charset=utf-8');
					echo $json->encode(
						array(
							"vicon" 		=> "error",
							"vtitle" 		=> "No se encontro ruta de destino para el archivo...",
							"vtext" 		=> "Ruta no encontrada!",
							"itimer" 		=> 3000,
							"icase" 		=> 4, //"ruta no encontrada en el servidor";
							"vprogressbar" 	=> true,
							)
					);
				}
			} else {
				//echo 'tipo de archivos no admitidos';
				header('Content-type: application/json; charset=utf-8');
				echo $json->encode(
					array(
						"vicon" 		=> "error",
						"vtitle" 		=> "Tipo de archivo no admitivo...",
						"vtext" 		=> "Favor de elegir otro tipo de archivo!",
						"itimer" 		=> 3000,
						"icase" 		=> 5, //"tipo de archivo no permitido";
						"vprogressbar" 	=> true,
						)
				);
			}

		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function mantenimiento_convenio_pdf_datos()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$timezone = -5;
			$dia =  strval(gmdate("YmdHis", time() + 3600 * ($timezone + date("I"))));

			$post = $_POST['post'];
			$id = $_POST['id'];
			$condicion = $_POST['condicion'];
			$nombre = $_POST['nombre'];
			$estado = $_POST['estado'];
			$finicio = $_POST['finicio'];
			$ffin = $_POST['ffin'];
			$tarjeta = $_POST['tarjeta']; //explode("/", $_FILES["archivo"]["type"]);
			$ventana = $_POST['ventana']; //explode("/", $_FILES["archivo"]["type"]);

			$ext_tarjeta = explode("/", $_FILES["tarjeta"]["type"]);
			$ext_ventana = explode("/", $_FILES["ventana"]["type"]);

			$tipos_archivos = array('jpg','png','jpeg');
			$tipos_archivos_v = array('pdf');

			if ($post == 3){	// delete

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
					'post' 		=> $post,
					'id'		=> $id,
					'condicion' => $condicion,
					'nombre' 	=> $nombre,
					'estado' 	=> $estado,
					'finicio' 	=> $finicio,
					'ffin' 		=> $ffin,
					'tarjeta'	=> "",
					'ventana'	=> "",
					'user' 		=> $_SESSION['dni'],
				);
	
				$soap = new SoapClient($wsdl, $options);
				$result = $soap->MantConvenios($params);
				$convenio = json_decode($result->MantConveniosResult, true);

				header('Content-type: application/json; charset=utf-8');
				echo $json->encode(
					array(
						"vicon" 		=> $convenio[0]['v_icon'],
						"vtitle" 		=> $convenio[0]['v_title'],
						"vtext" 		=> $convenio[0]['v_text'],
						"itimer" 		=> $convenio[0]['i_timer'],
						"icase" 		=> $convenio[0]['i_case'],
						"vprogressbar" 	=> $convenio[0]['v_progressbar'],
						)
				);

			} else {

				if (($ext_tarjeta[1] == "" || $ext_tarjeta[1] == null) && ($ext_ventana[1] == "" || $ext_ventana[1] == null) && $post > 1){

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
						'post' 		=> $post,
						'id'		=> $id,
						'condicion' => $condicion,
						'nombre' 	=> $nombre,
						'estado' 	=> $estado,
						'finicio' 	=> $finicio,
						'ffin' 		=> $ffin,
						'tarjeta'	=> "",
						'ventana'	=> "",
						'user' 		=> $_SESSION['dni'],
					);
		
					$soap = new SoapClient($wsdl, $options);
					$result = $soap->MantConvenios($params);
					$convenio = json_decode($result->MantConveniosResult, true);

					header('Content-type: application/json; charset=utf-8');
					echo $json->encode(
						array(
							"vicon" 		=> $convenio[0]['v_icon'],
							"vtitle" 		=> $convenio[0]['v_title'],
							"vtext" 		=> $convenio[0]['v_text'],
							"itimer" 		=> $convenio[0]['i_timer'],
							"icase" 		=> $convenio[0]['i_case'],
							"vprogressbar" 	=> $convenio[0]['v_progressbar'],
							)
					);
					
				} else if (($ext_tarjeta[1] !== "" || $ext_tarjeta[1] !== null) && ($ext_ventana[1] == "" || $ext_ventana[1] == null) && $post > 1) {

					if (in_array($ext_tarjeta[1],$tipos_archivos)){

						// guardamos la imagen de tarjeta
						$destino_tarjeta = "public/dist/img/beneficios/convenios/tarjeta/" . $nombre.$dia . "." . $ext_tarjeta[1];
		
						if (move_uploaded_file($_FILES["tarjeta"]["tmp_name"], $destino_tarjeta)){
		
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
								'post' 		=> $post,
								'id'		=> $id,
								'condicion' => $condicion,
								'nombre' 	=> $nombre,
								'estado' 	=> $estado,
								'finicio' 	=> $finicio,
								'ffin' 		=> $ffin,
								'tarjeta'	=> $destino_tarjeta,
								'ventana'	=> "",
								'user' 		=> $_SESSION['dni'],
							);
							$soap = new SoapClient($wsdl, $options);

							// eliminar imagen anterior (tarjeta)
							$parm1 = array(
								'post' 	=> 2, //0 -- consuta publicados, 1 --consultar todos, otro numero --consulta x id
								'id'	=> $id, // no se usa aqui
							);
							// convenios
							$result1 = $soap->ListarConvenios($parm1);
							$idconvenios = json_decode($result1->ListarConveniosResult, true);

							unlink($idconvenios[0]['v_tarjeta']);
				
							$result = $soap->MantConvenios($params);
							$convenio = json_decode($result->MantConveniosResult, true);

							header('Content-type: application/json; charset=utf-8');
							echo $json->encode(
								array(
									"vicon" 		=> $convenio[0]['v_icon'],
									"vtitle" 		=> $convenio[0]['v_title'],
									"vtext" 		=> $convenio[0]['v_text'],
									"itimer" 		=> $convenio[0]['i_timer'],
									"icase" 		=> $convenio[0]['i_case'],
									"vprogressbar" 	=> $convenio[0]['v_progressbar'],
									)
							);
		
						} else {
							// error al guardar las imagenes en la ruta
							header('Content-type: application/json; charset=utf-8');
							echo $json->encode(
								array(
									"vicon" 		=> "error",
									"vtitle" 		=> "No se encontro ruta de destino para el archivo...",
									"vtext" 		=> "Ruta no encontrada!",
									"itimer" 		=> 3000,
									"icase" 		=> 4, //"ruta no encontrada en el servidor";
									"vprogressbar" 	=> true,
									)
							);
						}
					} else {
						//echo 'tipo de archivos no admitidos';
						header('Content-type: application/json; charset=utf-8');
						echo $json->encode(
							array(
								"vicon" 		=> "error",
								"vtitle" 		=> "Tipo de archivo no admitivo...",
								"vtext" 		=> "Favor de elegir otro tipo de archivo!",
								"itimer" 		=> 3000,
								"icase" 		=> 5, //"tipo de archivo no permitido";
								"vprogressbar" 	=> true,
								)
						);
					}

				} else if (($ext_tarjeta[1] == "" || $ext_tarjeta[1] == null) && ($ext_ventana[1] !== "" || $ext_ventana[1] !== null) && $post > 1) {
					
					if (in_array($ext_ventana[1],$tipos_archivos_v)){

						// guardamos la imagen de ventana
						$destino_ventana = "public/dist/img/beneficios/convenios/ventana/" . $nombre.$dia . "." . $ext_ventana[1];
		
						if (move_uploaded_file($_FILES["ventana"]["tmp_name"], $destino_ventana)){
		
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
								'post' 		=> $post,
								'id'		=> $id,
								'condicion' => $condicion,
								'nombre' 	=> $nombre,
								'estado' 	=> $estado,
								'finicio' 	=> $finicio,
								'ffin' 		=> $ffin,
								'tarjeta'	=> "",
								'ventana'	=> $destino_ventana,
								'user' 		=> $_SESSION['dni'],
							);
				
							$soap = new SoapClient($wsdl, $options);

							// eliminar imagen anterior (ventana)
							$parm1 = array(
								'post' 	=> 2, //0 -- consuta publicados, 1 --consultar todos, otro numero --consulta x id
								'id'	=> $id, // no se usa aqui
							);
							// convenios
							$result1 = $soap->ListarConvenios($parm1);
							$idconvenios = json_decode($result1->ListarConveniosResult, true);

							unlink($idconvenios[0]['v_ventana']);

							$result = $soap->MantConvenios($params);
							$convenio = json_decode($result->MantConveniosResult, true);
		
							header('Content-type: application/json; charset=utf-8');
							echo $json->encode(
								array(
									"vicon" 		=> $convenio[0]['v_icon'],
									"vtitle" 		=> $convenio[0]['v_title'],
									"vtext" 		=> $convenio[0]['v_text'],
									"itimer" 		=> $convenio[0]['i_timer'],
									"icase" 		=> $convenio[0]['i_case'],
									"vprogressbar" 	=> $convenio[0]['v_progressbar'],
									)
							);
		
						} else {
							// error al guardar las imagenes en la ruta
							header('Content-type: application/json; charset=utf-8');
							echo $json->encode(
								array(
									"vicon" 		=> "error",
									"vtitle" 		=> "No se encontro ruta de destino para el archivo...",
									"vtext" 		=> "Ruta no encontrada!",
									"itimer" 		=> 3000,
									"icase" 		=> 4, //"ruta no encontrada en el servidor";
									"vprogressbar" 	=> true,
									)
							);
						}
					} else {
						//echo 'tipo de archivos no admitidos';
						header('Content-type: application/json; charset=utf-8');
						echo $json->encode(
							array(
								"vicon" 		=> "error",
								"vtitle" 		=> "Tipo de archivo no admitivo...",
								"vtext" 		=> "Favor de elegir otro tipo de archivo!",
								"itimer" 		=> 3000,
								"icase" 		=> 5, //"tipo de archivo no permitido";
								"vprogressbar" 	=> true,
								)
						);
					}

				} else {

					if (in_array($ext_tarjeta[1],$tipos_archivos) && in_array($ext_ventana[1],$tipos_archivos_v)){

						// guardamos la imagen de tarjeta
						$destino_tarjeta = "public/dist/img/beneficios/convenios/tarjeta/" . $nombre.$dia . "." . $ext_tarjeta[1];
						// guardamos la imagen de ventana
						$destino_ventana = "public/dist/img/beneficios/convenios/ventana/" . $nombre.$dia . "." . $ext_ventana[1];
		
						if (move_uploaded_file($_FILES["tarjeta"]["tmp_name"], $destino_tarjeta) && move_uploaded_file($_FILES["ventana"]["tmp_name"], $destino_ventana)){
		
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
								'post' 		=> $post,
								'id'		=> $id,
								'condicion' => $condicion,
								'nombre' 	=> $nombre,
								'estado' 	=> $estado,
								'finicio' 	=> $finicio,
								'ffin' 		=> $ffin,
								'tarjeta'	=> $destino_tarjeta,
								'ventana'	=> $destino_ventana,
								'user' 		=> $_SESSION['dni'],
							);
				
							$soap = new SoapClient($wsdl, $options);

							// eliminar imagen anterior (tarjeta) y (ventana)
							$parm1 = array(
								'post' 	=> 2, //0 -- consuta publicados, 1 --consultar todos, otro numero --consulta x id
								'id'	=> $id, // no se usa aqui
							);
							// convenios
							$result1 = $soap->ListarConvenios($parm1);
							$idconvenios = json_decode($result1->ListarConveniosResult, true);

							unlink($idconvenios[0]['v_tarjeta']);
							unlink($idconvenios[0]['v_ventana']);

							$result = $soap->MantConvenios($params);
							$convenio = json_decode($result->MantConveniosResult, true);
		
							header('Content-type: application/json; charset=utf-8');
							echo $json->encode(
								array(
									"vicon" 		=> $convenio[0]['v_icon'],
									"vtitle" 		=> $convenio[0]['v_title'],
									"vtext" 		=> $convenio[0]['v_text'],
									"itimer" 		=> $convenio[0]['i_timer'],
									"icase" 		=> $convenio[0]['i_case'],
									"vprogressbar" 	=> $convenio[0]['v_progressbar'],
									)
							);
		
						} else {
							// error al guardar las imagenes en la ruta
							header('Content-type: application/json; charset=utf-8');
							echo $json->encode(
								array(
									"vicon" 		=> "error",
									"vtitle" 		=> "No se encontro ruta de destino para el archivo...",
									"vtext" 		=> "Ruta no encontrada!",
									"itimer" 		=> 3000,
									"icase" 		=> 4, //"ruta no encontrada en el servidor";
									"vprogressbar" 	=> true,
									)
							);
						}
					} else {
						//echo 'tipo de archivos no admitidos';
						header('Content-type: application/json; charset=utf-8');
						echo $json->encode(
							array(
								"vicon" 		=> "error",
								"vtitle" 		=> "Tipo de archivo no admitivo...",
								"vtext" 		=> "Favor de elegir otro tipo de archivo!",
								"itimer" 		=> 3000,
								"icase" 		=> 5, //"tipo de archivo no permitido";
								"vprogressbar" 	=> true,
								)
						);
					}

				}
			}
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function imagen_refresh()
	{
		if (isset($_SESSION['usuario'])) {

			$id = $_POST['idcon'];

			$text1 = $_POST['texto'];
			$size1 = $_POST['size'];
			$color1 = $_POST['color'];
			$colornew1 = str_replace("#","",$color1);

			$angle1 = $_POST['angle'];
			$x1 = $_POST['x'];
			$y1 = $_POST['y'];

			$split = str_split($colornew1, 2);
			$r1 = hexdec($split[0]);
			$g1 = hexdec($split[1]);
			$b1 = hexdec($split[2]);

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
			$result = $soap->ListarConveniosTexto($params);
			$listaconveniodisenio = json_decode($result->ListarConveniosTextoResult, true);

			$parm1 = array(
				'post' 	=> 2, //0 -- consuta publicados, 1 --consultar todos, otro numero --consulta x id
				'id'	=> $id, // id para armar el div de imagen
			);

			$result1 = $soap->ListarConvenios($parm1);
			$imgconvenio = json_decode($result1->ListarConveniosResult, true);

			header("Content-type: image/jpeg");

			$timezone = -5;
			$nombre =  strval(gmdate("YmdHis", time() + 3600 * ($timezone + date("I"))));

			function datos_globales($string)
			{
				$string = str_replace(
					array('[usuario]','[dni]', '[nombre]', '[perfil]','[razon]', '[ruc]','[nombrecomercial]','[fecha]','[fechahora]'),
					array($_SESSION['usuario'],$_SESSION['dni'], $_SESSION['nombre'], $_SESSION['perfil'], 'VERDUM PERÚ S.A.C.',ruc,nombrecomercial,fechasis,fechahorasis),
					$string
				);
				return $string;
			}

			$fuente =  __DIR__ . "/fonts/"."GOTHICB.TTF";
			$img2 = imagecreatefromjpeg($imgconvenio[0]['v_ventana']);

			if (count($listaconveniodisenio) > 0) {

				// foreach
				foreach	($listaconveniodisenio as $dsn){

					$color = $dsn['v_color'];
					$colornew = str_replace("#","",$color);

					$split = str_split($colornew, 2);
					$r = hexdec($split[0]);
					$g = hexdec($split[1]);
					$b = hexdec($split[2]);

					$textnew = datos_globales($dsn['v_texto']);
					$black = imagecolorallocate($img2,$r,$g,$b);

					imagettftext($img2, $dsn['i_tamanio'], $dsn['i_angulo'], $dsn['i_posicionx'], $dsn['i_posiciony'], $black, $fuente, $textnew);
				}

				$textnew1 = datos_globales($text1);
				$black1 = imagecolorallocate($img2,$r1,$g1,$b1);
				imagettftext($img2, $size1, $angle1, $x1, $y1, $black1, $fuente, $textnew1);

				$salida = "public/dist/img/beneficios/convenios/ventana/".$nombre.".jpg";

				imagepng($img2, $salida);
				imagedestroy($img2);

				$div_new = "
				<div id='draw-img' style='border-radius: 10px; -webkit-border-radius: 10px;'>
					<img id='img-refresh' class='card-img-top' style='border:1px solid black; -webkit-border-radius: 10px;' src='".BASE_URL.$salida."'>
				</div>
				";

			} else {

				$textnew1 = datos_globales($text1);
				$black1 = imagecolorallocate($img2,$r1,$g1,$b1);
				imagettftext($img2, $size1, $angle1, $x1, $y1, $black1, $fuente, $textnew1);

				$salida = "public/dist/img/beneficios/convenios/ventana/".$nombre.".jpg";

				imagepng($img2, $salida);
				imagedestroy($img2);

				$div_new = "
				<div id='draw-img' style='border-radius: 10px; -webkit-border-radius: 10px;'>
					<img id='img-refresh' class='card-img-top' style='border:1px solid black; -webkit-border-radius: 10px;' src='".BASE_URL.$salida."'>
				</div>
				";
			}

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();
			
			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"div" 		=> $div_new,
					"imagen"	=> $nombre,
				)
			);
			// echo $div_new;
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function reshacer_imagen()
	{
		if (isset($_SESSION['usuario'])) {

			$nombre = $_POST['nombre'];
			unlink("public/dist/img/beneficios/convenios/ventana/".$nombre.".jpg");
			// echo 'correcto';

		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function guardar_disenio()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$post = $_POST['post'];
			$id = $_POST['id'];
			$iconvenio = $_POST['idcon']; // id convenio
			$text = $_POST['texto']; // texto
			$size = $_POST['size']; // tamaño
			$color = $_POST['color']; // color en hexadecimal
			$colornew = str_replace("#","",$color); 
			$angle = $_POST['angle']; // angulo
			$x = $_POST['x']; // posicion x
			$y = $_POST['y']; // posicion y

			$split = str_split($colornew, 2);
			$r = hexdec($split[0]); // R
			$g = hexdec($split[1]); // G
			$b = hexdec($split[2]); // B

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
				'post' 		=> $post,
				'id' 		=> $id,
				'iconvenio' => $iconvenio,
				'texto' 	=> $text,
				'tamanio' 	=> $size,
				'color' 	=> $color,
				'r'			=> $r,
				'g'			=> $g,
				'b'			=> $b,
				'angulo'	=> $angle,
				'posicionx'	=> $x,
				'posiciony'	=> $y,
				'user' 		=> $_SESSION['dni'],
			);

			// insertar diseño en BD
			$soap = new SoapClient($wsdl, $options);
			$result = $soap->MantConveniosTexto($params);
			$conveniotexto = json_decode($result->MantConveniosTextoResult, true);

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"vicon" 		=> $conveniotexto[0]['v_icon'],
					"vtitle" 		=> $conveniotexto[0]['v_title'],
					"vtext" 		=> $conveniotexto[0]['v_text'],
					"itimer" 		=> $conveniotexto[0]['i_timer'],
					"icase" 		=> $conveniotexto[0]['i_case'],
					"vprogressbar" 	=> $conveniotexto[0]['v_progressbar'],
					)
			);

		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function tabla_disenio()
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

			$params = array(
				'id' => $id,
			);

			// consulta para recontruir tabla
			$soap = new SoapClient($wsdl, $options);
			$result = $soap->ListarConveniosTexto($params);
			$listaconveniodisenio = json_decode($result->ListarConveniosTextoResult, true);

			// construimos la tabla
			$filas="";
			foreach($listaconveniodisenio as $dv){
				$filas.="
				<tr>
					<td class='text-center'>".$dv['i_id']."</td>
					<td class='text-center'>".$dv['i_convenio']."</td>
					<td class='text-left'>".$dv['v_texto']."</td>
					<td class='text-center'>".$dv['i_tamanio']."</td>
					<td class='text-center' style='color:".$dv['v_color']."; background-color: rgb(205,205,205);'><i class='fas fa-square'></i>&nbsp;&nbsp;".$dv['v_color']."</td>
					<td class='text-center'>".$dv['i_angulo']."</td>
					<td class='text-center'>".$dv['i_posicionx']."</td>
					<td class='text-center'>".$dv['i_posiciony']."</td>
					<td><a id=".$dv['i_id']." href='#' class='btn btn-kimbo btn-sm text-white editar-data'><i class='fas fa-edit'></i></a></td>
      				<td><a id=".$dv['i_id']." href='#' class='btn btn-danger btn-sm text-white delete-data'><i class='fas fa-trash-can'></i></a></td>
				</tr>
				";
			};

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"tabla" => $filas,
					)
			);

		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function obtenerimg_convenio()
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

			$params = array(
				'id' => $id,
			);

			// consulta para recontruir tabla
			$soap = new SoapClient($wsdl, $options);
			$result = $soap->ListarConveniosTexto($params);
			$listaconveniodisenio = json_decode($result->ListarConveniosTextoResult, true);

			$parm1 = array(
				'post' 	=> 2, //0 -- consuta publicados, 1 --consultar todos, otro numero --consulta x id
				'id'	=> $id, // id para armar el div de imagen
			);

			$result1 = $soap->ListarConvenios($parm1);
			$imgconvenio = json_decode($result1->ListarConveniosResult, true);

			$div_new = "";

			if (count($listaconveniodisenio) > 0) {
				// si hay datos contruimos ya la imagen

				$timezone = -5;
				$nombre =  strval(gmdate("YmdHis", time() + 3600 * ($timezone + date("I"))));

				function datos_globales($string)
				{
					$string = str_replace(
						array('[usuario]','[dni]', '[nombre]', '[perfil]','[razon]', '[ruc]','[nombrecomercial]','[fecha]','[fechahora]'),
						array($_SESSION['usuario'],$_SESSION['dni'], $_SESSION['nombre'], $_SESSION['perfil'], 'VERDUM PERÚ S.A.C.',ruc,nombrecomercial,fechasis,fechahorasis),
						$string
					);
					return $string;
				}

				$fuente =  __DIR__ . "/fonts/"."GOTHICB.TTF";
				$img2 = imagecreatefromjpeg($imgconvenio[0]['v_ventana']);

				// foreach
				foreach	($listaconveniodisenio as $dsn){

					$color = $dsn['v_color'];
					$colornew = str_replace("#","",$color);

					$split = str_split($colornew, 2);
					$r = hexdec($split[0]);
					$g = hexdec($split[1]);
					$b = hexdec($split[2]);

					$textnew = datos_globales($dsn['v_texto']);
					$black = imagecolorallocate($img2,$r,$g,$b);

					imagettftext($img2, $dsn['i_tamanio'], $dsn['i_angulo'], $dsn['i_posicionx'], $dsn['i_posiciony'], $black, $fuente, $textnew);
				}

				$salida = "public/dist/img/beneficios/convenios/ventana/".$nombre.".jpg";

				imagejpeg($img2, $salida);
				imagedestroy($img2);

				$div_new = "
				<div id='draw-img' style='border-radius: 10px; -webkit-border-radius: 10px;'>
					<img id='img-refresh' class='card-img-top' style='border:1px solid black; -webkit-border-radius: 10px;' src='".BASE_URL.$salida."'>
				</div>
				";

			} else {
				// obtener imagen principal
				$div_new = "
				<div id='draw-img' style='border-radius: 10px; -webkit-border-radius: 10px;'>
					<img id='img-refresh' class='card-img-top' style='border:1px solid black; -webkit-border-radius: 10px;' src='".BASE_URL.$imgconvenio[0]['v_ventana']."'>
				</div>
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

	public function obtenerdatos_disenio()
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

			$params = array(
				'id' => $id,
			);

			// consulta para obtener datos
			$soap = new SoapClient($wsdl, $options);
			$result = $soap->ListarDisenioTexto($params);
			$listaconveniodisenio = json_decode($result->ListarDisenioTextoResult, true);

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"id" 			=> $listaconveniodisenio[0]['i_id'],
					"iconvenio" 	=> $listaconveniodisenio[0]['i_convenio'],
					"vtexto" 		=> $listaconveniodisenio[0]['v_texto'],
					"itamanio" 		=> $listaconveniodisenio[0]['i_tamanio'],
					"vcolor" 		=> $listaconveniodisenio[0]['v_color'],
					"iangulo"		=> $listaconveniodisenio[0]['i_angulo'],
					"iposicionx" 	=> $listaconveniodisenio[0]['i_posicionx'],
					"iposiciony" 	=> $listaconveniodisenio[0]['i_posiciony'],
					)
			);

		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function link_img()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"vtarjeta" 	=> BASE_URL."public/dist/img/beneficios/convenios/tarjeta-no-disponible.jpg",
					"vventana" 	=> BASE_URL."public/dist/img/beneficios/convenios/ventana-no-disponible.jpg",
					)
			);

		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function obtenerdatos()
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

			$parm1 = array(
				'post' 	=> 2, //0 -- consuta publicados, 1 --consultar todos, otro numero --consulta x id
				'id'	=> $id, // se usa aqui
			);
			// convenios
			$result1 = $soap->ListarConvenios($parm1);
			$convenios = json_decode($result1->ListarConveniosResult, true);

			$div_tarjeta = "
			<div id='draw-img' style='border-radius: 10px; -webkit-border-radius: 10px;'>
				<img id='ruta-imagen-tarjeta1' class='card-img-top' style='border:1px solid black; -webkit-border-radius: 10px;' src='".BASE_URL.$convenios[0]['v_tarjeta']."'>
			</div>
			";

			$div_ventana = "
			<div id='draw-img' style='border-radius: 10px; -webkit-border-radius: 10px;'>
				<img id='ruta-imagen-ventana1' class='card-img-top' style='border:1px solid black; -webkit-border-radius: 10px;' src='".BASE_URL.$convenios[0]['v_ventana']."'>
			</div>
			";

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"id" 			=> $convenios[0]['i_id'],
					"nombre" 		=> $convenios[0]['v_nombre'],
					"tarjeta" 		=> $div_tarjeta,
					"ventana" 		=> $div_ventana,
					"estado" 		=> $convenios[0]['i_estado'],
					"finicio"		=> $convenios[0]['d_finicio'],
					"ffin" 			=> $convenios[0]['d_ffin'],
					"condicion" 	=> $convenios[0]['i_condicion'],
					)
			);

		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function obtenerdatos_pdf()
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

			$parm1 = array(
				'post' 	=> 2, //0 -- consuta publicados, 1 --consultar todos, otro numero --consulta x id
				'id'	=> $id, // se usa aqui
			);
			// convenios
			$result1 = $soap->ListarConvenios($parm1);
			$convenios = json_decode($result1->ListarConveniosResult, true);

			$div_tarjeta = "
			<div id='draw-pdf-tarjeta1' style='border-radius: 10px; -webkit-border-radius: 10px;'>
				<img id='preview-pdf-tarjeta1' class='card-img-top' style='border:1px solid black; -webkit-border-radius: 10px;' src='".BASE_URL.$convenios[0]['v_tarjeta']."'>
			</div>
			";

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"id" 			=> $convenios[0]['i_id'],
					"nombre" 		=> $convenios[0]['v_nombre'],
					"tarjeta" 		=> $div_tarjeta,
					"estado" 		=> $convenios[0]['i_estado'],
					"finicio"		=> $convenios[0]['d_finicio'],
					"ffin" 			=> $convenios[0]['d_ffin'],
					"condicion" 	=> $convenios[0]['i_condicion'],
					)
			);

		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function mantenimiento_convenioedu_pdf()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$timezone = -5;
			$dia =  strval(gmdate("YmdHis", time() + 3600 * ($timezone + date("I"))));

			$post = $_POST['post'];
			$id = $_POST['id'];
			$condicion = $_POST['condicion'];
			$nombre = $_POST['nombre'];
			$estado = $_POST['estado'];
			$finicio = $_POST['finicio'];
			$ffin = $_POST['ffin'];
			$tarjeta = $_POST['tarjeta']; //explode("/", $_FILES["archivo"]["type"]);
			$ventana = $_POST['ventana']; //explode("/", $_FILES["archivo"]["type"]);

			$ext_tarjeta = explode("/", $_FILES["tarjeta"]["type"]);
			$ext_ventana = explode("/", $_FILES["ventana"]["type"]);

			$tipos_archivos = array('jpg','png','jpeg');
			$tipos_archivos_v = array('pdf');

			if (in_array($ext_tarjeta[1],$tipos_archivos) && in_array($ext_ventana[1],$tipos_archivos_v)){

				// guardamos la imagen de tarjeta
				$destino_tarjeta = "public/dist/img/beneficios/convenios educativos/tarjeta/" . $nombre.$dia . "." . $ext_tarjeta[1];
				// guardamos la imagen de ventana
				$destino_ventana = "public/dist/img/beneficios/convenios educativos/ventana/" . $nombre.$dia . "." . $ext_ventana[1];

				if (move_uploaded_file($_FILES["tarjeta"]["tmp_name"], $destino_tarjeta) && move_uploaded_file($_FILES["ventana"]["tmp_name"], $destino_ventana)){

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
						'post' 		=> $post,
						'id'		=> $id,
						'condicion' => $condicion,
						'nombre' 	=> $nombre,
						'estado' 	=> $estado,
						'finicio' 	=> $finicio,
						'ffin' 		=> $ffin,
						'tarjeta'	=> $destino_tarjeta,
						'ventana'	=> $destino_ventana,
						'user' 		=> $_SESSION['dni'],
					);
		
					$soap = new SoapClient($wsdl, $options);
					$result = $soap->MantConveniosEducativos($params);
					$convenioedu = json_decode($result->MantConveniosEducativosResult, true);

					header('Content-type: application/json; charset=utf-8');
					echo $json->encode(
						array(
							"vicon" 		=> $convenioedu[0]['v_icon'],
							"vtitle" 		=> $convenioedu[0]['v_title'],
							"vtext" 		=> $convenioedu[0]['v_text'],
							"itimer" 		=> $convenioedu[0]['i_timer'],
							"icase" 		=> $convenioedu[0]['i_case'],
							"vprogressbar" 	=> $convenioedu[0]['v_progressbar'],
							)
					);

				} else {
					// error al guardar las imagenes en la ruta
					header('Content-type: application/json; charset=utf-8');
					echo $json->encode(
						array(
							"vicon" 		=> "error",
							"vtitle" 		=> "No se encontro ruta de destino para el archivo...",
							"vtext" 		=> "Ruta no encontrada!",
							"itimer" 		=> 3000,
							"icase" 		=> 4, //"ruta no encontrada en el servidor";
							"vprogressbar" 	=> true,
							)
					);
				}
			} else {
				//echo 'tipo de archivos no admitidos';
				header('Content-type: application/json; charset=utf-8');
				echo $json->encode(
					array(
						"vicon" 		=> "error",
						"vtitle" 		=> "Tipo de archivo no admitivo...",
						"vtext" 		=> "Favor de elegir otro tipo de archivo!",
						"itimer" 		=> 3000,
						"icase" 		=> 5, //"tipo de archivo no permitido";
						"vprogressbar" 	=> true,
						)
				);
			}

		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function obtenerdatos_pdf_edu()
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

			$parm1 = array(
				'post' 	=> 2, //0 -- consuta publicados, 1 --consultar todos, otro numero --consulta x id
				'id'	=> $id, // se usa aqui
			);
			// convenios
			$result1 = $soap->ListarConveniosEducativos($parm1);
			$conveniosedu = json_decode($result1->ListarConveniosEducativosResult, true);

			$div_tarjeta = "
			<div id='draw-pdf-tarjeta-edu1' style='border-radius: 10px; -webkit-border-radius: 10px;'>
				<img id='preview-pdf-tarjeta-edu1' class='card-img-top' style='border:1px solid black; -webkit-border-radius: 10px;' src='".BASE_URL.$conveniosedu[0]['v_tarjeta']."'>
			</div>
			";

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"id" 			=> $conveniosedu[0]['i_id'],
					"nombre" 		=> $conveniosedu[0]['v_nombre'],
					"tarjeta" 		=> $div_tarjeta,
					"estado" 		=> $conveniosedu[0]['i_estado'],
					"finicio"		=> $conveniosedu[0]['d_finicio'],
					"ffin" 			=> $conveniosedu[0]['d_ffin'],
					"condicion" 	=> $conveniosedu[0]['i_condicion'],
					)
			);

		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function mantenimiento_convenioedu_pdf_datos()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$timezone = -5;
			$dia =  strval(gmdate("YmdHis", time() + 3600 * ($timezone + date("I"))));

			$post = $_POST['post'];
			$id = $_POST['id'];
			$condicion = $_POST['condicion'];
			$nombre = $_POST['nombre'];
			$estado = $_POST['estado'];
			$finicio = $_POST['finicio'];
			$ffin = $_POST['ffin'];
			$tarjeta = $_POST['tarjeta']; //explode("/", $_FILES["archivo"]["type"]);
			$ventana = $_POST['ventana']; //explode("/", $_FILES["archivo"]["type"]);

			$ext_tarjeta = explode("/", $_FILES["tarjeta"]["type"]);
			$ext_ventana = explode("/", $_FILES["ventana"]["type"]);

			$tipos_archivos = array('jpg','png','jpeg');
			$tipos_archivos_v = array('pdf');

			if ($post == 3){	// delete

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
					'post' 		=> $post,
					'id'		=> $id,
					'condicion' => $condicion,
					'nombre' 	=> $nombre,
					'estado' 	=> $estado,
					'finicio' 	=> $finicio,
					'ffin' 		=> $ffin,
					'tarjeta'	=> "",
					'ventana'	=> "",
					'user' 		=> $_SESSION['dni'],
				);
	
				$soap = new SoapClient($wsdl, $options);
				$result = $soap->MantConveniosEducativos($params);
				$convenio = json_decode($result->MantConveniosEducativosResult, true);

				header('Content-type: application/json; charset=utf-8');
				echo $json->encode(
					array(
						"vicon" 		=> $convenio[0]['v_icon'],
						"vtitle" 		=> $convenio[0]['v_title'],
						"vtext" 		=> $convenio[0]['v_text'],
						"itimer" 		=> $convenio[0]['i_timer'],
						"icase" 		=> $convenio[0]['i_case'],
						"vprogressbar" 	=> $convenio[0]['v_progressbar'],
						)
				);

			} else {

				if (($ext_tarjeta[1] == "" || $ext_tarjeta[1] == null) && ($ext_ventana[1] == "" || $ext_ventana[1] == null) && $post > 1){

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
						'post' 		=> $post,
						'id'		=> $id,
						'condicion' => $condicion,
						'nombre' 	=> $nombre,
						'estado' 	=> $estado,
						'finicio' 	=> $finicio,
						'ffin' 		=> $ffin,
						'tarjeta'	=> "",
						'ventana'	=> "",
						'user' 		=> $_SESSION['dni'],
					);
		
					$soap = new SoapClient($wsdl, $options);
					$result = $soap->MantConveniosEducativos($params);
					$convenio = json_decode($result->MantConveniosEducativosResult, true);

					header('Content-type: application/json; charset=utf-8');
					echo $json->encode(
						array(
							"vicon" 		=> $convenio[0]['v_icon'],
							"vtitle" 		=> $convenio[0]['v_title'],
							"vtext" 		=> $convenio[0]['v_text'],
							"itimer" 		=> $convenio[0]['i_timer'],
							"icase" 		=> $convenio[0]['i_case'],
							"vprogressbar" 	=> $convenio[0]['v_progressbar'],
							)
					);
					
				} else if (($ext_tarjeta[1] !== "" || $ext_tarjeta[1] !== null) && ($ext_ventana[1] == "" || $ext_ventana[1] == null) && $post > 1) {

					if (in_array($ext_tarjeta[1],$tipos_archivos)){

						// guardamos la imagen de tarjeta
						$destino_tarjeta = "public/dist/img/beneficios/convenios educativos/tarjeta/" . $nombre.$dia . "." . $ext_tarjeta[1];
		
						if (move_uploaded_file($_FILES["tarjeta"]["tmp_name"], $destino_tarjeta)){
		
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
								'post' 		=> $post,
								'id'		=> $id,
								'condicion' => $condicion,
								'nombre' 	=> $nombre,
								'estado' 	=> $estado,
								'finicio' 	=> $finicio,
								'ffin' 		=> $ffin,
								'tarjeta'	=> $destino_tarjeta,
								'ventana'	=> "",
								'user' 		=> $_SESSION['dni'],
							);
							$soap = new SoapClient($wsdl, $options);

							// eliminar imagen anterior (tarjeta)
							$parm1 = array(
								'post' 	=> 2, //0 -- consuta publicados, 1 --consultar todos, otro numero --consulta x id
								'id'	=> $id, // no se usa aqui
							);
							// convenios
							$result1 = $soap->ListarConveniosEducativos($parm1);
							$idconvenios = json_decode($result1->ListarConveniosEducativosResult, true);

							unlink($idconvenios[0]['v_tarjeta']);
				
							$result = $soap->MantConveniosEducativos($params);
							$convenio = json_decode($result->MantConveniosEducativosResult, true);

							header('Content-type: application/json; charset=utf-8');
							echo $json->encode(
								array(
									"vicon" 		=> $convenio[0]['v_icon'],
									"vtitle" 		=> $convenio[0]['v_title'],
									"vtext" 		=> $convenio[0]['v_text'],
									"itimer" 		=> $convenio[0]['i_timer'],
									"icase" 		=> $convenio[0]['i_case'],
									"vprogressbar" 	=> $convenio[0]['v_progressbar'],
									)
							);
		
						} else {
							// error al guardar las imagenes en la ruta
							header('Content-type: application/json; charset=utf-8');
							echo $json->encode(
								array(
									"vicon" 		=> "error",
									"vtitle" 		=> "No se encontro ruta de destino para el archivo...",
									"vtext" 		=> "Ruta no encontrada!",
									"itimer" 		=> 3000,
									"icase" 		=> 4, //"ruta no encontrada en el servidor";
									"vprogressbar" 	=> true,
									)
							);
						}
					} else {
						//echo 'tipo de archivos no admitidos';
						header('Content-type: application/json; charset=utf-8');
						echo $json->encode(
							array(
								"vicon" 		=> "error",
								"vtitle" 		=> "Tipo de archivo no admitivo...",
								"vtext" 		=> "Favor de elegir otro tipo de archivo!",
								"itimer" 		=> 3000,
								"icase" 		=> 5, //"tipo de archivo no permitido";
								"vprogressbar" 	=> true,
								)
						);
					}

				} else if (($ext_tarjeta[1] == "" || $ext_tarjeta[1] == null) && ($ext_ventana[1] !== "" || $ext_ventana[1] !== null) && $post > 1) {
					
					if (in_array($ext_ventana[1],$tipos_archivos_v)){

						// guardamos la imagen de ventana
						$destino_ventana = "public/dist/img/beneficios/convenios educativos/ventana/" . $nombre.$dia . "." . $ext_ventana[1];
		
						if (move_uploaded_file($_FILES["ventana"]["tmp_name"], $destino_ventana)){
		
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
								'post' 		=> $post,
								'id'		=> $id,
								'condicion' => $condicion,
								'nombre' 	=> $nombre,
								'estado' 	=> $estado,
								'finicio' 	=> $finicio,
								'ffin' 		=> $ffin,
								'tarjeta'	=> "",
								'ventana'	=> $destino_ventana,
								'user' 		=> $_SESSION['dni'],
							);
				
							$soap = new SoapClient($wsdl, $options);

							// eliminar imagen anterior (ventana)
							$parm1 = array(
								'post' 	=> 2, //0 -- consuta publicados, 1 --consultar todos, otro numero --consulta x id
								'id'	=> $id, // no se usa aqui
							);
							// convenios
							$result1 = $soap->ListarConveniosEducativos($parm1);
							$idconvenios = json_decode($result1->ListarConveniosEducativosResult, true);

							unlink($idconvenios[0]['v_ventana']);

							$result = $soap->MantConveniosEducativos($params);
							$convenio = json_decode($result->MantConveniosEducativosResult, true);
		
							header('Content-type: application/json; charset=utf-8');
							echo $json->encode(
								array(
									"vicon" 		=> $convenio[0]['v_icon'],
									"vtitle" 		=> $convenio[0]['v_title'],
									"vtext" 		=> $convenio[0]['v_text'],
									"itimer" 		=> $convenio[0]['i_timer'],
									"icase" 		=> $convenio[0]['i_case'],
									"vprogressbar" 	=> $convenio[0]['v_progressbar'],
									)
							);
		
						} else {
							// error al guardar las imagenes en la ruta
							header('Content-type: application/json; charset=utf-8');
							echo $json->encode(
								array(
									"vicon" 		=> "error",
									"vtitle" 		=> "No se encontro ruta de destino para el archivo...",
									"vtext" 		=> "Ruta no encontrada!",
									"itimer" 		=> 3000,
									"icase" 		=> 4, //"ruta no encontrada en el servidor";
									"vprogressbar" 	=> true,
									)
							);
						}
					} else {
						//echo 'tipo de archivos no admitidos';
						header('Content-type: application/json; charset=utf-8');
						echo $json->encode(
							array(
								"vicon" 		=> "error",
								"vtitle" 		=> "Tipo de archivo no admitivo...",
								"vtext" 		=> "Favor de elegir otro tipo de archivo!",
								"itimer" 		=> 3000,
								"icase" 		=> 5, //"tipo de archivo no permitido";
								"vprogressbar" 	=> true,
								)
						);
					}

				} else {

					if (in_array($ext_tarjeta[1],$tipos_archivos) && in_array($ext_ventana[1],$tipos_archivos_v)){

						// guardamos la imagen de tarjeta
						$destino_tarjeta = "public/dist/img/beneficios/convenios educativos/tarjeta/" . $nombre.$dia . "." . $ext_tarjeta[1];
						// guardamos la imagen de ventana
						$destino_ventana = "public/dist/img/beneficios/convenios educativos/ventana/" . $nombre.$dia . "." . $ext_ventana[1];
		
						if (move_uploaded_file($_FILES["tarjeta"]["tmp_name"], $destino_tarjeta) && move_uploaded_file($_FILES["ventana"]["tmp_name"], $destino_ventana)){
		
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
								'post' 		=> $post,
								'id'		=> $id,
								'condicion' => $condicion,
								'nombre' 	=> $nombre,
								'estado' 	=> $estado,
								'finicio' 	=> $finicio,
								'ffin' 		=> $ffin,
								'tarjeta'	=> $destino_tarjeta,
								'ventana'	=> $destino_ventana,
								'user' 		=> $_SESSION['dni'],
							);
				
							$soap = new SoapClient($wsdl, $options);

							// eliminar imagen anterior (tarjeta) y (ventana)
							$parm1 = array(
								'post' 	=> 2, //0 -- consuta publicados, 1 --consultar todos, otro numero --consulta x id
								'id'	=> $id, // no se usa aqui
							);
							// convenios
							$result1 = $soap->ListarConveniosEducativos($parm1);
							$idconvenios = json_decode($result1->ListarConveniosEducativosResult, true);

							unlink($idconvenios[0]['v_tarjeta']);
							unlink($idconvenios[0]['v_ventana']);

							$result = $soap->MantConveniosEducativos($params);
							$convenio = json_decode($result->MantConveniosEducativosResult, true);
		
							header('Content-type: application/json; charset=utf-8');
							echo $json->encode(
								array(
									"vicon" 		=> $convenio[0]['v_icon'],
									"vtitle" 		=> $convenio[0]['v_title'],
									"vtext" 		=> $convenio[0]['v_text'],
									"itimer" 		=> $convenio[0]['i_timer'],
									"icase" 		=> $convenio[0]['i_case'],
									"vprogressbar" 	=> $convenio[0]['v_progressbar'],
									)
							);
		
						} else {
							// error al guardar las imagenes en la ruta
							header('Content-type: application/json; charset=utf-8');
							echo $json->encode(
								array(
									"vicon" 		=> "error",
									"vtitle" 		=> "No se encontro ruta de destino para el archivo...",
									"vtext" 		=> "Ruta no encontrada!",
									"itimer" 		=> 3000,
									"icase" 		=> 4, //"ruta no encontrada en el servidor";
									"vprogressbar" 	=> true,
									)
							);
						}
					} else {
						//echo 'tipo de archivos no admitidos';
						header('Content-type: application/json; charset=utf-8');
						echo $json->encode(
							array(
								"vicon" 		=> "error",
								"vtitle" 		=> "Tipo de archivo no admitivo...",
								"vtext" 		=> "Favor de elegir otro tipo de archivo!",
								"itimer" 		=> 3000,
								"icase" 		=> 5, //"tipo de archivo no permitido";
								"vprogressbar" 	=> true,
								)
						);
					}

				}
			}
		} else {
			$this->redireccionar('index/logout');
		}
	}

}
