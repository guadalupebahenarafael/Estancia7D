<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <!-- Vista responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Estilos -->
    <link rel="stylesheet" href="public/css/consult.css?v=<?php echo time(); ?>">

    <title>Consultar Administradores</title>
</head>

<body>

    <!-- Logo superior -->
    <img src="public/img/logo.png" class="logo-elegante">

    <!-- Título -->
    <h1>CONSULTAR ADMINISTRADORES</h1>

    <!-- Tabla -->
    <table border="1">
        <thead>
            <tr>
                <th>ID ADMINISTRADOR</th>
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
            <?php while ($row = $administradores->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['ID_Administrador']); ?></td>
                    <td><?php echo htmlspecialchars($row['matricula']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($row['paterno']); ?></td>
                    <td><?php echo htmlspecialchars($row['materno']); ?></td>
                    <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                    <td><?php echo htmlspecialchars($row['fechaNac']); ?></td>

                    <!-- No mostrar contraseña real -->
                    <td>********</td>

                    <td class="acciones">

                        <!-- Editar -->
                        <a 
                            href="index.php?action=actualizarAdministrador&id=<?php echo $row['ID_Administrador']; ?>" 
                            class="btn-accion editar">
                            Editar
                        </a>

                        <!-- Eliminar -->
                        <a 
                            href="index.php?action=eliminarAdministrador&id=<?php echo $row['ID_Administrador']; ?>" 
                            class="btn-accion eliminar"
                            onclick="return confirm('¿Estás seguro de eliminar este registro?');">
                            Eliminar
                        </a>

                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <br><br>

    <!-- Botón regresar -->
    <a href="index.php?action=insertarAdministrador">
        <button>Regresar</button>
    </a>

</body>
</html>
