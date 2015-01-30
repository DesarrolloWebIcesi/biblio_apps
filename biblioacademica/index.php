<?php
/**
 * Página inicial de la aplicación de colecciones
 *
 * @author David Andrés Manzano - damanzano
 * @since 17/01/11
 * @modified 11/02/11 Se agregan los mensajes de introduci&oacute;n
 *
 * @package biblio_apps
 * @subpackage biblioacademica
 */
include_once 'Config.php';
if (strpos(getenv('REQUEST_URI'), 'biblio_apps') !== FALSE){
  header("Location: ../biblioacademica.php");
  die;
}
?>
<div id="biblio_apps">    
    <div id="app_info">
        <span>
            Bienvenido(a), toda la informaci&oacute;n bibliog&aacute;fica y electr&oacute;nica - contenida en la Biblioteca Icesi
            y organizada por &aacute;reas.
        </span>
    </div>
    <?php 
    include 'view/listadoAreas.php';   
    ?>
</div>