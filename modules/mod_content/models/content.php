<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.mvc.model');

class ContentModelContent extends JhaModel {
    public function __construct() {
        parent::__construct();
    }
    
    public function getArticulo() {
    	return $this->getArticle(JhaRequest::getVar('id','0'));
    }
    
	public function getArticle($id) {
    	$db = &JhaFactory::getDBO();
        $db->setQuery('SELECT * FROM #__contenido WHERE id = ' . $id);
        return $db->loadObject();
    }
    
    public function save(){
    	$table = &$this->getTable('contenido');
        if($table->load(JhaRequest::getVar('id'))) {
        	$table->bind(JhaRequest::get('post',JHAREQUEST_ALLOWRAW));
    	    return $table->store();
        }
        return false;
    }
    
	public function saveArticle(){
    	$table = &$this->getTable('contenido');
    	$table->load(JhaRequest::getVar('id'));
    	if($table->bind(JhaRequest::get( 'post',JHAREQUEST_ALLOWRAW))) {
        	$table->id = ($table->id == '0' ? NULL : $table->id);
        	$table->usuario = $_SESSION['USER']->id;
            if(!$table->store())	return false;
            return $table->id;
        }
        return false;
    }
    
    public function deleteArticle($id){
    	$table = &$this->getTable('contenido');
        if($table->load($id)) {
            if(!$table->delete())	return false;
            return true;
        }
        return false;
    }
    
	public function getArticulosDetailed() {
    	$db = &JhaFactory::getDBO();
        $db->setQuery('SELECT c.id, c.titulo, c.orden, c.estado, c.fechacreacion, c.fechapublicacion, c.home, u.nombre as creador, s.nombre as seccion FROM #__contenido as c, #__usuario as u, #__seccion as s WHERE c.usuario = u.id AND c.seccion = s.id ORDER BY orden ASC');
        return $db->loadObjectList();
    }
    
    public function getSecciones(){
    	$db = &JhaFactory::getDBO();
        $db->setQuery('SELECT * FROM #__seccion ORDER BY nombre');
        return $db->loadObjectList();
    }

    public function getMenus(){
    	$db = &JhaFactory::getDBO();
        $db->setQuery('SELECT * FROM #__menu ORDER BY titulo');
        return $db->loadObjectList();
    }

    public function getMenuItems($id){
    	$db = &JhaFactory::getDBO();
        $db->setQuery('SELECT * FROM #__menuitem WHERE menu = ' . $id);
        return $db->loadObjectList();
    }
    
	public function deleteMenuItemLink($id){
    	$table = &$this->getTable('menuitem');
        if($table->load($id)) {
            if(!$table->delete())	return false;
            return true;
        }
        return false;
    }
    
	public function saveMenuItemLink($id = NULL){
        $table = &$this->getTable('menuitem');
        $table->load($id);
        if($table->bind(JhaRequest::get( 'post',JHAREQUEST_ALLOWRAW))) {
        	$table->id = $id;
            if(!$table->store())	return false;
            return $table->id;
        }
        return false;
    }
}
?>