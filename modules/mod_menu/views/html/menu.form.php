<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
echo JhaHTML::script('modules/mod_menu/extras/menu.js');
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
                            <label>T&iacute;tulo:</label>
                        </td>
                        <td>
                            <input type="text" size="35" id="titulo" name="titulo" value="<?php echo $this->menu->titulo; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Descripci&oacute;n:</label>
                        </td>
                        <td>
                            <textarea id="descripcion" name="descripcion" cols="27" rows="4"><?php echo $this->menu->descripcion; ?></textarea>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
        <div class="clr"></div>
        <input type="hidden" value="mod_menu" name="elem" id="elem" />
        <input type="hidden" value="<?php echo ($this->menu ? $this->menu->id : '0'); ?>" name="id" id="id" />
        <input type="hidden" value="" name="task" id="task" />
    </form>
</div>