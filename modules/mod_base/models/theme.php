<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.mvc.model');

class BaseModelTheme extends JhaModel {
    public function __construct() {
        parent::__construct();
    }
    
    public function getThemes(){
    	$db = &JhaFactory::getDBO();
        $db->setQuery('SELECT * FROM #__plantilla ORDER BY nombre');
        return $db->loadObjectList();
    }
    
    public function setDefault($id){
        $table = &$this->getTable('plantilla');
        if($table->load($id)) {
            $table->predeterminado = 1;
            return $table->store();
        }
        return false;
    }
    
    public function removeDefault($theme){
    	$table = &$this->getTable('plantilla');
        if($table->load($theme->id)) {
            $table->predeterminado = 0;
            return $table->store();
        }
        return false;
    }
    
    public function saveTheme(){
    	$table = &$this->getTable('plantilla');
        if($table->bind(JhaRequest::get( 'post',JHAREQUEST_ALLOWRAW))) {
            $table->predeterminado = 0;
            if(!$table->store())	return false;
            return $table->id;
        }
        return false;
    }
    
    public function getDefaultTheme(){
    	$db = &JhaFactory::getDBO();
        $db->setQuery('SELECT * FROM #__plantilla WHERE predeterminado = 1');
        return $db->loadObject();
    }
    
    public function storeTheme(){
        $obj = $this->getDefaultTheme();
    	$table = &$this->getTable('plantilla');
        if($table->bind($obj)) {
            $table->xml = $_SESSION['themeXML'];
            $table->html = $_SESSION['themeHTML'];
            return $table->store();
        }
        return false;
    }
    
    public function updateTheme($query){
    	$db = &JhaFactory::getDBO();
        return $db->executeQuery($query);
    }
}
?>