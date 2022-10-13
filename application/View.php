<?php

/*
 * -------------------------------------

 * View.php
 * -------------------------------------
 */


class View
{
	private $_controlador;
	private $_js;

	public function __construct(Request $peticion)
	{
		$this->_controlador = $peticion->getControlador();
		$this->_js = array();
		$this->_jsSp = array();
		$this->_cssSp = array();
	}


	/*
	 *  Esta funcion vuelve a cargar la pagina
	 *
	 *
	 */

	public function renderizar($vista, $partial = false)
	{


		$js = array();
		$jsSp = array();
		$cssSp = array();

		if (count($this->_js)) {
			$js = $this->_js;
		}

		if (count($this->_jsSp)) {
			$jsSp = $this->_jsSp;
		}

		if (count($this->_cssSp)) {
			$cssSp = $this->_cssSp;
		}

		$_layoutParams = array(
			'js' => $js,
			'jsSp' => $jsSp,
			'cssSp' => $cssSp
		);

		// $_layoutParams = array(
		//     'ruta_css' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/css/',
		//     'ruta_img' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/img/',
		//     'ruta_js' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/js/',
		//     'js' => $js
		// );

		$rutaView = ROOT . 'views' . DS . $this->_controlador . DS . $vista . '.phtml';

		if (is_readable($rutaView)) {
			if (!$partial) {
				include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'header.php';
				include_once $rutaView;
				include_once ROOT . 'views' . DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'footer.php';
			} else
				include_once $rutaView;
		} else {
			throw new Exception('Error de vista');
		}
	}

	/*
	 *  carga los js  especificos del controlador
	 *
	 */

	public function setJs(array $js)
	{
		if (is_array($js) && count($js)) {
			for ($i = 0; $i < count($js); $i++) {
				$this->_js[] = BASE_URL . 'views/' . $this->_controlador . '/js/' . $js[$i] . '.js?v='.LAST_VERSION_SOURCE;
			}
		} else {
			throw new Exception('Error de js');
		}
	}

	/*
	 *  Carga los js generales del controlador
	 *
	 */

	public function setJs_Specific(array $js)
	{
		if (is_array($js) && count($js)) {
			for ($i = 0; $i < count($js); $i++) {
				$this->_jsSp[] = BASE_URL . 'public/' . $js[$i] . '.js?v='.LAST_VERSION_SOURCE;
			}
		} else {
			throw new Exception('Error de js');
		}
	}

	/*
	 *  Carga los css generales del controlador
	 *
	 */

	public function setCss_Specific(array $css)
	{
		if (is_array($css) && count($css)) {
			for ($i = 0; $i < count($css); $i++) {
				$this->_cssSp[] = BASE_URL . 'public/' . $css[$i] . '.css';
			}
		} else {
			throw new Exception('Error de css');
		}
	}

	// menu
	public function conctructor_menu($menu,$submenu)
	{
		$filasmenu = "";
		$filassub = "";
		$menu1 = $menu;
		$submenu1 = $submenu;
		$active = "";

		foreach	($_SESSION['menus'] as $m) {
			$fechita = $m['i_submenu'] == 1 ? "<i class='right fas fa-angle-left'></i>":"";
			foreach ($_SESSION['submenus'] as $sm) {
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
	}
	
}
?>