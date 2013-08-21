<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.mvc.view');

class BaseViewBase extends JhaView {
    public function display(){
    	//agregar funcionalidad
        parent::display();
    }
    
	public function config(){
		$config = JhaFactory::getConfig();
    	$controls = JhaHTML::renderControls(array('Guardar', 'Cancelar'), array('saveconfig', 'cancelconfig'), array('save', 'cancel'), null);
    	
    	$this->assignRef('config', $config);
    	$this->assignRef('controls', $controls);
		parent::display();
	}
}
?>