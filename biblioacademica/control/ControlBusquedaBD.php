<?php

/**
 * Description of ControlBusquedaBD
 * Esta Clase se encarga de ejecutar la busqueda de los elementos de base de datos
 * según los parametros establecidos por los usuarios y de almacenar los resultados en
 * un arreglo para su consulta.
 *
 * @author David Andrés Manzano - damanzano
 * @since 13/10/10
 * 
 * @version 2.0 Se modificó para que utilizara la verisón 2 de la clase de conexión a oracle
 * @since 2012-08-03 damanzano
 */
include_once ('../model/ElementoBD.php');
include_once ('../../commons/services/OracleServices2.php');

class ControlBusquedaBD {

    private $elementos = array();

    /**
     * Retorna el tamaño del arreglo generado por la consulta.
     * @method Este método debe llamarse después de ejecutar la carga de la consulta con el método
     * cargarSearchBD($cont, $pBD, $pArea, $pTipoAcceso). Si se hace de manera previa a la ejecucion de la consulta
     * se estará obteniedo un valor inconsistente.
     *
     * @author damanzano
     * @since 13/10/10
     */
    public function getSize() {
        return count($this->elementos);
    }

    /**
     * Retorna  un subarreglo del generado por la consulta de acuerdo a los parametros establecidos.
     * @method Este método debe llamarse después de ejecutar la carga de la consulta con el método
     * cargarSearchBD($cont, $pBD, $pArea, $pTipoAcceso). Si se hace de manera previa a la ejecucion de la consulta
     * se estará obteniedo un valor inconsistente.
     *
     * @author damanzano
     * @since 13/10/10
     *
     * @param int $cont Indica a partir de que posición del arreglo original se desa el subarreglo.
     * @param int $size Indica el tamaños del subarreglo deseado.
     */
    public function getElementosDesde($cont, $size) {
        $newElementos = array();
        for ($i = $cont, $j = 0; ($i < count($this->elementos) && $j < $size); $i++, $j++) {
            $newElementos[] = $this->elementos[$i];
        }
        return $newElementos;
    }

    /**
     * Retorna el  arreglo generado por la consulta.
     * @method Este método debe llamarse después de ejecutar la carga de la consulta con el método
     * cargarSearchBD($cont, $pBD, $pArea, $pTipoAcceso). Si se hace de manera previa a la ejecucion de la consulta
     * se estará obteniedo un valor inconsistente.
     *
     * @author damanzano
     * @since 13/10/10
     */
    public function getElementos() {
        return $this->elementos;
    }

    /**
     * Este método se encarga de buscar las bases de datos registradas en el sistema que coincidan con
     * los parametrós de búsqueda
     *
     * @author damanzano
     * @since 13/10/10
     *
     * @param string $pBD nombre de la base de datos
     * @param string $pArea area en la que se clasifica la base de datos
     * @param string $pTipoAcceso tipo de acceso a la base de datos
     */
    public function cargarSearchBD($cont, $pArea) {
        //exit;
        $file = '../lib/.config';
        $bd = new OracleServices($file);
        $conecto = $bd->conectar();

        $idConsulta = 0;
        $sql = "select distinct tb.titleno titleid, upper(tb.title) titulo,
                fbibbus_resumen(tb.titleno) resumen, fbibbus_accesos ( tb.titleno ) tipo_acceso,
                fbibbus_objeto ( tb.titleno, '".utf8_decode('más información')."' ) masinfo, fbibbus_objeto ( tb.titleno, 'imagen' ) imagen,
                fbibbus_objeto ( tb.titleno, 'consultar' ) link_cons from titles tb
                where tb.titleno in (
                    select distinct decode(t.articleno,null,t.titleno,(select t1.titleno from titles t1 where t1.titleno = t.articleno)) titleno 
                    from titles t, copies c, classes cl, titleclasses tc where c.copycat = 'BD' 
                    and cl.classtp = 'AREA' 
                    and cl.classmarkno = '".$pArea."' 
                    and tc.titleno = c.titleno 
                    and tc.classmarkno = cl.classmarkno 
                    and tc.titleno = t.titleno)  
                    order by 2 asc";        

        $idConsulta = $bd->ejecutarConsulta($sql);

        $elementos = array();
        $i = 0;

        while ($bd->siguienteFila($idConsulta)) {
            $i = $i + 1;

            $elemento = new ElementoBD();
            $elemento->setTitleno($bd->dato($idConsulta, 1));
            $elemento->setBiblio($bd->dato($idConsulta, 2));
            $resumen = $bd->dato($idConsulta, 3);
            $tipoAcceso = $bd->dato($idConsulta, 4);
            $masInfo = $bd->dato($idConsulta, 5);


            $imagen = $bd->dato($idConsulta, 6);
            $enlaceConsultar = $bd->dato($idConsulta, 7);

            if ($resumen != null && $resumen != "null") {
                $elemento->setResumen($resumen);
            } else {
                $elemento->setResumen("");
            }

            if ($imagen != null && $imagen != "null") {
                $elemento->setImagen($imagen);
            } else {
                $elemento->setImagen("");
            }
            $elemento->setMasInfo($masInfo);
            $elemento->setTipoAcceso($tipoAcceso);
            $elemento->setEnlaceConsultar($enlaceConsultar);


            $elementos[] = $elemento;
        }

        $this->elementos = $elementos;
        $bd->desconectar();
    }

}

?>
