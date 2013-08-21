<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.db.table');

class JhaTableSeccion extends JhaTable {
	var $id = NULL;
	var $usuario = NULL;
	var $nombre = NULL;
	var $orden = 0;
	var $tipo = NULL;
	
	public function __construct(){
		parent::__construct('#__seccion','id');
	}
}
?>