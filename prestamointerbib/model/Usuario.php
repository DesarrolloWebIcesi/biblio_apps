<?php

/**
 * Description of Usuario
 *
 * @author David Andrés Manzano - damanzano
 */
class Usuario {

    private $identificacion;
    private $nombre;
    private $telefono;
    private $celular;
    private $email;
    private $codigoEstudiante;
    private $programaEstudiante;
    private $semestreEstudiante;
    private $tipo;

    public function getIdentificacion() {
        return $this->identificacion;
    }

    public function setIdentificacion($identificacion) {
        $this->identificacion = $identificacion;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }
    
    public function getCelular() {
        return $this->celular;
    }

    public function setCelular($celular) {
        $this->celular = $celular;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getCodigoEstudiante() {
        return $this->codigoEstudiante;
    }

    public function setCodigoEstudiante($codigoEstudiante) {
        $this->codigoEstudiante = $codigoEstudiante;
    }

    public function getProgramaEstudiante() {
        return $this->programaEstudiante;
    }

    public function setProgramaEstudiante($programaEstudiante) {
        $this->programaEstudiante = $programaEstudiante;
    }

    public function getSemestreEstudiante() {
        return $this->semestreEstudiante;
    }

    public function setSemestreEstudiante($semestreEstudiante) {
        $this->semestreEstudiante = $semestreEstudiante;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }



}

?>
