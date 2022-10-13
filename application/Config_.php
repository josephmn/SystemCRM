<?php

/*
 * -------------------------------------
 *  Config.php
 * -------------------------------------
 */
$timezone = -5;
$fechahora =  strval(gmdate("d/m/Y H:i:s", time() + 3600 * ($timezone + date("I"))));
$fecha =  strval(gmdate("d/m/Y", time() + 3600 * ($timezone + date("I"))));
$version = "5.1.3";

define('BASE_URL', 'http://localhost/recursoshumanos/');
define('BASE_URL2', 'https://verdum.com/recursoshumanos/');
define('BASE_ROOT',$_SERVER['DOCUMENT_ROOT'].'/recursoshumanos/');
// define('BASE_ROOT',$_SERVER['DOCUMENT_ROOT']);
define('DEFAULT_CONTROLLER', 'index');
define('DEFAULT_LAYOUT', 'default');

define('ruc', '20394862704');
define('nombrecomercial','ALTOMAYO');
define('fechasis',$fecha);
define('fechahorasis',$fechahora);
define('version',$version);

// define('DB_HOST1', 'localhost');
// define('DB_USER1', 'root');
// define('DB_PASS1', '');
// define('DB_NAME1', 'recursos_humanos');

define('LAST_VERSION_SOURCE',strtotime('2022-06-07 08:10:00'));
?>