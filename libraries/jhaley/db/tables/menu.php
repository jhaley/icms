<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.db.table');

class JhaTableMenu extends JhaTable {
	var $id = NULL;
	var $usuario = NULL;
	var $titulo = NULL;
	var $descripcion = NULL;
	
	public function __construct(){
		parent::__construct('#__menu','id');
	}
}
?>