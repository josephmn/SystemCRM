<?php

class documentosController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{

		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('documentopay', 'documentos');

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
				//"cache_wsdl"=> WSDL_CACHE_BOTH,
				"connection_timeout" => 60,
				"trace" => false,
				"encoding" => "UTF-8",
				"exceptions" => false,
			);

			$soap = new SoapClient($wsdl, $options);

			$param1 = array(
				"dni" => $_SESSION['dni'],
			);

			$result1 = $soap->ListadoDocumentosPersonal($param1);
			$document_personal = json_decode($result1->ListadoDocumentosPersonalResult, true);

			// construir tabla de legajo del personal
			$tb_legajo = "";
			foreach ($document_personal as $dp) {
				$tb_legajo .= "
				<tr>
					<td class='text-center'>" . $dp['ID'] . "</td>
					<td class='text-left'>" . $dp['NOMBRE'] . "</td>
					<td class='text-center'><a class='btn btn-" . $dp['COLOR'] . " btn-sm' target='_blank' style='color:white' href='" . BASE_URL . $dp['DIRECTORIO'] . "'><i class='" . $dp['ICONO'] . "'></i></td>
					<td class='text-center'>" . $dp['FECHA'] . "</td>
					<td class='text-center'>
						<a id='" . $dp['ID'] . "' name='" . $dp['NOMBRE'] . "' class='btn btn-danger btn-sm text-white eliminar'><i class='fa fa-trash-alt'></i>
					</td>
				</tr>
				";
			};

			$param2 = array(
				"post"	=> 2, // listado de combo para personal
				"id" 	=> 0, // no se usa id
				"dni" 	=> $_SESSION['dni'],
			);

			$result = $soap->Listacombodocumentos($param2);
			$cbosustento = json_decode($result->ListacombodocumentosResult, true);

			// NOTIFICACIONES TOTAL
			$param100 = array(
				"post"	=> 2,  	// consultar por DNI para obtener cantidad de notificaciones
				"top"	=> 0,	// no se usa para esta consulta
				"dni"	=> $_SESSION['dni'],
			);

			$result100 = $soap->ListarPaNotificaciones($param100);
			$countnoti = json_decode($result100->ListarPaNotificacionesResult, true);

			$_SESSION['num_notificaciones'] = intval($countnoti[0]['i_delay']);

			$this->_view->cbosustento = $cbosustento;
			$this->_view->tb_legajo = $tb_legajo;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function ObtenerTipoArchivo()
	{
		if (isset($_SESSION['usuario'])) {

			$id = $_POST['id'];

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

			// VALIDAR TIPO DE ARCHIVO
			$params1 = array(
				'post' 	=> 3, // para listar todos los documentos
				'id'	=> $id, // se usa (id)
				'dni'	=> "", // aqui no se usa dni 
			);

			$result1 = $soap->Listacombodocumentos($params1);
			$legajodoc = json_decode($result1->ListacombodocumentosResult, true);

			$tb_files = explode(",", $legajodoc[0]['v_type_archivo']);

			$data = "";
			$i = 0;
			foreach ($tb_files as $vl) {

				$params2[$i] = array(
					'post' 	=> 2, // para listar tipos de archivos para combo
					'id'	=> $vl[$i], // no se usa (id)
					'mime'	=> "",
					'type'	=> "",
				);

				$result2 = $soap->ListarTipoArchivos($params2[$i]);
				$filecb = json_decode($result2->ListarTipoArchivosResult, true);

				$data .= "." . $filecb[$i]['v_archivo'] . ",";
			}
			$i++;
			// quitamos la ultima coma al string
			$myString = trim($data, ',');

			echo $myString;

		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function subir_archivo()
	{
		if (isset($_SESSION['usuario'])) {

			date_default_timezone_set("America/Lima");

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			if (is_array($_FILES) && count($_FILES) > 0) {

				$combo = $_POST['combodocumento']; // id del archivo a cargar
				$extdoc = explode("/", $_FILES["archivo"]["type"]); // convertir en array (mime / type)

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

				// VALIDAR TIPO DE ARCHIVO
				$params1 = array(
					'post' 	=> 3, // para listar todos los documentos
					'id'	=> $combo, // se usa (id)
					'dni'	=> "", // aqui no se usa dni 
				);

				$result1 = $soap->Listacombodocumentos($params1);
				$legajodoc = json_decode($result1->ListacombodocumentosResult, true);

				$tb_files = explode(",", $legajodoc[0]['v_type_archivo']);

				$data = "";
				$i = 0;
				foreach ($tb_files as $vl) {

					$params2[$i] = array(
						'post' 	=> 2, // para listar tipos de archivos para combo
						'id'	=> $vl[$i], // no se usa (id)
						'mime'	=> "",
						'type'	=> "",
					);

					$result2 = $soap->ListarTipoArchivos($params2[$i]);
					$filecb = json_decode($result2->ListarTipoArchivosResult, true);

					$data .= $filecb[$i]['v_mime'] . "," . $filecb[$i]['v_type'] . ",";
				}
				$i++;

				// quitamos la ultima coma al string
				$myString = trim($data, ',');

				// luego volvemos a convertir string a array para encontrar mime y type del archivo a cargar
				$tb_datos = explode(",", $myString);

				// ahora preguntamos si mime y type estan dentro de los archivos permitidos (ejm: "application/pdf")
				if (in_array($extdoc[0], $tb_datos) && in_array($extdoc[1], $tb_datos)) {

					// revisamos el tamaño del archivo
					if (($_FILES['archivo']['size'] / 1024) <= $legajodoc[0]['f_size']) {

						// obtenemos la extension del archivo desde la BD
						$params3 = array(
							'post' 	=> 3, // extraer extension de la BD
							'id'	=> 0, // no se usa (id)
							'mime'	=> $extdoc[0],
							'type'	=> $extdoc[1],
						);

						$result2 = $soap->ListarTipoArchivos($params3);
						$extension = json_decode($result2->ListarTipoArchivosResult, true);

						// ahora especificamos la ruta en donde se guardar el archivo
						$fecha_hora = date("Ymd_His", time());
						$destino = "public/doc/" . $legajodoc[0]['v_carpeta'] . "/" . $legajodoc[0]['v_carpeta'] . "_" . rtrim(ltrim($_SESSION['dni'])) . "_" . $fecha_hora . "." . $extension[0]['v_archivo'];

						if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)) {

							$param1 = array(
								"id" 			=> "1",
								"codigo" 		=> $combo,
								"dni" 			=> $_SESSION['dni'],
								"directorio" 	=> $destino,
								"mime"			=> $extdoc[0],
								"type"			=> $extdoc[1],
							);

							$result3 = $soap->MantenimientoDocumentos($param1);
							$tipodocumento = json_decode($result3->MantenimientoDocumentosResult, true);

							// 0 no se cargo
							// 1 se cargo correctamente
							header('Content-type: application/json; charset=utf-8');
							echo $json->encode(
								array(
									"vicon" 		=> $tipodocumento[0]['v_icon'],
									"vtitle" 		=> $tipodocumento[0]['v_title'],
									"vtext" 		=> $tipodocumento[0]['v_text'],
									"itimer" 		=> $tipodocumento[0]['i_timer'],
									"icase" 		=> $tipodocumento[0]['i_case'],
									"vprogressbar" 	=> $tipodocumento[0]['v_progressbar'],
								)
							);
						} else {
							header('Content-type: application/json; charset=utf-8');
							echo $json->encode(
								array(
									"vicon" 		=> "error",
									"vtitle" 		=> "Error al subir archivo al servidor",
									"vtext" 		=> "Ocurrio un error al cargar el archivo, favor de volver a intentarlo..!!",
									"itimer" 		=> 3000,
									"icase" 		=> 5,
									"vprogressbar" 	=> true,
								)
							);
						}
					} else {
						header('Content-type: application/json; charset=utf-8');
						echo $json->encode(
							array(
								"vicon" 		=> "error",
								"vtitle" 		=> "Error en tamaño de archivo",
								"vtext" 		=> "Archivo es demasiado grande a lo permitido, debe ser menor a " . round($legajodoc[0]['f_size'] / 1024, 2) . " mb.",
								"itimer" 		=> 5000,
								"icase" 		=> 6,
								"vprogressbar" 	=> true,
							)
						);
					}
				} else {
					header('Content-type: application/json; charset=utf-8');
					echo $json->encode(
						array(
							"vicon" 		=> "error",
							"vtitle" 		=> "Error archivo no reconocido",
							"vtext" 		=> "Archivo no configurado en el sistema, si tiene problemas comuniquese con Recursos Humanos...!!!",
							"itimer" 		=> 6000,
							"icase" 		=> 7,
							"vprogressbar" 	=> true,
						)
					);
				}
			} else {
				header('Content-type: application/json; charset=utf-8');
				echo $json->encode(
					array(
						"vicon" 		=> "error",
						"vtitle" 		=> "Archivo de origen no encontrado",
						"vtext" 		=> "Favor de volver a intentar subir un archivo...!!!",
						"itimer" 		=> 3000,
						"icase" 		=> 8,
						"vprogressbar" 	=> true,
					)
				);
			}
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function eliminar_archivo()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$codigo = $_POST['codigo']; 		// CODIGO UNICO IDENTITY DE LA BASE DE DATOS

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

			$param2 = array(
				"id" 			=> 3, // eliminar
				"codigo" 		=> $codigo,
				"dni" 			=> $_SESSION['dni'],
				"directorio" 	=> "",
				"mime"			=> "",
				"type"			=> ""
			);

			$soap = new SoapClient($wsdl, $options);
			$result3 = $soap->MantenimientoDocumentos($param2);
			$data = json_decode($result3->MantenimientoDocumentosResult, true);

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"vicon" 		=> $data[0]['v_icon'],
					"vtitle" 		=> $data[0]['v_title'],
					"vtext" 		=> $data[0]['v_text'],
					"itimer" 		=> $data[0]['i_timer'],
					"icase" 		=> $data[0]['i_case'],
					"vprogressbar" 	=> $data[0]['v_progressbar'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}
}
