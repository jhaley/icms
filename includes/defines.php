<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );

$parts = explode( DS, JHA_BASE_PATH );

define( 'JHA_ROOT_PATH',			implode( DS, $parts ) );
define( 'JHA_SITE_PATH',			JHA_ROOT_PATH );
define( 'JHA_CONFIGURATION_PATH', 	JHA_ROOT_PATH );
define( 'JHA_LIBRARIES_PATH',	 	JHA_ROOT_PATH.DS.'libraries' );
define( 'JHA_IMAGES_PATH',          JHA_ROOT_PATH.DS.'images' );
define( 'JHA_THEMES_PATH',   	    JHA_BASE_PATH.DS.'themes' );
define( 'JHA_BLOCKS_PATH',          JHA_BASE_PATH.DS.'blocks' );
define( 'JHA_MODULES_PATH',         JHA_BASE_PATH.DS.'modules' );
?>