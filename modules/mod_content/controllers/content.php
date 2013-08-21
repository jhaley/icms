<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.mvc.controller');

class ContentControllerContent extends JhaController {
	
	public function display(){
		parent::display();
	}
    
    public function save() {
    	$model = &$this->getModel();
        $model->save();
        $this->redirect('index.php?elem=mod_content&id=' . JhaRequest::getVar('id'));
    }
    
    public function admin(){
    	$view = &$this->getView();
		$view->setLayout('content.admin');
		$view->admin();
    }
    
    public function newarticle(){
    	$view = &$this->getView();
		$view->setLayout('content.admin.form');
		$view->newarticle();
    }
    
	public function editarticle(){
    	$view = &$this->getView();
		$view->setLayout('content.admin.form');
		$view->editarticle();
    }
    
    public function savearticle(){
    	$model = &$this->getModel();
    	$articles = $model->getArticulosDetailed();
    	$id = JhaRequest::getVar('id');
    	JhaRequest::setVar('orden', $id == '0' ? count($articles) + 1 : NULL);
    	if($id == '0')	JhaRequest::setVar('fechacreacion', date('Y-m-d H:i:s'));
    	if($id == '0')	JhaRequest::setVar('fechapublicacion', date('Y-m-d H:i:s'));
		$id = $model->saveArticle();
		$this->deleteArticleMenuLink($id);
		if(JhaRequest::getVar('menu') != 'x')
			$this->saveArticleMenuLink($id);
		$this->redirect('index.php?elem=mod_content&task=admin');
    }
    
    private function deleteArticleMenuLink($id){
    	$model = &$this->getModel();
    	$menus = $model->getMenus();
    	foreach ($menus as $menu) {
    		$menuitems = $model->getMenuItems($menu->id);
    		foreach ($menuitems as $menuitem) {
    			if(strpos($menuitem->enlace, "&id=" . $id) !== FALSE){
    				$model->deleteMenuItemLink($menuitem->id);
    				break;
    			}
    		}
    	}
    }

    private function saveArticleMenuLink($id){
    	$model = &$this->getModel();
    	$menuitems = $model->getMenuItems(JhaRequest::getVar('menu'));
    	JhaRequest::setVar('orden', count($menuitems) + 1);
    	JhaRequest::setVar('icono', 'nothing.jpg');
    	JhaRequest::setVar('home', '0');
    	JhaRequest::setVar('nombre', JhaRequest::getVar('titulo'));
    	$itemid = $model->saveMenuItemLink();
    	JhaRequest::setVar('enlace', 'index.php?elem=mod_content&id=' . $id . '&itemid=' . $itemid);
    	$model->saveMenuItemLink($itemid);
    }
    
	public function deletearticle() {
    	$model = &$this->getModel();
        $ids = JhaRequest::getVar('id');
        if(!is_array($ids)) return false;
        foreach ($ids as $id) {
        	$model->deleteArticle($id);
        }
        //redireccionar a la pagina anterior.
        $this->redirect('index.php?elem=mod_content&task=admin');
    }
}
?>