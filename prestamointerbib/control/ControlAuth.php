<?php

/**
 * En este archivo se llevan a cabo las validaciones de autenticación de usuarios
 *
 * @author David Andrés Manzano - damanzano
 */
include_once('LDAPAuth.php');
include_once ('ControlInfoUsuarios.php');

echo ControlAuth::procesar();

class ControlAuth {

    public static function procesar() {
        session_start();
        $ldapService = new LDAPAuth(null);

        $usuario = $_POST['puser'];
        $password = $_POST['ppassword'];
//echo "user: ".$usuario."<br/>";
//echo "user: ".$password."<br/>";

        $ldapResponse = $ldapService->autenticarUsuario($usuario, $password, LDAPAuth::ALL);
//echo "ldap: " . $ldapResponse;
//Proceso de respuesta
        $jsonResponse['error'] = true;

        switch ($ldapResponse) {
            case 0:
                $ldapuproper = $ldapService->getUserProperties();
                $ldapDNuproperties = $ldapService->getUserDNParts();
                $ldapugroups = $ldapService->getUserGroups();
                //print_r($ldapugroups);
                //echo '<pre>' . print_R($ldapDNuproperties) . '</pre>';        
                $userData = ControlInfoUsuarios::getUserData($usuario, $ldapuproper, $ldapDNuproperties, $ldapugroups);
                $_SESSION['pibuser'] = $usuario;
                $_SESSION['pibuserdata'] = $userData;
                $jsonResponse['error'] = false;
                $jsonResponse['dn'] = $ldapuproper[0]['dn'];
                $jsonResponse['msg'] = "Login satisfactorio";
                break;
            case 1:
                $jsonResponse['msg'] = "Su identificación no existe en la base de datos de la Universidad, por favor comun&iacute;quese con la Oficina de Admisiones y Registro (si es estudiante) o Personal (si es colaborador o profesor)";

                break;
            case 2:
                $jsonResponse['msg'] = "Identificaci&oacute;n o contrase&ntilde;a incorrectos";

                break;
            case 3:
                $jsonResponse['msg'] = "En este momento el sistema no est&aacute; disponible<br/>Por favor intente m&aacute;s tarde";

                break;
            default:
                $jsonResponse['msg'] = "Error desconocido";

                break;
        }

        return json_encode($jsonResponse);
    }

}

?>
