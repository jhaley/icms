<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.base.object');

class JhaView extends JhaObject {

    protected $_name;
    protected $_module;
    protected $_layout;
    protected $_ext;
    protected $_model;
    
    public function __construct(){
        if (empty( $this->_name ) || empty( $this->_module )) {
            $this->_name = $this->getName();
            $this->_module = $this->getModule();
        }
        $this->_layout = $this->_name;
        $this->_ext = '.php';
    }
    
    public function display(){
    	$file = $this->_layout . $this->_ext;
   	    $content = '';
   	    $urlFile = $GLOBALS['JHA_MODULE_PATH'].'views'.DS.'html'.DS.$file;
   	    if(file_exists( $urlFile )){
   	    	ob_start();
            require_once $urlFile;
            $content = ob_get_contents();
            ob_end_clean();
            echo $content;
        }
        else{
        	throw new Exception("Vista no encontrada");
        }
    }
    
    public function &getModel($model = ''){
    	$model = (empty($model) ? $this->getName() : $model);
        $prefix = $this->_module . 'Model';
        jhaimport('jhaley.mvc.model');
        $this->model = JhaModel::getInstance($model, $prefix);
        return $this->model;
    }
    
    public function getLayout(){
    	return $this->_layout;
    }
    
    public function setLayout($layout = ''){
    	$this->_layout = $layout;
    }
    
    public function setModel(&$model = null){
    	$this->_model = &$model;
    }
    
    protected function getName(){
        $names = $this->getNames();
        return $names[1];
    }
    
    protected function getModule(){
        $names = $this->getNames();
        return $names[0];
    }
    
    private function getNames(){
    	$module = $this->_module;
        $name = $this->_name;
        if (empty( $name ) || empty( $module )) {
            $r = null;
            if (!preg_match('/(.*)View((view)*(.*(view)?.*))$/i', get_class($this), $r)) {
                throw new Exception("JhaView::getName() : No se puede obtener el nombre de la clase.");
            }
            if (strpos($r[4], "view")) {
                throw new Exception("JhaView::getName() : El nombre de la clase contiene la subcadena 'view'. Esto causa problemas cuando se extrae el nombre para la clase del nombre del objeto de la vista. Evite esto eliminando la subcadena 'view'.");
            }
            $module = strtolower( $r[1] );
            $name = strtolower( $r[4] );
        }
        return array($module,$name);
    }
    
    function assignRef($key, &$val) {
        if (is_string($key) && substr($key, 0, 1) != '_') {
            $this->$key =& $val;
            return true;
        }
        return false;
    }
    
    public function &getInstance($name, $prefix){
        $name = preg_replace('/[^A-Z0-9_\.-]/i', '', $name);
        $prefix = preg_replace('/[^A-Z0-9_\.-]/i', '', $prefix);
		$viewClass	= $prefix.$name;
		$result = false;
		if (!class_exists( $viewClass )) {
			$path = $GLOBALS['JHA_MODULE_PATH'].'views'.DS.$name.'.php';
			if ($path) {
				require_once $path;
				if (!class_exists( $viewClass )) {
					throw new Exception( 'Vista ' . $viewClass . ' no encontrado.' );
					return $result;
				}
			}
			else return $result;
		}
		$result = new $viewClass();
		return $result;
    }
}
?>