<?php

/**
 * En este archivo se realiza el manejo del cierre de la sessión.
 */
echo ControlSession::procesar();

class ControlSession {

    public static function procesar() {
        session_start();

        if ($_POST['action'] == 'cerrar') {

            //header("Location: prestamo_interbib.php");
            $jsonResponse['error'] = true;

            if (session_destroy()) {
                $jsonResponse['error'] = false;
            } else {
                $jsonResponse['msg'] = "Error tratando de cerrar la sesi&oacute;n";
            }
            return json_encode($jsonResponse);
        }

        if ($_POST['action'] == 'verificar') {
            // do something
            $jsonResponse['error'] = true;
            $pib_user = $_SESSION['pibuser'];
            if ($pib_user != null && $pib_user != '') {
                $jsonResponse['error'] = false;
                $jsonResponse['msg'] = $pib_user;
            }
            return json_encode($jsonResponse);
        }
    }

}

?>
