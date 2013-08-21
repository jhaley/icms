<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
echo JhaHTML::script('modules/mod_content/extras/new.js');
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
                            <label>Noticia:</label>
                        </td>
                        <td>
                            <textarea name="contenido" id="contenido" rows="4"><?php echo $this->noticia->contenido; ?></textarea>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
        <div class="clr"></div>
        <input type="hidden" value="mod_content" name="elem" id="elem" />
        <input type="hidden" value="new" name="controller" id="controller" />
        <input type="hidden" value="<?php echo ($this->noticia ? $this->noticia->id : '0'); ?>" name="id" id="id" />
        <input type="hidden" value="" name="task" id="task" />
    </form>
</div>