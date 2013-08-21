<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.base.object');

class JhaThemeRenderer extends JhaObject {
	public function render(){
		$db = &JhaFactory::getDBO();
        $db->setQuery('SELECT * FROM #__plantilla WHERE predeterminado = 1');
        $row = $db->loadObject();
        
		$template = $this->loadTemplate($row);
		$_SESSION['themeHTML'] = isset($_SESSION['themeHTML']) ? $_SESSION['themeHTML'] : $row->html;
		$_SESSION['themeXML'] = isset($_SESSION['themeXML']) ? $_SESSION['themeXML'] : $row->xml;
		echo $this->renderTemplate($template);
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
		$renderer = &JhaFactory::getRenderer($type == 'maincontent' ? 'module' : $type);
		if($type == 'maincontent') {
			$GLOBALS['JHA_MODULE_PATH'] = JHA_BASE_PATH.DS.'modules'.DS.JhaRequest::getVar('elem','mod_content').DS;
			$path = $GLOBALS['JHA_MODULE_PATH'].substr(JhaRequest::getVar('elem', 'mod_content'),4).'.php';
			$content = $renderer->render($path).$content;
		}
		elseif ($type == 'head'){
            $content = $renderer->render().$content;
        }
        elseif ($type == 'admin-menu'){
        	$content = $this->renderMenu().$content;
        }
		return $content;
	}
	
	private function renderMenu(){
		$content = '';
		if(JhaUtility::userCanEdit()) {
        	$content .= '<div id="jha-admin-menu"><div style="width: 950px; margin: 0pt auto; height: 25px; background-color: #7F7F7F;"><ul id="jhamenu"><li><a href="index.php?elem=mod_base&controller=theme&task=savePersonalizedChanges">Guardar Cambios</a></li><li><a href="index.php?elem=mod_base&controller=theme&task=cancelPersonalizedChanges">Cancelar</a></li></ul></div></div><br />';
        	$GLOBALS['JHA_HEAD_VARS'][] = JhaHTML::script('document.menu = null;
        	window.onload = function(){
        	    element = Jha.dom.$(\'jhamenu\');
        	    var menu = new Jha.menu(element);
        	    document.menu = menu;
   	        };', false);
        }
        return $content;
	}
	
	protected function renderTemplate($template) {
		$replace = array();
        $matches = array();
        if(preg_match_all('#<jhadoc:include\ type="([^"]+)" (.*)\/>#iU', $template, $matches)) {
            $matches[0] = array_reverse($matches[0]);
            $matches[1] = array_reverse($matches[1]);
            $count = count($matches[1]);
            for($i = 0; $i < $count; $i++) {
                $replace[$i] = $this->getBuffer($matches[1][$i]);
            }
            $template = str_replace($matches[0], $replace, $template);
        }
        return $template;
	} 
}
?>