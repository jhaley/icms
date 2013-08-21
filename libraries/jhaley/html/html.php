<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.base.object');

class JhaHTML extends JhaObject {
    
    public static function stylesheet($url){
    	jhaimport('jhaley.web.tags');
        $taghtml = new Tag ('link');
        $taghtml->setAttribute('type', 'text/css');
        $taghtml->setAttribute('rel', 'stylesheet');
        $taghtml->setAttribute('href', $url);
        return $taghtml->html ();
    }
    
    public static function script($src, $isUrl = true){
    	jhaimport('jhaley.web.jstag');
        $tagjs = new JSTag ();
        if($isUrl){
            $tagjs->setAttribute('type', 'text/javascript');
            $tagjs->setAttribute('src', $src);
        }
        else{
            $tagjs->add($src);
        }
        return $tagjs->html ();
    }
    
    public function title($title = ''){
    	jhaimport('jhaley.web.tags');
    	$taghtml = new Tag ('title', $title);
    	return $taghtml->html ();
    }
    
    //array-> titulos, tasks, linktype**, icons.  
    // ** -> Para la validacion de los checkboxes.
    public function renderControls($titles, $tasks, $linktypes, $icons){
    	if(count($titles) <= 0 && count($tasks) <= 0 && count($linktypes) <= 0) return '';
    	jhaimport('jhaley.web.tags');
    	$tagtable = new Tag ('table');
    	$tagtable -> add( $tagtr = new Tag('tr') );
        for($i = 0; $i < count($titles); $i++){
        	$mustValidate = $linktypes[$i] == 'edit' || $linktypes[$i] == 'delete' || $linktypes[$i] == 'save';
        	$onclick = '';
        	if($mustValidate) {
        		$condicion = ($linktypes[$i] == 'edit' || $linktypes[$i] == 'delete' ? 'Jha.html.checkbox.validate()' : 'validateForm()');
        		$onclick = 'if(' . $condicion . '){Jha.dom.$(\'task\').value = \'' . $tasks[$i] . '\'; document.forms.adminForm.submit();}';
        	}
        	else {
        		$onclick = 'Jha.dom.$(\'task\').value = \'' . $tasks[$i] . '\'; document.forms.adminForm.submit();';
        	}
            if($icons != null && $icons[$i] != null){
            	$tagicon = new Tag('img');
            	$tagicon->setAttribute('src', $icons[$i]);
            	$tagicon->setAttribute('title', $titles[$i]);
            }
            else{
            	$tagicon = new Tag('span');
            	$tagicon -> setAttribute('class', 'icon-' . $linktypes[$i]);
            	$tagicon -> setAttribute('title', $titles[$i]);
            }
            $tagtr -> add( $tagtd = new Tag('td') );
            $tagtd -> add( $taga = new Tag('a') );
            $taga -> setAttribute('href', 'javascript:;');
            $taga -> setAttribute('onclick', 'javascript:' . $onclick);
            $taga -> add( $tagicon );
            $taga -> add( $titles[$i] );
        }
        return $tagtable->html ();
    }
    
    public function tagHTML($tag = 'p', $extras = array()) {
    	jhaimport('jhaley.web.tags');
        $taginput = new Tag ('input');
        foreach ($extras as $index => $value) {
        	$taginput->setAttribute($index, $value);
        }
        return $taginput->html ();
    }
}
?>