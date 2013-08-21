<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );

$editor = &JhaFactory::getEditor();
$canEdit = false;
if(isset($this->articulos) && count($this->articulos) > 0){
	$canEdit = $this->user->rol == 'Super Administrador' || $this->user->rol == 'Editor';
    $isEdit = JhaRequest::getVar('task','save');
    $GLOBALS['JHA_HEAD_VARS'][] = JhaHTML::title($this->seccion->nombre);
    if($canEdit) {
    	echo '<form action="index.php" method="post" name="adminForm">';
    }
?>
<div style="width: 100%; position:relative;">
    <div style="width: 50%; display: block; float: left;" id="mod-sect-est-column-1">
        <div class="module" id="<?php echo 'article' . $this->articulos[0]->id; ?>">
            <div class="module-header">
                <div align="left" style="float:left;">
                <?php if(($canEdit && $isEdit != 'edit') || ($canEdit && $this->id != $this->articulos[0]->id)) { ?>
				    <a href="javascript:;" onclick="javascript:Jha.dom.$('task').value = 'edit'; Jha.dom.$('id').value = <?php echo $this->articulos[0]->id; ?>; document.forms.adminForm.submit();" title="Editar"><img src="images/edit.jpg" /></a>
				<?php } elseif($canEdit && $this->id == $this->articulos[0]->id) { ?>
				    <a href="javascript:;" title="Guardar" onclick="javascript:Jha.dom.$('task').value = 'save'; Jha.dom.$('id').value = <?php echo $this->articulos[0]->id; ?>; document.forms.adminForm.submit();"><img src="images/save.jpg" /></a>
				    <a href="javascript:;" title="Cancelar" onclick="javascript:Jha.dom.$('task').value = 'cancel'; Jha.dom.$('id').value = <?php echo $this->articulos[0]->id; ?>; document.forms.adminForm.submit();"><img src="images/cancel.jpg" /></a>
				<?php } ?>
				</div>
				<div align="left" onmousedown="javascript:dragContent.onDragStart(event, Jha.dom.$('<?php echo 'article' . $this->articulos[0]->id; ?>'));" style="line-height: 2;">
				    <?php if($canEdit) { echo $this->articulos[0]->titulo; } ?>
                </div>
            </div>
			<div class="content">
			    <?php if($this->articulos[0]->estado == 'Publicado') {
			        echo ($isEdit == 'edit' && $this->id == $this->articulos[0]->id ? $editor->editor('contenido',$this->articulos[0]->contenido) : $this->articulos[0]->contenido);
			    }
			    elseif ($this->articulos[0]->estado == 'No Publicado')
			        echo 'Este articulo no visible en este momento';
			    else
			        echo 'Este articulo esta ' . $this->articulos[0]->estado;
			    ?>
			</div>
        </div>
        <div class="module-column-empty" id="mod-sect-est-col-empty-1"><br /></div>
    </div>
    <div style="width: 50%; display: block; float: left;" id="mod-sect-est-column-2">
        <?php for($i = 1; $i < count($this->articulos); $i++) { ?>
        <div class="module" id="<?php echo 'article' . $this->articulos[$i]->id; ?>">
            <div class="module-header">
                <div align="left" style="float:left;">
                <?php if(($canEdit && $isEdit != 'edit') || ($canEdit && $this->id != $this->articulos[$i]->id)) { ?>
                    <a href="javascript:;" onclick="javascript:Jha.dom.$('task').value = 'edit'; Jha.dom.$('id').value = <?php echo $this->articulos[$i]->id; ?>; document.forms.adminForm.submit();" title="Editar"><img src="images/edit.jpg" /></a>
                <?php } elseif ($canEdit && $this->id == $this->articulos[$i]->id) { ?>
                    <a href="javascript:;" title="Guardar" onclick="javascript:Jha.dom.$('task').value = 'save'; Jha.dom.$('id').value = <?php echo $this->articulos[$i]->id; ?>; document.forms.adminForm.submit();"><img src="images/save.jpg" /></a>
                    <a href="javascript:;" title="Cancelar" onclick="javascript:Jha.dom.$('task').value = 'cancel'; Jha.dom.$('id').value = <?php echo $this->articulos[$i]->id; ?>; document.forms.adminForm.submit();"><img src="images/cancel.jpg" /></a>
                <?php } ?>
                </div>
                <div align="left" onmousedown="javascript:dragContent.onDragStart(event, Jha.dom.$('<?php echo 'article' . $this->articulos[$i]->id; ?>'));" style="line-height: 2;">
                    <?php if($canEdit) { echo $this->articulos[$i]->titulo; } ?>
                </div>
            </div>
            <div class="content">
                <?php if($this->articulos[$i]->estado == 'Publicado') {
                    echo ($isEdit == 'edit' && $this->id == $this->articulos[$i]->id ? $editor->editor('contenido',$this->articulos[$i]->contenido) : $this->articulos[$i]->contenido);
                }
                elseif ($this->articulos[$i]->estado == 'No Publicado')
                    echo 'Este articulo no visible en este momento';
                else
                    echo 'Este articulo esta ' . $this->articulos[$i]->estado;
                ?>
            </div>
        </div>
        <?php } ?>
        <div class="module-column-empty" id="mod-sect-est-col-empty-2"><br /></div>
    </div>
</div>
<input name="elem" id="elem" type="hidden" value="mod_content" />
<input name="controller" id="controller" type="hidden" value="section" />
<input name="sid" id="sid" type="hidden" value="<?php echo $this->seccion->id; ?>" />
<input name="id" id="id" type="hidden" value="" />
<input name="task" id="task" type="hidden" value="" />
<?php if($canEdit) {
	echo '</form>'; 
    $script = "dragContent = new Jha.drag();\ndragContent.setType('article');\n";
    for ($i = 0; $i < count($this->articulos); $i++){
        $script .= "dragContent.addTarget(Jha.dom.$('article" . $this->articulos[$i]->id . "'));\n";
    }
    $script .= 'dragContent.ajaxPost = function (objajax, idSource, idTarget, isBeforeTarget) { objajax.json = true; res = { elem : \'mod_content\', controller : \'section\', sid : Jha.dom.$(\'sid\').value, src : idSource, trg : idTarget, json : objajax.json, before : isBeforeTarget, task : \'reorder\'}; return res; };
dragContent.checkListStyle = function(){ elems = []; cols = [Jha.dom.$("mod-sect-est-column-1"), Jha.dom.$("mod-sect-est-column-2")]; for (var i = 0; i < cols.length; i++) { nodes = cols[i].childNodes; for (var j = 0; j < nodes.length; j++) { if(nodes[j].tagName == "DIV"){ if(nodes[j].id.indexOf("article") != -1){ elems[elems.length] = nodes[j]; nodes[j].parentNode.removeChild(nodes[j]); j--; } } } } cols[0].insertBefore(elems[0], Jha.dom.$("mod-sect-est-col-empty-1")); nodeEmpty = Jha.dom.$("mod-sect-est-col-empty-2"); for (var i = 1; i < elems.length; i++) { cols[1].insertBefore(elems[i], nodeEmpty); } };';
    echo JhaHTML::script($script, false);
} ?>
<?php } else { ?>
    <div class="content"><?php echo 'No hay articulos en esta seccion.' ?></div>
<?php } ?>