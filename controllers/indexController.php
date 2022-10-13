<?php 

class indexController extends Controller{
	
	public function __construct(){
		parent::__construct();
	}

	public function index(){

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
			)
		);

		$this->_view->setJs(array('index'));
		$this->_view->renderizar('index',true);
	}

	public function login(){

		date_default_timezone_set("America/Lima");

		putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
		putenv("NLS_CHARACTERSET=AL32UTF8");

		$this->getLibrary('json_php/JSON');
		$json = new Services_JSON();

		$usuario = trim($_POST['usuario']);
		$password = md5($_POST['password']);

		$clave = trim($_POST['password']);

		// $usuario = "72130767";
		// $password = "90c1ccf29dc97261e3d5eb6489667bfe";

		$wsdl = 'http://localhost:81/PAWEB/WSRecursos.asmx?WSDL';

		$options = array(
			"uri"=> $wsdl,
			"style"=> SOAP_RPC,
			"use"=> SOAP_ENCODED,
			"soap_version"=> SOAP_1_1,
			//"cache_wsdl"=> WSDL_CACHE_BOTH,
			"connection_timeout"=> 60,
			"trace"=> false,
			"encoding"=> "UTF-8",
			"exceptions"=> false,
			);
		
		$param = array(
			"usuario"=>$usuario,
			"password"=>$password,
		);

		//Envio del request
		$soap = new SoapClient($wsdl,$options);
		//Llamada a la funcion del servicio --no requiere parametro--
		$result = $soap->Login($param);
		//convertir en json en array
		$data = json_decode($result->LoginResult,true);
		
		if(count($data)>0){
			if(intval($data[0]['v_estado'])==1){
				$estado = 0; // usuario valido
			
				// PARA OBTENER LOS MENUS
				$param1 = array(
					"dato"=>$data[0]['i_idperfil']
				);
				$result1 = $soap->ListarMenu($param1);
				$menu = json_decode($result1->ListarMenuResult,true);

				//PARA OBTENER LOS SUB MENUS
				$param2 = array(
					"dato"=>$data[0]['i_idperfil']
				);	
				$result2 = $soap->ListarSubMenu($param2);
				$submenu = json_decode($result2->ListarSubMenuResult,true);

				// menus en variables globales
				$_SESSION['menus'] = $menu;
				$_SESSION['submenus'] = $submenu;

				// NOTIFICACIONES TOTAL
				$param3 = array(
					"post"	=> 2,  	// consultar por DNI para obtener cantidad de notificaciones
					"top"	=> 0,	// no se usa para esta consulta
					"dni"	=> trim($data[0]['v_dni']),
				);

				$result3 = $soap->ListarPaNotificaciones($param3);
				$countnoti = json_decode($result3->ListarPaNotificacionesResult, true);

				$_SESSION['num_notificaciones'] = intval($countnoti[0]['i_delay']);

				$filasmenu = "";
				$filassub = "";
				$menu1 = "home";
				$submenu1 = "nosotros";
				$active = "";

				foreach	($menu as $m) {
					
					$fechita = $m['i_submenu'] == 1 ? "<i class='right fas fa-angle-left'></i>":"";
					foreach ($submenu as $sm) {
						$active = $sm['v_link'] == $submenu1 ? " active":"";
						if ($sm['i_idmenu'] == $m['i_id']) {
							$filassub.="
							<ul class='nav nav-treeview'>
								<li class='nav-item'>
									<a href='".BASE_URL.$sm['v_link']."/index' class='".$sm['v_link']." nav-link".$active."'>
										<i class='nav-icon ".$sm['v_icono']."'></i>
										<p>".$sm['v_nombre']."</p>
										".$sm['v_span']."
									</a>
								</li>
							</ul>";
						}
						$active = "";
					}
					// menu-open
					$mopen = $menu1 == $m['v_link'] ? ' menu-open':"";
					$filasmenu.= "
						<li class='nav-item".$mopen."'>
							<a href=".BASE_URL.$m['v_link']." class='".$m['v_link']." nav-link'>
								<i class='nav-icon ".$m['v_icono']."'></i>
								<p>".$m['v_nombre']."</p>".$fechita."
							</a>
							".$filassub."
						</li>";
					$filassub = "";
				}

				$_SESSION['menuinicial'] = $filasmenu;

				// $url="/recursoshumanos/".$menu[0]['v_link']."/index"; //antes de acomodar los menús
				$url="/recursoshumanos/".$submenu[0]['v_link']."/index";
				
				$_SESSION['usuario']=trim($data[0]['v_nombre']);
				$_SESSION['razon']=$data[0]['v_razon'];
				$_SESSION['dni']= trim($data[0]['v_dni']);
				$_SESSION['nombre']=$data[0]['v_nombre_completo'];
				$_SESSION['foto']=$data[0]['v_ruta'];
				$_SESSION['firma']=$data[0]['v_firma'];
				$_SESSION['perfil']=$data[0]['v_perfil'];
				$_SESSION['correo']=$data[0]['v_correo'];

				$_SESSION['departamento']=$data[0]['v_departamento'];
				$_SESSION['provincia']=$data[0]['v_provincia'];
				$_SESSION['distrito']=$data[0]['v_distrito'];
				$_SESSION['direccion']=$data[0]['v_direccion'];
				$_SESSION['referencia']=$data[0]['v_referencia'];
				$_SESSION['cliente']=$data[0]['i_cliente'];

				$_SESSION['selmenu'] = "";
				$_SESSION['selsubmenu'] = "nosotros";
				$_SESSION['despliegue'] = "";

				$_SESSION['flex'] = $data[0]['i_flex']; // tarjeta de flex time
				$_SESSION['remoto'] = $data[0]['i_remoto']; // tarjeta de trabajo remoto
				$_SESSION['zona'] = $data[0]['i_zona']; // zona
				$_SESSION['local'] = $data[0]['i_local']; // local
				$_SESSION['cumpleanios'] = $data[0]['d_nacimiento']; // cumpleaños
				$_SESSION['venta'] = $data[0]['i_venta']; // pedido venta web
				$_SESSION['cargo'] = $data[0]['v_cargo']; // cargo en la empresa
				$_SESSION['nombres'] = $data[0]['v_nombres']; // nombres completos
				$_SESSION['apellidos'] = $data[0]['v_apellidos']; // apellidos completos
				$_SESSION['icumple'] = $data[0]['i_cumpleanios']; // estado para pop pup cumpleaños

				$fecha_session =  strval(date("Y-m-d H:i:s"));

				$_SESSION['fechasession'] = $fecha_session;

				if (trim($usuario) == $clave){
					$_SESSION['igualclave'] = 1;
				} else {
					$_SESSION['igualclave'] = 0;
				}

			}else{
				$estado = 1; // usuario inactivo
				$url="";
			}
		}else{
			$estado = 2; // no existe, error, usuario o clave incorrecta
			$url="";
		}

		header('Content-type: application/json; charset=utf-8');
    
		echo $json->encode(
			array(
				"estado"=>intval($estado),
				"url"=>$url,
				)
		);
	
	}

	public function recupera_clave(){
		$this->_view->setJs(array('recuperaclave'));
		$this->_view->renderizar('recuperaclave',true);
	}
	
	public function enviar_correo(){

		putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
		putenv("NLS_CHARACTERSET=AL32UTF8");

		$this->getLibrary('json_php/JSON');
		$json = new Services_JSON();

		// $output = $_POST['correo'];

		if (!empty($_POST['correo'])){
			
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
				"correo" => $_POST['correo'],
			);

			$soap = new SoapClient($wsdl, $options);
			$result = $soap->ListarRecuperarCorreo($param);
			$recuperacorreo = json_decode($result->ListarRecuperarCorreoResult, true);

			if (!empty($recuperacorreo)){

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
				$mail->Host = $conficorreo[0]['v_servidor_entrante']; //'mail.cafealtomayo.com.pe'
				$mail->Username  = $conficorreo[0]['v_correo_salida']; //'reportes@cafealtomayo.com.pe'  
				$mail->Password = $conficorreo[0]['v_password']; //'contraseña';
				$mail->Port = $conficorreo[0]['i_puerto']; //25;

				$mail->From = ($conficorreo[0]['v_correo_salida']); //('reportes@cafealtomayo.com.pe')
				$mail->FromName = $conficorreo[0]['v_nombre_salida']; //"VERDUM PERÚ SAC"
				// $mail->setFrom('reportes@cafealtomayo.com.pe', 'no replay verdum');
				// $mail->Timeout=60;
				// $mail->addReplyTo($conficorreo[0]['v_correo_salida'], 'reportes'); // ('reportes@cafealtomayo.com.pe', 'reportes')
				$mail->addAddress($recuperacorreo[0]['v_correo'],$recuperacorreo[0]['v_nombre']);
				
				$mail->isHTML(true);
				$mail->CharSet = "utf-8";
				$mail->Subject = 'RECUPERACION DE CLAVE';
				$mail->Body = "
				Hola <b>".$recuperacorreo[0]['v_nombre'].",</b>
				<br>
				<br>
				Te enviamos la nueva clave para poder ingresar al portal web.<br>
				<br>
				Clave: <b>".$recuperacorreo[0]['v_regclave']."</b>
				<br>
				<br>
				Saludo,
				<br>
				VERDUM PERU SAC.
				<br>
				<br>
				<img src='" . BASE_URL2 . "public/dist/img/footer_verdum2.png'>";
				
				// $mail->AltBody = 'Hola garcilla. Te enviamos el ticket de la compra que has realizado con nosotros. Un saludo,Lacodigoteca.com';
				// $mail->send();
				
				if (!$mail->send()) {
					$output = 3; //	ERROR AL ENVIAR CORREO
				} else {
					$output = 2; // SE ENVIO CORRECTAMENTE
				}

			}else{
				$output = 1; //NO SE ENCONTRO CORREO EN LA BASE DE DATOS
			}

		}else{
			$output = 0; // NO HA INGRESADO CORREO
		}

		header('Content-type: application/json; charset=utf-8');
    
		echo $json->encode(
			array(
				"dato"=>$output
				)
		);

	}

	public function logout(){
		if(isset($_SESSION['usuario'])){
			session_destroy();
			unset($_SESSION['usuario']);
			$this->redireccionar('index');
		}else{
			session_destroy();
			unset($_SESSION['usuario']);
			$this->redireccionar('index');
		}
	}
	
}

?>