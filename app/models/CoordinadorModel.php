<?php 

/**
 * ============================================================
 *  MODELO: CoordinadorModel
 *  Maneja el CRUD de los coordinadores.
 * ============================================================
 */
class CoordinadorModel {

    private $connection;

    /**
     * ----------------------------------------------
     * CONSTRUCTOR: recibe conexión a la BD
     * ----------------------------------------------
     */
    public function __construct($connection){
        $this->connection = $connection;
    }


    /* ============================================================
     *  MÉTODO: insertarCoordinador
     *  Inserta un nuevo coordinador.
     * ============================================================ */
    public function insertarCoordinador($matricula, $nombre, $paterno, $materno, $telefono, $fechaNac, $contrasena){

        $sql = "INSERT INTO coordinador 
                (matricula, nombre, paterno, materno, telefono, fechaNac, pass) 
                VALUES (?,?,?,?,?,?,?)";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("sssssss", $matricula, $nombre, $paterno, $materno, 
                          $telefono, $fechaNac, $contrasena);

        return $stmt->execute();
    }


    /* ============================================================
     *  MÉTODO: consultarCoordinador
     *  Obtiene lista completa de coordinadores.
     * ============================================================ */
    public function consultarCoordinador(){

        return $this->connection->query("SELECT * FROM coordinador");
    }


    /* ============================================================
     *  MÉTODO: consultarPorID
     *  Devuelve un coordinador específico por ID.
     * ============================================================ */
    public function consultarPorID($id){

        $sql = "SELECT * FROM coordinador WHERE ID_Coordinador = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);

        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }


    /* ============================================================
     *  MÉTODO: actualizarCoordinador
     *  Actualiza una fila de coordinador.
     * ============================================================ */
    public function actualizarCoordinador($ID_Coordinador, $matricula, $nombre, $paterno, $materno, $telefono, $fechaNac, $contrasena){

        $sql = "UPDATE coordinador 
                SET matricula = ?, nombre = ?, paterno = ?, materno = ?, 
                    telefono = ?, fechaNac = ?, pass = ? 
                WHERE ID_Coordinador = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("sssssssi", $matricula, $nombre, $paterno, $materno,
                          $telefono, $fechaNac, $contrasena, $ID_Coordinador);

        return $stmt->execute();
    }


    /* ============================================================
     *  MÉTODO: eliminarCoordinador
     *  Elimina un coordinador por ID.
     * ============================================================ */
    public function eliminarCoordinador($id){

        $sql = "DELETE FROM coordinador WHERE ID_Coordinador = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

}

?>
