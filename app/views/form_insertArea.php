<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <!-- Vista responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Estilos -->
    <link rel="stylesheet" href="public/css/consult.css?v=<?php echo time(); ?>">

    <title>Registrar Edificio o Área</title>
</head>

<body>

    <!-- Logo superior -->
    <img src="public/img/logo.png" class="logo-elegante">

    <!-- Título de la vista -->
    <h1>REGISTRAR EDIFICIO O ÁREA</h1>
    <hr>

    <!-- Formulario de registro -->
    <form action="" method="POST">

        <!-- Selección del nombre del edificio/área -->
        <label><b>Seleccione el nombre del edificio o área:</b></label>
        <select name="nombre" required>
            <option value="">-- Seleccionar --</option>
            <option value="UD1">UD1</option>
            <option value="UD2">UD2</option>
            <option value="UD3">UD3</option>
            <option value="LT1">LT1</option>
            <option value="LT2">LT2</option>
            <option value="BIBLIOTECA">BIBLIOTECA</option>
            <option value="CECAM">CECAM</option>
            <option value="SUM">SUM</option>
            <option value="AULAS D">AULAS D</option>
            <option value="CUM 1">CUM 1</option>
            <option value="CUM 2">CUM 2</option>
            <option value="CANCHA DE FUTBOL">CANCHA DE FÚTBOL</option>
            <option value="CANCHA DE ARENA">CANCHA DE ARENA</option>
        </select>

        <!-- Cantidad de salones -->
        <label for="salon"><b>Cantidad de salones:</b></label>
        <input type="number" name="salon" min="0" required>

        <!-- Cantidad de laboratorios -->
        <label for="laboratorio"><b>Cantidad de laboratorios:</b></label>
        <input type="number" name="laboratorio" min="0" max="10" required>

        <!-- Número de pisos -->
        <label for="piso"><b>Número de pisos:</b></label>
        <input type="number" name="piso" min="1" max="2" required>

        <!-- Botón: Registrar -->
        <input type="submit" value="Registrar Área" name="enviar">

    </form>

    <br>

    <!-- Botón para ir a consulta -->
    <a href="index.php?action=consultarArea">
        <button>Consultar Áreas o Edificios</button>
    </a>

    <br><br>

    <!-- Botón regresar -->
    <a href="index.php?action=dashboard_admin">
        <button>Regresar</button>
    </a>

</body>
</html>
