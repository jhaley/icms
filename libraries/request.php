<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );

$GLOBALS['_JHAREQUEST'] = array();

define( 'JHAREQUEST_NOTRIM'   , 1 );
define( 'JHAREQUEST_ALLOWRAW' , 2 );
define( 'JHAREQUEST_ALLOWHTML', 4 );

class JhaRequest {    
    function getMethod() {
        return strtoupper( $_SERVER['REQUEST_METHOD'] );
    }
    
    function getVar($name, $default = null, $hash = 'default', $type = 'none', $mask = 0) {
        // Ensure hash and type are uppercase
        $hash = strtoupper( $hash );
        if ($hash === 'METHOD') {
            $hash = strtoupper( $_SERVER['REQUEST_METHOD'] );
        }
        $type   = strtoupper( $type );
        $sig    = $hash.$type.$mask;
        switch ($hash) {
            case 'GET' :
                $input = &$_GET;
                break;
            case 'POST' :
                $input = &$_POST;
                break;
            case 'FILES' :
                $input = &$_FILES;
                break;
            case 'COOKIE' :
                $input = &$_COOKIE;
                break;
            case 'ENV'    :
                $input = &$_ENV;
                break;
            case 'SERVER'    :
                $input = &$_SERVER;
                break;
            default:
                $input = &$_REQUEST;
                $hash = 'REQUEST';
                break;
        }

        if (isset($GLOBALS['_JHAREQUEST'][$name]['SET.'.$hash]) && ($GLOBALS['_JHAREQUEST'][$name]['SET.'.$hash] === true)) {
            // Get the variable from the input hash
            $var = (isset($input[$name]) && $input[$name] !== null) ? $input[$name] : $default;
            $var = JhaRequest::_cleanVar($var, $mask, $type);
        }
        elseif (!isset($GLOBALS['_JHAREQUEST'][$name][$sig])) {
            if (isset($input[$name]) && $input[$name] !== null) {
                $var = JhaRequest::_cleanVar($input[$name], $mask, $type);
                // Handle magic quotes compatability
                if (get_magic_quotes_gpc() && ($var != $default) && ($hash != 'FILES')) {
                    $var = JhaRequest::_stripSlashesRecursive( $var );
                }
                $GLOBALS['_JHAREQUEST'][$name][$sig] = $var;
            }
            elseif ($default !== null) {
                // Clean the default value
                $var = JhaRequest::_cleanVar($default, $mask, $type);
            }
            else {
                $var = $default;
            }
        } else {
            $var = $GLOBALS['_JHAREQUEST'][$name][$sig];
        }
        return $var;
    }

	function getVarsWithPreffix($preffix, $hash = 'default') {
		$res = array();
        $hash = strtoupper( $hash );
        if ($hash === 'METHOD') {
            $hash = strtoupper( $_SERVER['REQUEST_METHOD'] );
        }
        switch ($hash) {
            case 'GET' :
                $input = &$_GET;
                break;
            case 'POST' :
                $input = &$_POST;
                break;
            case 'FILES' :
                $input = &$_FILES;
                break;
            case 'COOKIE' :
                $input = &$_COOKIE;
                break;
            case 'ENV'    :
                $input = &$_ENV;
                break;
            case 'SERVER'    :
                $input = &$_SERVER;
                break;
            default:
                $input = &$_REQUEST;
                $hash = 'REQUEST';
                break;
        }
        foreach ( $input as $index => $value ) {
        	if (substr ( $index, 0, strlen ($preffix) ) == $preffix) { 
				$res[substr ( $index, strlen ($preffix))] = $value;
			}
        }
        return $res;
    }
    
    function getCmd($name, $default = '', $hash = 'default')
    {
        return JhaRequest::getVar($name, $default, $hash, 'cmd');
    }

    function getString($name, $default = '', $hash = 'default', $mask = 0) {
        // Cast to string, in case JHAREQUEST_ALLOWRAW was specified for mask
        return (string) JhaRequest::getVar($name, $default, $hash, 'string', $mask);
    }

