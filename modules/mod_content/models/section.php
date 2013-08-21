<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.mvc.model');

class ContentModelSection extends JhaModel {
    public function __construct() {
        parent::__construct();
    }
    
    public function getArticulos() {
    	$sid = JhaRequest::getVar('sid',NULL);
    	if(!isset($sid)){
    		throw new Exception("No se encontro la seccion solicitada.");
        }
        return $this->getArticles($sid);
    }
    
    public function getArticles($sid){
    	$db = &JhaFactory::getDBO();
        $db->setQuery('SELECT * FROM #__contenido WHERE seccion = ' . $sid . ' ORDER BY orden DESC');
        return $db->loadObjectList();
    }
    
    public function getSeccion() {
        $sid = JhaRequest::getVar('sid',NULL);
        if(!isset($sid)){
            throw new Exception("No se encontro la seccion solicitada.");
        }
        return $this->getSection($sid);
    }
    
	public function getSection($id) {
        $db = &JhaFactory::getDBO();
        $db->setQuery('SELECT * FROM #__seccion WHERE id = ' . $id);
        return $db->loadObject();
    }
    
	public function getSecciones() {
        $db = &JhaFactory::getDBO();
        $db->setQuery('SELECT s.id, s.nombre, s.orden, s.tipo, u.nombre as creador FROM #__seccion as s, #__usuario as u WHERE s.usuario = u.id ORDER BY orden ASC');
        return $db->loadObjectList();
    }
    
    public function save(){
    	$table = &$this->getTable('contenido');
        if($table->load(JhaRequest::getVar('id'))) {
        	$table->bind(JhaRequest::get('post',JHAREQUEST_ALLOWRAW));
    	    return $table->store();
        }
        return false;
    }
    
    public function updateArticle($art, $pos){
        $table = &$this->getTable('contenido');
        if($table->load($art->id)) {
            $table->orden = $pos;
            return $table->store();
        }
        return false;
    }
    
	public function deleteSection($id){
    	$table = &$this->getTable('seccion');
        if($table->load($id)) {
            if(!$table->delete())	return false;
            return true;
        }
        return false;
    }
    
	public function saveSection(){
    	$table = &$this->getTable('seccion');
    	$table->load(JhaRequest::getVar('id'));
    	if($table->bind(JhaRequest::get( 'post',JHAREQUEST_ALLOWRAW))) {
        	$table->id = ($table->id == '0' ? NULL : $table->id);
        	$table->usuario = $_SESSION['USER']->id;
            if(!$table->store())	return false;
            return $table->id;
        }
        return false;
    }
}
?>