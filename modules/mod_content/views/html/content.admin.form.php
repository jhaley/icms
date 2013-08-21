<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
$publicado = $this->articulo->estado == 'No Publicado' ? false : true;
$predeterminado = $this->articulo->home == '1' ? true : false;
$editor = &JhaFactory::getEditor();
echo JhaHTML::script('modules/mod_content/extras/content.js');
?>
<div><?php echo $this->controls; ?></div>
<div>
    <form name="adminForm" method="post" action="index.php">
        <div class="col width-100">
            <fieldset class="adminform">
                <legend>Detalles</legend>
                <table cellspacing="1" width="100%" class="">
                    <tr>
                        <td valign="top" width="40%" class="paramlist_key">
                            <label>T&iacute;tulo:</label>
                        </td>
                        <td>
                            <input type="text" id="titulo" name="titulo" value="<?php echo $this->articulo->titulo; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Estado:</label>
                        </td>
                        <td>
                            <input type="radio" <?php echo !$publicado ? 'checked="checked"' : ''; ?> value="No Publicado" id="estado0" name="estado">
			                <label for="estado0">No Publicado</label>
			                <input type="radio" <?php echo $publicado ? 'checked="checked"' : ''; ?> value="Publicado" id="estado1" name="estado">
			                <label for="estado1">Publicado</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Predeterminado:</label>
                        </td>
                        <td>
                            <input type="radio" <?php echo !$predeterminado ? 'checked="checked"' : ''; ?> value="0" id="home0" name="home">
			                <label for="home0">No</label>
			                <input type="radio" <?php echo $predeterminado ? 'checked="checked"' : ''; ?> value="1" id="home1" name="home">
			                <label for="home1">S&iacute;</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Secci&oacute;n:</label>
                        </td>
                        <td>
                            <select name="seccion" id="seccion">
                                <?php foreach ($this->secciones as $seccion) { ?>
                                <option value="<?php echo $seccion->id; ?>" <?php echo ($seccion->id == $this->articulo->seccion ? 'selected="selected"' : ''); ?>><?php echo $seccion->nombre; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Enlace en el men&uacute;:</label>
                        </td>
                        <td>
                            <select name="menu" id="menu">
                            	<option value="x">- Ninguno -</option>
                                <?php foreach ($this->menus as $menu) { ?>
                                <option value="<?php echo $menu->id; ?>" <?php echo ($menu->id == $this->menu ? 'selected="selected"' : ''); ?>><?php echo $menu->titulo; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <fieldset>
            	<legend>Contenido</legend>
            	<?php echo ($this->articulo->contenido != '' ? $editor->editor('contenido',$this->articulo->contenido) : $editor->editor('contenido', '')); ?>
            </fieldset>
        </div>
        <div class="clr"></div>
        <input type="hidden" value="mod_content" name="elem" id="elem" />
        <input type="hidden" value="content" name="controller" id="controller" />
        <input type="hidden" value="<?php echo ($this->articulo ? $this->articulo->id : '0'); ?>" name="id" id="id" />
        <input type="hidden" value="" name="task" id="task" />
    </form>
</div>