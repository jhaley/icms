<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.base.object');

class JhaRendererModule extends JhaObject {
    public function render($path){
        $content = '';
        if(file_exists( $path )){
            ob_start();
            require $path;
            $content = ob_get_contents();
            ob_end_clean();
        }
        return $content;
    }
}
?>