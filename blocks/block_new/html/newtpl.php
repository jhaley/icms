<?php 
defined( '_JHAEXEC' ) or die( 'Access Denied' );
echo JhaHTML::script('blocks/block_new/new.js');
?>
<div>
    <?php if($params['showtitle'] == '1') { ?>
    <div style="position:relative;"><?php echo $block->titulo; ?></div>
    <?php } ?>
	<div style="position:relative;">
	    <?php for ($i = 0; $i < count($noticias); $i++) { ?>
	    <div id="new<?php echo $i; ?>"><?php echo $noticias[$i]->contenido; ?></div>
	    <?php } ?>
    </div>
    <script>
    	totalNews = <?php echo count($noticias) . ';'; ?>
    	initializeEffectsNew('<?php echo $params['newschange']; ?>');
    </script>
</div>