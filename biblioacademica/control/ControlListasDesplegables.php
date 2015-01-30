<?php

/**
 * Description of ControlListasDesplegables
 * Esta clase se encargar de llenar los arreglos que se utilizaran en las listas desplegables
 * con la información correspondiente a cada lista en la base de datos
 *
 * @author David Andrés Manzano - damanzano
 * @since 15/10/10
 * 
 * @version 2.0 Se modificó para que utilizara la verisón 2 de la clase de conexión a oracle
 * @since 2012-08-03 damanzano
 */
include_once ('../model/ElementoGenerico.php');
include_once ('../model/Area.php');
include_once ('../../commons/services/OracleServices2.php');

class ControlListasDesplegables {

    /**
     * @var $nombreBD Arreglo de nombres de bases de datos registradas en el sistema
     */
    private static $nombresBD = array();
    /**
     * @var $tiposAcceso Arreglo de tipos de acceso de las bases de datos
     */
    private static $tiposAcceso = array();
    /**
     * @var $areasBD Arreglo de los diferentes tipos de áreas en las que se clasifican las bases de datos
     */
    private static $areasBD = array();
    /**
     * @var $areasAqd Arreglo de las diferentes áreas para las que se consultan nuevas adquisiciones
     */
    private static $areasAdq = array();

    public static function getNombresBD() {
        self::cargarNombresBD();
        return self::$nombresBD;
    }

    public static function getTiposAcceso() {
        self::cargarTiposAcceso();
        return self::$tiposAcceso;
    }

    public static function getAreasBD() {
        self::cargarNombresAreasBD();
        return self::$areasBD;
    }

    public static function getAreasAdq() {
        self::cargarAreasAdq();
        return self::$areasAdq;
    }

    /**
     * Este método carga los nombre de las bases de datos registrados en el sistema
     *
     * @author damanzano
     * @since 15/10/10
     */
    private static function cargarNombresBD() {
        $file = '../lib/.config';
        $bd = new OracleServices($file);
        $bd->conectar();
        $idConsulta = 0;

        $sql = "select distinct decode(t.articleno,null,t.titleno,(select t1.titleno from titles t1 where t1.titleno = t.articleno)) ptitleno, " .
                "upper(decode(t.articleno,null,t.title,(select t1.title from titles t1 where t1.titleno = t.articleno))) titulo " .
                "from titles t, copies c, classes cl, titleclasses tc " .
                "where c.copycat = 'BD' and t.mediatp <> 'SISS' and cl.classtp = 'AREA' " .
                "and tc.titleno = c.titleno and tc.classmarkno = cl.classmarkno and tc.titleno = t.titleno " .
                "order by 2 asc";


        $idConsulta = $bd->ejecutarConsulta($sql);

        $elementos = array();
        while ($bd->siguienteFila($idConsulta)) {
            $elemento = new ElementoGenerico();
            $elemento->setId($bd->dato($idConsulta, 1));
            $elemento->setDescripcion($bd->dato($idConsulta, 2));

            if (strlen($elemento->getDescripcion()) > 35) {
                $elemento->setDescripcion(substr($elemento->getDescripcion(), 0, 35) . "...");
            }
            $elementos[] = $elemento;
        }
        self::$nombresBD = $elementos;
        $bd->desconectar();
    }

    /**
     * Este método carga los difenrentes tipos de acceso que tienen las bases de datos.
     *
     * @author damanzano
     * @since 15/10/10
     */
    private static function cargarTiposAcceso() {
        $file = '../lib/.config';
        $bd = new OracleServices($file);
        $bd->conectar();
        $idConsulta = 0;

        $sql = "select distinct decode(notetp,'LOCAL','L',decode(notetp,'LOCD','F','R')) ptipo ,  note  from titlenotes  where notetp in ( 'LOCD', 'LOCAL', 'AREM' )";

        $idConsulta = $bd->ejecutarConsulta($sql);

        $elementos = array();
        while ($bd->siguienteFila($idConsulta)) {
            $elemento = new ElementoGenerico();
            $elemento->setId($bd->dato($idConsulta, 1));
            $elemento->setDescripcion($bd->dato($idConsulta, 2));
            $elementos[] = $elemento;
        }
        self::$tiposAcceso = $elementos;
        $bd->desconectar();
    }

    /**
     * Este método carga el listado de areas en las que se clasifican las bases de datos
     *
     * @author damanzano
     * @since 15/10/10
     */
    private static function cargarNombresAreasBD() {
        $file = '../lib/.config';
        $bd = new OracleServices($file);
        $bd->conectar();
        $idConsulta = 0;

        $sql = "select classmarkno noarea, classmark parea from classes where classtp = 'AREA' order by 1 asc";

        $idConsulta = $bd->ejecutarConsulta($sql);

        $elementos = array();
        while ($bd->siguienteFila($idConsulta)) {
            $elemento = new ElementoGenerico();
            $elemento->setId($bd->dato($idConsulta, 1));
            $elemento->setDescripcion($bd->dato($idConsulta, 2));

            if (strlen($elemento->getDescripcion()) > 35) {
                $elemento->setDescripcion(substr($elemento->getDescripcion(), 0, 35) . "...");
            }
            $elementos[] = $elemento;
        }
        self::$areasBD = $elementos;
        $bd->desconectar();
    }

    /**
     * Este método carga el listado de áreas para las cuales se hacen consultas de nuevas adquisiciones.
     *
     * @author damanzano
     * @since 26/10/10
     */
    private static function cargarAreasAdq() {
        $file = '../lib/.config';
        $bd = new OracleServices($file);
        $bd->conectar();
        $idConsulta = 0;

        $sql = "select distinct cl.classmark area, cl.classmarkno p_id_area from order_items oi, orders o, titles t, titleclasses tc, classes cl where o.ord_orderno = oi.oi_orderno and oi.oi_datereq >= (sysdate - 30) and t.titleno = oi.oi_titleno and t.titleno = tc.titleno and tc.classmarkno = cl.classmarkno and cl.classtp = 'AREA' order by cl.classmark asc";
        $idConsulta = $bd->ejecutarConsulta($sql);

        $elementos = array();
        while ($bd->siguienteFila($idConsulta)) {
            $elemento = new Area();
            $elemento->setId($bd->dato($idConsulta, 2));
            $elemento->setNombre($bd->dato($idConsulta, 1));
            $elementos[] = $elemento;
        }
        self::$areasAdq = $elementos;
        $bd->desconectar();
    }

}

?>
