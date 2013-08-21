<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.db.table');

class JhaTablePlantilla extends JhaTable {
	var $id = NULL;
	var $nombre = NULL;
	var $predeterminado = 0;
	
	public function __construct(){
		parent::__construct('#__plantilla','id');
	}
}
?>