<?php 

/**
 * ---------------------------------------------------------
 * MODELO: Restauración de Base de Datos
 * Encargado de ejecutar un respaldo (.sql) y restaurarlo
 * en la base de datos actual.
 * ---------------------------------------------------------
 */
class RestauracionModel {

    private $connection;

    /**
     * -----------------------------------------------------
     * CONSTRUCTOR
     * Recibe la conexión a la base de datos desde el controlador.
     * -----------------------------------------------------
     */
    public function __construct($connection){
        $this->connection = $connection;
    }

    /**
     * -----------------------------------------------------
     * MÉTODO: restaurarBD()
     * Restaura la base de datos ejecutando un archivo SQL.
     *  - Desactiva llaves foráneas
     *  - Ejecuta multi_query (varias sentencias)
     *  - Limpia resultados intermedios
     *  - Reactiva llaves foráneas
     * -----------------------------------------------------
     */
    public function restaurarBD($ruta){

        // -------------------------------------------------
        // 1) Desactivar restricciones de llaves foráneas
        // -------------------------------------------------
        $this->connection->query("SET FOREIGN_KEY_CHECKS = 0");

        // -------------------------------------------------
        // 2) Cargar el archivo SQL completo
        // -------------------------------------------------
        $query_archivo = file_get_contents($ruta);

        // -------------------------------------------------
        // 3) Ejecutar todas las sentencias del archivo SQL
        // -------------------------------------------------
        if (!$this->connection->multi_query($query_archivo)) {
            return "Error en multi_query: " . $this->connection->error;
        }

        // -------------------------------------------------
        // 4) Limpiar todos los resultados generados por multi_query
        //    NECESARIO para evitar bloqueos o errores posteriores
        // -------------------------------------------------
        while ($this->connection->more_results()) {
            $this->connection->next_result();
            
            // Liberar memoria si hay un resultado pendiente
            if ($result = $this->connection->store_result()) {
                $result->free();
            }
        }

        // -------------------------------------------------
        // 5) Reactivar restricciones de llaves foráneas
        // -------------------------------------------------
        $this->connection->query("SET FOREIGN_KEY_CHECKS = 1");

        // -------------------------------------------------
        // 6) Respuesta final del proceso
        // -------------------------------------------------
        return "Restauración exitosa :)";
    }
}
