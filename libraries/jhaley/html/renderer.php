<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.base.object');

class JhaRenderer extends JhaObject {
	public function render(){
		$db = &JhaFactory::getDBO();
        $db->setQuery('SELECT * FROM #__plantilla WHERE predeterminado = 1');
        $row = $db->loadObject();
        
		$template = $this->loadTemplate($row);
		echo $this->renderTemplate(str_replace('<jhadoc:include type="maincontent" />', $row->html, $template));
	}
	 
	protected function loadTemplate($row){
        $template = '';
		ob_start();
        require_once JHA_THEMES_PATH.DS.($row ? $row->nombre : 'default').DS.'index.php';
        $template = ob_get_contents();
        ob_end_clean();
        return $template;
	}
	
	protected function getBuffer($type = null, $region = null){
		$content = '';
		if($type == null){
		    return;
		}
		$renderer = &JhaFactory::getRenderer($type);
		if($type == 'module'){
			$GLOBALS['JHA_MODULE_PATH'] = JHA_BASE_PATH.DS.'modules'.DS.JhaRequest::getVar('elem','mod_content').DS;
			$path = $GLOBALS['JHA_MODULE_PATH'].substr(JhaRequest::getVar('elem', 'mod_content'),4).'.php';
			$content = $renderer->render($path).$content;
		}
		elseif ($type == 'block' && $region != null){
			$blocks = $this->getBlocks($region);
			if($blocks) {
				if(JhaUtility::userCanEdit()){
				    $content .= '<div class="jhablock"><div class="jhablock-header">Region: ' . ucfirst($region) . '</div>';
				    $script = '';
		        }
				foreach($blocks as $block) {
					if($this->isRenderable($block) && $this->canShowed($block)){
						$GLOBALS['JHA_BLOCK_PATH'] = JHA_BASE_PATH.DS.'blocks'.DS.$block->renderizador.DS;
						$path = $GLOBALS['JHA_BLOCK_PATH'] . substr($block->renderizador,6) . '.php';
						$content .= $renderer->render($path, $block);
						if(JhaUtility::userCanEdit()){
							$script .= "dragBlock.addTarget(Jha.dom.$('block" . $block->id . "'));\n";
						}
					}
				}
				if(JhaUtility::userCanEdit()){
					//target por defecto para crear un punto de anclaje para los nuevos bloques que se arrastren a esta region
					$content .= '<div id="block' . $region . '" style="height:10px; width:100%;"></div>';
					//scripts que agregan los bloques a la lista de targets, y tambien al target por defecto.
					$content .= JhaHTML::script($script, false);
					$content .= JhaHTML::script("dragBlock.addTarget(Jha.dom.$('block" . $region . "'));\n", false);
					//agregar el enlace para agregar nuevos bloques.
					$content .= (JhaUtility::userCanAdministrate() ? '<div><a href="index.php?elem=mod_base&controller=block&task=newblock&region=' . $region . '"><img src="images/new.jpg" title="Agregar nuevo bloque" /></a></div>' : '');
					$content .= '</div>';
				}
			}
			else {
				if(JhaUtility::userCanEdit()){
					$content .= '<div class="jhablock"><div class="jhablock-header">Region: ' . ucfirst($region) . '</div><div id="block' . $region . '" style="height:10px; width:100%;"></div>' . (JhaUtility::userCanAdministrate() ? '<div><a href="index.php?elem=mod_base&controller=block&task=newblock&region=' . $region . '"><img src="images/new.jpg" title="Agregar nuevo bloque" /></a></div>' : '') . JhaHTML::script("dragBlock.addTarget(Jha.dom.$('block" . $region . "'));\n", false) . '</div>';
				}
			}
		}
		elseif ($type == 'head' || ($type == 'admin-menu' && JhaUtility::userCanAdministrate())){
            $content = $renderer->render().$content;
        }
		return $content;
	}
	
	protected function getBlocks($region){
		$db = &JhaFactory::getDBO();
        $db->setQuery("SELECT * FROM #__bloque WHERE region = '" . $region . "' ORDER BY orden ASC");
        return $db->loadObjectList();
	}
	
	protected function canShowed($block){
		if(JhaUtility::userCanEdit()){
			return true;
		}
		return 0 == intval($block->needlogin);
	}
	
	protected function isRenderable($block){
		$db = &JhaFactory::getDBO();
        $itemid = JhaRequest::getVar('itemid',0);
        if($itemid == 0){
            $db->setQuery('SELECT * FROM #__menuitem WHERE home = 1');
            $row = $db->loadObject();
            $itemid = $row->id;
        }
        $db->setQuery("SELECT * FROM #__menubloque WHERE (idmenu = '" . $itemid . "' OR idmenu = '0' ) AND idbloque = '" . $block->id . "'");
        $row = $db->loadObject();
        if($row)
            return true;
        return false;
	}
	
	protected function renderTemplate($template) {
        if(JhaUtility::userCanEdit()){
        	$GLOBALS['JHA_HEAD_VARS'][] = JhaHTML::script("dragBlock = new Jha.drag();\ndragBlock.setType('block');\ndragBlock.ajaxPost = function (objajax, idSource, idTarget, isBeforeTarget) { objajax.json = true; res = { elem : 'mod_base', controller : 'block', src : idSource, trg : idTarget, json : objajax.json, before : isBeforeTarget, task : 'reorder'}; return res; };", false);
        }
		$replace = array();
        $matches = array();
        if(preg_match_all('#<jhadoc:include\ type="([^"]+)" (.*)\/>#iU', $template, $matches)) {
            $matches[0] = array_reverse($matches[0]);
            $matches[1] = array_reverse($matches[1]);
            $matches[2] = array_reverse($matches[2]);
            $count = count($matches[1]);
            for($i = 0; $i < $count; $i++) {
                $attribs = JhaUtility::parseAttributes( $matches[2][$i] );
                $replace[$i] = $this->getBuffer($matches[1][$i], (isset($attribs['region']) ? $attribs['region'] : null));
            }
            $template = str_replace($matches[0], $replace, $template);
        }
        return $template;
	} 
}
?>