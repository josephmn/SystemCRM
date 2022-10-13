<?php

class periodosController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('configuracion','periodos');

			$this->_view->setCss_Specific(
				array(
					'plugins/fontawesome-free/css/all.min',
					'plugins/overlayScrollbars/css/OverlayScrollbars.min',
					'dist/css/adminlte',
					//DataTables>
					'plugins/datatables-responsive/css/responsive.bootstrap4.min',
					'plugins/datatables-net/css/jquery.dataTables.min',
					'plugins/datatables-net/css/searchPanes.dataTables.min',
					'plugins/datatables-net/select.dataTables.min',
					'plugins/datatables-net/css/buttons.dataTables.min',
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
					'plugins/datatables-net/js/dataTables.searchPanes.min',
					'plugins/datatables-net/js/dataTables.select.min',
					'plugins/datatables-net/js/dataTables.buttons.min',
					'plugins/datatables-net/js/buttons.flash.min',
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

			$result = $soap->PeriodosBoletas();
			$periodoboletas = json_decode($result->PeriodosBoletasResult, true);

			// NOTIFICACIONES TOTAL
			$param100 = array(
				"post"	=> 2,  	// consultar por DNI para obtener cantidad de notificaciones
				"top"	=> 0,	// no se usa para esta consulta
				"dni"	=> $_SESSION['dni'],
			);

			$result100 = $soap->ListarPaNotificaciones($param100);
			$countnoti = json_decode($result100->ListarPaNotificacionesResult, true);

			$_SESSION['num_notificaciones'] = intval($countnoti[0]['i_delay']);

			$this->_view->periodoboletas = $periodoboletas;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function mantenimiento_accesos()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");
			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$post = $_POST["post"];
			$menu = $_POST["menu"];
			$submenu = $_POST["submenu"];
			$perfil = $_POST["perfil"];
			$tipo = $_POST["tipo"];

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

			$param = array(
				"post" 		=> $post,
				"menu" 		=> $menu,
				"submenu" 	=> $submenu,
				"perfil" 	=> $perfil,
				"tipo" 		=> $tipo,
				"user"		=> $_SESSION['dni']
			);

			$result = $soap->MantPerfilesAccesos($param);
			$mantperfiles = json_decode($result->MantPerfilesAccesosResult, true);

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"vicon" 		=> $mantperfiles[0]['v_icon'],
					"vtitle" 		=> $mantperfiles[0]['v_title'],
					"vtext" 		=> $mantperfiles[0]['v_text'],
					"itimer" 		=> $mantperfiles[0]['i_timer'],
					"icase" 		=> $mantperfiles[0]['i_case'],
					"vprogressbar" 	=> $mantperfiles[0]['v_progressbar'],
				)
			);

		} else {
			$this->redireccionar('index/logout');
		}
	}

    public function mantenimiento_periodoboleta()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");
			
			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			if (is_array($_FILES) && count($_FILES) > 0) {

				// VARIABLE EN DONDE GUARDAMOS LA FECHA Y HORA
				$fecha_hora = date("Ymd_His", time());

				// RECORTAMOS EL TIPO DE ARCHIVO Y LO GUADAMOS EN UNA VARIABLE
				$extdoc = explode("/",$_FILES["archivo"]["type"]);
				// DECIMOS EN QUE RUTA SE GUARDARA EL ARCHIVO
				// $destino = "public/doc/perfil_foto/" . ltrim(rtrim($_SESSION['dni'])) . "_" . $fecha_hora . "." .$extdoc[1];
				$destino = "public/doc/firma_boletas/firma_".$fecha_hora.".".$extdoc[1];

				if (($_FILES["archivo"]["type"] == "image/jpeg") || ($_FILES["archivo"]["type"] == "image/jpg") || ($_FILES["archivo"]["type"] == "image/png")) {

					if ($_FILES['archivo']['size'] > 1050000) {
						echo $json->encode(// tipo archivo erroneo
							array(
								"vicon" 		=> "info",
								"vtitle" 		=> "Archivo sobrepasa 1 Mb.",
								"vtext" 		=> "Favor de subir un archivo mas ligero...!!!",
								"itimer" 		=> 3000,
								"icase" 		=> 4,
								"vprogressbar" 	=> true,
							)
						);
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

                        $params = array(
                            'post'      => $_POST['post'],
                            'id'        => $_POST['id'],
                            'periodo'   => $_POST['periodo'],
                            'estado'    => $_POST['estado'],
                            'firma'     => $destino,
                            'user'      => $_SESSION['dni'],
                        );
            
                        $soap = new SoapClient($wsdl, $options);
                        $result = $soap->MantPeriodosBoletas($params);
                        $perboleta = json_decode($result->MantPeriodosBoletasResult, true);

                        header('Content-type: application/json; charset=utf-8');
                        echo $json->encode(
                            array(
                                "vicon" 		=> $perboleta[0]['v_icon'],
                                "vtitle" 		=> $perboleta[0]['v_title'],
                                "vtext" 		=> $perboleta[0]['v_text'],
                                "itimer" 		=> intval($perboleta[0]['i_timer']),
                                "icase" 		=> intval($perboleta[0]['i_case']),
                                "vprogressbar" 	=> $perboleta[0]['v_progressbar'],
                            )
                        );

                        if (intval($perboleta[0]['i_case']) < 5){
                            move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino);
                        }

					}

				} else {
					echo $json->encode(// tipo archivo erroneo
						array(
							"vicon" 		=> "info",
							"vtitle" 		=> "Tipo de archivo no admitido",
							"vtext" 		=> "Favor de subir un archivo: *jpeg | *jpg | *png ...!!!",
							"itimer" 		=> 3000,
							"icase" 		=> 2,
							"vprogressbar" 	=> true,
						)
					);
				}
			} else {
				echo $json->encode(// archivo no existe
					array(
						"vicon" 		=> "error",
						"vtitle" 		=> "Archivo de origen no encontrado",
						"vtext" 		=> "Favor de volver a intentar subir un archivo...!!!",
						"itimer" 		=> 3000,
						"icase" 		=> 3,
						"vprogressbar" 	=> true,
					)
				);
			}
		} else {
			$this->redireccionar('index/logout');
		}
	}

    public function mantenimiento_periodoboleta2()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");
			
			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

            $post = $_POST['post'];
            $id = $_POST['id'];
            $periodo = $_POST['periodo'];
            $estado = $_POST['estado'];

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
                'post'      => $post,
                'id'        => $id,
                'periodo'   => $periodo,
                'estado'    => $estado,
                'firma'     => '',
                'user'      => $_SESSION['dni'],
            );

            $soap = new SoapClient($wsdl, $options);
            $result = $soap->MantPeriodosBoletas($params);
            $perboleta = json_decode($result->MantPeriodosBoletasResult, true);

            header('Content-type: application/json; charset=utf-8');
            echo $json->encode(
                array(
                    "vicon" 		=> $perboleta[0]['v_icon'],
                    "vtitle" 		=> $perboleta[0]['v_title'],
                    "vtext" 		=> $perboleta[0]['v_text'],
                    "itimer" 		=> intval($perboleta[0]['i_timer']),
                    "icase" 		=> intval($perboleta[0]['i_case']),
                    "vprogressbar" 	=> $perboleta[0]['v_progressbar'],
                )
            );

		}
	}

}
?>