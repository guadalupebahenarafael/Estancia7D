<?php 

/**
 * ============================================================
 *  MODELO: ObjetoModel
 *  Maneja el CRUD de objetos perdidos.
 * ============================================================
 */
class ObjetoModel {

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
     *  MÉTODO: insertarObjeto
     *  Inserta un nuevo objeto perdido.
     * ============================================================ */
    public function insertarObjeto($nombre, $categoria, $ID_Area, $caracteristicas, $marca){

        $sql = "INSERT INTO objeto 
                (nombre, categoria, ID_Area, caracteristicas, marca) 
                VALUES (?,?,?,?,?)";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ssiss", $nombre, $categoria, $ID_Area, $caracteristicas, $marca);

        return $stmt->execute();
    }


    /* ============================================================
     *  MÉTODO: consultarObjeto
     *  Obtiene lista de objetos con su área.
     * ============================================================ */
    public function consultarObjeto() {

        $sql = "SELECT 
                    o.ID_Objeto,
                    o.nombre AS nombre_objeto,
                    o.categoria,
                    a.nombre AS nombre_area,
                    o.recuperado,
                    o.caracteristicas,
                    o.marca,
                    o.genero
                FROM objeto o
                INNER JOIN area a ON o.ID_Area = a.ID_Area";

        return $this->connection->query($sql);
    }


    /* ============================================================
     *  MÉTODO: consultarPorID
     *  Obtiene un objeto específico por ID.
     * ============================================================ */
    public function consultarPorID($id){

        $sql = "SELECT * FROM objeto WHERE ID_Objeto = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);

        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }


    /* ============================================================
     *  MÉTODO: actualizarObjeto
     *  Actualiza un objeto existente.
     * ============================================================ */
    public function actualizarObjeto($ID_Objeto, $nombre, $categoria, $ID_Area, $recuperado, $caracteristicas, $marca, $genero){

        $sql = "UPDATE objeto 
                SET nombre = ?, categoria = ?, ID_Area = ?, recuperado = ?, 
                    caracteristicas = ?, marca = ?, genero = ?
                WHERE ID_Objeto = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ssissssi", $nombre, $categoria, $ID_Area, $recuperado, 
                          $caracteristicas, $marca, $genero, $ID_Objeto);

        return $stmt->execute();
    }


    /* ============================================================
     *  MÉTODO: eliminarObjeto
     *  Elimina un objeto por ID.
     * ============================================================ */
    public function eliminarObjeto($id){

        $sql = "DELETE FROM objeto WHERE ID_Objeto = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }


    /* ============================================================
     *  MÉTODO: consultarArea
     *  Devuelve lista de áreas (para selects).
     * ============================================================ */
    public function consultarArea() {

        return $this->connection->query("
            SELECT ID_Area, nombre 
            FROM area
        ");
    }

}

?>