    function setVar($name, $value = null, $hash = 'method', $overwrite = true) {
        //If overwrite is true, makes sure the variable hasn't been set yet
        if(!$overwrite && array_key_exists($name, $_REQUEST)) {
            return $_REQUEST[$name];
        }
        $GLOBALS['_JHAREQUEST'][$name] = array();
        $hash = strtoupper($hash);
        if ($hash === 'METHOD') {
            $hash = strtoupper($_SERVER['REQUEST_METHOD']);
        }
        $previous   = array_key_exists($name, $_REQUEST) ? $_REQUEST[$name] : null;
        switch ($hash) {
            case 'GET' :
                $_GET[$name] = $value;
                $_REQUEST[$name] = $value;
                break;
            case 'POST' :
                $_POST[$name] = $value;
                $_REQUEST[$name] = $value;
                break;
            case 'COOKIE' :
                $_COOKIE[$name] = $value;
                $_REQUEST[$name] = $value;
                break;
            case 'FILES' :
                $_FILES[$name] = $value;
                break;
            case 'ENV'    :
                $_ENV['name'] = $value;
                break;
            case 'SERVER'    :
                $_SERVER['name'] = $value;
                break;
        }
        $GLOBALS['_JHAREQUEST'][$name]['SET.'.$hash] = true;
        $GLOBALS['_JHAREQUEST'][$name]['SET.REQUEST'] = true;
        return $previous;
    }

    function get($hash = 'default', $mask = 0) {
        $hash = strtoupper($hash);
        if ($hash === 'METHOD') {
            $hash = strtoupper( $_SERVER['REQUEST_METHOD'] );
        }
        switch ($hash) {
            case 'GET' :
                $input = $_GET;
                break;
            case 'POST' :
                $input = $_POST;
                break;
            case 'FILES' :
                $input = $_FILES;
                break;
            case 'COOKIE' :
                $input = $_COOKIE;
                break;
            case 'ENV'    :
                $input = &$_ENV;
                break;
            case 'SERVER'    :
                $input = &$_SERVER;
                break;
            default:
                $input = $_REQUEST;
                break;
        }
        $result = JhaRequest::_cleanVar($input, $mask);
        if (get_magic_quotes_gpc() && ($hash != 'FILES')) {
            $result = JhaRequest::_stripSlashesRecursive( $result );
        }
        return $result;
    }

    function set( $array, $hash = 'default', $overwrite = true ) {
        foreach ($array as $key => $value) {
            JhaRequest::setVar($key, $value, $hash, $overwrite);
        }
    }

    function clean() {
        JhaRequest::_cleanArray( $_FILES );
        JhaRequest::_cleanArray( $_ENV );
        JhaRequest::_cleanArray( $_GET );
        JhaRequest::_cleanArray( $_POST );
        JhaRequest::_cleanArray( $_COOKIE );
        JhaRequest::_cleanArray( $_SERVER );
        if (isset( $_SESSION )) {
            JhaRequest::_cleanArray( $_SESSION );
        }
        $REQUEST    = $_REQUEST;
        $GET        = $_GET;
        $POST       = $_POST;
        $COOKIE     = $_COOKIE;
        $FILES      = $_FILES;
        $ENV        = $_ENV;
        $SERVER     = $_SERVER;
        if (isset ( $_SESSION )) {
            $SESSION = $_SESSION;
        }
        foreach ($GLOBALS as $key => $value){
            if ( $key != 'GLOBALS' ) {
                unset ( $GLOBALS [ $key ] );
            }
        }
        $_REQUEST   = $REQUEST;
        $_GET       = $GET;
        $_POST      = $POST;
        $_COOKIE    = $COOKIE;
        $_FILES     = $FILES;
        $_ENV       = $ENV;
        $_SERVER    = $SERVER;
        if (isset ( $SESSION )) {
            $_SESSION = $SESSION;
        }
        $GLOBALS['_JHAREQUEST'] = array();
    }

    function _cleanArray( &$array, $globalise=false ) {
        static $banned = array( '_files', '_env', '_get', '_post', '_cookie', '_server', '_session', 'globals' );
        foreach ($array as $key => $value) {
            $failed = in_array( strtolower( $key ), $banned );
            $failed |= is_numeric( $key );
            if ($failed) {
                exit( 'Illegal variable <b>' . implode( '</b> or <b>', $banned ) . '</b> passed to script.' );
            }
            if ($globalise) {
                $GLOBALS[$key] = $value;
            }
        }
    }

    function _cleanVar($var, $mask = 0, $type=null) {
        static $noHtmlFilter    = null;
        static $safeHtmlFilter  = null;
        if (!($mask & 1) && is_string($var)) {
            $var = trim($var);
        }
        if ($mask & 2) {
            $var = $var;
        }
        elseif ($mask & 4) {
            $var = $var;
        }
        else{
            $var = $var;
        }
        return $var;
    }

    function _stripSlashesRecursive( $value ) {
        $value = is_array( $value ) ? array_map( array( 'JhaRequest', '_stripSlashesRecursive' ), $value ) : stripslashes( $value );
        return $value;
    }
}
?>