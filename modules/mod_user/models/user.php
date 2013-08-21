<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.mvc.model');

class UserModelUser extends JhaModel {
    public function __construct() {
        parent::__construct();
    }
    
    public function login() {
    	$db = &JhaFactory::getDBO();
    	$username = JhaRequest::getVar('username',NULL);
    	$passwd = JhaRequest::getVar('passwd', NULL);
    	if(!isset($username) || !isset($passwd)){
            return false;
        }
        $db->setQuery("SELECT u.id, r.nombre as rol, u.nombre, u.usuario, u.contrasenia, u.estado, u.fecharegistro, u.fechaultimoacceso FROM #__usuario as u, #__rol as r WHERE u.usuario = '" . $username . "' AND u.contrasenia = '" . $passwd . "' AND u.rol = r.id");
        return $db->loadObject();
    }
    
	public function getUsers() {
    	$db = &JhaFactory::getDBO();
        $db->setQuery("SELECT u.id, r.nombre as rol, u.nombre, u.usuario, u.contrasenia, u.estado, u.fecharegistro, u.fechaultimoacceso FROM #__usuario as u, #__rol as r WHERE u.rol = r.id");
        return $db->loadObjectList();
    }
    
	public function getRoles() {
    	$db = &JhaFactory::getDBO();
        $db->setQuery("SELECT * FROM #__rol");
        return $db->loadObjectList();
    }
    
	public function getUsuario($id) {
    	$db = &JhaFactory::getDBO();
        $db->setQuery("SELECT u.id, r.nombre as rol, u.nombre, u.usuario, u.contrasenia, u.estado, u.fecharegistro, u.fechaultimoacceso FROM #__usuario as u, #__rol as r WHERE u.rol = r.id AND u.id = " . $id);
        return $db->loadObject();
    }
    
    public function saveUser(){
    	$table = &$this->getTable('usuario');
    	$table->load(JhaRequest::getVar('id'));
        if($table->bind(JhaRequest::get( 'post',JHAREQUEST_ALLOWRAW))) {
        	$table->id = ($table->id == '0' ? NULL : $table->id);
            if(!$table->store())	return false;
            return $table->id;
        }
        return false;
    }
    
	public function deleteUser($id){
    	$table = &$this->getTable('usuario');
        if($table->load($id)) {
            if(!$table->delete())	return false;
            return true;
        }
        return false;
    }
}
?>