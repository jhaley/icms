<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.base.object');

class JhaRendererAdminMenu extends JhaObject {
    public function render(){
    	$content = '';
        $user = (isset($_SESSION['USER']) ? $_SESSION['USER'] : NULL);
        $canEdit = $user->rol == 'Super Administrador' || $user->rol == 'Editor';
        if($canEdit){
        	$xml = simplexml_load_file(JHA_LIBRARIES_PATH.DS.'jhaley'.DS.'xml'.DS.'adminmenu.xml');
        	$content .= '<div id="jha-admin-menu"><div style="width: 950px; margin: 0pt auto; height: 25px; background-color: #7F7F7F;">' . $this->createMenu($xml) . '</div></div><br />';
        	$GLOBALS['JHA_HEAD_VARS'][] = JhaHTML::script('document.menu = null;
        	window.onload = function(){
        	    element = Jha.dom.$(\'jhamenu\');
        	    var menu = new Jha.menu(element);
        	    document.menu = menu;
   	        };', false);
        }
        return $content;
    }
    
    protected function createMenu($xml){
    	$content = '<ul' . $this->getAttributes($xml->attributes()) . '>';
   		foreach ($xml->elements->element as $element) {
   			$att = $element->attributes();
   			$content .= '<li><a' . $this->getAttributes($att) . '>' . $element->text . '</a>';
   			if(!isset($element->elements) && $att['type'] == 'bd'){
			    $content .= $this->createSubMenuBD(0);
   			}
   			elseif(isset($element->elements)){
   				$content .= $this->createMenu($element);
   			}
   			$content .= '</li>';
   		}
    	return $content . '</ul>';
    }
    
    protected function createSubMenuBD($level, $id = NULL){
    	$content = '';
    	$links = $this->getModuleList($level, $id);
    	if(count($links) > 0){
    		$content .= '<ul>';
	    	foreach ($links as $link) {
	    		$href = ($link->link != '' ? ' href="' . $link->link . '&itemid=' . $_SESSION["itemid"] . '"' : '');
	    		$content .= '<li><a' . $href . '>' . $link->nombre . '</a>';
	    		$content .= $this->createSubMenuBD($level + 1, $link->id) . '</li>';
	    	}
	    	$content .= '</ul>';
    	}
    	return $content;
    }
    
    protected function getModuleList($level, $id = NULL){
    	$db = &JhaFactory::getDBO();
    	$db->setQuery('SELECT * FROM #__modules WHERE parent = ' . ($level == 0 ? '0' : $id));
        return $db->loadObjectList();
    }
    
    protected function getAttributes($attributes){
    	$attr = '';
    	if(count($attributes) > 0){
    		foreach ($attributes as $index => $value){
    			if($index == 'href'){
    				$attr .= ' ' . $index . '="' . $value . '&itemid=' . $_SESSION["itemid"] . '"';
    			}
    			elseif($index != 'type'){
    			    $attr .= ' ' . $index . '="' . $value . '"';
    			}
    		}
    	}
    	return $attr;
    }
}
?>