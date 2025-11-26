<?php
/**
 * CONTROLADOR LOGIN
 * Manejo de autenticación y cierre de sesión
 */
class LoginController
{
    private $connection;
    private $userModel;

    /**
     * Constructor del controlador
     * Recibe conexión e instancia el modelo
     */
    public function __construct($connection)
    {
        $this->connection = $connection;
        $this->userModel  = new UserModel($connection);
    }

    /* ============================================================
       MOSTRAR FORMULARIO LOGIN
       ============================================================ */
    public function formLogin()
    {
        session_start();
        include "app/views/login.php";
    }

    /* ============================================================
       PROCESAR LOGIN
       ============================================================ */
    public function login()
    {
        session_start();

        // Validar campos vacíos
        if (empty($_POST['matricula']) || empty($_POST['pass'])) {

            $_SESSION['error'] = "Complete todos los campos.";
            header("Location: index.php?controller=login&action=formLogin");
            exit;
        }

        // Sanitizar entradas
        $matricula = trim($_POST['matricula']);
        $pass      = trim($_POST['pass']);

        // Consultar usuario en BD
        $usuario = $this->userModel->login($matricula, $pass);

        // Validar existencia del usuario
        if (!$usuario) {
            $_SESSION['error'] = "Matrícula o contraseña incorrectas.";
            header("Location: index.php?controller=login&action=formLogin");
            exit;
        }

        // Crear sesión segura
        session_regenerate_id(true);

        $_SESSION['id']        = $usuario['id'];
        $_SESSION['matricula'] = $usuario['matricula'];
        $_SESSION['rol']       = $usuario['rol'];

        // Redirigir según rol
        switch ($usuario['rol']) {

            case "administrador":
                header("Location: index.php?action=dashboard_admin");
                exit;

            case "coordinador":
                header("Location: index.php?action=dashboard_coord");
                exit;

            case "alumno":
                header("Location: index.php?action=dashboard_alumno");
                exit;

            default:
                $_SESSION['error'] = "Rol desconocido. Contacte al administrador.";
                header("Location: index.php?controller=login&action=formLogin");
                exit;
        }
    }

    /* ============================================================
       CERRAR SESIÓN
       ============================================================ */
    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();

        header("Location: index.php?controller=login&action=formLogin");
        exit;
    }
}
