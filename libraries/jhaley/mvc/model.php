<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.base.object');

class JhaModel extends JhaObject {
	
	protected $_name;
	protected $_module;
	
    public function __construct(){
        if (empty( $this->_name ) || empty( $this->_module )) {
            $this->_name = $this->getName();
            $this->_module = $this->getModule();
        }
    }
    
    public function &getTable($name = '') {
    	if(empty($name))   return false;
        $name   = preg_replace( '/[^A-Z0-9_]/i', '', $name );
        $table = &JhaTable::getInstance($name);
        return $table;
    }
    
    protected function getName(){
        $names = $this->getNames();
        return $names[1];
    }
    
    protected function getModule(){
        $names = $this->getNames();
        return $names[0];
    }
    
    protected function getNames(){
        $module = $this->_module;
        $name = $this->_name;
        if (empty( $name ) || empty( $module )) {
            $r = null;
            if ( !preg_match( '/(.*)Model(.*)/i', get_class( $this ), $r ) ) {
                throw new Exception("JhaModel::getName(): Cannot get or parse class name.");
            }
            $module = strtolower( $r[1] );
            $name = strtolower( $r[2] );
        }
        return array($module,$name);
    }
    
    public function &getInstance($name, $prefix){
        $name = preg_replace('/[^A-Z0-9_\.-]/i', '', $name);
        $prefix = preg_replace('/[^A-Z0-9_\.-]/i', '', $prefix);
        $modelClass  = $prefix.ucfirst($name);
        $result = false;
        if (!class_exists( $modelClass )) {
            $path = $GLOBALS['JHA_MODULE_PATH'].'models'.DS.$name.'.php';
            if ($path) {
                require_once $path;
                if (!class_exists( $modelClass )) {
                    throw new Exception( 'Modelo ' . $modelClass . ' no encontrado.' );
                    return $result;
                }
            }
            else return $result;
        }
        $result = new $modelClass();
        return $result;
    }
}
?>