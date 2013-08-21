<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.mvc.controller');

class BaseControllerTheme extends JhaController {
	
	public function display(){
		parent::display();
	}
	
	public function changeDefault(){
		$model = &$this->getModel('theme');
		$themes = $model->getThemes();
		if(count($themes) > 0){
			foreach ($themes as $theme) {
				$model->removeDefault($theme);
			}
		}
		$model->setDefault(JhaRequest::getVar('id'));
		$this->redirect('index.php?elem=mod_base&controller=theme');
    }
    
    public function newtheme(){
    	$view = &$this->getView('theme');
    	$view->setLayout('theme.form');
    	$view->newtheme();
    }
    
	public function savetheme(){
		$file = JhaRequest::getVar('theme', null, 'files', 'array' );
		if (!(bool) ini_get('file_uploads')) {
			throw new Exception('No se pueden subir archivos. Habilitar en el servidor Web.');
			return false;
		}
		if (!is_array($file) ) {
			throw new Exception('No subio ningun archivo.');
			return false;
		}
		if ( $file['error'] || $file['size'] < 1 ) {
			throw new Exception('Error al subir el archivo.');
			return false;
		}
    	$cfg = &JhaFactory::getConfig();
		$tmpdest = $cfg->tmp_path . $file['name'];
		$tmpsrc	= $file['tmp_name'];
		if (!move_uploaded_file($tmpsrc, $tmpdest)) {
			throw new Exception('Error al subir el archivo.');
		}
		if(!mkdir(JHA_THEMES_PATH . DS . JhaRequest::getVar('nombre'), 0777)){
			throw new Exception('Error al subir el archivo.');
		}
		$ext = $this->getExtension($file['name']);
		switch ($ext[1]) {
			case 'tar':
				jhaimport('jhaley.compress.tar');
				$compressfile = new TarFile($tmpdest);
			break;
			case 'tar.gz':
			case 'tgz':
				jhaimport('jhaley.compress.gzip');
				$compressfile = new GzipFile($tmpdest);
			break;
			case 'tar.bz':
			case 'tbz':
				jhaimport('jhaley.compress.bzip');
				$compressfile = new BzipFile($tmpdest);
			break;
			default:
				throw new Exception('Formato de archivo invalido');
		}
		$compressfile->setOptions(array('inmemory' => 0, 'basedir' => JHA_THEMES_PATH . DS . JhaRequest::getVar('nombre')));
		$compressfile->extractFiles();
		
		$model = &$this->getModel('theme');
    	$id = $model->saveTheme();
    	jhaimport('jhaley.file.file');
    	$install = new JhaFile(JHA_THEMES_PATH.DS.JhaRequest::getVar('nombre').DS.'install.sql');
    	$install->read();
    	$query = $install->getContent() . ' WHERE id = ' . $id;
    	$model->updateTheme($query);
    	$this->redirect('index.php?elem=mod_base&controller=theme');
    }
    
    private function getExtension($filename){
    	$elems = split('\.', $filename);
    	$res = array($elems[0], '');
    	if(count($elems) > 2){
    		$res[1] .= ($elems[count($elems) - 2] == 'tar' ? 'tar.' : '');
    	}
    	if(count($elems) > 1){
    		$res[1] .= $elems[count($elems) - 1];
    	}
    	return $res;
    }
    
