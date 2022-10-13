<?php

class buzonsugerenciaController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('escuchamos','buzonsugerencia');

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

			$params1 = array(
				'post' => 2, //para listar opciones combo
			);

			$result1 = $soap->ListarBuzonsugerencia($params1);
			$combobuzon = json_decode($result1->ListarBuzonsugerenciaResult, true);

			$filascombo = "";
			foreach ($combobuzon as $buzon) {
				$filascombo .= "<option value=" . $buzon['i_id'] . ">" . $buzon['v_nombre'] . "</option>";
			}

			// ARMAMOS TABLA
			$params2 = array(
				'post' => 2, //para listar solo los correos enviados por el personal
				'dni'  => $_SESSION['dni'], //dni del usuario
			);

			$result2 = $soap->ListarCorreoBuzonsugerencia($params2);
			$buzonsugerencia = json_decode($result2->ListarCorreoBuzonsugerenciaResult, true);
			
			// construimos la tabla
			$filas="";
			foreach($buzonsugerencia as $dv){
				$filas.="
				<tr data-widget='expandable-table' aria-expanded='false'>
					<td class='text-center'>".$dv['i_id']."</td>
					<td class='text-center'>".$dv['v_ticket']."</td>
					<td class='text-center'>".$dv['v_para']."</td>
					<td class='text-center'>".$dv['d_fecha']."</td>
					<td class='text-left'>".$dv['v_asunto']."</td>
					<td class='text-center'><span class='badge bg-".$dv['v_color']."'>".$dv['v_estado']."</span></td>
					<td class='text-left'>".$dv['v_mensaje']."</td>
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

			$this->_view->filascombo = $filascombo;
			$this->_view->filas = $filas;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
		}else{
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
		// $envio_para = "programador.app02@verdum.com";
		$envio_de = $_POST['envio_de'];
		$nombre = $_POST['nombre'];
		$asunto = $_POST['asunto'];
		$desc_asunto = $_POST['desc_asunto'];
		$descripcion = $_POST['descripcion'];

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

		$mail->addAddress($envio_para, $conficorreo[0]['v_nombre_salida']);
		$mail->addAddress($envio_de, $nombre);

		// CCO
		$mail->addBCC($conficorreo[0]['v_correo_salida']);

		$saludo = "";
		$hora =  strval(date("H"));

		if ($hora >= 0 && $hora <= 11) {
			$saludo = 'buenos días,';
		} else if ($hora >= 12 && $hora <= 18) {
			$saludo = 'buenas tardes,';
		} else if ($hora >= 19 && $hora <= 23) {
			$saludo = 'buenas noches,';
		}

		$mail->isHTML(true);
		$mail->CharSet = "utf-8";
		$mail->Subject = "BUZON DE SUGERENCIA - " . $desc_asunto;
		$mail->Body = "
		Hola " . $saludo . "</b>
		<br>
		<br>
		Envío el siguiente correo desde buzón de sugerencia de Verdum, expresando lo siguiente:<br>
		<br>
		". $descripcion ."
		<br>
		<br>
		Saludos,
		<br>
		". $_SESSION['usuario'] . "
		<br>
		<img src='" . BASE_URL2 . "public/dist/img/footer_verdum1.png'>
		<br>
		<br>
		- BUZÓN DE SUGERENCIAS - " . date("Y") . "
		<br>
		- TICKET: " . $diastring . "
		<br>
		<br>
		<img src='" . BASE_URL2 . "public/dist/img/footer_verdum2.png'>";

		if (!$mail->send()) {
			$output = 2; //	ERROR AL ENVIAR CORREO

			// GUARDAMOS LOG DE ENVIO DE CORREO ERROR
			$param2 = array(
				"post"			=> 1,
				"ticket"		=> $diastring,
				"para"			=> $envio_para,
				"copia"			=> $envio_de,
				"asunto"		=> intval($asunto),
				"desc_asunto"	=> $desc_asunto,
				"mensaje"		=> $descripcion,
				"output"		=> 2,
				"ruta"   		=> 'CORREO BUZON DE SUGERENCIA - ERROR',
				"user" 			=> $_SESSION['dni'],
			);

			$soap->MantLogCorreosBuzonsugerencia($param2);
		} else {
			$output = 1; // SE ENVIO CORRECTAMENTE

			// GUARDAMOS LOG DE ENVIO DE CORREO SUCCESS
			$param3 = array(
				"post"			=> 1,
				"ticket"		=> $diastring,
				"para"			=> $envio_para,
				"copia"			=> $envio_de,
				"asunto"		=> intval($asunto),
				"desc_asunto"	=> $desc_asunto,
				"mensaje"		=> $descripcion,
				"output"		=> 1,
				"ruta"   		=> 'CORREO BUZON DE SUGERENCIA - SUCCESS',
				"user" 			=> $_SESSION['dni'],
			);

			$soap->MantLogCorreosBuzonsugerencia($param3);
		}

		header('Content-type: application/json; charset=utf-8');	

		echo $json->encode(
			array(
				"correo" => $output
			)
		);
	}

	// // para mostrar tabla en ajax
	// public function datatable(){

	// 	if (isset($_SESSION['usuario'])) {

	// 		putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
	// 		putenv("NLS_CHARACTERSET=AL32UTF8");

	// 		$this->getLibrary('json_php/JSON');
	// 		$json = new Services_JSON();

	// 		$wsdl = 'http://localhost:81/PAWEB/WSRecursos.asmx?WSDL';

	// 		$options = array(
	// 			"uri" => $wsdl,
	// 			"style" => SOAP_RPC,
	// 			"use" => SOAP_ENCODED,
	// 			"soap_version" => SOAP_1_1,
	// 			"connection_timeout" => 60,
	// 			"trace" => false,
	// 			"encoding" => "UTF-8",
	// 			"exceptions" => false,
	// 		);

	// 		$soap = new SoapClient($wsdl, $options);

	// 		// ARMAMOS TABLA
	// 		$params2 = array(
	// 			'post' => 2, //para listar solo los correos enviados por el personal
	// 			'dni'  => $_SESSION['dni'], //dni del usuario
	// 		);

	// 		$result2 = $soap->ListarCorreoBuzonsugerencia($params2);
	// 		$buzonsugerencia = json_decode($result2->ListarCorreoBuzonsugerenciaResult, true);

	// 		$filas = [];
	// 		$i = 0;
	// 		foreach ($buzonsugerencia as $da) {
	// 			$propiedades1 = array(
	// 				"i_id" => ($da['i_id']),
	// 				"v_ticket" => $da['v_ticket'],
	// 				"d_fecha" => $da['d_fecha'],
	// 				"v_asunto" => $da['v_asunto'],
	// 				"v_estado" => $da['v_estado'],
	// 				"v_mensaje" => $da['v_mensaje']
	// 			);
	// 			$filas += ["$i" => $propiedades1];
	// 			$i++;
	// 		}
	// 		header('Content-type: application/json; charset=utf-8');

	// 		echo $json->encode(
	// 			array(
	// 				'data' => $filas
	// 			)
	// 		);

	// 	} else {
	// 		$this->redireccionar('index/logout');
	// 	}

	// }

	public function FunctionName()
	{
		date_default_timezone_set("America/Lima");

		$hora =  strval(date("H"));
		$diastring =  strval(date("YmdHis"));

		if ($hora >= 0 && $hora <= 11) {
			$saludo = 'buenos días,';
		} else if ($hora >= 12 && $hora <= 18) {
			$saludo = 'buenas tardes,';
		} else if ($hora >= 19 && $hora <= 23) {
			$saludo = 'buenas noches,';
		}

		echo $hora;
	}

}

?>