<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('Usuario.php');

/**
 * Description of SolicitudPrestamo
 *
 * @author 1130619373
 */
class SolicitudPrestamo {
    private $identificacion;
    private $nombre;
    private $telefono;
    private $celular;
    private $correo;
    private $libros=array();
    private $tipoSolicitante;
    private $usuario;

    /**
     * Contructor de la solicitud
     *
     * @param Usuario $usuario datos del usario que hace la solicitud
     */
    public function SolicitudPrestamo($usuario,$libros=null){
        $this->identificacion=$usuario->getIdentificacion();
        $this->nombre=$usuario->getNombre();
        $this->correo=$usuario->getEmail();
        $this->celular=$usuario->getCelular();        
        $this->telefono=$usuario->getTelefono();
        $this->tipoSolicitante=$usuario->getTipo();
        $this->libros=$libros;
        $this->usuario=$usuario;
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

    public function getCorreo() {
        return $this->correo;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    public function getLibros() {
        return $this->libros;
    }

    public function setLibros($libros) {
        $this->libros = $libros;
    }
    
    public function imprimirSolicitud(){
        $mensaje=
        "Solicitud de Préstamo interbibliotecario
            
        Datos del solicitante
        Tipo Usuario: ".strtoupper($this->usuario->getTipo())."
        Nombres y Apellidos: ".$this->nombre."
        Identificación: ".$this->identificacion."
        Correo: ".$this->correo."
        Teléfono: ".$this->telefono."
        Celular: ".$this->celular."
        ";
        if($this->usuario->getTipo()=='estudiante'){
            $mensaje.=
            "Código: ".$this->usuario->getCodigoEstudiante()."
             Programa: ".$this->usuario->getProgramaEstudiante()."             
             ";
            if($this->usuario->getSemestreEstudiante()==null ||$this->usuario->getSemestreEstudiante==''){
                $mensaje.=
                "Semestre: ".$this->usuario->getSemestreEstudiante()."
                 ";
            }
        }
        
        foreach ($this->libros as $key => $value) {
            $mensaje.= 
            "Libro ".($key+1)."
             Título: ".$value['titulo']."
             Edición: ".$value['edicion']."
             Autor: ".$value['autor']."
             Signatura: ".$value['signatura']."
             Institución: ".$value['institucion']."";
        }
        return $mensaje;
    }
    public function imprimirSolicitudHTML(){
        $mensaje=
        "<table>
        <tr>
        <td colspan=\"2\"><b>Datos del solicitante</b></td>
        </tr>
        <tr>
        <td>Tipo Usuario:</td><td> ".strtoupper($this->usuario->getTipo())."</td>
        </tr>
        <tr>
        <td>Nombres y Apellidos:</td><td> ".$this->nombre."</td>
        </tr>
        <tr>
        <td>Identificaci6oacute;n:</td> <td>".$this->identificacion."</td>
        </tr>
        <tr>
        <td>Correo:</td><td> ".$this->correo."</td>
        </tr>
        <tr>
        <td>Tel&eacute;fono:</td><td> ".$this->telefono."</td>
        </tr>
        <tr>
        <td>Celular: </td><td>".$this->celular."</td>
        </tr>
        ";
        if($this->usuario->getTipo()=='estudiante'){
            $mensaje.=
            "<tr>
             <td>C&oacute;digo:</td><td> ".$this->usuario->getCodigoEstudiante()."</td>
             </tr>
             <tr>
             <td>Programa:</td><td> ".$this->usuario->getProgramaEstudiante()."</td>
             </tr>
             ";
            if($this->usuario->getSemestreEstudiante()==null ||$this->usuario->getSemestreEstudiante==''){
                $mensaje.=
                "<tr>
                 <td>Semestre:</td><td> ".$this->usuario->getSemestreEstudiante()."</td>
                 </tr>
                 ";
            }
        }
        $mensaje.="</table>
            <table>
            <tr>
            <td colspan=\"2\"><b>Libros solicitados</b></td>
            </tr>";
        
        foreach ($this->libros as $key => $value) {
            $mensaje.= 
            "
            <tr>
            <td colspan=\"2\"><b>Libro</b> ".($key+1)."</td>
            </tr>
            <tr>
             <td>T&iacute;tulo:</td><td> ".$value['titulo']."</td>
             </tr>
             <tr>
             <td>Edici&oacute;n:</td><td> ".$value['edicion']."</td>
             </tr>
             <tr>
             <td>Autor:</td><td> ".$value['autor']."</td>
             </tr>
             <tr>
             <td>Signatura:</td><td> ".$value['signatura']."</td>
             </tr>
             <tr>
             <td>Instituci&oacute;n:</td><td> ".$value['institucion']."</td></tr>";
        }
        $mensaje.='</table>';
        return $mensaje;
    }


}
?>
