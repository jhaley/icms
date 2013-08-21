<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.db.table');

class JhaTableBloque extends JhaTable {
	var $id = NULL;
	var $titulo = NULL;
	var $contenido = NULL;
	var $orden = 0;
	var $region = NULL;
	var $renderizador = NULL;
	var $needlogin = 0;
	var $params = NULL;
	
	public function __construct(){
		parent::__construct('#__bloque','id');
	}
}
?>