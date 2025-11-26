<?php 
    /*------------------------------------------------------------
     | Obtener rol desde la URL
     *-----------------------------------------------------------*/
    $rol_btn = (int) $_GET['rol'];
?>

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
    <h2 class="mb-4">CONSULTAR AVISOS</h2>

    <!-- Tabla -->
    <table border="1">
        <thead>
            <tr>
                <th>ID AVISO</th>
                <th>NOMBRE DEL OBJETO</th>
                <th>ÁREA DONDE SE ENCONTRÓ</th>
                <th>DESCRIPCIÓN</th>
                <th>ACCIONES</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($row = $avisos->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['ID_Aviso']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre_objeto']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre_area']); ?></td>
                    <td><?php echo htmlspecialchars($row['descripcion']); ?></td>

                    <td class="acciones">

                        <!-- Botón editar -->
                        <a 
                            href="index.php?action=actualizarAviso&id=<?php echo $row['ID_Aviso']; ?>&rol=<?php echo $rol_btn; ?>" 
                            class="btn-accion editar">
                            Editar
                        </a>

                        <!-- Botón eliminar -->
                        <a 
                            href="index.php?action=eliminarAviso&id=<?php echo $row['ID_Aviso']; ?>&rol=<?php echo $rol_btn; ?>" 
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
    <?php if ($rol_btn == 1): ?>
        <a href="index.php?action=insertarAviso&rol=1">
            <button>Regresar</button>
        </a>

    <?php elseif ($rol_btn == 2): ?>
        <a href="index.php?action=insertarAviso&rol=2">
            <button>Regresar</button>
        </a>

    <?php else: ?>
        <p>No se reconoce el rol</p>
    <?php endif; ?>

</body>
</html>
