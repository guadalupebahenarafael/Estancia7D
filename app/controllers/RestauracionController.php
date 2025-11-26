<?php

include_once "config/db_connection.php";
include_once "app/models/RestauracionModel.php";

/**
 * Controlador encargado de gestionar la restauración
 * de respaldos SQL de la base de datos.
 */
class RestauracionController {

    private $model;

    /**
     * Constructor
     * @param mysqli $connection Conexión activa a la BD
     */
    public function __construct($connection) {
        $this->model = new RestauracionModel($connection);
    }

    /**
     * Restauración rápida: restaura automáticamente
     * el respaldo generado en la fecha actual.
     */
    public function restaurarBD() {

        $fecha = date("Y-m-d");
        $ruta  = "config/backups/db-backup-$fecha.sql";

        // Validar archivo existente
        if (!file_exists($ruta)) {
            $this->alert(
                "No se encontró un respaldo del día de hoy ($fecha).",
                "index.php?action=dashboard_admin"
            );
        }

        // Ejecutar restauración
        $resultado = $this->model->restaurarBD($ruta);

        // Enviar mensaje al usuario
        $this->alert($resultado, "index.php?action=dashboard_admin");
    }

    /**
     * Vista donde se listan todos los respaldos disponibles
     * para seleccionar cuál restaurar.
     */
    public function vistaRestauracion() {

        $directorio = "config/backups/";
        
        // Obtener archivos .sql del directorio
        $archivos = array_filter(scandir($directorio), function($file) use ($directorio) {
            return pathinfo($file, PATHINFO_EXTENSION) === "sql";
        });

        // Preparar datos para la vista
        $respaldos = [];
        foreach ($archivos as $file) {
            $respaldos[] = [
                "nombre" => $file,
                "tamano" => round(filesize($directorio.$file) / 1024, 2), // KB
                "fecha"  => date("d/m/Y H:i", filemtime($directorio.$file))
            ];
        }

        include "app/views/listar_respaldo.php";
    }

    /**
     * Restaurar un respaldo seleccionado manualmente.
     */
    public function restaurarVersion() {

        // Validar parámetro recibido
        if (empty($_GET['ruta'])) {
            $this->alert(
                "No se especificó archivo para restaurar.",
                "index.php?action=vistaRestauracion"
            );
        }

        // Seguridad: evitar rutas externas
        $archivo = basename($_GET['ruta']);
        $ruta = "config/backups/" . $archivo;

        if (!file_exists($ruta)) {
            $this->alert(
                "El archivo seleccionado no existe.",
                "index.php?action=vistaRestauracion"
            );
        }

        // Ejecutar restauración
        $resultado = $this->model->restaurarBD($ruta);

        $this->alert($resultado, "index.php?action=dashboard_admin");
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

