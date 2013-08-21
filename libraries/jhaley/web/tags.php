<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );

class Tag {
	protected $taghtml;
	protected $content;
	protected $attributes;
	protected $parent;
    
	public function getContents(){
		return $this->content;
	}
	
	public function getAttributes(){
		return $this->attributes;
	}
	
	public function setParent($parent) {
		$this->parent = $parent;
	}
    
	public function getParent() {
		return $this->parent;
	}

	public function setTag($tag) {
		$this->taghtml = $tag;
	}
	
	public function getTag() {
		return $this->taghtml;
	}
    
	public function __construct($tag = "p", $content = "") {
		$this->taghtml = $tag;
		$this->content = array ( );
		$this->add ( $content );
		$this->attributes = array ( );
	}
	
    public function add($elem) {
		if (is_string ( $elem )) {
			if ($elem != "") {
				array_push ( $this->content, $elem );
				return true;
			}
		}
		elseif ( $elem instanceof Tag) {
			if ($elem != null) {
				if ($elem->getParent () == null) {
					array_push ( $this->content, $elem );
					$elem->setParent ( $this );
				} else {
					throw new Exception ( "Un Tag no puede tener mas de un padre" );
				}
				return true;
			}
		}
		return false;
	}
    
	public function remove($elem) {
		$akey = array_search ( $elem, $this->content, true );
		if ($akey !== false) {
			$newcontenido = array ( );
			foreach ( $this->content as $index => $element ) {
				if ($index != $akey) {
					array_push ( $newcontenido, $element );
				}
			}
			$this->content = $newcontenido;
		}
	}

	public function removeAll() {
		$this->content = array();
	}
	
	public function html() {
		if($this->taghtml=="html") {
			return $this->docType().$this->intag ( $this->innerHTML () );
		}
		else {
			return $this->intag ( $this->innerHTML () );
		}
	}
	
	public function innerHTML() {
		$retorno = "";
		foreach ( $this->content as $element ) {
			if (is_string ( $element )) {
				$retorno .= $element;
			}
			if ( $element instanceof Tag ) {
				$retorno .= $element->html ();
			}
		}
		return $retorno;
	}
    
	protected function intag($content) {
		$attributes = $this->attributos ();
		if($content != ""){
			return "<$this->taghtml$attributes>$content</$this->taghtml>\n";
		}
		else {
			return "<$this->taghtml$attributes/>\n";
		}
		
	}
    
	public function setAttribute($attr, $valor) {
		if ($attr != "") {
			$attr = strtolower ( $attr );
			$this->attributes [$attr] = $valor;
		}
	}
    
	public function getAttribute($attr) {
		return $this->attributes [$attr];
	}
    
	protected function attributos() {
		$retorno = "";
		if ($this->attributes != null) {
			foreach ( $this->attributes as $index => $atributo ) {
				$retorno .= ' '.$index.'="'.$atributo.'"';
			}
		}
		return $retorno;
	}
    
	public function get($posicion) {
		if ($posicion < count ( $this->content )) {
			return $this->content [$posicion];
		}
		return null;
	}
    
	public function set($posicion, $valor) {
		if ($posicion < count ( $this->content )) {
			$this->content [$posicion] = $valor;
		}
	}
	
	public function addPosition($elem, $pos) {
		$this->content = JhaUtility::insert($elem, $pos, $this->content);
	}
	
	public function __toString() {
		return $this->html ();
	}
	
	public function removeAttribute($attr, $all = false){
		if($all){
			$this->attributes = array();
			return;
		}
		$aux = array();
		foreach ($this->attributes as $index => $value) {
			if($attr != $index){
				$aux[$index] = $value;
			}
		}
		$this->attributes = $aux;
	}
    
	private function docType(){
		return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
	}
}

?>