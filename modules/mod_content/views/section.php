<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.mvc.view');

class ContentViewSection extends JhaView {
    public function display(){
    	$model = $this->getModel();
    	$itemid = JhaRequest::getVar('itemid', $_SESSION["itemid"]);
    	$id = JhaRequest::getVar('id',null);
    	if(!isset($itemid)){
    		$db = &JhaFactory::getDBO();
            $db->setQuery('SELECT * FROM #__menuitem WHERE home = 1');
            $row = $db->loadObject();
	        $_SESSION["itemid"] = $row->id;
	        $itemid = $row->id;
    	}
    	if ($itemid != $_SESSION["itemid"]) {
    		$_SESSION["itemid"] = $itemid;
    		$_SESSION["breadcrumb"] = array();
    	}
    	$articulos = $model->getArticulos();
        $seccion = $model->getSeccion();
        if($seccion->tipo == 'Estandar'){
        	$this->setLayout('section.estandar');
        }
        elseif($seccion->tipo == 'Dos Columnas'){
            $this->setLayout('section.twocols');
        }
        elseif($seccion->tipo == 'Una Columna'){
            $this->setLayout('section.onecol');
        }        
        $user = (isset($_SESSION['USER']) ? $_SESSION['USER'] : NULL);
        $this->assignRef('articulos',$articulos);
        $this->assignRef('seccion',$seccion);
        $this->assignRef('user',$user);
        $this->assignRef('id',$id);
    	parent::display();
    }
    
    public function reorder($isUpdated){
    	jhaimport('jhaley.web.json');
    	$objJson = new JSON ( );
        $objJson->add ( "saved", ($isUpdated ? 'true' : 'false') );
        print $objJson->render ();
        return;
    }
    
	public function admin(){
    	$model = &$this->getModel('section');
    	$secciones = $model->getSecciones();
    	$controls = $this->createControls();
    	$this->assignRef('secciones', $secciones);
    	$this->assignRef('controls', $controls);
        parent::display();
    }
    
	private function createControls(){
    	$task = JhaRequest::getVar('task');
        if($task == 'newsection' || $task == 'editsection'){
            return JhaHTML::renderControls(array('Guardar', 'Cancelar'), array('savesection', 'admin'), array('save', 'cancel'), null);
        }
        return JhaHTML::renderControls(array('Nuevo', 'Editar', 'Eliminar'), array('newsection', 'editsection', 'deletesection'), array('new', 'edit', 'delete'), null);
    }
    
    public function newsection(){
    	$controls = $this->createControls();
    	$model = &$this->getModel('content');
    	$menus = $model->getMenus();
    	
    	$this->assignRef('controls', $controls);
    	$this->assignRef('menus', $menus);
        parent::display();
    }
    
	public function editsection(){
    	$model = &$this->getModel('section');
    	$controls = $this->createControls();
    	$ids = JhaRequest::getVar('id');
    	if(!is_array($ids)) $ids = array($ids);
    	$seccion = $model->getSection($ids[0]);
    	$model = &$this->getModel('content');
    	$menus = $model->getMenus();
    	$menuid = 'x';
    	foreach ($menus as $menu) {
    		$menuitems = $model->getMenuItems($menu->id);
    		foreach ($menuitems as $menuitem) {
    			if(strpos($menuitem->enlace, "sid=" . $ids[0]) !== FALSE){
    				$menuid = $menu->id;
    				$this->assignRef('menu', $menuid);
    				break;
    			}
    		}
    	}
    	
    	$this->assignRef('menus', $menus);
    	$this->assignRef('seccion', $seccion);
    	$this->assignRef('controls', $controls);
        parent::display();
    }
}
?>