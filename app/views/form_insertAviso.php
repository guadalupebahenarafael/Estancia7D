<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <!-- Vista responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Estilos -->
    <link rel="stylesheet" href="public/css/consult.css?v=<?php echo time(); ?>">

    <title>Registrar Aviso</title>
</head>

<body>

    <!-- Logo superior -->
    <img src="public/img/logo.png" class="logo-elegante">

    <!-- Título de la vista -->
    <h1>REGISTRAR AVISO</h1>
    <hr>

    <!-- Formulario principal -->
    <form action="" method="POST">

        <!-- Combobox de objetos -->
        <label><b>Selecciona el nombre del objeto:</b></label>
        <select name="ID_Objeto" required>
            <option value="">-- Seleccionar objeto --</option>

            <?php while ($row = $objetos->fetch_assoc()): ?>
                <option value="<?= $row['ID_Objeto']; ?>">
                    <?= htmlspecialchars($row['nombre']); ?>
                </option>
            <?php endwhile; ?>

        </select>

        <!-- Combobox de áreas -->
        <label><b>Selecciona el área donde se encontró:</b></label>
        <select name="ID_Area" required>
            <option value="">-- Seleccionar área --</option>

            <?php while ($row = $areas->fetch_assoc()): ?>
                <option value="<?= $row['ID_Area']; ?>">
                    <?= htmlspecialchars($row['nombre']); ?>
                </option>
            <?php endwhile; ?>

        </select>

        <!-- Descripción del aviso -->
        <label><b>Descripción del aviso:</b></label>
        <textarea name="descripcion" required></textarea>

        <!-- Botón enviar -->
        <input type="submit" name="enviar" value="Registrar Aviso">

    </form>

    <br>

    <!-- Botón para ir a consultas según el rol -->
    <?php
    if (isset($_GET['rol'])) {
        $rol_btn = (int) $_GET['rol'];

        switch ($rol_btn) {
            case 1:
                echo "<a href='index.php?action=consultarAviso&rol=1'>
                        <button>Ir a consulta de avisos</button>
                      </a>";
                break;

            case 2:
                echo "<a href='index.php?action=consultarAviso&rol=2'>
                        <button>Ir a consulta de avisos</button>
                      </a>";
                break;

            default:
                echo "No disponible";
                break;
        }
    }
    ?>

    <br><br>

    <!-- Botón regresar según rol -->
    <?php
    if (isset($_GET['rol'])) {
        $rol_btn = (int) $_GET['rol'];

        switch ($rol_btn) {
            case 1:
                echo "<a href='index.php?action=dashboard_admin'>
                        <button>Regresar</button>
                      </a>";
                break;

            case 2:
                echo "<a href='index.php?action=dashboard_coord'>
                        <button>Regresar</button>
                      </a>";
                break;

            default:
                echo "No disponible";
                break;
        }
    }
    ?>

</body>
</html>
