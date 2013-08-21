<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.mvc.view');

class ContentViewContent extends JhaView {
    public function display(){
    	$model = $this->getModel();
    	$id = JhaRequest::getVar('id',null);
    	$itemid = JhaRequest::getVar('itemid', $_SESSION["itemid"]);
    	$menu = null;
    	if(!isset($itemid)){
    		$db = &JhaFactory::getDBO();
	        $db->setQuery('SELECT * FROM #__menuitem WHERE home = 1');
	        $menu = $db->loadObject();
	        $_SESSION["itemid"] = $menu->id;
	        $itemid = $menu->id;
    	}
    	if ($itemid != $_SESSION["itemid"]) {
    		$_SESSION["itemid"] = $itemid;
    		$_SESSION["breadcrumb"] = array();
    	}
    	$toRedirect = $menu->enlace != '';
    	if(!isset($id)){
            $db = &JhaFactory::getDBO();
            $db->setQuery('SELECT * FROM #__contenido WHERE home = 1');
            $content = $db->loadObject();
            JhaRequest::setVar('id',$content->id);
        }
        if(!isset($id) && $toRedirect){
        	$this->redirect($menu->enlace);
        }
    	$articulo = $model->getArticulo();
    	$user = (isset($_SESSION['USER']) ? $_SESSION['USER'] : NULL);
    	$this->assignRef('articulo',$articulo);
    	$this->assignRef('user',$user);
    	parent::display();
    }
    
    public function admin(){
    	$model = &$this->getModel();
    	$articulos = $model->getArticulosDetailed();
    	$controls = $this->createControls();
    	$this->assignRef('articulos', $articulos);
    	$this->assignRef('controls', $controls);
        parent::display();
    }
    
	private function createControls(){
    	$task = JhaRequest::getVar('task');
        if($task == 'newarticle' || $task == 'editarticle'){
            return JhaHTML::renderControls(array('Guardar', 'Cancelar'), array('savearticle', 'admin'), array('save', 'cancel'), null);
        }
        return JhaHTML::renderControls(array('Nuevo', 'Editar', 'Eliminar'), array('newarticle', 'editarticle', 'deletearticle'), array('new', 'edit', 'delete'), null);
    }
    
    public function newarticle(){
    	$model = &$this->getModel();
    	$controls = $this->createControls();
    	$secciones = $model->getSecciones();
    	$menus = $model->getMenus();
    	
    	$this->assignRef('controls', $controls);
    	$this->assignRef('secciones', $secciones);
    	$this->assignRef('menus', $menus);
        parent::display();
    }
    
	public function editarticle(){
    	$model = &$this->getModel();
    	$controls = $this->createControls();
    	$ids = JhaRequest::getVar('id');
    	if(!is_array($ids)) $ids = array($ids);
    	$secciones = $model->getSecciones();
    	$articulo = $model->getArticle($ids[0]);
    	$menus = $model->getMenus();
    	$menuid = 'x';
    	foreach ($menus as $menu) {
    		$menuitems = $model->getMenuItems($menu->id);
    		foreach ($menuitems as $menuitem) {
    			if(strpos($menuitem->enlace, "&id=" . $ids[0]) !== FALSE){
    				$menuid = $menu->id;
    				$this->assignRef('menu', $menuid);
    				break;
    			}
    		}
    	}
    	
    	$this->assignRef('menus', $menus);
    	$this->assignRef('controls', $controls);
    	$this->assignRef('articulo', $articulo);
    	$this->assignRef('secciones', $secciones);
        parent::display();
    }
}
?>