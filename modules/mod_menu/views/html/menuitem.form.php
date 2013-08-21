<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
$predeterminado = $this->menuitem->home == '1' ? true : false;
$selectedLast = count($this->menuitems) == 0 || JhaRequest::getVar('task') == 'newmenuitem';
echo JhaHTML::script('modules/mod_menu/extras/menuitem.js');
$GLOBALS['JHA_HEAD_VARS'][] = JhaHTML::script('nomenu = function (){return false;}; document.oncontextmenu = nomenu;', false);
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
                            <label>Nombre:</label>
                        </td>
                        <td>
                            <input type="text" id="nombre" name="nombre" value="<?php echo $this->menuitem->nombre; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Enlace:</label>
                        </td>
                        <td>
                            <input type="text" id="enlace_view" name="enlace_view" value="<?php echo $this->enlace_view; ?>" />
                            <a href="javascript:;" oncontextmenu="javascript:showPopupMenu(event);"><img src="images/select.jpg" title="Seleccionar Contenido" /></a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Icono:</label>
                        </td>
                        <td>
                            <select id="icono" name="icono">
                            	<option value="nothing.jpg" <?php echo $this->menuitem->icono == 'nothing.jpg' ? 'selected="selected"' : ''; ?>>nothing.jpg</option>
                            	<option value="home.jpg" <?php echo $this->menuitem->icono == 'home.jpg' ? 'selected="selected"' : ''; ?>>home.jpg</option>
                            	<option value="whoarewe.jpg" <?php echo $this->menuitem->icono == 'whoarewe.jpg' ? 'selected="selected"' : ''; ?>>whoarewe.jpg</option>
                            	<option value="contactus.jpg" <?php echo $this->menuitem->icono == 'contactus.jpg' ? 'selected="selected"' : ''; ?>>contactus.jpg</option>
                            	<option value="services.jpg" <?php echo $this->menuitem->icono == 'services.jpg' ? 'selected="selected"' : ''; ?>>services.jpg</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Orden:</label>
                        </td>
                        <td>
                            <select id="orden" name="orden">
                            <?php foreach ($this->menuitems as $menuitem) { ?>
                            	<option value="<?php echo $menuitem->orden; ?>" <?php echo $menuitem->orden == $this->menuitem->orden ? 'selected="selected"' : ''; ?>><?php echo $menuitem->orden . ' -> ' . $menuitem->nombre; ?></option>
                            <?php } ?>
                            	<option value="<?php echo count($this->menuitems) + 1; ?>" <?php echo $selectedLast ? 'selected="selected"' : ''; ?>><?php echo count($this->menuitems) + 1; ?> -> &Uacute;ltimo</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
			            <td>
			                <label>Predeterminado:</label>
			            </td>
			            <td class="paramlist_value">
			                <input type="radio" <?php echo !$predeterminado ? 'checked="checked"' : ''; ?> value="0" id="home0" name="home">
			                <label for="home0">No</label>
			                <input type="radio" <?php echo $predeterminado ? 'checked="checked"' : ''; ?> value="1" id="home1" name="home">
			                <label for="home1">S&iacute;</label>
			            </td>
			        </tr>
                </table>
            </fieldset>
        </div>
        <div class="clr"></div>
        <input type="hidden" value="mod_menu" name="elem" id="elem" />
        <input type="hidden" value="<?php echo ($this->menuitem ? $this->menuitem->id : '0'); ?>" name="id" id="id" />
        <input type="hidden" id="enlace" name="enlace" value="<?php echo $this->menuitem->enlace; ?>" />
        <input type="hidden" value="<?php echo $this->idmenu; ?>" name="showing" id="showing" />
        <input type="hidden" value="" name="task" id="task" />
    </form>
</div>