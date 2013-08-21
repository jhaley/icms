<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.mvc.controller');

class ContentControllerSection extends JhaController {
	public function display(){
		parent::display();
	}
	
    public function edit(){
        $this->display();
    }
    
    public function save() {
    	$model = &$this->getModel();
        $model->save();
        $this->redirect('index.php?elem=mod_content&controller=section&sid=' . JhaRequest::getVar('sid'));
    }
    
    public function cancel(){
        $this->display();
    }
    
    public function reorder() {
    	$model = &$this->getModel();
    	$view = &$this->getView();
    	$articles = $model->getArticulos();
    	$src = JhaRequest::getVar('src',NULL);
    	$trg = JhaRequest::getVar('trg',NULL);
    	$json = JhaRequest::getVar('json','false');
    	$before = JhaRequest::getVar('before','false');
    	$objSrc = JhaUtility::search($src, $articles);
    	$objTrg = JhaUtility::search($trg, $articles);
    	if($before == 'true')
    		$neworder = JhaUtility::inArray($objTrg, $articles);
   		else 
   			$neworder = JhaUtility::inArray($objTrg, $articles) + 1;
    	//$neworder = ($before == true ? JhaUtility::inArray($objTrg, $articles) : JhaUtility::inArray($objTrg, $articles) + 1);
    	$newarticles = $this->reordenar($articles, $src, $neworder, $objSrc);
    	$isUpdated = true;
    	for($i = 0; $i < count($newarticles); $i++) {
    		$isUpdated = $isUpdated && $model->updateArticle($newarticles[$i], $i + 1);
    	}
    	if($json == 'true')
    	    $view->reorder($isUpdated);
   	    else
    	    parent::display();
    }
    
    private function reordenar($articles, $id, $neworder, $obj) {
        $newarticles = array();
        for($i = 0; $i < count($articles); $i++) {
            if($articles[$i]->id != $id) {
                if(count($newarticles) == $neworder)
                    $newarticles[] = $obj;
                $newarticles[] = $articles[$i];
            }
        }
        if(!JhaUtility::search($obj->id, $newarticles)) {
        	if($neworder > 0)
        		$newarticles[] = $obj;
       		else {
       			$newarticles = array_reverse($newarticles);
       			$newarticles[] = $obj;
       			$newarticles = array_reverse($newarticles);
       		}
        }
        return array_reverse($newarticles);
    }

	public function admin(){
    	$view = &$this->getView('section');
		$view->setLayout('section.admin');
		$view->admin();
    }
    
    public function newsection(){
    	$view = &$this->getView('section');
		$view->setLayout('section.admin.form');
		$view->newsection();
    }
    
	public function editsection(){
    	$view = &$this->getView('section');
		$view->setLayout('section.admin.form');
		$view->editsection();
    }
    
    public function savesection(){
    	$model = &$this->getModel('section');
    	$secciones = $model->getSecciones();
    	$id = JhaRequest::getVar('id');
    	if($id == '0')	JhaRequest::setVar('orden', count($secciones) + 1);
    	$id = $model->saveSection();
    	$this->deleteSectionMenuLink($id);
		if(JhaRequest::getVar('menu') != 'x')
			$this->saveSectionMenuLink($id);
		$this->redirect('index.php?elem=mod_content&controller=section&task=admin');
    }

    private function deleteSectionMenuLink($id){
    	$model = &$this->getModel('content');
    	$menus = $model->getMenus();
    	foreach ($menus as $menu) {
    		$menuitems = $model->getMenuItems($menu->id);
    		foreach ($menuitems as $menuitem) {
    			if(strpos($menuitem->enlace, "sid=" . $id) !== FALSE){
    				$model->deleteMenuItemLink($menuitem->id);
    				break;
    			}
    		}
    	}
    }

    private function saveSectionMenuLink($id){
    	$model = &$this->getModel('content');
    	$menuitems = $model->getMenuItems(JhaRequest::getVar('menu'));
    	JhaRequest::setVar('orden', count($menuitems) + 1);
    	JhaRequest::setVar('icono', 'nothing.jpg');
    	JhaRequest::setVar('home', '0');
    	$itemid = $model->saveMenuItemLink();
    	JhaRequest::setVar('enlace', 'index.php?elem=mod_content&controller=section&sid=' . $id . '&itemid=' . $itemid);
    	$model->saveMenuItemLink($itemid);
    }
    
    
	public function deletesection() {
    	$model = &$this->getModel('section');
        $ids = JhaRequest::getVar('id');
        if(!is_array($ids)) return false;
        foreach ($ids as $id) {
        	$articulos = $model->getArticles($id);
        	if(count($articulos) > 0)
        		throw new Exception('No se puede eliminar algunas secciones debido a que tienen articulos asociados.');
       		$model->deleteSection($id);
        }
        //redireccionar a la pagina anterior.
        $this->redirect('index.php?elem=mod_content&controller=section&task=admin');
    }
}
?>