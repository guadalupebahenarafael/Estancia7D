<?php /* app/views/login.php - Vista de inicio de sesión */ ?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">

    <!-- Ajuste responsivo para dispositivos móviles -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Hoja de estilos con versionado para evitar caché -->
    <link rel="stylesheet" href="public/css/consult.css?v=<?php echo time(); ?>">

    <!-- Contenedor del logotipo -->
    <div class="logo-login-container">
        <img src="public/img/logo_upemor.png" class="logo-login" alt="Logo UPEMOR">
    </div>

    <title>Acceso | Objetos Perdidos</title>
</head>

<body>

    <!-- Título principal del sistema -->
    <h2>PLATAFORMA WEB PARA OBJETOS PERDIDOS DE LA UPEMOR</h2>

    <!-- Subtítulo de la vista -->
    <h3>Iniciar sesión</h3>

    <!-- Formulario de acceso -->
    <form method="post" action="index.php?action=doLogin" novalidate>

        <!-- Mostrar error si existe -->
        <?php if (!empty($err)): ?>
            <div class="msg-error">
                <?= htmlspecialchars($err) ?>
            </div>
        <?php endif; ?>

        <!-- Mostrar mensaje informativo si existe -->
        <?php if (!empty($msg)): ?>
            <div class="msg-info">
                <?= htmlspecialchars($msg) ?>
            </div>
        <?php endif; ?>

        <!-- Campo: Matrícula -->
        <div class="form-group">
            <label for="matricula">Matrícula:</label>
            <input id="matricula" name="matricula" type="text" required>
        </div>

        <!-- Campo: Contraseña -->
        <div class="form-group">
            <label for="pass">Contraseña:</label>
            <input id="pass" name="pass" type="password" required>
        </div>

        <!-- Selector de rol -->
        <div class="form-group">
            <label for="rol">Rol:</label>
            <select id="rol" name="rol" required>
                <option value="">Selecciona tu rol…</option>
                <option value="alumno">Alumno</option>
                <option value="coordinador">Coordinador</option>
                <option value="administrador">Administrador</option>
            </select>
        </div>

        <!-- Botón de envío -->
        <button type="submit" class="btn-login">Entrar</button>
    </form>

</body>
</html>
