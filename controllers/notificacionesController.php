<?php
class notificacionesController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('planillas', 'notificaciones');

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
					//toastr
					'plugins/toastr/toastr.min',
					//fuentes
					'dist/css/fonts',
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
				//"cache_wsdl"=> WSDL_CACHE_BOTH,
				"connection_timeout" => 60,
				"trace" => false,
				"encoding" => "UTF-8",
				"exceptions" => false,
			);

			$soap = new SoapClient($wsdl, $options);

			// consultar notificacion
			$param1 = array(
				"post"		=> 1,  // listar datos en grilla
				"id"		=> 0,
			);

			$result1 = $soap->ListarNotificaciones($param1);
			$notificaciones = json_decode($result1->ListarNotificacionesResult, true);

			// construimos la tabla
			$filas = "";
			foreach ($notificaciones as $tb) {

				$td_desplegar = ($tb['v_subtitle'] == null || $tb['v_subtitle'] == "") && $tb['v_estado'] == 0 ? "<a id='" . $tb['i_id'] . "' class='btn btn-success btn-sm text-white desplegar'><i class='fa fa-check'></i></a>" : "<a></a>";
				$td_editar = ($tb['v_subtitle'] == null || $tb['v_subtitle'] == "") && $tb['v_estado'] == 0 ? "<a id='" . $tb['i_id'] . "' class='btn btn-warning btn-sm text-black editar'><i class='fa fa-edit'></i></a>" : "<a></a>";
				$td_eliminar = ($tb['v_subtitle'] == null || $tb['v_subtitle'] == "") && $tb['v_estado'] == 0 ? "<a id='" . $tb['i_id'] . "' class='btn btn-danger btn-sm text-white eliminar'><i class='fa fa-trash-alt'></i></a>" : "<a></a>";

				$filas .= "
				<tr>
					<td class='text-center'>" . $tb['i_id'] . "</td>
					<td class='text-center'>" . $tb['v_class'] . "</td>
					<td class='text-left'>" . $tb['v_title'] . "</td>
					<td class='text-left'>" . $tb['v_subtitle'] . "</td>
					<td class='text-left'>" . $tb['v_body'] . "</td>
					<td class='text-left'>" . $tb['v_description'] . "</td>
					<td class='text-left'>" . $tb['v_link'] . "</td>
					<td class='text-center'><span class='badge bg-" . $tb['v_estado_color'] . "'>" . $tb['v_estado'] . "</span></td>
					<td class='text-center'>" . $tb['d_creacion'] . "</td>
					<td class='text-center'>" . $tb['d_actualizacion'] . "</td>
					<td class='text-center'>
						" . $td_desplegar . "
					</td>
					<td class='text-center'>
						" . $td_editar . "
					</td>
					<td class='text-center'>
						" . $td_eliminar . "
					</td>
				</tr>
				";
			};

			// menus globales para notificaciones
			$param2 = array(
				"dato"	=> 0,  // listar datos en grilla
			);

			$result2 = $soap->ListarSubMenu($param2);
			$menunotificacion = json_decode($result2->ListarSubMenuResult, true);

			// consultar notificacion cumpleaños
			$param3 = array(
				"post"		=> 1,  // listar datos en grilla
				"id"		=> 0,
			);

			$result3 = $soap->ListarNotificumpleanios($param3);
			$notificumpleanios = json_decode($result3->ListarNotificumpleaniosResult, true);

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
			$this->_view->menunotificacion = $menunotificacion;
			$this->_view->notificumpleanios = $notificumpleanios;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function get_notificaciones()
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

			// consultar notificacion por id
			$param1 = array(
				"post"		=> 2,  // listar datos en grilla
				"id"		=> $id,
			);

			$result1 = $soap->ListarNotificaciones($param1);
			$notificacion = json_decode($result1->ListarNotificacionesResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"id" 			=> $notificacion[0]['i_id'],
					"color" 		=> $notificacion[0]['v_class'],
					"titulo" 		=> $notificacion[0]['v_title'],
					"mensaje" 		=> $notificacion[0]['v_body'],
					"descripcion" 	=> $notificacion[0]['v_description'],
					"modulo" 		=> $notificacion[0]['v_link'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	// MANTENIMIENTO NOTIFICACIONES
	public function mantenimiento_notificaciones()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$post = $_POST['post'];
			$id = $_POST['id']; // array sku
			$color = $_POST['color'];
			$titulo = $_POST['titulo'];
			$mensaje = $_POST['mensaje'];
			$descripcion = $_POST['descripcion'];
			$modulo = $_POST['modulo'];

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
				"post"				=> $post,
				"id"				=> $id,
				"clase"				=> $color,
				"titulo"			=> $titulo,
				"cuerpo"			=> $mensaje,
				"descripcion"		=> $descripcion,
				"modulo"			=> $modulo,
				"user"				=> $_SESSION['dni'],
			);

			$result1 = $soap->MantNotificaciones($param1);
			$mannotificaciones = json_decode($result1->MantNotificacionesResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"vicon" 		=> $mannotificaciones[0]['v_icon'],
					"vtitle" 		=> $mannotificaciones[0]['v_title'],
					"vtext" 		=> $mannotificaciones[0]['v_text'],
					"itimer" 		=> $mannotificaciones[0]['i_timer'],
					"icase" 		=> $mannotificaciones[0]['i_case'],
					"vprogressbar" 	=> $mannotificaciones[0]['v_progressbar'],
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
					"vventana" 	=> BASE_URL . "public/dist/img/cumpleanios/ventana-no-disponible.jpg",
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function mantenimiento_cumple_img()
	{
		if (isset($_SESSION['usuario'])) {

			date_default_timezone_set("America/Lima");

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$dia =  strval(date("YmdHis"));

			$post = $_POST['post'];
			$id = $_POST['id'];
			$condicion = $_POST['condicion'];
			$nombre = $_POST['nombre'];
			$estado = $_POST['estado'];

			$ext_ventana = explode("/", $_FILES["ventana"]["type"]);

			$tipos_archivos = array('jpg', 'png', 'jpeg');

			if (in_array($ext_ventana[1], $tipos_archivos)) {

				// guardamos la imagen de ventana
				$destino_ventana = "public/dist/img/cumpleanios/ventana/" . $nombre . $dia . "." . $ext_ventana[1];

				if (move_uploaded_file($_FILES["ventana"]["tmp_name"], $destino_ventana)) {

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
						'ventana'	=> $destino_ventana,
						'user' 		=> $_SESSION['dni'],
					);

					$soap = new SoapClient($wsdl, $options);
					$result = $soap->MantNotificumpleanios($params);
					$convenio = json_decode($result->MantNotificumpleaniosResult, true);

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

	public function mantenimiento_cumple_img_datos()
	{
		if (isset($_SESSION['usuario'])) {

			date_default_timezone_set("America/Lima");

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$dia =  strval(date("YmdHis"));

			$post = $_POST['post'];
			$id = $_POST['id'];
			$condicion = $_POST['condicion'];
			$nombre = $_POST['nombre'];
			$estado = $_POST['estado'];

			$ext_ventana = explode("/", $_FILES["ventana"]["type"]);

			$tipos_archivos = array('jpg', 'png', 'jpeg');

			if ($post == 3) {	// delete

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
					'ventana'	=> "",
					'user' 		=> $_SESSION['dni'],
				);

				$soap = new SoapClient($wsdl, $options);
				$result = $soap->MantNotificumpleanios($params);
				$notificumpleanios = json_decode($result->MantNotificumpleaniosResult, true);

				header('Content-type: application/json; charset=utf-8');
				echo $json->encode(
					array(
						"vicon" 		=> $notificumpleanios[0]['v_icon'],
						"vtitle" 		=> $notificumpleanios[0]['v_title'],
						"vtext" 		=> $notificumpleanios[0]['v_text'],
						"itimer" 		=> $notificumpleanios[0]['i_timer'],
						"icase" 		=> $notificumpleanios[0]['i_case'],
						"vprogressbar" 	=> $notificumpleanios[0]['v_progressbar'],
					)
				);
			} else {

				if (($ext_ventana[1] == "" || $ext_ventana[1] == null) && $post > 1) {

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
						'ventana'	=> "",
						'user' 		=> $_SESSION['dni'],
					);

					$soap = new SoapClient($wsdl, $options);
					$result = $soap->MantNotificumpleanios($params);
					$notificumpleanios = json_decode($result->MantNotificumpleaniosResult, true);

					header('Content-type: application/json; charset=utf-8');
					echo $json->encode(
						array(
							"vicon" 		=> $notificumpleanios[0]['v_icon'],
							"vtitle" 		=> $notificumpleanios[0]['v_title'],
							"vtext" 		=> $notificumpleanios[0]['v_text'],
							"itimer" 		=> $notificumpleanios[0]['i_timer'],
							"icase" 		=> $notificumpleanios[0]['i_case'],
							"vprogressbar" 	=> $notificumpleanios[0]['v_progressbar'],
						)
					);
				} else if (($ext_ventana[1] !== "" || $ext_ventana[1] !== null) && $post > 1) {

					if (in_array($ext_ventana[1], $tipos_archivos)) {

						// guardamos la imagen de ventana
						$destino_ventana = "public/dist/img/cumpleanios/ventana/" . $nombre . $dia . "." . $ext_ventana[1];

						if (move_uploaded_file($_FILES["ventana"]["tmp_name"], $destino_ventana)) {

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
							$result1 = $soap->ListarNotificumpleanios($parm1);
							$idcumple = json_decode($result1->ListarNotificumpleaniosResult, true);

							unlink($idcumple[0]['v_ventana']);

							$result = $soap->MantNotificumpleanios($params);
							$notificumpleanios = json_decode($result->MantNotificumpleaniosResult, true);

							header('Content-type: application/json; charset=utf-8');
							echo $json->encode(
								array(
									"vicon" 		=> $notificumpleanios[0]['v_icon'],
									"vtitle" 		=> $notificumpleanios[0]['v_title'],
									"vtext" 		=> $notificumpleanios[0]['v_text'],
									"itimer" 		=> $notificumpleanios[0]['i_timer'],
									"icase" 		=> $notificumpleanios[0]['i_case'],
									"vprogressbar" 	=> $notificumpleanios[0]['v_progressbar'],
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
					if (in_array($ext_ventana[1], $tipos_archivos)) {

						// guardamos la imagen de ventana
						$destino_ventana = "public/dist/img/cumpleanios/ventana/" . $nombre . $dia . "." . $ext_ventana[1];

						if (move_uploaded_file($_FILES["ventana"]["tmp_name"], $destino_ventana)) {

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
							$result1 = $soap->ListarNotificumpleanios($parm1);
							$idcumple = json_decode($result1->ListarNotificumpleaniosResult, true);

							unlink($idcumple[0]['v_ventana']);

							$result = $soap->MantNotificumpleanios($params);
							$notificumpleanios = json_decode($result->MantNotificumpleaniosResult, true);

							header('Content-type: application/json; charset=utf-8');
							echo $json->encode(
								array(
									"vicon" 		=> $notificumpleanios[0]['v_icon'],
									"vtitle" 		=> $notificumpleanios[0]['v_title'],
									"vtext" 		=> $notificumpleanios[0]['v_text'],
									"itimer" 		=> $notificumpleanios[0]['i_timer'],
									"icase" 		=> $notificumpleanios[0]['i_case'],
									"vprogressbar" 	=> $notificumpleanios[0]['v_progressbar'],
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
			$result = $soap->ListarNotificumpleTexto($params);
			$listanotificumpledisenio = json_decode($result->ListarNotificumpleTextoResult, true);

			// construimos la tabla
			$filas = "";
			foreach ($listanotificumpledisenio as $dv) {
				$filas .= "
				<tr>
					<td class='text-center'>" . $dv['i_id'] . "</td>
					<td class='text-center'>" . $dv['i_notifi'] . "</td>
					<td class='text-left'>" . $dv['v_texto'] . "</td>
					<td class='text-center'>" . $dv['i_tamanio'] . "</td>
					<td class='text-center' style='color:" . $dv['v_color'] . "; background-color: rgb(205,205,205);'><i class='fas fa-square'></i>&nbsp;&nbsp;" . $dv['v_color'] . "</td>
					<td class='text-center'>" . $dv['i_angulo'] . "</td>
					<td class='text-center'>" . $dv['i_posicionx'] . "</td>
					<td class='text-center'>" . $dv['i_posiciony'] . "</td>
					<td class='text-center'>" . $dv['i_alineacion'] . "</td>
					<td class='text-center'>" . $dv['v_fuente'] . "</td>
					<td><a id=" . $dv['i_id'] . " href='#' class='btn btn-kimbo btn-sm text-white editar-data'><i class='fas fa-edit'></i></a></td>
      				<td><a id=" . $dv['i_id'] . " href='#' class='btn btn-danger btn-sm text-white delete-data'><i class='fas fa-trash-can'></i></a></td>
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

				$salida = "public/dist/img/cumpleanios/ventana/" . $nombre . ".jpg";

				imagejpeg($img2, $salida);
				imagedestroy($img2);

				$div_new = "
				<div id='draw-img' style='border-radius: 10px; -webkit-border-radius: 10px;'>
					<img id='img-refresh' class='card-img-top' style='border:1px solid black; -webkit-border-radius: 10px;' src='" . BASE_URL . $salida . "'>
				</div>
				";
			} else {
				// obtener imagen principal
				$div_new = "
				<div id='draw-img' style='border-radius: 10px; -webkit-border-radius: 10px;'>
					<img id='img-refresh' class='card-img-top' style='border:1px solid black; -webkit-border-radius: 10px;' src='" . BASE_URL . $imgcumple[0]['v_ventana'] . "'>
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

	public function imagen_refresh()
	{
		if (isset($_SESSION['usuario'])) {

			date_default_timezone_set("America/Lima");

			$id = $_POST['idcon'];

			$text1 = $_POST['texto'];
			$size1 = $_POST['size'];
			$color1 = $_POST['color'];
			$colornew1 = str_replace("#", "", $color1);

			$angle1 = $_POST['angle'];
			$x1 = $_POST['x'];
			$y1 = $_POST['y'];
			$aling = $_POST['aling'];
			$font = $_POST['font'];

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
			$result = $soap->ListarNotificumpleTexto($params);
			$listanotificumpledisenio = json_decode($result->ListarNotificumpleTextoResult, true);

			$parm1 = array(
				'post' 	=> 2, //0 -- consuta publicados, 1 --consultar todos, otro numero --consulta x id
				'id'	=> $id, // id para armar el div de imagen
			);

			$result1 = $soap->ListarNotificumpleanios($parm1);
			$imgcumple = json_decode($result1->ListarNotificumpleaniosResult, true);

			header("Content-type: image/jpeg");

			$nombre =  strval(date("YmdHis"));

			function datos_globales($xtring)
			{
				$string = str_replace(
					array(
						'[usuario]', '[dni]', '[nombre]', '[perfil]', '[razon]', '[ruc]', '[nombrecomercial]',
						'[fecha]', '[fechahora]', '[cargo]', '[nombres]', '[apellidos]'
					),
					array(
						$_SESSION['usuario'], $_SESSION['dni'], $_SESSION['nombre'], $_SESSION['perfil'], 'VERDUM PERÚ S.A.C.', ruc, nombrecomercial,
						fechasis, fechahorasis, $_SESSION['cargo'], $_SESSION['nombres'], $_SESSION['apellidos']
					),
					$xtring
				);
				return $string;
			}

			$fuente =  __DIR__ . "/fonts/" . $font . ".ttf";
			$img2 = imagecreatefromjpeg($imgcumple[0]['v_ventana']);

			if (count($listanotificumpledisenio) > 0) {

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
					$fuentex =  __DIR__ . "/fonts/" . $dsn['v_fuente'] . ".ttf";

					if ($dsn['i_alineacion'] == "Centrado") {
						// longitud del texto
						$xtext = imageftbbox($dsn['i_tamanio'], $dsn['i_angulo'], $fuentex, $textnew);

						// posiscion del texto centrado
						$x = $xtext[0] + (imagesx($img2) / 2) - ($xtext[4] / 2) - (($dsn['i_tamanio']) / 2);
						// $y = $xtext[1] + (imagesy($img2) / 2) - ($xtext[5] / 2) - (($dsn['i_tamanio'])/2);

						imagettftext($img2, $dsn['i_tamanio'], $dsn['i_angulo'], $x, $dsn['i_posiciony'], $black, $fuentex, $textnew);
					} else {
						imagettftext($img2, $dsn['i_tamanio'], $dsn['i_angulo'], $dsn['i_posicionx'], $dsn['i_posiciony'], $black, $fuentex, $textnew);
					}
				}

				$textnew1 = datos_globales($text1);
				$black1 = imagecolorallocate($img2, $r1, $g1, $b1);

				if ($aling == 1) {
					// longitud del texto
					$xtext = imageftbbox($size1, $angle1, $fuente, $textnew1);

					// posiscion del texto centrado
					$x = $xtext[0] + (imagesx($img2) / 2) - ($xtext[4] / 2) - (($size1) / 2);
					// $y = $xtext[1] + (imagesy($img2) / 2) - ($xtext[5] / 2) - (($size1)/2);

					imagettftext($img2, $size1, $angle1, $x, $y1, $black1, $fuente, $textnew1);
				} else {
					imagettftext($img2, $size1, $angle1, $x1, $y1, $black1, $fuente, $textnew1);
				}

				$salida = "public/dist/img/cumpleanios/ventana/" . $nombre . ".jpg";

				imagepng($img2, $salida);
				imagedestroy($img2);

				$div_new = "
				<div id='draw-img' style='border-radius: 10px; -webkit-border-radius: 10px;'>
					<img id='img-refresh' class='card-img-top' style='border:1px solid black; -webkit-border-radius: 10px;' src='" . BASE_URL . $salida . "'>
				</div>
				";
			} else {

				$textnew1 = datos_globales($text1);
				$black1 = imagecolorallocate($img2, $r1, $g1, $b1);

				if ($aling == 1) {
					// longitud del texto
					$xtext = imageftbbox($size1, $angle1, $fuente, $textnew1);

					// posiscion del texto centrado
					$x = $xtext[0] + (imagesx($img2) / 2) - ($xtext[4] / 2) - (($size1) / 2);
					// $y = $xtext[1] + (imagesy($img2) / 2) - ($xtext[5] / 2) - (($size1)/2);

					imagettftext($img2, $size1, $angle1, $x, $y1, $black1, $fuente, $textnew1);
				} else {
					imagettftext($img2, $size1, $angle1, $x1, $y1, $black1, $fuente, $textnew1);
				}

				$salida = "public/dist/img/cumpleanios/ventana/" . $nombre . ".jpg";

				imagepng($img2, $salida);
				imagedestroy($img2);

				$div_new = "
				<div id='draw-img' style='border-radius: 10px; -webkit-border-radius: 10px;'>
					<img id='img-refresh' class='card-img-top' style='border:1px solid black; -webkit-border-radius: 10px;' src='" . BASE_URL . $salida . "'>
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
			unlink("public/dist/img/cumpleanios/ventana/" . $nombre . ".jpg");
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
			$icumple = $_POST['idcon']; // id convenio
			$text = $_POST['texto']; // texto
			$size = $_POST['size']; // tamaño
			$color = $_POST['color']; // color en hexadecimal
			$colornew = str_replace("#", "", $color);
			$angle = $_POST['angle']; // angulo
			$x = $_POST['x']; // posicion x
			$y = $_POST['y']; // posicion y
			$align = $_POST['align']; // alineacion de texto
			$font = $_POST['font']; // fuente letra de texto

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
				'icumple' 	=> $icumple,
				'texto' 	=> $text,
				'tamanio' 	=> $size,
				'color' 	=> $color,
				'r'			=> $r,
				'g'			=> $g,
				'b'			=> $b,
				'angulo'	=> $angle,
				'posicionx'	=> $x,
				'posiciony'	=> $y,
				'alineacion' => $align,
				'fuente'	=> $font,
				'user' 		=> $_SESSION['dni'],
			);

			// insertar diseño en BD
			$soap = new SoapClient($wsdl, $options);
			$result = $soap->MantNotificumpleaniosTexto($params);
			$cumpleaniostexto = json_decode($result->MantNotificumpleaniosTextoResult, true);

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"vicon" 		=> $cumpleaniostexto[0]['v_icon'],
					"vtitle" 		=> $cumpleaniostexto[0]['v_title'],
					"vtext" 		=> $cumpleaniostexto[0]['v_text'],
					"itimer" 		=> $cumpleaniostexto[0]['i_timer'],
					"icase" 		=> $cumpleaniostexto[0]['i_case'],
					"vprogressbar" 	=> $cumpleaniostexto[0]['v_progressbar'],
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
			// cumpleanios
			$result1 = $soap->ListarNotificumpleanios($parm1);
			$cumpleanios = json_decode($result1->ListarNotificumpleaniosResult, true);

			$div_ventana = "
			<div id='draw-img' style='border-radius: 10px; -webkit-border-radius: 10px;'>
				<img id='ruta-imagen-ventana1' class='card-img-top' style='border:1px solid black; -webkit-border-radius: 10px;' src='" . BASE_URL . $cumpleanios[0]['v_ventana'] . "'>
			</div>
			";

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"id" 			=> $cumpleanios[0]['i_id'],
					"nombre" 		=> $cumpleanios[0]['v_nombre'],
					"ventana" 		=> $div_ventana,
					"estado" 		=> $cumpleanios[0]['i_estado'],
					"condicion" 	=> $cumpleanios[0]['i_condicion'],
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
			$result = $soap->ListarDisenioNotificumpleTexto($params);
			$listanotificumpledisenio = json_decode($result->ListarDisenioNotificumpleTextoResult, true);

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"id" 			=> $listanotificumpledisenio[0]['i_id'],
					"icumple" 		=> $listanotificumpledisenio[0]['i_notifi'],
					"vtexto" 		=> $listanotificumpledisenio[0]['v_texto'],
					"itamanio" 		=> $listanotificumpledisenio[0]['i_tamanio'],
					"vcolor" 		=> $listanotificumpledisenio[0]['v_color'],
					"iangulo"		=> $listanotificumpledisenio[0]['i_angulo'],
					"iposicionx" 	=> $listanotificumpledisenio[0]['i_posicionx'],
					"iposiciony" 	=> $listanotificumpledisenio[0]['i_posiciony'],
					"ialineacion" 	=> $listanotificumpledisenio[0]['i_alineacion'],
					"vfuente"		=> $listanotificumpledisenio[0]['v_fuente'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}
}
