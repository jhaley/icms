<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
echo JhaHTML::script('modules/mod_menu/extras/menu.js');
?>
<div><?php echo $this->controls; ?></div>
<div>
    <form action="index.php" method="post" name="adminForm">
        <table class="adminlist" cellspacing="1">
            <thead>
                <tr>
                    <th width="5"><input type="checkbox" name="toggle" id="cb" value="" onclick="javascript:Jha.html.checkbox.checkAll(this, 'menu');" /></th>
                    <th class="title">ID</th>
                    <th nowrap="nowrap">Titulo</th>
                    <th nowrap="nowrap">Descripci&oacute;n</th>
                    <th nowrap="nowrap">Creador</th>
                    <th nowrap="nowrap">Items del Menu</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $k = 0;
                for ($i=0 ; $i < count( $this->menus ); $i++) {  
                    $row = &$this->menus[$i];
                    $checked = JhaHTML::tagHTML( 'input', array('name'=>'idmenu[]', 'type'=>'checkbox', 'value'=>$row->id, 'id'=>'menu' . $i, 'onclick'=>'javascript:Jha.html.checkbox.isChecked(this);') );
                    $link = 'index.php?elem=mod_menu&task=editmenu&idmenu='. $row->id;
                ?>
                <tr class="<?php echo "row$k"; ?>">
                    <td><?php echo $checked; ?></td>
                    <td><?php echo $row->id; ?></td>
                    <td><a href="<?php echo $link; ?>"><?php echo $row->titulo; ?></a></td>
                    <td><a href="<?php echo $link; ?>"><?php echo $row->descripcion; ?></a></td>
                    <td><a href="<?php echo $link; ?>"><?php echo $row->creador; ?></a></td>
                    <td><a href="javascript:;" onclick="javascript:<?php echo $this->showing == $row->id ? 'hide' : 'show'; ?>MenuItems(<?php echo $row->id; ?>);" id="showButton<?php echo $row->id; ?>"><?php echo $this->showing == $row->id ? 'Ocultar' : 'Mostrar'; ?></a></td>
                </tr>
                <tr><td id="menuitems<?php echo $row->id; ?>" colspan="6"><?php echo $this->showing == $row->id ? $this->menuitems : ''; ?></td></tr>
                <?php
                    $k = 1 - $k;
                }
                ?>
            </tbody>
        </table>
        <input type="hidden" name="elem" id="elem" value="mod_menu" />
        <input type="hidden" name="task" id="task" value="" />
        <input type="hidden" name="showing" id="showing" value="<?php echo $this->showing ? $this->showing : '0'; ?>" />
    </form>
</div>