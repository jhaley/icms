<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.web.tags');

class PhpTag extends Tag {
	const PUBLICO = 0;
	const PRIVADO = 1;
	const PROTEGIDO = 2;
	const ABSTRACTO = 4;
	const ESTATICO = 8;
	const NINGUNO = 16;
	protected $tags;
	private $tabs;
    
	public function setParent($parent) {
		parent::setParent ( $parent );
		if ($this->parent != null) {
			if (($this->parent instanceof PhpTag) || ! ($this->parent instanceof Tag)) {
				$this->tabs = $this->parent->tabs () + 1;
			}
		}
	}
    
	public function __construct($content = "", $tags = true, $tabs = 0) {
		$this->content = array ();
		$this->addTabbed ( $content, $tabs );
		$this->tags = $tags;
		$this->tabs ( $tabs );
	}
	
	public function tabs($tabs = null) {
		if ($tabs != null && $this->tabs != $tabs) {
			$this->tabs = intval ( $tabs );
		}
		return intval ( $this->tabs );
	}
	
	public function tags($tags = null) {
		if ($tags != null && $this->tags != $tags) {
			$this->tags = $tags;
		}
		return $this->tags;
	}
	
	public function addLine($content = "") {
		$this->add ( $content );
		$this->add ( "\n" );
	}
	
	public function addTabbed($content = "", $tabs = null) {
		if ($tabs == null) {
			$tabs = $this->tabs;
		}
		if (! ($content instanceof PhpTag)) {
			$this->add ( $this->owntabs ( $tabs ) );
		}
		$this->add ( $content );
	}
	
	public function addTabbedLine($content = "", $tabs = null) {
		$this->addTabbed ( $content, $tabs );
		$this->add ( "\n" );
	}
	
	protected function owntabs($tabs = 1) {
		$tabu = "";
		for($i = 0; $i < intval ( $tabs ); $i ++) {
			$tabu .= "\t";
		}
		return $tabu;
	}
	
	public function addFunction($nombre, $attributes = "", $content = ";", $acceso = self::PUBLICO, $adicional = self::NINGUNO, $anonimo = false) {
		switch ($acceso) {
			case self::PRIVADO :
				$this->addTabbed ( "private " );
				break;
			case self::PROTEGIDO :
				$this->addTabbed ( "protected " );
				break;
			case self::PUBLICO :
				$this->addTabbed ( "public " );
				break;
			default :
				if (! $anonimo) {
					$this->addTabbed ();
				}
				break;
		}
		
		switch ($adicional) {
			case self::ABSTRACTO :
				$this->add ( "abstract " );
				break;
			case self::ESTATICO :
				$this->add ( "static " );
				break;
		}
		if (! $anonimo) {
			$this->addLine ( "function $nombre($attributes)" );
		} else {
			if($nombre!=""){
				$this->add($nombre."=");
			}
			$this->addLine ( "function($attributes)" );
		}
		$this->addTabbedLine ( "{" );
		if (($content instanceof PhpTag)) {
			$this->addTabbed ( $content, $this->tabs + 1 );
		} else {
			$this->addTabbedLine ( $content, $this->tabs + 1 );
		}
		$this->addTabbedLine ( "}" );
	}
	
	public function addClass($nombre, $content = ";", $extiende = "", $implementa = "", $adicional = self::NINGUNO) {
		if ($extiende != "") {
			$extiende = "extends $extiende";
		}
		if ($implementa != "") {
			$implementa = "implements $implementa";
		}
		switch ($adicional) {
			case self::ABSTRACTO :
				$this->addTabbedLine ( "abstract class $nombre $extiende $implementa", $this->tabs );
				break;
			default :
				$this->addTabbedLine ( "class $nombre $extiende $implementa", $this->tabs );
				break;
		}
		
		$this->addTabbedLine ( "{", $this->tabs );
		if (($content instanceof PhpTag)) {
			$this->addTabbed ( $content, $this->tabs + 1 );
		} else {
			$this->addTabbedLine ( $content, $this->tabs + 1 );
		}
		$this->addTabbedLine ( "}", $this->tabs );
	}
	
	public function addIf($condicion = "true", $content = ";") {
		$this->addTabbedLine ( "if($condicion)", $this->tabs );
		$this->addTabbedLine ( "{", $this->tabs );
		if (($content instanceof PhpTag)) {
			$this->addTabbed ( $content, $this->tabs + 1 );
		} else {
			$this->addTabbedLine ( $content, $this->tabs + 1 );
		}
		$this->addTabbedLine ( "}", $this->tabs );
	}
	
