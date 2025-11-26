<?php 

/**
 * ============================================================
 *  MODELO: ProgramaModel
 *  Encargado de gestionar CRUD de programas académicos.
 * ============================================================
 */
class ProgramaModel {

    private $connection;

    /**
     * ----------------------------------------------
     * CONSTRUCTOR
     * Recibe la conexión de BD.
     * ----------------------------------------------
     */
    public function __construct($connection){
        $this->connection = $connection;
    }


    /* ============================================================
     *  MÉTODO: insertarPrograma
     *  Inserta un registro de programa nuevo.
     * ============================================================ */
    public function insertarPrograma($nombre, $vigencia, $certificaciones, $nivel, $ID_Area){

        $sql = "INSERT INTO programa (nombre, vigencia, certificaciones, nivel, ID_Area) 
                VALUES (?,?,?,?,?)";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ssssi", $nombre, $vigencia, $certificaciones, $nivel, $ID_Area);

        return $stmt->execute();
    }


    /* ============================================================
     *  MÉTODO: consultarPrograma
     *  Obtiene lista de programas con su respectiva área.
     * ============================================================ */
    public function consultarPrograma() {

        $sql = "SELECT 
                    p.ID_Programa,
                    p.nombre AS nombre_programa,
                    p.vigencia,
                    p.certificaciones,
                    p.nivel,
                    a.nombre AS nombre_area
                FROM programa p
                INNER JOIN area a ON p.ID_Area = a.ID_Area";

        return $this->connection->query($sql);
    }


    /* ============================================================
     *  MÉTODO: consultarPorID
     *  Obtiene un programa específico por su ID.
     * ============================================================ */
    public function consultarPorID($id){

        $sql = "SELECT * FROM programa WHERE ID_Programa = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);

        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }


    /* ============================================================
     *  MÉTODO: actualizarPrograma
     *  Actualiza un programa existente.
     * ============================================================ */
    public function actualizarPrograma($ID_Programa, $nombre, $vigencia, $certificaciones, $nivel, $ID_Area){

        $sql = "UPDATE programa 
                SET nombre = ?, vigencia = ?, certificaciones = ?, nivel = ?, ID_Area = ? 
                WHERE ID_Programa = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ssssii", $nombre, $vigencia, $certificaciones, $nivel, $ID_Area, $ID_Programa);

        return $stmt->execute();
    }


    /* ============================================================
     *  MÉTODO: eliminarPrograma
     *  Borra un programa por ID.
     * ============================================================ */
    public function eliminarPrograma($id){

        $sql = "DELETE FROM programa WHERE ID_Programa = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }


    /* ============================================================
     *  MÉTODO: consultarArea
     *  Devuelve lista de áreas disponibles.
     * ============================================================ */
    public function consultarArea() {
        $sql = "SELECT ID_Area, nombre FROM area";
        return $this->connection->query($sql);
    }

}

?>