    public function personalizeTheme(){
    	$template = $_SESSION['themeHTML'];
    	$replace = array();
        $matches = array();
        $regiones = array();
        if(preg_match_all('#<jhadoc:include\ type="([^"]+)" (.*)\/>#iU', $template, $matches)) {
            $matches[0] = array_reverse($matches[0]);
            $matches[1] = array_reverse($matches[1]);
            $matches[2] = array_reverse($matches[2]);
            $count = count($matches[1]);
            for($i = 0; $i < $count; $i++) {
                $attribs = JhaUtility::parseAttributes( $matches[2][$i] );
                $replace[$i] = $this->getBuffer($matches[1][$i], (isset($attribs['region']) ? $attribs['region'] : null));
                $regiones[] = 'jha' . $matches[1][$i] . (isset($attribs['region']) ? $attribs['region'] : '');
            }
            $template = str_replace($matches[0], $replace, $template);
        }
        else {
        	$template = $this->getBuffer('module');
        	$regiones[] = 'jhamodule';
        }
        $GLOBALS['JHA_HEAD_VARS'][] = JhaHTML::script("dragTheme = new Jha.drag();\ndragTheme.setType('block');\n" . "dragTheme.onDragEnd = function(){if(dragTheme.target == -1 || dragTheme.currentSource == dragTheme.targets[dragTheme.target]) { dragTheme.reorder(false); return false;} dragTheme.reorder(true);objajax = new Jha.ajax();objajax.url = \"ajax.php\";objajax.json = false;objajax.drg = dragTheme;objajax.post = dragTheme.ajaxPost(objajax, 0, 0, false);objajax.action = function (){if (objajax.responseJSON && objajax.responseJSON.saved) {location.href = location.href;}};objajax.enviarpeticion();};\n" . "dragTheme.ajaxPost = function (objajax, idSource, idTarget, isBeforeTarget) { objajax.json = true; res = { elem : 'mod_base', controller : 'theme', xml : reorganizeXML(Jha.dom.$('jhamaincontent')) + '', json : objajax.json, task : 'reorganizeXML'}; return res; };\ndragTheme.setType('theme')", false);
        $GLOBALS['JHA_HEAD_VARS'][] = JhaHTML::script('nomenu = function (){return false;}; document.oncontextmenu = nomenu;', false);
        $script = '';
        foreach ($regiones as $region) {
        	$script .= "dragTheme.addTarget(Jha.dom.$('" . $region . "'));\n";
        }
        echo JhaHTML::script('modules/mod_base/extras/ptheme.js');
        echo $template;
        echo JhaHTML::script($script, false);
    }
    
    //popupThemeMenu
    //	true -> Module
    //	false -> Block 
    private function getBuffer($type, $region = null){
    	return '<div id="jha' . $type . ($type == 'module' ? '' : $region) . '" class="jhablock-header" style="border: 2px dashed #AAAAAA; margin: 5px; padding: 10px;" oncontextmenu="javascript:popupThemeMenu(event, ' . ($type == 'module' ? 'true' : 'false') . ', \'' . ($type == 'module' ? '' : $region) . '\');"><span onmousedown="javascript:dragTheme.onDragStart(event, Jha.dom.$(\'jha' . $type . ($type == 'module' ? '' : $region) . '\'));" style="cursor:move;">' . ($type == 'module' ? 'Contenido Principal' : 'Region: ' . $region) . '</span></div>';
    }
    
    public function divideIn(){
    	jhaimport('jhaley.web.xmltag');
    	$dividemethod = JhaRequest::getVar('dividemethod');
    	$region = JhaRequest::getVar('region', '');
    	$isModule = $region == '';
    	$xmlchilds = $this->toXMLObject(simplexml_load_string($_SESSION['themeXML']));
    	$xml = new XmlTag('content');
    	foreach ($xmlchilds as $xmlchild) {
    		$xml->add($xmlchild);
    	}
    	$elem = $this->findChild($region, $isModule, $xml);
    	$this->divide($dividemethod == 'rows', $elem); 
        $_SESSION['themeXML'] = $xml->xml();
    	$_SESSION['themeHTML'] = '<div id="jhamaincontent">' . $this->toHTMLObject(simplexml_load_string($_SESSION['themeXML'])) . '</div>';
    	$this->redirect('index.php?elem=mod_base&controller=theme&task=personalizeTheme');
    }

    public function reorganizeXML(){
        $_SESSION['themeXML'] = '<?xml version="1.0" encoding="ISO-8859-1" ?><content>' . JhaRequest::getVar('xml') . '</content>';
    	$_SESSION['themeHTML'] = '<div id="jhamaincontent">' . $this->toHTMLObject(simplexml_load_string($_SESSION['themeXML'])) . '</div>';
    	jhaimport('jhaley.web.json');
        $objJson = new JSON ( );
        $objJson->add ( "saved", 'true');
        print $objJson->render ();
        return;
    }
    
    public function deleteRegion(){
    	jhaimport('jhaley.web.xmltag');
    	$region = JhaRequest::getVar('region', '');
    	$isModule = $region == '';
    	$xmlchilds = $this->toXMLObject(simplexml_load_string($_SESSION['themeXML']));
    	$xml = new XmlTag('content');
    	foreach ($xmlchilds as $xmlchild) {
    		$xml->add($xmlchild);
    	}
    	$xml = $this->reorderRemoving($region, $isModule, $xml);
        $_SESSION['themeXML'] = $xml->xml();
    	$_SESSION['themeHTML'] = '<div id="jhamaincontent">' . $this->toHTMLObject(simplexml_load_string($_SESSION['themeXML'])) . '</div>';
    	$this->redirect('index.php?elem=mod_base&controller=theme&task=personalizeTheme');
    }
    
