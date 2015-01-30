<?php

/**
 * Description of CasoMantis
 *
 * Esta clase contiene todas las funciones usadas para crear los casos en Mantis
 * con la información proporcionada por el formulario de prestamo interbibliotecario.
 *
 * @author David Andrés Manzano - damanzano
 */
include_once('GeneradorCorreos.php');
include_once ('../../commons/services/OracleServices.php');
include_once ('../../commons/services/MySQLServices.php');

class ControlCasoMantis {

    private $bdMantis;
    private $idProyectoMantis;
    private $cedulaEncargadoMantis;
    private $idEncargadoMantis;
    private $idInformadorMantis;
    private $areaInformadorMantis;
    private $correoInformadorMantis;    
    private $resumenCasoMantis; //titulo del caso
    private $idPrioridadMantis;
    private $idSeveridadMantis;
    private $idReproductibilidadMantis = 10;
    private $idEstadoMantis; // estados del caso reemplazó a idEstadoNuevoMantis idEstadoAsignadoMantis
    private $idResolucionMantis = 10;
    private $idProyeccionMantis = 0;
    private $idCategoriaMantis = "";
    private $idEtaMantis = 0;
    private $idPerfilMantis = 0;
    private $idEstadoVistaMantis = 50;
    private $idSponsorMantis = 0;
    private $idStickyMantis = 0;
    private $areaCasoMantis = 'SYRI';
    private $extensionUsuarioCasoMantis = 'N/A';
    private $tipoNotaCasoMantis = 0;
    private $cantidadCerosHistoricoNota = 7; //Este valor debe ser igual a $g_display_bugnote_padding en la configuración de Mantis (config_inc.php)
    private $medioCasoMantis;
    private $oficinaCasoMantis;
    private $tipoGestionCasoMantis;
    private $modoAtencionCasoMantis = 'N/A';
    //variables para casos de desarrollo
    private $ambienteDESCasoMantis; //DES Ambiente
    private $causasCasoMantis;      //DES Causa
    private $serviciosDesarrolloCasoMantis;   //DES Servicios
    private $objetoDesarrolloCasoMantis; //DES Objeto
    private $proyectoDesarrolloCasoMantis;
    //variables para casos de biblioteca
    private $servicioBibliotecaCasoMantis;   //BIB Servicios
    private $materialesCasoMantis;     //BIB Material
    private $departamentoAcademicoCasoMantis;   //BIB Departamentos Académicos
    private $programaBibiliotecaCasoMantis;
    private $profesorBibliotecaCasoMantis;
    //variables para operaciones
    private $serviciosOperacionalesCasoMantis;   //OPE Servicios
    private $tipoOperacionalesCasoMantis; // OPE tipo
    //variables Infraestructura
    private $serviciosinfraestructuraCasoMantis;  //INF Servicios
    private $aplicacionesInfraestructuraCasoMantis; //INF Aplicaciones
    private $conectividadCasoMantis;     //INF Conectividad
    private $hardwareCasoMantis;      //INF Hardware
    private $cierreInfraestructura;
    //variables E-learning
    private $servicioElearningCasoMantis;
    private $tipoElearningCasosMantis;
    private $causaElearningCasoMantis;
    private $aplicacionElearningCasoMantis;
    //variables Procesos
    private $servicioProcesosCasoMantis;    //PRO Servicios
    private $condicionesPrestacionCasoMantis = 'N/A';   //Condiciones de Prestación
    private $condicionesEntregaCasoMantis = 'N/A';   //Condiciones de Entrega
    private $tiempoResolucionCasoMantis = "HH:MM";
    private $ANSCumplidoCasoMantis = "N/A";
    private $fechaEntregaCasoMantis = null;
    private $horaEntregaCasoMantis = "HH:MM";

