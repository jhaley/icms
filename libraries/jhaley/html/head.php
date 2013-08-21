<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
jhaimport('jhaley.base.object');

class JhaRendererHead extends JhaObject {
    public function render(){
        $content = '';
        $GLOBALS['JHA_HEAD_VARS'] = (isset($GLOBALS['JHA_HEAD_VARS'][0]) ? $GLOBALS['JHA_HEAD_VARS'] : array());
        if(JhaUtility::userCanEdit()){
        	$GLOBALS['JHA_HEAD_VARS'] = array_reverse($GLOBALS['JHA_HEAD_VARS']);
        	$GLOBALS['JHA_HEAD_VARS'][] = JhaHTML::script('libraries/jhaley/js/menu.js');
        	$GLOBALS['JHA_HEAD_VARS'][] = JhaHTML::script('libraries/jhaley/js/popup.js');
        	$GLOBALS['JHA_HEAD_VARS'][] = JhaHTML::script('libraries/jhaley/js/pmenu.js');
        	$GLOBALS['JHA_HEAD_VARS'][] = JhaHTML::script('libraries/jhaley/js/effect.js');
        	$GLOBALS['JHA_HEAD_VARS'][] = JhaHTML::script('libraries/jhaley/js/drag.js');
        	$GLOBALS['JHA_HEAD_VARS'][] = JhaHTML::script('libraries/jhaley/js/ajax.js');
	        $GLOBALS['JHA_HEAD_VARS'][] = JhaHTML::script('libraries/jhaley/js/jha.js');
	        $GLOBALS['JHA_HEAD_VARS'][] = JhaHTML::stylesheet('libraries/jhaley/css/menu.css');
	        $GLOBALS['JHA_HEAD_VARS'][] = JhaHTML::stylesheet('libraries/jhaley/css/base.css');
	        $GLOBALS['JHA_HEAD_VARS'] = array_reverse($GLOBALS['JHA_HEAD_VARS']);
        }
        else{
        	$GLOBALS['JHA_HEAD_VARS'] = array_reverse($GLOBALS['JHA_HEAD_VARS']);
        	$GLOBALS['JHA_HEAD_VARS'][] = JhaHTML::script('libraries/jhaley/js/effect.js');
	        $GLOBALS['JHA_HEAD_VARS'][] = JhaHTML::script('libraries/jhaley/js/jha.js');
	        $GLOBALS['JHA_HEAD_VARS'] = array_reverse($GLOBALS['JHA_HEAD_VARS']);
        }
        if(isset($GLOBALS['JHA_HEAD_VARS']) && count($GLOBALS['JHA_HEAD_VARS']) > 0){
        	$this->cleanHeadVars();
            $content .= implode('',$GLOBALS['JHA_HEAD_VARS']);
        }
        return $content;
    }
    
    protected function cleanHeadVars(){
    	$array = array();
    	foreach ($GLOBALS['JHA_HEAD_VARS'] as $headVar){
    		if (JhaUtility::inArray($headVar, $array) == -1) {
    			$array[] = $headVar;
    		}
    	}
    	$GLOBALS['JHA_HEAD_VARS'] = $array;
    }
}
?>