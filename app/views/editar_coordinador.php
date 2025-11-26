<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <!-- Vista responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Estilos -->
    <link rel="stylesheet" href="public/css/consult.css?v=<?php echo time(); ?>">

    <title>Editar Coordinador</title>
</head>

<body>

    <!-- Logo superior dinámico -->
    <img src="public/img/logo.png" class="logo-elegante">

    <!-- Título principal -->
    <h1>EDITAR COORDINADOR</h1>
    <hr>

    <!-- Formulario para editar coordinador -->
    <form action="index.php?action=actualizarCoordinador" method="POST" id="formCoordinador">

        <!-- ID oculto -->
        <input type="hidden" name="id" value="<?php echo $row['ID_Coordinador']; ?>">

        <!-- Matrícula -->
        <label for="matricula">Matrícula:</label>
        <input type="text" name="matricula" required value="<?php echo htmlspecialchars($row['matricula']); ?>">

        <!-- Nombre -->
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required value="<?php echo htmlspecialchars($row['nombre']); ?>">

        <!-- Apellido paterno -->
        <label for="paterno">Apellido paterno:</label>
        <input type="text" name="paterno" required value="<?php echo htmlspecialchars($row['paterno']); ?>">

        <!-- Apellido materno -->
        <label for="materno">Apellido materno:</label>
        <input type="text" name="materno" required value="<?php echo htmlspecialchars($row['materno']); ?>">

        <!-- Teléfono -->
        <label for="telefono">Teléfono:</label>
        <input type="text" maxlength="10" name="telefono" required value="<?php echo htmlspecialchars($row['telefono']); ?>">

        <!-- Fecha de nacimiento -->
        <label for="fechaNac">Fecha de nacimiento:</label>
        <input type="date" name="fechaNac" required value="<?php echo $row['fechaNac']; ?>">

        <!-- Contraseña -->
        <label for="pass">Contraseña:</label>
        <input type="password" name="pass" required value="<?php echo htmlspecialchars($row['pass']); ?>">

        <!-- Botón actualizar -->
        <input type="submit" value="Editar coordinador" name="editar">

    </form>

    <br><br>

    <!-- Botón regresar -->
    <a href="index.php?action=consultarCoordinador">
        <button>Regresar</button>
    </a>


<!-- ======================================================
     VALIDACIONES JS (TELÉFONO + FECHA DE NACIMIENTO)
====================================================== -->
<script>
document.getElementById("formCoordinador").addEventListener("submit", function(e) {

    /*----------------------------------------
     | Validación del número de teléfono
     *---------------------------------------*/
    let telefono = document.querySelector("input[name='telefono']").value;

    if (!/^[0-9]+$/.test(telefono)) {
        alert("El número de teléfono solo debe contener números.");
        e.preventDefault();
        return;
    }

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
        alert("El coordinador debe tener al menos 18 años.");
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