    private function reorderRemoving($region, $isModule, $xml){
    	$elem = $this->findChild($region, $isModule, $xml);
    	$parent = $elem->getParent()->getParent();
    	$parent->remove($elem->getParent());
    	$childs = $parent->getContents();
    	$count = count($childs);
    	if($count > 2){
    		$percent = 100 / ($count - 1);
    		for ($i = 0 ; $i < $count - 1; $i++) {
    			$attr = $childs[$i]->getAttributes();
    			if(strpos($attr['style'], '%') !== FALSE){
    				$childs[$i]->setAttribute('style', 'float:left; width:' . $percent . '%;');
    			}
    		}
    	}
    	elseif ($count == 2){
    		$attr = $childs[0]->getAttributes();
			if(strpos($attr['style'], '%') !== FALSE){
				$jhadoc = $childs[0]->getContents();
				$node = $jhadoc[0];
				$node->setParent(null);
				$parent->removeAll();
				$parent->add($node);
			}
    	}
    	return $xml;
    }
    
	private function toHTMLObject($xml){
		$res = '';
    	foreach ($xml->elem as $elem) {
    		$res .= '<div' . $this->getHTMLAttributes($elem->attributes()) . '>';
   			if(isset($elem->elem)) {
   				$res .= $this->toHTMLObject($elem);
   			}
   			elseif(isset($elem->jhadoc)) {
   				$res .= $this->toHTMLObject($elem);
   			}
   			$res .= '</div>';
   		}
   		if(isset($xml->jhadoc)){
   			foreach ($xml->jhadoc as $jhadoc) {
   				$res .= '<jhadoc:include' . $this->getHTMLAttributes($jhadoc->attributes()) . ' />';
   			}
   		}
    	return $res;
    }
    
    private function toXMLObject($xml){
    	jhaimport('jhaley.web.xmltag');
    	$res = array();
    	foreach ($xml->children() as $elem) {
    		$aux = $this->getXMLAttributes($elem->attributes(), $elem->getName());
   			if(count($elem->children()) > 0) {
   				$childs = $this->toXMLObject($elem);
   				foreach ($childs as $child){
   					$aux->add($child);
   				}
   			}
   			$res[] = $aux;
   		}
    	return $res;
    }
    
    private function divide($isRows, $elem){
    	jhaimport('jhaley.web.xmltag');
    	if($isRows) {
    		$parent = $elem->getParent()->getParent();
    		$contenido = $parent->getContents();
    		//$elem->getParent()->setAttribute('style', 'float:left; width:50%;');
    		$pos = JhaUtility::inArray($elem->getParent(), $contenido);
    		$aux = new XmlTag('elem', $jhadoc = new XmlTag('jhadoc'));
    		//$aux->setAttribute('style', 'float:left; width:50%;');
    		$jhadoc->setAttribute('type', 'block');
    		$jhadoc->setAttribute('region', 'region' . mktime());
    		$parent->addPosition($aux, $pos);
    	}
    	else {
    		$percent = round(100 / intval(JhaRequest::getVar('cols')));
    		$parent = $elem->getParent();
    		$parent->remove($elem);
    		$elem->setParent(null);
    		$parent->add($aux = new XmlTag('elem'));
    		$aux->setAttribute('style', 'float:left; width:' . $percent . '%;');
    		$aux->add($elem);
    		for ($i = 1 ; $i < intval(JhaRequest::getVar('cols')); $i++) {
    			$parent->add($elem = new XmlTag('elem', $jhadoc = new XmlTag('jhadoc')));
	    		$elem->setAttribute('style', 'float:left; width:' . $percent . '%;');
	    		$jhadoc->setAttribute('type', 'block');
	    		$jhadoc->setAttribute('region', 'region' . (mktime() + $i));
    		}
    		$parent->add($elem = new XmlTag('elem'));
    		$elem->setAttribute('style', 'clear:both;');
    	}
    }
    
    private function findChild($region, $isModule, $xml){
    	$elem = null;
    	foreach ($xml->getContents() as $child) {
    		$attr = $child->getAttributes();
    		if(!$isModule && $attr['region'] == $region){
   				$elem = $child;
   				break;
   			}
   			elseif ($isModule && $attr['type'] == 'module'){
   				$elem = $child;
   				break;
   			}
   			else {	
   				$elem = $this->findChild($region, $isModule, $child);
   				if($elem != null)	break;
   			}
    	}
    	return $elem;
    }
    
