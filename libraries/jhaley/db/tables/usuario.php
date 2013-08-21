<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.db.table');

class JhaTableUsuario extends JhaTable {
	var $id = NULL;
	var $rol = NULL;
	var $nombre = NULL;
	var $usuario = NULL;
	var $contrasenia = NULL;
	var $estado = NULL;
	var $fecharegistro = NULL;
	var $fechaultimoacceso = NULL;
	
	public function __construct(){
		parent::__construct('#__usuario','id');
	}
}
?>