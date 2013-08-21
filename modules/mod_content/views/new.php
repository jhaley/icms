<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.mvc.view');

class ContentViewNew extends JhaView {
    public function display(){
    	$this->admin();
    }
    
	public function admin(){
    	$model = &$this->getModel('new');
    	$noticias = $model->getNoticias();
    	$controls = $this->createControls();
    	$this->assignRef('noticias', $noticias);
    	$this->assignRef('controls', $controls);
        parent::display();
    }
    
	private function createControls(){
    	$task = JhaRequest::getVar('task');
        if($task == 'newnew' || $task == 'editnew'){
            return JhaHTML::renderControls(array('Guardar', 'Cancelar'), array('savenew', 'admin'), array('save', 'cancel'), null);
        }
        return JhaHTML::renderControls(array('Nuevo', 'Editar', 'Eliminar'), array('newnew', 'editnew', 'deletenew'), array('new', 'edit', 'delete'), null);
    }
    
    public function newnew(){
    	$controls = $this->createControls();
    	
    	$this->assignRef('controls', $controls);
        parent::display();
    }
    
	public function editnew(){
    	$model = &$this->getModel('new');
    	$controls = $this->createControls();
    	$ids = JhaRequest::getVar('id');
    	if(!is_array($ids)) $ids = array($ids);
    	$noticia = $model->getNoticia($ids[0]);
    	
    	$this->assignRef('noticia', $noticia);
    	$this->assignRef('controls', $controls);
        parent::display();
    }
}
?>