<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
$selectedLast = count($this->secciones) == 0 || JhaRequest::getVar('task') == 'newsection';
echo JhaHTML::script('modules/mod_content/extras/section.js');
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
                            <label>Nombre:</label>
                        </td>
                        <td>
                            <input type="text" id="nombre" name="nombre" value="<?php echo $this->seccion->nombre; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Tipo:</label>
                        </td>
                        <td>
                            <select id="tipo" name="tipo">
                            	<option value="Estandar" <?php echo $this->seccion->tipo == 'Estandar' ? 'selected="selected"' : ''; ?>>Estandar</option>
                            	<!-- <option value="Dos Columnas" <?php echo $this->seccion->tipo == 'Dos Columnas' ? 'selected="selected"' : ''; ?>>Dos Columnas</option>
                            	<option value="Una Columna" <?php echo $this->seccion->tipo == 'Una Columna' ? 'selected="selected"' : ''; ?>>Una Columna</option> -->
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
        </div>
        <div class="clr"></div>
        <input type="hidden" value="mod_content" name="elem" id="elem" />
        <input type="hidden" value="section" name="controller" id="controller" />
        <input type="hidden" value="<?php echo ($this->seccion ? $this->seccion->id : '0'); ?>" name="id" id="id" />
        <input type="hidden" value="" name="task" id="task" />
    </form>
</div>