<?php 
defined( '_JHAEXEC' ) or die( 'Access Denied' );

class JhaLoginHelper {
	private $params;
	
	function __construct($params) {
		$this->params = $params;
	}
	
    public function getTask() {
    	if(isset($_SESSION['USER'])) {
    		return 'logout';
    	}
    	return 'login';
    }
    
    public function getUser(){
    	if(isset($_SESSION['USER'])){
    		return $_SESSION['USER'];
    	}
    	return NULL;
    }
}
?>