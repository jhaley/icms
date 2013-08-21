<?php 
defined( '_JHAEXEC' ) or die( 'Access Denied' );
?>
<div>
    <form action="index.php" method="post">
        <?php if($task == 'logout') { ?>
            <div>Bienvenido, <a href="index.php?elem=mod_user&task=edituser&id=<?php echo $user->id; ?>"><?php echo $user->nombre; ?></a></div>
            <div><center><input name="submit" type="submit" value="Cerrar Sesion" /></center></div>
        <?php } else { ?>
            <div>
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr><td><label for="username">Nombre de Usuario: </label></td></tr>
                    <tr><td><input name="username" id="username" type="text" /></tr>
                    <tr><td><label for="passwd">Contrase&ntilde;a: </label></td></tr>
                    <tr><td><input name="passwd" id="passwd" type="password" /></tr>
                </table>
            </div>
            <div><center><input name="submit" type="submit" value="Iniciar Sesion" /></center></div>
        <?php } ?>
        <input name="elem" type="hidden" value="mod_user" />
        <input name="task" type="hidden" value="<?php echo $task; ?>" />
    </form>
</div>