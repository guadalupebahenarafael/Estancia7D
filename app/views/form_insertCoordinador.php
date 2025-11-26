<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <!-- Ajuste responsivo -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Hoja de estilos con control de caché -->
    <link rel="stylesheet" href="public/css/consult.css?v=<?php echo time(); ?>">

    <title>Registrar Coordinador</title>
</head>

<body>
    <!-- Logo principal -->
    <img src="public/img/logo.png" class="logo-elegante">

    <!-- Título principal de la vista -->
    <h1>REGISTRAR COORDINADOR</h1>
    <hr>

    <!-- Formulario para registrar coordinador -->
    <form action="" method="POST" id="formCoordinador">

        <!-- Matrícula del coordinador -->
        <label for="matricula">Matrícula:</label>
        <input type="text" name="matricula" required>

        <!-- Nombre del coordinador -->
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>

        <!-- Apellido paterno -->
        <label for="paterno">Apellido paterno:</label>
        <input type="text" name="paterno" required>

        <!-- Apellido materno -->
        <label for="materno">Apellido materno:</label>
        <input type="text" name="materno" required>

        <!-- Teléfono (solo números, 10 dígitos) -->
        <label for="telefono">Teléfono:</label>
        <input
            type="text"
            name="telefono"
            maxlength="10"
            required
        >

        <!-- Fecha de nacimiento -->
        <label for="fechaNac">Fecha de nacimiento:</label>
        <input type="date" name="fechaNac" required>

        <!-- Contraseña de acceso -->
        <label for="pass">Contraseña:</label>
        <input type="password" name="pass" required>

        <!-- Botón para registrar coordinador -->
        <input type="submit" value="Registrar coordinador" name="enviar">

    </form>

    <!-- Botón para ir a consultas de coordinadores -->
    <br>
    <a href="index.php?action=consultarCoordinador">
        <button>Ir a consultas de coordinadores</button>
    </a>

    <!-- Botón para regresar al dashboard de administrador -->
    <br><br>
    <a href="index.php?action=dashboard_admin">
        <button>Regresar</button>
    </a>


    <!-- ======================================================
         VALIDACIONES DE TELÉFONO Y FECHA DE NACIMIENTO (JS)
    ======================================================= -->
    <script>
    document.getElementById("formCoordinador").addEventListener("submit", function(e) {

        /*----------------------------------------
         | Validación del número de teléfono
         *---------------------------------------*/
        let telefono = document.querySelector("input[name='telefono']").value;

        // Validar que solo contenga números
        if (!/^[0-9]+$/.test(telefono)) {
            alert("El número de teléfono solo debe contener números.");
            e.preventDefault();
            return;
        }

        // Validar que tenga exactamente 10 dígitos
        if (telefono.length !== 10) {
            alert("El número de teléfono debe tener exactamente 10 dígitos.");
            e.preventDefault();
            return;
        }

        /*----------------------------------------
         | Validación de fecha de nacimiento
         *---------------------------------------*/
        let fechaNacValor = document.querySelector("input[name='fechaNac']").value;
        let nacimiento = new Date(fechaNacValor);
        let hoy = new Date();

        // Calcular edad
        let edad = hoy.getFullYear() - nacimiento.getFullYear();
        let mes = hoy.getMonth() - nacimiento.getMonth();
        if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
            edad--;
        }

        // Validar que la fecha no sea futura
        if (nacimiento > hoy) {
            alert("La fecha de nacimiento no puede ser mayor a la fecha actual.");
            e.preventDefault();
            return;
        }

        // Validar mayoría de edad (mínimo 18)
        if (edad < 18) {
            alert("El coordinador debe tener al menos 18 años.");
            e.preventDefault();
            return;
        }

        // Validar máximo 100 años
        if (edad > 100) {
            alert("La edad no puede ser mayor a 100 años.");
            e.preventDefault();
            return;
        }

    });
    </script>

</body>
</html>
