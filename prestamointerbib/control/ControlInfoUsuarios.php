<?php

/**
 * Description of ControlInfoUsuarios
 * Esta clase se encarga de acceder a la base datos y extraer la información requerida por la aplicación
 * dependiedo del tipo se usuario
 *
 * @author David Andrés Manzano - damanzano
 * @since 20/01/11
 */
include_once '../model/Usuario.php';
include_once ('../../commons/services/OracleServices.php');
include_once ('../../commons/services/GeneralServices.php');

class ControlInfoUsuarios {

    static function getEstudiante($userObject) {
        //$file = '../lib/.config';
        $file = '../lib/.configlistadbd';
        $bd = new OracleServices($file);
        $conecto = $bd->conectar();
        $sql = "select max(h.semestre),p.DESCRIPCION programa, al.codigo, al.celular
                from tbas_alumnos al,tbas_hist_prog_estud h,tbas_programas p
                where al.numid =  '" .$userObject->getIdentificacion() . "' and h.PROGRAMA_CODIGO = p.CODIGO and al.codigo = h.ALUMNO_CODIGO and h.activo='S'
                and estado in ('N','P','I') group by al.codigo, al.celular, p.DESCRIPCION
                order by 1 desc";

        $idConsulta = $bd->ejecutarConsulta($sql);

        $elementos = array();        

        if ($bd->siguienteFila($idConsulta)) {
            $userObject->setSemestreEstudiante($bd->dato($idConsulta, 1));
            $userObject->setProgramaEstudiante($bd->dato($idConsulta, 2));
            $userObject->setCodigoEstudiante($bd->dato($idConsulta, 3));
            $userObject->setCelular($bd->dato($idConsulta, 4));
        }else{
            $sql="SELECT p.nombre PROGRAMA, e.codigo, e.celular
                  FROM ESTUDIANTE_POS e,PROGRAMA p
                  WHERE e.documento_id ='" .$userObject->getIdentificacion() . "'
                  AND e.COD_PROGRAMA =p.CODIGO
                  and e.termino='N'
                  and e.retirado='N'
                  GROUP BY e.documento_id,e.nombre||' '||e.apellidos,e.codigo,p.nombre";
            $idConsulta = $bd->ejecutarConsulta($sql);

            if ($bd->siguienteFila($idConsulta)) {                
                $userObject->setProgramaEstudiante($bd->dato($idConsulta, 1));
                $userObject->setCodigoEstudiante($bd->dato($idConsulta, 2));
                $userObject->setCelular($bd->dato($idConsulta, 3));
            }

        }
        $bd->desconectar();
        return $userObject;
//        //echo "entro aqui 3 <br/>";
//        include_once("../clases_biblioteca/class/conexion_oracle.inc");
//        $bd = new conexion_oracle();
//        $file = '../clases_biblioteca/lib/.configlistas';
//        $bd->leerarchivo($file);
//        $bd->conectar($bd->usuario, $bd->password, $bd->db);
//        $sql = "select al.nombre||' '|| al.apellidos nombres,max(h.semestre),p.DESCRIPCION programa, al.codigo " .
//                "from tbas_alumnos al,tbas_hist_prog_estud h,tbas_programas p " .
//                "where al.numid =  '" . $identificacion_est . "' and h.PROGRAMA_CODIGO = p.CODIGO and al.codigo = h.ALUMNO_CODIGO and h.activo='S' " .
//                "and estado in ('N','P','I') group by al.nombre||' '|| al.apellidos,al.codigo ,p.DESCRIPCION";
//
//        $s = 0;
//        $s2 = 0;
//        $idct = $bd->idcone();
//        $s = $bd->procesa($idct, $sql);
//        OCIExecute($s, OCI_DEFAULT);
//        $nombre = " ";
//        $codigo = " ";
//        $semestre = " ";
//        $programa = " ";
//
//        if ($bd->numfect($s)) {
//            $nombre = $bd->datos($s, 1);
//            $semestre = $bd->datos($s, 2);
//            $programa = $bd->datos($s, 3);
//            $codigo = $bd->datos($s, 4);
//        } else {
//            $sql2 = "SELECT e.nombre||' '||e.apellidos , p.nombre PROGRAMA, e.codigo " .
//                    "FROM ESTUDIANTE_POS e,PROGRAMA p " .
//                    "WHERE e.documento_id ='" . $identificacion_est . "' AND e.COD_PROGRAMA =p.CODIGO and e.termino='N' and e.retirado='N' " .
//                    "GROUP BY e.documento_id,e.nombre||' '||e.apellidos,e.codigo,p.nombre";
//            $s2 = $bd->procesa($idct, $sql2);
//            OCIExecute($s2, OCI_DEFAULT);
//            if ($bd->numfect($s2)) {
//                $nombre = $bd->datos($s2, 1);
//                $semestre = "-";
//                $programa = $bd->datos($s2, 2);
//                $codigo = $bd->datos($s2, 3);
//            }
//        }
//
//        $xml2 = $codigo . "," . $identificacion_est . "," . $nombre . "," . $programa . "," . $semestre;
//
//
//        return $xml2;
    }

