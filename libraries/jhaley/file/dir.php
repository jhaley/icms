<?php 
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.base.object');

class JhaDirectory extends JhaObject {
	var $_pathfile;
	var $_files;
	
	public function __construct($pathfile = '.'){
		$this->_pathfile = $pathfile;
		$this->_files = array();
	}
	
	public function setPathFile($pathfile){
		$this->_pathfile = $pathfile;
	}
	
	public function read(){
        $this->_files = scandir($this->_pathfile);
	}
	
	public function getFolders(){
		$res = array();
		for ($i = 0; $i < count($this->_files); $i++) {
			if(is_dir($this->_pathfile.DS.$this->_files[$i]) && $this->_files[$i] != '.svn' && $this->_files[$i] != '.'){
				$res[] = $this->_files[$i];
			}
		}
		return $res;
	}
	
	public function getFiles($filetypes = array()){
		$res = array();
		for ($i = 0; $i < count($this->_files); $i++) {
			if($this->validateExtension($this->_files[$i],$filetypes)){
				$res[] = $this->_files[$i];
			}
		}
		return $res;
	}
	
	private function validateExtension($file, $filetypes){
		if(count($filetypes) <= 0)	return true;
		$parts = split('\.', $file);
		$isValide = false;
		foreach ($filetypes as $filetype) {
			if(count($parts) > 1){
				$isValide = $isValide || $parts[count($parts) - 1] == $filetype;
			}
		}
		return $isValide;
	}
}
?>