<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );

$blockparams = null;
if(JhaRequest::getVar('id', '0') != '0'){ //id del bloque
    $bloque = $this->model->getBlock(JhaRequest::getVar('id'));
    jhaimport('jhaley.html.block');
    $blockparams = JhaRendererBlock::getParams($bloque);
}

require_once $this->blocktypepath.DS.'params.php';
?>
