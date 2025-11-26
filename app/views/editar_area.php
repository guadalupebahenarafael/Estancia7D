<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <!-- Vista responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Archivo CSS con control de caché -->
    <link rel="stylesheet" href="public/css/consult.css?v=<?php echo time(); ?>">

    <title>Editar Área o Edificio</title>
</head>

<body>

    <!-- Logo superior -->
    <img src="public/img/logo.png" class="logo-elegante">

    <h1>EDITAR EDIFICIO O ÁREA</h1>
    <hr>

    <!-- Formulario -->
    <form action="index.php?action=actualizarArea" method="POST" id="formArea">

        <!-- ID del área -->
        <input type="hidden" name="id" value="<?php echo $row['ID_Area']; ?>">

        <!-- Nombre del edificio/área -->
        <label><b>Seleccione el nombre del edificio o área:</b></label>
        <select name="nombre" required>
            <option value="">-- Seleccionar --</option>
            <option value="UD1"                  <?php if ($row['nombre'] == 'UD1') echo 'selected'; ?>>UD1</option>
            <option value="UD2"                  <?php if ($row['nombre'] == 'UD2') echo 'selected'; ?>>UD2</option>
            <option value="UD3"                  <?php if ($row['nombre'] == 'UD3') echo 'selected'; ?>>UD3</option>
            <option value="LT1"                  <?php if ($row['nombre'] == 'LT1') echo 'selected'; ?>>LT1</option>
            <option value="LT2"                  <?php if ($row['nombre'] == 'LT2') echo 'selected'; ?>>LT2</option>
            <option value="BIBLIOTECA"           <?php if ($row['nombre'] == 'BIBLIOTECA') echo 'selected'; ?>>BIBLIOTECA</option>
            <option value="CECAM"                <?php if ($row['nombre'] == 'CECAM') echo 'selected'; ?>>CECAM</option>
            <option value="SUM"                  <?php if ($row['nombre'] == 'SUM') echo 'selected'; ?>>SUM</option>
            <option value="AULAS D"              <?php if ($row['nombre'] == 'AULAS D') echo 'selected'; ?>>AULAS D</option>
            <option value="CUM 1"                <?php if ($row['nombre'] == 'CUM 1') echo 'selected'; ?>>CUM 1</option>
            <option value="CUM 2"                <?php if ($row['nombre'] == 'CUM 2') echo 'selected'; ?>>CUM 2</option>
            <option value="CANCHA DE FUTBOL"     <?php if ($row['nombre'] == 'CANCHA DE FUTBOL') echo 'selected'; ?>>CANCHA DE FÚTBOL</option>
            <option value="CANCHA DE ARENA"      <?php if ($row['nombre'] == 'CANCHA DE ARENA') echo 'selected'; ?>>CANCHA DE ARENA</option>
        </select>

        <!-- Salones -->
        <label><b>Cantidad de salones:</b></label>
        <input type="number" name="salon" min="0" required
               value="<?php echo $row['salon']; ?>">

        <!-- Laboratorios -->
        <label><b>Cantidad de laboratorios:</b></label>
        <input type="number" name="laboratorio" min="0" max="10" required
               value="<?php echo $row['laboratorio']; ?>">

        <!-- Pisos -->
        <label><b>Número de pisos:</b></label>
        <input type="number" name="piso" min="1" max="2" required
               value="<?php echo $row['piso']; ?>">

        <br><br>

        <input type="submit" value="Actualizar área" name="editar">

    </form>

    <br><br>

    <a href="index.php?action=consultarArea">
        <button>Regresar</button>
    </a>


<!-- ======================================================
     VALIDACIONES JS DE CAMPOS NUMÉRICOS
====================================================== -->
<script>
document.getElementById("formArea").addEventListener("submit", function(e) {

    let salon = document.querySelector("input[name='salon']").value;
    let lab   = document.querySelector("input[name='laboratorio']").value;
    let piso  = document.querySelector("input[name='piso']").value;

    /*----------------------------------------
     | Validación de salones
     *---------------------------------------*/
    if (salon < 0 || salon === "") {
        alert("La cantidad de salones no puede ser negativa ni estar vacía.");
        e.preventDefault();
        return;
    }

    /*----------------------------------------
     | Validación de laboratorios
     *---------------------------------------*/
    if (lab < 0 || lab > 10 || lab === "") {
        alert("La cantidad de laboratorios debe ser entre 0 y 10.");
        e.preventDefault();
        return;
    }

    /*----------------------------------------
     | Validación de pisos
     *---------------------------------------*/
    if (piso < 1 || piso > 2 || piso === "") {
        alert("El número de pisos debe ser 1 o 2.");
        e.preventDefault();
        return;
    }

});
</script>

</body>
</html>
