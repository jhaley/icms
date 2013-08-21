<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.web.tags');

class XmlTag extends Tag {
	protected $version;
	protected $encoding;
    
	public function __construct($tag = "content", $content = "", $version = "1.0", $encoding = "ISO-8859-1") {
		parent::__construct ( $tag, $content );
		$this->version = $version;
		$this->encoding = $encoding;
	}
	
	public function addCDATA($content){
		$this->add("<![CDATA[$content]]>");
	}
	
	public function xml() {
		return $this->header () . $this->html ();
	}

	public function xmlprint(){
		header("Content-type: text/xml");
		print $this->xml();
	}
	private function header() {
		return '<?xml version="' . $this->version . '" encoding="' . $this->encoding . '" ?>';
	}
	
	protected function intag($content) {
		$attributes = $this->attributos ();
		return "<$this->taghtml$attributes>$content</$this->taghtml>";
	}
}
?>