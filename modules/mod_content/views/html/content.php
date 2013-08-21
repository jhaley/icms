<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
$editor = &JhaFactory::getEditor();
$canEdit = false;
if(isset($this->articulo)) {
	$canEdit = $this->user->rol == 'Super Administrador' || $this->user->rol == 'Editor';
	$isEdit = JhaRequest::getVar('task','save');
	$GLOBALS['JHA_HEAD_VARS'][] = JhaHTML::title($this->articulo->titulo);
	if($canEdit) { echo '<form action="index.php" method="post" name="contentform">'; }
?>

<div align="left">
    <?php if($canEdit && $isEdit != 'edit') { ?>
    	<a href="javascript:;" onclick="javascript:document.getElementById('task').value = 'edit'; document.contentform.submit();" title="Editar"><img src="images/edit.jpg" /></a>
    <?php } elseif($canEdit) { ?>
        <a href="javascript:;" title="Guardar" onclick="javascript:document.getElementById('task').value = 'save'; document.contentform.submit();"><img src="images/save.jpg" /></a>
        <a href="javascript:;" title="Cancelar" onclick="javascript:document.getElementById('task').value = 'cancel'; document.contentform.submit();"><img src="images/cancel.jpg" /></a>
    <?php } ?>
</div>

<div class="content">
    <?php if($this->articulo->estado == 'Publicado') {
        echo ($isEdit == 'edit' ? $editor->editor('contenido',$this->articulo->contenido) : $this->articulo->contenido);
    }
    elseif ($this->articulo->estado == 'No Publicado')
        echo 'Este articulo no visible en este momento';
    else
        echo 'Este articulo esta ' . $this->articulo->estado;
    ?>
</div>
<input name="elem" id="elem" type="hidden" value="mod_content" />
<input name="id" id="id" type="hidden" value="<?php echo $this->articulo->id; ?>" />
<input name="task" id="task" type="hidden" value="" />
<?php if($canEdit) { echo '</form>'; } ?>
<?php } else { ?>
    <div class="content"><?php echo 'Articulo no encontrado.' ?></div>
<?php } ?>