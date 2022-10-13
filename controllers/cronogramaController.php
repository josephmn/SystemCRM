<?php

class cronogramaController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('planillas', 'cronograma');

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
				"connection_timeout" => 60,
				"trace" => false,
				"encoding" => "UTF-8",
				"exceptions" => false,
			);

			$soap = new SoapClient($wsdl, $options);

			$param1 = array(
				"post" => 1, //mostrar todos
			);

			$result = $soap->Listarmeses($param1);
			$listarmeses = json_decode($result->ListarmesesResult, true);

			$param2 = array(
				"post" => 2, //mostrar los meses
			);

			$result = $soap->Listarmeses($param2);
			$meses = json_decode($result->ListarmesesResult, true);

			$param3 = array(
				"post" => 3, //mostrar años
			);

			$result = $soap->Listarmeses($param3);
			$anhios = json_decode($result->ListarmesesResult, true);

			$result = $soap->ListadoEstadocronograma();
			$estadocronograma = json_decode($result->ListadoEstadocronogramaResult, true);

			// NOTIFICACIONES TOTAL
			$param100 = array(
				"post"	=> 2,  	// consultar por DNI para obtener cantidad de notificaciones
				"top"	=> 0,	// no se usa para esta consulta
				"dni"	=> $_SESSION['dni'],
			);

			$result100 = $soap->ListarPaNotificaciones($param100);
			$countnoti = json_decode($result100->ListarPaNotificacionesResult, true);

			$_SESSION['num_notificaciones'] = intval($countnoti[0]['i_delay']);

			$this->_view->listarmeses = $listarmeses;
			$this->_view->meses = $meses;
			$this->_view->anhios = $anhios;
			$this->_view->estadocronograma = $estadocronograma;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function gen_anhio()
	{
		if (isset($_SESSION['usuario'])) {

			$anhio = $_POST['anhio'];

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
				"anhio" => $anhio,
				"user" => $_SESSION['dni'],
			);

			$soap = new SoapClient($wsdl, $options);
			$result = $soap->MantenimientoVacacionesanhio($param);
			$consulta = json_decode($result->MantenimientoVacacionesanhioResult, true);

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"vicon" 		=> $consulta[0]['v_icon'],
					"vtitle" 		=> $consulta[0]['v_title'],
					"vtext" 		=> $consulta[0]['v_text'],
					"itimer" 		=> intval($consulta[0]['i_timer']),
					"icase" 		=> intval($consulta[0]['i_case']),
					"vprogressbar" 	=> $consulta[0]['v_progressbar'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function filtro_meses()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->setCss_Specific(
				array(
					'plugins/fontawesome-free/css/all.min',
					'plugins/overlayScrollbars/css/OverlayScrollbars.min',
					'dist/css/adminlte',
					//Bootstrap Color Picker y Tempusdominus Bootstrap 4
					'plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min',
					'plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min',
					//DataTables>
					'plugins/datatables-responsive/css/responsive.bootstrap4.min',
					'plugins/datatables-net/css/jquery.dataTables.min',
					'plugins/datatables-net/css/searchPanes.dataTables.min',
					'plugins/datatables-net/select.dataTables.min',
					'plugins/datatables-net/css/buttons.dataTables.min',
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
					'plugins/datatables-net/js/dataTables.searchPanes.min',
					'plugins/datatables-net/js/dataTables.select.min',
					'plugins/datatables-net/js/dataTables.buttons.min',
					'plugins/datatables-net/js/buttons.flash.min',
					'plugins/datatables-net/js/jszip.min',
					'plugins/datatables-net/js/pdfmake.min',
					'plugins/datatables-net/js/vfs_fonts',
					'plugins/datatables-net/js/buttons.html5.min',
					'plugins/datatables-net/js/buttons.print.min',
					'plugins/datatables-net/js/dataTables.responsive.min',
					//InputMask
					'plugins/moment/moment.min',
					'plugins/inputmask/min/jquery.inputmask.bundle.min',
					//bootstrap color picker y Tempusdominus Bootstrap 4
					'plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min',
					'plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min',
					//sweetalert2
					'plugins/sweetalert2/sweetalert2.all',
				)
			);

			$mes = $_GET['mes'];
			$anhio = $_GET['anhio'];
			$nommes = $_GET['nommes'];

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
				"mes"	=> $mes,
				"anhio" => $anhio
			);

			$soap = new SoapClient($wsdl, $options);
			$result = $soap->Listarcronogramaxmes($param);
			$cronogramames = json_decode($result->ListarcronogramaxmesResult, true);

			$param2 = array(
				"post" => 2, //mostrar los meses
			);

			$result = $soap->Listarmeses($param2);
			$listarmeses = json_decode($result->ListarmesesResult, true);

			$param3 = array(
				"post" => 3, //mostrar años
			);

			$result = $soap->Listarmeses($param3);
			$anhios = json_decode($result->ListarmesesResult, true);

			$result = $soap->ListadoEstadocronograma();
			$estadocronograma = json_decode($result->ListadoEstadocronogramaResult, true);

			$param3 = array(
				"mes"	=> $mes,
				"anhio" => $anhio,
			);

			$soap = new SoapClient($wsdl, $options);
			$result3 = $soap->Listarenviovacaciones($param3);
			$enviopago = json_decode($result3->ListarenviovacacionesResult, true);

			$fechacorte = "";
			$input = "";
			if ($_GET['mes'] == 1) {
				$fechacorte = "15/12/" . strval($_GET['anhio'] - 1);
			} else if ($_GET['mes'] > 1 && $_GET['mes'] < 10) {
				$fechacorte = "15/0" . strval($_GET['mes'] - 1) . "/" . strval($_GET['anhio']);
			} else {
				$fechacorte = "15/" . strval($_GET['mes'] - 1) . "/" . strval($_GET['anhio']);
			}

			if (count($enviopago) > 0) {
				$input = "<input id='fcorte' type='text' class='form-control datetimepicker-input' value=" . $enviopago[0]['d_corte'] . " placeholder='dd/mm/aaaa' disabled>";
			} else {
				$input = "<input id='fcorte' type='text' class='form-control datetimepicker-input' value=" . $fechacorte . " placeholder='dd/mm/aaaa'>";
			}

			$this->_view->listarmeses = $listarmeses;
			$this->_view->anhios = $anhios;
			$this->_view->cronogramames = $cronogramames;
			$this->_view->estadocronograma = $estadocronograma;
			$this->_view->input = $input;

			$this->_view->setJs(array('detallecronograma'));
			$this->_view->renderizar('detallecronograma');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function cargar_datos() //ok
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			if (is_array($_FILES) && count($_FILES) > 0) {

				$nombre_archivo = date("Ymd_His", time());

				$archivo = $_FILES['excel']['name'];

				$destino = "temp/" . $nombre_archivo . "_" . LTRIM(RTRIM($_SESSION['dni'])) . "_" . $archivo;

				if (copy($_FILES['excel']['tmp_name'], $destino)) {

					if (file_exists($destino)) {

						$this->getLibrary('PHPExcel/PHPExcel');

						$inputFileType = PHPExcel_IOFactory::identify($destino);
						$objReader = PHPExcel_IOFactory::createReader($inputFileType);
						$objPHPExcel = $objReader->load($destino);

						$sheet = $objPHPExcel->getSheet(0);
						$cantidadfilas = $sheet->getHighestRow();
						$ultimacolumna = $sheet->getHighestColumn();

						if ($ultimacolumna == 'D') {

							for ($i = 2; $i <= $cantidadfilas; $i++) {

								$_DATOS_EXCEL[$i]['dni'] 	= $sheet->getCell("A" . $i)->getValue();
								$_DATOS_EXCEL[$i]['mes'] 	= $sheet->getCell("B" . $i)->getValue();
								$_DATOS_EXCEL[$i]['dias'] 	= $sheet->getCell("C" . $i)->getValue();
								$_DATOS_EXCEL[$i]['anio'] 	= $sheet->getCell("D" . $i)->getValue();
							}

							unlink($destino);

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

							foreach ($_DATOS_EXCEL as $campo) {

								$param = array(
									"post"	=> 1,
									"codigo" => 0,
									"dni"	=> $campo['dni'],
									"mes"	=> $campo['mes'],
									"tipo"	=> 1,
									"dias"	=> $campo['dias'],
									"anhio"	=> $campo['anio'],
									"user"	=> $_SESSION['dni']
								);

								$result = $soap->MantenimientoCronograma($param);
							}

							$cronogramaresult = json_decode($result->MantenimientoCronogramaResult, true);

							header('Content-type: application/json; charset=utf-8');
							echo $json->encode(
								array(
									"vicon"		 	=> $cronogramaresult[0]['v_icon'],
									"vtitle" 		=> $cronogramaresult[0]['v_title'],
									"vtext" 		=> $cronogramaresult[0]['v_text'],
									"itimer" 		=> $cronogramaresult[0]['i_timer'],
									"icase" 		=> $cronogramaresult[0]['i_case'],
									"vprogressbar" 	=> $cronogramaresult[0]['v_progressbar'],
								)
							);
						} else {
							//echo 2; //archivo no contiene el formato correcto.
							header('Content-type: application/json; charset=utf-8');
							echo $json->encode(
								array(
									"vicon" 		=> "error",
									"vtitle" 		=> "Archivo no contiene el formato correcto...",
									"vtext" 		=> "No se pudo cargar el archivo!",
									"itimer" 		=> 3000,
									"icase" 		=> 2, //"archivo no se pudo guardar em ruta destino";
									"vprogressbar" 	=> true
								)
							);
						}
					} else {
						//echo 3; //archivo no encontrado en la ruta de destino.
						header('Content-type: application/json; charset=utf-8');
						echo $json->encode(
							array(
								"vicon" 		=> "error",
								"vtitle" 		=> "Archivo no encontrado...",
								"vtext" 		=> "No se pudo guardar el archivo!",
								"itimer" 		=> 3000,
								"icase" 		=> 3, //"archivo no se pudo guardar em ruta destino";
								"vprogressbar" 	=> true
							)
						);
					}
				} else {
					//echo 4; //no ha cargado ningun archivo.
					header('Content-type: application/json; charset=utf-8');
					echo $json->encode(
						array(
							"vicon" 		=> "error",
							"vtitle" 		=> "No ha cargado ningun archivo...",
							"vtext" 		=> "Favor de cargar un archivo Excel!",
							"itimer" 		=> 3000,
							"icase" 		=> 4, //"archivo no se pudo guardar em ruta destino";
							"vprogressbar" 	=> true
						)
					);
				}
			}
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function registrar_cronograma()
	{
		if (isset($_SESSION['usuario'])) {

			$dni = $_POST['dni'];
			$mes = $_POST['mes'];
			$tipo = $_POST['tipo'];
			$dias = $_POST['dias'];
			$anhio = $_POST['anhio'];

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
				"post"	=> 1,
				"codigo" => 0,
				"dni"	=> $dni,
				"mes"	=> $mes,
				"tipo"	=> $tipo,
				"dias"	=> $dias,
				"anhio" => $anhio, //date("Y")
				"user"	=> $_SESSION['dni']
			);

			$soap = new SoapClient($wsdl, $options);
			$result = $soap->MantenimientoCronograma($param);
			$cronogramaresult = json_decode($result->MantenimientoCronogramaResult, true);

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"vicon" 		=> $cronogramaresult[0]['v_icon'],
					"vtitle" 		=> $cronogramaresult[0]['v_title'],
					"vtext" 		=> $cronogramaresult[0]['v_text'],
					"itimer" 		=> $cronogramaresult[0]['i_timer'],
					"icase" 		=> $cronogramaresult[0]['i_case'],
					"vprogressbar" 	=> $cronogramaresult[0]['v_progressbar'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function descargar_formato()
	{
		if (isset($_SESSION['usuario'])) {

			$this->getLibrary('PHPExcel/PHPExcel');

			// Crea un nuevo objeto PHPExcel
			$objPHPExcel = new PHPExcel();

			// Establecer propiedades
			$objPHPExcel->getProperties()
				->setCreator("Joseph Magallanes")
				->setLastModifiedBy("Portal web RRHH")
				->setTitle("Formato cronograma")
				->setSubject("Formato cronograma")
				->setDescription("Formato para importacion de datos al portal")
				->setKeywords("Excel Office 2007 openxml")
				->setCategory("Formatos");

			//titulos del reporte y datos donde va cada informacion
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'DNI')
				->setCellValue('B1', 'MES')
				->setCellValue('C1', 'DIA')
				->setCellValue('D1', 'ANIO')
				->setCellValue('A2', '88888888')
				->setCellValue('B2', '1')
				->setCellValue('C2', '7')
				->setCellValue('D2', '2021');

			// Renombrar Hoja
			$objPHPExcel->getActiveSheet()->setTitle('formato_cronograma');

			// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
			$objPHPExcel->setActiveSheetIndex(0);

			// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="formato_cronograma.xlsx"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function descargar_cronograma()
	{
		if (isset($_SESSION['usuario'])) {

			function html_caracteres($string)
			{
				$string = str_replace(
					array('&amp;', '&Ntilde;', '&Aacute;', '&Eacute;', '&Iacute;', '&Oacute;', '&Uacute;'),
					array('&', 'Ñ', 'Á', 'É', 'Í', 'Ó', 'Ú'),
					$string
				);
				return $string;
			}

			$this->getLibrary('PHPExcel/PHPExcel');

			// Crea un nuevo objeto PHPExcel
			$objPHPExcel = new PHPExcel();

			// Establecer propiedades
			$objPHPExcel->getProperties()
				->setCreator("Joseph Magallanes")
				->setLastModifiedBy("Portal web RRHH")
				->setTitle("Cronograma anual")
				->setSubject("Cronograma anual")
				->setDescription("Formato de crnograma cargado anual")
				->setKeywords("Excel Office 2007 openxml")
				->setCategory("Formatos");

			//AQUI SERVICIO DE CONSULTA E ITERAR

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
				"mes"	=> 13,
				"anhio"	=> 0
			);

			$soap = new SoapClient($wsdl, $options);
			$result = $soap->Listarcronogramaxmes($param);
			$cronograma = json_decode($result->ListarcronogramaxmesResult, true);

			// PARA UNIR UN RANGO DE CELDAS
			//$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:I1');

			//titulos del reporte y datos donde va cada informacion
			$objPHPExcel->setActiveSheetIndex(0);

			// Fuente de la primera fila en negrita
			$boldArray = array('font' => array('bold' => true,), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
			$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($boldArray);

			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Numero');
			$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Documento');
			$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Nombres y Apellidos');
			$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Mes');
			$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Dias');
			$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Fecha Inicio');
			$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Fecha Fin');
			$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Total dias');
			$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Estado');
			$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Anio');
			$objPHPExcel->getActiveSheet()->setCellValue('K1', 'Numero Mes');

			// COLOCAR MARCO A LAS CELDAS
			$rango = 'A1:K1';
			$styleArray = array(
				'font' => array('name' => 'Arial', 'size' => 9),
				'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '#FFFFFF')))
			);
			$objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray($styleArray);

			$rowcel = 2;
			for ($i = 0; $i < count($cronograma); $i++) {

				$objPHPExcel->getActiveSheet()->setCellValue('A' . $rowcel, $cronograma[$i]['i_id']);
				$objPHPExcel->getActiveSheet()->setCellValue('B' . $rowcel, $cronograma[$i]['v_dni']);
				$objPHPExcel->getActiveSheet()->setCellValue('C' . $rowcel, html_caracteres($cronograma[$i]['v_nombres']));
				$objPHPExcel->getActiveSheet()->setCellValue('D' . $rowcel, $cronograma[$i]['v_nommes']);
				$objPHPExcel->getActiveSheet()->setCellValue('E' . $rowcel, $cronograma[$i]['v_dias']);
				$objPHPExcel->getActiveSheet()->setCellValue('F' . $rowcel, $cronograma[$i]['d_finicio']);
				$objPHPExcel->getActiveSheet()->setCellValue('G' . $rowcel, $cronograma[$i]['d_ffin']);
				$objPHPExcel->getActiveSheet()->setCellValue('H' . $rowcel, $cronograma[$i]['v_total']);
				$objPHPExcel->getActiveSheet()->setCellValue('I' . $rowcel, $cronograma[$i]['v_estado']);
				$objPHPExcel->getActiveSheet()->setCellValue('J' . $rowcel, $cronograma[$i]['i_anhio']);
				$objPHPExcel->getActiveSheet()->setCellValue('K' . $rowcel, $cronograma[$i]['v_mes']);

				$rango = 'A' . $rowcel . ":" . 'K' . $rowcel;
				$styleArray = array(
					'font' => array('name' => 'Arial', 'size' => 9),
					'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '#FFFFFF')))
				);
				$objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray($styleArray);

				// FORMATO TIPO TEXTO
				$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $i)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING);

				$rowcel++;
			}

			// Renombrar Hoja
			$objPHPExcel->getActiveSheet()->setTitle('listado_cronograma');

			// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
			$objPHPExcel->setActiveSheetIndex(0);

			// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="listado_cronograma_' . date('d-m-Y H i s') . '.xlsx"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function validar_documento()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$dni = $_POST['doc'];
			//$dni = '88888888';

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
				'dni' => $dni,
			);

			$soap = new SoapClient($wsdl, $options);
			$result = $soap->Verificardocumento($params);
			$verificacion = json_decode($result->VerificardocumentoResult, true);

			if (count($verificacion) > 0) {
				$contador = 1;
			} else {
				$contador = 0;
				$verificacion[0]['v_dni'] = "";
				$verificacion[0]['v_nombre'] = "";
			}

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"dato"		=> $contador,
					"dni" 		=> $verificacion[0]['v_dni'],
					"nombre" 	=> $verificacion[0]['v_nombre'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function buscar_cronograma()
	{
		if (isset($_SESSION['usuario'])) {

			$codigo = $_POST['id'];
			//$codigo = "1";

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
				"codigo" => $codigo
			);

			$soap = new SoapClient($wsdl, $options);
			$result = $soap->Consultarcronograma($param);
			$consulta = json_decode($result->ConsultarcronogramaResult, true);

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"dni" 		=> $consulta[0]['v_dni'],
					"nombre" 	=> $consulta[0]['v_nombres'],
					"mes" 		=> $consulta[0]['v_mes'],
					"tipo" 		=> $consulta[0]['i_tipo'],
					"dia" 		=> $consulta[0]['v_dias'],
					"anhio" 	=> $consulta[0]['i_anhio'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function mantenimiento_cronograma()
	{
		if (isset($_SESSION['usuario'])) {

			$post = $_POST['post'];
			$codigo = $_POST['codigo'];
			$dni = $_POST['dni'];
			$mes = $_POST['mes'];
			$tipo = $_POST['tipo'];
			$dias = $_POST['dia'];
			$anhio = $_POST['anhio'];

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
				"post"	=> $post,
				"codigo" => $codigo,
				"dni"	=> $dni,
				"mes"	=> $mes,
				"tipo"	=> $tipo,
				"dias"	=> $dias,
				// "anhio"	=>date("Y"),
				"anhio"	=> $anhio,
				"user"	=> $_SESSION['dni']
			);

			$soap = new SoapClient($wsdl, $options);
			$result = $soap->MantenimientoCronograma($param);
			$cronogramaresult = json_decode($result->MantenimientoCronogramaResult, true);

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"vicon" 		=> $cronogramaresult[0]['v_icon'],
					"vtitle" 		=> $cronogramaresult[0]['v_title'],
					"vtext" 		=> $cronogramaresult[0]['v_text'],
					"itimer" 		=> $cronogramaresult[0]['i_timer'],
					"icase" 		=> $cronogramaresult[0]['i_case'],
					"vprogressbar" 	=> $cronogramaresult[0]['v_progressbar'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	// IMPRIMIR PDF DE VACACIONES
	public function imprimir_pdf()
	{
		if (isset($_SESSION['usuario'])) {

			$id = $_GET['id'];
			$anhio = $_GET['anhio'];

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
				//"cache_wsdl"=> WSDL_CACHE_BOTH,
				"connection_timeout" => 60,
				"trace" => false,
				"encoding" => "UTF-8",
				"exceptions" => false,
			);

			$param = array(
				"id" => $id,
				"anhio" => $anhio,
			);
			$soap = new SoapClient($wsdl, $options);
			$result = $soap->ImpVacacioncronograma($param);
			$vacacion = json_decode($result->ImpVacacioncronogramaResult, true);

			$this->getLibrary('fpdf/fpdf');

			$this->getLibrary('fpdf/makefont/makefont');
			// $this->getLibrary('fpdf/makefont/makefont/GOTHIC');

			$pdf = new FPDF('P', 'mm', 'A4');

			$pdf->AddPage();
			$pdf->SetMargins(12, 4, 12);
			$pdf->Image('./public/dist/img/banner.png', 16, 12, 180, 18, "png");

			$pdf->Ln(30);
			$pdf->AddFont('CenturyGothic-Bold', '', 'GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold', 'U', 18);
			$pdf->MultiCell(190, 5, utf8_decode("SOLICITUD DE VACACIONES"), 0, "C", false);

			// DATOS DEL TRABAJADOR
			$pdf->SetXY(18, 55);
			$pdf->AddFont('CenturyGothic-Bold', '', 'GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold', '', 11);
			$pdf->SetFillColor(146, 208, 80);
			$pdf->SetTextColor(255, 255, 255);
			$pdf->Cell(175, 6, utf8_decode("DATOS DEL TRABAJADOR"), 1, 0, 'C', true);

			$pdf->SetXY(18, 61);
			$pdf->AddFont('CenturyGothic', '', 'GOTHIC.php');
			$pdf->SetFont('CenturyGothic', '', 9);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->Cell(30, 6, utf8_decode($vacacion[0]['v_dni']), 1, 0, 'C', true);
			$pdf->Cell(105, 6, utf8_decode(html_caracteres($vacacion[0]['v_nombres'])), 1, 0, 'C', true);
			$pdf->Cell(40, 6, utf8_decode($vacacion[0]['d_ingreso']), 1, 0, 'C', true);

			$pdf->SetXY(18, 67);
			$pdf->AddFont('CenturyGothic-Bold', '', 'GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold', '', 7);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(229, 229, 229);
			$pdf->Cell(30, 4, utf8_decode("DNI"), 1, 0, 'C', true);
			$pdf->Cell(105, 4, utf8_decode("APELLIDOS Y NOMBRES"), 1, 0, 'C', true);
			$pdf->Cell(40, 4, utf8_decode("FECHA DE INGRESO"), 1, 0, 'C', true);

			$pdf->SetXY(18, 71);
			$pdf->AddFont('CenturyGothic', '', 'GOTHIC.php');
			$pdf->SetFont('CenturyGothic', '', 9);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->Cell(75, 6, utf8_decode(html_caracteres($vacacion[0]['v_area'])), 1, 0, 'C', true);
			$pdf->Cell(100, 6, utf8_decode(html_caracteres($vacacion[0]['v_cargo'])), 1, 0, 'C', true);

			$pdf->SetXY(18, 77);
			$pdf->AddFont('CenturyGothic-Bold', '', 'GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold', '', 7);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(229, 229, 229);
			$pdf->Cell(75, 4, utf8_decode("AREA"), 1, 0, 'C', true);
			$pdf->Cell(100, 4, utf8_decode("CARGO"), 1, 0, 'C', true);

			// ESPECIFICACIONES
			$pdf->SetXY(18, 81);
			$pdf->AddFont('CenturyGothic-Bold', '', 'GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold', '', 11);
			$pdf->SetFillColor(146, 208, 80);
			$pdf->SetTextColor(255, 255, 255);
			$pdf->Cell(175, 6, utf8_decode("ESPECIFICACIONES (DE USO DE RR.HH.)"), 1, 0, 'C', true);

			$pdf->SetXY(18, 87);
			$pdf->AddFont('CenturyGothic', '', 'GOTHIC.php');
			$pdf->SetFont('CenturyGothic', '', 9);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->Cell(30, 6, utf8_decode($vacacion[0]['v_periodo']), 1, 0, 'C', true);
			$pdf->Cell(70, 6, utf8_decode(html_caracteres("")), 1, 0, 'C', true);
			$pdf->Cell(75, 6, utf8_decode(html_caracteres("")), 1, 0, 'C', true);

			$pdf->SetXY(18, 93);
			$pdf->AddFont('CenturyGothic-Bold', '', 'GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold', '', 7);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(229, 229, 229);
			$pdf->Cell(30, 4, utf8_decode("PERIODO"), 1, 0, 'C', true);
			$pdf->Cell(70, 4, utf8_decode("PERIODO LEGAL DE GOZE"), 1, 0, 'C', true);
			$pdf->Cell(75, 4, utf8_decode("ROL OFICINA PROGRAMADO (MES DE PAGO)"), 1, 0, 'C', true);

			$pdf->SetXY(18, 97);
			$pdf->Cell(175, 12, utf8_decode(""), 1, 0);

			$pdf->SetXY(18, 94);
			$pdf->AddFont('CenturyGothic-Bold', '', 'GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold', '', 7);
			$pdf->Cell(175, 12, utf8_decode("Observaciones del rol oficial programado:"), 0, 0, 'L');

			// DESCANSO FISICO
			$pdf->SetXY(18, 109);
			$pdf->AddFont('CenturyGothic-Bold', '', 'GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold', '', 11);
			$pdf->SetFillColor(146, 208, 80);
			$pdf->SetTextColor(255, 255, 255);
			$pdf->Cell(175, 6, utf8_decode("DESCANSO FÍSICO"), 1, 0, 'C', true);

			$pdf->SetXY(18, 115);
			$pdf->AddFont('CenturyGothic-Bold', '', 'GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold', '', 7);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(229, 229, 229);
			$pdf->Cell(30, 4, utf8_decode("FECHA INICIO (1)"), 1, 0, 'C', true);
			$pdf->Cell(30, 4, utf8_decode("FECHA INICIO (1)"), 1, 0, 'C', true);
			$pdf->Cell(28, 4, utf8_decode("DÍAS GOZADOS"), 1, 0, 'C', true);
			$pdf->Cell(30, 4, utf8_decode("FECHA INICIO (2)"), 1, 0, 'C', true);
			$pdf->Cell(30, 4, utf8_decode("FECHA INICIO (2)"), 1, 0, 'C', true);
			$pdf->Cell(27, 4, utf8_decode("DÍAS GOZADOS"), 1, 0, 'C', true);

			$pdf->SetXY(18, 119);
			$pdf->AddFont('CenturyGothic', '', 'GOTHIC.php');
			$pdf->SetFont('CenturyGothic', '', 9);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->Cell(30, 6, utf8_decode($vacacion[0]['d_finicio']), 1, 0, 'C', true);
			$pdf->Cell(30, 6, utf8_decode($vacacion[0]['d_ffin']), 1, 0, 'C', true);
			$pdf->Cell(28, 6, utf8_decode($vacacion[0]['i_dias']), 1, 0, 'C', true);
			$pdf->Cell(30, 6, utf8_decode("--/--/----"), 1, 0, 'C', true);
			$pdf->Cell(30, 6, utf8_decode("--/--/----"), 1, 0, 'C', true);
			$pdf->Cell(27, 6, utf8_decode("--"), 1, 0, 'C', true);

			$pdf->SetXY(18, 125);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->Cell(44, 30, utf8_decode(""), 1, 0, 'C', true);
			$pdf->Cell(44, 30, utf8_decode(""), 1, 0, 'C', true);
			$pdf->Cell(44, 30, utf8_decode(""), 1, 0, 'C', true);
			$pdf->Cell(43, 30, utf8_decode(""), 1, 0, 'C', true);

			$pdf->SetXY(18, 155);
			$pdf->AddFont('CenturyGothic-Bold', '', 'GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold', '', 7);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(229, 229, 229);
			$pdf->Cell(44, 9, utf8_decode(""), 1, 0, 'C', true);
			$pdf->Cell(44, 9, utf8_decode("Firma del Trabajador"), 1, 0, 'C', true);

			$pdf->Image('./' . $vacacion[0]['v_firma_personal'], 63, 130, 42, 20, "png");

			$pdf->Cell(44, 9, utf8_decode(""), 1, 0, 'C', true);
			$pdf->Cell(43, 9, utf8_decode("Firma del Trabajador"), 1, 0, 'C', true);

			// firma
			//$pdf->Image('./public/doc/firmas/07258243_20210412_213119.png', 18, 130, 43, 20, "png");
			$pdf->Image('./' . $vacacion[0]['v_firma_jefe'], 19, 130, 42, 20, "png");

			// primera firma jefe inmediato
			$pdf->SetXY(18, 154);
			$pdf->AddFont('CenturyGothic-Bold', '', 'GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold', '', 7);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->Cell(44, 8, utf8_decode("Autorizado por:"), 0, 0, 'C');

			$pdf->SetXY(18, 157);
			$pdf->AddFont('CenturyGothic-Bold', '', 'GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold', '', 7);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->Cell(44, 8, utf8_decode("(Firma del Jefe Inmediato)"), 0, 0, 'C');

			// segunda firma jefe inmediato
			$pdf->SetXY(106, 154);
			$pdf->AddFont('CenturyGothic-Bold', '', 'GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold', '', 7);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->Cell(44, 8, utf8_decode("Autorizado por:"), 0, 0, 'C');

			$pdf->SetXY(106, 157);
			$pdf->AddFont('CenturyGothic-Bold', '', 'GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold', '', 7);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->Cell(44, 8, utf8_decode("(Firma del Jefe Inmediato)"), 0, 0, 'C');

			// OBSERVACIONES DEL DESCANSO FÍSICO
			$pdf->SetXY(18, 164);
			$pdf->AddFont('CenturyGothic-Bold', '', 'GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold', '', 11);
			$pdf->SetFillColor(146, 208, 80);
			$pdf->SetTextColor(255, 255, 255);
			$pdf->Cell(175, 6, utf8_decode("Observaciones del descanso físico: (de uso de RR.HH.)"), 1, 0, 'L', true);

			$pdf->SetXY(18, 170);
			$pdf->AddFont('CenturyGothic-Bold', '', 'GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold', '', 9);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->Cell(175, 7, utf8_decode(" 1."), 1, 0, 'L', true);

			$pdf->SetXY(18, 177);
			$pdf->AddFont('CenturyGothic-Bold', '', 'GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold', '', 9);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->Cell(175, 7, utf8_decode(" 2."), 1, 0, 'L', true);

			$pdf->SetXY(18, 184);
			$pdf->AddFont('CenturyGothic-Bold', '', 'GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold', '', 9);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->Cell(175, 7, utf8_decode(" 3."), 1, 0, 'L', true);

			$pdf->SetXY(18, 191);
			$pdf->AddFont('CenturyGothic-Bold', '', 'GOTHICB.php');
			$pdf->SetFont('CenturyGothic-Bold', '', 9);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->Cell(175, 7, utf8_decode(" 4."), 1, 0, 'L', true);

			$xperiodo = utf8_decode($vacacion[0]['v_periodo']);
			$xnombres = utf8_decode(html_caracteres($vacacion[0]['v_nombres']));

			//$pdf->Output();
			$pdf->Output("VACACIONES - $xperiodo - $xnombres.pdf", 'I');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function consultarmeses()
	{
		if (isset($_SESSION['usuario'])) {

			$id = $_POST['id'];

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$wsdl1 = 'http://localhost:81/PAWEB/WSRecursos.asmx?WSDL';

			$options = array(
				"uri" => $wsdl1,
				"style" => SOAP_RPC,
				"use" => SOAP_ENCODED,
				"soap_version" => SOAP_1_1,
				"connection_timeout" => 60,
				"trace" => false,
				"encoding" => "UTF-8",
				"exceptions" => false,
			);

			$param = array(
				"id" => $id
			);

			$ra = new SoapClient($wsdl1, $options);
			$result = $ra->Consultarmeses($param);
			$consultameses = json_decode($result->ConsultarmesesResult, true);

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"estado" => intval($consultameses[0]['i_estado']),
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function mantenimiento_meses()
	{
		if (isset($_SESSION['usuario'])) {

			$id = $_POST['id'];
			$estado = $_POST['estado'];

			// $id = 8;
			// $estado = 1;

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$wsdl2 = 'http://localhost:81/PAWEB/WSRecursos.asmx?WSDL';

			$options = array(
				"uri" => $wsdl2,
				"style" => SOAP_RPC,
				"use" => SOAP_ENCODED,
				"soap_version" => SOAP_1_1,
				"connection_timeout" => 60,
				"trace" => false,
				"encoding" => "UTF-8",
				"exceptions" => false,
			);

			$param = array(
				"id" => $id,
				"estado" => $estado,
				"user" => $_SESSION['dni']
			);

			$soap = new SoapClient($wsdl2, $options);
			$result = $soap->MantenimientoMeses($param);
			$mantenimientomeses = json_decode($result->MantenimientoMesesResult, true);

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"vicon" 		=> $mantenimientomeses[0]['v_icon'],
					"vtitle" 		=> $mantenimientomeses[0]['v_title'],
					"vtext" 		=> $mantenimientomeses[0]['v_text'],
					"itimer" 		=> $mantenimientomeses[0]['i_timer'],
					"icase" 		=> $mantenimientomeses[0]['i_case'],
					"vprogressbar" 	=> $mantenimientomeses[0]['v_progressbar'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function pagolinkmensual()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$anhio = $_POST['anhio'];
			$mes = $_POST['mes'];
			$fecha = $_POST['fcorte'];
			$nommes = $_POST['nommes'];

			$link = BASE_URL . 'cronograma/pagovacaciones/&anhio=' . $anhio . '&mes=' . $mes . '&nommes=' . $nommes . '&fecha=' . $fecha;

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"vlink" => $link,
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function pagovacaciones()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->setCss_Specific(
				array(
					'plugins/fontawesome-free/css/all.min',
					'plugins/overlayScrollbars/css/OverlayScrollbars.min',
					'dist/css/adminlte',
					//Bootstrap Color Picker y Tempusdominus Bootstrap 4
					'plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min',
					'plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min',
					//DataTables>
					'plugins/datatables-responsive/css/responsive.bootstrap4.min',
					'plugins/datatables-net/css/jquery.dataTables.min',
					'plugins/datatables-net/css/searchPanes.dataTables.min',
					'plugins/datatables-net/select.dataTables.min',
					'plugins/datatables-net/css/buttons.dataTables.min',
					'plugins/datatables-net/css/responsive.dataTables.min',
					//Select2
					'plugins/select2/css/select2.min',
					'plugins/select2-bootstrap4-theme/select2-bootstrap4.min',
					//animate css
					'dist/css/animate',
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
					'plugins/datatables-net/js/jszip.min',
					'plugins/datatables-net/js/pdfmake.min',
					'plugins/datatables-net/js/vfs_fonts',
					'plugins/datatables-net/js/buttons.html5.min',
					'plugins/datatables-net/js/buttons.print.min',
					'plugins/datatables-net/js/dataTables.responsive.min',
					//InputMask
					'plugins/moment/moment.min',
					'plugins/inputmask/min/jquery.inputmask.bundle.min',
					//bootstrap color picker y Tempusdominus Bootstrap 4
					'plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min',
					'plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min',
					//sweetalert2
					'plugins/sweetalert2/sweetalert2.all',
				)
			);

			$mes = $_GET['mes'];
			$anhio = $_GET['anhio'];
			$nommes = $_GET['nommes'];
			$fecha = $_GET['fecha'];

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

			$param1 = array(
				"post"	=> 1, // 1. pago en fecha corte, 2. pago fuera de fecha corte
				"mes"	=> $mes,
				"anhio" => $anhio,
				"fecha" => $fecha,
			);

			$soap = new SoapClient($wsdl, $options);
			$result1 = $soap->Listarpagovacaciones($param1);
			$pagomes = json_decode($result1->ListarpagovacacionesResult, true);

			if (count($pagomes) > 0) {
				$stylefila = ["display: block;", "fas fa-minus", ""];
			} else {
				$stylefila = ["display: none;", "fas fa-plus", "collapsed-card"];
			}

			// construimos la tabla pago con fecha corte
			$filas = "";
			foreach ($pagomes as $dv) {
				$filas .= "
				<tr data-widget='expandable-table' aria-expanded='false'>
					<td class='text-center'>" . $dv['i_vac'] . "</td>
					<td class='text-center'>" . $dv['v_dni'] . "</td>
					<td class='text-left'>" . $dv['v_nombres'] . "</td>
					<td class='text-center'><span class='badge bg-info'>" . $dv['v_nommes'] . "</span></td>
					<td class='text-center'><span class='badge bg-primary'>" . $dv['i_anhio'] . "</span></td>
					<td class='text-center'>" . $dv['d_finicio'] . "</td>
					<td class='text-center'>" . $dv['d_ffin'] . "</td>
					<td class='text-center'>" . $dv['v_total'] . "</td>
					<td class='text-center'><span class='badge bg-" . $dv['v_color_tipo'] . "'>" . $dv['v_tipo'] . "</span></td>
					<td class='text-center'>" . $dv['d_aprobado'] . "</td>
					<td class='text-center'>" . $dv['d_corte'] . "</td>
				</tr>";
			};

			$param2 = array(
				"post"	=> 2, // 1. pago en fecha corte, 2. pago fuera de fecha corte
				"mes"	=> $mes,
				"anhio" => $anhio,
				"fecha" => $fecha,
			);

			$soap = new SoapClient($wsdl, $options);
			$result2 = $soap->Listarpagovacaciones($param2);
			$pagomespasado = json_decode($result2->ListarpagovacacionesResult, true);

			if (count($pagomespasado) > 0) {
				$stylefila1 = ["display: block;", "fas fa-minus", ""];
			} else {
				$stylefila1 = ["display: none;", "fas fa-plus", "collapsed-card"];
			}

			// construimos la tabla pago con fecha corte fuera de fecha
			$filas1 = "";
			foreach ($pagomespasado as $payf) {
				$filas1 .= "
				<tr data-widget='expandable-table' aria-expanded='false'>
					<td class='text-center'>" . $payf['i_vac'] . "</td>
					<td class='text-center'>" . $payf['v_dni'] . "</td>
					<td class='text-left'>" . $payf['v_nombres'] . "</td>
					<td class='text-center'><span class='badge bg-info'>" . $payf['v_nommes'] . "</span></td>
					<td class='text-center'><span class='badge bg-primary'>" . $payf['i_anhio'] . "</span></td>
					<td class='text-center'>" . $payf['d_finicio'] . "</td>
					<td class='text-center'>" . $payf['d_ffin'] . "</td>
					<td class='text-center'>" . $payf['v_total'] . "</td>
					<td class='text-center'><span class='badge bg-" . $payf['v_color_tipo'] . "'>" . $payf['v_tipo'] . "</span></td>
					<td class='text-center'>" . $payf['d_aprobado'] . "</td>
					<td class='text-center'>" . $payf['d_corte'] . "</td>
					<td class='text-center'>
						<a id='" . $payf['i_vac'] . "' nombre='" . $payf['v_nombres'] . "' class='btn btn-warning btn-sm text-black aprobar'><i class='fa fa-check'></i><b>&nbsp;&nbsp;Aprobar</b></a>
					</td>
				</tr>";
			};

			$param3 = array(
				"mes"	=> $mes,
				"anhio" => $anhio,
			);

			$soap = new SoapClient($wsdl, $options);
			$result3 = $soap->Listarenviovacaciones($param3);
			$enviopago = json_decode($result3->ListarenviovacacionesResult, true);

			if (count($enviopago) > 0) {
				$stylefila2 = ["display: block;", "fas fa-minus", ""];
			} else {
				$stylefila2 = ["display: none;", "fas fa-plus", "collapsed-card"];
			}

			// construimos la tabla para envio de pagos
			$filas2 = "";
			foreach ($enviopago as $dev) {

				if ($dev['i_confirmado'] == 0) {
					if ($dev['i_generado'] == 0) {
						$div = "<a id='" . $dev['i_vac'] . "' nombre='" . $dev['v_nombres'] . "' class='btn btn-danger btn-sm text-white eliminar'><i class='fa fa-trash-alt'></i></a>";
					} else {
						$div = "";
					}
					$btconfirmado = "
					<div class='row'>
						<div class='col-sm-4'>
							<div class='form-group'>
								<button type='button' id='btnenvio' class='btn btn-success btn-block'>
									<i class='fas fa-save fa-beat'></i>&nbsp;&nbsp;<b>ENVIAR PAGOS</b>
								</button>
							</div>
						</div>
					</div>";
				} else {
					$div = "";
					$btconfirmado = "
					<form action=" . BASE_URL . "cronograma/descargar_reporte/&mes=". $mes ."&anhio=". $anhio ." method='post'>
						<div class='row'>
							<div class='col-sm-4'>
								<div class='form-group'>
									<button type='submit' id='btnreporte' name='btn-descargar' class='btn btn-success btn-block'><i class='fa fa-file-excel'></i><b>&nbsp;&nbsp;DESCARGAR REPORTE</b></button>
								</div>
							</div>
						</div>
					</form>";
				}

				$filas2 .= "
				<tr data-widget='expandable-table' aria-expanded='false'>
					<td class='text-center'>" . $dev['i_vac'] . "</td>
					<td class='text-center'>" . $dev['v_dni'] . "</td>
					<td class='text-left'>" . $dev['v_nombres'] . "</td>
					<td class='text-center'><span class='badge bg-info'>" . $dev['v_nommes'] . "</span></td>
					<td class='text-center'><span class='badge bg-primary'>" . $dev['i_anhio'] . "</span></td>
					<td class='text-center'>" . $dev['d_finicio'] . "</td>
					<td class='text-center'>" . $dev['d_ffin'] . "</td>
					<td class='text-center'>" . $dev['v_total'] . "</td>
					<td class='text-center'><span class='badge bg-" . $dev['v_color_tipo'] . "'>" . $dev['v_tipo'] . "</span></td>
					<td class='text-center'>" . $dev['d_aprobado'] . "</td>
					<td class='text-center'>" . $dev['d_corte'] . "</td>
					<td class='text-center'><span class='badge bg-" . $dev['v_color'] . "'>" . $dev['v_generado'] . "</span></td>
					<td class='text-center'>
						" . $div . "
					</td>
				</tr>";
			};

			$this->_view->pagomes = $filas;
			$this->_view->stylefila = $stylefila;
			$this->_view->pagomespasado = $filas1;
			$this->_view->stylefila1 = $stylefila1;
			$this->_view->enviopago = $filas2;
			$this->_view->stylefila2 = $stylefila2;
			$this->_view->btconfirmado = $btconfirmado;

			$this->_view->setJs(array('pagovacaciones'));
			$this->_view->renderizar('pagovacaciones');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function mantenimiento_pagovacaciones()
	{
		if (isset($_SESSION['usuario'])) {

			$post = $_POST['post'];
			$mes = $_POST['mes'];
			$anhio = $_POST['anhio'];
			$fecha = $_POST['fecha'];
			$ivac = $_POST['ivac'];

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
				"post" 		=> $post,
				"mes" 		=> $mes,
				"anhio" 	=> $anhio,
				"fecha" 	=> $fecha,
				"ivac" 		=> $ivac,
				"user" 		=> $_SESSION['dni']
			);

			$soap = new SoapClient($wsdl, $options);
			$result = $soap->MantPagovacaciones($param);
			$mantpagovacaciones = json_decode($result->MantPagovacacionesResult, true);

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"vicon" 		=> $mantpagovacaciones[0]['v_icon'],
					"vtitle" 		=> $mantpagovacaciones[0]['v_title'],
					"vtext" 		=> $mantpagovacaciones[0]['v_text'],
					"itimer" 		=> $mantpagovacaciones[0]['i_timer'],
					"icase" 		=> $mantpagovacaciones[0]['i_case'],
					"vprogressbar" 	=> $mantpagovacaciones[0]['v_progressbar'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function descargar_reporte()
	{
		if (isset($_SESSION['usuario'])) {

			$mes = $_GET['mes'];
			$anhio = $_GET['anhio'];

			function html_caracteres($string)
			{
				$string = str_replace(
					array('&amp;', '&Ntilde;', '&Aacute;', '&Eacute;', '&Iacute;', '&Oacute;', '&Uacute;'),
					array('&', 'Ñ', 'Á', 'É', 'Í', 'Ó', 'Ú'),
					$string
				);
				return $string;
			}

			$this->getLibrary('PHPExcel/PHPExcel');

			// Crea un nuevo objeto PHPExcel
			$objPHPExcel = new PHPExcel();

			// Establecer propiedades
			$objPHPExcel->getProperties()
				->setCreator("Joseph Magallanes")
				->setLastModifiedBy("Portal web RRHH")
				->setTitle("Formato pago de vacaciones")
				->setSubject("Formato pago de vacaciones")
				->setDescription("Formato para exportar pago de personal en fecha")
				->setKeywords("Excel Office 2007 openxml")
				->setCategory("Formatos");

			//AQUI SERVICIO DE CONSULTA E ITERAR
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
				"mes"	=> $mes,
				"anhio"	=> $anhio,
			);

			$soap = new SoapClient($wsdl, $options);
			$result = $soap->ListaReportePagoVacaciones($param);
			$report = json_decode($result->ListaReportePagoVacacionesResult, true);

			//titulos del reporte y datos donde va cada informacion
			$objPHPExcel->setActiveSheetIndex(0);

			$objPHPExcel->getActiveSheet()->setCellValue('B1', 'VACACIONES VERDUM PERÚ S.A.C.');
			$objPHPExcel->getActiveSheet()->mergeCells('B1:C1');

			$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Periodo :');
			$objPHPExcel->getActiveSheet()->setCellValue('C2', $report[0]['v_periodo']);

			// Fuente de la primera fila en negrita
			$boldArray = array('font' => array('bold' => true,), 'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));

			$objPHPExcel->getActiveSheet()->getStyle('B1:C1')->applyFromArray($boldArray);
			$objPHPExcel->getActiveSheet()->getStyle('B2:C2')->applyFromArray($boldArray);
			$objPHPExcel->getActiveSheet()->getStyle('A4:P4')->applyFromArray($boldArray);

			$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			$objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

			$objPHPExcel->getActiveSheet()->setCellValue('A4', 'N°');
			$objPHPExcel->getActiveSheet()->setCellValue('B4', 'DNI');
			$objPHPExcel->getActiveSheet()->setCellValue('C4', 'Nombres y Apellidos');
			$objPHPExcel->getActiveSheet()->setCellValue('D4', 'Area');
			$objPHPExcel->getActiveSheet()->setCellValue('E4', 'Cargo');
			$objPHPExcel->getActiveSheet()->setCellValue('F4', 'Zona');
			$objPHPExcel->getActiveSheet()->setCellValue('G4', 'Banco');
			$objPHPExcel->getActiveSheet()->setCellValue('H4', 'CTA');
			$objPHPExcel->getActiveSheet()->setCellValue('I4', 'AFP');
			$objPHPExcel->getActiveSheet()->setCellValue('J4', 'Basico');
			$objPHPExcel->getActiveSheet()->setCellValue('K4', 'Fecha Inicio');
			$objPHPExcel->getActiveSheet()->setCellValue('L4', 'Fecha Fin');
			$objPHPExcel->getActiveSheet()->setCellValue('M4', 'Dias');
			$objPHPExcel->getActiveSheet()->setCellValue('N4', 'VAC');
			$objPHPExcel->getActiveSheet()->setCellValue('O4', 'T.Ingresos');
			$objPHPExcel->getActiveSheet()->setCellValue('P4', 'SNeto');

			// COLOCAR MARCO A LAS CELDAS
			$rango = 'A4:P4';
			$styleArray = array(
				'font' => array('name' => 'Calibri', 'size' => 9),
				'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '#FFFFFF'))) //9BC2E6 FFFFFF
			);
			$objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle($rango)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('9BC2E6'); // color de encabezado

			$rowcel = 5;
			for ($i = 0; $i < count($report); $i++) {

				$objPHPExcel->getActiveSheet()->setCellValue('A' . $rowcel, $report[$i]['row']); //0
				$objPHPExcel->getActiveSheet()->setCellValue('B' . $rowcel, $report[$i]['v_dni']); //1
				$objPHPExcel->getActiveSheet()->setCellValue('C' . $rowcel, html_caracteres($report[$i]['v_nombres'])); //2
				$objPHPExcel->getActiveSheet()->setCellValue('D' . $rowcel, $report[$i]['v_area']); //3
				$objPHPExcel->getActiveSheet()->setCellValue('E' . $rowcel, $report[$i]['v_cargo']); //4
				$objPHPExcel->getActiveSheet()->setCellValue('F' . $rowcel, $report[$i]['v_zona']); //5
				$objPHPExcel->getActiveSheet()->setCellValue('G' . $rowcel, $report[$i]['v_banco']); //6
				$objPHPExcel->getActiveSheet()->setCellValue('H' . $rowcel, $report[$i]['v_cta']); //7
				$objPHPExcel->getActiveSheet()->setCellValue('I' . $rowcel, $report[$i]['v_afp']); //8
				$objPHPExcel->getActiveSheet()->setCellValue('J' . $rowcel, $report[$i]['f_basico']); //9
				$objPHPExcel->getActiveSheet()->setCellValue('K' . $rowcel, $report[$i]['d_finicio']); //10
				$objPHPExcel->getActiveSheet()->setCellValue('L' . $rowcel, $report[$i]['d_ffin']); //11
				$objPHPExcel->getActiveSheet()->setCellValue('M' . $rowcel, $report[$i]['v_total']); //12
				$objPHPExcel->getActiveSheet()->setCellValue('N' . $rowcel, $report[$i]['f_vacaciones']); //13
				$objPHPExcel->getActiveSheet()->setCellValue('O' . $rowcel, $report[$i]['f_ingresos']); //14
				$objPHPExcel->getActiveSheet()->setCellValue('P' . $rowcel, $report[$i]['f_sneto']); //15

				$rango = 'A' . $rowcel . ":" . 'P' . $rowcel;
				$styleArray = array(
					'font' => array('name' => 'Calibri', 'size' => 9),
					'borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '#FFFFFF')))
				);

				// FORMATO DE CELDAS
				$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $rowcel)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->getActiveSheet()->getCellByColumnAndRow(7, $rowcel)->setDataType(PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->getActiveSheet()->getStyle('J' . $rowcel)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$objPHPExcel->getActiveSheet()->getStyle('N' . $rowcel)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$objPHPExcel->getActiveSheet()->getStyle('O' . $rowcel)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$objPHPExcel->getActiveSheet()->getStyle('P' . $rowcel)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

				// ALINEAR TEXTO
				$objPHPExcel->getActiveSheet()->getStyle('A' . $rowcel)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				// $objPHPExcel->getActiveSheet()->getStyle('N' . $rowcel)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				// $objPHPExcel->getActiveSheet()->getStyle('O' . $rowcel)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				// $objPHPExcel->getActiveSheet()->getStyle('P' . $rowcel)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

				// FORMATO AUTOSIZE
				$objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->getColumnDimension('A', TRUE)->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('B', TRUE)->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('C', TRUE)->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('D', TRUE)->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('E', TRUE)->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('F', TRUE)->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('G', TRUE)->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('H', TRUE)->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('I', TRUE)->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('J', TRUE)->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('K', TRUE)->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('L', TRUE)->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('M', TRUE)->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('N', TRUE)->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('O', TRUE)->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getColumnDimension('P', TRUE)->setAutoSize(true);

				$rowcel++;
			}

			// Renombrar Hoja
			$objPHPExcel->getActiveSheet()->setTitle('pago_vacaciones');

			// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
			$objPHPExcel->setActiveSheetIndex(0);

			// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="pago_vacaciones_' . date('d-m-Y His') . '.xlsx"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
		} else {
			$this->redireccionar('index/logout');
		}
	}
}
