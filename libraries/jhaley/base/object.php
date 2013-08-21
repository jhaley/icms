<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );

class JhaObject{
    public function getProperties( $isPublic = true ) {
        $vars  = get_object_vars($this);
        if($isPublic) {
            foreach ($vars as $key => $value) {
                if ('_' == substr($key, 0, 1)) {
                    unset($vars[$key]);
                }
            }
        }
        return $vars;
    }
    
    protected function redirect($url = 'index.php'){
    	$config = JhaFactory::getConfig();
        if (preg_match( '#^index[2]?.php#', $url )) {
            $host = 'http://' . $_SERVER['HTTP_HOST'];
            $site = $config->site;
            $url = $host . $site . $url;
        }
        header( 'HTTP/1.1 301 Moved Permanently' );
        header( 'Location: ' . $url );
    }
}
?>