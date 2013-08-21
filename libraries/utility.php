<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );

class JhaUtility {
	function parseAttributes($string) {
        $attr = array();
        $res  = array();
        preg_match_all( '/([\w:-]+)[\s]?=[\s]?"([^"]*)"/i', $string, $attr );
        if (is_array($attr)) {
            $numPairs = count($attr[1]);
            for($i = 0; $i < $numPairs; $i++ ) {
                $res[$attr[1][$i]] = $attr[2][$i];
            }
        }
        return $res;
    }
	
    function search($id, $array) {
    	$res = false;
    	if(!($id && $array)) return $res;
    	for ($i = 0; $i < count($array); $i++){
    		if($array[$i]->id == $id){
    			$res = $array[$i];
    			break;
    		}
    	}
    	return $res;
    }
    
    function inArray($elem, $array){
    	$res = -1;
        if(!($elem && $array)) return $res;
        $i = 0;
        foreach ($array as $key => $value) {
        	if($array[$key] == $elem){
                $res = $i;
                break;
            }
            $i++;
        }
        return $res;
    }
    
    function remove($elem, $array) {
        $res = array();
        if(!($elem && $array)) return $res;
        for ($i = 0; $i < count($array); $i++){
            if($array[$i] != $elem){
                $res[] = $array[$i];
            }
        }
        return $res;
    }
    
	function insert($elem, $pos, $array) {
        $res = array();
        if(!($elem && $array)) return false;
        for ($i = 0; $i < count($array); $i++){
            if($i == $pos){
                $res[] = $elem;
            }
            $res[] = $array[$i];
        }
        if($pos >= count($array))	$res[] = $elem;
        return $res;
    }
    
    function userCanEdit(){
    	$user = (isset($_SESSION['USER']) ? $_SESSION['USER'] : NULL);
    	if($user){
    		return $user->rol == 'Super Administrador' || $user->rol == 'Editor'; 
    	}
    	return false;
    }
    
	function userCanAdministrate() {
    	$user = (isset($_SESSION['USER']) && $_SESSION['USER']->rol == 'Super Administrador' ? $_SESSION['USER'] : NULL);
    	if($user){
    		return $user->rol == 'Super Administrador'; 
    	}
    	return false;
    }
}
?>