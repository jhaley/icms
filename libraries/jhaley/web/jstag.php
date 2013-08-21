<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.web.phptag');

class JSTag extends PhpTag {
	
	public function __construct($content = "", $tags = true, $tabs = 0) {
		parent::__construct ( $content, $tags, $tabs );
	}
	
	public function html() {
		return $this->intag ( $this->innerHTML () );
	}
	
	protected function intag($content) {
		if ($this->tags ()) {
			if ((( $this->parent instanceof Tag ) && ! ( $this->parent instanceof JSTag )) || $this->parent == null) {
				$attributes = $this->attributos ();
				return "<script $attributes>$content</script>\n";
			}
		}
		return $content;
	}
    
	public function addFunction($nombre, $attributes="", $content=";",$anonimo=false) {
		return parent::addFunction($nombre,$attributes,$content,self::NINGUNO,self::NINGUNO,$anonimo);
	}
	
	public function addBranches($content=";"){
		$this->addTabbedLine("{");
		$this->addTabbedLine($content,$this->tabs()+1);
		$this->addTabbedLine("}");
	}
}

?>