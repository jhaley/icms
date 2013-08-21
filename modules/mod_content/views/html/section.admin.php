<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
?>
<div><?php echo $this->controls; ?></div>
<div>
    <form action="index.php" method="post" name="adminForm">
        <table class="adminlist" cellspacing="1">
            <thead>
                <tr>
                    <th width="5"><input type="checkbox" name="toggle" id="cb" value="" onclick="javascript:Jha.html.checkbox.checkAll(this, 'section');" /></th>
                    <th class="title">ID</th>
                    <th class="title">Nombre</th>
                    <th class="title">Tipo</th>
                    <th class="title">Orden</th>
                    <th class="title">Creador</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $k = 0;
                for ($i=0 ; $i < count( $this->secciones ); $i++) {  
                    $row = &$this->secciones[$i];
                    $checked = JhaHTML::tagHTML( 'input', array('name'=>'id[]', 'type'=>'checkbox', 'value'=>$row->id, 'id'=>'section' . $i, 'onclick'=>'javascript:Jha.html.checkbox.isChecked(this);') );
                    $link = 'index.php?elem=mod_content&controller=section&task=editsection&id='. $row->id;
                ?>
                <tr class="<?php echo "row$k"; ?>">
                    <td><?php echo $checked; ?></td>
                    <td><?php echo $row->id; ?></td>
                    <td><a href="<?php echo $link; ?>"><?php echo $row->nombre; ?></a></td>
                    <td><a href="<?php echo $link; ?>"><?php echo $row->tipo; ?></a></td>
                    <td><a href="<?php echo $link; ?>"><?php echo $row->orden; ?></a></td>
                    <td><a href="<?php echo $link; ?>"><?php echo $row->creador; ?></a></td>
                </tr>
                <?php
                    $k = 1 - $k;
                }
                ?>
            </tbody>
        </table>
        <input type="hidden" name="elem" id="elem" value="mod_content" />
        <input type="hidden" name="controller" id="controller" value="section" />
        <input type="hidden" name="task" id="task" value="" />
    </form>
</div>