<?php 

/**
 * ============================================================
 *  MODELO: AdministradorModel
 *  Maneja el CRUD de administradores del sistema.
 * ============================================================
 */
class AdministradorModel {

    private $connection;

    /**
     * Constructor: almacena la conexión a la BD
     */
    public function __construct($connection){
        $this->connection = $connection;
    }


    /* ============================================================
     *  MÉTODO: insertarAdministrador
     *  Inserta un administrador nuevo.
     * ============================================================ */
    public function insertarAdministrador($matricula, $nombre, $paterno, 
                                          $materno, $telefono, $fechaNac, $contraseña){

        $sql = "INSERT INTO administrador 
                (matricula, nombre, paterno, materno, telefono, fechaNac, pass)
                VALUES (?,?,?,?,?,?,?)";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("sssssss",
            $matricula, $nombre, $paterno, $materno,
            $telefono, $fechaNac, $contraseña
        );

        return $stmt->execute();
    }


    /* ============================================================
     *  MÉTODO: consultarAdministrador
     *  Obtiene todos los administradores.
     * ============================================================ */
    public function consultarAdministrador(){

        $sql = "SELECT * FROM administrador";
        return $this->connection->query($sql);
    }


    /* ============================================================
     *  MÉTODO: consultarPorID
     *  Devuelve los datos de un administrador por su ID.
     * ============================================================ */
    public function consultarPorID($id){

        $sql = "SELECT * FROM administrador WHERE ID_Administrador = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);

        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }


    /* ============================================================
     *  MÉTODO: actualizarAdministrador
     *  Actualiza los datos del administrador seleccionado.
     * ============================================================ */
    public function actualizarAdministrador($ID_Administrador, $matricula, $nombre, 
                                           $paterno, $materno, $telefono, $fechaNac, $contraseña){

        $sql = "UPDATE administrador 
                SET matricula = ?, nombre = ?, paterno = ?, materno = ?, 
                    telefono = ?, fechaNac = ?, pass = ?
                WHERE ID_Administrador = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("sssssssi",
            $matricula, $nombre, $paterno, $materno,
            $telefono, $fechaNac, $contraseña, $ID_Administrador
        );

        return $stmt->execute();
    }


    /* ============================================================
     *  MÉTODO: eliminarAdministrador
     *  Elimina un administrador por su ID.
     * ============================================================ */
    public function eliminarAdministrador($id){

        $sql = "DELETE FROM administrador WHERE ID_Administrador = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

}
