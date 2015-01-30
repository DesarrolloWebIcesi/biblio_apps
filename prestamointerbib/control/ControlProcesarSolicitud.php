<?php

/**
 * En este archivo se llevan a cabo la validaciones y procesos necesaior para la
 * construcción y envio de la solicitud.
 *
 * @author David Andrés Manzano - damanzano
 */
include_once("../Config.php");
include_once ('ControlCasoMantis.php');
include_once ('../model/Usuario.php');
include_once ('../model/SolicitudPrestamo.php');
include_once ('GeneradorCorreos.php');

echo ControlProcesarSolicitud::procesar();

class ControlProcesarSolicitud {

    public static function procesar() {
        session_start();
        $usuario = $_SESSION['pibuserdata'];
        $telefono = $_POST['telefono'];
        $celular = $_POST['celular'];
        $correo = $_POST['correo'];
        $libros = $_POST['libros'];

        //$solicitud = new SolicitudPrestamo($usuario);
        $caso = new ControlCasoMantis('../lib/.configlistas');               
        $caso->configurarCasoMantis('187', 0, '../lib/.configlistadbd', $usuario->getIdentificacion(), ControlCasoMantis::$areas['none'], $telefono, $correo, ControlCasoMantis::$proyectosMantis['syri'], utf8_decode("Solicitud de préstamo interbibliotecario"), ControlCasoMantis::$prioridades['normal'], ControlCasoMantis::$severidades['media'], ControlCasoMantis::$estados['asignado'], ControlCasoMantis::$medios['sgs'], ControlCasoMantis::$oficinas['bib'], ControlCasoMantis::$tiposGestion['sol']);
        /* $caso->configurarCasoMantis('1130619373', 1, null, 
          $usuario->getIdentificacion(),
          ControlCasoMantis::$areas['none'],
          $usuario->getTelefono(), ControlCasoMantis::$proyectosMantis['syri'],
          "Solicitud de préstamo interbibliotecario",
          ControlCasoMantis::$prioridades['normal'],
          ControlCasoMantis::$severidades['media'],
          ControlCasoMantis::$estados['asignado'],
          ControlCasoMantis::$medios['sgs'],
          ControlCasoMantis::$oficinas['bib'],
          ControlCasoMantis::$tiposGestion['sol']); */
        $caso->casoBiblioteca(utf8_decode(ControlCasoMantis::$serviciosBiblioteca['pib']));
        //print_r($libros);
        $solicitud = new SolicitudPrestamo($usuario, $libros);
        $solicitud->setCelular($celular);
        $solicitud->setCorreo($correo);
        $solicitud->setTelefono($telefono);
        //echo $solicitud->imprimirSolicitud();
        $caso_id = $caso->crearCasoMantis(utf8_decode($solicitud->imprimirSolicitud()));
        //echo "caso_id: ".$caso_id;
        if ($caso_id != -1 && $caso_id != null) {
            //si se creo el caso se envian los correos
            GeneradorCorreos::confirmacionSolicitud($solicitud, $usuario, $caso_id);
            $correoUsuarioEncargado = $caso->correoEncargadoMantis();
            GeneradorCorreos::notificarEncargadoCaso($caso_id, $solicitud->imprimirSolicitudHTML(), $correoUsuarioEncargado);
            $jsonResponse['error'] = false;
            $jsonResponse['msg'] = 'Su solicitud ha sido procesada correctamente puede hacer seguimiento 
                            de la misma a través del sistema de gestión de solicitudes en el caso <a target="_blank"href="https://' . $_SERVER['SERVER_NAME'] . '/solicitud_servicios/view.php?id=' . $caso_id . '">' . $caso_id . '</a>';
        } else {
            $jsonResponse['error'] = true;
            $jsonResponse['msg'] = "Error tratando de crear su caso en el sistema de gesti&oacute;n de solicitudes";
        }

        return json_encode($jsonResponse);
    }

}

?>
