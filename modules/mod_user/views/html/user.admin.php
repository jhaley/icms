<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
?>
<div><?php echo $this->controls; ?></div>
<div>
    <form action="index.php" method="post" name="adminForm">
        <table class="adminlist" cellspacing="1">
            <thead>
                <tr>
                    <th width="5"><input type="checkbox" name="toggle" id="cb" value="" onclick="javascript:Jha.html.checkbox.checkAll(this, 'user');" /></th>
                    <th class="title">ID</th>
                    <th class="title">Nombre</th>
                    <th class="title">Nick</th>
                    <th class="title">Rol</th>
                    <th class="title">Estado</th>
                    <th class="title">Fecha de Registro</th>
                    <th class="title">Ultimo ingreso</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $k = 0;
                for ($i=0 ; $i < count( $this->usuarios ); $i++) {
                    $row = &$this->usuarios[$i];
                    $checked = JhaHTML::tagHTML( 'input', array('name'=>'id[]', 'type'=>'checkbox', 'value'=>$row->id, 'id'=>'user' . $i, 'onclick'=>'javascript:Jha.html.checkbox.isChecked(this);') );
                    $user = $_SESSION['USER'];
                    $link = 'href="index.php?elem=mod_user&task=edituser&id=' . $row->id . '"';
                    if($row->rol == 'Super Administrador' && $row->id != $user->id) {
                    	$link = '';
                    	$checked = '';
                    }
                ?>
                <tr class="<?php echo "row$k"; ?>">
                    <td><?php echo $checked; ?></td>
                    <td><?php echo $row->id; ?></td>
                    <td><a <?php echo $link; ?>><?php echo $row->nombre; ?></a></td>
                    <td><a <?php echo $link; ?>><?php echo $row->usuario; ?></a></td>
                    <td><a <?php echo $link; ?>><?php echo $row->rol; ?></a></td>
                    <td><a <?php echo $link; ?>><?php echo $row->estado; ?></a></td>
                    <td><a <?php echo $link; ?>><?php echo $row->fecharegistro; ?></a></td>
                    <td><a <?php echo $link; ?>><?php echo $row->fechaultimoacceso; ?></a></td>
                </tr>
                <?php
                    $k = 1 - $k;
                }
                ?>
            </tbody>
        </table>
        <input type="hidden" name="elem" id="elem" value="mod_user" />
        <input type="hidden" name="task" id="task" value="" />
    </form>
</div>