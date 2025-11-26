<?php 
include_once "app/middleware/auth.php"; 
require_role('administrador'); 

$u = $_SESSION['user']; 
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">

    <!-- Estilos -->
    <link rel="stylesheet" href="public/css/consult.css?v=<?php echo time(); ?>">

    <title>Dashboard Administrador</title>
</head>

<body>

    <!-- Logo -->
    <img src="public/img/logo.png" class="logo-elegante">

    <main class="card" style="max-width: 900px; margin:auto;">

        <!-- Encabezado -->
        <div class="header">
            <h1>
                Hola, <?= htmlspecialchars($u['nombre']) ?> (Administrador)
            </h1>
        </div>

        <div class="content">

            <!-- Opciones -->
            <ul>

                <li>
                    <a href="index.php?action=insertarAlumno&rol=1">
                        <button>Gestión de alumnos</button>
                    </a>
                </li>

                <li>
                    <a href="index.php?action=insertarCoordinador">
                        <button>Gestión de coordinadores</button>
                    </a>
                </li>

                <li>
                    <a href="index.php?action=insertarAdministrador&rol=1">
                        <button>Gestión de administradores</button>
                    </a>
                </li>

                <li>
                    <a href="index.php?action=insertarObjeto&rol=1">
                        <button>Gestión de objetos</button>
                    </a>
                </li>

                <li>
                    <a href="index.php?action=insertarAviso&rol=1">
                        <button>Gestión de avisos</button>
                    </a>
                </li>

                <li>
                    <a href="index.php?action=insertarArea">
                        <button>Gestión de áreas</button>
                    </a>
                </li>

                <li>
                    <a href="index.php?action=insertarPrograma">
                        <button>Gestión de programas</button>
                    </a>
                </li>

                <li>
                    <a href="index.php?action=vistaReportePorEdificio">
                        <button>Reportes por edificio</button>
                    </a>
                </li>

                <li>
                    <a href="index.php?action=vistaReportePorCategoria">
                        <button>Reportes por categoría</button>
                    </a>
                </li>

                <li>
                    <a href="index.php?action=vistaReportePorGenero">
                        <button>Reportes por género</button>
                    </a>
                </li>

                <li>
                    <button onclick="confirmarRespaldo()">Respaldo de BD</button>
                </li>

                <li>
                    <a href="index.php?action=vistaRestauracion">
                        <button>Restaurar BD</button>
                    </a>
                </li>

                <script>
                    function confirmarRespaldo() {
                        if (confirm("¿Estás seguro de generar un nuevo respaldo?\nEsto guardará una copia completa de la BD.")) {
                            window.location = "index.php?action=crearRespaldo";
                        }
                    }
                </script>

            </ul>

            <!-- Cerrar sesión -->
            <a href="index.php?action=logout" class="logout-btn">
                Cerrar sesión
            </a>

        </div>

        <!-- Mensaje de restauración -->
        <?php if (isset($restore)): ?>
            <br><br>
            <?= $restore ?>

            <script>
                setTimeout(function(){
                    window.location.href = "index.php?action=dashboard_admin";
                }, 3000);
            </script>
        <?php endif; ?>

    </main>

</body>
</html>
