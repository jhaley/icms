<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.db.table');

class JhaTableNoticia extends JhaTable {
	var $id = NULL;
	var $usuario = NULL;
	var $contenido = NULL;
	var $fechacreacion = NULL;
	
	public function __construct(){
		parent::__construct('#__noticia','id');
	}
}
?>