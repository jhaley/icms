<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.mvc.model');

class MenuModelMenu extends JhaModel {
    public function __construct() {
        parent::__construct();
    }
    
    public function getMenus(){
    	$db = &JhaFactory::getDBO();
        $db->setQuery('SELECT m.id, m.titulo, m.descripcion, u.nombre as creador FROM #__menu as m, #__usuario as u WHERE m.usuario = u.id ORDER BY m.id');
        return $db->loadObjectList();
    }
    
	public function getMenu($id){
    	$db = &JhaFactory::getDBO();
        $db->setQuery('SELECT * FROM #__menu WHERE id = ' . $id);
        return $db->loadObject();
    }
    
	public function getMenuItem($id){
    	$db = &JhaFactory::getDBO();
        $db->setQuery('SELECT * FROM #__menuitem WHERE id = ' . $id);
        return $db->loadObject();
    }
    
    public function getMenuitems($idmenu){
    	$db = &JhaFactory::getDBO();
        $db->setQuery('SELECT * FROM #__menuitem WHERE menu = ' . $idmenu . ' ORDER BY orden');
        return $db->loadObjectList();
    }
    
    public function saveMenu(){
        $table = &$this->getTable('menu');
        if($table->bind(JhaRequest::get( 'post',JHAREQUEST_ALLOWRAW))) {
        	$table->id = ($table->id == '0' ? NULL : $table->id);
        	$table->usuario = $_SESSION['USER']->id;
            if(!$table->store())	return false;
            return $table->id;
        }
        return false;
    }
    
    public function setUndefaultMenuItem($menuitem){
    	$table = &$this->getTable('menuitem');
        if($table->bind($menuitem)) {
        	$table->home = '0';
            return $table->store();
        }
        return false;
    }
    
    public function updateMenuItem($menuitem, $pos){
        $table = &$this->getTable('menuitem');
        if($table->load($menuitem->id)) {
            $table->orden = $pos;
            return $table->store();
        }
        return false;
    }
    
	public function saveMenuItem(){
        $table = &$this->getTable('menuitem');
        if($table->bind(JhaRequest::get( 'post',JHAREQUEST_ALLOWRAW))) {
        	$table->id = ($table->id == '0' ? NULL : $table->id);
        	$table->menu = JhaRequest::getVar('showing');
            if(!$table->store())	return false;
            return $table->id;
        }
        return false;
    }
    
    public function deleteMenu($id){
    	$table = &$this->getTable('menu');
        if($table->load($id)) {
            if(!$table->delete())	return false;
            return true;
        }
        return false;
    }
    
	public function deleteMenuItem($id){
    	$table = &$this->getTable('menuitem');
        if($table->load($id)) {
            if(!$table->delete())	return false;
            return true;
        }
        return false;
    }
    
    public function getArticles(){
    	$db = &JhaFactory::getDBO();
        $db->setQuery('SELECT id, titulo as nombre, concat(\'index.php?elem=mod_content&id=\', id) as link FROM #__contenido');
        return $db->loadObjectList();
    }
    
	public function getSections(){
    	$db = &JhaFactory::getDBO();
        $db->setQuery('SELECT id, nombre, concat(\'index.php?elem=mod_content&controller=section&sid=\', id) as link FROM #__seccion');
        return $db->loadObjectList();
    }
    
    public function getSection($id){
    	$db = &JhaFactory::getDBO();
        $db->setQuery('SELECT * FROM #__seccion WHERE id = ' . $id);
        return $db->loadObject();
    }
    
	public function getArticle($id, $home = false){
    	$db = &JhaFactory::getDBO();
    	if(!$home)
        	$db->setQuery('SELECT * FROM #__contenido WHERE id = ' . $id);
       	else 
       		$db->setQuery('SELECT * FROM #__contenido WHERE home = 1');
        return $db->loadObject();
    }
}
?>