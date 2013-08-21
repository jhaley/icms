<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.mvc.view');

class BaseViewBlock extends JhaView {
    public function display(){
    	if(JhaUtility::userCanAdministrate()){
	    	$model = &$this->getModel();
	    	$bloques = $model->getBlocks();
	    	$controls = $this->createControls();
	    	
	    	$this->assignRef('blocks', $bloques);
	    	$this->assignRef('controls', $controls);
	        parent::display();
    	}
    	else
    		$this->redirect();
    }
    
    public function reorder($isUpdated){
        jhaimport('jhaley.web.json');
        $objJson = new JSON ( );
        $objJson->add ( "saved", ($isUpdated ? 'true' : 'false') );
        print $objJson->render ();
        return;
    }
    
    public function newblock(){
    	//obtener datos desde BD.
    	$model = &$this->getModel();
    	$blocktypes = $this->getBlockTypes();
    	$regions = $this->getRegions($model->getThemeParameters());
    	$menuelems = $this->getMenus();
    	$controls = $this->createControls();
    	$region = JhaRequest::getVar('region', null);
    	
    	$this->assignRef('controls', $controls);
    	$this->assignRef('blocktypes', $blocktypes);
        $this->assignRef('regions', $regions);
        $this->assignRef('region', $region);
        $this->assignRef('menus', $menuelems['menus']);
        $this->assignRef('itemscount', $menuelems['itemscount']);
    	
    	parent::display();
    }
    
    public function editblock(){
    	//obtener datos desde BD.
    	$model = &$this->getModel();
        $blocktypes = $this->getBlockTypes();
        $regions = $this->getRegions($model->getThemeParameters());
        $menuelems = $this->getMenus();
        $controls = $this->createControls();
        $ids = JhaRequest::getVar('id');
        if(!is_array($ids)) $ids = array($ids);
        $block = $model->getBlock($ids[0]);
        $menuids = $model->getMenuBlocks($ids[0]);
        $menublocks = array();
        if(count($menuids) > 0 ){
            foreach($menuids as $menuid){
                $menublocks[] = $menuid->idmenu;
            }
        }
        
        JhaRequest::setVar('region', $block->region);
        JhaRequest::setVar('blocktype', $block->renderizador);
        JhaRequest::setVar('id', $block->id);
        $orders = $this->loadOrder($block->orden);
        $parameters = $this->loadParameters();
        
        $this->assignRef('block', $block);
        $this->assignRef('parameters', $parameters);
        $this->assignRef('menublocks', $menublocks);
        $this->assignRef('controls', $controls);
        $this->assignRef('blocktypes', $blocktypes);
        $this->assignRef('regions', $regions);
        $this->assignRef('menus', $menuelems['menus']);
        $this->assignRef('itemscount', $menuelems['itemscount']);
        $this->assignRef('orders', $orders);
    	
        parent::display();
    }
    
    private function createControls(){
        //array-> titulos, link, tasks, linktype**, icons  
        // ** -> Para la validacion de los checkboxes.
        $task = JhaRequest::getVar('task');
        if($task == 'newblock' || $task == 'editblock'){
            return JhaHTML::renderControls(array('Guardar', 'Cancelar'), array('saveblock', 'cancelblock'), array('save', 'cancel'), null);
        }
        else{
            return JhaHTML::renderControls(array('Nuevo', 'Editar', 'Eliminar'), array('newblock', 'editblock', 'deleteblock'), array('new', 'edit', 'delete'), null);
        }
    }
    
    private function getBlockTypes(){
    	$res = array();
        $blocks = scandir(JHA_BLOCKS_PATH);
        foreach ($blocks as $block) {
        	$blocktype = new stdClass();
        	if(substr($block, 0, 6) == 'block_'){
        		$xml = simplexml_load_file(JHA_BLOCKS_PATH.DS.$block.DS.'info.xml');
        		$blocktype->name = $xml->info->name . '';
        		$blocktype->renderer = $xml->info->renderer . '';
        		$res[] = $blocktype;
        	}
        }
        return $res;
    }
    
