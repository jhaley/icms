<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );

$control = JhaRequest::getVar('controller', 'content');
require_once($GLOBALS['JHA_MODULE_PATH'].'controllers'.DS.$control.'.php' );

$classname = 'ContentController' . $control;
$controller = new $classname();

$controller->execute(JhaRequest::getVar('task'));
?>