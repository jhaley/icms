<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.mvc.controller');

class ContentControllerNew extends JhaController {
	
	public function display(){
		parent::display();
	}
    
    public function admin(){
    	$view = &$this->getView('new');
		$view->setLayout('new.admin');
		$view->admin();
    }
    
    public function newnew(){
    	$view = &$this->getView('new');
		$view->setLayout('new.admin.form');
		$view->newnew();
    }
    
	public function editnew(){
    	$view = &$this->getView('new');
		$view->setLayout('new.admin.form');
		$view->editnew();
    }
    
    public function savenew(){
    	$model = &$this->getModel('new');
    	$id = JhaRequest::getVar('id');
    	if($id == '0')	JhaRequest::setVar('fechacreacion', date('Y-m-d H:i:s'));
		$model->saveNoticia();
		$this->redirect('index.php?elem=mod_content&controller=new&task=admin');
    }
    
	public function deletenew() {
    	$model = &$this->getModel('new');
        $ids = JhaRequest::getVar('id');
        if(!is_array($ids)) return false;
        foreach ($ids as $id) {
        	$model->deleteNoticia($id);
        }
        $this->redirect('index.php?elem=mod_content&controller=new&task=admin');
    }
}
?>