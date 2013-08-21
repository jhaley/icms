<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.base.object');

class JhaFactory extends JhaObject {
    static function &getRenderer($type = null){
        static $renderer;
       	if($type == null){
       		if(JhaRequest::getVar('elem') == 'mod_base' && JhaRequest::getVar('controller') == 'theme' && (JhaRequest::getVar('task') == 'personalizeTheme' || JhaRequest::getVar('task') == 'savePersonalizedChanges')){
       			jhaimport('jhaley.html.theme'); 
	            $renderer = new JhaThemeRenderer();
       		}
       		else {
	            jhaimport('jhaley.html.renderer'); 
	            $renderer = new JhaRenderer();
       		}
       	}
       	elseif($type == 'block'){
       		jhaimport('jhaley.html.block'); 
            $renderer = new JhaRendererBlock();
       	}
       	elseif($type == 'module'){
            jhaimport('jhaley.html.module'); 
            $renderer = new JhaRendererModule();
        }
        elseif($type == 'head'){
            jhaimport('jhaley.html.head'); 
            $renderer = new JhaRendererHead();
        }
        elseif($type == 'admin-menu'){
            jhaimport('jhaley.html.adminmenu'); 
            $renderer = new JhaRendererAdminMenu();
        }
        elseif($type == 'ajax'){
            jhaimport('jhaley.html.ajax'); 
            $renderer = new JhaAJAXRenderer();
        }
        return $renderer;
    }
    
	static function &getDBO(){
        static $dbo;
        if (!is_object($dbo)) {
            jhaimport('jhaley.db.dbo');             
            $dbo = new JhaDBO(JhaFactory::getConfig());
        }
        return $dbo;
    }
    
	static function &getConfig(){
        static $config;
        if (!is_object($config)) {
            require_once JHA_CONFIGURATION_PATH . DS . 'config.php'; 
            $config = new JhaConfiguration();
        }
        return $config;
    }
    
    static function &getEditor(){
        static $editor;
        if (!is_object($editor)) {
            jhaimport('jhaley.editor.ckeditor');
            jhaimport('jhaley.filefinder.ckfinder');
            $editor = new CKEditor();
            $finder = new CKFinder();
			$finder->BasePath = 'libraries/jhaley/filefinder/';
			$finder->SetupCKEditorObject($editor);
        }
        return $editor;
    }
}
?>