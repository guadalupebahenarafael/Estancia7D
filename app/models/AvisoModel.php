<?php 

/**
 * ============================================================
 *  MODELO: AvisoModel
 *  Maneja el CRUD de avisos + consultas a áreas y objetos.
 * ============================================================
 */
class AvisoModel {

    private $connection;

    /**
     * ----------------------------------------------
     * CONSTRUCTOR: recibe la conexión a la BD
     * ----------------------------------------------
     */
    public function __construct($connection){
        $this->connection = $connection;
    }


    /* ============================================================
     *  MÉTODO: insertarAviso
     *  Inserta un aviso nuevo.
     * ============================================================ */
    public function insertarAviso($ID_Objeto, $ID_Area, $descripcion){

        $sql = "INSERT INTO aviso (ID_Objeto, ID_Area, descripcion) 
                VALUES (?,?,?)";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("iis", $ID_Objeto, $ID_Area, $descripcion);

        return $stmt->execute();
    }


    /* ============================================================
     *  MÉTODO: consultarAviso
     *  Devuelve la lista completa de avisos con nombres.
     * ============================================================ */
    public function consultarAviso(){

        $sql = "SELECT 
                    a.ID_Aviso,
                    a.descripcion,
                    o.nombre AS nombre_objeto,
                    ar.nombre AS nombre_area
                FROM aviso a
                INNER JOIN objeto o ON a.ID_Objeto = o.ID_Objeto
                INNER JOIN area ar ON a.ID_Area = ar.ID_Area";

        return $this->connection->query($sql);
    }


    /* ============================================================
     *  MÉTODO: consultarPorID
     *  Devuelve un aviso específico por ID.
     * ============================================================ */
    public function consultarPorID($id){

        $sql = "SELECT * FROM aviso WHERE ID_Aviso = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);

        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }


    /* ============================================================
     *  MÉTODO: actualizarAviso
     *  Modifica un aviso existente.
     * ============================================================ */
    public function actualizarAviso($ID_Aviso, $ID_Objeto, $ID_Area, $descripcion){

        $sql = "UPDATE aviso 
                SET ID_Objeto = ?, ID_Area = ?, descripcion = ?
                WHERE ID_Aviso = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("iisi", $ID_Objeto, $ID_Area, $descripcion, $ID_Aviso);

        return $stmt->execute();
    }


    /* ============================================================
     *  MÉTODO: eliminarAviso
     *  Elimina un aviso por ID.
     * ============================================================ */
    public function eliminarAviso($id){

        $sql = "DELETE FROM aviso WHERE ID_Aviso = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }


    /* ============================================================
     *  MÉTODO: consultarObjetos
     *  Devuelve lista de objetos (solo ID + nombre).
     * ============================================================ */
    public function consultarObjetos(){
        return $this->connection->query("
            SELECT ID_Objeto, nombre 
            FROM objeto
        ");
    }


    /* ============================================================
     *  MÉTODO: consultarAreas
     *  Devuelve lista de áreas (solo ID + nombre).
     * ============================================================ */
    public function consultarAreas(){
        return $this->connection->query("
            SELECT ID_Area, nombre 
            FROM area
        ");
    }

}

?>
