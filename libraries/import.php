<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );

function jhaimport($url){
    $parts = split("\.",$url);
    $parts[count($parts) - 1] = $parts[count($parts) - 1] . '.php';
    require_once JHA_LIBRARIES_PATH . DS . implode(DS,$parts); 
}

?>