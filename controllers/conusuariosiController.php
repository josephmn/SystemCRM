<?php

class conusuariosiController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('configuracion','conusuariosi');

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
					'plugins/datatables-net/js/jszip.min',
					'plugins/datatables-net/js/pdfmake.min',
					'plugins/datatables-net/js/vfs_fonts',
					'plugins/datatables-net/js/buttons.html5.min',
					'plugins/datatables-net/js/buttons.print.min',
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

			$param = array(
				"post"		=> 1, //consulta todos
				"dni" 		=> "", //no se usa
				"estado"	=> 0, //inactivos
			);

			$result = $soap->ListarUsuarios($param);
			$usuarios = json_decode($result->ListarUsuariosResult, true);

			// NOTIFICACIONES TOTAL
			$param100 = array(
				"post"	=> 2,  	// consultar por DNI para obtener cantidad de notificaciones
				"top"	=> 0,	// no se usa para esta consulta
				"dni"	=> $_SESSION['dni'],
			);

			$result100 = $soap->ListarPaNotificaciones($param100);
			$countnoti = json_decode($result100->ListarPaNotificacionesResult, true);

			$_SESSION['num_notificaciones'] = intval($countnoti[0]['i_delay']);

			$this->_view->usuarios = $usuarios;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function consulta_usuario()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");
			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$post = $_POST["post"];
			$dni = $_POST["dni"];

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

			$param = array(
				"post"		=> $post, //consulta por dni
				"dni" 		=> $dni, //dni a consultar
				"estado"	=> 0, //estado no se usa
			);

			$result = $soap->ListarUsuarios($param);
			$usuarios = json_decode($result->ListarUsuariosResult, true);

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"icodigo" 				=> $usuarios[0]['v_dni'],
					"vnombre" 				=> html_caracteres($usuarios[0]['v_nombre']),
					"vapellido" 			=> html_caracteres($usuarios[0]['v_apellidos']),
					"vcorreo" 				=> $usuarios[0]['v_correo'],
					"vcorreoemp" 			=> $usuarios[0]['v_correo_empresa'],
					"iestado" 				=> $usuarios[0]['i_estado'],
					"iperfil"				=> $usuarios[0]['i_perfil'],
					"vfoto"					=> BASE_URL.$usuarios[0]['v_foto'],
				)
			);

		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function comboperfil()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");
			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$perfil = $_POST["perfil"];

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
				"post" => 2, //lista los perfiles para combo
				"perfil" => $perfil, //para seleccionar por default el perfil actual
			);

			$result = $soap->ConPerfiles($param);
			$comboperfil = json_decode($result->ConPerfilesResult, true);

			$filas="";
			foreach($comboperfil as $dv){
				$filas.="<option ".$dv['v_selected']." value=".$dv['i_id'].">".$dv['v_nombre']."</option>";
			};
			
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

	public function combocorreos()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");
			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$post = $_POST["post"];
			$id = $_POST["id"];

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
				"post" => $post,
				"codigo" => $id,
			);

			$result = $soap->Usuarios($param);
			$combousuarios = json_decode($result->UsuariosResult, true);

			$filas="";
			foreach($combousuarios as $dv){
				$filas.="<option value=".$dv['v_codigo']." idcorreo=".$dv['v_correo'].">".$dv['v_nombres']."</option>";
			};
			
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

	public function mantenimiento_usuarios()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");
			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$post = $_POST["post"];
			$dni = $_POST["dni"];
			$estado = $_POST["estado"];
			$perfil = $_POST["perfil"];

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
				"dni" 		=> $dni,
				"estado" 	=> $estado,
				"perfil" 	=> $perfil,
				"user" 		=> $_SESSION['dni'],
			);

			$result = $soap->MantUsuarios($param);
			$mantperfiles = json_decode($result->MantUsuariosResult, true);

			header('Content-type: application/json; charset=utf-8');
			echo $json->encode(
				array(
					"vicon" 		=> $mantperfiles[0]['v_icon'],
					"vtitle" 		=> $mantperfiles[0]['v_title'],
					"vtext" 		=> $mantperfiles[0]['v_text'],
					"itimer" 		=> intval($mantperfiles[0]['i_timer']),
					"icase" 		=> intval($mantperfiles[0]['i_case']),
					"vprogressbar" 	=> $mantperfiles[0]['v_progressbar'],
				)
			);

		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function enviarcorreo()
	{

		putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
		putenv("NLS_CHARACTERSET=AL32UTF8");

		$this->getLibrary('json_php/JSON');
		$json = new Services_JSON();

		$cnombre = $_POST['cnombre'];
		$cpara = $_POST['cpara'];
		$ccopia = $_POST['ccopia'];
		$casunto = $_POST['casunto'];
		$cmensaje = $_POST['cmensaje'];

		// $cnombre = "JOSEPH MAGALLANES";
		// $cpara = "programador.app02@verdum.com";
		// $ccopia = ["3","4","5"];
		// $casunto = "PRUEBA";
		// $cmensaje = "CORREO DE PRUEBA";

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

		$output = 0;
		// envio de correo
		$this->getLibrary('phpmailer/PHPMailer');
		$this->getLibrary('phpmailer/SMTP');

		$mail = new PHPMailer;

		$mail->isSMTP();
		$mail->SMTPDebug = false;
		$mail->SMTPAuth = true; //Habilita uso de usuario y contraseña
		//$mail->SMTPSecure = 'tls'; //tls o ssl, configuracion de correo personalizado Ejem: gmail (ssl)
		$mail->Mailer = 'smtp';
		$mail->Host = 'mail.cafealtomayo.com.pe';
		$mail->Username = 'reportes@cafealtomayo.com.pe';
		$mail->Password = 'pppp'; //contraseña
		$mail->Port = 25;

		// $mail->From = ('reportes@cafealtomayo.com.pe');
		$mail->From = ('reportes@cafealtomayo.com.pe');
		$mail->FromName = "VERDUM PERÚ SAC"; //de
		$mail->addAddress($cpara, $cnombre);
		// $mail->addReplyTo('reportes@cafealtomayo.com.pe', 'noreplay verdum');

		// concatenar los correos en copia
		$i = 0;
		$cccorreos = "";
		foreach ($ccopia as $di) {
			$params[$i] = array(
				"post" => 2,
				"codigo" => $di,
			);
			$result = $soap->Usuarios($params[$i]);
			$usuario = json_decode($result->UsuariosResult, true);
			$cccorreos = $usuario[0]['v_correo'];
			$mail->addCC($cccorreos);
			$i++;
		}
		// $mail->addBCC('bcc@example.com');

		$mail->isHTML(true);
		$mail->CharSet = "utf-8";
		$mail->Subject = $casunto;
		$mail->Body = "
		Hola <b>" . $cnombre . ",</b>
		<br>
		". $cmensaje ."
		<br>
		<br>
		Saludo,
		<br>
		VERDUM PERU SAC.
		<br>
		<br>
		<img src='" . BASE_URL2 . "public/dist/img/footer_verdum2.png'>";

		$output = 0;

		if (!$mail->send()) {
			$output = 0; //	ERROR AL ENVIAR CORREO
		} else {
			$output = 1; // SE ENVIO CORRECTAMENTE
		}

		header('Content-type: application/json; charset=utf-8');

		echo $json->encode(
			array(
				"correo" => $output,
			)
		);
	}

	public function cambiar_password()
	{

		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");
			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$dni= $_POST['dni'];

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
				"dni" 		=> $dni,
				"user"		=> $_SESSION['dni'],
			);

			$soap = new SoapClient($wsdl, $options);
			$result = $soap->MantenimientoUserPassword($param);
			$insertperfil = json_decode($result->MantenimientoUserPasswordResult, true);

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

}
?>