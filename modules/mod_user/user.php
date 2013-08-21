<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );

$control = JhaRequest::getVar('controller', 'user');
require_once($GLOBALS['JHA_MODULE_PATH'].'controllers'.DS.$control.'.php' );

$classname = 'UserController' . $control;
$controller = new $classname();

$controller->execute(JhaRequest::getVar('task'));
?>