<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
?>
<div><?php echo $this->controls; ?></div>
<div>
    <form action="index.php" method="post" name="adminForm">
        <table class="adminlist" cellspacing="1">
            <thead>
                <tr>
                    <th width="5"><input type="checkbox" name="toggle" id="cb" value="" onclick="javascript:Jha.html.checkbox.checkAll(this, 'cb');" /></th>
                    <th class="title">ID</th>
                    <th nowrap="nowrap">Titulo</th>
                    <th nowrap="nowrap">Region</th>
                    <th nowrap="nowrap">Orden</th>
                    <th nowrap="nowrap">Renderizador</th>
                    <th nowrap="nowrap">Acceso</th>
                    <th nowrap="nowrap">Parametros Adicionales</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $k = 0;
                for ($i=0 ; $i < count( $this->blocks ); $i++) {  
                    $row = &$this->blocks[$i];
                    $checked = JhaHTML::tagHTML( 'input', array('name'=>'id[]', 'type'=>'checkbox', 'value'=>$row->id, 'id'=>'cb' . $i, 'onclick'=>'javascript:Jha.html.checkbox.isChecked(this);') );
                    $link = 'index.php?elem=mod_base&controller=block&task=editblock&id='. $row->id . '&itemid=' . $this->itemid;
                ?>
                <tr class="<?php echo "row$k"; ?>">
                    <td><?php echo $checked; ?></td>
                    <td><?php echo $row->id; ?></td>
                    <td><a href="<?php echo $link; ?>"><?php echo $row->titulo; ?></a></td>
                    <td><a href="<?php echo $link; ?>"><?php echo $row->region; ?></a></td>
                    <td><a href="<?php echo $link; ?>"><?php echo $row->orden; ?></a></td>
                    <td><a href="<?php echo $link; ?>"><?php echo $row->renderizador; ?></a></td>
                    <td><a href="<?php echo $link; ?>"><?php echo ($row->needlogin == 0 ? 'Libre' : 'Restringido'); ?></a></td>
                    <td><a href="<?php echo $link; ?>"><?php echo $row->params; ?></a></td>
                </tr>
                <?php
                    $k = 1 - $k;
                }
                ?>
            </tbody>
        </table>
        <input type="hidden" name="elem" id="elem" value="mod_base" />
        <input type="hidden" name="controller" id="controller" value="block" />
        <input type="hidden" name="task" id="task" value="" />
    </form>
</div>