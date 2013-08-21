<?php 
defined( '_JHAEXEC' ) or die( 'Access Denied' );
?>
<div>
    <?php if($params['showtitle'] == '1') { ?>
    <div style="position:relative;"><?php echo $block->titulo; ?></div>
    <?php } ?>
	<div style="position:relative;">
	    <?php echo $block->contenido; ?>
    </div>
</div>