    static function getProfesor($userObject) {
        $file = '../lib/.configlistadbd';
        $bd = new OracleServices($file);
        $conecto = $bd->conectar();
        $sql = "select pr.celular from tbas_profesores pr where pr.CEDULA = '" . $userObject->getIdentificacion() . "'";

        $idConsulta = $bd->ejecutarConsulta($sql);

        $elementos = array();
        $i = 0;

        if ($bd->siguienteFila($idConsulta)) {
            $userObject->setCelular($bd->dato($idConsulta, 1));
        }
        $bd->desconectar();
        return $userObject;

//        $sql = "select distinct pr.NOMBRE||' '||pr.APELLIDOS, pr.CEDULA from tbas_profesores pr, tbas_cursos_profesor tp where pr.CEDULA = '" . $identificacion_prof . "' and (select count('c') " .
//                " from tbas_cursos_profesor tp where tp.profesor_cedula = '" . $identificacion_prof . "' and tp.periodo_periodo_acad =  (select fprebus_constantes('002','03','') from dual) " .
//                "and tp.periodo_consecutivo = (select fprebus_constantes('002','04','') from dual))>0 and fpreval_curso_activo ( profesor_cedula, tp.periodo_periodo_acad, " .
//                "tp.periodo_consecutivo, tp.descripmat_codigo, tp.descripmat_consecutivo)  = 'S'";

    }

    static function getColaborador($userObject) {
        $file = '../lib/.configlistadbd';
        $bd = new OracleServices($file);
        $conecto = $bd->conectar();
        $sql = "select em.celular from empleado em where em.cedula = '" . $userObject->getIdentificacion() . "'";

        $idConsulta = $bd->ejecutarConsulta($sql);

        $elementos = array();
        $i = 0;

        if ($bd->siguienteFila($idConsulta)) {
            $userObject->setCelular($bd->dato($idConsulta, 1));
        }
        $bd->desconectar();
        return $userObject;
    }    

    static function getUserData($identification, $userProperties, $userDNProperties,$userGroups) {
        $userData = new Usuario();
        $userData->setIdentificacion($identification);
        $userData->setNombre($userProperties[0]['givenname'][0] . " " . $userProperties[0]['sn'][0]);
        $userData->setEmail($userProperties[0]['mail_preferido'][0]);
        $userData->setTelefono($userProperties[0]['homephone'][0]);
        
        //determinar tipo de usuario
        //echo "gruposDN: ".print_r($userGroups);
        $groups=array();
        for($i=1;$i<count($userGroups);$i++){
            $group=$userGroups[$i];          
            $groupparts=explode(",", $group);
            $groups[]=str_replace("cn=", "", $groupparts[0]);
        }
        //print_r($groups);
        //$userType = str_replace("cn=", "", $userDNProperties[1]);

        //recorrer el arreglo de grupos para asociar el tipo de usuario
        //1.buscar si es estudiante
        $pregado=in_array("pregrado", $groups);
        $pregrado_a=in_array("pregrado_a", $groups);
        $postgrado=in_array("postgrado", $groups);
        if($pregado || $postgrado || $pregrado_a){
            $userData->setTipo("estudiante");
            return ControlInfoUsuarios::getEstudiante($userData);
        }

        //2.Buscar si es profesor hora/catedra
        $profesor=in_array("profesor", $groups);
        $profesor_a=in_array("profesor_a", $groups);
        if($profesor || $profesor_a){
            $userData->setTipo("profesor");
            return ControlInfoUsuarios::getProfesor($userData);
        }
        
        //3.Buscar se es investigador
        $investigador=in_array("investigadores", $groups);
        $investigador_a=in_array("investigadores_a", $groups);
        if($investigador || $investigador_a){
            $userData->setTipo("investigador");
            return ControlInfoUsuarios::getProfesor($userData);
        }
        
        //4. Busca si es empleado
        $empleado=in_array("empleado", $groups);
        if($empleado){
            $userData->setTipo("colaborador");
            return ControlInfoUsuarios::getColaborador($userData);
        }        
        return $userData;
    }

}

?>