	public function addIfElse($condicion = "true", $contenidoif = ";", $contenidoelse = ";") {
		$this->addIf ( $condicion, $contenidoif, $this->tabs );
		$this->addTabbedLine ( "else", $this->tabs );
		$this->addTabbedLine ( "{", $this->tabs );
		if (($contenidoelse instanceof PhpTag)) {
			$this->addTabbed ( $contenidoelse, $this->tabs + 1 );
		} else {
			$this->addTabbedLine ( $contenidoelse, $this->tabs + 1 );
		}
		$this->addTabbedLine ( "}", $this->tabs );
	}
	
	public function addTryCatch($contenidotry = ";", $contenidocatch = ";") {
		$this->addTabbedLine ( "try", $this->tabs );
		$this->addTabbedLine ( "{", $this->tabs );
		if (($contenidotry instanceof PhpTag)) {
			$this->addTabbed ( $contenidotry, $this->tabs + 1 );
		} else {
			$this->addTabbedLine ( $contenidotry, $this->tabs + 1 );
		}
		$this->addTabbedLine ( "}catch(Exception \$exception)", $this->tabs );
		$this->addTabbedLine ( "{", $this->tabs );
		if (($contenidocatch instanceof PhpTag)) {
			$this->addTabbed ( $contenidocatch, $this->tabs + 1 );
		} else {
			$this->addTabbedLine ( $contenidocatch, $this->tabs + 1 );
		}
		$this->addTabbedLine ( "}", $this->tabs );
	}
	
	public function addForEach($sentencia = "\$arreglo as \$index=>\$element", $content = ";") {
		$this->addTabbedLine ( "foreach($sentencia)", $this->tabs );
		$this->addTabbedLine ( "{", $this->tabs );
		if (($content instanceof PhpTag)) {
			$this->addTabbed ( $content, $this->tabs + 1 );
		} else {
			$this->addTabbedLine ( $content, $this->tabs + 1 );
		}
		$this->addTabbedLine ( "}", $this->tabs );
	}
	
	public function addSwitch($variable = "\$var", $content = ";") {
		$this->addTabbedLine ( "switch ($variable)", $this->tabs );
		$this->addTabbedLine ( "{", $this->tabs );
		if (($content instanceof PhpTag)) {
			$this->addTabbed ( $content, $this->tabs + 1 );
		} else {
			$this->addTabbedLine ( $content, $this->tabs + 1 );
		}
		$this->addTabbedLine ( "}", $this->tabs );
	}
	public function addCase($valor = "0", $content = ";") {
		$this->addTabbedLine ( "case $valor:", $this->tabs );
		if (($content instanceof PhpTag)) {
			$this->addTabbed ( $content, $this->tabs + 1 );
		} else {
			$this->addTabbedLine ( $content, $this->tabs + 1 );
		}
		$this->addTabbedLine ( "break;", $this->tabs );
	}
	public function addDefault($content = ";") {
		$this->addTabbedLine ( "default:", $this->tabs );
		if (($content instanceof PhpTag)) {
			$this->addTabbed ( $content, $this->tabs + 1 );
		} else {
			$this->addTabbedLine ( $content, $this->tabs + 1 );
		}
		$this->addTabbedLine ( "break;", $this->tabs );
	}
	
	public function remove($posicion = -1) {
		if ($posicion < $this->size ()) {
			$element = $this->content [$posicion];
			$nuevoarreglo = array ();
			foreach ( $this->content as $index => $nuevoelemento ) {
				if ($index != $posicion) {
					array_push ( $nuevoarreglo, $nuevoelemento );
				}
			}
			$this->content = $nuevoarreglo;
			return $element;
		}
		return null;
	}
	
	public function get($posicion = -1) {
		if ($posicion < $this->size ()) {
			return $this->content [$posicion];
		}
		return null;
	}
	
	public function set($posicion = -1, $content = "") {
		if ($posicion < $this->size () && $content != "") {
			$this->content [$posicion] = $content;
		}
	}
	
	public function size() {
		return count ( $this->content );
	}
	
	public function html() {
		return $this->addTag ( $this->innerHTML () );
	}
	
	public function innerHTML() {
		$retorno = "";
		foreach ( $this->content as $element ) {
			$retorno .= $this->processElement ( $element );
		}
		return $retorno;
	}
    
	protected function processElement($element) {
		if (($element instanceof Tag) && ! ($element instanceof PhpTag)) {
			return $this->addForHTML ( $element );
		} else {
			return $element;
		}
	}
	
	protected function addTag($content = "") {
		if ($this->tags) {
			if ((($this->parent instanceof Tag) && ! ($this->parent instanceof PhpTag)) || $this->parent == null) {
				return "<?php $content?>";
			} elseif (($this->parent instanceof Tag) && is_subclass_of ( $this->parent, "PhpTag" )) {
				return "<?php $content?>";
			}
		}
		return $content;
	}
	
	protected function addForHTML($content = "") {
		return "?>$content<?php ";
	}
}

?>