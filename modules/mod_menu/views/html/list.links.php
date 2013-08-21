<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
?>
<div id="menuitemslist">
	<div>
	    <form action="index.php" method="post" name="adminForm">
	        <table class="adminlist" cellspacing="1">
	            <thead>
	                <tr>
	                    <th class="title">ID</th>
	                    <th nowrap="nowrap">Nombre</th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php
	                $k = 0;
	                for ($i=0 ; $i < count( $this->items ); $i++) {  
	                    $row = &$this->items[$i];
	                    $link = 'javascript:selectLink(\'' . $row->link . '\', ' . $row->id . ', \'' . $row->nombre . '\');';
	                ?>
	                <tr class="<?php echo "row$k"; ?>">
	                    <td><a href="javascript:;" onclick="<?php echo $link; ?>"><?php echo $row->id; ?></a></td>
	                    <td><a href="javascript:;" onclick="<?php echo $link; ?>"><?php echo $row->nombre; ?></a></td>
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