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

    <!-- Hojas de estilo -->
    <link rel="stylesheet" href="public/css/consult.css?v=<?php echo time(); ?>">

    <title>Consultar Objetos</title>
</head>

<body>

    <!-- Logo superior -->
    <img src="public/img/logo.png" class="logo-elegante">

    <h1>CONSULTAR OBJETOS</h1>

    <!-- Tabla de consulta -->
    <table border="1">
        <thead>
            <tr>
                <th>ID OBJETO</th>
                <th>NOMBRE</th>
                <th>CATEGORÍA</th>
                <th>ÁREA DONDE SE ENCONTRÓ</th>
                <th>RECUPERADO</th>
                <th>CARACTERÍSTICAS</th>
                <th>MARCA</th>
                <th>GÉNERO</th>
                <th>ACCIONES</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($row = $objetos->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['ID_Objeto']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre_objeto']); ?></td>
                    <td><?php echo htmlspecialchars($row['categoria']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre_area']); ?></td>
                    <td><?php echo htmlspecialchars($row['recuperado']); ?></td>
                    <td><?php echo htmlspecialchars($row['caracteristicas']); ?></td>
                    <td><?php echo htmlspecialchars($row['marca']); ?></td>
                    <td><?php echo htmlspecialchars($row['genero']); ?></td>

                    <td class="acciones">
                        <!-- Botón editar -->
                        <a 
                            href="index.php?action=actualizarObjeto&id=<?php echo $row['ID_Objeto']; ?>&rol=<?php echo $rol_btn; ?>" 
                            class="btn-accion editar">
                            Editar
                        </a>

                        <!-- Botón eliminar -->
                        <a 
                            href="index.php?action=eliminarObjeto&id=<?php echo $row['ID_Objeto']; ?>&rol=<?php echo $rol_btn; ?>" 
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

    <!-- Botón regresar dependiendo del rol -->
    <?php if ($rol_btn == 1): ?>
        <a href="index.php?action=insertarObjeto&rol=1">
            <button>Regresar</button>
        </a>

    <?php elseif ($rol_btn == 2): ?>
        <a href="index.php?action=insertarObjeto&rol=2">
            <button>Regresar</button>
        </a>

    <?php else: ?>
        <p>No se reconoce el rol</p>
    <?php endif; ?>

</body>
</html>
