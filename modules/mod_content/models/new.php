<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.mvc.model');

class ContentModelNew extends JhaModel {
    public function __construct() {
        parent::__construct();
    }
    
    public function getNoticias(){
    	$db = &JhaFactory::getDBO();
        $db->setQuery('SELECT n.id, n.contenido, n.fechacreacion, u.nombre as creador FROM #__noticia as n, #__usuario as u WHERE n.usuario = u.id ORDER BY n.fechacreacion DESC');
        return $db->loadObjectList();
    }
    
	public function getNoticia($id){
    	$db = &JhaFactory::getDBO();
        $db->setQuery('SELECT * FROM #__noticia WHERE id = ' . $id);
        return $db->loadObject();
    }
    
    public function saveNoticia(){
    	$table = &$this->getTable('noticia');
    	$table->load(JhaRequest::getVar('id'));
    	if($table->bind(JhaRequest::get( 'post',JHAREQUEST_ALLOWRAW))) {
        	$table->id = ($table->id == '0' ? NULL : $table->id);
        	$table->usuario = $_SESSION['USER']->id;
            if(!$table->store())	return false;
            return $table->id;
        }
        return false;
    }
    
	public function deleteNoticia($id){
    	$table = &$this->getTable('noticia');
        if($table->load($id)) {
            if(!$table->delete())	return false;
            return true;
        }
        return false;
    }
}
?>