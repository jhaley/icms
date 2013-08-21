<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
$editor = &JhaFactory::getEditor();
echo JhaHTML::script('modules/mod_base/extras/block.js');

$blockmenutype = 'all'; //all, none, any
if(isset($this->block)){
	switch (count($this->menublocks)) {
		case 0: 
			$blockmenutype = 'none';
		break;
		default: 
			$blockmenutype = ($this->menublocks[0] == '0' ? 'all' : 'any');
	}
}
$initLoadOrder = $this->region != null;
?>
<div><?php echo $this->controls; ?></div>
<div>
    <form name="adminForm" method="post" action="index.php">
        <div class="col width-50">
            <fieldset class="adminform">
                <legend>Detalles</legend>
                <table cellspacing="1" width="100%" class="">
                    <tr>
                        <td valign="top" width="40%" class="paramlist_key">
                            <label>Bloque:</label>
                        </td>
                        <td>
                            <select name="renderizador" id="renderizador" onchange="javascript:loadParamenters();">
                                <option value="x">- Seleccionar -</option>
                                <?php foreach ($this->blocktypes as $blocktype) { ?>
                                <option value="<?php echo $blocktype->renderer; ?>" <?php echo ($blocktype->renderer == $this->block->renderizador ? 'selected="selected"' : ''); ?>><?php echo $blocktype->name; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>T&iacute;tulo:</label>
                        </td>
                        <td>
                            <input type="text" size="35" id="titulo" name="titulo" value="<?php echo $this->block->titulo; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Region:</label>
                        </td>
                        <td>
                            <select id="region" name="region" onchange="javascript:loadOrder();">
                                <option value="x">- Seleccionar -</option>
                                <?php foreach ($this->regions as $region) { ?>
                                <option value="<?php echo $region; ?>" <?php echo ($region == $this->block->region || $this->region == $region ? 'selected="selected"' : ''); ?>><?php echo $region; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Posici&oacute;n:</label>
                        </td>
                        <td>
                            <select id="orden" name="orden">
                                <?php echo (isset($this->orders) ? $this->orders : ''); ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Nivel de acceso:</label>
                        </td>
                        <td>
                            <select id="needlogin" name="needlogin">
                                <option <?php echo ($this->block->needlogin == '0' ? 'selected="selected"' : ''); ?> value="0">P&uacute;blico</option>
                                <option <?php echo ($this->block->needlogin == '1' ? 'selected="selected"' : ''); ?> value="1">Registrado</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>ID:</label>
                        </td>
                        <td>
                            <?php echo ($this->block ? $this->block->id : '0'); ?>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <fieldset id="contenidoHTML">
            	<legend>HTML Personalizado</legend>
		    	<?php echo ($this->block->contenido != '' ? $editor->editor('contenido',$this->block->contenido) : $editor->editor('contenido', '')); ?>
		    	<script>
		    		setTimeout("initEditor();", 2000);
		    	</script>
            </fieldset>
            <fieldset class="adminform">
                <legend>Relaci&oacute;n con el men&uacute;</legend>
                <table cellspacing="1" width="100%" class="">
                    <tr>
                        <td valign="top" width="40%" class="paramlist_key">
                            <label>Men&uacute;s:</label>
                        </td>
                        <td>
                            <label for="menus-all">
                                <input type="radio" <?php echo ($blockmenutype == 'all' ? 'checked="checked"' : ''); ?> onclick="javascript:allselections();" value="all" name="menus" id="menus-all">
                                Todo
                            </label>
                            <label for="menus-none">
                                <input type="radio" <?php echo ($blockmenutype == 'none' ? 'checked="checked"' : ''); ?> onclick="javascript:disableselections();" value="none" name="menus" id="menus-none">
                                Ninguno
                            </label>
                            <label for="menus-select">
                                <input type="radio" <?php echo ($blockmenutype == 'any' ? 'checked="checked"' : ''); ?> onclick="javascript:enableselections();" value="select" name="menus" id="menus-select">
                                Selecci&oacute;n arbitraria
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Selecci&oacute;n:</label>
                        </td>
                        <td>
                            <select multiple="multiple" size="<?php echo $this->itemscount; ?>" id="selections" name="selections[]" <?php echo ($blockmenutype != 'any' ? 'disabled="disabled"' : ''); ?>>
                                <?php foreach ($this->menus as $menu) { ?>
                                <optgroup label="<?php echo $menu->menu->titulo; ?>">
                                    <?php foreach ($menu->items as $item) {
                                    	$disabled = ($blockmenutype != 'any' ? 'disabled="disabled"' : '');
                                    	$selected = '';
                                    	switch ($blockmenutype) {
                                    		case 'all':
                                    		    $selected = 'selected="selected"';
                                    		break;
                                    		case 'any':
                                    			$selected = (JhaUtility::inArray($item->id, $this->menublocks) != -1 ? 'selected="selected"' : '');
                                    	    break;
                                    	}
                                    ?>
                                    <option <?php echo $disabled; ?> <?php echo $selected; ?> value="<?php echo $item->id; ?>"><?php echo $item->nombre; ?></option>
                                    <?php } ?>
                                </optgroup>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                </table>
                <?php if(!isset($this->block)){ ?>
                <script type="text/javascript">allselections();</script>
                <?php } ?>
            </fieldset>
        </div>
        <div class="col width-50" id="parameters-block">
            <?php echo (isset($this->block) ? $this->parameters : ''); ?>
        </div>
        <div class="clr"></div>
        <input type="hidden" value="mod_base" name="elem" id="elem" />
        <input type="hidden" value="block" name="controller" id="controller" />
        <input type="hidden" value="<?php echo ($this->block ? $this->block->id : '0'); ?>" name="id" id="id" />
        <input type="hidden" value="" name="task" id="task" />
    </form>
</div>
<script>
	loadOrder();
</script>