    /* Listas de opciones */
    public static $proyectosMantis = array('syri' => 14);
    public static $prioridades = array('ninguna' => 10, 'baja' => 20, 'normal' => 30, 'alta' => 40, 'inmmediata' => 60, 'urgente' => 80);
    public static $severidades = array('baja' => 10, 'media' => 20, 'alta' => 30);
    public static $estados = array('nuevo' => 10, 'asignado' => 50);
    public static $medios = array('sgs' => 'SGS', 'mail' => 'Correo electrónico', 'tel' => 'Telfónico', 'per' => 'Personal');
    public static $areas = array('rec' => 'Rectoría',
        'daf' => 'Dirección Administrativa y Financiera',
        'cdee' => 'Centro de Desarrollo del Espirítu Empresarial',
        'mi' => 'Mercadeo Institucional',
        'bu' => 'Bienestar Universitario y Secretaría General',
        'dac' => 'Dirección Académica',
        'fvl' => 'FVL',
        'fcae' => 'Facultad de Ciencias Administrativas y Económicas',
        'fing' => 'Facultad de Ingeniería',
        'fdcs' => 'Facultad de Derecho y Ciencias Sociales',
        'fcn' => 'Facultad de Ciencias Naturales',
        'fcs' => 'Facultad de Ciencias de la Salud',
        'femp' => 'Fondo de empleados',
        'cideim' => 'CIDEIM',
        'syri' => 'SYRI',
        'none'=> 'Ninguna');
    public static $oficinas = array('bib' => 'Biblioteca',
        'des' => 'Desarrollo de sistemas',
        'eler' => 'E-Learning',
        'inf' => 'Infraestructura',
        'ope' => 'Operaciones',
        'pro' => 'Procesos',
        'asg' => 'Por asignar...');
    public static $tiposGestion = array('sol' => 'Solicitud',
        'inc' => 'Incidente',
        'adm' => 'Administrativo',
        'proy' => 'Proyecto',
        'cam' => 'Cambio',
        'qor' => 'Queja o reclamo',
        'sug' => 'Sugerencia');
    public static $materialesBiblioteca = array('lib' => "Libros", 'auv' => "Material audiovisual", 'col' => "Casos o lecturas", 'sus' => "Suscripciones");
    public static $serviciosBiblioteca = array('bdigital' => 'Biblioteca digital',
        'cap' => 'Capacitaciones en servicios y recursos bibliográficos',
        'cbd' => 'Consulta de base de datos bibliográficas',
        'dtc' => 'Divulgación de tablas de contenido de revistas',
        'opd' => 'Obtención y proceso técnico de documentos',
        'pres' => 'Préstamo general',
        'pib' => 'Préstamo interbibliotecario',
        'ref' => 'Referencia bibliográfica');
    public static $serviciosDesarollo = array();
    public static $proyectosDesarrollo = array();
    public static $ambientesDesarrollo = array();
    public static $causasDesarrollo = array();
    public static $serviciosOperaciones = array();
    public static $tiposOperaciones = array();
    public static $serviciosInfraestructura = array();


    public function ControlCasoMantis($bdMantisFile) {
        //echo $bdMantisFile;
        $this->bdMantis = new MySQLServices($bdMantisFile);
    }

    public function configurarCasoMantis($encargado, $tipo_encargado, $conexion_encargado,$informador, $area_informador, $ext_informador,$correo_informador, $proyecto, $titulo, $prioridad, $severidad, $estado, $medio, $oficina, $tipo_gestion) {
        if ($tipo_encargado == 0) {
            $this->cedulaEncargadoMantis = $this->obtenerCedulaEncargadoCasoMantis($encargado,$conexion_encargado);
            $this->idEncargadoMantis = $this->obtenerIdUsuarioMantis($this->cedulaEncargadoMantis);
        } else {
            $this->idEncargadoMantis = $this->obtenerIdUsuarioMantis($encargado);
        }

        $this->idInformadorMantis = $this->obtenerIdUsuarioMantis($informador);
        $this->areaInformadorMantis=$area_informador;
        $this->correoInformadorMantis=$correo_informador;
        $this->extensionUsuarioCasoMantis=$ext_informador;
        $this->idProyectoMantis = $proyecto;
        $this->resumenCasoMantis = substr($titulo, 0, 127);
        $this->resumenCasoMantis = str_replace("'", "\'", $this->resumenCasoMantis);
        $this->idPrioridadMantis = $prioridad;
        $this->idSeveridadMantis = $severidad;
        $this->idEstadoMantis = $estado;
        $this->medioCasoMantis = $medio;
        $this->oficinaCasoMantis = $oficina;
        $this->tipoGestionCasoMantis = $tipo_gestion;
    }

