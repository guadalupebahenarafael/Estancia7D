<?php 

/**
 * ============================================================
 *  MODELO: AreaModel
 *  Maneja el CRUD de las áreas/edificios.
 * ============================================================
 */
class AreaModel {

    private $connection;

    /**
     * Constructor: recibe la conexión
     */
    public function __construct($connection){
        $this->connection = $connection;
    }


    /* ============================================================
     *  MÉTODO: insertarArea
     *  Crea un registro de área/edificio.
     * ============================================================ */
    public function insertarArea($nombre, $salon, $laboratorio, $piso){

        $sql = "INSERT INTO area (nombre, salon, laboratorio, piso) 
                VALUES (?,?,?,?)";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("siii", $nombre, $salon, $laboratorio, $piso);

        return $stmt->execute();
    }


    /* ============================================================
     *  MÉTODO: consultarArea
     *  Devuelve todas las áreas registradas.
     * ============================================================ */
    public function consultarArea(){

        $sql = "SELECT * FROM area";

        return $this->connection->query($sql);
    }


    /* ============================================================
     *  MÉTODO: consultarPorID
     *  Obtiene una área específica por su ID.
     * ============================================================ */
    public function consultarPorID($id){

        $sql = "SELECT * FROM area WHERE ID_Area = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);

        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }


    /* ============================================================
     *  MÉTODO: actualizarArea
     *  Edita los datos de un área existente.
     * ============================================================ */
    public function actualizarArea($ID_Area, $nombre, $salon, $laboratorio, $piso){

        $sql = "UPDATE area 
                SET nombre = ?, salon = ?, laboratorio = ?, piso = ?
                WHERE ID_Area = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("siiii", $nombre, $salon, $laboratorio, $piso, $ID_Area);

        return $stmt->execute();
    }


    /* ============================================================
     *  MÉTODO: eliminarArea
     *  Elimina un área por su ID.
     * ============================================================ */
    public function eliminarArea($id){

        $sql = "DELETE FROM area WHERE ID_Area = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

}

?>
