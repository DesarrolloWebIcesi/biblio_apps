<?php
/**
 * Página de inicio de la colección de Nuevas Adquisiciones
 *
 * @author damanzano
 * @since 26/10/10
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
<script type="text/javascript" src="<?php echo $GLOBALS["app_route"] ?>/js/lnuevasadquisiciones_validations.js" charset="iso-8859-1"></script>

<div id="biblio_apps">
    <!--<div class="title">Listado de Nuevas Adquisiones</div>-->
    <div id="app_info">
        <p>Aqu&iacute; se listan las adquisiciones realizadas en los &uacute;ltimos 30 d&iacute;as hasta la fecha.</p>
        <p>Los listados se muestran de clasificados por &aacute;rea</p>
    </div>
    <div id="app_form">
        <form action="" method="post" id="naForm">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <table width="470" border="0" cellspacing="5" cellpadding="0">
                                <tr>
                                    <td align="right" class="contenido" width="30%">
                                        <strong>Selecciona un &aacute;rea</strong>
                                    </td>
                                    <td>
                                        <select name="idArea" id="idArea">
                                        </select>
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