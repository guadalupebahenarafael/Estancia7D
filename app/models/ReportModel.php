<?php 

/**
 * ---------------------------------------------------------
 * MODELO: ReportModel
 * Encargado de obtener la información necesaria para los
 * reportes: por género, categoría, edificio, y tablas
 * completas para gráficas o vistas previas.
 * ---------------------------------------------------------
 */

class ReportModel {

    private $connection;

    /**
     * -----------------------------------------------------
     * CONSTRUCTOR
     * Recibe y almacena la conexión para consultas SQL.
     * -----------------------------------------------------
     */
    public function __construct($connection){
        $this->connection = $connection;
    }


    /* =====================================================
     *  SECCIÓN 1: CONSULTAS GENERALES
     * ===================================================== */

    /**
     * Consultar todos los usuarios (alumnos).
     */
    public function consultarUsuarios(){
        $sql = "SELECT * FROM alumno";
        return $this->connection->query($sql);
    }


    /* =====================================================
     *  SECCIÓN 2: REPORTES POR GÉNERO
     * ===================================================== */

    /**
     * Obtener lista de géneros disponibles en objetos.
     */
    public function obtenerGeneros(){
        $sql = "SELECT DISTINCT genero 
                FROM objeto 
                WHERE genero IS NOT NULL AND genero != ''";
        return $this->connection->query($sql);
    }

    /**
     * Obtener todos los objetos con su género.
     */
    public function obtenerTodosConGenero(){
        $sql = "SELECT 
                    o.ID_Objeto,
                    o.nombre AS nombre_objeto,
                    o.categoria,
                    o.caracteristicas,
                    o.marca,
                    o.genero,
                    a.nombre AS nombre_area
                FROM objeto o
                INNER JOIN area a ON o.ID_Area = a.ID_Area
                ORDER BY o.ID_Objeto ASC";

        return $this->connection->query($sql);
    }

    /**
     * Validar si el género realmente existe.
     */
    public function validarGenero($genero){
        $sql = "SELECT genero 
                FROM objeto 
                WHERE genero = '$genero' 
                LIMIT 1";
        return $this->connection->query($sql);
    }


    /* =====================================================
     *  SECCIÓN 3: REPORTES POR EDIFICIO / ÁREA
     * ===================================================== */

    /**
     * Obtener lista de áreas/edificios.
     */
    public function obtenerAreas(){
        return $this->connection->query("
            SELECT ID_Area, nombre 
            FROM area 
            ORDER BY nombre ASC
        ");
    }

    /**
     * Obtener todos los objetos con sus áreas.
     */
    public function obtenerTodosConArea(){
        $sql = "SELECT 
                    o.ID_Objeto,
                    o.nombre,
                    o.categoria,
                    o.caracteristicas,
                    o.marca,
                    o.genero,
                    o.recuperado,
                    a.nombre AS nombre_area
                FROM objeto o
                INNER JOIN area a ON o.ID_Area = a.ID_Area
                ORDER BY o.ID_Objeto ASC";

        return $this->connection->query($sql);
    }

    /**
     * Objetos filtrados por área (edificio).
     */
    public function consultarObjetosPorEdificio($ID_Area){

        $sql = "SELECT 
                    o.ID_Objeto,
                    o.nombre AS nombre_objeto,
                    o.categoria,
                    o.genero,
                    o.recuperado,
                    o.caracteristicas,
                    o.marca,
                    a.nombre AS nombre_area
                FROM objeto o
                INNER JOIN area a ON o.ID_Area = a.ID_Area
                WHERE o.ID_Area = ?
                ORDER BY o.ID_Objeto ASC";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $ID_Area);
        $stmt->execute();
        return $stmt->get_result();
    }


    /* =====================================================
     *  SECCIÓN 4: REPORTES POR CATEGORÍA
     * ===================================================== */

    /**
     * Obtener lista de categorías disponibles.
     */
    public function obtenerCategorias(){
        return $this->connection->query("
            SELECT DISTINCT categoria 
            FROM objeto 
            WHERE categoria IS NOT NULL AND categoria != ''
            ORDER BY categoria ASC
        ");
    }

    /**
     * Obtener todos los objetos con su categoría.
     */
    public function obtenerTodosConCategoria(){
        return $this->connection->query("
            SELECT 
                o.ID_Objeto,
                o.nombre,
                o.categoria,
                o.caracteristicas,
                o.marca,
                o.genero,
                o.recuperado,
                a.nombre AS nombre_area
            FROM objeto o
            INNER JOIN area a ON o.ID_Area = a.ID_Area
            ORDER BY o.ID_Objeto ASC
        ");
    }

    /**
     * Obtener objetos específicos por categoría.
     */
    public function consultarObjetosPorCategoria($categoria){

        $sql = "SELECT 
                    o.ID_Objeto,
                    o.nombre AS nombre_objeto,
                    o.categoria,
                    o.genero,
                    o.recuperado,
                    o.caracteristicas,
                    o.marca,
                    a.nombre AS nombre_area
                FROM objeto o
                INNER JOIN area a ON o.ID_Area = a.ID_Area
                WHERE o.categoria = ?
                ORDER BY o.ID_Objeto ASC";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("s", $categoria);
        $stmt->execute();
        return $stmt->get_result();
    }


    /* =====================================================
     *  SECCIÓN 5: CONSULTAS PARA GRÁFICAS
     * ===================================================== */

    /**
     * Datos agrupados por género.
     */
    public function consultarGenero(){

        $sql = "SELECT genero, COUNT(*) AS total 
                FROM objeto 
                GROUP BY genero";

        $result = $this->connection->query($sql);
        $data = [];

        while($row = $result->fetch_assoc()){
            $data[] = [$row['genero'], (int)$row['total']];
        }

        return $data;
    }

    /**
     * Datos agrupados por edificio/área.
     */
    public function consultarEdificio(){

        $sql = "SELECT 
                    a.nombre AS nombre_area, 
                    COUNT(*) AS total
                FROM objeto o
                INNER JOIN area a ON o.ID_Area = a.ID_Area
                GROUP BY a.nombre";

        $result = $this->connection->query($sql);
        $data = [];

        while($row = $result->fetch_assoc()){
            $data[] = [$row['nombre_area'], (int)$row['total']];
        }

        return $data;
    }

    /**
     * Datos agrupados por categoría.
     */
    public function consultarCategoria(){

        $sql = "SELECT categoria, COUNT(*) AS total 
                FROM objeto 
                GROUP BY categoria";

        $result = $this->connection->query($sql);
        $data = [];

        while($row = $result->fetch_assoc()){
            $data[] = [$row['categoria'], (int)$row['total']];
        }

        return $data;
    }

    public function consultarObjetosPorGenero($genero)
    {
        $sql = "SELECT 
                    o.ID_Objeto,
                    o.nombre AS nombre_objeto,
                    o.categoria,
                    o.marca,
                    o.recuperado,
                    o.genero,
                    a.nombre AS nombre_area
                FROM objeto o
                INNER JOIN area a ON o.ID_Area = a.ID_Area
                WHERE o.genero = '$genero'";

        return $this->connection->query($sql);
    }



}

?>
