<?php
/**
 * Description of ElementoVideoteca
 *
 * @author David Andrés Manzano - damanzano
 */
class ElementoVideoteca {

    private $titleno;
    private $titulo;
    private $resumen;
    private $abstract;
    private $imagen;
    private $link;

    public function getTitleno() {
        return $this->titleno;
    }

    public function setTitleno($titleno) {
        $this->titleno = $titleno;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function getResumen() {
        return $this->resumen;
    }

    public function setResumen($resumen) {
        $this->resumen = $resumen;
    }

    public function getAbstract() {
        return $this->abstract;
    }

    public function setAbstract($abstract) {
        $this->abstract = $abstract;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    public function getLink() {
        return $this->link;
    }

    public function setLink($link) {
        $this->link = $link;
    }

}
?>

