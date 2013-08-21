<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.mvc.controller');

class MenuControllerMenu extends JhaController {
	
	public function display(){
		$this->admin();
	}
	
	public function admin(){
		$view = &$this->getView();
		$view->setLayout('menu');
		$view->admin();
	}
	
	/**
	 * Menu Section 
	 */
	public function newmenu(){
		$view = &$this->getView();
		$view->setLayout('menu.form');
		$view->newmenu();
	}
	
	public function editmenu(){
		$view = &$this->getView();
		$view->setLayout('menu.form');
		$view->editmenu();
	}
	
	public function savemenu(){
		$model = &$this->getModel();
		$model->saveMenu();
		$this->redirect('index.php?elem=mod_menu');
	}
	
	public function deletemenu(){
		$model = &$this->getModel();
        $ids = JhaRequest::getVar('idmenu');
        if(!is_array($ids)) return false;
        foreach ($ids as $id) {
        	$menuitems = $model->getMenuitems($id);
        	if(count($menuitems)){
	        	foreach ($menuitems as $menuitem) {
	        		$model->deleteMenuItem($menuitem->id);
	        	}
        	}
        	$model->deleteMenu($id);
        }
        //redireccionar a la pagina anterior.
        $this->redirect('index.php?elem=mod_menu');
	}
	
	/**
	 * Menuitem Section
	 */
	
	public function newmenuitem(){
		$view = &$this->getView();
		$view->setLayout('menuitem.form');
		$view->newmenuitem();
	}
	
	public function editmenuitem(){
		$view = &$this->getView();
		$view->setLayout('menuitem.form');
		$view->editmenuitem();
	}
	
	public function savemenuitem(){
		$model = &$this->getModel();
		$menuitems = $model->getMenuItems(JhaRequest::getVar('showing'));
		//Determinar menu por defecto
		if(count($menuitems) == 0)	JhaRequest::setVar('home', '1');
		elseif (count($menuitems) > 0 && intval(JhaRequest::getVar('home')) == 1){
			foreach ($menuitems as $menuitem) {
				if($menuitem->home != 0){
					$model->setUndefaultMenuItem($menuitem);
				}
			}
		}
		//Reordenar si es necesario antes de guardar.
		$id = JhaRequest::getVar('id');
    	if($id != '0'){
    		$orden = intval(JhaRequest::getVar('orden'));
    		$menuitem = $model->getMenuItem($id);
    		if($menuitem->orden != $orden){
    			$elem = JhaUtility::search($id, $menuitems);
    			$menuitems = JhaUtility::remove($elem, $menuitems);
    			$pos = -1;
    			if(count($menuitems) + 1 < $orden)	$pos = count($menuitems);
    			else{
	    			for ($i = 0; $i < count($menuitems); $i++) {
	    				if($menuitems[$i]->orden == $orden){
	    					$pos = $i;
	    					break;
	    				}
	    			}
    			}
    			if($pos == -1)	return false;
   				$menuitems = JhaUtility::insert($elem, $pos, $menuitems);
   				$model->saveMenuItem();
	    		for($i = 0; $i < count($menuitems); $i++) {
	                $model->updateMenuItem($menuitems[$i], $i + 1);
	            }
    		}
    		else{
    			$model->saveMenuItem();
    		}
    	}
    	else {
    		JhaRequest::setVar('orden', count($menuitems));
    		$id = $model->saveMenuItem();
    	}
    	if(strpos(JhaRequest::getVar('enlace'), "itemid") === false){
    		JhaRequest::setVar('enlace', JhaRequest::getVar('enlace') . '&itemid=' . $id);
    		JhaRequest::setVar('id', $id);
    		$model->saveMenuItem();
    	}
		$this->redirect('index.php?elem=mod_menu&showing='.JhaRequest::getVar('showing'));
	}
	
	public function deletemenuitem(){
		$model = &$this->getModel();
        $ids = JhaRequest::getVar('id');
        if(!is_array($ids)) return false;
        foreach ($ids as $id) {
        	$model->deleteMenuItem($id);
        }
        //redireccionar a la pagina anterior.
        $this->redirect('index.php?elem=mod_menu&showing='.JhaRequest::getVar('showing'));
	}
	
	/**
	 * Ajax Functions
	 */
	public function loadMenuItems(){
		$model = &$this->getModel();
		$view = &$this->getView();
		$view->setModel($model);
        $view->setLayout('menuitem');
        echo $view->loadMenuItems();
	}
	
	public function listArticles(){
		$model = &$this->getModel();
		$view = &$this->getView();
		$view->setModel($model);
        $view->setLayout('list.links');
        echo $view->listArticles();
	}
	
	public function listSections(){
		$model = &$this->getModel();
		$view = &$this->getView();
		$view->setModel($model);
        $view->setLayout('list.links');
        echo $view->listSections();
	}
}
?>