    public function casoBiblioteca($servicio, $materiales='N/A', $deptoAcademico='N/A', $progAcademico='N/A', $profesor='N/A') {
        $this->servicioBibliotecaCasoMantis = $servicio;        
        $this->materialesCasoMantis = $materiales;
        $this->departamentoAcademicoCasoMantis = $deptoAcademico;
        $this->programaBibiliotecaCasoMantis = $progAcademico;
        $this->profesorBibliotecaCasoMantis = $profesor;
    }

    public function casoDesarrollo() {
        $this->ambienteDESCasoMantis = "N/A";
        $this->serviciosDesarrolloCasoMantis = "N/A";
        $this->causasCasoMantis = "N/A";
    }

    public function casoOperaciones() {
        $this->serviciosOperacionalesCasoMantis = "N/A";
    }

    public function casoInfraestructura() {
        $this->serviciosInfraestructuraCasoMantis = "N/A";
        $this->aplicacionesInfraestructuraCasoMantis = "N/A";
        $this->conectividadCasoMantis = "N/A";
        $this->hardwareCasoMantis = "N/A";
    }

    public function casoProcesos() {
        $this->servicioProcesosCasoMantis = "N/A";
    }

    function obtenerIdUsuarioMantis($cedulaUsuario) {
        
        $this->bdMantis->conectar();
        $sql = "SELECT id FROM mantis_user_table WHERE username='" . $cedulaUsuario . "';";
        //echo "sql: ".$sql;
        $resultado = $this->bdMantis->ejecutarConsulta($sql);
        $fila = $this->bdMantis->siguienteFila($resultado);
        $idUsuarioMantis = $fila[0];        
        $this->bdMantis->desconectar();

        return $idUsuarioMantis;
    }

