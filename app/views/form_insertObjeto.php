<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <!-- Vista responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Hoja de estilos con control de caché -->
    <link rel="stylesheet" href="public/css/consult.css?v=<?php echo time(); ?>">

    <title>Registrar Objeto</title>
</head>

<body>
     <!-- Logo principal -->
    <img src="public/img/logo.png" class="logo-elegante">

    <!-- Título principal -->
    <h1><b>REGISTRAR OBJETO</b></h1>
    <hr>

    <!-- Formulario para registrar nuevo objeto -->
    <form action="" method="POST">

        <!-- Nombre del objeto -->
        <label for="nombre"><b>Ingresa el nombre del objeto:</b></label>
        <input type="text" name="nombre" required>

        <!-- Categoría del objeto -->
        <label><b>Categoría:</b></label>
        <select name="categoria" required>
            <option value="">-- Seleccionar --</option>
            <option value="Electronica">Electrónica</option>
            <option value="Ropa">Ropa</option>
            <option value="Joyeria">Joyería</option>
            <option value="Articulos de cocina">Artículos de cocina</option>
            <option value="Otros">Otros</option>
        </select>

        <!-- Selección del área donde se encontró el objeto -->
        <label for="ID_Area"><b>Selecciona el área donde se encontró el objeto:</b></label>
        <select name="ID_Area" required>
            <option value="">-- Seleccionar área --</option>

            <?php while ($row = $objetos->fetch_assoc()): ?>
                <option value="<?php echo $row['ID_Area']; ?>">
                    <?php echo htmlspecialchars($row['nombre']); ?>
                </option>
            <?php endwhile; ?>

        </select>

        <!-- Características especiales -->
        <label for="caracteristicas"><b>Ingresa las características especiales del objeto:</b></label>
        <input type="text" name="caracteristicas" class="required">

        <!-- Marca del objeto -->
        <label for="marca"><b>Marca del objeto (opcional):</b></label>
        <input type="text" name="marca">

        <!-- Botón de envío -->
        <input type="submit" value="Registrar objeto" name="enviar">
    </form>


    <!-- Botón para ir a consultar objetos según el rol recibido por GET -->
    <br>
    <?php
        if (isset($_GET['rol'])) {
            $rol_btn = (int) $_GET['rol'];

            switch ($rol_btn) {
                case 1: // Administrador
                    echo "
                        <a href='index.php?action=consultarObjeto&rol=1'>
                            <button>Ir a consultas de objetos</button>
                        </a>";
                    break;

                default: // Coordinador
                    echo "
                        <a href='index.php?action=consultarObjeto&rol=2'>
                            <button>Ir a consultas de objetos</button>
                        </a>";
                    break;
            }
        }
    ?>


    <!-- Botón para regresar a dashboard según rol -->
    <br><br>
    <?php
        if (isset($_GET['rol'])) {
            $rol_btn = (int) $_GET['rol'];

            switch ($rol_btn) {
                case 1: // Administrador
                    echo "
                        <a href='index.php?action=dashboard_admin'>
                            <button>Regresar</button>
                        </a>";
                    break;

                default: // Coordinador
                    echo "
                        <a href='index.php?action=dashboard_coord'>
                            <button>Regresar</button>
                        </a>";
                    break;
            }
        }
    ?>

</body>
</html>
