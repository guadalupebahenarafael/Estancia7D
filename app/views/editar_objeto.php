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

    <!-- Hacer la vista responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS con control de caché -->
    <link rel="stylesheet" href="public/css/consult.css?v=<?php echo time(); ?>">

    <title>Editar Objeto</title>
</head>

<body>

    <!-- Logo superior -->
    <img src="public/img/logo.png" class="logo-elegante">

    <!-- Título principal -->
    <h1>EDITAR OBJETO</h1>
    <hr>

    <!-- Formulario para actualizar objeto -->
    <form action="index.php?action=actualizarObjeto" method="POST">

        <!-- ID de objeto -->
        <input type="hidden" name="rol" value="<?php echo $rol_btn; ?>">
        <input type="hidden" name="id" value="<?php echo $row['ID_Objeto']; ?>">

        <!-- Nombre del objeto -->
        <label><b>Ingresa el nombre del objeto:</b></label>
        <input type="text" name="nombre" required
               value="<?php echo htmlspecialchars($row['nombre']); ?>">

        <!-- Categoría del objeto -->
        <label><b>Categoría:</b></label>
        <select name="categoria" required>
            <option value="">-- Seleccionar --</option>

            <option value="Electronica" 
                <?php if ($row['categoria'] == 'Electronica') echo 'selected'; ?>>Electrónica</option>

            <option value="Ropa"
                <?php if ($row['categoria'] == 'Ropa') echo 'selected'; ?>>Ropa</option>

            <option value="Joyeria"
                <?php if ($row['categoria'] == 'Joyeria') echo 'selected'; ?>>Joyería</option>

            <option value="Articulos de cocina"
                <?php if ($row['categoria'] == 'Articulos de cocina') echo 'selected'; ?>>Artículos de cocina</option>

            <option value="Otros"
                <?php if ($row['categoria'] == 'Otros') echo 'selected'; ?>>Otros</option>
        </select>

        <!-- Área donde se encontró -->
        <label><b>Selecciona el área donde se encontró el objeto:</b></label>
        <select name="ID_Area" required>
            <option value="">-- Seleccionar área --</option>

            <?php while ($area = $objetos->fetch_assoc()): ?>
                <option value="<?php echo $area['ID_Area']; ?>"
                    <?php if ($row['ID_Area'] == $area['ID_Area']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($area['nombre']); ?>
                </option>
            <?php endwhile; ?>

        </select>

        <!-- Recuperado -->
        <label><b>¿El objeto fue recuperado por el dueño?</b></label>
        <select name="recuperado" required>
            <option value="">-- Seleccionar opción --</option>

            <option value="si" <?php if ($row['recuperado'] == 'si') echo 'selected'; ?>>Sí</option>
            <option value="no" <?php if ($row['recuperado'] == 'no') echo 'selected'; ?>>No</option>
        </select>

        <!-- Características -->
        <label><b>Ingresa las características especiales del objeto:</b></label>
        <input type="text" name="caracteristicas" required
               value="<?php echo htmlspecialchars($row['caracteristicas']); ?>">

        <!-- Marca -->
        <label><b>Marca del objeto (opcional):</b></label>
        <input type="text" name="marca"
               value="<?php echo htmlspecialchars($row['marca']); ?>">

        <!-- Dueñ@ (género) -->
        <label><b>¿El/La dueñ@ del objeto es hombre o mujer?</b></label>
        <select name="genero">
            <option value="">-- Seleccionar opción --</option>

            <option value="Mujer"
                <?php if ($row['genero'] == 'Mujer') echo 'selected'; ?>>Mujer</option>

            <option value="Hombre"
                <?php if ($row['genero'] == 'Hombre') echo 'selected'; ?>>Hombre</option>
        </select>

        <!-- Botón guardar cambios -->
        <input type="submit" value="Actualizar objeto" name="editar">

    </form>

    <!-- Botón regresar -->
    <br>
    <a href="index.php?action=consultarObjeto&rol=<?php echo $rol_btn; ?>">
        <button>Regresar</button>
    </a>

</body>
</html>
