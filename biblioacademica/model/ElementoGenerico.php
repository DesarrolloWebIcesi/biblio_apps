<?php
/**
 * Description of ElementoGenerico
 *
 * @author David Andrés Manzano - damanzano
 * @since 13/10/10
 */
class ElementoGenerico {
    /**
     * @var $id Identificador del elemento
     */
    private $id;
    /**
     * @var $descripcion Descripción del elemento
     */
    private $descripcion;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }



}
?>
