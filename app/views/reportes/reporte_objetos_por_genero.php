<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <!-- Vista responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="public/css/consult.css?v=<?php echo time(); ?>">

    <title>Reporte por Género</title>
</head>

<body>

    <!-- Logo -->
    <img src="public/img/logo.png" class="logo-elegante">

    <h2>Reporte de Objetos Perdidos por Género</h2>
    <hr>

    <!-- FORMULARIO PARA GENERAR PDF -->
    <form action="index.php?action=reporteObjetosPorGenero" method="POST">

        <label><b>Seleccione el género para generar el PDF:</b></label><br>

        <select name="genero" id="genero" required>
            <option value="">-- Seleccionar --</option>

            <?php while ($g = $generos->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($g['genero']) ?>">
                    <?= htmlspecialchars($g['genero']) ?>
                </option>
            <?php endwhile; ?>

        </select>

        <br><br>

        <button type="submit">Generar PDF</button>

    </form>

    <br><br>

    <!-- TABLA SIEMPRE VISIBLE -->
    <h3>Objetos registrados con género</h3>

    <table border="1">
        <thead>
            <tr>
                <th>ID OBJETO</th>
                <th>NOMBRE</th>
                <th>CATEGORÍA</th>
                <th>ÁREA</th>
                <th>GÉNERO</th>
                <th>CARACTERÍSTICAS</th>
                <th>MARCA</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($todos_los_objetos) && $todos_los_objetos->num_rows > 0): ?>
                <?php while ($item = $todos_los_objetos->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['ID_Objeto']) ?></td>
                        <td><?= htmlspecialchars($item['nombre_objeto']) ?></td>
                        <td><?= htmlspecialchars($item['categoria']) ?></td>
                        <td><?= htmlspecialchars($item['nombre_area']) ?></td>
                        <td><?= htmlspecialchars($item['genero']) ?></td>
                        <td><?= htmlspecialchars($item['caracteristicas']) ?></td>
                        <td><?= htmlspecialchars($item['marca']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No hay objetos registrados con género.</td>
                </tr>
            <?php endif; ?>
        </tbody>

    </table>

    <br><br>

    <a href="index.php?action=pdf_pie">
        <button>Generar gráfica</button>
    </a>

    <br><br>

    <a href="index.php?action=dashboard_admin">
        <button>Regresar</button>
    </a>

</body>
</html>
