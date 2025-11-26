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

    <!-- CSS con control de caché -->
    <link rel="stylesheet" href="public/css/consult.css?v=<?php echo time(); ?>">

    <title>Editar Alumno</title>
</head>

<body>

    <!-- Logo superior -->
    <img src="public/img/logo.png" class="logo-elegante">

    <h1>EDITAR ALUMNO</h1>
    <hr>

    <!-- Formulario -->
    <form action="index.php?action=actualizarAlumno" method="POST" id="formAlumno">

        <!-- ID y rol ocultos -->
        <input type="hidden" name="rol" value="<?php echo $rol_btn; ?>">
        <input type="hidden" name="id" value="<?php echo $row['ID_Alumno']; ?>">

        <!-- Matrícula -->
        <label>Matrícula:</label>
        <input type="text" name="matricula" required 
               value="<?php echo htmlspecialchars($row['matricula']); ?>">

        <!-- Nombre -->
        <label>Nombre:</label>
        <input type="text" name="nombre" required 
               value="<?php echo htmlspecialchars($row['nombre']); ?>">

        <!-- Apellido paterno -->
        <label>Apellido paterno:</label>
        <input type="text" name="paterno" required 
               value="<?php echo htmlspecialchars($row['paterno']); ?>">

        <!-- Apellido materno -->
        <label>Apellido materno:</label>
        <input type="text" name="materno" required
               value="<?php echo htmlspecialchars($row['materno']); ?>">

        <!-- Teléfono -->
        <label>Teléfono:</label>
        <input type="text" maxlength="10" name="telefono" required
               value="<?php echo htmlspecialchars($row['telefono']); ?>">

        <!-- Fecha de nacimiento -->
        <label>Fecha de nacimiento:</label>
        <input type="date" name="fechaNac" required 
               value="<?php echo $row['fechaNac']; ?>">

        <!-- Contraseña -->
        <label>Contraseña:</label>
        <input type="password" name="pass" required
               value="<?php echo htmlspecialchars($row['pass']); ?>">

        <!-- Programa -->
        <label>Selecciona el programa:</label>
        <select name="ID_Programa" required>
            <option value="">-- Seleccionar programa --</option>

            <?php while ($programa = $programas->fetch_assoc()): ?>
                <option value="<?php echo $programa['ID_Programa']; ?>"
                    <?php if ($programa['ID_Programa'] == $row['ID_Programa']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($programa['nombre']); ?>
                </option>
            <?php endwhile; ?>

        </select>

        <!-- Botón enviar -->
        <input type="submit" value="Editar alumno" name="editar">

    </form>

    <br><br>

    <!-- Botón regresar -->
    <a href="index.php?action=consultarAlumno&rol=<?php echo $rol_btn; ?>">
        <button>Regresar</button>
    </a>


<!-- ======================================================
     VALIDACIONES JS (TELÉFONO + FECHA DE NACIMIENTO)
====================================================== -->
<script>
document.getElementById("formAlumno").addEventListener("submit", function(e) {

    /*----------------------------------------
     | Validación del número de teléfono
     *---------------------------------------*/
    let tel = document.querySelector("input[name='telefono']").value;

    if (!/^[0-9]+$/.test(tel)) {
        alert("El número de teléfono solo debe contener números.");
        e.preventDefault();
        return;
    }

    if (tel.length !== 10) {
        alert("El número de teléfono debe tener exactamente 10 dígitos.");
        e.preventDefault();
        return;
    }

    /*----------------------------------------
     | Validación de fecha de nacimiento
     *---------------------------------------*/
    let fechaNac = document.querySelector("input[name='fechaNac']").value;
    let nacimiento = new Date(fechaNac);
    let hoy = new Date();

    let edad = hoy.getFullYear() - nacimiento.getFullYear();
    let mes = hoy.getMonth() - nacimiento.getMonth();
    if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
        edad--;
    }

    if (nacimiento > hoy) {
        alert("La fecha de nacimiento no puede ser mayor a hoy.");
        e.preventDefault();
        return;
    }

    if (edad < 18) {
        alert("El alumno debe tener al menos 18 años.");
        e.preventDefault();
        return;
    }

    if (edad > 100) {
        alert("La edad no puede ser mayor a 100 años.");
        e.preventDefault();
        return;
    }

});
</script>

</body>
</html>
