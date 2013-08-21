<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );

require_once $this->blocktypepath.DS.'helper.php';
$helper = new JhaBannerHelper(array('showtitle' => '1' ,'bannerchange' => 'none', 'suffix' => ''));

$params = array();
$params['showtitle'] = array('', 'checked="checked"');
$params['bannerchange'] = array('checked="checked"', '', '', '');
$params['directory'] = 'images';
$params['imageheight'] = '120';
$params['imagewidth'] = '300';
$params['suffix'] = '';

if($blockparams != NULL){
	$params['showtitle'] = array(($blockparams['showtitle'] == '0' ? 'checked="checked"' : ''), ($blockparams['showtitle'] == '1' ? 'checked="checked"' : ''));
	$params['bannerchange'] = array(($blockparams['bannerchange'] == 'none' ? 'selected="selected"' : ''),($blockparams['bannerchange'] == 'overlay' ? 'selected="selected"' : ''), ($blockparams['bannerchange'] == 'vertical' ? 'selected="selected"' : ''), ($blockparams['bannerchange'] == 'horizontal' ? 'selected="selected"' : ''));
	$params['directory'] = $blockparams['directory'];
	$params['imageheight'] = $blockparams['imageheight'];
	$params['imagewidth'] = $blockparams['imagewidth'];
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
                <label>Efecto de Intercambio de las Imagenes</label>
            </td>
            <td class="paramlist_value">
                <select name="params_bannerchange" id="params_bannerchange">
                	<option value="none" <?php echo $params['bannerchange'][0]; ?>>Ninguno</option>
                	<option value="overlay" <?php echo $params['bannerchange'][1]; ?>>Sobreponer</option>
                	<option value="vertical" <?php echo $params['bannerchange'][2]; ?>>Vertical</option>
                	<!-- <option value="horizontal" <?php echo $params['bannerchange'][3]; ?>>Horizontal</option> -->
                </select>
            </td>
        </tr>
		<tr>
            <td width="40%" class="paramlist_key">
                <label>Directorio de las Imagenes</label>
            </td>
            <td class="paramlist_value">
                <input type="text" value="<?php echo $params['directory']; ?>" id="params_directory" name="params_directory" readonly="readonly">
                <a href="javascript:;" onclick="javascript:selectFolder();"><img src="images/select.jpg" title="Seleccionar" /></a>
            </td>
        </tr>
        <tr>
            <td width="40%" class="paramlist_key">
                <label>Dimensiones de las Imagenes</label>
            </td>
            <td class="paramlist_value">
            	<label for="params_imagewidth">Ancho (px):</label>
                <input size="3" type="text" value="<?php echo $params['imagewidth']; ?>" id="params_imagewidth" name="params_imagewidth">
                <label for="params_imageheight">Alto (px):</label>
                <input size="3" type="text" value="<?php echo $params['imageheight']; ?>" id="params_imageheight" name="params_imageheight">
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