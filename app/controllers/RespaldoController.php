<?php

include_once "config/db_connection.php";
include_once "app/models/RespaldoModel.php";

/**
 * Controlador encargado de generar respaldos SQL
 * de la base de datos del sistema.
 */
class RespaldoController {

    private $model;

    /**
     * Constructor que inicializa el modelo
     */
    public function __construct($connection) {
        $this->model = new RespaldoModel($connection);
    }

    /**
     * Muestra alerta de confirmación antes de realizar el respaldo.
     * Esta función se manda llamar desde el botón "Respaldo de BD"
     * en el dashboard del administrador.
     */
    public function confirmarRespaldo() {
        echo "
            <script>
                if (confirm('¿Estás seguro de que deseas generar un nuevo respaldo?')) {
                    window.location = 'index.php?action=realizarRespaldoBD';
                } else {
                    window.location = 'index.php?action=dashboard_admin';
                }
            </script>
        ";
        exit;
    }

    /**
     * Genera el respaldo SQL y lo descarga en el navegador.
     */
    public function realizarRespaldoBD() {

        // Datos de la conexión
        $server   = "localhost";
        $user     = "root";
        $password = "";
        $db       = "objetos_perdidos";

        // Crear respaldo
        $this->model->backup_tables($server, $user, $password, $db);

        // Nombre basado en fecha y hora exacta (evita sobreescritura)
        $fecha = date("Y-m-d_H-i-s");
        $archivo = "config/backups/db-backup-" . $fecha . ".sql";
        $archivo_sin_ruta = "db-backup-" . $fecha . ".sql";

        // Validar que el archivo realmente se creó
        if (!file_exists($archivo)) {
            $this->alert(
                "Error: No se pudo generar el respaldo.",
                "index.php?action=dashboard_admin"
            );
        }

        // Forzar la descarga del archivo SQL
        header("Content-Disposition: attachment; filename=$archivo_sin_ruta");
        header("Content-Type: application/octet-stream");
        header("Content-Length: " . filesize($archivo));

        readfile($archivo);
        exit;
    }

    /**
     * Función utilitaria para mostrar alertas con redirección
     */
    private function alert(string $mensaje, string $redirect): void {
        echo "<script>
                alert('$mensaje');
                window.location = '$redirect';
              </script>";
        exit;
    }
}

