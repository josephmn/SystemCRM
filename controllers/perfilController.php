<?php

class perfilController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('home','perfil');

			$this->_view->setCss_Specific(
				array(
					'plugins/fontawesome-free/css/all.min',
					'plugins/overlayScrollbars/css/OverlayScrollbars.min',
					'dist/css/adminlte',
					//iCheck for checkboxes and radio inputs
					// 'plugins/icheck-bootstrap/icheck-bootstrap.min',
					//Bootstrap Color Picker y Tempusdominus Bootstrap 4
					'plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min',
					'plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min',
					//Select2
					'plugins/select2/css/select2.min',
					'plugins/select2-bootstrap4-theme/select2-bootstrap4.min',
					//Bootstrap4 Duallistbox
					// 'plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min',
					//daterange picker
					// 'plugins/daterangepicker/daterangepicker',
					//Bootstrap Color Picker
					// 'plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min',			
				)
			);
	
			$this->_view->setJs_Specific(
				array(
					'plugins/jquery/jquery-3.5.1',
					'plugins/bootstrap/js/bootstrap.bundle.min',
					'plugins/jquery-ui/jquery-ui.min',
					'plugins/overlayScrollbars/js/jquery.overlayScrollbars.min',
					'dist/js/adminlte',
					//Select2
					'plugins/select2/js/select2.full.min',
					//Optional 
					'dist/js/demo',
					//bs-custom-file-input
					'plugins/bs-custom-file-input/bs-custom-file-input.min',
					//InputMask
					'plugins/moment/moment.min',
					'plugins/inputmask/min/jquery.inputmask.bundle.min',
					//date-range-picker
					// 'plugins/daterangepicker/daterangepicker',
					//bootstrap color picker y Tempusdominus Bootstrap 4
					'plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min',
					'plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min',
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

			//Envio del request
			$soap = new SoapClient($wsdl, $options);
			$result = $soap->ListadoCivil();
			$datacivil = json_decode($result->ListadoCivilResult, true);

			$result2 = $soap->ListarDepartamento();
			$datadepartamento = json_decode($result2->ListarDepartamentoResult, true);

			$param = array(
				"dni" => $_SESSION['dni'],
			);

			$result3 = $soap->ListarConsultaPerfil($param);
			$respuestaperfil = json_decode($result3->ListarConsultaPerfilResult, true);

			// VALIDAR PROVINCIA
			if (empty($respuestaperfil)){
				$param1 = array(
					"departamento" => 0,
				);

				$result4 = $soap->ListarProvincia($param1);
				$dataprovincia = json_decode($result4->ListarProvinciaResult, true);
				
				$this->_view->dataprovincia = $dataprovincia;
			}else{
				$param1 = array(
					"departamento" => $respuestaperfil[0]['v_departamento'],
				);

				$result4 = $soap->ListarProvincia($param1);
				$dataprovincia = json_decode($result4->ListarProvinciaResult, true);
				
				$this->_view->dataprovincia = $dataprovincia;
			}

			// VALIDAR DISTRITO
			if (empty($respuestaperfil)){
				$param2 = array(
					"provincia" => 0,
				);

				$result5 = $soap->ListarDistrito($param2);
				$datadistritos = json_decode($result5->ListarDistritoResult, true);
				
				$this->_view->datadistritos = $datadistritos;
			}else{
				$param2 = array(
					"provincia" => $respuestaperfil[0]['v_provincia'],
				);
				
				$result5 = $soap->ListarDistrito($param2);
				$datadistritos = json_decode($result5->ListarDistritoResult, true);
				
				$this->_view->datadistritos = $datadistritos;
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

			$this->_view->datacivil = $datacivil;
			$this->_view->datadepartamento = $datadepartamento;
			$this->_view->respuestaperfil = $respuestaperfil;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function cargar_provincia()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");
			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$departamento = $_POST['departamento'];

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
				"departamento" => $departamento,
			);

			//Envio del request
			$soap = new SoapClient($wsdl, $options);
			$result = $soap->ListarProvincia($param);
			$dataprovincia = json_decode($result->ListarProvinciaResult, true);
			
			$c=0;
			$filas="";
			foreach($dataprovincia as $dv){
				$filas.="<option value=".$dv['i_idpro'].">".$dv['v_descripcion']."</option>";
			$c++;	
			}

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"data" => $filas,
				)
			);

		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function cargar_distritos()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");
			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$provincia = $_POST['provincia'];

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
				"provincia" => $provincia,
			);

			//Envio del request
			$soap = new SoapClient($wsdl, $options);
			$result = $soap->ListarDistrito($param);
			$datadistritos = json_decode($result->ListarDistritoResult, true);

			$c=0;
			$filas="";
			foreach($datadistritos as $dv){
				$filas.="<option value=".$dv['i_iddis'].">".$dv['v_descripcion']."</option>";
			$c++;	
			}

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"data" => $filas,
				)
			);

		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function registrar_perfil()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");
			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$dni= $_POST['dni'];
			$nombre= $_POST['nombre'];
			$fnacimiento= $_POST['fnacimiento'];
			$civil= $_POST['civil'];
			$celular= $_POST['celular'];
			$correo= $_POST['correo'];
			$correoempresa= $_POST['correoempresa'];
			$numero_emergencia= $_POST['numero_emergencia'];
			$nombre_contacto= $_POST['nombre_contacto'];
			$departamento= $_POST['departamento'];
			$provincia= $_POST['provincia'];
			$distrito= $_POST['distrito'];
			$domicilio_actual= $_POST['domicilio_actual'];
			$referencia_actual= $_POST['referencia_actual'];

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
				"dni" => $dni,
				"nombre" => $nombre,
				"fnacimiento" => $fnacimiento,
				"civil" => $civil,
				"celular" => $celular,
				"correo" => $correo,
				"correoempresa" => $correoempresa,
				"celularsos" => $numero_emergencia,
				"nombresos" => $nombre_contacto,
				"departamento" => $departamento,
				"provincia" => $provincia,
				"distrito" => $distrito,
				"domicilioactual" => $domicilio_actual,
				"referencia" => $referencia_actual,
				"user" => $dni,
			);

			//Envio del request
			$soap = new SoapClient($wsdl, $options);
			$result = $soap->MantenimientoPerfilPersonal($param);
			$insertperfil = json_decode($result->MantenimientoPerfilPersonalResult, true);

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"vicon" 		=> $insertperfil[0]['v_icon'],
					"vtitle" 		=> $insertperfil[0]['v_title'],
					"vtext" 		=> $insertperfil[0]['v_text'],
					"itimer" 		=> $insertperfil[0]['i_timer'],
					"icase" 		=> $insertperfil[0]['i_case'],
					"vprogressbar" 	=> $insertperfil[0]['v_progressbar'],
					)
			);

		} else {
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

				// VARIABLE EN DONDE GUARDAMOS LA FECHA Y HORA
				// $fecha_hora = date("Ymd_His", time());

				// RECORTAMOS EL TIPO DE ARCHIVO Y LO GUADAMOS EN UNA VARIABLE
				$extdoc = explode("/",$_FILES["archivo"]["type"]);
				// DECIMOS EN QUE RUTA SE GUARDARA EL ARCHIVO
				// $destino = "public/doc/perfil_foto/" . ltrim(rtrim($_SESSION['dni'])) . "_" . $fecha_hora . "." .$extdoc[1];
				$destino = "public/doc/perfil_foto/".ltrim(rtrim($_SESSION['dni'])).".".$extdoc[1];

				//var_dump(BASE_URL.$destino);exit;

				if (($_FILES["archivo"]["type"] == "image/jpeg") || ($_FILES["archivo"]["type"] == "image/jpg") || ($_FILES["archivo"]["type"] == "image/png")) {
					if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino)) {

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
						$result = $soap->MantenimientoFotoperfil($param);
						$fotoperfil = json_decode($result->MantenimientoFotoperfilResult, true);

						$_SESSION['foto'] = $destino;

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
				} else {// tipo archivo erroneo
					echo $json->encode(
						array(
							"vicon" 		=> "error",
							"vtitle" 		=> "Formato de archivo incorrecto...",
							"vtext" 		=> "Subir archivo con extensión JPG o PNG!",
							"itimer" 		=> 3000,
							"icase" 		=> 3,
							"vprogressbar" 	=> true,
							"url"			=> ""
							)
					);
				}
			} else {// archivo no existe
				echo $json->encode(
					array(
						"vicon" 		=> "error",
						"vtitle" 		=> "Archivo no encontrado...",
						"vtext" 		=> "No se encontro archivo de origen!",
						"itimer" 		=> 3000,
						"icase" 		=> 4,
						"vprogressbar" 	=> true,
						"url"			=> "",
						)
				);
			}
		} else {
			$this->redireccionar('index/logout');
		}
	}

}
?>