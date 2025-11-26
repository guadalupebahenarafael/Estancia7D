<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <!-- Ajuste responsivo -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Hoja de estilos con versionado para evitar caché -->
    <link rel="stylesheet" href="public/css/consult.css?v=<?php echo time(); ?>">

    <title>Insertar Programa</title>
</head>

<body>

    <!-- Logo principal -->
    <img src="public/img/logo.png" class="logo-elegante">

    <!-- Título principal de la vista -->
    <h1>REGISTRAR PROGRAMA</h1>
    <hr>

    <!-- Formulario para registrar nuevos programas -->
    <form action="" method="POST">

        <!-- Selección del nombre del programa -->
        <label>Seleccione el nombre del programa:</label>
        <select name="nombre" required>
            <option value="">-- Seleccionar --</option>
            <option value="(IIN)">Ingeniería Industrial (IIN)</option>
            <option value="(IFI)">Ingeniería Financiera (IFI)</option>
            <option value="(LAD)">Licenciatura en Administración (LAD)</option>
            <option value="(IID)">Ingeniería en Tecnologías de la Información e Innovación Digital (IID)</option>
            <option value="(ISE)">Ingeniería en Sistemas Electrónicos (ISE)</option>
            <option value="(IBT)">Ingeniería en Biotecnología (IBT)</option>
            <option value="(IAS)">Ingeniería Ambiental y Sustentabilidad (IAS)</option>
        </select>

        <!-- Campo de fecha de vigencia -->
        <label for="vigencia">Vigencia:</label>
        <input type="date" name="vigencia" required>

        <!-- Selección de certificaciones -->
        <label for="certificaciones">Selecciona una certificación:</label>
        <select name="certificaciones" required>
            <option value="">-- Seleccionar certificación --</option>
            <option value="EC0076">EC0076 — Evaluación de la competencia de candidatos con base en Estándares de Competencia</option>
            <option value="EC0301">EC0301 — Diseño de cursos de formación del capital humano</option>
            <option value="EC0217.01">EC0217.01 — Impartición de cursos de formación del capital humano</option>
            <option value="EC0366">EC0366 — Diseño de cursos de formación en línea</option>
            <option value="EC0435">EC0435 — Desarrollo de cursos en línea</option>
            <option value="EC0647">EC0647 — Coordinación de la impartición de cursos de formación</option>
            <option value="EC0891">EC0891 — Prestación de servicios de atención a clientes</option>
            <option value="EC0105">EC0105 — Atención al ciudadano en el sector público</option>
            <option value="EC0772">EC0772 — Evaluación de la competencia del sector educativo</option>
            <option value="EC0610">EC0610 — Elaboración de programas de formación de capital humano</option>
            <option value="EC0072">EC0072 — Colocación de productos financieros</option>
        </select>

        <!-- Selección del nivel educativo -->
        <label for="nivel">Selecciona el nivel educativo:</label>
        <select name="nivel" required>
            <option value="">-- Seleccionar nivel --</option>
            <option value="licenciatura">Licenciatura</option>
            <option value="ingenieria">Ingeniería</option>
            <option value="maestria">Maestría</option>
            <option value="diplomado">Diplomado / Educación continua</option>
            <option value="certificacion">Certificación</option>
        </select>

        <!-- Selección del área (datos obtenidos dinámicamente desde BD) -->
        <label for="ID_Area">Selecciona el área donde se enseña el programa:</label>
        <select name="ID_Area" required>
            <option value="">-- Seleccionar área --</option>
            <?php while ($row = $areas->fetch_assoc()): ?>
                <option value="<?php echo $row['ID_Area']; ?>">
                    <?php echo htmlspecialchars($row['nombre']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <!-- Botón para enviar el formulario -->
        <input type="submit" value="Registrar programa" name="enviar">
    </form>

    <!-- Botón para ir a la consulta de programas -->
    <br>
    <a href="index.php?action=consultarPrograma">
        <button>Ir a consultas de programas</button>
    </a>

    <!-- Botón para regresar al dashboard de administrador -->
    <br><br>
    <a href="index.php?action=dashboard_admin">
        <button>Regresar</button>
    </a>

</body>
</html>
