<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
?>
<div><?php echo $this->controls; ?></div>
<div>
    <form action="index.php" method="post" name="adminForm">
        <table class="adminlist" cellspacing="1">
            <thead>
                <tr>
                    <th width="5"><input type="checkbox" name="toggle" id="cb" value="" onclick="javascript:Jha.html.checkbox.checkAll(this, 'article');" /></th>
                    <th class="title">ID</th>
                    <th class="title">T&iacute;tulo</th>
                    <th class="title">Orden</th>
                    <th class="title">Estado</th>
                    <th class="title">Fecha de Creaci&oacute;n</th>
                    <th class="title">Fecha de Publicaci&oacute;n</th>
                    <th class="title">Predeterminado</th>
                    <th class="title">Creador</th>
                    <th class="title">Secci&oacute;n</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $k = 0;
                for ($i=0 ; $i < count( $this->articulos ); $i++) {  
                    $row = &$this->articulos[$i];
                    $checked = JhaHTML::tagHTML( 'input', array('name'=>'id[]', 'type'=>'checkbox', 'value'=>$row->id, 'id'=>'article' . $i, 'onclick'=>'javascript:Jha.html.checkbox.isChecked(this);') );
                    $link = 'index.php?elem=mod_content&task=editarticle&id='. $row->id;
                ?>
                <tr class="<?php echo "row$k"; ?>">
                    <td><?php echo $checked; ?></td>
                    <td><?php echo $row->id; ?></td>
                    <td><a href="<?php echo $link; ?>"><?php echo $row->titulo; ?></a></td>
                    <td><a href="<?php echo $link; ?>"><?php echo $row->orden; ?></a></td>
                    <td><a href="<?php echo $link; ?>"><?php echo $row->estado; ?></a></td>
                    <td><a href="<?php echo $link; ?>"><?php echo $row->fechacreacion; ?></a></td>
                    <td><a href="<?php echo $link; ?>"><?php echo $row->fechapublicacion; ?></a></td>
                    <td><a href="<?php echo $link; ?>"><?php echo $row->home; ?></a></td>
                    <td><a href="<?php echo $link; ?>"><?php echo $row->creador; ?></a></td>
                    <td><a href="<?php echo $link; ?>"><?php echo $row->seccion; ?></a></td>
                </tr>
                <?php
                    $k = 1 - $k;
                }
                ?>
            </tbody>
        </table>
        <input type="hidden" name="elem" id="elem" value="mod_content" />
        <input type="hidden" name="task" id="task" value="" />
    </form>
</div>