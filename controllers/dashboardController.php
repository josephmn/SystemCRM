<?php

class dashboardController extends Controller{
	
	public function __construct(){
		parent::__construct();
	}

    public function index(){

        if(isset($_SESSION['usuario'])){

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

			$soap = new SoapClient($wsdl,$options);
			$result = $soap->ListadoPersonalTab();
			$data = json_decode($result->ListadoPersonalTabResult,true);

			$result3 = $soap->Listadopagomes();
			$filasgrafico1 = json_decode($result3->ListadopagomesResult,true);

			$result4 = $soap->Listadoareapersonal();
			$filasgrafico2 = json_decode($result4->ListadoareapersonalResult,true);

			$this->_view->data = $data;
			$this->_view->filasgrafico1 = $filasgrafico1;
			$this->_view->filasgrafico2 = $filasgrafico2;

			$this->_view->setJs(array('index'));
            $this->_view->renderizar('index');
        }else{
            $this->redireccionar('index/logout');
        }
        
    }

	public function cambiarsession()
	{
		if (isset($_SESSION['usuario'])) {

			$session = $_POST['string'];

			$_SESSION['selsubmenu'] = '';
			$_SESSION['selmenu'] = $session;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');

		} else {
			$this->redireccionar('index/logout');
		}
    }

	public function cambiarsessionsub()
	{
		if (isset($_SESSION['usuario'])) {

			$sessionsub = $_POST['string'];

			$_SESSION['selsubmenu'] = $sessionsub;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');

		} else {
			$this->redireccionar('index/logout');
		}
    }

	public function cambiaropen()
	{
		if (isset($_SESSION['usuario'])) {

			$sessionsub = $_POST['string'];

			$_SESSION['despliegue'] = $sessionsub;

			$this->_view->setJs(array('index'));
			$this->_view->renderizar('index');

		} else {
			$this->redireccionar('index/logout');
		}
    }

}

?>