    public function crearCasoMantis($datosSolicitud, $nombre_informador=null) {

        //Si el usuario encargado no está registrado en la Base de Datos de Mantis, se cancela la creación del caso.
        if (is_null($this->idEncargadoMantis)) {
            return -1;
            die;
        }

        //Si el usuario solicitante no está registrado en la Base de Datos de Mantis, se cancela la creación del caso.
        if (is_null($this->idInformadorMantis)) {
            return -2;
            die;
        }
        
        $this->bdMantis->conectar();
        $datosSolicitud = str_replace("'", "", $datosSolicitud);
        
        $sql = "INSERT INTO mantis_bug_text_table (description, steps_to_reproduce, additional_information)
	        VALUES ('" . $datosSolicitud . "', '', '')";
        //echo "Consulta: ".$sql;
        $resultado = $this->bdMantis->ejecutarConsulta($sql);

        if ($resultado) {
            $sql = "INSERT INTO mantis_bug_table (project_id, reporter_id, handler_id, duplicate_id, priority, severity, reproducibility, status, resolution, projection, date_submitted, last_updated, eta, bug_text_id, profile_id, view_state, summary, sponsorship_total, sticky)
		      VALUES (%id_proyecto%, %id_informador_mantis%, %id_encargado_mantis%, 0, %id_prioridad%, %id_severidad%, %id_reproductibilidad%, %id_estado_asignado%, %id_resolucion%, %id_proyeccion%, UNIX_TIMESTAMP(SYSDATE()), UNIX_TIMESTAMP(SYSDATE()), %id_eta%, LAST_INSERT_ID(), %id_perfil%, %id_estado_vista%, '%resumen_caso%', %id_sponsor%, %id_sticky%)";

            $sql = str_replace("%id_proyecto%", $this->idProyectoMantis, $sql);
            $sql = str_replace("%id_informador_mantis%", $this->idInformadorMantis, $sql);
            $sql = str_replace("%id_encargado_mantis%", $this->idEncargadoMantis, $sql);
            $sql = str_replace("%id_prioridad%", $this->idPrioridadMantis, $sql);
            $sql = str_replace("%id_severidad%", $this->idSeveridadMantis, $sql);
            $sql = str_replace("%id_reproductibilidad%", $this->idReproductibilidadMantis, $sql);
            $sql = str_replace("%id_estado_asignado%", $this->idEstadoMantis, $sql);
            $sql = str_replace("%id_resolucion%", $this->idResolucionMantis, $sql);
            $sql = str_replace("%id_proyeccion%", $this->idProyeccionMantis, $sql);            
            $sql = str_replace("%id_eta%", $this->idEtaMantis, $sql);
            $sql = str_replace("%id_perfil%", $this->idPerfilMantis, $sql);
            $sql = str_replace("%id_estado_vista%", $this->idEstadoVistaMantis, $sql);
            $sql = str_replace("%resumen_caso%", $this->resumenCasoMantis, $sql);
            $sql = str_replace("%id_sponsor%", $this->idSponsorMantis, $sql);
            $sql = str_replace("%id_sticky%", $this->idStickyMantis, $sql);

            //echo "Consulta: ".$sql;
            $resultado = $this->bdMantis->ejecutarConsulta($sql);
            $idCasoMantis = mysql_insert_id();

            if ($resultado) {
                $sql = "INSERT INTO mantis_custom_field_string_table (field_id, bug_id, value)
                        VALUES (5, LAST_INSERT_ID(), '%area_caso%'),
                               (2, LAST_INSERT_ID(), '%correo_usuario%'),
                               (9, LAST_INSERT_ID(), '%extension_usuario%'),
                               (25, LAST_INSERT_ID(), '%oficina%'),
                               (26, LAST_INSERT_ID(), '%tipo_gestion%'),
                               (3, LAST_INSERT_ID(), '%medio%')";
                
                if($this->oficinaCasoMantis=='Biblioteca'){
                    $sql.=",(19, LAST_INSERT_ID(), '%servicio_biblioteca%')";
                    if($this->servicioBibliotecaCasoMantis=='Obtención y proceso técnico de documentos'){
                        $sql.=",(16, LAST_INSERT_ID(), '%departamento_academico%'),
                                (31, LAST_INSERT_ID(), '%programa_responsable%'),
                                (18, LAST_INSERT_ID(), '%nombre_profesor%'),
                                (17, LAST_INSERT_ID(), '%material_solicitado%')";
                    }                        
                }
                $sql.=";";
                               
                               

                $sql = str_replace("%area_caso%", $this->areaCasoMantis, $sql);
                $sql = str_replace("%correo_usuario%", $this->correoInformadorMantis, $sql);
                $sql = str_replace("%extension_usuario%", $this->extensionUsuarioCasoMantis, $sql);
                $sql = str_replace("%oficina%", $this->oficinaCasoMantis, $sql);
                $sql = str_replace("%tipo_gestion%", $this->tipoGestionCasoMantis, $sql);
                $sql = str_replace("%medio%", $this->medioCasoMantis, $sql);
                
                if($this->oficinaCasoMantis=='Biblioteca'){
                    $sql = str_replace("%servicio_biblioteca%", $this->servicioBibliotecaCasoMantis, $sql);
                    $sql = str_replace("%departamento_academico%", $this->departamentoAcademicoCasoMantis, $sql);
                    $sql = str_replace("%programa_responsable%", $this->programaBibiliotecaCasoMantis, $sql);                
                    $sql = str_replace("%nombre_profesor%", $this->profesorBibliotecaCasoMantis, $sql);
                    $sql = str_replace("%material_solicitado%", $this->materialesCasoMantis, $sql);
                }
                $sql = str_replace("%hora_acordada%", $this->horaEntregaCasoMantis, $sql);
                $sql = str_replace("%tiempo_resolucion%", $this->tiempoResolucionCasoMantis, $sql);

                $resultado = $this->bdMantis->ejecutarConsulta($sql);

                if ($resultado) {
                    $sql = "INSERT INTO mantis_bug_history_table (user_id, bug_id, date_modified, field_name, old_value, new_value, type)
                            VALUES (%id_informador_mantis%, LAST_INSERT_ID(), SYSDATE(), '', '', '', 1),
                                   (%id_informador_mantis%, LAST_INSERT_ID(), SYSDATE(), '" . $this->obtenerNombreCampo(5, $bd) . "', '', '%area_caso%', 0),
                                   (%id_informador_mantis%, LAST_INSERT_ID(), SYSDATE(), '" . $this->obtenerNombreCampo(2, $bd) . "', '', '%correo_usuario%', 0),
                                   (%id_informador_mantis%, LAST_INSERT_ID(), SYSDATE(), '" . $this->obtenerNombreCampo(9, $bd) . "', '', '%extension_usuario%', 0),
                                   (%id_informador_mantis%, LAST_INSERT_ID(), SYSDATE(), '" . $this->obtenerNombreCampo(25, $bd) . "', '', '%oficina%', 0),
                                   (%id_informador_mantis%, LAST_INSERT_ID(), SYSDATE(), '" . $this->obtenerNombreCampo(26, $bd) . "', '', '%tipo_gestion%', 0),
                                   (%id_informador_mantis%, LAST_INSERT_ID(), SYSDATE(), '" . $this->obtenerNombreCampo(3, $bd) . "', '', '%medio%', 0),
                                   
                                   (%id_informador_mantis%, LAST_INSERT_ID(), SYSDATE(), '" . $this->obtenerNombreCampo(19, $bd) . "', '', '%servicio_biblioteca%', 0),
                                   (%id_informador_mantis%, LAST_INSERT_ID(), SYSDATE(), '" . $this->obtenerNombreCampo(16, $bd) . "', '', '%departamento_academico%', 0),
                                   (%id_informador_mantis%, LAST_INSERT_ID(), SYSDATE(), '" . $this->obtenerNombreCampo(31, $bd) . "', '', '%programa_responsable%', 0),
                                   (%id_informador_mantis%, LAST_INSERT_ID(), SYSDATE(), '" . $this->obtenerNombreCampo(18, $bd) . "', '', '%nombre_profesor%', 0),
                                   (%id_informador_mantis%, LAST_INSERT_ID(), SYSDATE(), '" . $this->obtenerNombreCampo(17, $bd) . "', '', '%material_solicitado%', 0),
                                   
                                   (%id_informador_mantis%, LAST_INSERT_ID(), SYSDATE(), 'status', '%id_estado_nuevo%', '%id_estado_asignado%', 0),
                                   (%id_informador_mantis%, LAST_INSERT_ID(), SYSDATE(), 'handler_id', '0', '%id_encargado_mantis%', 0)";

                    $sql = str_replace("%area_caso%", $this->areaCasoMantis, $sql);
                    $sql = str_replace("%correo_usuario%", $this->correoInformadorMantis, $sql);
                    $sql = str_replace("%extension_usuario%", $this->extensionUsuarioCasoMantis, $sql);
                    $sql = str_replace("%oficina%", $this->oficinaCasoMantis, $sql);
                    $sql = str_replace("%tipo_gestion%", $this->tipoGestionCasoMantis, $sql);
                    $sql = str_replace("%medio%", $this->medioCasoMantis, $sql);
                    
                    $sql = str_replace("%servicio_biblioteca%", $this->servicioBibliotecaCasoMantis, $sql);
                    $sql = str_replace("%departamento_academico%", $this->departamentoAcademicoCasoMantis, $sql);
                    $sql = str_replace("%programa_responsable%", $this->programaBibiliotecaCasoMantis, $sql);
                    $sql = str_replace("%nombre_profesor%", $this->profesorBibliotecaCasoMantis, $sql);
                    $sql = str_replace("%material_solicitado%", $this->materialesCasoMantis, $sql);
                    
                    $sql = str_replace("%id_estado_nuevo%", $this->idEstadoNuevoMantis, $sql);
                    $sql = str_replace("%id_estado_asignado%", $this->idEstadoAsignadoMantis, $sql);
                    $sql = str_replace("%id_encargado_mantis%", $this->idEncargadoMantis, $sql);
                    $sql = str_replace("%id_informador_mantis%", $this->idInformadorMantis, $sql);

                    $resultado = $this->bdMantis->ejecutarConsulta($sql);
                }
            }
        }

        if ($resultado) {
            return $idCasoMantis;
        } else {
            return -1;
        }
    }
    function correoEncargadoMantis(){
        $this->bdMantis->conectar();
        $sql = "SELECT email FROM mantis_user_table WHERE id=" . $this->idEncargadoMantis;
        $resultado = $this->bdMantis->ejecutarConsulta($sql);
        $fila = $this->bdMantis->siguienteFila($resultado);
        $correoUsuarioEncargado = $fila[0];
        $this->bdMantis->desconectar();
        return $correoUsuarioEncargado;
    }
    
