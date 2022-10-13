<?php

class conarchivosController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('configuracion', 'conarchivos');

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

	// --- ARCHIVOS BEGIN ---
	public function archivos()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('configuracion', 'conarchivos');

			$this->_view->setCss_Specific(
				array(
					'plugins/fontawesome-free/css/all.min',
					'plugins/overlayScrollbars/css/OverlayScrollbars.min',
					'dist/css/adminlte',
					//DataTables>
					'plugins/datatables-responsive/css/responsive.bootstrap4.min',
					'plugins/datatables-net/css/jquery.dataTables.min',
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

			// ARMAMOS TABLA ARCHIVOS GLOBALES
			$params1 = array(
				'post' 	=> 1, // para listar solo los tipos de archivos
				'id'	=> 0, // no se usa (id)
				'mime'	=> "",
				'type'	=> "",
			);

			$result1 = $soap->ListarTipoArchivos($params1);
			$tipoarchivo = json_decode($result1->ListarTipoArchivosResult, true);

			// construimos la tabla
			$tb_archivos = "";
			foreach ($tipoarchivo as $dv) {
				$tb_archivos .= "
				<tr>
					<td class='text-center'>" . $dv['i_id'] . "</td>
					<td class='text-left'>" . $dv['v_archivo'] . "</td>
					<td class='text-left'>" . $dv['v_mime'] . "</td>
					<td class='text-left'>" . $dv['v_type'] . "</td>
					<td class='text-left'>" . $dv['v_icono'] . "</td>
					<td class='text-left'>" . $dv['v_color'] . "</td>
					<td class='text-left'>" . $dv['d_creacion'] . "</td>
					<td class='text-left'>" . $dv['d_actualizacion'] . "</td>
					<td><a id=" . $dv['i_id'] . " href='#' class='btn btn-warning btn-sm text-black editar-data'><i class='fas fa-edit'></i></a></td>
				</tr>
				";
			};

			// <td><a id=".$dv['i_id']." href='#' class='btn btn-danger btn-sm text-white delete-data'><i class='fas fa-trash-can'></i></a></td>

			// NOTIFICACIONES TOTAL
			$param100 = array(
				"post"	=> 2,  	// consultar por DNI para obtener cantidad de notificaciones
				"top"	=> 0,	// no se usa para esta consulta
				"dni"	=> $_SESSION['dni'],
			);

			$result100 = $soap->ListarPaNotificaciones($param100);
			$countnoti = json_decode($result100->ListarPaNotificacionesResult, true);

			$_SESSION['num_notificaciones'] = intval($countnoti[0]['i_delay']);

			$this->_view->tb_archivos = $tb_archivos;

			$this->_view->setJs(array('archivos'));
			$this->_view->renderizar('archivos');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function obtener_tipoarchivo()
	{

		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$id = $_POST['cod'];

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
				'post' 	=> 2, // para consultar archivo por id
				'id'	=> $id, // (id)
				'mime'	=> "",
				'type'	=> "",
			);

			$result2 = $soap->ListarTipoArchivos($params);
			$archivo = json_decode($result2->ListarTipoArchivosResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"v_archivo" => $archivo[0]['v_archivo'],
					"v_mime" => $archivo[0]['v_mime'],
					"v_type" => $archivo[0]['v_type'],
					"v_icono" => $archivo[0]['v_icono'],
					"v_color" => $archivo[0]['v_color'],
					"d_creacion" => $archivo[0]['d_creacion'],
					"d_actualizacion" => $archivo[0]['d_actualizacion'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function mantenimiento_archivos()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$post = $_POST['post'];
			$id = $_POST['id'];
			$nombre = $_POST['nombre'];
			$mime = $_POST['mime'];
			$type = $_POST['type'];
			$icono = $_POST['icono'];
			$color = $_POST['color'];

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
				'id' 		=> $id,
				'nombre' 	=> $nombre,
				'mime' 		=> $mime,
				'type' 		=> $type,
				'icono' 	=> $icono,
				'color' 	=> $color,
				'dni' 		=> $_SESSION['dni'],
			);
			$result = $soap->MantArchivos($params);
			$mantarchivo = json_decode($result->MantArchivosResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"vicon" 		=> $mantarchivo[0]['v_icon'],
					"vtitle" 		=> $mantarchivo[0]['v_title'],
					"vtext" 		=> $mantarchivo[0]['v_text'],
					"itimer" 		=> $mantarchivo[0]['i_timer'],
					"icase" 		=> $mantarchivo[0]['i_case'],
					"vprogressbar" 	=> $mantarchivo[0]['v_progressbar'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}
	// --- ARCHIVOS END ---

	// --- DOCUMENTOS BEGIN ---
	public function legajo()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('configuracion', 'conarchivos');

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
				"connection_timeout" => 60,
				"trace" => false,
				"encoding" => "UTF-8",
				"exceptions" => false,
			);

			$soap = new SoapClient($wsdl, $options);

			// ARMAMOS TABLA CONFIGURACION LEGAJO
			$params1 = array(
				'post' 	=> 1, // para listar todos los documentos
				'id'	=> 0, // no se usa (id)
				'dni'	=> "", // aqui no se usa dni 
			);

			$result1 = $soap->Listacombodocumentos($params1);
			$legajodoc = json_decode($result1->ListacombodocumentosResult, true);

			// construimos la tabla
			$tb_legajo = "";
			foreach ($legajodoc as $lj) {

				$tb_files = explode(",", $lj['v_type_archivo']);
				$span = "";
				$i = 0;
				foreach ($tb_files as $vl) {

					$params2[$i] = array(
						'post' 	=> 2, // para listar tipos de archivos para combo
						'id'	=> $vl, // no se usa (id)
						'mime'	=> "",
						'type'	=> "",
					);

					$result2 = $soap->ListarTipoArchivos($params2[$i]);
					$filecb = json_decode($result2->ListarTipoArchivosResult, true);

					$span .= "<span class='badge bg-" . $filecb[$i]['v_color'] . "'>*." . $filecb[$i]['v_archivo'] . "</span>" . " ";
					// $span .= "<a class='btn btn-" . $filecb[$i]['v_color'] . " btn-sm text-white'><i class='" . $filecb[$i]['v_icono'] . "'></i><b></a>" . " ";
					
				}
				$i++;

				$tb_legajo .= "
				<tr>
					<td class='text-center'>" . $lj['i_id'] . "</td>
					<td class='text-left'>" . $lj['v_nombre'] . "</td>
					<td class='text-left'>" . $lj['v_carpeta'] . "</td>
					<td class='text-left'>" . $lj['v_modulo'] . "</td>
					<td class='text-center'><span class='badge bg-" . $lj['v_color_estado'] . "'>" . $lj['v_estado'] . "</span></td>
					<td class='text-left'>" . $span . "</td>
					<td class='text-center'><span class='badge bg-" . $lj['v_color_cantidad'] . "'>" . $lj['v_cantidad'] . "</span></td>
					<td class='text-right'>" . (floor($lj['f_size']) / 1024) . " Mb</td>
					<td class='text-left'>" . $lj['d_fecha_actualiza'] . "</td>
					<td><a id=" . $lj['i_id'] . " href='#' class='btn btn-warning btn-sm text-black editar-data'><i class='fas fa-edit'></i></a></td>
				</tr>
				";
			};

			// <td><a id=" . $lj['i_id'] . " href='#' class='btn btn-danger btn-sm text-white delete-data'><i class='fas fa-trash-can'></i></a></td>

			// ARMAMOS COMBO PARA TIPOS DE ARCHIVOS
			$params2 = array(
				'post' 	=> 1, // para listar tipos de archivos para combo
				'id'	=> 0, // no se usa (id)
				'mime'	=> "",
				'type'	=> "",
			);

			$result2 = $soap->ListarTipoArchivos($params2);
			$combolegajo = json_decode($result2->ListarTipoArchivosResult, true);

			$filascombo = "";
			foreach ($combolegajo as $cb) {
				$filascombo .= "<option value=" . $cb['i_id'] . ">" . $cb['v_archivo'] . "</option>";
			}

			// NOTIFICACIONES TOTAL
			$param100 = array(
				"post"	=> 2,  	// consultar por DNI para obtener cantidad de notificaciones
				"top"	=> 0,	// no se usa para esta consulta
				"dni"	=> $_SESSION['dni'],
			);

			$result100 = $soap->ListarPaNotificaciones($param100);
			$countnoti = json_decode($result100->ListarPaNotificacionesResult, true);

			$_SESSION['num_notificaciones'] = intval($countnoti[0]['i_delay']);

			$this->_view->tb_legajo = $tb_legajo;
			$this->_view->filascombo = $filascombo;

			$this->_view->setJs(array('legajo'));
			$this->_view->renderizar('legajo');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function construir_combo()
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

			// ARMAMOS COMBO PARA TIPOS DE ARCHIVOS
			$params1 = array(
				'post' 	=> 1, // para listar tipos de archivos para combo
				'id'	=> 0, // no se usa (id)
				'mime'	=> "",
				'type'	=> "",
			);

			$result1 = $soap->ListarTipoArchivos($params1);
			$combolegajo = json_decode($result1->ListarTipoArchivosResult, true);

			$filascombo = "";
			foreach ($combolegajo as $cb) {
				$filascombo .= "<option value=" . $cb['i_id'] . ">" . $cb['v_archivo'] . "</option>";
			}

			echo $filascombo;
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function obtener_archivolegajo()
	{

		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$id = $_POST['cod'];

			function html_caracteres($string)
			{
				$string = str_replace(
					array('&amp;', '&Ntilde;', '&Aacute;', '&Eacute;', '&Iacute;', '&Oacute;', '&Uacute;'),
					array('&', 'Ñ', 'Á', 'É', 'Í', 'Ó', 'Ú'),
					$string
				);
				return $string;
			}

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

			// obtener datos
			$params1 = array(
				'post' 	=> 3, // para listar todos los documentos
				'id'	=> $id, // se usa (id)
				'dni'	=> "", // aqui no se usa dni 
			);

			$result1 = $soap->Listacombodocumentos($params1);
			$legajodoc = json_decode($result1->ListacombodocumentosResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"v_nombre" => html_caracteres($legajodoc[0]['v_nombre']),
					"v_carpeta" => $legajodoc[0]['v_carpeta'],
					"i_estado" => $legajodoc[0]['i_estado'],
					"v_type_archivo" => explode(',', $legajodoc[0]['v_type_archivo']),
					"i_cantidad" => $legajodoc[0]['i_cantidad'],
					"f_size" => ($legajodoc[0]['f_size'] / 1024),
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function mantenimiento_archivos_legajo()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$post = $_POST['post'];
			$id = $_POST['id'];
			$nombre = $_POST['nombre'];
			$carpeta = $_POST['carpeta'];
			$modulo = $_POST['modulo'];
			$estado = $_POST['estado'];
			$cantidad = $_POST['cantidad'];
			$tipoarchivo = $_POST['tipoarchivo']; //array con datos
			$tamanio = $_POST['tamanio'];

			// convertir array a string para insert
			$mewtipoarchivo = implode(",", $tipoarchivo);

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

			if ($post == 1) { // insert

				// validamos que no exista el nombre de la carpeta
				$micarpeta = "public/doc/" . trim($carpeta);
				if (!is_dir($micarpeta)) {

					// creamos carpeta
					mkdir($micarpeta, 0777, true);

					$params = array(
						'post' 			=> $post,
						'id' 			=> $id,
						'nombre' 		=> $nombre,
						'carpeta' 		=> $carpeta,
						'modulo' 		=> $modulo,
						'estado' 		=> $estado,
						'cantidad' 		=> $cantidad,
						'tipoarchivo' 	=> $mewtipoarchivo,
						'tamanio' 		=> $tamanio,
						'dni' 			=> $_SESSION['dni'],
					);
					$result = $soap->MantArchivosLegajo($params);
					$mantarchivo = json_decode($result->MantArchivosLegajoResult, true);

					header('Content-type: application/json; charset=utf-8');

					echo $json->encode(
						array(
							"vicon" 		=> $mantarchivo[0]['v_icon'],
							"vtitle" 		=> $mantarchivo[0]['v_title'],
							"vtext" 		=> $mantarchivo[0]['v_text'],
							"itimer" 		=> $mantarchivo[0]['i_timer'],
							"icase" 		=> $mantarchivo[0]['i_case'],
							"vprogressbar" 	=> $mantarchivo[0]['v_progressbar'],
						)
					);
				} else {
					header('Content-type: application/json; charset=utf-8');

					echo $json->encode(
						array(
							"vicon" 		=> "error",
							"vtitle" 		=> "Carpeta ya existe en el sistema",
							"vtext" 		=> "La carpeta que esta tratando de crear ya existe, favor de cambiarla para guardar..!!",
							"itimer" 		=> 6000,
							"icase" 		=> 5,
							"vprogressbar" 	=> "true",
						)
					);
				}
			} else if ($post == 2) { // update

				$params = array(
					'post' 			=> $post,
					'id' 			=> $id,
					'nombre' 		=> $nombre,
					'carpeta' 		=> $carpeta,
					'modulo' 		=> $modulo,
					'estado' 		=> $estado,
					'cantidad' 		=> $cantidad,
					'tipoarchivo' 	=> $mewtipoarchivo,
					'tamanio' 		=> $tamanio,
					'dni' 			=> $_SESSION['dni'],
				);
				$result = $soap->MantArchivosLegajo($params);
				$mantarchivo = json_decode($result->MantArchivosLegajoResult, true);

				header('Content-type: application/json; charset=utf-8');

				echo $json->encode(
					array(
						"vicon" 		=> $mantarchivo[0]['v_icon'],
						"vtitle" 		=> $mantarchivo[0]['v_title'],
						"vtext" 		=> $mantarchivo[0]['v_text'],
						"itimer" 		=> $mantarchivo[0]['i_timer'],
						"icase" 		=> $mantarchivo[0]['i_case'],
						"vprogressbar" 	=> $mantarchivo[0]['v_progressbar'],
					)
				);
			}
		} else {
			$this->redireccionar('index/logout');
		}
	}
	// --- DOCUMENTOS END ---

	public function dato()
	{

		// $valor = "jpeg,png,jpg,pdf";

		// $array = explode(",", $valor);
		// $array2 = ['jpg','png','gif','pdf'];

		// $JsonObject = json_encode($array);
		// $existe = in_array("xls", $array) ? 'existe': 'no existe';

		// echo $JsonObject;
		// echo $existe;

		$filename = "./anunciosController.php";
		$archivo = mime_content_type($filename);

		var_dump($archivo);

		// var_dump($array).'<b/>';
		// var_dump($array2);

		$mimet = array(
			'txt' => 'text/plain',
			'htm' => 'text/html',
			'html' => 'text/html',
			'php' => 'text/html',
			'css' => 'text/css',
			'js' => 'application/javascript',
			'json' => 'application/json',
			'xml' => 'application/xml',
			'swf' => 'application/x-shockwave-flash',
			'flv' => 'video/x-flv',

			// images
			'png' => 'image/png',
			'jpe' => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'jpg' => 'image/jpeg',
			'gif' => 'image/gif',
			'bmp' => 'image/bmp',
			'ico' => 'image/vnd.microsoft.icon',
			'tiff' => 'image/tiff',
			'tif' => 'image/tiff',
			'svg' => 'image/svg+xml',
			'svgz' => 'image/svg+xml',

			// archives
			'zip' => 'application/zip',
			'rar' => 'application/x-rar-compressed',
			'exe' => 'application/x-msdownload',
			'msi' => 'application/x-msdownload',
			'cab' => 'application/vnd.ms-cab-compressed',

			// audio/video
			'mp3' => 'audio/mpeg',
			'qt' => 'video/quicktime',
			'mov' => 'video/quicktime',

			// adobe
			'pdf' => 'application/pdf',
			'psd' => 'image/vnd.adobe.photoshop',
			'ai' => 'application/postscript',
			'eps' => 'application/postscript',
			'ps' => 'application/postscript',

			// ms office
			'doc' => 'application/msword',
			'rtf' => 'application/rtf',
			'xls' => 'application/vnd.ms-excel',
			'ppt' => 'application/vnd.ms-powerpoint',
			'docx' => 'application/msword',
			'xlsx' => 'application/vnd.ms-excel',
			'pptx' => 'application/vnd.ms-powerpoint',


			// open office
			'odt' => 'application/vnd.oasis.opendocument.text',
			'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
		);
	}
}
