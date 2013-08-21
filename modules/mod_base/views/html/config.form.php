<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
echo JhaHTML::script('modules/mod_base/extras/config.js');
?>
<div><?php echo $this->controls; ?></div>
<div>
    <form name="adminForm" method="post" action="index.php">
        <div class="col width-50">
            <fieldset class="adminform">
                <legend>Bases de Datos</legend>
                <table cellspacing="1" width="100%" class="">
                    <tr>
                        <td valign="top" width="40%" class="paramlist_key">
                            <label>Servidor: </label>
                        </td>
                        <td>
                            <input type="text" id="db_host" name="db_host" value="<?php echo $this->config->db_host; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Base de Datos:</label>
                        </td>
                        <td>
                            <input type="text" id="db_database" name="db_database" value="<?php echo $this->config->db_database; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Usuario:</label>
                        </td>
                        <td>
                            <input type="text" id="db_user" name="db_user" value="<?php echo $this->config->db_user; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Contrase&ntilde;a:</label>
                        </td>
                        <td>
                            <input type="text" id="db_pass" name="db_pass" value="<?php echo $this->config->db_pass; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Prefijo de las Tablas:</label>
                        </td>
                        <td>
                            <input type="text" id="db_preffix" name="db_preffix" value="<?php echo $this->config->db_preffix; ?>" />
                        </td>
                    </tr>
                </table>
            </fieldset>
            <fieldset class="adminform">
                <legend>Miscelanea</legend>
                <table cellspacing="1" width="100%" class="">
                    <tr>
                        <td valign="top" width="40%" class="paramlist_key">
                            <label>Vigencia de las Noticias: </label>
                        </td>
                        <td>
                            <select id="days_showing_news" name="days_showing_news">
                            	<option value="7" <?php echo $this->config->days_showing_news == '7' ? 'selected="selected"' : ''; ?>>Una Semana</option>
                            	<option value="14" <?php echo $this->config->days_showing_news == '14' ? 'selected="selected"' : ''; ?>>Dos Semanas</option>
                            	<option value="30" <?php echo $this->config->days_showing_news == '30' ? 'selected="selected"' : ''; ?>>Un Mes</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Meta Descripci&oacute;n:</label>
                        </td>
                        <td>
                            <textarea name="meta_desc" id="meta_desc" rows="4"><?php echo $this->config->meta_desc; ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Meta Palabras Clave:</label>
                        </td>
                        <td>
                            <textarea name="meta_keys" id="meta_keys" rows="4"><?php echo $this->config->meta_keys; ?></textarea>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
        <div class="clr"></div>
        <input type="hidden" id="site" name="site" value="<?php echo $this->config->site; ?>" />
        <input type="hidden" id="tmp_path" name="tmp_path" value="<?php echo $this->config->tmp_path; ?>" />
        <input type="hidden" value="mod_base" name="elem" id="elem" />
        <input type="hidden" value="" name="task" id="task" />
    </form>
</div>