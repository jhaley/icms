<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.mvc.controller');

class UserControllerUser extends JhaController {
	public function display(){
		parent::display();
	}
	
	public function login() {
		$model = &$this->getModel( 'user' );
        $user = $model->login();
        if ($user) {
        	JhaRequest::setVar('id', $user->id);
        	JhaRequest::setVar('fechaultimoacceso', date('Y-m-d H:i:s'));
        	$model->saveUser();
            $_SESSION['USER'] = $user;
            $_SESSION["breadcrumb"] = array();
        }
        else {
            unset($_SESSION['USER']);
        }
        $this->redirect();
	}
	
    public function logout() {
        unset($_SESSION['USER']);
        $_SESSION["breadcrumb"] = array();
        $this->redirect();
    }
    
    public function admin() {
    	if(JhaUtility::userCanAdministrate()){
	    	$view = &$this->getView();
			$view->setLayout('user.admin');
			$view->admin();
    	}
    	else
    		$this->redirect();
    }
    
    public function newuser() {
    	if(JhaUtility::userCanAdministrate()){
	    	$view = &$this->getView();
			$view->setLayout('user.admin.form');
			$view->newuser();
    	}
    	else
    		$this->redirect();
    }
    
	public function edituser() {
    	if(JhaUtility::userCanAdministrate() || JhaRequest::getVar('id') == $_SESSION['USER']->id){
	    	$view = &$this->getView();
			$view->setLayout('user.admin.form');
			$view->edituser();
    	}
    	else
    		$this->redirect();
    }
    
    public function saveuser() {
    	if(JhaUtility::userCanAdministrate() || JhaRequest::getVar('id') == $_SESSION['USER']->id){
	    	$model = &$this->getModel();
	    	if(intval(JhaRequest::getVar('id')) == 0) {
	    		JhaRequest::setVar('fecharegistro', date('Y-m-d H:i:s'));
	    	}
			$model->saveUser();
			$_SESSION['USER'] = $model->getUsuario(JhaRequest::getVar('id'));
			if(JhaRequest::getVar('id') == $_SESSION['USER']->id)
				$this->redirect('index.php?elem=mod_user&task=admin');
			else
				$this->redirect();
    	}
    	else
    		$this->redirect();
    }
    
	public function deleteuser() {
		if(JhaUtility::userCanAdministrate()){
			$model = &$this->getModel();
	        $ids = JhaRequest::getVar('id');
	        if(!is_array($ids)) return false;
	        foreach ($ids as $id) {
	        	$model->deleteUser($id);
	        }
			$this->redirect('index.php?elem=mod_user&task=admin');
    	}
    	else
    		$this->redirect();
	}
    
	public function isUniqueName() {
        $view = &$this->getView();
        echo $view->isUniqueName();
    }
}
?>