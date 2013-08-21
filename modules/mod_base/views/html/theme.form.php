<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
echo JhaHTML::script('modules/mod_base/extras/theme.js');
?>
<div><?php echo $this->controls; ?></div>
<div>
    <form name="adminForm" method="post" action="index.php" enctype="multipart/form-data">
        <div class="col width-50">
            <fieldset class="adminform">
                <legend>Detalles</legend>
                <table cellspacing="1" width="100%" class="">
                    <tr>
                        <td>
                            <label>Nombre de la Plantilla:</label>
                        </td>
                        <td>
                            <input type="text" id="nombre" name="nombre" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Plantilla (*.tgz, *.tbz):</label>
                        </td>
                        <td>
                            <input type="file" id="theme" name="theme" onchange="javascript:changeName(this);" />
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
        <div class="clr"></div>
        <input type="hidden" value="mod_base" name="elem" id="elem" />
        <input type="hidden" value="theme" name="controller" id="controller" />
        <input type="hidden" value="" name="task" id="task" />
    </form>
</div>