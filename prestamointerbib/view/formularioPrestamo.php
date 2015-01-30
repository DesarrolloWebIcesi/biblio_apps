<?php
/*
 * Este archivo despliega el formulario de préstamo interbibliotecario.
 */
include_once '../Config.php';
include_once '../model/Usuario.php';

session_start();
//La sesión se destruye y se envía a la página de inicio cada 20 minutos si no hay actividad
$maximoInactivo = 1200;
if (isset($_SESSION['ultimoAcceso']) && isset($_SESSION['pibuser'])) {
    $tiempoUltimoAcceso = time() - $_SESSION['ultimoAcceso'];
    if ($tiempoUltimoAcceso >= $maximoInactivo) {
        session_destroy();        
    }
}
$_SESSION['ultimoAcceso'] = time();
if (isset($_SESSION['pibuser'])) {
    $usuario = $_SESSION['pibuser'];
    $userData = $_SESSION['pibuserdata'];
} else {
    session_destroy();    
}
?>


<!--<script type="text/javascript" src="<?php echo $GLOBALS["biblio_apps"] ?>/commons/js/jquery-1.4.3.min.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS["biblio_apps"] ?>/commons/js/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS["biblio_apps"] ?>/commons/js/dialogos.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS["biblio_apps"] ?>/commons/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS["biblio_apps"] ?>/commons/js/jquery.validate.localization.js"></script>
<script language="javascript">
    var biblioappsURL="<?php echo $GLOBALS["biblio_apps"] ?>";
    var approuteURL="<?php echo $GLOBALS["app_route"] ?>";
    $.noConflict();
</script>-->
<script type="text/JavaScript" src="<?php echo $GLOBALS["app_route"] ?>/js/prestamoForm_validations.js" charset="iso-8859-1"></script>
<!--<link type="text/css" rel="stylesheet"  href="<?php echo $GLOBALS["app_route"] ?>/css/ui.css"/>-->
<link type="text/css" rel="stylesheet"  href="<?php echo $GLOBALS["app_route"] ?>/css/arquitecture.css"/>
   
    <div id="form_prestamo">
        <form action="" method="post" name="prestamoForm" id="prestamoForm">
            <div id="personal_data">
            <span><strong>Informaci&oacute;n Personal</strong></span>
            <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td>
                        <table width="100%" border="0" cellpadding="4" cellspacing="1">           
                            <?php
                            if ($userData->getTipo() == "estudiante") {
                            ?>
                                <tr >
                                    <td>
                                        <strong>Identificaci&oacute;n </strong>
                                    </td>
                                    <td width="36%">
                                        <input name="identificacion" type="text" id="identificacion" size="15" maxlength="15" readonly="true" value="<?php echo($userData->getIdentificacion()); ?>">
                                    </td>
                                    <td width="10%" >
                                        <strong>C&oacute;digo</strong>
                                    </td>
                                    <td width="31%">
                                        <input name="codigo" type="text" id="codigo" size="15" maxlength="15" readonly="true" value="<?php echo($userData->getCodigoEstudiante()); ?>">
                                </td>
                            </tr>
                            <?php } else { ?>
                                <tr >
                                    <td width="23%" >
                                        <strong>Identificaci&oacute;n</strong>
                                    </td>
                                    <td colspan="3">
                                        <input name="identificacion" type="text" id="identificacion" size="15" maxlength="15" readonly="true" value="<?php echo($userData->getIdentificacion()); ?>">
                                    </td>
                                </tr>
                            <?php } ?>

                            <tr >
                                <td width="23%" >                                    
                                    <strong>Nombre</strong>
                                </td>
                                <td colspan="3">
                                    <input name="nombre" type="text" id="nombre" size="70" readonly="true" value="<?php echo(htmlentities($userData->getNombre())); ?>">
                                </td>
                            </tr>
                            <?php
                            if ($userData->getTipo() == "estudiante") {
                            ?>
                                <tr>
                                    <td width="23%"><strong>Programa</strong></td>
                                    <td colspan="3">
                                        <input name="programa" type="text" id="programa" size="40" maxlength="50" readonly="true" value="<?php echo(htmlentities($userData->getProgramaEstudiante())); ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="etiquetaFormReq"><strong>Semestre</strong></td>
                                    <td colspan="3">
                                        <input name="semestre" type="text" id="semestre" size="40" maxlength="100" readonly="true" value="<?php echo($userData->getSemestreEstudiante()); ?>">
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td>Tel&eacute;fono</td>
                                <td colspan="3">
                                    <input name="telefono" type="text" id="telefono" class="requiered digits"size="15" maxlength="15" value="<?php echo($userData->getTelefono()); ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>Celular</td>
                                <td colspan="3">
                                    <input name="celular" type="text" id="celular" class="digits"size="15" maxlength="15" value="<?php echo($userData->getCelular()); ?>">
                                </td>
                            </tr>
                            <tr>
                                <td class="etiquetaFormReq"><strong>Correo electr&oacute;nico *</strong></td>
                                <td colspan="3">
                                    <input name="correo" type="text" id="correo" class="required email" size="40" maxlength="40" value="<?php echo($userData->getEmail()); ?>">
                                </td>
                            </tr>                            
                        </table>
                    </td>
                </tr>
            </table>
            </div>
            <br/>
            <div id="book_data">
                <span><strong>Informaci&oacute;n de los libros</strong></span>
                <input type="hidden" value="0" id="booksnumber" />
                <input type="hidden" value="0" id="booksid" />
                <div class="book" id="book0">
                    <table cellpadding="4" cellspacing="1" border="0" width="90%">
                        <tr>
                            <td colspan="4" class="booktitle">
                                Libro 1
                            </td>
                        </tr>

                        <tr>
                            <td width="25%"><strong>T&iacute;tulo del libro *</strong></td>
                            <td colspan="3">                                
                                <input name="libros[0][titulo]" type="text" id="titulo" class="required" size="70"/>
                            </td>
                        </tr>
                        <tr>
                            <td width="25%"><strong>Edici&oacute;n del libro *</strong></td>
                            <td colspan="3">
                                <input name="libros[0][edicion]" type="text" id="edicion" class="required" size="70"/>
                            </td>
                        </tr>
                        <tr>
                            <td>Autor</td>
                            <td width="39%">
                                    <input name="libros[0][autor]" type="text" id="autor" size="40" maxlength="30"/>
                            </td>
                            <td width="11%">Signatura o n&uacute;mero topogr&aacute;fico</td>
                            <td width="25%">
                                    <input name="libros[0][signatura]" type="text" id="sigantura" size="20" maxlength="30" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Instituci&oacute;n prestante del material *</strong>
                            </td>
                            <td colspan="4">
                                <input name="libros[0][institucion]" type="text" id="institucion" class="required" size="40" maxlength="50" />
                            </td>
                        </tr>
                    </table>
                    <span href="#" class="deletebook" onclick="deleteBook('#book0')">Quitar este libro</span>
                </div>              
            </div>
            <div class="book_controls">
                <a href="#" id="addbook">Adicionar Otro Libro</a>
            </div>
            <div align="center">
                <input name="btnEnviar" type="submit" value="Enviar">
                <input type="reset" name="btnLimpiar" value="Limpiar">                
            </div>            
        </form>
    </div>