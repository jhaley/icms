<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.db.table');

class JhaTableMenuItem extends JhaTable {
	var $id = NULL;
	var $menu = NULL;
	var $nombre = NULL;
	var $enlace = NULL;
	var $icono = NULL;
	var $orden = 0;
	var $home = NULL;
	
	public function __construct(){
		parent::__construct('#__menuitem','id');
	}
}
?>