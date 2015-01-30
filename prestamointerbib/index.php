<?php
/**
 * Página inicial de la aplicación de Prestamo Interbibliotecario
 *
 * @author David Andrés Manzano - damanzano
 * @since 13/01/11
 * 
 */
include_once 'Config.php';
if (strpos(getenv('REQUEST_URI'), 'biblio_apps') !== FALSE){
  header("Location: ../prestamo_interbib.php");
  die;
}

?>
<div id="biblio_apps">
    <div class="title">Pr&eacute;stamo Interbibliotecario</div>
    <div id="app_info">
        <span>
            El servicio de <strong>Pr&eacute;stamo Interbibliotecario </strong>es un convenio entre la
            <strong>Biblioteca Universidad Icesi</strong> con otras bibliotecas universitarias nacionales
            e Internacionales y adem&aacute;s con la <strong>Biblioteca</strong> <a href="http://ticuna.banrep.gov.co:8080/opac/inicio.htm">Luis &Aacute;ngel Arango</a>
            a trav&eacute;s de la red de Bibliotecas del Banco de la Rep&uacute;blica. Este servicio se ofrece desde la
            Secci&oacute;n de Referencia y consiste en facilitar las <strong>colecciones bibliogr&aacute;ficas</strong>,
            de acuerdo a las pol&iacute;ticas establecidas en cada una de ellas.
        </span>
		<span>Por favor diligenciar el siguiente formato, sólo si el material solicitado se encuentra en bibliotecas fuera de cali</span>
    </div>
    <?php
        include_once ('view/formularioLogin.php');
        //echo "usuario: ".$_SESSION['pibuser'];
        //si el usuario no se ha loguado
//        if(!isset ($_SESSION['pibuser'])){
//            include_once ('view/formularioLogin.php');
//        }else{
//            include_once('view/formularioPrestamo.php');
//        }
    ?>
</div>