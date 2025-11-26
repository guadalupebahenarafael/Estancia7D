<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <!-- Vista responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Estilos con control de caché -->
    <link rel="stylesheet" href="public/css/consult.css?v=<?php echo time(); ?>">

    <!-- Logotipo de la página -->
    <img src="public/img/logo.png" class="logo-elegante">

    <title>Registrar Alumno</title>
</head>

<body>

    <!-- Título principal -->
    <h1>REGISTRAR ALUMNO</h1>
    <hr>

    <!-- Formulario para registrar alumno -->
    <form action="" method="POST" id="formAlumno">

        <!-- Matrícula -->
        <label for="matricula">Matrícula:</label>
        <input type="text" name="matricula" required>

        <!-- Nombre -->
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>

        <!-- Apellido paterno -->
        <label for="paterno">Apellido paterno:</label>
        <input type="text" name="paterno" required>

        <!-- Apellido materno -->
        <label for="materno">Apellido materno:</label>
        <input type="text" name="materno" required>

        <!-- Teléfono -->
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" maxlength="10" required>

        <!-- Fecha de nacimiento -->
        <label for="fechaNac">Fecha de nacimiento:</label>
        <input type="date" name="fechaNac" required>

        <!-- Contraseña -->
        <label for="pass">Contraseña:</label>
        <input type="password" name="pass" required>

        <!-- Selección de programa educativo -->
        <label for="ID_Programa">Selecciona la carrera:</label>
        <select name="ID_Programa" required>
            <option value="">-- Seleccionar programa --</option>

            <?php while ($row = $programas->fetch_assoc()): ?>
                <option value="<?= $row['ID_Programa']; ?>">
                    <?= htmlspecialchars($row['nombre']); ?>
                </option>
            <?php endwhile; ?>

        </select>

        <!-- Botón para registrar -->
        <input type="submit" value="Registrar alumno" name="enviar">

    </form>

    <!-- Botón para consultar alumnos según rol -->
    <br>
    <?php
        if (isset($_GET['rol'])) {
            $rol_btn = (int) $_GET['rol'];

            switch ($rol_btn) {
                case 1:
                case 2:
                    echo "
                        <a href='index.php?action=consultarAlumno&rol={$rol_btn}'>
                            <button>Ir a consulta de alumnos</button>
                        </a>";
                    break;

                default:
                    echo "No disponible.";
            }
        }
    ?>

    <!-- Botón para regresar -->
    <br><br>
    <?php
        if (isset($_GET['rol'])) {
            $rol_btn = (int) $_GET['rol'];

            switch ($rol_btn) {
                case 1:
                    echo "<a href='index.php?action=dashboard_admin'><button>Regresar</button></a>";
                    break;

                case 2:
                    echo "<a href='index.php?action=dashboard_coord'><button>Regresar</button></a>";
                    break;

                default:
                    echo "No disponible.";
            }
        }
    ?>



<!-- ======================================================
     VALIDACIONES JS (TELÉFONO + FECHA DE NACIMIENTO)
====================================================== -->
<script>
document.getElementById("formAlumno").addEventListener("submit", function(e) {

    /*----------------------------------------
     | Validación del número de teléfono
     *---------------------------------------*/
    let telefono = document.querySelector("input[name='telefono']").value;

    // Teléfono solo números
    if (!/^[0-9]+$/.test(telefono)) {
        alert("El número de teléfono solo debe contener números.");
        e.preventDefault();
        return;
    }

    // Teléfono con exactamente 10 dígitos
    if (telefono.length !== 10) {
        alert("El número de teléfono debe tener exactamente 10 dígitos.");
        e.preventDefault();
        return;
    }

    /*----------------------------------------
     | Validación de la fecha de nacimiento
     *---------------------------------------*/
    let fechaNac = document.querySelector("input[name='fechaNac']").value;
    let nacimiento = new Date(fechaNac);
    let hoy = new Date();

    // Cálculo de edad
    let edad = hoy.getFullYear() - nacimiento.getFullYear();
    let mes = hoy.getMonth() - nacimiento.getMonth();
    if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
        edad--;
    }

    // Fecha futura no permitida
    if (nacimiento > hoy) {
        alert("La fecha de nacimiento no puede ser mayor a hoy.");
        e.preventDefault();
        return;
    }

    // Mayor de edad mínimo 18
    if (edad < 18) {
        alert("El alumno debe tener al menos 18 años.");
        e.preventDefault();
        return;
    }

    // Máximo 100 años
    if (edad > 100) {
        alert("La edad no puede ser mayor a 100 años.");
        e.preventDefault();
        return;
    }

});
</script>


</body>
</html>
