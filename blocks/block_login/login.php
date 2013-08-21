<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );

require_once $GLOBALS['JHA_BLOCK_PATH'] . 'helper.php';

$helper = new JhaLoginHelper($params);
$task = $helper->getTask();
$user = $helper->getUser();

require_once $GLOBALS['JHA_BLOCK_PATH'] . 'html' . DS . 'logintpl.php';
?>