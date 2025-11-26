<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <!-- Vista responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Hoja de estilos -->
    <link rel="stylesheet" href="public/css/consult.css?v=<?php echo time(); ?>">

    <title>Editar Programa</title>
</head>

<body>

    <!-- Logo elegante superior -->
    <img src="public/img/logo.png" class="logo-elegante">

    <!-- Título principal -->
    <h1>EDITAR PROGRAMA</h1>
    <hr>

    <!-- Formulario para actualizar el programa -->
    <form action="index.php?action=actualizarPrograma" method="POST">

        <!-- ID oculto del programa -->
        <input type="hidden" name="id" value="<?php echo $row['ID_Programa']; ?>">

        <!-- Nombre del programa -->
        <label><b>Seleccione el nombre del programa:</b></label>
        <select name="nombre" required>
            <option value="">-- Seleccionar --</option>
            <option value="(IIN)" <?php if ($row['nombre'] == '(IIN)') echo 'selected'; ?>>Ingeniería Industrial (IIN)</option>
            <option value="(IFI)" <?php if ($row['nombre'] == '(IFI)') echo 'selected'; ?>>Ingeniería Financiera (IFI)</option>
            <option value="(LAD)" <?php if ($row['nombre'] == '(LAD)') echo 'selected'; ?>>Licenciatura en Administración (LAD)</option>
            <option value="(IID)" <?php if ($row['nombre'] == '(IID)') echo 'selected'; ?>>Ingeniería en Tecnologías de la Información e Innovación Digital (IID)</option>
            <option value="(ISE)" <?php if ($row['nombre'] == '(ISE)') echo 'selected'; ?>>Ingeniería en Sistemas Electrónicos (ISE)</option>
            <option value="(IBT)" <?php if ($row['nombre'] == '(IBT)') echo 'selected'; ?>>Ingeniería en Biotecnología (IBT)</option>
            <option value="(IAS)" <?php if ($row['nombre'] == '(IAS)') echo 'selected'; ?>>Ingeniería Ambiental y Sustentabilidad (IAS)</option>
        </select>

        <!-- Vigencia -->
        <label for="vigencia"><b>Vigencia:</b></label>
        <input type="date" name="vigencia" value="<?php echo $row['vigencia']; ?>" required>

        <!-- Certificaciones -->
        <label for="certificaciones"><b>Selecciona una certificación:</b></label>
        <select name="certificaciones" required>
            <option value="">-- Seleccionar certificación --</option>
            <option value="EC0076"     <?php if ($row['certificaciones'] == 'EC0076') echo 'selected'; ?>>EC0076 — Evaluación de la competencia de candidatos</option>
            <option value="EC0301"     <?php if ($row['certificaciones'] == 'EC0301') echo 'selected'; ?>>EC0301 — Diseño de cursos de formación</option>
            <option value="EC0217.01"  <?php if ($row['certificaciones'] == 'EC0217.01') echo 'selected'; ?>>EC0217.01 — Impartición de cursos</option>
            <option value="EC0366"     <?php if ($row['certificaciones'] == 'EC0366') echo 'selected'; ?>>EC0366 — Diseño de cursos en línea</option>
            <option value="EC0435"     <?php if ($row['certificaciones'] == 'EC0435') echo 'selected'; ?>>EC0435 — Desarrollo de cursos en línea</option>
            <option value="EC0647"     <?php if ($row['certificaciones'] == 'EC0647') echo 'selected'; ?>>EC0647 — Coordinación de cursos</option>
            <option value="EC0891"     <?php if ($row['certificaciones'] == 'EC0891') echo 'selected'; ?>>EC0891 — Atención a clientes</option>
            <option value="EC0105"     <?php if ($row['certificaciones'] == 'EC0105') echo 'selected'; ?>>EC0105 — Atención al ciudadano</option>
            <option value="EC0772"     <?php if ($row['certificaciones'] == 'EC0772') echo 'selected'; ?>>EC0772 — Competencia en sector educativo</option>
            <option value="EC0610"     <?php if ($row['certificaciones'] == 'EC0610') echo 'selected'; ?>>EC0610 — Elaboración de programas</option>
            <option value="EC0072"     <?php if ($row['certificaciones'] == 'EC0072') echo 'selected'; ?>>EC0072 — Colocación de productos financieros</option>
        </select>

        <!-- Nivel educativo -->
        <label for="nivel"><b>Selecciona el nivel educativo:</b></label>
        <select name="nivel" required>
            <option value="">-- Seleccionar nivel --</option>
            <option value="licenciatura" <?php if ($row['nivel'] == 'licenciatura') echo 'selected'; ?>>Licenciatura</option>
            <option value="ingenieria"   <?php if ($row['nivel'] == 'ingenieria') echo 'selected'; ?>>Ingeniería</option>
            <option value="maestria"     <?php if ($row['nivel'] == 'maestria') echo 'selected'; ?>>Maestría</option>
            <option value="diplomado"    <?php if ($row['nivel'] == 'diplomado') echo 'selected'; ?>>Diplomado / Educación continua</option>
            <option value="certificacion" <?php if ($row['nivel'] == 'certificacion') echo 'selected'; ?>>Certificación</option>
        </select>

        <!-- Área donde se enseña el programa -->
        <label for="ID_Area"><b>Selecciona el área donde se enseña el programa:</b></label>
        <select name="ID_Area" required>
            <option value="">-- Seleccionar área --</option>

            <?php while ($area = $areas->fetch_assoc()): ?>
                <option value="<?php echo $area['ID_Area']; ?>"
                    <?php if ($area['ID_Area'] == $row['ID_Area']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($area['nombre']); ?>
                </option>
            <?php endwhile; ?>

        </select>

        <!-- Botón actualizar -->
        <input type="submit" value="Editar programa" name="editar">

    </form>

    <!-- Botón regresar -->
    <br><br>
    <a href="index.php?action=consultarPrograma">
        <button>Regresar</button>
    </a>

</body>
</html>
