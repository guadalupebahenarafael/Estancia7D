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

    <title>Consultar Alumnos</title>
</head>

<body>

    <!-- Logo superior -->
    <img src="public/img/logo.png" class="logo-elegante">

    <!-- Título -->
    <h1>CONSULTAR ALUMNOS</h1>

    <!-- Tabla -->
    <table border="1">
        <thead>
            <tr>
                <th>ID ALUMNO</th>
                <th>MATRÍCULA</th>
                <th>NOMBRE</th>
                <th>PATERNO</th>
                <th>MATERNO</th>
                <th>TELÉFONO</th>
                <th>FECHA NACIMIENTO</th>
                <th>CONTRASEÑA</th>
                <th>PROGRAMA</th>
                <th>ACCIONES</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($row = $alumnos->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['ID_Alumno']); ?></td>
                    <td><?php echo htmlspecialchars($row['matricula']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre_alumno']); ?></td>
                    <td><?php echo htmlspecialchars($row['paterno']); ?></td>
                    <td><?php echo htmlspecialchars($row['materno']); ?></td>
                    <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                    <td><?php echo htmlspecialchars($row['fechaNac']); ?></td>

                    <!-- Nunca mostrar la contraseña real -->
                    <td>********</td>

                    <td><?php echo htmlspecialchars($row['nombre_programa']); ?></td>

                    <td class="acciones">

                        <!-- Botón editar -->
                        <a 
                            href="index.php?action=actualizarAlumno&id=<?php echo $row['ID_Alumno']; ?>&rol=<?php echo $rol_btn; ?>" 
                            class="btn-accion editar">
                            Editar
                        </a>

                        <!-- Botón eliminar -->
                        <a 
                            href="index.php?action=eliminarAlumno&id=<?php echo $row['ID_Alumno']; ?>&rol=<?php echo $rol_btn; ?>" 
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

    <!-- Botón regresar dinámico según rol -->
    <?php if ($rol_btn == 1): ?>
        <a href="index.php?action=insertarAlumno&rol=1">
            <button>Regresar</button>
        </a>

    <?php elseif ($rol_btn == 2): ?>
        <a href="index.php?action=insertarAlumno&rol=2">
            <button>Regresar</button>
        </a>

    <?php else: ?>
        <p>No se reconoce el rol.</p>
    <?php endif; ?>

</body>
</html>
