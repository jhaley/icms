<?php 
defined( '_JHAEXEC' ) or die( 'Access Denied' );

class JhaBreadcrumbHelper {
	private $params;
	
	function __construct($params) {
		$this->params = $params;
	}
	
    public function getLinks() {
    	if(JhaUtility::userCanEdit())	return array();
        if(JhaRequest::getVar('itemid', NULL) != NULL && $_SESSION["itemid"] != JhaRequest::getVar('itemid')){
        	$_SESSION["itemid"] = JhaRequest::getVar('itemid');
        	$_SESSION['breadcrumb'] = array();
        	$this->addLink();
        	return $_SESSION['breadcrumb'];
        }
        $_SESSION["breadcrumb"] = isset($_SESSION["breadcrumb"]) ? $_SESSION["breadcrumb"] : array();
    	$this->verifyLinks();
    	return $_SESSION["breadcrumb"];
    }
    
    private function addLink(){
    	$obj = new stdClass();
       	$obj->nombre = $this->getName();
       	$obj->link = 'index.php?' . $_SERVER['QUERY_STRING'];
       	$_SESSION["breadcrumb"][] = $obj;
    }
    
    private function getName(){
    	$db = &JhaFactory::getDBO();
    	$query = '';
    	if(JhaRequest::getVar('elem') == 'mod_content' && JhaRequest::getVar('controller') == 'section'){
    		$query = "SELECT nombre FROM #__seccion WHERE id = '" . JhaRequest::getVar('sid') . "'";
    	}
    	elseif (JhaRequest::getVar('elem') == 'mod_content'){
    		$query = "SELECT titulo as nombre FROM #__contenido WHERE id = '" . JhaRequest::getVar('id') . "'";
    	}
    	else {
    		$query = "SELECT titulo as nombre FROM #__contenido WHERE home = 1";
    		$this->stablishItemId();
    	}
    	if($query == '') return '';
    	$db->setQuery($query);
    	$obj = $db->loadObject();
    	return $obj->nombre;
    }
    
    private function stablishItemId(){
    	$db = &JhaFactory::getDBO();
    	$query = "SELECT id FROM #__menuitem WHERE home = 1";
    	$db->setQuery($query);
    	$obj = $db->loadObject();
    	$_SESSION["itemid"] = $obj->id;
    }
    
    private function verifyLinks(){
    	// verificar si existe $qs dentro de $_SESSION["breadcrumb"], si existe eliminar todos los ultimos excepto $qs, sino existe agregar $qs al final de $_SESSION["breadcrumb"].
    	$newlist = array();
    	$links = $_SESSION["breadcrumb"];
    	for ($i = 0; $i < count($links); $i++) {
    		$elems = $this->prepareLink(substr($links[$i]->link, strlen('index.php?')));
    		$isEqual = true;
    		foreach ($elems as $index => $value) {
    			$isEqual = $isEqual && $value == JhaRequest::getVar($index);
    		}
    		$newlist[] = $links[$i];
    		if($isEqual)	break;
    	}
    	$_SESSION["breadcrumb"] = $newlist;
    	if(!$isEqual)	$this->addLink(); 
    }
    
    private function prepareLink($qs){
    	$parts = split('&', $qs);
    	$elems = array();
    	foreach ($parts as $part) {
    		$elem = split("=", $part);
    		if($elem[0] == 'elem' || $elem[0] == 'controller' || $elem[0] == 'id' || $elem[0] == 'sid') {
    			$elems[$elem[0]] = $elem[1];
    		}
    	}
    	return $elems;
    }
}
?>