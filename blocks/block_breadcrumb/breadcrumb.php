<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );

require_once $GLOBALS['JHA_BLOCK_PATH'] . 'helper.php';

$helper = new JhaBreadcrumbHelper($params);
$links = $helper->getLinks();

require_once $GLOBALS['JHA_BLOCK_PATH'] . 'html' . DS . 'breadcrumbtpl.php';
?>