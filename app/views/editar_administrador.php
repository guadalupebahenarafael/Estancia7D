<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <!-- Vista responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Estilos -->
    <link rel="stylesheet" href="public/css/consult.css?v=<?php echo time(); ?>">

    <title>Editar Administrador</title>
</head>

<body>

    <!-- Logo superior -->
    <img src="public/img/logo.png" class="logo-elegante">

    <!-- Título -->
    <h1>EDITAR ADMINISTRADOR</h1>
    <hr>

    <!-- Formulario -->
    <form action="index.php?action=actualizarAdministrador" method="POST" id="formAdministrador">

        <!-- ID oculto -->
        <input type="hidden" name="id" value="<?php echo $row['ID_Administrador']; ?>">

        <!-- Matrícula -->
        <label><b>Matrícula:</b></label>
        <input type="text" name="matricula" required
               value="<?php echo htmlspecialchars($row['matricula']); ?>">

        <!-- Nombre -->
        <label><b>Nombre:</b></label>
        <input type="text" name="nombre" required
               value="<?php echo htmlspecialchars($row['nombre']); ?>">

        <!-- Apellido paterno -->
        <label><b>Apellido paterno:</b></label>
        <input type="text" name="paterno" required
               value="<?php echo htmlspecialchars($row['paterno']); ?>">

        <!-- Apellido materno -->
        <label><b>Apellido materno:</b></label>
        <input type="text" name="materno" required
               value="<?php echo htmlspecialchars($row['materno']); ?>">

        <!-- Teléfono -->
        <label><b>Teléfono:</b></label>
        <input type="text" maxlength="10" name="telefono" required
               value="<?php echo htmlspecialchars($row['telefono']); ?>">

        <!-- Fecha de nacimiento -->
        <label><b>Fecha de nacimiento:</b></label>
        <input type="date" name="fechaNac" required
               value="<?php echo $row['fechaNac']; ?>">

        <!-- Contraseña -->
        <label><b>Contraseña:</b></label>
        <input type="password" name="pass" required
               value="<?php echo htmlspecialchars($row['pass']); ?>">

        <!-- Botón guardar -->
        <input type="submit" value="Editar administrador" name="editar">

    </form>

    <!-- Botón regresar -->
    <br><br>
    <a href="index.php?action=consultarAdministrador">
        <button>Regresar</button>
    </a>


<!-- ======================================================
     VALIDACIONES JS (TELÉFONO + FECHA DE NACIMIENTO)
====================================================== -->
<script>
document.getElementById("formAdministrador").addEventListener("submit", function(e) {

    /*----------------------------------------
     | Validación del teléfono
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
    let mes  = hoy.getMonth() - nacimiento.getMonth();

    if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
        edad--;
    }

    if (nacimiento > hoy) {
        alert("La fecha de nacimiento no puede ser mayor a hoy.");
        e.preventDefault();
        return;
    }

    if (edad < 18) {
        alert("El administrador debe tener al menos 18 años.");
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
