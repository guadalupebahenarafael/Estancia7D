<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <!-- Vista responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Hojas de estilo -->
    <link rel="stylesheet" href="public/css/consult.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="public/css/style.css?v=<?php echo time(); ?>">

    <title>Consultar Programas</title>
</head>

<body>

    <!-- Logo superior -->
    <img src="public/img/logo.png" class="logo-elegante">

    <!-- Título -->
    <h1>CONSULTAR PROGRAMAS</h1>

    <!-- Tabla de resultados -->
    <table border="1">
        <thead>
            <tr>
                <th>ID PROGRAMA</th>
                <th>NOMBRE</th>
                <th>VIGENCIA</th>
                <th>CERTIFICACIÓN</th>
                <th>NIVEL</th>
                <th>ÁREA</th>
                <th>ACCIONES</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($row = $programas->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['ID_Programa']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre_programa']); ?></td>
                    <td><?php echo htmlspecialchars($row['vigencia']); ?></td>
                    <td><?php echo htmlspecialchars($row['certificaciones']); ?></td>
                    <td><?php echo htmlspecialchars($row['nivel']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre_area']); ?></td>

                    <td class="acciones">
                        <a href="index.php?action=actualizarPrograma&id=<?php echo $row['ID_Programa']; ?>&rol=1" 
                           class="btn-accion editar">
                            Editar
                        </a>

                        <a href="index.php?action=eliminarPrograma&id=<?php echo $row['ID_Programa']; ?>&rol=1"
                           class="btn-accion eliminar"
                           onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?');">
                            Eliminar
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <br><br>

    <!-- Botón regresar -->
    <a href="index.php?action=insertarPrograma">
        <button>Regresar</button>
    </a>

</body>
</html>