	private function getXMLAttributes($attributes, $elem){
		jhaimport('jhaley.web.xmltag');
    	$res = new XmlTag($elem);
    	if(count($attributes) > 0){
    		foreach ($attributes as $index => $value){
   			    $res->setAttribute($index, $value . "");
    		}
    	}
    	return $res;
    }
    
	private function getHTMLAttributes($attributes) {
    	$res = '';
    	if(count($attributes) > 0){
    		foreach ($attributes as $index => $value){
   			    $res .= ' ' . $index . '="' . $value . '"';
    		}
    	}
    	return $res;
    }
    
    public function changeRegionName(){
    	$newregion = JhaRequest::getVar('newregion');
    	$oldregion = JhaRequest::getVar('oldregion');
    	$_SESSION['themeXML'] = str_replace($oldregion, $newregion, $_SESSION['themeXML']);
    	$_SESSION['themeHTML'] = str_replace($oldregion, $newregion, $_SESSION['themeHTML']);
    }
    
    public function setThemeAttribute(){
    	$region = JhaRequest::getVar('region');
    	$attr = JhaRequest::getVar('attribute');
    	$val = JhaRequest::getVar('value');
    	$xmlchilds = $this->toXMLObject(simplexml_load_string($_SESSION['themeXML']));
    	$xml = new XmlTag('content');
    	foreach ($xmlchilds as $xmlchild) {
    		$xml->add($xmlchild);
    	}
    	$elem = $this->findChild($region, $region == '', $xml);
    	$parent = $elem->getParent();
    	$parent->setAttribute($attr, $val);
    	$_SESSION['themeXML'] = $xml->xml();
    	$_SESSION['themeHTML'] = $this->toHTMLObject(simplexml_load_string($_SESSION['themeXML']));
    }
    
    public function changeMainContent() {
    	$region = JhaRequest::getVar('region');
    	$xmlchilds = $this->toXMLObject(simplexml_load_string($_SESSION['themeXML']));
    	$xml = new XmlTag('content');
    	foreach ($xmlchilds as $xmlchild) {
    		$xml->add($xmlchild);
    	}
    	$elemRegion = $this->findChild($region, $region == '', $xml);
    	$elemModule = $this->findChild('', true, $xml);
    	$elemRegion->removeAttribute('', true);
    	$elemModule->removeAttribute('', true);
    	$elemRegion->setAttribute('type', 'module');
    	$elemModule->setAttribute('type', 'block');
    	$elemModule->setAttribute('region', 'region' . mktime());
    	$_SESSION['themeXML'] = $xml->xml();
    	$_SESSION['themeHTML'] = $this->toHTMLObject(simplexml_load_string($_SESSION['themeXML']));
    }
    
    public function savePersonalizedChanges(){
    	$model = &$this->getModel('theme');
    	$obj = $model->getDefaultTheme();
    	if($model->storeTheme()) {
    		$xml = $this->getThemeInfo(simplexml_load_file(JHA_THEMES_PATH.DS.$obj->nombre.DS.'info.xml'), $this->getRegions($_SESSION['themeXML']));
    		jhaimport('jhaley.file.file');
    		$file = new JhaFile(JHA_THEMES_PATH.DS.$obj->nombre.DS.'info.xml', $xml->xml());
    		$file->write();
    		unset($_SESSION['themeXML']);
	    	unset($_SESSION['themeHTML']);
	    	$this->redirect();
    	}
    }
    
    private function getThemeInfo($xml, $regions = array()){
    	jhaimport('jhaley.web.xmltag');
    	$res = new XmlTag('template', $info = new XmlTag('info'));
    	$info->add(new XmlTag('name', $xml->info->name . ''));
    	$info->add(new XmlTag('description', $xml->info->description . ''));
    	$info->add(new XmlTag('author', $xml->info->author.''));
    	$info->add(new XmlTag('date', $xml->info->date.''));
    	$res->add($regs = new XmlTag('regions'));
    	foreach ($regions as $reg) {
    		$regs->add(new XmlTag('region', $reg));
    	}
    	return $res;
    }
    
    private function getRegions($themeXML){
    	$res = array();
        $matches = array();
        if(preg_match_all('#region="([^"]+)"#iU', $themeXML, $matches)) {
            for($i = 0; $i < count($matches[1]); $i++) {
                $res[] = $matches[1][$i];
            }
        }
        return $res;
    }
    
    public function cancelPersonalizedChanges(){
    	unset($_SESSION['themeXML']);
    	unset($_SESSION['themeHTML']);
    	$this->redirect();
    }
}
?>