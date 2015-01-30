<?php

/**
 * En este archivo se realiza lo concerniente a las variables de sesión
 *
 * @author David Andrés Manzano - damanzano
 * @since 11/02/11
 * @modified 12/02/11 se adiciona funcionalidad para regresar al index
 *
 * @package biblioacademica
 * @subpackage control
 */
include_once ('../control/ControlAreas.php');
include_once ('../../commons/services/GeneralServices.php');
include_once ('../Config.php');

echo ControlSession::procesar();

class ControlSession {

    public static function procesar() {
        session_start();
        $area = $_POST['area'];

        $jsonResponse['error'] = true;
        if (isset($area) && ($area == '' || $area == null || $area == 'null')) {
            session_destroy();
            $jsonResponse['error'] = false;
            $jsonResponse['area'] = null;
            $jsonResponse['msg'] = "ningun area seleccionada";
        } else {
            if (isset($area) && $area != null && $area != '') {
                $_SESSION['parea'] = $area;
                $jsonResponse['error'] = false;
                $jsonResponse['area'] = $area;
                $jsonResponse['msg'] = "area seleccionada";

                $controlAreas = $_SESSION["controlAreas"];
                if ($controlAreas == null || $controlAreas == '') {
                    $controlAreas = new ControlAreas();
                    $_SESSION["controlAreas"] = $controlAreas;
                }
                $controlAreas->cargarAreas();
                $areaobj = $controlAreas->getArea($area);
                $_SESSION['parea_desc'] = $areaobj->getNombre();
                $jsonResponse['area_desc'] = "" . htmlentities($areaobj->getNombre()) . "";
            }
        }
        echo json_encode($jsonResponse);
    }

}

?>
