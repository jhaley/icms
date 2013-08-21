<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.mvc.view');

class BaseViewTheme extends JhaView {
    public function display(){
    	//listar themes y pasarlos al table template
    	$model = &$this->getModel();
    	$themes = $model->getThemes();
    	$controls = $this->createControls();
    	
    	$this->assignRef('themes', $themes);
    	$this->assignRef('controls', $controls);
        parent::display();
    }
    
    private function createControls(){
        //array-> titulos, link, tasks, linktype**, icons
    	$task = JhaRequest::getVar('task');
        if($task == 'newtheme'){
            return JhaHTML::renderControls(array('Guardar', 'Cancelar'), array('savetheme', 'canceltheme'), array('save', 'cancel'), null);
        }
        else{
            return JhaHTML::renderControls(array('Nuevo'), array('newtheme'), array('new'), null);
        }
    }
    
    public function newtheme(){
    	$controls = $this->createControls();
    	$this->assignRef('controls', $controls);
    	parent::display();
    }
}
?>