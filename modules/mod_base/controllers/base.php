<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.mvc.controller');

class BaseControllerBase extends JhaController {
	
	public function display(){
		parent::display();
	}
	
	public function config(){
		$view = &$this->getView();
		$view->setLayout('config.form');
		$view->config();
	}
	
	public function saveconfig(){
		$config = JhaFactory::getConfig();
		$vars = '';
		foreach (get_object_vars( $config ) as $k => $v) {
			if(JhaRequest::getVar($k) == NULL)
				$vars .= "\tvar $". $k . " = \"" . $v . "\";\n";
			else 
				$vars .= "\tvar $". $k . " = \"" . addslashes(JhaRequest::getVar($k)) . "\";\n";
		}
		$str = "<?php\n\ndefined( '_JHAEXEC' ) or die( 'Access Denied' );\n\n/**\n * Archivo de configuracion Base\n */\n\nclass JhaConfiguration {\n" . $vars . "}\n?>";
		jhaimport('jhaley.file.file');
		$file = new JhaFile(JHA_BASE_PATH.DS.'config.php', $str);
		$file->write();
		$this->redirect();
	}
	
	public function cancelconfig(){
		$this->redirect();
	}
}
?>