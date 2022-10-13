<?php

class canaldenunciaController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('escuchamos', 'canaldenuncia');

			$this->_view->setCss_Specific(
				array(
					'plugins/fontawesome-free/css/all.min',
					'plugins/overlayScrollbars/css/OverlayScrollbars.min',
					'dist/css/adminlte',
					//Bootstrap Color Picker y Tempusdominus Bootstrap 4
					'plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min',
					'plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min',
					//Select2
					'plugins/select2/css/select2.min',
					'plugins/select2-bootstrap4-theme/select2-bootstrap4.min',
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

	public function datos_personal()
	{
		putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
		putenv("NLS_CHARACTERSET=AL32UTF8");

		$this->getLibrary('json_php/JSON');
		$json = new Services_JSON();

		$nombre = $_SESSION['nombre'];
		$correo = $_SESSION['correo'];

		header('Content-type: application/json; charset=utf-8');

		echo $json->encode(
			array(
				"nombre" => $nombre,
				"correo" => $correo,
			)
		);
	}

	public function anonimo()
	{
		//Configuración del algoritmo de encriptación
		//Debes cambiar esta cadena, debe ser larga y unica
		//nadie mas debe conocerla
		$clave  = 'altomayo el sabor natural del cafe';
		//Metodo de encriptación
		$method = 'aes-256-cbc';
		// Puedes generar una diferente usando la funcion $getIV()
		$iv = base64_decode("cm7qd99erma6QzKOUc96Bw==");
		/*
		Encripta el contenido de la variable, enviada como parametro.
		*/
		$encriptar = function ($valor) use ($method, $clave, $iv) {
			return openssl_encrypt($valor, $method, $clave, false, $iv);
		};
		/*
		Desencripta el texto recibido
		*/
		$desencriptar = function ($valor) use ($method, $clave, $iv) {
			$encrypted_data = base64_decode($valor);
			return openssl_decrypt($valor, $method, $clave, false, $iv);
		};
		/*
		Genera un valor para IV
		*/
		$getIV = function () use ($method) {
			return base64_encode(openssl_random_pseudo_bytes(openssl_cipher_iv_length($method)));
		};

		// ejemplo
		// include "mcript.php";
		// Como usar las funciones para encriptar y desencriptar.
		$dato = "72130767";
		//Encripta información:
		$dato_encriptado = $encriptar($dato);
		//Desencripta información:
		$dato_desencriptado = $desencriptar($dato_encriptado);
		echo 'Dato encriptado: ' . $dato_encriptado . '<br>';
		echo 'Dato desencriptado: ' . $dato_desencriptado . '<br>';
		echo "IV generado: " . $getIV();
	}

	public function password()
	{
		$password = '72130767';

		echo md5($password) . '<br>';
		echo sha1($password) . '<br>';

		// hash(alg, string)
		foreach (hash_algos() as $algo) {
			echo $algo . ": " . hash($algo, $password) . "<br/>";
		}

		// pasword hash
		$hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]);
		echo $hash . '<br/>';

		// password_verify
		if (password_verify($password, $hash)) {
			echo "password correcto";
		}
	}

	public function enviar_correo() // NO SE USAR, SE USO PARA PRUEBAS
	{
		date_default_timezone_set("America/Lima");

		putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
		putenv("NLS_CHARACTERSET=AL32UTF8");

		$this->getLibrary('json_php/JSON');
		$json = new Services_JSON();

		// $envio_para = "comunicaciones@verdum.com";
		$envio_para = "programador.app02@verdum.com";
		$envio_de = $_POST['envio_de'];
		$nombre = $_POST['nombre'];
		$anonimo = $_POST['icheck']; // anonimo o no
		$fecha = $_POST['fecha']; // feche de suceso
		$asunto = $_POST['asunto'];
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

		//si tiene archivo adjunto
		if (is_array($_FILES) && count($_FILES) > 0) {

			$combo = 21; // id de configuracion de la tabla "pa_documentos"
			$extdoc = explode("/", $_FILES["archivo"]["type"]); // convertir en array (mime / type)

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
					$destino = "public/doc/" . $legajodoc[0]['v_carpeta'] . "/" . rtrim(ltrim($_SESSION['dni'])) . "_" . $fecha_hora . "." . $extension[0]['v_archivo'];

					if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)) {

						$result3 = $soap->ConfiguracionCorreo();
						$conficorreo = json_decode($result3->ConfiguracionCorreoResult, true);

						$this->getLibrary('phpmailer/class.phpmailer');
						$this->getLibrary('phpmailer/PHPMailerAutoload');

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
						$mail->FromName = ($conficorreo[0]['v_nombre_salida']); // VERDUM PERÚ SAC

						$mail->addAddress($envio_para);

						if ($anonimo == 0) {
							$mail->addAddress($envio_de, $nombre);
						}

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
						// $mail->AddAttachment($_FILES['archivo']['tmp_name'], $_FILES['archivo']['name']);
						$mail->AddAttachment($destino);
						$mail->CharSet = "utf-8";
						$mail->Subject = "CANAL DE DENUNCIA - " . $asunto;
						$mail->Body = "
							Hola " . $saludo . "</b>
							<br>
							<br>
							Envío el siguiente correo desde Canal de denuncia de Verdum, expresando lo siguiente:
							<br>
							<br>
							Fecha de suceso: " . $fecha . "
							<br>
							<br>
							" . $descripcion . "
							<br>
							<br>
							Saludos,
							<br>
							" . $_SESSION['usuario'] . "
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
							//	ERROR AL ENVIAR CORREO
							// GUARDAMOS LOG DE ENVIO DE CORREO ERROR
							$param2 = array(
								"post"			=> 1,
								"ticket"		=> $diastring,
								"para"			=> $envio_para,
								"copia"			=> $envio_de,
								"anonimo"		=> $anonimo,
								"asunto"		=> $asunto,
								"archivo"		=> "", //$destino,
								"mensaje"		=> $descripcion,
								"output"		=> 2,
								"ruta"   		=> 'CORREO CANAL DE DENUNCIA - ERROR',
								"user" 			=> $_SESSION['dni'],
							);

							$soap->MantLogCorreosCanaldenuncia($param2);

							header('Content-type: application/json; charset=utf-8');

							echo $json->encode(
								array(
									"vicon" 		=> "error",
									"vtitle" 		=> "Error no se pudo enviar el correo",
									"vtext" 		=> "Ocurrio un error en el envío, favor de volver a intentarlo en un momento..!!",
									"itimer" 		=> 4000,
									"icase" 		=> 2,
									"vprogressbar" 	=> true,
								)
							);
						} else {
							// SE ENVIO CORRECTAMENTE
							// GUARDAMOS LOG DE ENVIO DE CORREO SUCCESS
							$param3 = array(
								"post"			=> 1,
								"ticket"		=> $diastring,
								"para"			=> $envio_para,
								"copia"			=> $envio_de,
								"anonimo"		=> $anonimo,
								"asunto"		=> $asunto,
								"archivo"		=> "", //$destino,
								"mensaje"		=> $descripcion,
								"output"		=> 1,
								"ruta"   		=> 'CORREO CANAL DE DENUNCIA - SUCCESS',
								"user" 			=> $_SESSION['dni'],
							);

							$soap->MantLogCorreosCanaldenuncia($param3);

							header('Content-type: application/json; charset=utf-8');

							echo $json->encode(
								array(
									"vicon" 		=> "success",
									"vtitle" 		=> "Correo enviado correctamente",
									"vtext" 		=> "Muchas gracias por la información.",
									"itimer" 		=> 3000,
									"icase" 		=> 1,
									"vprogressbar" 	=> true,
								)
							);
						}
					} else {
						header('Content-type: application/json; charset=utf-8');
						echo $json->encode(
							array(
								"vicon" 		=> "error",
								"vtitle" 		=> "Error al enviar correo con archivo",
								"vtext" 		=> "Ocurrio un error al cargar el archivo al correo, favor de volver a intentarlo..!!",
								"itimer" 		=> 3000,
								"icase" 		=> 3,
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
							"icase" 		=> 4,
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
						"icase" 		=> 5,
						"vprogressbar" 	=> true,
					)
				);
			}
		} else {
			$result4 = $soap->ConfiguracionCorreo();
			$conficorreo = json_decode($result4->ConfiguracionCorreoResult, true);

			$this->getLibrary('phpmailer/class.phpmailer');
			$this->getLibrary('phpmailer/PHPMailerAutoload');

			$mail = new PHPMailer;

			$mail->isSMTP();
			$mail->SMTPDebug = 0;
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'tls';
			$mail->Mailer = 'smtp';
			$mail->Host = $conficorreo[0]['v_servidor_entrante']; //mail.cafealtomayo.com.pe
			$mail->Username = $conficorreo[0]['v_correo_salida']; //reportes@cafealtomayo.com.pe
			$mail->Password = $conficorreo[0]['v_password']; //contraseña
			$mail->Port = $conficorreo[0]['i_puerto']; //25

			$mail->From = ($conficorreo[0]['v_correo_salida']); //reportes@cafealtomayo.com.pe
			$mail->FromName = ($conficorreo[0]['v_nombre_salida']); // VERDUM PERÚ SAC

			$mail->addAddress($envio_para);
			if ($anonimo == 0) {
				$mail->addAddress($envio_de, $nombre);
			}

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
			$mail->Subject = $asunto;
			$mail->Body = "
			Hola " . $saludo . "</b>
			<br>
			<br>
			Envío el siguiente correo desde Canal de denuncia de Verdum, expresando lo siguiente:
			<br>
			<br>
			Fecha de suceso: " . $fecha . "
			<br>
			<br>
			" . $descripcion . "
			<br>
			<br>
			Saludos,
			<br>
			" . $_SESSION['usuario'] . "
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
				//	ERROR AL ENVIAR CORREO
				// GUARDAMOS LOG DE ENVIO DE CORREO ERROR
				$param2 = array(
					"post"			=> 1,
					"ticket"		=> $diastring,
					"para"			=> $envio_para,
					"copia"			=> $envio_de,
					"anonimo"		=> $anonimo,
					"asunto"		=> $asunto,
					"archivo"		=> "",
					"mensaje"		=> $descripcion,
					"output"		=> 2,
					"ruta"   		=> 'CORREO CANAL DE DENUNCIA - ERROR',
					"user" 			=> $_SESSION['dni'],
				);

				$soap->MantLogCorreosBuzonsugerencia($param2);

				header('Content-type: application/json; charset=utf-8');

				echo $json->encode(
					array(
						"vicon" 		=> "error",
						"vtitle" 		=> "Error no se pudo enviar el correo",
						"vtext" 		=> "Ocurrio un error en el envío, favor de volver a intentarlo en un momento..!!",
						"itimer" 		=> 4000,
						"icase" 		=> 2,
						"vprogressbar" 	=> true,
					)
				);
			} else {
				// SE ENVIO CORRECTAMENTE
				// GUARDAMOS LOG DE ENVIO DE CORREO SUCCESS
				$param3 = array(
					"post"			=> 1,
					"ticket"		=> $diastring,
					"para"			=> $envio_para,
					"copia"			=> $envio_de,
					"anonimo"		=> $anonimo,
					"asunto"		=> $asunto,
					"archivo"		=> "",
					"mensaje"		=> $descripcion,
					"output"		=> 1,
					"ruta"   		=> 'CORREO CANAL DE DENUNCIA - SUCCESS',
					"user" 			=> $_SESSION['dni'],
				);

				$soap->MantLogCorreosBuzonsugerencia($param3);

				header('Content-type: application/json; charset=utf-8');

				echo $json->encode(
					array(
						"vicon" 		=> "success",
						"vtitle" 		=> "Correo enviado correctamente",
						"vtext" 		=> "Muchas gracias por la información.",
						"itimer" 		=> 3000,
						"icase" 		=> 1,
						"vprogressbar" 	=> true,
					)
				);
			}
		}
	}

	// MEJORADO PARA ENVIO CON ARCHIVOS ADJUNTOS
	public function enviar_correo2()
	{
		date_default_timezone_set("America/Lima");

		putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
		putenv("NLS_CHARACTERSET=AL32UTF8");

		$this->getLibrary('json_php/JSON');
		$json = new Services_JSON();

		$envio_para = "comunicaciones@verdum.com";
		//$envio_para = "programador.app02@verdum.com";
		$envio_de = $_POST['envio_de'];
		$nombre = $_POST['nombre'];
		$anonimo = $_POST['anonimo']; // anonimo o no
		$fecha = $_POST['fecha']; // feche de suceso
		$asunto = $_POST['asunto'];
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

		//si tiene archivo adjunto
		if (is_array($_FILES) && count($_FILES) > 0) {

			// revisamos el tamaño del archivo (15 Mb => 15 * 1024)
			if (($_FILES['archivo']['size'] / 1024) <= 15400) {

				// ahora especificamos la ruta en donde se guardar el archivo
				$fecha_hora = date("Ymd_His", time());
				$path = "public/doc/correo_denuncia/" . $fecha_hora . "_" . $_FILES["archivo"]["name"];

				if (move_uploaded_file($_FILES['archivo']['tmp_name'], $path)) {

					// move_uploaded_file($_FILES["archivo"]["tmp_name"], $path);

					$result3 = $soap->ConfiguracionCorreo();
					$conficorreo = json_decode($result3->ConfiguracionCorreoResult, true);

					// $this->getLibrary('phpmaileradd/class.phpmailer');
					// $this->getLibrary('phpmaileradd/class.smtp');
					// $this->getLibrary('phpmaileradd/PHPMailerAutoload');

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
					$mail->FromName = ($conficorreo[0]['v_nombre_salida']); // VERDUM PERÚ SAC

					$mail->addAddress($envio_para);

					if ($anonimo == 1) { // es anonimo
						$envio_de = "";
						$saludofooter = "Saludos";
					} else {
						$mail->addAddress($envio_de, $nombre);
						$saludofooter = "
						Saludos,
						<br>
						" . $_SESSION['usuario'] . "";
					}

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
					$mail->AddAttachment($path);
					$mail->CharSet = "utf-8";
					$mail->Subject = "CANAL DE DENUNCIA - " . $asunto;
					$mail->Body = "
						Hola " . $saludo . "</b>
						<br>
						<br>
						Envío el siguiente correo desde Canal de denuncia de Verdum, expresando lo siguiente:
						<br>
						<br>
						Fecha de suceso: " . $fecha . "
						<br>
						<br>
						" . $descripcion . "
						<br>
						<br>
						" . $saludofooter . "
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
						// ERROR AL ENVIAR CORREO
						$output = 2;

						// GUARDAMOS LOG DE ENVIO DE CORREO ERROR
						$param2 = array(
							"post"			=> 1,
							"ticket"		=> $diastring,
							"para"			=> $envio_para,
							"copia"			=> $envio_de,
							"anonimo"		=> $anonimo,
							"asunto"		=> $asunto,
							"archivo"		=> $path,
							"mensaje"		=> $descripcion,
							"output"		=> 2,
							"ruta"   		=> 'CORREO CANAL DE DENUNCIA - ERROR',
							"user" 			=> $_SESSION['dni'],
						);

						$soap->MantLogCorreosCanaldenuncia($param2);
					} else {
						// SE ENVIO CORRECTAMENTE
						$output = 1;

						// GUARDAMOS LOG DE ENVIO DE CORREO SUCCESS
						$param3 = array(
							"post"			=> 1,
							"ticket"		=> $diastring,
							"para"			=> $envio_para,
							"copia"			=> $envio_de,
							"anonimo"		=> $anonimo,
							"asunto"		=> $asunto,
							"archivo"		=> $path,
							"mensaje"		=> $descripcion,
							"output"		=> 1,
							"ruta"   		=> 'CORREO CANAL DE DENUNCIA - SUCCESS',
							"user" 			=> $_SESSION['dni'],
						);

						$soap->MantLogCorreosCanaldenuncia($param3);
					}
				} else {
					$output = 3;
				}
			} else {
				$output = 4;
			}

		} else {

			$result4 = $soap->ConfiguracionCorreo();
			$conficorreo = json_decode($result4->ConfiguracionCorreoResult, true);

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

			$mail->addAddress($envio_para);

			if ($anonimo == 1) { // es anonimo
				$envio_de = "";
				$saludofooter = "Saludos";
			} else {
				$mail->addAddress($envio_de, $nombre);
				$saludofooter = "
				Saludos,
				<br>
				" . $_SESSION['usuario'] . "";
			}

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
			$mail->Subject = "CANAL DE DENUNCIA - " . $asunto;
			$mail->Body = "
			Hola " . $saludo . "</b>
			<br>
			<br>
			Envío el siguiente correo desde Canal de denuncia de Verdum, expresando lo siguiente:
			<br>
			<br>
			Fecha de suceso: " . $fecha . "
			<br>
			<br>
			" . $descripcion . "
			<br>
			<br>
			". $saludofooter ."
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
				// ERROR AL ENVIAR CORREO
				$output = 2;

				// GUARDAMOS LOG DE ENVIO DE CORREO ERROR
				$param10 = array(
					"post"			=> 1,
					"ticket"		=> $diastring,
					"para"			=> $envio_para,
					"copia"			=> $envio_de,
					"anonimo"		=> $anonimo,
					"asunto"		=> $asunto,
					"archivo"		=> "",
					"mensaje"		=> $descripcion,
					"output"		=> 2,
					"ruta"   		=> 'CORREO CANAL DE DENUNCIA - ERROR',
					"user" 			=> $_SESSION['dni'],
				);

				$soap->MantLogCorreosCanaldenuncia($param10);
			} else {
				// SE ENVIO CORRECTAMENTE
				$output = 1;
				
				// GUARDAMOS LOG DE ENVIO DE CORREO SUCCESS
				$param11 = array(
					"post"			=> 1,
					"ticket"		=> $diastring,
					"para"			=> $envio_para,
					"copia"			=> $envio_de,
					"anonimo"		=> $anonimo,
					"asunto"		=> $asunto,
					"archivo"		=> "",
					"mensaje"		=> $descripcion,
					"output"		=> 1,
					"ruta"   		=> 'CORREO CANAL DE DENUNCIA - SUCCESS',
					"user" 			=> $_SESSION['dni'],
				);

				$soap->MantLogCorreosCanaldenuncia($param11);
			}

		}

		header('Content-type: application/json; charset=utf-8');	

		echo $json->encode(
			array(
				"correo" => $output
			)
		);
	}

	// PRUEBA DE ENVIO
	public function enviar()
	{

		$envio_para = "programador.app02@verdum.com";
		$envio_de = $_POST['envio_de'];
		$nombre = $_POST['nombre'];
		$anonimo = $_POST['icheck']; // anonimo o no
		$fecha = $_POST['fecha']; // feche de suceso
		$asunto = $_POST['asunto'];
		$descripcion = $_POST['descripcion'];

		// if (isset($_POST["submit"])) {
			$path = 'uploads/' . $_FILES["archivo"]["name"];
			move_uploaded_file($_FILES["archivo"]["tmp_name"], $path);

			$message = '
				<h3 align="center">Detalles del informe</h3>
				<table border="1" width="100%" cellpadding="5" cellspacing="5">
					<tr>
						<td width="30%">Codigo</td>
						<td width="70%">' . $envio_de . '</td>
					</tr>
					<tr>
						<td width="30%">Nombre</td>
						<td width="70%">' . $nombre . '</td>
					</tr>
					<tr>
						<td width="30%">Email</td>
						<td width="70%">' . $descripcion . '</td>
					</tr>
				</table>
			';

			// require 'class/class.phpmailer.php';
			// $mail = new PHPMailer;

			$this->getLibrary('phpmailer/class.phpmailer');
			$this->getLibrary('phpmailer/PHPMailerAutoload');

			$mail = new PHPMailer;

			$mail->IsSMTP();															//Sets Mailer to send message using SMTP
			$mail->Host = 'mail.example.com.pe';
			$mail->Port = '25';															//Sets the default SMTP server port
			$mail->SMTPAuth = true;														//Sets SMTP authentication.
			$mail->Username = 'correo@example.com.pe';									//Sets SMTP username
			$mail->Password = 'tu_clave_aqui';											//Sets SMTP password
			$mail->SMTPSecure = '';														//Sets connection prefix. Options are "", "ssl" or "tls"
			$mail->From = 'tucorresalida@example.com.pe';;								//Sets the From email address for the message
			$mail->FromName = "NOMBRE DESTINATARIO";									//Sets the From name of the message
			$mail->AddAddress('correo_enviado@example.com', 'TU NOMBRE');				//Adds a "To" address
			$mail->WordWrap = 50;
			$mail->IsHTML(true);														//Sets message type to HTML
			$mail->AddAttachment($path);												//Adds an attachment from a path on the filesystem
			$mail->Subject = 'Enviar informe';											//Sets the Subject of the message
			$mail->Body = $message;														//An HTML or plain text message body
			if ($mail->Send())															//Send an Email. Return true on success or false on error
			{
				$message = '<div class="alert alert-success">Informe enviado correctamente</div>';
				unlink($path);
			} else {
				$message = '<div class="alert alert-danger">Hubo un error al procesar envio</div>';
			}
		// }
	}
}
?>