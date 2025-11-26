<?php 
include_once "app/middleware/auth.php"; 
require_role('coordinador'); 

$u = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="public/css/consult.css?v=<?php echo time(); ?>">
    <title>Dashboard Coordinador</title>
</head>

<body>

    <!-- LOGO -->
    <img src="public/img/logo.png" class="logo-elegante">

    <main class="card" style="max-width: 900px; margin: auto;">

        <!-- Encabezado -->
        <div class="header">
            <h1>Hola, <?= htmlspecialchars($u['nombre']) ?> (Coordinador)</h1>
        </div>

        <div class="content">

            <!-- Opciones -->
            <ul>
                <li>
                    <a href="index.php?action=insertarAlumno&rol=2">
                        <button>Gestión de alumnos</button>
                    </a>
                </li>

                <li>
                    <a href="index.php?action=insertarObjeto&rol=2">
                        <button>Gestión de objetos</button>
                    </a>
                </li>

                <li>
                    <a href="index.php?action=insertarAviso&rol=2">
                        <button>Gestión de avisos</button>
                    </a>
                </li>
            </ul>

            <!-- Cerrar sesión -->
            <a href="index.php?action=logout" class="logout-btn">Cerrar sesión</a>

        </div>

    </main>

</body>
</html>
