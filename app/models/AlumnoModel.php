<?php 

/**
 * ============================================================
 *  MODELO: AlumnoModel
 *  Maneja el CRUD de alumnos y sus relaciones con programas.
 * ============================================================
 */
class AlumnoModel {

    private $connection;

    /**
     * Constructor: recibe la conexión
     */
    public function __construct($connection){
        $this->connection = $connection;
    }


    /* ============================================================
     *  MÉTODO: insertarAlumno
     *  Inserta un alumno nuevo en la base de datos.
     * ============================================================ */
    public function insertarAlumno($matricula, $nombre, $paterno, $materno, 
                                   $telefono, $fechaNac, $contraseña, $ID_Programa){

        $sql = "INSERT INTO alumno 
                (matricula, nombre, paterno, materno, telefono, fechaNac, pass, ID_Programa)
                VALUES (?,?,?,?,?,?,?,?)";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("sssssssi", 
            $matricula, $nombre, $paterno, $materno,
            $telefono, $fechaNac, $contraseña, $ID_Programa
        );

        return $stmt->execute();
    }


    /* ============================================================
     *  MÉTODO: consultarAlumno
     *  Devuelve todos los alumnos junto con su programa.
     * ============================================================ */
    public function consultarAlumno(){

        $sql = "SELECT 
                    a.ID_Alumno,
                    a.matricula,
                    a.nombre AS nombre_alumno,
                    a.paterno,
                    a.materno,
                    a.telefono,
                    a.fechaNac,
                    a.pass,
                    a.rol,
                    p.ID_Programa,
                    p.nombre AS nombre_programa,
                    p.vigencia,
                    p.certificaciones,
                    p.nivel,
                    p.ID_Area
                FROM alumno a
                INNER JOIN programa p 
                    ON a.ID_Programa = p.ID_Programa";

        return $this->connection->query($sql);
    }


    /* ============================================================
     *  MÉTODO: consultarPorID
     *  Obtiene la información de un alumno según su ID.
     * ============================================================ */
    public function consultarPorID($id){

        $sql = "SELECT * FROM alumno WHERE ID_Alumno = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);

        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }


    /* ============================================================
     *  MÉTODO: actualizarAlumno
     *  Actualiza los datos de un alumno existente.
     * ============================================================ */
    public function actualizarAlumno($ID_Alumno, $matricula, $nombre, $paterno, 
                                     $materno, $telefono, $fechaNac, $contraseña, $ID_Programa){

        $sql = "UPDATE alumno 
                SET matricula = ?, nombre = ?, paterno = ?, materno = ?, 
                    telefono = ?, fechaNac = ?, pass = ?, ID_Programa = ?
                WHERE ID_Alumno = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("sssssssii",
            $matricula, $nombre, $paterno, $materno,
            $telefono, $fechaNac, $contraseña, $ID_Programa,
            $ID_Alumno
        );

        return $stmt->execute();
    }


    /* ============================================================
     *  MÉTODO: eliminarAlumno
     *  Elimina un alumno por su ID.
     * ============================================================ */
    public function eliminarAlumno($id){

        $sql = "DELETE FROM alumno WHERE ID_Alumno = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }


    /* ============================================================
     *  MÉTODO: consultarPrograma
     *  Obtiene todos los programas disponibles.
     * ============================================================ */
    public function consultarPrograma(){

        $sql = "SELECT ID_Programa, nombre FROM programa";
        return $this->connection->query($sql);
    }

}

?>
