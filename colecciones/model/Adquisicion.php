<?php

/**
 * Description of Adquisición
 *
 * @author David Andrés Manzano - damanzano
 */
class Adquisicion {

    private $titulo;
    private $autores;
    private $link;
    private $ejemplares;

    /* propiedades autores */
    public function getAutores() {
        return $this->autores;
    }

    public function setAutores($autores) {
        $this->autores = $autores;
    }

    /* propiedades titulo */
    public function getTitulo() {
        return $this->titulo;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    /* propiedades link */
    public function getLink() {
        return $this->link;
    }

    public function setLink($link) {
        $this->link = $link;
    }


    public function getEjemplares() {
        return $this->ejemplares;
    }

    public function setEjemplares($ejemplares) {
        $this->ejemplares = $ejemplares;
    }



}
?>

