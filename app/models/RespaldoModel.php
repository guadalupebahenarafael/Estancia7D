<?php 

/**
 * ---------------------------------------------------------
 * MODELO: Respaldo de Base de Datos
 * Se encarga de generar un archivo .sql con toda la BD.
 * ---------------------------------------------------------
 */
class RespaldoModel {

    private $connection;

    /**
     * -----------------------------------------------------
     * CONSTRUCTOR
     * Recibe la conexión usada por el controlador.
     * -----------------------------------------------------
     */
    public function __construct($connection){
        $this->connection = $connection;
    }

    /**
     * -----------------------------------------------------
     * MÉTODO: backup_tables()
     * Genera un respaldo completo o parcial de la BD.
     *
     * Parámetros:
     *  - $host: servidor
     *  - $user: usuario
     *  - $pass: contraseña
     *  - $name: nombre de la BD
     *  - $tables: '*' para todas o lista específica
     * -----------------------------------------------------
     */
    public function backup_tables($host, $user, $pass, $name, $tables = '*') {

        $return  = '';
        $link    = new mysqli($host, $user, $pass, $name);

        // -------------------------------------------------
        // 1) Obtener nombres de todas las tablas
        // -------------------------------------------------
        if ($tables == '*') {
            $tables  = [];
            $result  = $link->query("SHOW TABLES");

            while ($row = mysqli_fetch_row($result)) {
                $tables[] = $row[0];
            }
        } else {
            // Convertir cadena a array si es necesario
            $tables = is_array($tables) ? $tables : explode(',', $tables);
        }

        // -------------------------------------------------
        // 2) Recorrer tabla por tabla
        // -------------------------------------------------
        foreach ($tables as $table) {

            // Obtener registros
            $result      = $link->query("SELECT * FROM $table");
            $num_fields  = mysqli_num_fields($result);

            // Obtener estructura de la tabla
            $row2  = mysqli_fetch_row($link->query("SHOW CREATE TABLE $table"));

            // Agregar sentencia de borrado y creación
            $return .= "\n\nDROP TABLE IF EXISTS `$table`;\n";
            $return .= "\n" . $row2[1] . ";\n\n";

            // Insertar datos de la tabla
            for ($i = 0; $i < $num_fields; $i++) {
                while ($row = mysqli_fetch_row($result)) {

                    $return .= "INSERT INTO $table VALUES(";

                    for ($j = 0; $j < $num_fields; $j++) {

                        // Limpiar caracteres especiales
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = preg_replace("/\n/", "\\n", $row[$j]);

                        // Agregar comillas o valor vacío
                        $return .= isset($row[$j]) ? "\"{$row[$j]}\"" : "\"\"";

                        if ($j < ($num_fields - 1)) { 
                            $return .= ","; 
                        }
                    }

                    $return .= ");\n";
                }
            }

            $return .= "\n\n\n";
        }

        // -------------------------------------------------
        // 3) Guardar archivo .sql con fecha
        // -------------------------------------------------
        $fecha = date("Y-m-d_H-i-s");
        $ruta   = "config/backups/db-backup-$fecha.sql";

        // Crear archivo y escribir contenido
        $handle = fopen('config/backups/db-backup-' . $fecha . '.sql', 'w+');
        fwrite($handle, $return);
        fclose($handle);
    }
}