    public function agregarNotaCasoMantis($idCasoMantis, $datosNota, $tipoNota=0) {
        $tipoN = $this->tipoNotaCasoMantis;
        if ($tipoNota != 0 || $tipoNota != null) {
            $tipoN = $tipoNota;
        }
        
        $this->bdMantis->conectar();

        $sql = "INSERT INTO mantis_bugnote_text_table (note)
            VALUES ('" . $datosNota . "')";
        $resultado = $this->bdMantis->ejecutarConsulta($sql);

        if ($resultado) {
            $sql = "INSERT INTO mantis_bugnote_table (bug_id, reporter_id, bugnote_text_id, view_state, date_submitted, last_modified, note_type)
              VALUES (%id_caso%, %id_usuario_mantis%, LAST_INSERT_ID(), %id_estado_vista%, SYSDATE(), SYSDATE(), %tipo_nota%)";
            $sql = str_replace("%id_caso%", $idCasoMantis, $sql);
            $sql = str_replace("%id_usuario_mantis%", $this->idEncargadoMantis, $sql);
            $sql = str_replace("%id_estado_vista%", $this->idEstadoVistaMantis, $sql);
            $sql = str_replace("%tipo_nota%", $tipoN, $sql);

            $resultado = $this->bdMantis->ejecutarConsulta($sql);

            if ($resultado) {
                $sql = "INSERT INTO mantis_bug_history_table (user_id, bug_id, date_modified, field_name, old_value, new_value, type)
               VALUES (%id_usuario_mantis%, %id_caso%, SYSDATE(), '', '%id_nota%', '', 2)";
                $sql = str_replace("%id_usuario_mantis%", $this->idEncargadoMantis, $sql);
                $sql = str_replace("%id_caso%", $idCasoMantis, $sql);

                //Se agregan ceros a la izquierda del ID de la nota ya que Mantis lo hace al agregarlo en el hist�rico
                $idNota = str_pad(mysql_insert_id(), $this->cantidadCerosHistoricoNota, '0', STR_PAD_LEFT);
                $sql = str_replace("%id_nota%", $idNota, $sql);

                $resultado = $this->bdMantis->ejecutarConsulta($sql);
            }
        }
        $this->bdMantis->desconectar();
    }

