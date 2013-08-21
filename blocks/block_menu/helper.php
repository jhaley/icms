<?php 
defined( '_JHAEXEC' ) or die( 'Access Denied' );

class JhaMenuHelper {
	private $params;
	private $menu;
	private $items;
	
	function __construct($params) {
		$this->params = $params;
		$this->menu = $this->_get(true);
		$this->items = $this->_get(false);
	}
	
    private function _get($isMenu){
        $db = &JhaFactory::getDBO();
        $query = "SELECT * FROM #__menu WHERE id = '" . $this->params['id'] . "'";
        if(!$isMenu) {
            $query = "SELECT * FROM #__menuitem WHERE menu = '" . $this->params['id'] . "' ORDER BY orden";
        }
        $db->setQuery($query);
        if(!$isMenu) {
            return $db->loadObjectList();
        }
        return $db->loadObject();
    }
	
	function getMenu(){
		$ret = '';
		if($this->params['showtitle'] == 1){
			$ret .= '<div>' . $this->menu->titulo . '</div>';
		}
		
		switch ($this->params['viewtype']) {
			case 'horizontaltable':
				$ret .= $this->showHorizontalTableMenu();
			break;
			case 'verticaltable':
                $ret .= $this->showVerticalTableMenu();
            break;
			case 'list':
			default:
				$ret .= $this->showListMenu();
			break;
		}
		return $ret;
	}
	
	private function showHorizontalTableMenu(){
		$items = array();
		foreach ($this->items as $item){
			$items[] = $this->getMenuItemHTML($item);
		}
		return '<table cellspacing="0" cellpadding="0" border="0"><tr><td>' . implode('</td><td>', $items) . '</td></tr></table>'; 
	}
	
    private function showVerticalTableMenu(){
        $items = array();
        foreach ($this->items as $item){
            $items[] = '<td>' . $this->getMenuItemHTML($item) . '</td>';
        }
        return '<table cellspacing="0" cellpadding="0" border="0"><tr>' . implode('</tr><tr>', $items) . '</tr></table>'; 
    }
    
    private function showListMenu(){
    	$items = array();
        foreach ($this->items as $item){
            $items[] = $this->getMenuItemHTML($item);
        }
        $id = (isset($this->params['cssId']) ? ' id="' . $this->params['cssId'] . '"' : '');
        return '<ul' . $id . '><li>' . implode('</li><li>', $items) . '</li></ul>';
    }
    
    private function getMenuItemHTML($item){
    	$ret = '';
    	$itemid = JhaRequest::getVar('itemid');
    	$active = ($itemid != null && $item->id == $itemid ? 'class="jha-menu-active"' : ($item->home == 1 ? 'class="jha-menu-active"' : ''));
    	if($this->params['showicons'] == 1) {
    		$iconlink = array('<td width="25" class="jha-menu-icon">' . ($item->icono ? '<img src="' . JHA_IMAGES_PATH . DS . $item->icono . '" width="25" />' : '') . '</td>', '<td><a href="' . $item->enlace . '">' . $item->nombre . '</a></td>');
    		$ret .= '<table cellspacing="0" cellpadding="0" border="0" ' . $active . '><tr>';
    		if($this->params['iconalign'] == 'left'){
    			$ret .= $iconlink[0] . $iconlink[1];
    		}
    		else {
    			$ret .= $iconlink[1] . $iconlink[0];
    		}
    		$ret .='</tr></table>';
    	}
    	else {
    		$ret .= '<a href="' . $item->enlace . '" ' . $active . '>' . $item->nombre . '</a>';
    	}
    	return $ret;
    }
    
    public function getMenus(){
        $db = &JhaFactory::getDBO();
        $db->setQuery('SELECT * FROM #__menu');
        return $db->loadObjectList();
    }
}
?>