<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.web.tags');

class HtmlTag extends Tag {
	protected $head;
	protected $body;
    
	public function __construct() {
		parent::__construct ("html",$this->head=new Tag("head"));
		$this->add($this->body=new Tag("body"));
	}
    
	public function head(){
		return $this->head;
	}
    
	public function body(){
		return $this->body;
	}
}
?>