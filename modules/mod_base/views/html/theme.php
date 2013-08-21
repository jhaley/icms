<?php
defined( '_JHAEXEC' ) or die( 'Access Denied' );
echo JhaHTML::script('modules/mod_base/extras/theme.js');
?>
<div><?php echo $this->controls; ?></div>
<div>
    <form action="index.php" method="post" name="adminForm">
        <table class="adminlist" cellspacing="1">
            <thead>
                <tr>
                    <th class="title">ID</th>
                    <th nowrap="nowrap">Nombre</th>
                    <th nowrap="nowrap">Predeterminado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $k = 0;
                for ($i=0 ; $i < count( $this->themes ); $i++) {  
                    $row = &$this->themes[$i];
                    $params = array('name'=>'id', 'type'=>'radio', 'value'=>$row->id, 'id'=>'rb' . $row->id, 'onclick'=>'javascript:changeDefault(' . $row->id . ');');
                    if($row->predeterminado == '1')	$params['checked'] = 'checked';
                    $selected = JhaHTML::tagHTML( 'input', $params );
                ?>
                <tr class="<?php echo "row$k"; ?>">
                    <td><?php echo $row->id; ?></td>
                    <td><a href="javascript:;" onclick="javascript:changeDefault(<?php echo $row->id; ?>);"><?php echo $row->nombre; ?></a></td>
                    <td><?php echo $selected; ?></td>
                </tr>
                <?php
                    $k = 1 - $k;
                }
                ?>
            </tbody>
        </table>
        <input type="hidden" name="elem" id="elem" value="mod_base" />
        <input type="hidden" name="controller" id="controller" value="theme" />
        <input type="hidden" name="task" id="task" value="" />
    </form>
</div>