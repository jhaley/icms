<?php 
defined( '_JHAEXEC' ) or die( 'Access Denied' );

class JhaNewHelper {
	private $params;
	
	function __construct($params) {
		$this->params = $params;
	}
	
    public function getNews() {
    	$db = &JhaFactory::getDBO();
        $query = "SELECT * FROM #__noticia ORDER BY fechacreacion DESC";
        $db->setQuery($query);
        return $db->loadObjectList();
    }
    
    public function getNoticias(){
    	$noticias = $this->getNews();
    	$config = &JhaFactory::getConfig();
    	$res = array();
    	for ($i = 0; $i < count($noticias); $i++) {    	
    		$date = split(' ', $noticias[$i]->fechacreacion);
    		$fecha = split('-', $date[0]);
    		$hora = split(':', $date[1]);
    		$dateini = mktime($hora[0], $hora[1], $hora[2], $fecha[1], $fecha[2], $fecha[0]);
    		$datenow = mktime();
    		$datefin = mktime($hora[0], $hora[1], $hora[2], $fecha[1], $fecha[2] + intval($config->days_showing_news), $fecha[0]);
    		if($datenow >= $dateini && $datenow <= $datefin){
    			$res[] = $noticias[$i];
    		}
    	}
    	return $res; 
    }
}
?>