<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.web.tags');
class InputTag extends Tag {
	protected $type;
	protected $validate;
	protected $decimal;
	protected $parteentera;
	protected $capaparafecha;
	const NUMERICA = 1;
	const ALFABETICA = 2;
	const ALFANUMERICA = 3;
	const DECIMAL = 4;
	const FECHA = 8;
	const NOVALIDACION = 0;
	const TEXTFIELD = 256;
	const TEXTAREA = 512;
	const PASSWORD = 1024;
	const HIDDEN = 2048;
	
	function __construct($type = self::TEXTFIELD, $validate = self::NOVALIDACION, $capaparafecha = "") {
		parent::__construct ( "input" );
		$this->type ( $type );
		$this->decimal = -1;
		$this->parteentera = -1;
		$this->capaParaFecha ( $capaparafecha );
		$this->validate ( $validate );
	}
	
	function type($type = null) {
		if ($type != null && $type != $this->type) {
			$this->type = $type;
			switch ( $type) {
				case self::TEXTAREA :
					$this->taghtml = "textarea";
				break;
				case self::PASSWORD :
					$this->setAttribute ( "type", "password" );
				break;
				case self::HIDDEN :
					$this->setAttribute ( "type", "hidden" );
				break;
				default :
					$this->setAttribute ( "type", "text" );
				break;
			}
		}
		return $this->type;
	}
	
	public function validate($validate = "") {
		if ($validate != "" && $this->validate != $validate) {
			if ($validate == self::FECHA) {
				$this->resetEvent ( "onkeyup", $validate );
				$this->resetEvent ( "onkeydown", $validate );
				$this->resetEvent ( "onclick", $validate );
				$this->resetEvent ( "oncontextmenu", $validate );
			} else {
				$this->resetEvent ( "onkeyup", $validate );
				$this->resetEvent ( "onkeydown", $validate );
				$this->resetEvent ( "onclick", $validate );
				$this->resetEvent ( "oncontextmenu", $validate );
			}
		}
		return $this->validate;
	}
	
	private function resetEvent($event, $validate) {
		$eventotexto = $this->getAttribute ( $event );
		$nuevavalidacion = str_replace ( $this->getTextoValidacion ( $this->validate, $event ), "", $eventotexto );
		$this->validate = $validate;
		$this->setAttribute ( $event, $nuevavalidacion );
	}
	
	private function getTextoValidacion($validate, $event) {
		switch ( $validate) {
			case self::NUMERICA :
				switch ( $event) {
					case "onkeyup" :
						if ($this->parteentera != - 1) {
							return "this.value=validador.validarEnteros(this.value,$this->parteentera);";
						}
						return "this.value=validador.validarEnteros(this.value);";
					break;
					default:
						return "";
					break;
				}
			break;
			case self::ALFABETICA :
				switch ( $event) {
					case "onkeyup" :
						return "this.value=validador.validarAlfabetico(this.value);";
					break;
					default:
						return "";
					break;
				}
			break;
			case self::ALFANUMERICA :
				switch ( $event) {
					case "onkeyup" :
						return "this.value=validador.validarAlfaNumerico(this.value);";
					break;
					default:
						return "";
					break;
				}
			break;
			case self::DECIMAL :
				switch ( $event) {
					case "onkeyup" :
						if ($this->decimal != - 1 && $this->parteentera != - 1) {
							return "this.value=validador.validarDecimal(this.value,$this->parteentera,$this->decimal);";
						}
						if ($this->parteentera != - 1) {
							return "this.value=validador.validarDecimal(this.value,$this->parteentera);";
						}
						if ($this->decimal != - 1) {
							return "this.value=validador.validarDecimal(this.value,null,$this->decimal);";
						}
						return "this.value=validador.validarDecimal(this.value);";
					break;
					default:
						return "";
					break;
				}
			break;
			case self::FECHA :
				switch ( $event) {
					case "onclick" :
						return "generarCalendario(\"$this->capaparafecha\",this.id, event);";
					break;
					case "oncontextmenu" :
						return "return false;";
					break;
					case "onkeydown" :
						return "return false;";
					break;
					default:
						return "";
					break;
				}
			break;
			default :
				return "";
			break;
		}
		return "";
	}
	
	public function setAttribute($attr, $valor) {
		$attr = strtolower ( $attr );
		if ($attr == "onkeyup") {
			parent::setAttribute ( $attr, $this->getTextoValidacion ( $this->validate, $attr ) . $valor );
		} else {
			if ($attr == "onkeydown") {
				parent::setAttribute ( $attr, $this->getTextoValidacion ( $this->validate, $attr ) . $valor );
			} else {
				if ($attr == "onclick") {
					parent::setAttribute ( $attr, $this->getTextoValidacion ( $this->validate, $attr ) . $valor );
				} else {
					if ($attr == "oncontextmenu") {
						parent::setAttribute ( $attr, $this->getTextoValidacion ( $this->validate, $attr ) . $valor );
					} else {
						parent::setAttribute ( $attr, $valor );
					}
				}
			}
		}
		if ($attr == "type") {
			$valor = strtolower ( $valor );
			switch ( $valor) {
				case "textarea" :
					$this->type = self::TEXTAREA;
				break;
				case "password" :
					$this->type = self::PASSWORD;
				break;
				case "hidden" :
					$this->type = self::HIDDEN;
				break;
				default :
					$this->type = self::TEXTFIELD;
				break;
			}
			parent::setAttribute ( $attr, $valor );
		}
	}
    
	public function decimal($decimal = "") {
		if ($decimal != "") {
			$this->decimal = $decimal;
		}
		return $this->decimal;
	}
    
	public function parteEntera($parteEntera = "") {
		if ($parteEntera != "") {
			$this->parteentera = $parteEntera;
		}
		return $this->parteentera;
	}
	
	public function capaParaFecha($capaparafecha = "") {
		if ($capaparafecha != "") {
			$this->capaparafecha = $capaparafecha;
		}
		return $this->capaParaFecha;
	}
}
?>