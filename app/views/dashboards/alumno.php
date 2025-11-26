<?php 
include_once "app/middleware/auth.php"; 
require_login(); 

$u = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">

    <!-- Estilos -->
    <link rel="stylesheet" href="public/css/consult.css?v=<?php echo time(); ?>">

    <title>Dashboard Alumno</title>
</head>

<body>

    <!-- Logo -->
    <img src="public/img/logo.png" class="logo-elegante">

    <main class="card" style="max-width:900px; margin:auto;">

        <!-- Encabezado -->
        <div class="header">
            <h1>
                Hola, <?= htmlspecialchars($u['nombre']) ?> 
                (<?= htmlspecialchars($u['rol']) ?>)
            </h1>
        </div>

        <div class="content">

            <!-- Opciones -->
            <ul>
                <li>
                    <a href="index.php?action=avisos">
                        <button>Ver avisos</button>
                    </a>
                </li>
            </ul>

            <!-- Cerrar sesión -->
            <a href="index.php?action=logout" class="logout-btn">
                Cerrar sesión
            </a>

        </div>

    </main>

</body>
</html>
