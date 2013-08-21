<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );

require_once $this->blocktypepath.DS.'helper.php';
//newschange -> vertical, horizontal, overlay
$helper = new JhaNewHelper(array('showtitle' => '1' ,'newschange' => 'noneffect', 'suffix' => ''));

$params = array();
$params['showtitle'] = array('', 'checked="checked"');
$params['newschange'] = array('checked="checked"', '', '', '');
$params['suffix'] = '';

if($blockparams != NULL){
	$params['showtitle'] = array(($blockparams['showtitle'] == '0' ? 'checked="checked"' : ''), ($blockparams['showtitle'] == '1' ? 'checked="checked"' : ''));
	$params['newschange'] = array(($blockparams['newschange'] == 'noneffect' ? 'selected="selected"' : ''), ($blockparams['newschange'] == 'overlay' ? 'selected="selected"' : ''), ($blockparams['newschange'] == 'vertical' ? 'selected="selected"' : ''), ($blockparams['newschange'] == 'horizontal' ? 'selected="selected"' : ''));
	$params['suffix'] = $blockparams['suffix'];
}
?>
<fieldset>
    <legend>Parametros del Bloque</legend>
    <table cellspacing="1" width="100%" class="">
        <tr>
            <td width="40%" class="paramlist_key">
                <label>Mostrar t&iacute;tulo</label>
            </td>
            <td class="paramlist_value">
                <input type="radio" <?php echo $params['showtitle'][0] ?> value="0" id="params_showtitle0" name="params_showtitle">
                <label for="params_showtitle0">No</label>
                <input type="radio" <?php echo $params['showtitle'][1] ?> value="1" id="params_showtitle1" name="params_showtitle">
                <label for="params_showtitle1">S&iacute;</label>
            </td>
        </tr>
        <tr>
            <td width="40%" class="paramlist_key">
                <label>Efecto de Intercambio de las Noticias</label>
            </td>
            <td class="paramlist_value">
                <select name="params_newschange" id="params_newschange">
                	<option value="noneffect" <?php echo $params['newschange'][0]; ?>>Ninguno</option>
                	<option value="overlay" <?php echo $params['newschange'][1]; ?>>Sobreponer</option>
                	<option value="vertical" <?php echo $params['newschange'][2]; ?>>Vertical</option>
                	<!-- <option value="horizontal" <?php echo $params['newschange'][3]; ?>>Horizontal</option> -->
                </select>
            </td>
        </tr>
		<tr>
            <td width="40%" class="paramlist_key">
                <label>Sufijo de la clase CSS</label>
            </td>
            <td class="paramlist_value">
                <input type="text" value="<?php echo $params['suffix']; ?>" id="params_suffix" name="params_suffix">
            </td>
        </tr>
    </table>
</fieldset>