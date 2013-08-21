<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.db.table');

class JhaTableContenido extends JhaTable {
	var $id = NULL;
	var $usuario = NULL;
	var $seccion = NULL;
	var $titulo = NULL;
	var $contenido = NULL;
	var $orden = 0;
	var $estado = NULL;
	var $fechacreacion = NULL;
	var $fechapublicacion = NULL;
	
	public function __construct(){
		parent::__construct('#__contenido','id');
	}
}
?>