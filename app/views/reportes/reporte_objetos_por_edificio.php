<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <!-- Vista responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="public/css/consult.css?v=<?php echo time(); ?>">

    <title>Reporte por Edificio</title>
</head>

<body>

    <!-- Logo -->
    <img src="public/img/logo.png" class="logo-elegante">

    <h2>Reporte de Objetos Perdidos por Edificio</h2>
    <hr>

    <!-- FORMULARIO PARA GENERAR PDF -->
    <form action="index.php?action=reporteObjetosPorEdificio" method="POST">

        <label><b>Seleccione el edificio:</b></label><br>

        <select name="ID_Area" required>
            <option value="">-- Seleccionar --</option>

            <?php while ($a = $areas->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($a['ID_Area']) ?>">
                    <?= htmlspecialchars($a['nombre']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <br><br>

        <button type="submit">Generar PDF</button>

    </form>

    <br><br>

    <!-- =============================
         TABLA DE VISTA PREVIA SIEMPRE
         ============================= -->
    <h3>Objetos registrados por edificio</h3>

    <table border="1">
        <thead>
            <tr>
                <th>ID OBJETO</th>
                <th>NOMBRE</th>
                <th>CATEGORÍA</th>
                <th>ÁREA</th>
                <th>CARACTERÍSTICAS</th>
                <th>MARCA</th>
                <th>GENERO</th>
                <th>RECUPERADO</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($todos_los_objetos) && $todos_los_objetos->num_rows > 0): ?>
                <?php while ($item = $todos_los_objetos->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['ID_Objeto']) ?></td>
                        <td><?= htmlspecialchars($item['nombre']) ?></td>
                        <td><?= htmlspecialchars($item['categoria']) ?></td>
                        <td><?= htmlspecialchars($item['nombre_area']) ?></td>
                        <td><?= htmlspecialchars($item['caracteristicas']) ?></td>
                        <td><?= htmlspecialchars($item['marca']) ?></td>
                        <td><?= htmlspecialchars($item['genero']) ?></td>
                        <td><?= htmlspecialchars($item['recuperado']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No hay objetos registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>

    </table>

    <br><br>

    <a href="index.php?action=pdf_pieEdificio">
        <button>Generar gráfica</button>
    </a>

    <br><br>

    <a href="index.php?action=dashboard_admin">
        <button>Regresar</button>
    </a>

</body>
</html>
