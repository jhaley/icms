<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.mvc.view');

class UserViewUser extends JhaView {
    public function display(){
    	$this->admin();
    }
    
    public function admin(){
    	$model = &$this->getModel();
    	$usuarios = $model->getUsers();
    	$controls = $this->createControls();
    	$this->assignRef('usuarios', $usuarios);
    	$this->assignRef('controls', $controls);
        parent::display();
    }
    
	private function createControls(){
    	$task = JhaRequest::getVar('task');
        if($task == 'newuser' || $task == 'edituser'){
            return JhaHTML::renderControls(array('Guardar', 'Cancelar'), array('saveuser', 'admin'), array('save', 'cancel'), null);
        }
        return JhaHTML::renderControls(array('Nuevo', 'Editar', 'Eliminar'), array('newuser', 'edituser', 'deleteuser'), array('new', 'edit', 'delete'), null);
    }
    
    public function newuser(){
    	$model = &$this->getModel();
    	$controls = $this->createControls();
    	$roles = $model->getRoles();
    	
    	$this->assignRef('controls', $controls);
    	$this->assignRef('roles', $roles);
        parent::display();
    }
    
	public function edituser(){
    	$model = &$this->getModel();
    	$controls = $this->createControls();
    	$ids = JhaRequest::getVar('id');
    	if(!is_array($ids)) $ids = array($ids);
    	$roles = $model->getRoles();
    	$usuario = $model->getUsuario($ids[0]);
    	
    	$this->assignRef('controls', $controls);
    	$this->assignRef('usuario', $usuario);
    	$this->assignRef('roles', $roles);
        parent::display();
    }
    
	public function isUniqueName(){
        $model = &$this->getModel();
    	$nombre = JhaRequest::getVar('nombre');
        if($nombre == '')  return 'Ingrese el nombre de usuario';
        $existName = false;
        $users = $model->getUsers();
        foreach ($users as $user) {
        	if($nombre == $user->usuario) {
        		$existName = true;
        		break;
        	}
        }
        return (!$existName ? '' : '<span style="color: #FF0000;">Nombre de usuario ingresado ya existe, ingrese otro.</span>');
    }
}
?>