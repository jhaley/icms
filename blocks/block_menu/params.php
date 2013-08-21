<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );

require_once $this->blocktypepath.DS.'helper.php';
$helper = new JhaMenuHelper(array('showtitle' => '0', 'id' => '0', 'viewtype' => 'list', 'showicons' => '0', 'iconalign' => 'left', 'suffix' => '')); 
$menus = JhaMenuHelper::getMenus();

$params = array();
$params['showtitle'] = array('', 'checked="checked"');
$params['id'] = '';
$params['viewtype'] = 'list';
$params['showicons'] = array('checked="checked"', '');
$params['iconalign'] = 'left';
$params['suffix'] = '';

if($blockparams != NULL){
	$params['showtitle'] = array(($blockparams['showtitle'] == '0' ? 'checked="checked"' : ''), ($blockparams['showtitle'] == '1' ? 'checked="checked"' : ''));
	$params['id'] = $blockparams['id'];
	$params['viewtype'] = $blockparams['viewtype'];
	$params['showicons'] = array(($blockparams['showicons'] == '0' ? 'checked="checked"' : ''), ($blockparams['showicons'] == '1' ? 'checked="checked"' : ''));
	$params['iconalign'] = $blockparams['iconalign'];
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
                <label>Enlace al Men&uacute;</label>
            </td>
            <td class="paramlist_value">
                <select id="params_id" name="params_id">
                    <option <?php echo ($params['id'] == '' ? 'selected="selected"' : ''); ?> value="">- Seleccionar un men&uacute; -</option>
                    <?php foreach ($menus as $menu) { ?>
                    <option <?php echo ($params['id'] == $menu->id ? 'selected="selected"' : ''); ?> value="<?php echo $menu->id; ?>"><?php echo $menu->titulo; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td width="40%" class="paramlist_key">
                <label>Tipo de men&uacute;</label>
            </td>
            <td class="paramlist_value">
                <select id="params_viewtype" name="params_viewtype">
	                <option <?php echo ($params['viewtype'] == 'list' ? 'selected="selected"' : ''); ?> value="list">Lista</option>
	                <option <?php echo ($params['viewtype'] == 'verticaltable' ? 'selected="selected"' : ''); ?> value="verticaltable">Tablas - Vertical</option>
	                <option <?php echo ($params['viewtype'] == 'horizontaltable' ? 'selected="selected"' : ''); ?> value="horizontaltable">Tablas - Horizontal</option>
                </select>
            </td>
        </tr>
        <tr>
            <td width="40%" class="paramlist_key">
                <label>Mostrar Iconos</label>
            </td>
            <td class="paramlist_value">
                <input type="radio" <?php echo $params['showicons'][0] ?> value="0" id="params_showicons0" name="params_showicons">
			    <label for="params_showicons0">No</label>
			    <input type="radio" <?php echo $params['showicons'][1] ?> value="1" id="params_showicons1" name="params_showicons">
			    <label for="params_showicons1">S&iacute;</label>
            </td>
        </tr>
        <tr>
			<td width="40%" class="paramlist_key">
			    <label>Alineaci&oacute;n de los Iconos</label>
			</td>
			<td class="paramlist_value">
                <select name="params_iconalign" id="params_iconalign">
                    <option <?php echo ($params['iconalign'] == 'left' ? 'selected="selected"' : ''); ?> value="left">Izquierda</option>
                    <option <?php echo ($params['iconalign'] == 'right' ? 'selected="selected"' : ''); ?> value="right">Derecha</option>
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