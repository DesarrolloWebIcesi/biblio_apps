<?php

/**
 * Description of ControlAreas
 *
 * @author David Andr&eacute;s Manzano - damanzano
 * @since 11/02/11
 *
 * @package biblio_icesi
 * @subpackage biblioacad&eacute;mica
 * 
 * @version 2.0 Se modificó para que utilizara la verisón 2 de la clase de conexión a oracle
 * @since 2012-08-03 damanzano
 */
include_once ('../model/Area.php');
include_once ('../../commons/services/OracleServices2.php');
class ControlAreas {

    private $elementos = array();

    /**
     * Retorna el tamaño del arreglo generado por la consulta.
     * @method Este método debe llamarse después de ejecutar la carga de la consulta con el método
     * cargarAreas(). Si se hace de manera previa a la ejecucion de la consulta
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
     * cargarAreas(). Si se hace de manera previa a la ejecucion de la consulta
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
     * cargarAreas(). Si se hace de manera previa a la ejecucion de la consulta
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
    public function cargarAreas() {
        //exit;
        $file = '../lib/.config';
        $bd = new OracleServices($file);
        $conecto = $bd->conectar();

        $idConsulta = 0;
        $sql = "select classmarkno noarea, classmark parea, description from classes where classtp = 'AREA' order by 1 asc";

        $idConsulta = $bd->ejecutarConsulta($sql);

        $elementos = array();
        while ($bd->siguienteFila($idConsulta)) {
            $elemento = new Area();
            $elemento->setId($bd->dato($idConsulta, 1));
            $elemento->setNombre($bd->dato($idConsulta, 3));            
            $elementos[] = $elemento;
        }
        $this->elementos = $elementos;
        $bd->desconectar();
    }

    /**
     * Este método devuelve el area identificada con el id pasado por parámetro
     *
     * @author damanzano
     * @since 12/02/11
     *
     * @param string $idarea identificador del area a buscar
     */
    public function getArea($idarea){
        $find=false;
        for($i=0;($i<$this->getSize() && $find==false);$i++){
            $area=$this->elementos[$i];
            if($area->getId()==$idarea){
                $find=true;
                return $area;
            }
         }
         return null;
    }

}
?>
