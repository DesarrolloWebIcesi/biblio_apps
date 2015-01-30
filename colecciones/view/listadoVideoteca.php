<?php
/**
 * Página de inicio de la colección Sonoteca
 *
 * @author damanzano
 * @since 23/11/10
 */
?>
<!--<script type="text/javascript" src="<?php echo $GLOBALS["biblio_apps"] ?>/commons/js/jquery-1.4.2.min.js" charset="iso-8859-1"></script>-->
<link type="text/css" rel="stylesheet"  href="<?php echo $GLOBALS["biblio_apps"] ?>/commons/css/commons.css"/>
<script language="javascript" charset="iso-8859-1">
    var biblioappsURL="<?php echo $GLOBALS["biblio_apps"] ?>";
    var coleccionesURL="<?php echo $GLOBALS["app_route"] ?>";
    $.noConflict();
</script>
<script type="text/javascript" src="<?php echo $GLOBALS["biblio_apps"] ?>/commons/js/jquery.validate.js" charset="iso-8859-1"></script>
<script type="text/javascript" src="<?php echo $GLOBALS["app_route"] ?>/js/lvideos_validations.js" charset="iso-8859-1"></script>
<div id="biblio_apps">
    <div class="title"></div>
    <div id="app_info">
        <span>
            Digita en el campo T&iacute;tulo , el nombre del elemento de video que deseas buscar.
            Si dejas el campo vac&iacute;o se mostrar&aacute; el listado completo de elementos de video registrados en el sistema de biblioteca
        </span>
    </div>
    <div id="app_form">        
        <form action="" method="post" id="videosForm">
                <span></span>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <table width="470" border="0" cellspacing="5" cellpadding="0">
                                <tr>
                                    <td align="right" class="contenido" width="30%">
                                        <strong>T&iacute;tulo:</strong>
                                    </td>
                                    <td>
                                        <input type="text" name="pkeyword" id="pkeyword">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        &nbsp;
                                    </td>
                                    <td>
                                        <span>N&uacute;mero de items a desplegar</span>
                                        <select name="size" id="size">
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="30">30</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>
                                        <input type="hidden" name="newsearch" id="newsearch" value="s"/>
                                        <input name="submit" type="image" src="/biblioteca/images/accesos/buscar.png" value="Buscar">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </form>
    </div>
    <div class="app_navigation"></div>
    <div id="app_results">
    </div>
    <div class="app_navigation"></div>
</div>