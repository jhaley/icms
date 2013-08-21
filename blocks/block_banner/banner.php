<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );

require_once $GLOBALS['JHA_BLOCK_PATH'] . 'helper.php';

$helper = new JhaBannerHelper($params);
$images = $helper->getImages();

require_once $GLOBALS['JHA_BLOCK_PATH'] . 'html' . DS . 'bannertpl.php';
?>