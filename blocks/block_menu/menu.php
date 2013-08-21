<?php 
defined( '_JHAEXEC' ) or die( 'Access Denied' );

require_once $GLOBALS['JHA_BLOCK_PATH'] . 'helper.php';

$helper = new JhaMenuHelper($params);
$menu = $helper->getMenu();

require $GLOBALS['JHA_BLOCK_PATH'] . 'html' . DS . 'menutpl.php';
?>