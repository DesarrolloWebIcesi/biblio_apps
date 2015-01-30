<script type="text/javascript">
    //Refresca la página cada 20 minutos y tres segundos
    /*function timedRefresh(timeoutPeriod) {
        setTimeout("location.reload(true);",timeoutPeriod);
    }
    timedRefresh(1200003);*/
</script>
<?php
include_once '../Config.php';
include_once '../model/Usuario.php';

session_start();
//La sesión se destruye y se envía a la página de inicio cada 20 minutos si no hay actividad
$maximoInactivo = 1200;
if (isset($_SESSION['ultimoAcceso']) && isset($_SESSION['pibuser'])) {
    $tiempoUltimoAcceso = time() - $_SESSION['ultimoAcceso'];
    if ($tiempoUltimoAcceso >= $maximoInactivo) {
        session_destroy();
        header("Location: formulario_prestamo_interbibliotecario.php");
    }
}
$_SESSION['ultimoAcceso'] = time();

//Si hay datos en la sesión el usuario ya se logueó, entonces se muestran sus datos y la opción salir encima del contenido
//No importa la URL del artículo de Joomla, que corresponda a un formulario de adquisiciones, que se use para salir
//Cuando invoque al index y vea el parámetro salir, se borrará la sesión
if (isset($_SESSION['pibuser'])) {
    $user = $_SESSION['pibuserdata'];
?>
    <table  class="login_data" width="100%">
        <tr>
            <td>
                Ha ingresado como <?php echo $user->getNombre(); ?>
                <br/>
                Correo: <?php echo $user->getEmail(); ?>
            </td>
            <td align="right"><strong><a href='#' title='Salir'id="close_session">Salir</a></strong></td>
        </tr>
    </table>
<?php
}
?>