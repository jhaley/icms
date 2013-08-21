<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.mvc.controller');

class BaseControllerBlock extends JhaController {
	
	public function display(){
		parent::display();
	}
	
	public function reorder(){
	    $model = &$this->getModel();
        $view = &$this->getView();
        $blocks = $model->getBlocks();
        $src = JhaRequest::getVar('src',NULL);
        $trg = JhaRequest::getVar('trg',NULL);
        $json = JhaRequest::getVar('json','false');
        $before = JhaRequest::getVar('before','false');
        //si $trg es distinto de valor numerico -> llamar a otra funcion y reordenar
        if(intval($trg) == 0){
        	$this->reorderWithRegionName(JhaUtility::search($src, $blocks), $trg, $json, $before);
        	return;
        }
        $objSrc = JhaUtility::search($src, $blocks);
        $objTrg = JhaUtility::search($trg, $blocks);
        if($objSrc->region != $objTrg->region){
        	$blocksSrcRegion = $model->getBlocks($objSrc->region);
            $blocksTrgRegion = $model->getBlocks($objTrg->region);
            $blocksSrcRegion = JhaUtility::remove($objSrc, $blocksSrcRegion);
            $objSrc->region = $objTrg->region;
	        if($before == 'true')
	            $neworder = JhaUtility::inArray($objTrg, $blocksTrgRegion);
	        else 
	            $neworder = JhaUtility::inArray($objTrg, $blocksTrgRegion) + 1;
	        $newblocks = $this->reordenar($blocksTrgRegion, $src, $neworder, $objSrc);
	        $isUpdated = true;
	        for($i = 0; $i < count($newblocks); $i++) {
	            $isUpdated = $isUpdated && $model->updateBlock($newblocks[$i], $i + 1);
	        }
            for($i = 0; $i < count($blocksSrcRegion); $i++) {
                $isUpdated = $isUpdated && $model->updateBlock($blocksSrcRegion[$i], $i + 1);
            }
        }
        else{
            $blocksTrgRegion = $model->getBlocks($objTrg->region);
            if($before == 'true')
                $neworder = JhaUtility::inArray($objTrg, $blocksTrgRegion);
            else 
                $neworder = JhaUtility::inArray($objTrg, $blocksTrgRegion) + 1;
            $newblocks = $this->reordenar($blocksTrgRegion, $src, $neworder, $objSrc);
            $isUpdated = true;
            for($i = 0; $i < count($newblocks); $i++) {
                $isUpdated = $isUpdated && $model->updateBlock($newblocks[$i], $i + 1);
            }
        }
        
        if($json == 'true')
            $view->reorder($isUpdated);
        else
            parent::display();
    }
    
    private function reorderWithRegionName($objSrc, $trg, $json, $before){
	    $model = &$this->getModel();
        $view = &$this->getView();
    	$blocksSrcRegion = $model->getBlocks($objSrc->region);
        $blocksTrgRegion = $model->getBlocks($trg);
        $blocksSrcRegion = JhaUtility::remove($objSrc, $blocksSrcRegion);
        $objSrc->region = $trg;
        $neworder = $before == 'true' ? 0 : 1;
        $newblocks = $this->reordenar($blocksTrgRegion, $objSrc->id, $neworder, $objSrc);
        $isUpdated = true;
        for($i = 0; $i < count($newblocks); $i++) {
            $isUpdated = $isUpdated && $model->updateBlock($newblocks[$i], $i + 1);
        }
        for($i = 0; $i < count($blocksSrcRegion); $i++) {
            $isUpdated = $isUpdated && $model->updateBlock($blocksSrcRegion[$i], $i + 1);
        }
        if($json == 'true')
            $view->reorder($isUpdated);
        else
            parent::display();
    }
    
    private function reordenar($blocks, $id, $neworder, $obj) {
        $newblocks = array();
        for($i = 0; $i < count($blocks); $i++) {
            if($blocks[$i]->id != $id) {
                if(count($newblocks) == $neworder)
                    $newblocks[] = $obj;
                $newblocks[] = $blocks[$i];
            }
        }
        if(!JhaUtility::search($obj->id, $newblocks)) {
            if($neworder > 0)
                $newblocks[] = $obj;
            else {
                $newblocks = array_reverse($newblocks);
                $newblocks[] = $obj;
                $newblocks = array_reverse($newblocks);
            }
        }
        return $newblocks;
    }
    