    /*     * *****************************************************************************
      Nombre:     obtenerValoresLista
      Propósito:  Obtiene los valores de una opción que sea del tipo "ComboBox" o "Lista de Valores" de Mantis,
      que están registrados en la Base de Datos.
      Entradas:   idCampo: Id del campo de la Base de Datos de Mantis que tiene los valores a consultar.
      Salida:     Un arreglo de string con los valores para retornar

      Revisiones:
      Ver        Fecha        Autor            Descripci�n
      ---------  -----------  ---------------  ------------------------------------
      1.0        11-FEB-2010  gavarela         Creaci�n

      Notas:

     * ****************************************************************************** */

    function obtenerValoresLista($idCampo) {
        $this->bdMantis->conectar();

        $sql = "SELECT possible_values FROM mantis_custom_field_table WHERE id=" . $idCampo;
        $resultado = $this->bdMantis->ejecutarConsulta($sql);
        $fila = $this->bdMantis->siguienteFila($resultado);
        $valoresCampo = $fila[0];
        $this->bdMantis->descononectar();

        return explode('|', $valoresCampo);
    }

    /*     * *****************************************************************************
      Nombre:     obtenerNombreCampo
      Propósito:  Obtiene el nombre de un campo de Mantis, según el código del campo dado
      Entradas:   codigoCampo: Código del campo de Mantis en la Base de Datos de Mantis.
      bd: un objeto para consultar la Base de Datos de Mantis.
      Salida:     Un String con el nombre del campo solicitado

      Revisiones:
      Ver        Fecha        Autor            Descripción
      ---------  -----------  ---------------  ------------------------------------
      1.0        17-FEB-2010  gavarela         Creación

      Notas:
      El link de la base de datos no se cierra, para que pueda seguir siendo usado.
     * ****************************************************************************** */

