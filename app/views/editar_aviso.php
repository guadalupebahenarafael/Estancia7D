<?php 
    /*------------------------------------------------------------
     | Obtener el rol desde la URL
     *-----------------------------------------------------------*/
    $rol_btn = (int) $_GET['rol'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <!-- Vista responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Archivo CSS con control de caché -->
    <link rel="stylesheet" href="public/css/consult.css?v=<?php echo time(); ?>">

    <title>Editar Aviso</title>
</head>

<body>

    <!-- Logo elegante superior -->
    <img src="public/img/logo.png" class="logo-elegante">

    <!-- Título principal -->
    <h1>EDITAR AVISO</h1>
    <hr>

    <!-- Formulario principal para actualizar aviso -->
    <form action="index.php?action=actualizarAviso" method="POST">

        <!-- ID del aviso -->
        <input type="hidden" name="ID_Aviso" value="<?php echo $dato['ID_Aviso']; ?>">

        <!-- Rol oculto para redirección -->
        <input type="hidden" name="rol" value="<?php echo $rol_btn; ?>">

        <!-- OBJETO -->
        <label><b>Seleccione el nombre del objeto:</b></label>
        <select name="ID_Objeto" required>
            <option value="">-- Seleccionar objeto --</option>

            <?php while ($obj = $objetos->fetch_assoc()): ?>
                <option value="<?php echo $obj['ID_Objeto']; ?>"
                    <?php if ($obj['ID_Objeto'] == $dato['ID_Objeto']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($obj['nombre']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <!-- ÁREA -->
        <label><b>Seleccione el área donde se encontró:</b></label>
        <select name="ID_Area" required>
            <option value="">-- Seleccionar área --</option>

            <?php while ($ar = $areas->fetch_assoc()): ?>
                <option value="<?php echo $ar['ID_Area']; ?>"
                    <?php if ($ar['ID_Area'] == $dato['ID_Area']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($ar['nombre']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <!-- DESCRIPCIÓN -->
        <label><b>Descripción del aviso:</b></label>
        <textarea name="descripcion" required><?php echo htmlspecialchars($dato['descripcion']); ?></textarea>

        <!-- Botón enviar -->
        <input type="submit" value="Actualizar Aviso" name="editar">

    </form>

    <!-- Botón regresar -->
    <br><br>
    <a href="index.php?action=consultarAviso&rol=<?php echo $rol_btn; ?>">
        <button>Regresar</button>
    </a>

</body>
</html>
