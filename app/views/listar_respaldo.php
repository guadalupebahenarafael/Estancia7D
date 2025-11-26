<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="public/css/consult.css?v=<?php echo time(); ?>">
    <title>Respaldos disponibles</title>
</head>

<body>

<h1>RESPALDOS DISPONIBLES</h1>
<hr>

<table border="1">
    <thead>
        <tr>
            <th>Archivo</th>
            <th>Tamaño</th>
            <th>Fecha</th>
            <th>Acción</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($respaldos as $file): ?>
            <tr>
                <td><?= $file['nombre'] ?></td>
                <td><?= $file['tamano'] ?> KB</td>
                <td><?= $file['fecha'] ?></td>

                <td>
                    <button onclick="confirmarRestauracion('<?= $file['nombre'] ?>')">
                        Restaurar
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<br><br>
<a href="index.php?action=dashboard_admin">
    <button>Regresar</button>
</a>

<script>
function confirmarRestauracion(nombre) {
    if (confirm("¿Seguro que quieres restaurar: " + nombre + "?\n\n⚠ ADVERTENCIA:\nSe sobrescribirá por completo la base de datos actual.")) {
        window.location = "index.php?action=restaurarVersion&ruta=" + nombre;
    }
}
</script>

</body>
</html>
