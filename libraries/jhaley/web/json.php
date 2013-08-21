<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.web.jstag');

class JSON {
	private $items;
	private $values;
	private $tabs;
	private $type;
	private $tag;
	private $parent;
	
	const LLAVES = 0;
	const CORCHETES = 1;
    
	public function __construct($tag = null, $type = self::LLAVES) {
		$this->items = array ();
		$this->values = array ();
		$this->tag = $tag;
		$this->type = $type;
		if ($tag instanceof JSTag) {
			$this->tabs = $tag->tabs ();
		} else {
			$this->tabs = 0;
		}
		$this->parent = null;
	}
	
	public function setParent($parent = null) {
		if ($parent != $this->parent) {
			$this->parent = $parent;
		}
		return $this->parent;
	}
	
	public function tabs($tabs = null) {
		if ($tabs != $this->tabs) {
			$this->tabs = $tabs;
		}
		return $this->tabs;
	}
	
	public function type($type = null) {
		if ($type != $this->type) {
			$this->type = $type;
		}
		return $this->type;
	}
	
	public function add($item, $value) {
		if (($value instanceof JSTag) || ($value instanceof JSON)) {
			$value->tabs ( $this->tabs + 1 );
		}
		if($value instanceof JSON){
			$value->setParent($this);
		}
		array_push ( $this->items, $item );
		array_push ( $this->values, $value );
	}
	
	public function render() {
		$filas = array ();
		foreach ( $this->items as $indice => $item ) {
			$lodelitem = "";
			if (trim ( $item ) != "") {
				$lodelitem = $item . ": ";
			}
			$fila = $this->renderTabs ( 1 );
			$fila .= $lodelitem . $this->values [$indice];
			array_push ( $filas, $fila );
		}
		$cadena = implode ( ",\n", $filas );
		$cadena = $this->entreLC ( $cadena );
		return $cadena;
	}
	
	protected function entreLC($content) {
		$cadena = "";
		if ($this->parent == null) {
			$cadena = $this->renderTabs ();
		}
		if ($this->type == self::LLAVES) {
			$cadena .= "{\n";
			$cadena .= $content;
			$cadena .= "\n" . $this->renderTabs () . "}";
		} else {
			$cadena .= "[\n";
			$cadena .= $content;
			$cadena .= "\n" . $this->renderTabs () . "]";
		}
		return $cadena;
	}
	
	private function renderTabs($tab = 0) {
		$tab = $this->tabs + $tab;
		$cadena = "";
		for($i = 0; $i < $tab; $i ++) {
			$cadena .= "\t";
		}
		return $cadena;
	}
	
	public function __toString() {
		return $this->render ();
	}

}
?>