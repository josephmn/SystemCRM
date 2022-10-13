<?php

class viveverdumController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('verdum','viveverdum');

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
					'dist/js/demo',
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

			$parm1 = array(
				'post' 	=> 0, //0 -- consuta publicados, 1 --consultar todos, otro numero --consulta x id
				'id'	=> 0, // se usa aqui
			);

			// convenios
			$result1 = $soap->ListarConvenios($parm1);
			$convenios = json_decode($result1->ListarConveniosResult, true);

			$filas = "";
			foreach ($convenios as $cnv) {
				$vref = "";
				if ($cnv['v_href'] == "#") {
					$vref = "#";
				} else {
					$vref = BASE_URL . $cnv['v_href'];
				}

				$filas .=
					"<div class='col-md-12 col-lg-6 col-xl-4'>
					<div class='card mb-2' style='border-radius: 10px; -webkit-border-radius: 10px;'>
						<a id='" . $cnv['i_id'] . "' href='" . $vref . "' class='" . $cnv['v_class'] . "' " . $cnv['v_target'] . ">
							<img class='card-img-top' style='border:1px solid black; -webkit-border-radius: 10px;' src='" . BASE_URL . $cnv['v_tarjeta'] . "'>
						</a>
					</div>
				</div>";
			};

			$parm2 = array(
				'post' 	=> 0, //0 -- consuta publicados, 1 --consultar todos, otro numero --consulta x id
				'id'	=> 0, // se usa aqui
			);

			// convenios educativos
			$result2 = $soap->ListarConveniosEducativos($parm2);
			$conveniosedu = json_decode($result2->ListarConveniosEducativosResult, true);

			$filase = "";
			foreach ($conveniosedu as $cnve) {
				$vrefv = "";
				if ($cnve['v_href'] == "#") {
					$vrefv = "#";
				} else {
					$vrefv = BASE_URL . $cnve['v_href'];
				}

				$filase .=
					"<div class='col-md-12 col-lg-6 col-xl-4'>
						<div class='card mb-2' style='border-radius: 10px; -webkit-border-radius: 10px;'>
							<a id='" . $cnve['i_id'] . "' href='" . $vrefv . "' class='" . $cnve['v_class'] . "' " . $cnve['v_target'] . ">
								<img class='card-img-top' style='border:1px solid black; -webkit-border-radius: 10px;' src='" . BASE_URL . $cnve['v_tarjeta'] . "'>
							</a>
						</div>
					</div>";
			};

			$flex = "";
			if ($_SESSION['flex'] == 1) {
				$flex = "
				<div class='card mb-2' style='border-radius: 10px; -webkit-border-radius: 10px;'>
					<a href='" . BASE_URL . "viveverdum/flextime/'>
						<img class='card-img-top' style='border:1px solid black; -webkit-border-radius: 10px;' src='" . BASE_URL . "public/dist/img/beneficios/beneficios/flex-time.jpg'>
					</a>
				</div>";
			} else {
				$flex = "";
			}

			$remoto = "";
			if ($_SESSION['remoto'] == 1) {
				$remoto = "
				<div class='card mb-2' style='border-radius: 10px; -webkit-border-radius: 10px;'>
					<a href='" . BASE_URL . "viveverdum/remoto/'>
						<img class='card-img-top' style='border:1px solid black; -webkit-border-radius: 10px;' src='" . BASE_URL . "public/dist/img/beneficios/beneficios/trabajo-remoto.jpg'>
					</a>
				</div>";
			} else {
				$remoto = "";
			}

			$venta = "";
			if ($_SESSION['venta'] == 1) {
				$venta = "
				<!-- VENTA INTERNA -->
				<section class='col-lg-6 connectedSortable'>
					<div class='card card-gray'>
						<div class='card-header'>
							<h3 class='card-title'>
								<i class='fa-solid fa-cart-shopping fa-bounce'></i>
								&nbsp;<strong>VENTA INTERNA</strong>
							</h3>
							<div class='card-tools'>
							</div>
						</div>
	
						<div class='card-body'>
							<div class='row'>
								<div class='col-md-12 col-lg-6 col-xl-4'>
									<div id='envio_correo' class='card mb-2' style='border-radius: 10px; -webkit-border-radius: 10px;'>
										<img class='card-img-top' style='border:1px solid black; -webkit-border-radius: 10px;' src='" . BASE_URL . "public/dist/img/beneficios/venta/correo.jpg'>
									</div>
								</div>
							</div>
	
						</div>
	
					</div>
				</section>";
			} else {
				$venta = "";
			}

			$div_flex = "";

			if ($_SESSION['flex'] == 0) {
				$div_flex = "";
			} else {
				$div_flex = "
				<div id='flex' class='col-md-12 col-lg-6 col-xl-4'>"
					.$flex."
				</div>";
			}

			$div_remoto = "";
			
			if ($_SESSION['remoto'] == 0) {
				$div_remoto = "";
			} else {
				$div_remoto = "
				<div id='flex' class='col-md-12 col-lg-6 col-xl-4'>"
					.$remoto."
				</div>";
			}

			$verdum = "
			<!-- BENEFICIOS -->
			<section class='col-lg-6 connectedSortable'>
				<div class='card card-gray'>
					<div class='card-header'>
						<h3 class='card-title'>
							<i class='fas fa-star fa-spin'></i>
							&nbsp;<strong>BENEFICIOS</strong>
						</h3>
						<div class='card-tools'>
						</div>
					</div>

					<div class='card-body'>

						<div class='row'>
							".$div_flex."
							".$div_remoto."
							<div id='cumpleanios' class='col-md-12 col-lg-6 col-xl-4'>
								<div class='card mb-2' style='border-radius: 10px; -webkit-border-radius: 10px;'>
									<a href='" . BASE_URL . "viveverdum/cumpleanios/'>
										<img class='card-img-top' style='border:1px solid black; -webkit-border-radius: 10px;' src='" . BASE_URL . "public/dist/img/beneficios/beneficios/feliz-cumpleaños.jpg'>
									</a>
								</div>
							</div>
						</div>

					</div>

				</div>
			</section>

			".$venta."
			";

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
			$this->_view->filase = $filase;
			$this->_view->flex = $flex;
			$this->_view->remoto = $remoto;
			$this->_view->verdum = $verdum;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
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
						array('[usuario]', '[dni]', '[nombre]', '[perfil]', '[razon]', '[ruc]', '[nombrecomercial]', '[fecha]', '[fechahora]'),
						array($_SESSION['usuario'], $_SESSION['dni'], $_SESSION['nombre'], $_SESSION['perfil'], 'VERDUM PERÚ S.A.C.', ruc, nombrecomercial, fechasis, fechahorasis),
						$string
					);
					return $string;
				}

				$fuente =  __DIR__ . "/fonts/" . "GOTHICB.TTF";
				$img2 = imagecreatefromjpeg($imgconvenio[0]['v_ventana']);

				// foreach
				foreach ($listaconveniodisenio as $dsn) {

					$color = $dsn['v_color'];
					$colornew = str_replace("#", "", $color);

					$split = str_split($colornew, 2);
					$r = hexdec($split[0]);
					$g = hexdec($split[1]);
					$b = hexdec($split[2]);

					$textnew = datos_globales($dsn['v_texto']);
					$black = imagecolorallocate($img2, $r, $g, $b);

					imagettftext($img2, $dsn['i_tamanio'], $dsn['i_angulo'], $dsn['i_posicionx'], $dsn['i_posiciony'], $black, $fuente, $textnew);
				}

				$salida = "public/dist/img/beneficios/convenios/ventana/" . $nombre . ".jpg";

				imagejpeg($img2, $salida);
				imagedestroy($img2);

				$div_new = "
				<img class='card-img-top' style='-webkit-border-radius: 10px;' src='" . BASE_URL . $salida . "'>
				";
			} else {
				// obtener imagen principal
				$div_new = "
				<img class='card-img-top' style='border:1px solid black; -webkit-border-radius: 10px;' src='" . BASE_URL . $imgconvenio[0]['v_ventana'] . "'>
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
			unlink("public/dist/img/beneficios/convenios/ventana/" . $nombre . ".jpg");
			// echo 'correcto';

		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function obtenerimg()
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
				'id'	=> $id, // id para armar el div de imagen
			);

			$result1 = $soap->ListarConvenios($parm1);
			$imgconvenio = json_decode($result1->ListarConveniosResult, true);

			$div_new = "";

			$div_new = "
			<img class='card-img-top' style='-webkit-border-radius: 10px;' src='" . BASE_URL . $imgconvenio[0]['v_ventana'] . "'>
			";

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"div" => $div_new,
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function obtenerpdf()
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
				'id'	=> $id, // id para armar el div de imagen
			);

			$result1 = $soap->ListarConvenios($parm1);
			$pdfconvenio = json_decode($result1->ListarConveniosResult, true);

			$div_new = "";

			$div_new = "
			<div class='flex-slider-custom'>
				<embed type='application/pdf' src='" . BASE_URL . $pdfconvenio[0]['v_ventana'] . "' style='width:100%' height='650px'>
			</div>";

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"div" => $div_new,
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function obtenerpdf_edu()
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
				'id'	=> $id, // id para armar el div de imagen
			);

			$result1 = $soap->ListarConveniosEducativos($parm1);
			$pdfconvenioedu = json_decode($result1->ListarConveniosEducativosResult, true);

			$div_new = "";

			$div_new = "
			<div class='flex-slider-custom'>
				<embed type='application/pdf' src='" . BASE_URL . $pdfconvenioedu[0]['v_ventana'] . "' style='width:100%' height='650px'>
			</div>";

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"div" => $div_new,
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function flextime()
	{
		if (isset($_SESSION['usuario'])) {

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
					//Optional 
					'dist/js/demo',
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
				'id' 		=> 3, // cargar combo
				'idflex' 	=> 0, // no se usa aqui
				'zona'		=> $_SESSION['zona'],
				'local'		=> $_SESSION['local'],
			);

			$result = $soap->ListarFlexTime($param);
			$flexcombo = json_decode($result->ListarFlexTimeResult, true);

			$params2 = array(
				'post' => 2, // listar semanas flex time
				'user' => $_SESSION['dni'],
			);

			$result2 = $soap->ListarSemana($params2);
			$semana = json_decode($result2->ListarSemanaResult, true);

			$param3 = array(
				"post" => 3, //mostrar años
			);

			$result3 = $soap->Listarmeses($param3);
			$anhios = json_decode($result3->ListarmesesResult, true);

			$param4 = array(
				"post"		=> 1, // llenar tabla flex time x personal
				"user"		=> $_SESSION['dni'],
				"anhio"		=> date("Y"),
				"mes"		=> date("n"),
			);

			$result4 = $soap->TablaFlexTime($param4);
			$tbflex = json_decode($result4->TablaFlexTimeResult, true);

			$param5 = array(
				"post" => 2, //mostrar los meses
			);

			$result = $soap->Listarmeses($param5);
			$meses = json_decode($result->ListarmesesResult, true);

			// construimos la tabla
			$filas = "";
			foreach ($tbflex as $tb) {

				if ($tb['i_estado'] == 1) {
					$a = "<a id='" . $tb['i_id'] . "' class='btn btn-danger btn-sm text-white delete'><i class='fa fa-trash-alt'></i></a>";
				} else {
					$a = "";
				}

				$filas .= "
				<tr>
					<td class='text-center'>" . $tb['i_id'] . "</td>
					<td class='text-center'>" . $tb['i_semana'] . "</td>
					<td class='text-center'><span class='badge bg-warning'>" . $tb['v_flex'] . "</span></td>
					<td class='text-center'><span class='badge bg-info'>" . $tb['v_descripcion'] . "</span></td>
					<td class='text-center'><span class='badge bg-" . $tb['v_color_estado'] . "'>" . $tb['v_estado'] . "</span></td>
					<td class='text-center'>" . $tb['d_fregistro'] . "</td>
					<td class='text-center'>" . $tb['d_faprobacion'] . "</td>
					<td class='text-center'>
						" . $a . "
					</td>
				</tr>
				";
			};

			$this->_view->flexcombo = $flexcombo;
			$this->_view->semana = $semana;
			$this->_view->anhios = $anhios;
			$this->_view->meses = $meses;
			$this->_view->tbflex = $filas;

			$this->_view->setJs(array('flextime'));
			$this->_view->renderizar('flextime');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function construir_tabla()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$anhio = $_POST['anhio'];
			$mes = $_POST['mes'];

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

			$param4 = array(
				"post"		=> 1, // llenar tabla flex time x personal
				"user"		=> $_SESSION['dni'],
				"anhio"		=> $anhio,
				"mes"		=> $mes,
			);

			$result4 = $soap->TablaFlexTime($param4);
			$tbflex = json_decode($result4->TablaFlexTimeResult, true);

			// construimos la tabla
			$filas = "";
			foreach ($tbflex as $tb) {

				if ($tb['i_estado'] == 1) {
					$a = "<a id='" . $tb['i_id'] . "' class='btn btn-danger btn-sm text-white delete'><i class='fa fa-trash-alt'></i></a>";
				} else {
					$a = "";
				}

				$filas .= "
				<tr>
					<td class='text-center'>" . $tb['i_id'] . "</td>
					<td class='text-center'>" . $tb['i_semana'] . "</td>
					<td class='text-center'><span class='badge bg-warning'>" . $tb['v_flex'] . "</span></td>
					<td class='text-center'><span class='badge bg-info'>" . $tb['v_descripcion'] . "</span></td>
					<td class='text-center'><span class='badge bg-" . $tb['v_color_estado'] . "'>" . $tb['v_estado'] . "</span></td>
					<td class='text-center'>" . $tb['d_fregistro'] . "</td>
					<td class='text-center'>" . $tb['d_faprobacion'] . "</td>
					<td class='text-center'>
						" . $a . "
					</td>
				</tr>
				";
			};

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"div" => $filas,
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function mantenimiento_flextime()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$post = $_POST['post'];
			$id = $_POST['id'];
			$semana = $_POST['semana']; // array semanas
			$flex = $_POST['flex'];

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

			//array semanas
			$i = 0;
			foreach ($semana as $di) {
				$params[$i] = array(
					'post' 		=> $post,
					'id' 		=> $id,
					'semana' 	=> $di,
					'flex' 		=> $flex,
					'zona' 		=> $_SESSION['zona'],
					'local' 	=> $_SESSION['local'],
					'user' 		=> $_SESSION['dni'],
				);
				$result = $soap->MantTablaFlexTime($params[$i]);
				$tbflex = json_decode($result->MantTablaFlexTimeResult, true);
				$i++;
			}

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"vicon" 		=> $tbflex[0]['v_icon'],
					"vtitle" 		=> $tbflex[0]['v_title'],
					"vtext" 		=> $tbflex[0]['v_text'],
					"itimer" 		=> $tbflex[0]['i_timer'],
					"icase" 		=> $tbflex[0]['i_case'],
					"vprogressbar" 	=> $tbflex[0]['v_progressbar'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function eliminar_flextime()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$post = $_POST['post'];
			$id = $_POST['id'];
			$semana = $_POST['semana']; // array semanas
			$flex = $_POST['flex'];

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
				'semana' 	=> $semana,
				'flex' 		=> $flex,
				'zona' 		=> $_SESSION['zona'],
				'local' 	=> $_SESSION['local'],
				'user' 		=> $_SESSION['dni'],
			);
			$result = $soap->MantTablaFlexTime($params);
			$tbflex = json_decode($result->MantTablaFlexTimeResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"vicon" 		=> $tbflex[0]['v_icon'],
					"vtitle" 		=> $tbflex[0]['v_title'],
					"vtext" 		=> $tbflex[0]['v_text'],
					"itimer" 		=> $tbflex[0]['i_timer'],
					"icase" 		=> $tbflex[0]['i_case'],
					"vprogressbar" 	=> $tbflex[0]['v_progressbar'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function remoto()
	{
		if (isset($_SESSION['usuario'])) {

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
					//Optional 
					'dist/js/demo',
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

			$params2 = array(
				'post' => 3, // listar semanas remoto
				'user' => $_SESSION['dni'],
			);

			$result2 = $soap->ListarSemana($params2);
			$semana = json_decode($result2->ListarSemanaResult, true);

			$param3 = array(
				"post" => 3, //mostrar años
			);

			$result3 = $soap->Listarmeses($param3);
			$anhios = json_decode($result3->ListarmesesResult, true);

			$param4 = array(
				"post"		=> 1, // llenar tabla flex time x personal
				"user"		=> $_SESSION['dni'],
				"anhio"		=> date("Y"),
			);

			$result4 = $soap->TablaRemoto($param4);
			$tbremoto = json_decode($result4->TablaRemotoResult, true);

			// construimos la tabla
			$filas = "";
			foreach ($tbremoto as $tb) {

				if ($tb['i_estado'] == 1) {
					$a = "<a id='" . $tb['i_id'] . "' class='btn btn-danger btn-sm text-white delete'><i class='fa fa-trash-alt'></i></a>";
				} else {
					$a = "";
				}

				$filas .= "
				<tr>
					<td class='text-center'>" . $tb['i_id'] . "</td>
					<td class='text-center'>" . $tb['i_semana'] . "</td>
					<td class='text-center'><span class='badge bg-secondary'>" . $tb['v_mes'] . "</span></td>
					<td class='text-center'><span class='badge bg-info'>" . $tb['v_descripcion'] . "</span></td>
					<td class='text-center'><span class='badge bg-" . $tb['v_color_estado'] . "'>" . $tb['v_estado'] . "</span></td>
					<td class='text-center'>" . $tb['d_fregistro'] . "</td>
					<td class='text-center'>" . $tb['d_faprobacion'] . "</td>
					<td class='text-center'>
						" . $a . "
					</td>
				</tr>
				";
			};

			$this->_view->semana = $semana;
			$this->_view->anhios = $anhios;
			$this->_view->tbflex = $filas;

			$this->_view->setJs(array('remoto'));
			$this->_view->renderizar('remoto');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function construir_tabla_remoto()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$anhio = $_POST['anhio'];

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

			$param4 = array(
				"post"		=> 1, // llenar tabla flex time x personal
				"user"		=> $_SESSION['dni'],
				"anhio"		=> date("Y"),
			);

			$result4 = $soap->TablaRemoto($param4);
			$tbremoto = json_decode($result4->TablaRemotoResult, true);

			// construimos la tabla
			$filas = "";
			foreach ($tbremoto as $tb) {

				if ($tb['i_estado'] == 1) {
					$a = "<a id='" . $tb['i_id'] . "' class='btn btn-danger btn-sm text-white delete'><i class='fa fa-trash-alt'></i></a>";
				} else {
					$a = "";
				}

				$filas .= "
				<tr>
					<td class='text-center'>" . $tb['i_id'] . "</td>
					<td class='text-center'>" . $tb['i_semana'] . "</td>
					<td class='text-center'><span class='badge bg-secondary'>" . $tb['v_mes'] . "</span></td>
					<td class='text-center'><span class='badge bg-info'>" . $tb['v_descripcion'] . "</span></td>
					<td class='text-center'><span class='badge bg-" . $tb['v_color_estado'] . "'>" . $tb['v_estado'] . "</span></td>
					<td class='text-center'>" . $tb['d_fregistro'] . "</td>
					<td class='text-center'>" . $tb['d_faprobacion'] . "</td>
					<td class='text-center'>
						" . $a . "
					</td>
				</tr>
				";
			};

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"div" => $filas,
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function mantenimiento_remoto()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$post = $_POST['post'];
			$id = $_POST['id'];
			$semana = $_POST['semana'];

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
				'semana' 	=> $semana,
				'zona' 		=> $_SESSION['zona'],
				'local' 	=> $_SESSION['local'],
				'user' 		=> $_SESSION['dni'],
			);
			$result = $soap->MantTablaRemoto($params);
			$tbremoto = json_decode($result->MantTablaRemotoResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"vicon" 		=> $tbremoto[0]['v_icon'],
					"vtitle" 		=> $tbremoto[0]['v_title'],
					"vtext" 		=> $tbremoto[0]['v_text'],
					"itimer" 		=> $tbremoto[0]['i_timer'],
					"icase" 		=> $tbremoto[0]['i_case'],
					"vprogressbar" 	=> $tbremoto[0]['v_progressbar'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function get_confimar_marcacion()
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

			$params = array(
				'dni' 	=> $_SESSION['dni'],
			);
			$result = $soap->GetMarcacion($params);
			$marcacion = json_decode($result->GetMarcacionResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"vicon" 		=> $marcacion[0]['v_icon'],
					"vtitle" 		=> $marcacion[0]['v_title'],
					"vtext" 		=> $marcacion[0]['v_text'],
					"itimer" 		=> $marcacion[0]['i_timer'],
					"icase" 		=> $marcacion[0]['i_case'],
					"vprogressbar" 	=> $marcacion[0]['v_progressbar'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function get_mensaje_marcacion()
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

			$params = array(
				'dni' 	=> $_SESSION['dni'],
			);
			$result = $soap->MantMensajeMarcacion($params);
			$marcacion = json_decode($result->MantMensajeMarcacionResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"vicon" 		=> $marcacion[0]['v_icon'],
					"vtitle" 		=> $marcacion[0]['v_title'] . " " . $_SESSION['usuario'],
					"vtext" 		=> $marcacion[0]['v_text'],
					"itimer" 		=> $marcacion[0]['i_timer'],
					"icase" 		=> $marcacion[0]['i_case'],
					"vprogressbar" 	=> $marcacion[0]['v_progressbar'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function marcacion_remota()
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

			$params = array(
				'dni' 			=> $_SESSION['dni'],
				'comentario' 	=> "",
				'marcahuella' 	=> 0,
				'marcadni' 		=> 1,
				'temperatura' 	=> "",
				'remoto' 		=> "X",
			);
			$result = $soap->MantMarcacion($params);
			$marcacion = json_decode($result->MantMarcacionResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"vicon" 		=> $marcacion[0]['v_icon'],
					"vtitle" 		=> $marcacion[0]['v_title'],
					"vtext" 		=> $marcacion[0]['v_text'],
					"itimer" 		=> $marcacion[0]['i_timer'],
					"icase" 		=> $marcacion[0]['i_case'],
					"vprogressbar" 	=> $marcacion[0]['v_progressbar'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function cumpleanios()
	{
		if (isset($_SESSION['usuario'])) {

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
					//Select2
					'plugins/select2/css/select2.min',
					'plugins/select2-bootstrap4-theme/select2-bootstrap4.min',
					//
					'plugins/pickers/css/pickadate/pickadate',
					'plugins/pickers/css/flatpickr/flatpickr.min',
					'plugins/pickers/css/form-flat-pickr',
					'plugins/pickers/css/form-pickadate',
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
					//Optional 
					'dist/js/demo',
					'plugins/moment/moment.min',
					// //InputMask
					// 'plugins/inputmask/min/jquery.inputmask.bundle.min',
					//bootstrap color picker y Tempusdominus Bootstrap 4
					'plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min',
					'plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min',
					//sweetalert2
					'plugins/sweetalert2/sweetalert2.all',
					//
					'plugins/pickers/js/pickadate/picker',
					'plugins/pickers/js/pickadate/picker.date',
					'plugins/pickers/js/pickadate/picker.time',
					'plugins/pickers/js/pickadate/legacy',
					'plugins/pickers/js/flatpickr/flatpickr.min',
					'plugins/pickers/js/form-pickers',
					// imput mask
					'plugins/pickers/js/form-input-mask',
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

			$params2 = array(
				'post' => 3, // listar semanas remoto
				'user' => $_SESSION['dni'],
			);

			$result2 = $soap->ListarSemana($params2);
			$semana = json_decode($result2->ListarSemanaResult, true);

			$param3 = array(
				"post" => 3, //mostrar años
			);

			$result3 = $soap->Listarmeses($param3);
			$anhios = json_decode($result3->ListarmesesResult, true);

			$param4 = array(
				"dni" => $_SESSION['dni'],
			);

			$result4 = $soap->Listarcumpleaniosxdni($param4);
			$tbcumple = json_decode($result4->ListarcumpleaniosxdniResult, true);

			// construimos la tabla
			$filas = "";
			foreach ($tbcumple as $tb) {

				// revisar pdf
				if ($tb['i_estado'] == 2) {
					$a2 = "<a id='" . $tb['i_id'] . "' href='" . BASE_URL . "viveverdum/imprimir_pdf/" . $tb['i_id'] . "' target='_blank' class='btn btn-danger btn-sm text-white'><i class='fa fa-file-pdf'></i>&nbsp;&nbsp;PDF</a>";
				} else {
					$a2 = "";
				}

				// eliminar
				if ($tb['i_estado'] == 1) {
					$a = "<a id='" . $tb['i_id'] . "' class='btn btn-danger btn-sm text-white delete'><i class='fa fa-trash-alt'></i></a>";
				} else {
					$a = "";
				}

				$filas .= "
				<tr>
					<td class='text-center'>" . $tb['i_id'] . "</td>
					<td class='text-center'><span class='badge bg-info'>" . $tb['v_mes'] . "</span></td>
					<td class='text-center'>" . $tb['d_finicio'] . "</td>
					<td class='text-center'>" . $tb['d_ffin'] . "</td>
					<td class='text-center'>" . $tb['i_dias'] . "</td>
					<td class='text-center'><span class='badge bg-" . $tb['v_color_tipo'] . "'>" . $tb['v_tipo'] . "</span></td>
					<td class='text-center'><span class='badge bg-" . $tb['v_color'] . "'>" . $tb['v_estado'] . "</span></td>
					<td class='text-center'>
						" . $a2 . "
					</td>
					<td class='text-center'>" . $tb['d_fregistro'] . "</td>
					<td class='text-center'>" . $tb['d_faprobacion'] . "</td>
					<td class='text-center'>
						" . $a . "
					</td>
				</tr>
				";
			};

			$this->_view->semana = $semana;
			$this->_view->anhios = $anhios;
			$this->_view->tbcumple = $filas;

			$this->_view->setJs(array('cumpleanios'));
			$this->_view->renderizar('cumpleanios');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	// IMPRIMIR PDF DE VACACIONES
	public function imprimir_pdf($id)
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
				"post" 	=> 2, //para vacaciones por cumpleaños
				"id" 	=> $id
			);
			$soap = new SoapClient($wsdl, $options);
			$result = $soap->Listavacacionesdni($param);
			$vacacion = json_decode($result->ListavacacionesdniResult, true);

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

	public function get_cumpleanios()
	{
		if (isset($_SESSION['usuario'])) {

			$date1 = date_create($_SESSION['cumpleanios']);
			$cumple = date_format($date1, "d/m/Y");

			echo trim($cumple);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function mantenimiento_vacacion_cumpleanios()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$post = $_POST['post'];
			$id = $_POST['id'];
			$fecha = $_POST['fecha'];

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
				'fecha' 	=> $fecha,
				'user' 		=> $_SESSION['dni'],
			);
			$result = $soap->MantVacacioncumpleanios($params);
			$tbvaccum = json_decode($result->MantVacacioncumpleaniosResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"vicon" 		=> $tbvaccum[0]['v_icon'],
					"vtitle" 		=> $tbvaccum[0]['v_title'],
					"vtext" 		=> $tbvaccum[0]['v_text'],
					"itimer" 		=> $tbvaccum[0]['i_timer'],
					"icase" 		=> $tbvaccum[0]['i_case'],
					"vprogressbar" 	=> $tbvaccum[0]['v_progressbar'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function combo_sku()
	{
		if (isset($_SESSION['usuario'])) {

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

			// consultar inventario
			$param3 = array(
				"post"		=> 3,  // listar combo solo con estado activo
				"sku"		=> "",
			);

			$result3 = $soap->ListarInventario($param3);
			$sku = json_decode($result3->ListarInventarioResult, true);

			$filas = "<option value='00000' selected disabled>-- SELECCIONE --</option>";
			foreach ($sku as $sku) {
				$filas .= "<option value=" . $sku['v_sku'] . ">(" . $sku['v_sku'] . ") " . $sku['v_descripcion'] . "</option>";
			};

			echo $filas;
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function obtener_ventas_tope()
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

			// consultar top ventas
			$param = array(
				"dni"	=> $_SESSION['dni'],
			);

			$result = $soap->ListarTopeVentas($param);
			$tope = json_decode($result->ListarTopeVentasResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"cliente" 		=> $tope[0]['cliente'],
					"periodo" 		=> $tope[0]['periodo'],
					"total" 		=> $tope[0]['total'],
					"tope_venta" 	=> $tope[0]['tope_venta'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function obtener_datossku()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$sku = $_POST['sku'];

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

			// consultar inventario
			$param1 = array(
				"post"		=> 4,  // consultar por sku para obtener precio
				"sku"		=> $sku,
			);

			$result1 = $soap->ListarInventario($param1);
			$inventario = json_decode($result1->ListarInventarioResult, true);

			$case = 0;
			if (!empty($inventario[0]['v_sku'])) {
				$case = 1;
			} else {
				$case = 0;
			}

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"case"		=> $case,
					"sku" 		=> $inventario[0]['v_sku'],
					"precio" 	=> $inventario[0]['f_precio'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function enviar_correo()
	{
		date_default_timezone_set("America/Lima");

		putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
		putenv("NLS_CHARACTERSET=AL32UTF8");

		$this->getLibrary('json_php/JSON');
		$json = new Services_JSON();

		$envio_para = $_POST['envio_para'];
		$envio_cc = $_POST['envio_cc'];
		$envio_asunto = $_POST['envio_asunto'];
		$detalle = $_POST['detalle'];

		$envio_base = $_POST['envio_base'];
		$envio_igv = $_POST['envio_igv'];
		$envio_total = $_POST['envio_total'];

		$diastring =  strval(date("YmdHis"));

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

		$result2 = $soap->ConfiguracionCorreo();
		$conficorreo = json_decode($result2->ConfiguracionCorreoResult, true);

		$this->getLibrary('phpmailer/PHPMailer');
		$this->getLibrary('phpmailer/SMTP');

		$mail = new PHPMailer;

		$mail->isSMTP();
		$mail->SMTPDebug = false;
		$mail->SMTPAuth = true;
		// $mail->SMTPSecure = 'tls';
		$mail->Mailer = 'smtp';
		$mail->Host = $conficorreo[0]['v_servidor_entrante']; //mail.cafealtomayo.com.pe
		$mail->Username = $conficorreo[0]['v_correo_salida']; //reportes@cafealtomayo.com.pe
		$mail->Password = $conficorreo[0]['v_password']; //contraseña
		$mail->Port = $conficorreo[0]['i_puerto']; //25

		$mail->From = ($conficorreo[0]['v_correo_salida']); //reportes@cafealtomayo.com.pe
		$mail->FromName = $conficorreo[0]['v_nombre_salida']; // VERDUM PERÚ SAC
		// $mail->addAddress($envio_para);
		// $mail->Timeout=60;
		// $mail->addReplyTo('reportes@cafealtomayo.com.pe', 'noreplay verdum');
		$mail->addAddress('backoffice01@verdum.com');
		$mail->addAddress('backoffice02@verdum.com');
		// $mail->addAddress('programador.app02@verdum.com');

		if (!empty($envio_cc) || $envio_cc != null || $envio_cc != "") {
			$mail->addCC($envio_cc);
		}
		// CCO
		$mail->addBCC($conficorreo[0]['v_correo_salida']);
		$mail->addBCC('programador.app02@verdum.com');

		$filas = "";
		foreach ($detalle as $dt) {
			$filas .= "
			<tr>
				<td style='border: 1px solid black; border-collapse: collapse; border-color: black;' ALIGN=center>" . $dt['sku'] . "</td>
				<td style='border: 1px solid black; border-collapse: collapse; border-color: black;' ALIGN=left>" . $dt['descripcion'] . "</td>
				<td style='border: 1px solid black; border-collapse: collapse; border-color: black;' ALIGN=right>" . number_format($dt['precio'], 2) . "</td>
				<td style='border: 1px solid black; border-collapse: collapse; border-color: black;' ALIGN=right>" . $dt['cantidad'] . "</td>
				<td style='border: 1px solid black; border-collapse: collapse; border-color: black;' ALIGN=right>" . number_format($dt['subtotal'], 2) . "</td>
			</tr>
			";
		}

		$saludo = "";
		$timezone = -5;
		$hora =  strval(gmdate("H", time() + 3600 * ($timezone + date("I"))));

		if ($hora >= 0 && $hora <= 11) {
			$saludo = 'buenos días,';
		} else if ($hora >= 12 && $hora <= 18) {
			$saludo = 'buenas tardes,';
		} else if ($hora >= 19 && $hora <= 23) {
			$saludo = 'buenas noches,';
		}

		$datos_cliente = "";
		if ($_SESSION['cliente'] == 0) {
			$datos_cliente = "
			<br>
			DEPARTAMENTO: " . $_SESSION['departamento'] . "<br>
			PROVINCIA: " . $_SESSION['provincia'] . "<br>
			DISTRITO: " . $_SESSION['distrito'] . "<br>
			DIRECCION: " . $_SESSION['direccion'] . "<br>
			REFERENCIA: " . $_SESSION['referencia'] . "<br>
			<br>
			";
		} else {
			$datos_cliente = "<br>";
		}

		$mail->isHTML(true);
		$mail->CharSet = "utf-8";
		$mail->Subject = $envio_asunto;
		// $mail->addEmbeddedImage('public/dist/img/banner.png', 'imgcid');
		$mail->Body = "
		Hola " . $saludo . "</b>
		<br>
		<br>
		Envío mi solicitud de pedido para mi pronta atención, a continuacion detallo lo solicitado:<br>
		<br>
		<table cellspacing='1' cellpadding='5'>
			<thead>
				<tr ALIGN=center>
					<th style='border: 1px solid black; border-collapse: collapse; border-color: black;' bgcolor='#8fce00'>SKU</th>
					<th style='border: 1px solid black; border-collapse: collapse; border-color: black;' bgcolor='#8fce00'>DESCRIPCION</th>
					<th style='border: 1px solid black; border-collapse: collapse; border-color: black;' bgcolor='#8fce00'>PRECIO UNIT.</th>
					<th style='border: 1px solid black; border-collapse: collapse; border-color: black;' bgcolor='#8fce00'>CANTIDAD (UND)</th>
					<th style='border: 1px solid black; border-collapse: collapse; border-color: black;' bgcolor='#8fce00'>TOTAL</th>
				</tr>
			</thead>
			<tbody>
				" . $filas . "
			</tbody>
			<tfoot>
				<tr>
				<th></th>
				<th></th>
				<th></th>
				<th style='border: 1px solid black; border-collapse: collapse; border-color: black;' ALIGN=right>SUBTOTAL </th>
				<td style='border: 1px solid black; border-collapse: collapse; border-color: black;' ALIGN=right>" . $envio_base . "</td>
				</tr>
				<tr>
				<th></th>
				<th></th>
				<th></th>
				<th style='border: 1px solid black; border-collapse: collapse; border-color: black;' ALIGN=right>IGV (18%)</th>
				<td style='border: 1px solid black; border-collapse: collapse; border-color: black;' ALIGN=right>" . $envio_igv . "</td>
				</tr>
				<tr>
				<th></th>
				<th></th>
				<th></th>
				<th style='border: 1px solid black; border-collapse: collapse; border-color: black;' ALIGN=right>TOTAL S/</th>
				<td style='border: 1px solid black; border-collapse: collapse; border-color: black;' ALIGN=right>" . $envio_total . "</td>
				</tr>
			</tfoot>
		</table>
		" . $datos_cliente . "
		Saludos,<br>"
			. $_SESSION['usuario'] . "
		<br>
		VIVE VERDUM - PEDIDO PORTAL WEB - " . date("Y") . " - TICKET: " . $diastring . "
		<br>
		<br>
		<img src='" . BASE_URL2 . "public/dist/img/footer_verdum2.png'>";

		$envio_mensaje = "Hola " . $saludo . "</b>
		<br>
		<br>
		Envío mi solicitud de pedido para mi pronta atención, a continuacion detallo lo solicitado:<br>
		<br>
		<table cellspacing='1' cellpadding='5'>
			<thead>
				<tr ALIGN=center>
					<th style='border: 1px solid black; border-collapse: collapse; border-color: black;' bgcolor='#8fce00'>SKU</th>
					<th style='border: 1px solid black; border-collapse: collapse; border-color: black;' bgcolor='#8fce00'>DESCRIPCION</th>
					<th style='border: 1px solid black; border-collapse: collapse; border-color: black;' bgcolor='#8fce00'>PRECIO UNIT.</th>
					<th style='border: 1px solid black; border-collapse: collapse; border-color: black;' bgcolor='#8fce00'>CANTIDAD (UND)</th>
					<th style='border: 1px solid black; border-collapse: collapse; border-color: black;' bgcolor='#8fce00'>TOTAL</th>
				</tr>
			</thead>
			<tbody>
				" . $filas . "
			</tbody>
			<tfoot>
				<tr>
				<th></th>
				<th></th>
				<th></th>
				<th style='border: 1px solid black; border-collapse: collapse; border-color: black;' ALIGN=right>SUBTOTAL </th>
				<td style='border: 1px solid black; border-collapse: collapse; border-color: black;' ALIGN=right>" . $envio_base . "</td>
				</tr>
				<tr>
				<th></th>
				<th></th>
				<th></th>
				<th style='border: 1px solid black; border-collapse: collapse; border-color: black;' ALIGN=right>IGV (18%)</th>
				<td style='border: 1px solid black; border-collapse: collapse; border-color: black;' ALIGN=right>" . $envio_igv . "</td>
				</tr>
				<tr>
				<th></th>
				<th></th>
				<th></th>
				<th style='border: 1px solid black; border-collapse: collapse; border-color: black;' ALIGN=right>TOTAL S/</th>
				<td style='border: 1px solid black; border-collapse: collapse; border-color: black;' ALIGN=right>" . $envio_total . "</td>
				</tr>
			</tfoot>
		</table>
		" . $datos_cliente . "
		Saludos,<br>"
			. $_SESSION['usuario'] . "
		<br>
		VIVE VERDUM - PEDIDO PORTAL WEB - " . date("Y") . " - TICKET: " . $diastring . "
		<br>
		<br>
		<img src='" . BASE_URL2 . "public/dist/img/footer_verdum2.png'>";

		if (!$mail->send()) {
			$output = 2; //	ERROR AL ENVIAR CORREO

			// GUARDAMOS LOG DE ENVIO DE CORREO ERROR
			$param3 = array(
				"post"		=> 1,
				"ticket"	=> "",
				"para"		=> $envio_para,
				"copia"		=> $envio_cc,
				"asunto"	=> $envio_asunto,
				"mensaje"	=> $envio_mensaje,
				"output"	=> 2,
				"ruta"   	=> 'CORREO VENTA WEB - ERROR',
				"user" 		=> $_SESSION['dni'],
			);

			$soap->MantLogCorreos($param3);
		} else {
			$output = 1; // SE ENVIO CORRECTAMENTE

			// GUARDAMOS LOG DE ENVIO DE CORREO SUCCESS
			$param3 = array(
				"post"		=> 1,
				"ticket"	=> $diastring,
				"para"		=> $envio_para,
				"copia"		=> $envio_cc,
				"asunto"	=> $envio_asunto,
				"mensaje"	=> $envio_mensaje,
				"output"	=> 1,
				"ruta"   	=> 'CORREO VENTA WEB - SUCCESS',
				"user" 		=> $_SESSION['dni'],
			);

			$soap->MantLogCorreos($param3);

			// GUARDAMOS DATOS DE LA VENTA - (CABECRA Y DETALLE)

			// CABECERA
			$param4 = array(
				"post"		=> 1, // insert
				"id"		=> 1, // id de control para genera correlativo de venta al personal
				"ticket"	=> $diastring,
				"para"		=> $envio_para,
				"copia"		=> $envio_cc,
				"asunto"	=> $envio_asunto,
				"subtotal"	=> $envio_base,
				"igv"		=> $envio_igv,
				"total"   	=> $envio_total,
				"user" 		=> $_SESSION['dni'],
			);

			$result4 = $soap->MantVentaCabecera($param4);
			$ventacab = json_decode($result4->MantVentaCabeceraResult, true);

			$correlativo = $ventacab[0]['v_icon'];

			// array DETALLE
			$i = 0;
			foreach ($detalle as $dtv) {
				$param[$i] = array(
					"post"		=> 1, // insert
					"pedido"	=> $correlativo, // correlativo viene despues de insert en cabecera
					"sku"		=> $dtv['sku'],
					"precio"	=> $dtv['precio'],
					"cantidad"	=> $dtv['cantidad'],
					"subtotal"	=> $dtv['subtotal'],
					"user" 		=> $_SESSION['dni'],
				);
				$soap->MantVentaDetalle($param[$i]);
				$i++;
			}
		}

		header('Content-type: application/json; charset=utf-8');

		echo $json->encode(
			array(
				"correo" => $output
			)
		);
	}

	public function venta_viernes()
	{
		date_default_timezone_set("America/Lima");
		$dias = array("domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado");

		$data = $dias[date('w')];

		echo $data;
	}
}
?>