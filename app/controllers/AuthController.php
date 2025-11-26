<?php
// app/controllers/AuthController.php
include_once "config/db_connection.php"; 
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }

class AuthController {

    private $db;

    public function __construct($mysqli) {
        $this->db = $mysqli;
    }

    /**
     * Muestra el formulario de login
     */
    public function showLogin() {
        $err = $_GET['err'] ?? '';
        $msg = $_GET['msg'] ?? '';
        include "app/views/login.php";
    }

    /**
     * Procesar inicio de sesión
     */
    public function doLogin() {

        // ==========================
        // VALIDACIÓN DE CAMPOS
        // ==========================
        $matricula = trim($_POST['matricula'] ?? '');
        $password  = $_POST['pass'] ?? ($_POST['password'] ?? '');
        $rol       = $_POST['rol'] ?? '';

        if ($matricula === '' || $password === '' || !in_array($rol, ['alumno','coordinador','administrador'], true)) {
            echo "<script>alert('Completa todos los campos.'); window.location='index.php?action=login';</script>";
            exit;
        }

        // ==========================
        // SELECCIÓN DE TABLA SEGÚN ROL
        // ==========================
        $tabla = $rol;

        // ==========================
        // OBTENER COLUMNA PASSWORD
        // ==========================
        $colPass = null;
        foreach (['pass','password','contrasena','Contrasena','Contrasenia','contrasenia'] as $c) {
            $res = $this->db->query("SHOW COLUMNS FROM `$tabla` LIKE '$c'");
            if ($res && $res->num_rows > 0) { 
                $colPass = $c; 
                break; 
            }
        }

        if (!$colPass) {
            echo "<script>alert('Error interno: columna de contraseña no encontrada.'); window.location='index.php?action=login';</script>";
            exit;
        }

        // ==========================
        // OBTENER COLUMNA MATRÍCULA
        // ==========================
        $colMat = null;
        foreach (['matricula','Matricula','ID','id'] as $c) {
            $res = $this->db->query("SHOW COLUMNS FROM `$tabla` LIKE '$c'");
            if ($res && $res->num_rows > 0) { 
                $colMat = $c; 
                break; 
            }
        }

        if (!$colMat) {
            echo "<script>alert('Error interno: columna de matrícula no encontrada.'); window.location='index.php?action=login';</script>";
            exit;
        }

        // ==========================
        // COLUMNAS DE NOMBRE
        // ==========================
        $colNom = $this->findColumn($tabla, ['nombre','Nombre']);
        $colPat = $this->findColumn($tabla, ['paterno','Paterno','ApellidoPaterno']);
        $colMatApe = $this->findColumn($tabla, ['materno','Materno','ApellidoMaterno']);

        // ==========================
        // CONSULTA POR MATRÍCULA
        // ==========================
        $query = "SELECT 
                    `$colMat` AS matricula,
                    `$colPass` AS pass,
                    " . ($colNom ? "`$colNom` AS nombre," : "'Usuario' AS nombre,") . "
                    " . ($colPat ? "`$colPat` AS paterno," : "'' AS paterno,") . "
                    " . ($colMatApe ? "`$colMatApe` AS materno" : "'' AS materno") . "
                  FROM `$tabla`
                  WHERE `$colMat` = ?
                  LIMIT 1";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $matricula);
        $stmt->execute();
        $res = $stmt->get_result();
        $user = $res ? $res->fetch_assoc() : null;

        if (!$user) {
            echo "<script>alert('Usuario no encontrado con el rol seleccionado.'); window.location='index.php?action=login';</script>";
            exit;
        }

        // ==========================
        // VALIDAR CONTRASEÑA
        // ==========================
        $hash = (string) $user['pass'];
        $valid = false;

        if (strlen($hash) >= 20 && (str_starts_with($hash,'$2y$') || str_starts_with($hash,'$argon2'))) {
            $valid = password_verify($password, $hash);
        } else {
            $valid = hash_equals($hash, $password);
        }

        if (!$valid) {
            echo "<script>alert('Contraseña incorrecta.'); window.location='index.php?action=login';</script>";
            exit;
        }

        // ==========================
        // INICIAR SESIÓN
        // ==========================
        $_SESSION['user'] = [
            'matricula' => $user['matricula'],
            'rol'       => $rol,
            'nombre'    => trim(($user['nombre'] ?? '') . ' ' . ($user['paterno'] ?? '') . ' ' . ($user['materno'] ?? '')),
            'login_at'  => time(),
        ];

        // ==========================
        // REDIRECCIÓN POR ROL
        // ==========================
        switch ($rol) {
            case 'administrador':
                echo "<script>alert('Bienvenido administrador'); window.location='index.php?action=dashboard_admin';</script>";
                break;

            case 'coordinador':
                echo "<script>alert('Bienvenido coordinador'); window.location='index.php?action=dashboard_coord';</script>";
                break;

            case 'alumno':
                echo "<script>alert('Bienvenido alumno'); window.location='index.php?action=dashboard_alumno';</script>";
                break;
        }
    }

    /**
     * Buscar columna automáticamente
     */
    private function findColumn($tabla, $candidatos) {
        foreach ($candidatos as $c) {
            $res = $this->db->query("SHOW COLUMNS FROM `$tabla` LIKE '$c'");
            if ($res && $res->num_rows > 0) return $c;
        }
        return null;
    }

    /**
     * Cerrar sesión
     */
    public function logout() {
        $_SESSION = [];
        session_destroy();
        echo "<script>alert('Sesión cerrada correctamente.'); window.location='index.php?action=login';</script>";
    }
}
