<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.mvc.model');

class BaseModelBlock extends JhaModel {
    public function __construct() {
        parent::__construct();
    }
    
    public function getBlocks($region = ''){
    	$db = &JhaFactory::getDBO();
        $where = ($region == '' ? $region : "WHERE region = '" . $region . "'");
        $db->setQuery('SELECT * FROM #__bloque ' . $where . ' ORDER BY region, orden ASC');
        return $db->loadObjectList();
    }
    
    public function updateBlock($block, $pos){
        $table = &$this->getTable('bloque');
        if($table->load($block->id)) {
            $table->orden = $pos;
            $table->region = $block->region;
            return $table->store();
        }
        return false;
    }
    
    public function getThemeParameters(){
    	$db = &JhaFactory::getDBO();
        $db->setQuery('SELECT * FROM #__plantilla WHERE predeterminado = 1');
        $row = $db->loadObject();
        return JHA_THEMES_PATH.DS.($row ? $row->nombre : 'default');
    }
    
    public function getMenus(){
        $db = &JhaFactory::getDBO();
        $db->setQuery('SELECT * FROM #__menu');
        return $db->loadObjectList();
    }
    
    public function getMenuItems($menuid){
        $db = &JhaFactory::getDBO();
        $db->setQuery('SELECT * FROM #__menuitem WHERE menu=' . $menuid . ' ORDER BY orden ASC');
        return $db->loadObjectList();
    }
    
    public function getBlock($id){
        $db = &JhaFactory::getDBO();
        $db->setQuery('SELECT * FROM #__bloque WHERE id=' . $id);
        return $db->loadObject();
    }
    
    public function getMenuBlocks($id){
        $db = &JhaFactory::getDBO();
        $db->setQuery('SELECT idmenu FROM #__menubloque WHERE idbloque=' . $id);
        return $db->loadObjectList();
    }
    
	public function saveBlock($params, $orden = 0){
        $table = &$this->getTable('bloque');
        if($table->bind(JhaRequest::get( 'post',JHAREQUEST_ALLOWRAW))) {
        	$table->id = ($table->id == '0' ? NULL : $table->id);
        	$table->orden = $orden;
        	$table->params = $params;
            if(!$table->store())	return false;
            return $table->id;
        }
        return false;
    }
    
    public function deleteBlock($id){
    	$table = &$this->getTable('bloque');
        if($table->load($id)) {
            if(!$table->delete())	return false;
            return true;
        }
        return false;
    }
    
    public function saveMenuBlock($idbloque, $idmenu) {
    	$db = &JhaFactory::getDBO();
        return $db->insertGeneralObject('#__menubloque', array('idbloque' => $idbloque, 'idmenu' => $idmenu));
    }
    
    public function deleteMenuBlock($idbloque, $idmenu){
    	$db = &JhaFactory::getDBO();
        return $db->deleteGeneralObject('#__menubloque', array('idbloque' => $idbloque, 'idmenu' => $idmenu));
    }
}
?>