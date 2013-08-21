<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.base.object');

class JhaFile extends JhaObject {
	var $_pathfile;
	var $_content;
	
	public function __construct($pathfile = '', $content = ''){
		$this->_pathfile = $pathfile;
		$this->_content = $content;
	}
	
	public function setPathFile($pathfile){
		$this->_pathfile = $pathfile;
	}
	
	public function setContent($content){
		$this->_content = $content;
	}
	
	public function getContent(){
		return $this->_content;
	}
	
	public function write(){
		$fp = fopen($this->_pathfile, 'w+');
		fwrite($fp,$this->_content);
		fclose($fp);
	}
	
	public function read(){
		$fp = fopen($this->_pathfile, 'r');
		while(!feof($fp)) {
			$this->_content .= fgets($fp, 999999);
		}
		fclose($fp);
	}
}
?>