<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.base.object');

class JhaRendererBlock extends JhaObject {
	public function render($path, $block){
		$content = '';
		$params = $this->getParams($block);
	    if(file_exists( $path )){
            ob_start();
            require $path;
            if(JhaUtility::userCanEdit()){
                $content .= '<div class="block blockelement' . $params['suffix'] . '" id="block' . $block->id . '"><div class="block-header"><div align="left" style="float:left;"><a href="index.php?elem=mod_base&controller=block&task=editblock&id=' . $block->id . '" title="Editar"><img src="images/edit.jpg" /></a></div><div align="left" onmousedown="javascript:dragBlock.onDragStart(event, Jha.dom.$(\'block' . $block->id . '\'));" style="line-height: 2;">' . $block->titulo . '</div></div>' . ob_get_contents() . '</div>';
            }
            else {
                $content = '<div class="blockelement' . $params['suffix'] . '">' . ob_get_contents() . '</div>';
            }
            ob_end_clean();
        }
        return $content;
	}
	
	public function getParams($block){
		$params = split("\n",$block->params);
		$res = array();
		foreach ($params as $param){
			$parts = split('=', $param);
			$res[$parts[0]] = $parts[1];
		}
		return $res;
	}
}
?>