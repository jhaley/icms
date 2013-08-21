<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.mvc.view');

class MenuViewMenu extends JhaView {
    public function display(){
    	$this->admin();
    }
    
    public function admin(){
    	$model = &$this->getModel();
    	$menus = $model->getMenus();
    	$controls = $this->createControls();
    	$showing = JhaRequest::getVar('showing', false);
    	if($showing){
    		JhaRequest::setVar('idmenu',$showing);
    		JhaRequest::setVar('task','loadMenuItems');
    		$menuitems = $this->loadMenuItems();
    		$this->assignRef('menuitems', $menuitems);
    	}
    	$this->assignRef('menus', $menus);
    	$this->assignRef('showing', $showing);
    	$this->assignRef('controls', $controls);
        parent::display();
    }
    
	private function createControls(){
        //array-> titulos, link, tasks, linktype**, icons
    	$task = JhaRequest::getVar('task');
    	$item = ($task == 'newmenuitem' || $task == 'editmenuitem' || $task == 'loadMenuItems' ? 'item' : '');
        if($task == 'newmenu' || $task == 'newmenuitem' || $task == 'editmenu' || $task == 'editmenuitem'){
            return JhaHTML::renderControls(array('Guardar', 'Cancelar'), array('savemenu' . $item, 'cancel'), array('save', 'cancel'), null);
        }
        return JhaHTML::renderControls(array('Nuevo', 'Editar', 'Eliminar'), array('newmenu' . $item, 'editmenu' . $item, 'deletemenu' . $item), array('new', 'edit', 'delete'), null);
    }
    
    public function newmenu(){
    	$controls = $this->createControls();
    	
    	$this->assignRef('controls', $controls);
    	parent::display();
    }
    
    public function editmenu(){
    	$model = &$this->getModel();
    	$controls = $this->createControls();
    	$ids = JhaRequest::getVar('idmenu');
    	if(!is_array($ids)) $ids = array($ids);
    	$menu = $model->getMenu($ids[0]);
    	
    	$this->assignRef('menu', $menu);
    	$this->assignRef('controls', $controls);
    	parent::display();
    }
    
    public function newmenuitem(){
    	$model = &$this->getModel();
    	$controls = $this->createControls();
    	$idmenu = JhaRequest::getVar('showing');
    	$menuitems = $model->getMenuitems($idmenu);
    	$this->assignRef('controls', $controls);
    	$this->assignRef('idmenu', $idmenu);
    	$this->assignRef('menuitems', $menuitems);
    	parent::display();
    }
    
	public function editmenuitem(){
    	$model = &$this->getModel();
    	$controls = $this->createControls();
    	$ids = JhaRequest::getVar('id');
    	if(!is_array($ids)) $ids = array($ids);
    	$menuitem = $model->getMenuItem($ids[0]);
    	$idmenu = JhaRequest::getVar('showing');
    	$menuitems = $model->getMenuitems($idmenu);
    	$linkview = $this->getLinkView($model, $menuitem->enlace, $menuitem->home);
    	
    	$this->assignRef('menuitem', $menuitem);
    	$this->assignRef('enlace_view', $linkview);
    	$this->assignRef('controls', $controls);
    	$this->assignRef('idmenu', $idmenu);
    	$this->assignRef('menuitems', $menuitems);
    	parent::display();
    }
    
    public function getLinkView($model, $enlace, $home){
    	$enlace = substr($enlace, strlen('index.php?'));
    	$parts = split("&", $enlace);
    	$elems = array();
    	foreach ($parts as $part) {
    		$elems = split("=", $part);
    		if($elems[0] == 'id' || $elems[0] == 'sid'){
    			break;
    		}
    	}
    	if($home == 1)	$elems = array('id', '');
    	if($elems[0] == 'sid'){
    		$section = $model->getSection($elems[1]);
    		return $section->id . ' : ' . $section->nombre;
    	}
    	elseif ($elems[0] == 'id'){
    		$article = $model->getArticle($elems[1], $home);
    		return $article->id . ' : ' . $article->titulo;
    	}
    	else{
    		return 'Enlace Externo';
    	}
    }
    
    public function loadMenuItems(){
    	$res = '';
    	$model = &$this->getModel();
    	$oldLayout = $this->getLayout();
    	$this->setLayout('menuitem');
    	$menuitems = $model->getMenuitems(JhaRequest::getVar('idmenu'));
    	$controls = $this->createControls();
    	
        $this->assignRef('menuitems', $menuitems);
        $this->assignRef('controls', $controls);
        ob_start();
        parent::display();
        $res = ob_get_contents();
        ob_end_clean();
        $this->setLayout($oldLayout);
        return $res;
    }
    
    public function listArticles(){
    	$res = '';
    	$model = &$this->getModel();
    	$oldLayout = $this->getLayout();
    	$this->setLayout('list.links');
    	$articles = $model->getArticles();
    	
        $this->assignRef('items', $articles);
        ob_start();
        parent::display();
        $res = ob_get_contents();
        ob_end_clean();
        $this->setLayout($oldLayout);
        return $res;
    }
    
	public function listSections(){
		$res = '';
    	$model = &$this->getModel();
    	$oldLayout = $this->getLayout();
    	$this->setLayout('list.links');
    	$sections = $model->getSections();
    	
        $this->assignRef('items', $sections);
        ob_start();
        parent::display();
        $res = ob_get_contents();
        ob_end_clean();
        $this->setLayout($oldLayout);
        return $res;
	}
}
?>