<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
?>
<div><?php echo $this->controls; ?></div>
<div>
    <form action="index.php" method="post" name="adminForm">
        <table class="adminlist" cellspacing="1">
            <thead>
                <tr>
                    <th width="5"><input type="checkbox" name="toggle" id="cb" value="" onclick="javascript:Jha.html.checkbox.checkAll(this, 'new');" /></th>
                    <th class="title">ID</th>
                    <th class="title">Contenido</th>
                    <th class="title">Fecha de Creaci&oacute;n</th>
                    <th class="title">Creador</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $k = 0;
                for ($i=0 ; $i < count( $this->noticias ); $i++) {  
                    $row = &$this->noticias[$i];
                    $checked = JhaHTML::tagHTML( 'input', array('name'=>'id[]', 'type'=>'checkbox', 'value'=>$row->id, 'id'=>'new' . $i, 'onclick'=>'javascript:Jha.html.checkbox.isChecked(this);') );
                    $link = 'index.php?elem=mod_content&controller=new&task=editnew&id='. $row->id;
                ?>
                <tr class="<?php echo "row$k"; ?>">
                    <td><?php echo $checked; ?></td>
                    <td><?php echo $row->id; ?></td>
                    <td><a href="<?php echo $link; ?>"><?php echo $row->contenido; ?></a></td>
                    <td><a href="<?php echo $link; ?>"><?php echo $row->fechacreacion; ?></a></td>
                    <td><a href="<?php echo $link; ?>"><?php echo $row->creador; ?></a></td>
                </tr>
                <?php
                    $k = 1 - $k;
                }
                ?>
            </tbody>
        </table>
        <input type="hidden" name="elem" id="elem" value="mod_content" />
        <input type="hidden" name="controller" id="controller" value="new" />
        <input type="hidden" name="task" id="task" value="" />
    </form>
</div>