    public function editblock(){
    	$model = &$this->getModel('block');
    	$view = &$this->getView('block');
    	$view->setModel($model);
    	$view->setLayout('block.form');
    	$view->editblock();
    }
    
    public function newblock(){
        $view = &$this->getView();
        $view->setLayout('block.form');
        $view->newblock();
    }
    
    public function deleteblock(){
    	$model = &$this->getModel('block');
        $itemid = JhaRequest::getVar('itemid');
        $ids = JhaRequest::getVar('id');
        if(!is_array($ids)) return false;
        foreach ($ids as $id) {
        	$menublocks = $model->getMenuBlocks($id);
        	if(count($menublocks)){
	        	foreach ($menublocks as $menublock) {
	        		$model->deleteMenuBlock($id, $menublock->idmenu);
	        	}
        	}
        	$model->deleteBlock($id);
        }
        //redireccionar a la pagina anterior.
        $this->redirect('index.php?elem=mod_base&controller=block');
    }
    
	public function saveblock(){
    	$model = &$this->getModel('block');
    	$params = '';
    	$parameters = JhaRequest::getVarsWithPreffix('params_');
    	foreach ($parameters as $index => $value) {
    		$params .= $index . '=' . addslashes($value) . '\n';
    	}
    	
    	$blocks = $model->getBlocks(JhaRequest::getVar('region'));
    	$id = JhaRequest::getVar('id');
    	if($id != '0'){
    		$orden = intval(JhaRequest::getVar('orden'));
    		$block = $model->getBlock($id);
    		if($block->orden == $orden){
    			$model->saveBlock($params, $orden);
    		}
    		else{
    			if(count($blocks) <= 0){
    				$model->saveBlock($params, $orden);
    			}
    			else{
	    			$elem = JhaUtility::search($id, $blocks);
	    			$blocks = JhaUtility::remove($elem, $blocks);
	    			$pos = -1;
	    			for ($i = 0; $i < count($blocks); $i++) {
	    				if($blocks[$i]->orden == $orden){
	    					$pos = $i;
	    					break;
	    				}
	    			}
	    			if($pos == -1)	return false;
	   				$blocks = JhaUtility::insert($elem, $pos, $blocks);
	   				$model->saveBlock($params);
		    		for($i = 0; $i < count($blocks); $i++) {
		                $model->updateBlock($blocks[$i], $i + 1);
		            }
    			}
    		}
    	}
    	else {
    		$id = $model->saveBlock($params, count($blocks) + 1);
    	}
    	//guardar relacion bloquemenu.
    	$menublocks = $model->getMenuBlocks($id);
    	if($menublocks){
	    	foreach ($menublocks as $menublock) {
	    		$model->deleteMenuBlock($id, $menublock->idmenu);
	    	}
    	}
    	$selectiontype = JhaRequest::getVar('menus');
    	if($selectiontype == 'all'){
    		$model->saveMenuBlock($id, '0');
    	}
    	else if($selectiontype == 'select'){
    		$menuids = JhaRequest::getVar('selections');
    		if(count($menuids) > 0){
    			foreach ($menuids as $menuid) {
    				$model->saveMenuBlock($id, $menuid);
    			}
    			
    		}
    	}
    	
    	$this->redirect('index.php?elem=mod_base&controller=block');
    	//JhaRequest::setVar('task', ''); 
        //$this->display();
    }
    
    public function loadParameters(){
    	$view = &$this->getView();
        $view->setLayout('block.form.params');
        echo $view->loadParameters();
    }
    
    public function loadOrder(){
        $view = &$this->getView();
        echo $view->loadOrder();
    }
    
    public function selectFolder(){
    	$view = &$this->getView('block');
    	$view->setLayout('banner.folder.explore');
        echo $view->selectFolder();
    }
}
?>