<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.base.object');

class JhaAJAXRenderer extends JhaObject {
    public function render(){
        $content = '';
        $elem = JhaRequest::getVar('elem');
        if(substr($elem, 0, 3) == 'mod'){
        	$renderer = &JhaFactory::getRenderer('module');
        	$GLOBALS['JHA_MODULE_PATH'] = JHA_BASE_PATH.DS.'modules'.DS.$elem.DS;
            $path = $GLOBALS['JHA_MODULE_PATH'].substr($elem, 4).'.php';
            $content = $renderer->render($path).$content;
        }
        else {
        	$block = $this->getBlock();
        	$renderer = &JhaFactory::getRenderer('block');
        	$GLOBALS['JHA_BLOCK_PATH'] = JHA_BASE_PATH.DS.'blocks'.DS.$block->renderizador.DS;
            $path = $GLOBALS['JHA_BLOCK_PATH'] . substr($block->renderizador,6) . '.php';
            $content = $renderer->render($path, $block);
        }
        echo $content;
    }
    
    protected function getBlock(){
    	$db = &JhaFactory::getDBO();
        $db->setQuery("SELECT * FROM #__bloque WHERE id = '" . JhaRequest::getVar('id') . "'");
        return $db->loadObject();
    }
}
?>