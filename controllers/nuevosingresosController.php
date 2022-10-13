<?php

class nuevosingresosController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (isset($_SESSION['usuario'])) {

			$this->_view->conctructor_menu('planillas','nuevosingresos');

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

			$result1 = $soap->ConsultaFinalistas();
			$finalistas = json_decode($result1->ConsultaFinalistasResult, true);

			// NOTIFICACIONES TOTAL
			$param100 = array(
				"post"	=> 2,  	// consultar por DNI para obtener cantidad de notificaciones
				"top"	=> 0,	// no se usa para esta consulta
				"dni"	=> $_SESSION['dni'],
			);

			$result100 = $soap->ListarPaNotificaciones($param100);
			$countnoti = json_decode($result100->ListarPaNotificacionesResult, true);

			$_SESSION['num_notificaciones'] = intval($countnoti[0]['i_delay']);

			$this->_view->finalistas = $finalistas;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');
		} else {
			$this->redireccionar('index/logout');
		}
	}

	public function registropersonal()
	{
		if (isset($_SESSION['usuario'])) {

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
					//toastr
					'plugins/toastr/toastr.min',
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
					//InputMask
					'plugins/moment/moment.min',
					'plugins/inputmask/min/jquery.inputmask.bundle.min',
					//bootstrap color picker y Tempusdominus Bootstrap 4
					'plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min',
					'plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min',
					//sweetalert2
					'plugins/sweetalert2/sweetalert2.all',
					//toastr
					'plugins/toastr/toastr.min',
				)
			);

			$dni = $_GET['dni'];
			$publicacion = $_GET['publicacion'];

			// ConsultaPaPersonal

			//MICROSERVICIO A RECURSOS HUMANOS
			$wsdl1 = 'http://localhost:81/PAWEB/WSRecursos.asmx?WSDL';

			$options1 = array(
				"uri" => $wsdl1,
				"style" => SOAP_RPC,
				"use" => SOAP_ENCODED,
				"soap_version" => SOAP_1_1,
				//"cache_wsdl"=> WSDL_CACHE_BOTH,
				"connection_timeout" => 60,
				"trace" => false,
				"encoding" => "UTF-8",
				"exceptions" => false,
			);

			$soap1 = new SoapClient($wsdl1, $options1);

			//MICROSERVICIO AL RECLUTAMIENTO
			$wsdl = 'http://localhost:81/RSWEB/WSReclutamiento.asmx?WSDL';

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


			// CONSULTA DATOS DE FINALISTA
			$prm = array(
				"dni" 			=> $dni, // id del postulante 88888888
				"publicacion" 	=> $publicacion, // correlativo de publicacion PUB000001
			);

			$resu = $soap1->ConsultaPaPersonal($prm);
			$personal = json_decode($resu->ConsultaPaPersonalResult, true);

			// TIPO DOCUMENTO
			$result1 = $soap->PaTipoDocumento();
			$patipodoc = json_decode($result1->PaTipoDocumentoResult, true);

			$combotipodoc = "";
			foreach ($patipodoc as $pa) {
				if ($pa['i_codigo'] == $personal[0]['v_tipodocumento']) {
					$data = 'selected';
				} else {
					$data = '';
				}
				$combotipodoc .= "<option " . $data . " value=" . $pa['i_codigo'] . ">" . $pa['v_descripcion'] . "</option>";
			}

			// ESTADO CIVIL
			$resulta1 = $soap1->ListadoCivil();
			$datacivil = json_decode($resulta1->ListadoCivilResult, true);

			$combocivil = "";
			foreach ($datacivil as $dc) {
				if ($dc['i_id'] == $personal[0]['v_civil']) {
					$edata = 'selected';
				} else {
					$edata = '';
				}
				$combocivil .= "<option " . $edata . " value=" . $dc['i_id'] . ">" . $dc['v_nombre'] . "</option>";
			}

			// PAIS
			$result2 = $soap->Pais();
			$pais = json_decode($result2->PaisResult, true);

			$combopais = "";
			foreach ($pais as $pa) {
				if ($pa['i_codigo'] == $personal[0]['i_pais']) {
					$pdata = 'selected';
				} else {
					$pdata = '';
				}
				$combopais .= "<option " . $pdata . " value=" . $pa['i_codigo'] . ">" . $pa['v_descripcion'] . "</option>";
			}

			// DEPARTAMENTO
			$resulta2 = $soap1->ListarDepartamento();
			$departamento = json_decode($resulta2->ListarDepartamentoResult, true);

			$combodepartamento = "";
			foreach ($departamento as $dpp) {
				if ($dpp['i_iddep'] == $personal[0]['i_departamento']) {
					$ddata = 'selected';
				} else {
					$ddata = '';
				}
				$combodepartamento .= "<option " . $ddata . " value=" . $dpp['i_iddep'] . ">" . $dpp['v_descripcion'] . "</option>";
			}

			// PROVINCIA
			$param111 = array(
				"departamento" => $personal[0]['i_departamento'], //codigo departamento
			);

			$result111 = $soap1->ListarProvincia($param111);
			$dataprovincia = json_decode($result111->ListarProvinciaResult, true);

			$comboprovincia = "";
			foreach ($dataprovincia as $dpr) {
				if ($dpr['i_idpro'] == $personal[0]['i_provincia']) {
					$xdata = 'selected';
				} else {
					$xdata = '';
				}
				$comboprovincia .= "<option " . $xdata . " value=" . $dpr['i_idpro'] . ">" . $dpr['v_descripcion'] . "</option>";
			}

			// DISTRITO
			$param112 = array(
				"provincia" => $personal[0]['i_provincia'], //codigo provincia
			);

			$result112 = $soap1->ListarDistrito($param112);
			$datadistrito = json_decode($result112->ListarDistritoResult, true);

			$combodistrito = "";
			foreach ($datadistrito as $dtr) {
				if ($dtr['i_iddis'] == $personal[0]['i_distrito']) {
					$ydata = 'selected';
				} else {
					$ydata = '';
				}
				$combodistrito .= "<option " . $ydata . " value=" . $dtr['i_iddis'] . ">" . $dtr['v_descripcion'] . "</option>";
			}

			// AFP
			$result4 = $soap->PaAFP();
			$afp = json_decode($result4->PaAFPResult, true);

			$comboafp = "";
			foreach ($afp as $afp) {
				if ($afp['i_codigo'] == $personal[0]['v_afp']) {
					$zdata = 'selected';
				} else {
					$zdata = '';
				}
				$comboafp .= "<option " . $zdata . " value=" . $afp['i_codigo'] . ">" . $afp['v_descripcion'] . "</option>";
			}

			// TIPO TRABAJADOR
			$resulta3 = $soap1->ListadoTipoTrabajador();
			$datatipotrabajador = json_decode($resulta3->ListadoTipoTrabajadorResult, true);

			$combotipotrabajador = "";
			foreach ($datatipotrabajador as $dtp) {
				$combotipotrabajador .= "<option " . $dtp['v_default'] . " value=" . $dtp['i_id'] . ">" . $dtp['v_descripcion'] . "</option>";
			}

			// NIVEL DE EDUCACION
			$result5 = $soap->PaNivelD();
			$nivelD = json_decode($result5->PaNivelDResult, true);

			$combonivelD = "";
			foreach ($nivelD as $nd) {
				if ($nd['i_codigo'] == $personal[0]['i_niveleducacion']) {
					$fdata = 'selected';
				} else {
					$fdata = '';
				}
				$combonivelD .= "<option " . $fdata . " value=" . $nd['i_codigo'] . ">" . $nd['v_descripcion'] . "</option>";
			}

			// OCUPACION
			$resulta4 = $soap1->ListadoOcupacion();
			$dataocupacion = json_decode($resulta4->ListadoOcupacionResult, true);

			$comboocupacion = "";
			foreach ($dataocupacion as $coc) {
				$comboocupacion .= "<option " . $coc['v_default'] . " value=" . $coc['i_id'] . ">" . $coc['v_descripcion'] . "</option>";
			}

			// TIPO CONTRATO
			$resulta5 = $soap1->ListadoTipoContrato();
			$datatipocontrato = json_decode($resulta5->ListadoTipoContratoResult, true);

			$combotipocontrato = "";
			foreach ($datatipocontrato as $dtc) {
				$combotipocontrato .= "<option " . $dtc['v_default'] . " value=" . $dtc['i_id'] . ">" . $dtc['v_descripcion'] . "</option>";
			}

			// TIPO PAGO
			$resulta6 = $soap1->ListadoTipoPago();
			$datatipopago = json_decode($resulta6->ListadoTipoPagoResult, true);

			$combotipopago = "";
			foreach ($datatipopago as $dtp) {
				$combotipopago .= "<option " . $dtp['v_default'] . " value=" . $dtp['i_id'] . ">" . $dtp['v_descripcion'] . "</option>";
			}

			// LISTAR CENTRO DE COSTO
			$resulta7 = $soap1->ListarCentroCosto();
			$datacentrocosto = json_decode($resulta7->ListarCentroCostoResult, true);

			$combocentrocosto = "";
			foreach ($datacentrocosto as $dcc) {
				$combocentrocosto .= "<option " . $dcc['v_default'] . " value=" . $dcc['i_id'] . ">(" . $dcc['i_id'] . ") " . $dcc['v_descripcion'] . "</option>";
			}

			// LISTAR CUENTA
			$resulta8 = $soap1->ListarCuenta();
			$datacuenta = json_decode($resulta8->ListarCuentaResult, true);

			$combocuenta = "";
			foreach ($datacuenta as $dc) {
				$combocuenta .= "<option " . $dc['v_default'] . " value=" . $dc['i_id'] . ">(" . $dc['i_id'] . ") " . $dc['v_descripcion'] . "</option>";
			}

			// LISTAR EMPRESA
			$resulta9 = $soap1->ListarEmpresa();
			$dataempresa = json_decode($resulta9->ListarEmpresaResult, true);

			$comboempresa = "";
			foreach ($dataempresa as $dc) {
				$comboempresa .= "<option value=" . $dc['v_ruc'] . ">" . $dc['v_razon'] . "</option>";
			}

			// LISTAR AREA
			$resulta10 = $soap1->ListadoArea();
			$dataarea = json_decode($resulta10->ListadoAreaResult, true);

			$comboarea = "";
			foreach ($dataarea as $ca) {
				$comboarea .= "<option value=" . $ca['i_id'] . ">" . $ca['v_descripcion'] . "</option>";
			}

			// LISTAR SUB AREA
			$param11 = array(
				"post" => 1, //consulta en vacio
				"area" => "",
			);

			$resulta11 = $soap1->ListadoSubArea($param11);
			$datasubarea = json_decode($resulta11->ListadoSubAreaResult, true);

			$combosubarea = "";
			foreach ($datasubarea as $dsa) {
				$combosubarea .= "<option " . $dsa['v_default'] . " value=" . $dsa['i_id'] . ">" . $dsa['v_descripcion'] . "</option>";
			}

			// LISTAR CARGO
			$resulta12 = $soap1->ListadoCargo();
			$datacargo = json_decode($resulta12->ListadoCargoResult, true);

			$combocargo = "";
			foreach ($datacargo as $dcg) {
				if ($dcg['i_id'] == $personal[0]['v_puesto']) {
					$gdata = 'selected';
				} else {
					$gdata = '';
				}
				$combocargo .= "<option " . $gdata . " value=" . $dcg['i_id'] . ">" . $dcg['v_descripcion'] . "</option>";
			}

			// LISTAR LOCAL TRABAJO
			$resulta13 = $soap1->ListadoLocalTrabajo();
			$datalocaltrabajo = json_decode($resulta13->ListadoLocalTrabajoResult, true);

			$combolocaltrabajo = "";
			foreach ($datalocaltrabajo as $clt) {
				$combolocaltrabajo .= "<option " . $clt['v_default'] . " value=" . $clt['v_descripcion'] . ">" . $clt['v_descripcion'] . "</option>";
			}

			// LISTAR ENTIDAD FINANCIERA
			$resulta14 = $soap1->ListadoEntidadFinanciera();
			$dataentidadfinanciera = json_decode($resulta14->ListadoEntidadFinancieraResult, true);

			$comboentidadfinanciera = "";
			foreach ($dataentidadfinanciera as $cef) {
				$comboentidadfinanciera .= "<option " . $cef['v_default'] . " value=" . $cef['i_id'] . ">" . $cef['v_descripcion'] . "</option>";
			}

			$this->_view->combotipodoc = $combotipodoc;
			$this->_view->combocivil = $combocivil;
			$this->_view->combopais = $combopais;
			$this->_view->combodepartamento = $combodepartamento;
			$this->_view->comboprovincia = $comboprovincia;
			$this->_view->combodistrito = $combodistrito;
			$this->_view->comboafp = $comboafp;
			$this->_view->combotipotrabajador = $combotipotrabajador;
			$this->_view->combonivelD = $combonivelD;
			$this->_view->comboocupacion = $comboocupacion;
			$this->_view->combotipocontrato = $combotipocontrato;
			$this->_view->combotipopago = $combotipopago;
			$this->_view->combocentrocosto = $combocentrocosto;
			$this->_view->combocuenta = $combocuenta;
			$this->_view->comboempresa = $comboempresa;
			$this->_view->comboarea = $comboarea;
			$this->_view->combosubarea = $combosubarea;
			$this->_view->combocargo = $combocargo;
			$this->_view->combolocaltrabajo = $combolocaltrabajo;
			$this->_view->comboentidadfinanciera = $comboentidadfinanciera;
			$this->_view->personal = $personal;

			$this->_view->setJs(array('registropersonal'));
			$this->_view->renderizar('registropersonal');
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

			$c = 0;
			$filas = "";
			foreach ($dataprovincia as $dv) {
				$filas .= "<option value=" . $dv['i_idpro'] . ">" . $dv['v_descripcion'] . "</option>";
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

			$c = 0;
			$filas = "";
			foreach ($datadistritos as $dv) {
				$filas .= "<option value=" . $dv['i_iddis'] . ">" . $dv['v_descripcion'] . "</option>";
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

	public function cargar_subarea()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");
			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$area = $_POST['area'];

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
				"post" => 2, //consulta en vacio
				"area" => $area,
			);

			$result = $soap->ListadoSubArea($param);
			$datasubarea = json_decode($result->ListadoSubAreaResult, true);

			$filas = "";
			foreach ($datasubarea as $ca) {
				$filas .= "<option " . $ca['v_default'] . " value=" . $ca['i_id'] . ">" . $ca['v_descripcion'] . "</option>";
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

	public function mant_personal()
	{
		if (isset($_SESSION['usuario'])) {

			putenv("NLS_LANG=SPANISH_SPAIN.AL32UTF8");
			putenv("NLS_CHARACTERSET=AL32UTF8");

			$this->getLibrary('json_php/JSON');
			$json = new Services_JSON();

			$pertipodoc			 = $_POST['pertipodoc'];
			$perpaterno			 = $_POST['perpaterno'];
			$permaterno			 = $_POST['permaterno'];
			$pernombre			 = $_POST['pernombre'];
			$peremail			 = $_POST['peremail'];
			$peressalud			 = $_POST['peressalud'];
			$perdomic			 = $_POST['perdomic'];
			$perrefzona			 = $_POST['perrefzona'];
			$perdep				 = $_POST['perdep'];
			$perprov			 = $_POST['perprov'];
			$perdist			 = $_POST['perdist'];
			$perttrab			 = $_POST['perttrab'];
			$perregimen			 = $_POST['perregimen'];
			$pernivel			 = $_POST['pernivel'];
			$perocup			 = $_POST['perocup'];
			$perdisc			 = $_POST['perdisc'];
			$pertcon			 = $_POST['pertcon'];
			$perjmax			 = $_POST['perjmax'];
			$perafeps			 = $_POST['perafeps'];
			$perexqta			 = $_POST['perexqta'];
			$pertpago			 = $_POST['pertpago'];
			$perafp				 = $_POST['perafp'];
			$perarea			 = $_POST['perarea'];
			$perbanco			 = $_POST['perbanco'];
			$perbancocts		 = $_POST['perbancocts'];
			$perbruto			 = $_POST['perbruto'];
			$percargo			 = $_POST['percargo'];
			$percond			 = $_POST['percond'];
			$perctaban			 = $_POST['perctaban'];
			$perdir				 = $_POST['perdir'];
			$perid				 = $_POST['perid'];
			$peremp				 = $_POST['peremp'];
			$perfing			 = $_POST['perfing'];
			$perfnac			 = $_POST['perfnac'];
			$perhijos			 = $_POST['perhijos'];
			$permovilidad		 = $_POST['permovilidad'];
			$pernac				 = $_POST['pernac'];
			$pernumafp			 = $_POST['pernumafp'];
			$perruc				 = $_POST['perruc'];
			$perruta			 = $_POST['perruta'];
			$perseguro			 = $_POST['perseguro'];
			$persub				 = $_POST['persub'];
			$persubarea			 = $_POST['persubarea'];
			$persexo			 = $_POST['persexo'];
			$pertipopago		 = $_POST['pertipopago'];
			$pertlf1			 = $_POST['pertlf1'];
			$perzonaid			 = $_POST['perzonaid'];
			$user10				 = $_POST['user10'];
			$user2				 = $_POST['user2'];
			$user4				 = $_POST['user4'];
			$user5				 = $_POST['user5'];
			$user6				 = $_POST['user6'];
			$MontoQuintaExt		 = $_POST['MontoQuintaExt'];
			$MontoRetenidoQuinta = $_POST['MontoRetenidoQuinta'];
			$movilidadAdmin		 = $_POST['movilidadAdmin'];
			$periodosueldo		 = $_POST['periodosueldo'];
			$periodoqta			 = $_POST['periodoqta'];

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

			$params1 = array(
				'pertipodoc' 			=> $pertipodoc,
				'perpaterno' 			=> $perpaterno,
				'permaterno' 			=> $permaterno,
				'pernombre' 			=> $pernombre,
				'peremail' 				=> $peremail,
				'peressalud' 			=> $peressalud,
				'perdomic' 				=> $perdomic,
				'perrefzona' 			=> $perrefzona,
				'perdep' 				=> $perdep,
				'perprov' 				=> $perprov,
				'perdist' 				=> $perdist,
				'perttrab' 				=> $perttrab,
				'perregimen' 			=> $perregimen,
				'pernivel' 				=> $pernivel,
				'perocup' 				=> $perocup,
				'perdisc' 				=> $perdisc,
				'pertcon' 				=> $pertcon,
				'perjmax' 				=> $perjmax,
				'perafeps' 				=> $perafeps,
				'perexqta' 				=> $perexqta,
				'pertpago' 				=> $pertpago,
				'perafp' 				=> $perafp,
				'perarea' 				=> $perarea,
				'perbanco' 				=> $perbanco,
				'perbancocts' 			=> $perbancocts,
				'perbruto' 				=> $perbruto,
				'percargo' 				=> $percargo,
				'percond' 				=> $percond,
				'perctaban' 			=> $perctaban,
				'perdir' 				=> $perdir,
				'perid' 				=> $perid,
				'peremp' 				=> $peremp,
				'perfing' 				=> $perfing,
				'perfnac' 				=> $perfnac,
				'perhijos' 				=> $perhijos,
				'permovilidad' 			=> $permovilidad,
				'pernac' 				=> $pernac,
				'pernumafp' 			=> $pernumafp,
				'perruc'				=> $perruc,
				'perruta' 				=> $perruta,
				'perseguro' 			=> $perseguro,
				'persub' 				=> $persub,
				'persubarea' 			=> $persubarea,
				'persexo' 				=> $persexo,
				'pertipopago' 			=> $pertipopago,
				'pertlf1' 				=> $pertlf1,
				'perzonaid' 			=> $perzonaid,
				'user10' 				=> $user10,
				'user2' 				=> $user2,
				'user4' 				=> $user4,
				'user5' 				=> $user5,
				'user6' 				=> $user6,
				'MontoQuintaExt' 		=> $MontoQuintaExt,
				'MontoRetenidoQuinta' 	=> $MontoRetenidoQuinta,
				'movilidadAdmin' 		=> $movilidadAdmin,
				'periodosueldo'	 		=> $periodosueldo,
				'periodoqta' 			=> $periodoqta,
				'user' 					=> $_SESSION['dni'],
			);

			$soap = new SoapClient($wsdl, $options);
			$result = $soap->MantRegPersonal($params1);
			$regpersonal = json_decode($result->MantRegPersonalResult, true);

			header('Content-type: application/json; charset=utf-8');

			echo $json->encode(
				array(
					"vicon" 		=> $regpersonal[0]['v_icon'],
					"vtitle" 		=> $regpersonal[0]['v_title'],
					"vtext" 		=> $regpersonal[0]['v_text'],
					"itimer" 		=> $regpersonal[0]['i_timer'],
					"icase" 		=> $regpersonal[0]['i_case'],
					"vprogressbar" 	=> $regpersonal[0]['v_progressbar'],
				)
			);
		} else {
			$this->redireccionar('index/logout');
		}
	}
}
?>