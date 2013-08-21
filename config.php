<?php

defined( '_JHAEXEC' ) or die( 'Access Denied' );

/**
 * Archivo de configuracion Base
 */

class JhaConfiguration {
	var $db_host = "localhost";
	var $db_database = "icms";
	var $db_user = "root";
	var $db_pass = "";
	var $db_preffix = "jha_";
	var $days_showing_news = "30";
	var $site = "/icms/";
	var $tmp_path = "C:\\wamp\\www\\icms\\tmp\\";
	var $meta_desc = "iCMS es un CMS creado para ser flexible y dinamico a la hora de gestionar los contenidos.";
	var $meta_keys = "iCMS CMS Flexible Dinamico Gestion Contenidos";
}
?>