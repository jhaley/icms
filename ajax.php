<?php
session_start(); 

define( '_JHAEXEC', 1 );
define('JHA_BASE_PATH', dirname(__FILE__) );
define( 'DS', DIRECTORY_SEPARATOR );

require_once JHA_BASE_PATH.DS.'includes'.DS.'defines.php';
require_once JHA_BASE_PATH.DS.'includes'.DS.'imports.php';

$renderer = &JhaFactory::getRenderer('ajax');
$renderer->render();
?>