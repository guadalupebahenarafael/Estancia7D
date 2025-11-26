<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <!-- Vista responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Estilos con control de caché -->
    <link rel="stylesheet" href="public/css/consult.css?v=<?php echo time(); ?>">

    <title>Registrar Administrador</title>
</head>

<body>

    <!-- Logo principal -->
    <img src="public/img/logo.png" class="logo-elegante">

    <!-- Título principal -->
    <h1>REGISTRAR ADMINISTRADOR</h1>
    <hr>

    <!-- Formulario de registro -->
    <form action="" method="POST" id="formAdministrador">

        <!-- Matrícula -->
        <label for="matricula"><b>Matrícula:</b></label>
        <input type="text" name="matricula" required>

        <!-- Nombre -->
        <label for="nombre"><b>Nombre:</b></label>
        <input type="text" name="nombre" required>

        <!-- Apellido paterno -->
        <label for="paterno"><b>Apellido paterno:</b></label>
        <input type="text" name="paterno" required>

        <!-- Apellido materno -->
        <label for="materno"><b>Apellido materno:</b></label>
        <input type="text" name="materno" required>

        <!-- Teléfono -->
        <label for="telefono"><b>Teléfono:</b></label>
        <input type="text" name="telefono" maxlength="10" required>

        <!-- Fecha de nacimiento -->
        <label for="fechaNac"><b>Fecha de nacimiento:</b></label>
        <input type="date" name="fechaNac" required>

        <!-- Contraseña -->
        <label for="pass"><b>Contraseña:</b></label>
        <input type="password" name="pass" required>

        <!-- Botón registrar -->
        <input type="submit" value="Registrar administrador" name="enviar">
    </form>

    <!-- Botón de consulta -->
    <br>
    <a href="index.php?action=consultarAdministrador">
        <button>Ir a consultas de administradores</button>
    </a>

    <!-- Botón de regreso -->
    <br><br>
    <a href="index.php?action=dashboard_admin">
        <button>Regresar</button>
    </a>


<!-- ==========================================================
     VALIDACIONES DE TELÉFONO Y FECHA DE NACIMIENTO (JAVASCRIPT)
=========================================================== -->
<script>
document.getElementById("formAdministrador").addEventListener("submit", function(e) {

    /*----------------------------------------
     | VALIDACIÓN DE TELÉFONO
     *---------------------------------------*/
    let telefono = document.querySelector("input[name='telefono']").value;

    // Solo números
    if (!/^[0-9]+$/.test(telefono)) {
        alert("El número de teléfono solo debe contener números.");
        e.preventDefault();
        return;
    }

    // Longitud exacta de 10 dígitos
    if (telefono.length !== 10) {
        alert("El número de teléfono debe tener exactamente 10 dígitos.");
        e.preventDefault();
        return;
    }

    /*----------------------------------------
     | VALIDACIÓN DE FECHA DE NACIMIENTO
     *---------------------------------------*/
    let fechaNacValor = document.querySelector("input[name='fechaNac']").value;
    let nacimiento = new Date(fechaNacValor);
    let hoy = new Date();

    // Calcular edad exacta
    let edad = hoy.getFullYear() - nacimiento.getFullYear();
    let mes = hoy.getMonth() - nacimiento.getMonth();

    if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
        edad--;
    }

    // No permitir fecha futura
    if (nacimiento > hoy) {
        alert("La fecha de nacimiento no puede ser mayor a la fecha actual.");
        e.preventDefault();
        return;
    }

    // Edad mínima (18 años)
    if (edad < 18) {
        alert("El administrador debe tener al menos 18 años.");
        e.preventDefault();
        return;
    }

    // Edad máxima (100 años)
    if (edad > 100) {
        alert("La edad no puede ser mayor a 100 años.");
        e.preventDefault();
        return;
    }

});
</script>

</body>
</html>
