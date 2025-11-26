<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <!-- Vista responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Estilos -->
    <link rel="stylesheet" href="public/css/consult.css?v=<?php echo time(); ?>">

    <title>Consultar Áreas o Edificios</title>
</head>

<body>

    <!-- Logo superior -->
    <img src="public/img/logo.png" class="logo-elegante">

    <!-- Título -->
    <h2 class="mb-4">CONSULTAR ÁREAS O EDIFICIOS</h2>

    <!-- Tabla -->
    <table border="1">
        <thead>
            <tr>
                <th>ID ÁREA</th>
                <th>NOMBRE</th>
                <th>SALONES</th>
                <th>LABORATORIOS</th>
                <th>PISOS</th>
                <th>ACCIONES</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($row = $areas->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['ID_Area']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($row['salon']); ?></td>
                    <td><?php echo htmlspecialchars($row['laboratorio']); ?></td>
                    <td><?php echo htmlspecialchars($row['piso']); ?></td>

                    <td class="acciones">

                        <!-- Editar -->
                        <a 
                            href="index.php?action=actualizarArea&id=<?php echo $row['ID_Area']; ?>&rol=1" 
                            class="btn-accion editar">
                            Editar
                        </a>

                        <!-- Eliminar -->
                        <a 
                            href="index.php?action=eliminarArea&id=<?php echo $row['ID_Area']; ?>&rol=1" 
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
    <a href="index.php?action=insertarArea">
        <button>Regresar</button>
    </a>

</body>
</html>