    private function getRegions($themepath){
        $res = array();
        $xml = simplexml_load_file($themepath.DS.'info.xml');
        foreach ($xml->regions->region as $region) {
        	$res[] = $region . '';
        }
        return $res;
    }
    
    private function getMenus(){
    	$model = &$this->getModel();
    	$res = array();
    	$menus = $model->getMenus();
    	$numitems = count($menus);
    	if(count($menus) > 0){
    		foreach ($menus as $menu) {
    			$obj = new stdClass();
    			$obj->menu = $menu;
    			$obj->items = array();
    			$menuitems = $model->getMenuItems($menu->id);
    			if(count($menuitems) > 0){
    				$obj->items = $menuitems;
    				$numitems += count($menuitems);
    			}
    			$res[] = $obj;
    		}
    	}
    	return array('menus'=>$res, 'itemscount'=>$numitems); 
    }
    
    public function loadParameters(){
    	$res = '';
    	$oldlayout = $this->getLayout();
        $this->setLayout('block.form.params');
    	ob_start();
        $blocktype = JhaRequest::getVar('blocktype');
        $blocktypepath = JHA_BLOCKS_PATH.DS.$blocktype;
        $this->assignRef('blocktypepath', $blocktypepath);
        $this->assignRef('model', $this->getModel('block'));
        parent::display();
        $res = ob_get_contents();
        ob_end_clean();
        $this->setLayout($oldlayout);
        return $res;
    }
    
    public function loadOrder($orden = 0){
        jhaimport('jhaley.web.tags');
        $model = &$this->getModel();
    	$region = JhaRequest::getVar('region');
        if($region == 'x')  return '';
        $tags = array();
        $blocks = $model->getBlocks($region);
        foreach ($blocks as $block) {
        	$tagaux = new Tag('option', $block->orden . ' -> ' . $block->titulo);
        	$tagaux->setAttribute('value', $block->orden);
        	if($orden != 0 && $orden == $block->orden) $tagaux->setAttribute('selected', 'selected');
        	$tags[] = $tagaux->html();
        }
        if(count($tags) <= 0)	{
        	$tagaux = new Tag('option', '1 -> Ultimo');
        	$tagaux->setAttribute('value', '1');
        	$tagaux->setAttribute('selected', 'selected');
        	return $tagaux->html();
        }
        return implode('', $tags);
    }
    
	public function selectFolder(){
    	$res = '';
    	ob_start();
        $folders = $this->getFolders();
        $this->assignRef('folders', $folders);
        parent::display();
        $res = ob_get_contents();
        ob_end_clean();
        return $res;
    }
    
    private function getFolders(){
    	if(JhaRequest::getVar('path') == 'images'){
    		$obj = new stdClass();
    		$obj->nombre = "images";
    		$obj->path = "images";
    		$obj->imagen = "images/folder-large.png";
    		return array($obj);
    	}
    	jhaimport('jhaley.file.dir');
    	$path = JhaRequest::getVar('path');
    	$path = split(addslashes(DS), $path);
    	$elems = array();
    	for ($i = 0; $i < count($path) - 1; $i++) {
    		$elems[] = $path[$i];
    	}
    	$pathPreffix = implode(DS, $elems);
    	$path = JHA_BASE_PATH.DS.$pathPreffix;
    	$dir = new JhaDirectory($path);
    	$dir->read();
    	$folders = $dir->getFolders();
    	$res = array();
    	for ($i = 0; $i < count($folders); $i++) {
    		$path = $folders[$i];
    		$obj = new stdClass();
    		$obj->nombre = $path;
    		if($path == "..") {
    			$obj->path = $pathPreffix;
    			$obj->imagen = "images/folder-up.png";
    		}
    		else {
    			$obj->path = $pathPreffix.DS.$path;
    			$obj->imagen = "images/folder-large.png";
    		}
    		$res[] = $obj;
    	}
    	return $res;
    }
}
?>