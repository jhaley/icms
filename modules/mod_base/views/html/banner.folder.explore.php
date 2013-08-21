<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
?>

<?php foreach ($this->folders as $path) { ?>
<div style="border: 1px solid #AAAAAA;padding: 5px;text-align: center;width: 70px; float: left;" class="banner-folder-explore">
	
<?php if($path->nombre == "..") { ?>
	<div style="margin: 5px;" onclick="javascript:exploreBannerFolder('<?php echo addslashes($path->path); ?>');"><img src="<?php echo $path->imagen; ?>" /></div>
	<a href="javascript:;" onclick="javascript:exploreBannerFolder('<?php echo addslashes($path->path); ?>');"><?php echo $path->nombre; ?></a><br />
<?php } else { ?>
	<div style="margin: 5px;" onclick="javascript:exploreBannerFolder('<?php echo addslashes($path->path.DS."."); ?>');"><img src="<?php echo $path->imagen; ?>" /></div>
	<a href="javascript:;" onclick="javascript:exploreBannerFolder('<?php echo addslashes($path->path.DS."."); ?>');"><?php echo $path->nombre; ?></a><br />
	<a href="javascript:;" onclick="javascript:selectBannerFolder('<?php echo addslashes($path->path); ?>');">Seleccionar</a>
<?php } ?>
</div>
<?php } ?>
<div class="cleared"></div>