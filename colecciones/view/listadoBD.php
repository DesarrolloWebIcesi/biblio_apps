<?php
/**
 * Página de inicio de la colección de bases de datos
 * @author damanzano
 * @since 15/10/10
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
<script type="text/javascript" src="<?php echo $GLOBALS["app_route"] ?>/js/lbd_validations.js" charset="iso-8859-1"></script>

<div id="biblio_apps">
    <!--<div class="title">B&uacute;squeda de Bases de Datos</div>-->
    <div id="app_info">
        <table align="center" width="100%" border="1" cellspacing="0" cellpadding="0">
            <tr>
                <!--<td class="contenido" align="center"><font color="#333333"><strong>Convenci&oacute;n</strong></font></td>
                <td class="contenido" align="center"><font color="#333333"><strong>Tipo
                            de acceso</strong></font></td>
                            <td class="contenido" align="center"><font color="#333333"><strong>Descripci&oacute;n</strong></font></td>-->
            </tr>
            <tr>
                <td align="center"><img src="<?php echo $GLOBALS["app_route"] ?>/images/accesos/local_1.png" width="27" height="27"></td>
                <td class="contenidoIdentado"><font color="#666666">Consulta dentro
                        del campus universitario</font></td>
                <td class="contenidoIdentado"><font color="#666666">Recursos desde cualquier
                        computador de la Universidad, incluyendo la Secci&oacute;n de Bases de Datos</font></td>
            </tr>
            <tr>
                <td align="center"><img src="<?php echo $GLOBALS["app_route"] ?>/images/accesos/fijo_1.png" width="27" height="27"></td>
                <td class="contenidoIdentado"><font color="#666666">Consulta desde la
                        Secci&oacute;n de Bases de Datos</font></td>
                <td class="contenidoIdentado"><font color="#666666">Recursos monousuarios,
                        su consulta es s&oacute;lo desde la Secci&oacute;n de Bases de Datos de la Biblioteca</font></td>
            </tr>
            <tr>
                <td align="center"><img src="<?php echo $GLOBALS["app_route"] ?>/images/accesos/remoto_1.png" width="27" height="28"></td>
                <td class="contenidoIdentado"><font color="#666666">Consulta fuera del
                        campus universitario</font></td>
                <td class="contenidoIdentado"><font color="#666666">Recursos, tanto
                        dentro de la Universidad como fuera de ella (consulta desde la casa
                        u oficina)</font></td>
            </tr>
        </table>
    </div>
    <div id="app_form">
        <form action="" method="post" id="bdForm">
            <div align="left">                
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td>
                            <table width="470" border="0" cellspacing="5" cellpadding="0">
                                <tr>
                                    <td align="right" class="contenido" width="30%">                                        
                                        <strong>Base de datos:</strong>
                                    </td>
                                    <td>
                                        <select name="pBD" id="pBD">
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" class="contenido">                                        
                                        <strong>Área:</strong>
                                    </td>
                                    <td>
                                        <select name="pArea" id="pArea">                                           
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" class="contenido">                                        
                                        <strong>Acceso:</strong>
                                    </td>
                                    <td>
                                        <select name="pTipoAcceso" id="pTipoAcceso">
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
                        <td valign="top" align="center">&nbsp;

                        </td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
    <div class="app_navigation"></div>
    <div id="app_results">        
    </div>
    <div class="app_navigation"></div>
</div>