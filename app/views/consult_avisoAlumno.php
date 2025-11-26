<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <!-- Vista responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Estilos -->
    <link rel="stylesheet" href="public/css/consult.css?v=<?php echo time(); ?>">

    <title>Consultar Avisos</title>
</head>

<body>

    <!-- Logo superior -->
    <img src="public/img/logo.png" class="logo-elegante">

    <!-- Título -->
    <h2 class="mb-4">AVISOS</h2>

    <!-- Tabla de avisos -->
    <table border="1">
        <thead>
            <tr>
                <th>ID AVISO</th>
                <th>NOMBRE DEL OBJETO</th>
                <th>ÁREA DONDE SE ENCONTRÓ</th>
                <th>DESCRIPCIÓN</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($row = $avisos->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['ID_Aviso']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre_objeto']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre_area']); ?></td>
                    <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <br><br>

    <!-- Botón regresar -->
    <a href="index.php?action=dashboard_alumno">
        <button>Regresar</button>
    </a>

</body>
</html>
