<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
$activo = $this->usuario->estado == 'Inactivo' ? false : true;
echo JhaHTML::script('modules/mod_user/extras/user.js');
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
                            <label>Nombre real:</label>
                        </td>
                        <td>
                            <input type="text" id="nombre" name="nombre" value="<?php echo $this->usuario->nombre; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="40%" class="paramlist_key">
                            <label>Nombre de Usuario:</label>
                        </td>
                        <td>
                            <input type="text" id="usuario" name="usuario" value="<?php echo $this->usuario->usuario; ?>" onblur="javascript:isUniqueName(this.value);" />
                            <div id="user_msg"></div>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="40%" class="paramlist_key">
                            <label>Contrase&ntilde;a:</label>
                        </td>
                        <td>
                            <input type="password" id="contrasenia" name="contrasenia" value="<?php echo $this->usuario->contrasenia; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="40%" class="paramlist_key">
                            <label>Repetir contrase&ntilde;a:</label>
                        </td>
                        <td>
                            <input type="password" id="rcontrasenia" name="rcontrasenia" value="<?php echo $this->usuario->contrasenia; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Estado:</label>
                        </td>
                        <td>
                            <input type="radio" <?php echo !$activo ? 'checked="checked"' : ''; ?> value="Inactivo" id="estado0" name="estado">
			                <label for="estado0">Inactivo</label>
			                <input type="radio" <?php echo $activo ? 'checked="checked"' : ''; ?> value="Activo" id="estado1" name="estado">
			                <label for="estado1">Activo</label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Rol:</label>
                        </td>
                        <td>
                            <select name="rol" id="rol">
                                <?php foreach ($this->roles as $rol) { ?>
                                <option value="<?php echo $rol->id; ?>" <?php echo ($rol->nombre == $this->usuario->rol ? 'selected="selected"' : ''); ?>><?php echo $rol->nombre; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
        <div class="clr"></div>
        <input type="hidden" value="mod_user" name="elem" id="elem" />
        <input type="hidden" value="<?php echo ($this->usuario ? $this->usuario->id : '0'); ?>" name="id" id="id" />
        <input type="hidden" value="" name="task" id="task" />
    </form>
</div>