<?php 
defined( '_JHAEXEC' ) or die( 'Access Denied' );
?>
<div>
    <?php if($params['showtitle'] == '1') { ?>
    <div style="position:relative;"><?php echo $block->titulo; ?></div>
    <?php } ?>
	<div style="position:relative;">
	    <?php for ($i = 0; $i < count($links); $i++) { ?>
	    <span class="breadcrumb-separator"></span>
	    <a class="breadcrumb-link" id="bc<?php echo $i; ?>" href="<?php echo $links[$i]->link; ?>"><?php echo $links[$i]->nombre; ?></a>
	    <?php } ?>
    </div>
    <?php if(count($links) <= 0) { echo 'No habilitado mientras se realizan tareas administrativas.'; } ?>
</div>