    function obtenerNombreCampo($codigoCampo) {
        $this->bdMantis->conectar();
        $sql = "SELECT name FROM mantis_custom_field_table WHERE id=" . $codigoCampo;
        $resultado = $this->bdMantis->ejecutarConsulta($sql);
        $fila = $this->bdMantis->siguienteFila($resultado);
        $nombreCampo = $fila[0];
        //$this->bdMantis->descononectar();

        return $nombreCampo;
    }

    /*     * *****************************************************************************
      Nombre:     obtenerCedulaEncargadoCasoMantis
      Propósito:  Obtiene la cédula, o el nombre de usuario, registrado en TBAS_CONSTANTES del usuario que estar�
      encargado de los casos creados para las solicitudes de material bibliográfico.
      Entradas:   NInguna
      Salida:     Cédula, o el nombre de usuario, el usuario que estar� encargado de los casos

      Revisiones:
      Ver        Fecha        Autor            Descripción
      ---------  -----------  ---------------  ------------------------------------
      1.0        17-FEB-2010  gavarela         Creación

      Notas:
      El código de la constante es 175
     * ****************************************************************************** */

    function obtenerCedulaEncargadoCasoMantis($cteEncargado, $connectionFile) {
        //return '1130608864';
        //return '1130619373';        
        $conexion = new OracleServices($connectionFile);
        $conecto=$conexion->conectar();

        $sql = "SELECT valor_varchar2 from TBAS_CONSTANTES WHERE codigo = ".$cteEncargado;
        $idConsulta = $conexion->ejecutarConsulta($sql);        
        $solicitudes = array();
        $cedulaEncargado = "";

        while ($conexion->siguienteFila($idConsulta)) {
            $cedulaEncargado = "" . $conexion->dato($idConsulta, 1);
        }

        $conexion->desconectar();
        return $cedulaEncargado;
    }

}

?>