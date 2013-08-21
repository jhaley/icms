<?php 
defined( '_JHAEXEC' ) or die( 'Access Denied' );

class JhaBannerHelper {
	private $params;
	
	function __construct($params) {
		$this->params = $params;
	}
	
    public function getImages() {
    	//directorio $params['directory'].
    	jhaimport('jhaley.file.dir');
    	$dir = new JhaDirectory(addslashes(JHA_BASE_PATH.DS.$this->params['directory']));
    	$dir->read();
    	return $dir->getFiles(array('jpg','png'));
    }
}
?>