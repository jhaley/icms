<?php 
defined( '_JHAEXEC' ) or die( 'Access Denied' );
echo JhaHTML::script('blocks/block_banner/banner.js');
?>
<div>
    <?php if($params['showtitle'] == '1') { ?>
    <div style="position:relative;"><?php echo $block->titulo; ?></div>
    <?php } ?>
	<div style="position:relative;">
	    <?php for ($i = 0; $i < count($images); $i++) { ?>
	    <div id="banner<?php echo $i; ?>">
	    	<img src="<?php echo str_replace("\\", "/", $params["directory"].DS.$images[$i]); ?>" width="<?php echo $params['imagewidth']; ?>" height="<?php echo $params['imageheight']; ?>" />
    	</div>
	    <?php } ?>
    </div>
    <script>
    	totalImages = <?php echo count($images) . ';'; ?>
    	initializeEffectsBanner('<?php echo $params['bannerchange']; ?>');
    </script>
</div>