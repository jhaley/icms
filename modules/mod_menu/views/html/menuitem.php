<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
?>
<div id="menuitemslist">
	<div><?php echo $this->controls; ?></div>
	<div>
	    <form action="index.php" method="post" name="adminForm">
	        <table class="adminlist" cellspacing="1">
	            <thead>
	                <tr>
	                    <th width="5"><input type="checkbox" name="toggle" id="cbmi" value="" onclick="javascript:Jha.html.checkbox.checkAll(this, 'cbmi');" /></th>
	                    <th class="title">ID</th>
	                    <th nowrap="nowrap">Nombre</th>
	                    <th nowrap="nowrap">Predeterminado</th>
	                    <th nowrap="nowrap">Orden</th>
	                    <th nowrap="nowrap">Enlace</th>
	                    <th nowrap="nowrap">Icono</th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php
	                $k = 0;
	                for ($i=0 ; $i < count( $this->menuitems ); $i++) {  
	                    $row = &$this->menuitems[$i];
	                    $checked = JhaHTML::tagHTML( 'input', array('name'=>'id[]', 'type'=>'checkbox', 'value'=>$row->id, 'id'=>'cbmi' . $i, 'onclick'=>'javascript:Jha.html.checkbox.isChecked(this);') );
	                    $link = 'index.php?elem=mod_menu&task=editmenuitem&showing='. $row->menu . '&id=' . $row->id;
	                ?>
	                <tr class="<?php echo "row$k"; ?>">
	                    <td><?php echo $checked; ?></td>
	                    <td><?php echo $row->id; ?></td>
	                    <td><a href="<?php echo $link; ?>"><?php echo $row->nombre; ?></a></td>
	                    <td><a href="<?php echo $link; ?>"><?php echo $row->home; ?></a></td>
	                    <td><a href="<?php echo $link; ?>"><?php echo $row->orden; ?></a></td>
	                    <td><a href="<?php echo $link; ?>"><?php echo $row->enlace; ?></a></td>
	                    <td><a href="<?php echo $link; ?>"><?php echo $row->icono; ?></a></td>
	                </tr>
	                <?php
	                    $k = 1 - $k;
	                }
	                ?>
	            </tbody>
	        </table>
	    </form>
	</div>
</div>