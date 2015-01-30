<?php
/*
 * Este archivo despliega el formulario de ingreso a la aplicación de
 * préstamo interbibliotecario.
 */

if (basename($_SERVER['PHP_SELF']) != "index.php") {
    header("Location: index.php");
    die;
}

?>
<link type="text/css" rel="stylesheet"  href="<?php echo $GLOBALS["biblio_apps"] ?>/commons/css/commons.css"/>
<script type="text/javascript" src="<?php echo $GLOBALS["biblio_apps"] ?>/commons/js/jquery-1.4.3.min.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS["biblio_apps"] ?>/commons/js/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS["biblio_apps"] ?>/commons/js/dialogos.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS["biblio_apps"] ?>/commons/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo $GLOBALS["biblio_apps"] ?>/commons/js/jquery.validate.localization.js"></script>
<script language="javascript">
    var biblioappsURL="<?php echo $GLOBALS["biblio_apps"] ?>";
    var approuteURL="<?php echo $GLOBALS["app_route"] ?>";
    $.noConflict();
</script>
<script type="text/JavaScript" src="<?php echo $GLOBALS["app_route"] ?>/js/loginForm_validations.js" charset="iso-8859-1"></script>
<link type="text/css" rel="stylesheet"  href="<?php echo $GLOBALS["app_route"] ?>/css/ui.css"/>
<div id="user_data"></div>
<div id="pib_app_form">    
    <div id="form_login">
        <form method="post" action="" name="loginForm" id="loginForm" >
            <table align="center" cellpadding="4" cellspacing="0">
                <tr>
                    <th colspan="2" bgcolor="#CCCCCC" style="border: solid 1px black;">
		    Por favor ingrese su nombre de usuario y su contrase&ntilde;a
                    </th>
                </tr>
                <tr>
                    <td align="right" style="border-left:solid 1px black;">Nombre de usuario</td>
                    <td style="border-right:solid 1px black;"><input type="text" name="usuario" id="usuario" /></td>
                </tr>
                <tr>
                    <td align="right" style="border-left:solid 1px black;">Contrase&ntilde;a</td>
                    <td style="border-right:solid 1px black;"><input type="password" name="password" id="password"/></td>
                </tr>
                <tr>
                    <td colspan="2" align="center" style="border-right:solid 1px black; border-bottom:solid 1px black; border-left:solid 1px black;">
                        <input type="submit" name="boton" value="Ingresar"/>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php include_once $GLOBALS["biblio_apps"].'/commons/helpers/dialogos.php';?>