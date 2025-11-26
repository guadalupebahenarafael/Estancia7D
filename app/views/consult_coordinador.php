<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <!-- Vista responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Estilos -->
    <link rel="stylesheet" href="public/css/consult.css?v=<?php echo time(); ?>">

    <title>Consultar Coordinadores</title>
</head>

<body>

    <!-- Logo superior -->
    <img src="public/img/logo.png" class="logo-elegante">

    <!-- Título -->
    <h1>CONSULTAR COORDINADORES</h1>

    <!-- Tabla -->
    <table border="1">
        <thead>
            <tr>
                <th>ID COORDINADOR</th>
                <th>MATRÍCULA</th>
                <th>NOMBRE</th>
                <th>PATERNO</th>
                <th>MATERNO</th>
                <th>TELÉFONO</th>
                <th>FECHA DE NACIMIENTO</th>
                <th>CONTRASEÑA</th>
                <th>ACCIONES</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($row = $coordinadores->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['ID_Coordinador']); ?></td>
                    <td><?php echo htmlspecialchars($row['matricula']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($row['paterno']); ?></td>
                    <td><?php echo htmlspecialchars($row['materno']); ?></td>
                    <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                    <td><?php echo htmlspecialchars($row['fechaNac']); ?></td>

                    <!-- Nunca se debe mostrar la contraseña original -->
                    <td>********</td>

                    <td class="acciones">

                        <a href="index.php?action=actualizarCoordinador&id=<?php echo $row['ID_Coordinador']; ?>" 
                           class="btn-accion editar">
                           Editar
                        </a>

                        <a href="index.php?action=eliminarCoordinador&id=<?php echo $row['ID_Coordinador']; ?>" 
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
    <a href="index.php?action=insertarCoordinador">
        <button>Regresar</button>
    </a>

</body>
</html>
