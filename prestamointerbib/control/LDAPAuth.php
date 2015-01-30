<?php

/**
 * Description of LDAPAuth
 *
 *
 * @author David Andrés Manzano - damanzano
 * @since 13/01/11
 */
include_once('ControlCasoMantis.php');

class LDAPAuth {

    private $server;
    private $userProperties = array();
    private $userDNParts = array();
    private $userGroups=array();
    private $userType;
    private $connection;
    const PROFESORES_OC="cn=profesores,cn=users,dc=icesi,dc=edu,dc=co";
    const COLABORADORES="cn=colaboradores,cn=users,dc=icesi,dc=edu,dc=co";
    const TEMPORALES="cn=temporales,cn=users,dc=icesi,dc=edu,dc=co";
    const ESTUDIANTES_PRE="";
    const ESTUDIANTES_POST="";
    const ALL="cn=users,dc=icesi,dc=edu,dc=co";
    const DNANONIMO="cn=busqueda,cn=dsistemas,cn=users,dc=icesi,dc=edu,dc=co";
    const PASSANONIMO="lK3Bs0o";
    const DNSEARCH="cn=users,dc=icesi,dc=edu,dc=co";

    /**
     * Constructor de la clase
     *
     * @param string $pserver url del servidor ldap al que se desea conectar.
     */
    function LDAPAuth($pserver) {
        if ($pserver == null || $pserver == '') {
            $this->server = "ldap://iden.icesi.edu.co/";
        } else {
            $this->server = $pserver;
        }
    }

    /**
     * Esta función se encarga de validar la autenticación de un usuario contra
     * el servidor LDAP.
     *
     * @author aorozco, damanzano
     * @since 14/01/11
     *
     * @param string $nombreUsuario nombre de usuario unico
     * @param string $clave password de acceso
     * @param string $grupo Grupo contra el que se desea loguear.
     */
    function autenticarUsuario($nombreUsuario, $clave, $grupo=self::ALL) {
        if ($this->buscarUsuario($nombreUsuario)) {
            //echo "encontro el usuario: " . $this->userProperties[0]['dn'];
            $userDN = $this->userProperties[0]['dn'];
            $this->buscarGrupos($userDN);

            $this->connection = ldap_connect($this->server);
            if (!$this->connection) {
                return 3;
            }

            if (!ldap_set_option($this->connection, LDAP_OPT_PROTOCOL_VERSION, 3)) {
                return 3;
            }

            //echo 'cadena: ' . $userDN . '<br/>';
            //echo 'clave:' . $clave . '<br/>';
            $bind = @ldap_bind($this->connection, $userDN, $clave);
            if ($bind) {
                ldap_unbind($this->connection);
                return 0; // se logueo bien
            } else {
                ldap_unbind($this->connection);
                return 2; // usuario y/o contraseña erroneos
            }
        } else {
            //ldap_unbind($this->connection);
            return 1; //no existe
        }
    }
    /**
     * Este m&eacute;todo consulta los grupos de ldap a los que pertenece el
     * usuario logueado.
     *
     * @author Julio Cesar Chaves - jcchaves
     * @since 28/01/11
     *
     * @param string $userDN cadena DN del usuario logueado.
     */
    function buscarGrupos($userDN){
            $this->connection = ldap_connect($this->server);
            if (!$this->connection) {
                return 3;
            }

            if (!ldap_set_option($this->connection, LDAP_OPT_PROTOCOL_VERSION, 3)) {
                return 3;
            }

        $bindAnonimo = @ldap_bind($this->connection, self::DNANONIMO, self::PASSANONIMO);
        $filtro = "(uniquemember=" . $userDN . ")";
        $sr = @ldap_search($this->connection, "cn=groups,dc=icesi,dc=edu,dc=co", $filtro);
        if (sr === false) {
            ldap_unbind($bindAnonimo);
            return false;
        } else {
            $entries = @ldap_get_entries($this->connection, $sr);
            //echo print_r($this->userProperties);
            foreach($entries as $entry){
                $this->userGroups[]=$entry['dn'];
            }
            ldap_unbind($this->connection);
            return true;
        }
    }

    /**
     * Este método busca a un usuario dentro del servidor ldap
     */
    function buscarUsuario($idUsuario) {
        $this->connection = ldap_connect($this->server);
        $bindAnonimo = @ldap_bind($this->connection, self::DNANONIMO, self::PASSANONIMO);
        $filtro = "(cn=" . $idUsuario . ")";
        $sr = @ldap_search($this->connection, "cn=users,dc=icesi,dc=edu,dc=co", $filtro);
        if (sr === false) {
            ldap_unbind($dsAnonimo);
            return false;
        } else {
            $this->userProperties = @ldap_get_entries($this->connection, $sr);
            //echo print_r($this->userProperties);
            if (count($this->userProperties) > 0) {
                $this->userDNParts = ldap_explode_dn($this->userProperties[0]['dn'], 0);

                if($this->userProperties[0]['dn']== null || $this->userProperties[0]['dn']==''){
                    ldap_unbind($bindAnonimo);
                    return false;
                }
                ldap_unbind($this->connection);
                return true;
            }
            ldap_unbind($bindAnonimo);
            return false;
        }
        
    }

    public function getUserProperties() {
        return $this->userProperties;
    }

    public function getUserType() {
        return $this->userType;
    }

    public function getUserDNParts() {
        return $this->userDNParts;
    }

    public function getUserGroups() {
        return $this->userGroups;
    }
}

?>