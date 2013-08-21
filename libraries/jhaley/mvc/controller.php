<?php 
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.base.object');

class JhaController extends JhaObject {
	
	var $_tasks;
	var $_name;
	var $_module;
	
    public function __construct(){
    	$this->_tasks = array();
        if (empty( $this->_name ) || empty( $this->_module )) {
            $this->_name = $this->getName();
            $this->_module = $this->getModule();
        }
    	
    	$thisMethods = get_class_methods( get_class( $this ) );
        $baseMethods = get_class_methods( 'JhaController' );
        $methods = array_diff( $thisMethods, $baseMethods );
        $methods[] = 'display';
        foreach ( $methods as $method ) {
	        $this->_tasks[strtolower( $method )] = $method;
        }
    }
    
    public function display(){
    	$view = &$this->getView();
    	$model = &$this->getModel();
    	$view->setModel($model);
    	$view->display();
    }
    
    public function execute($task){
        $task = strtolower( $task );
        if (isset($this->_tasks[$task])) {
        	$jobToDo = $this->_tasks[$task];
        }
        elseif (isset($this->_tasks['display'])){
        	$jobToDo = $this->_tasks['display'];
        }
        else{
        	throw new Exception( 'Proceso asociado a la tarea ' . $task . ' no encontrada.' );
        }
        return $this->$jobToDo();
    }
    
    public function &getView($view = ''){
    	$view = (empty($view) ? $this->getName() : $view);
        $prefix = $this->_module . 'View';
        jhaimport('jhaley.mvc.view');
        return JhaView::getInstance($view, $prefix);
    }
    
    public function &getModel($model = ''){
    	$model = (empty($model) ? $this->getName() : $model);
        $prefix = $this->_module . 'Model';
        jhaimport('jhaley.mvc.model');
        return JhaModel::getInstance($model, $prefix);
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
            if ( !preg_match( '/(.*)Controller(.*)/i', get_class( $this ), $r ) ) {
                throw new Exception("JhaController::getNames(): Cannot get or parse class name.");
            }
            $module = strtolower( $r[1] );
            $name = strtolower( $r[2] );
        }
        return array($module,$name);
    }
}
?>