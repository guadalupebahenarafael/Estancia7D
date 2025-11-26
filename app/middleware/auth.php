<?php
/**
 * ============================================================
 *  MIDDLEWARE DE AUTENTICACIÓN Y AUTORIZACIÓN
 *  Maneja:
 *   - Sesiones
 *   - Verificación de login
 *   - Roles de usuario
 *   - Acceso por módulos
 * ============================================================
 */

if (session_status() !== PHP_SESSION_ACTIVE) { 
    session_start(); 
}


/* ============================================================
 *  FUNCIÓN: is_logged_in
 *  Verifica si hay un usuario autenticado en sesión.
 * ============================================================ */
function is_logged_in(): bool {
    return isset($_SESSION['user']);
}


/* ============================================================
 *  FUNCIÓN: current_user_role
 *  Devuelve el rol del usuario autenticado.
 * ============================================================ */
function current_user_role(): string {
    return $_SESSION['user']['rol'] ?? '';
}


/* ============================================================
 *  FUNCIÓN: require_login
 *  Obliga a iniciar sesión para continuar.
 * ============================================================ */
function require_login(): void {
    if (!is_logged_in()) {
        header('Location: index.php?action=login&err=' . urlencode('Inicia sesión para continuar.'));
        exit;
    }
}


/* ============================================================
 *  FUNCIÓN: require_role
 *  Obliga a tener un rol específico (admin, coordinador, alumno).
 * ============================================================ */
function require_role(string $role): void {
    require_login();

    if (current_user_role() !== $role) {
        http_response_code(403);
        echo '<!doctype html>
              <meta charset="utf-8">
              <title>Acceso denegado</title>
              <p>Sin permisos suficientes.</p>';
        exit;
    }
}


/* ============================================================
 *  REGLAS DE AUTORIZACIÓN POR MÓDULO
 *
 *  alumno:
 *      - avisos
 *
 *  coordinador:
 *      - gestion_alumnos
 *      - gestion_objetos
 *      - gestion_avisos
 *
 *  administrador:
 *      - acceso total
 * ============================================================ */
function can_access(string $module): bool {

    $role = current_user_role();

    if ($role === 'administrador') {
        return true; // Acceso completo
    }

    if ($role === 'coordinador') {
        return in_array(
            $module,
            ['gestion_alumnos', 'gestion_objetos', 'gestion_avisos'],
            true
        );
    }

    if ($role === 'alumno') {
        return ($module === 'avisos');
    }

    return false;
}


/* ============================================================
 *  FUNCIÓN: require_module
 *  Restringe acceso basándose en reglas por módulo.
 * ============================================================ */
function require_module(string $module): void {
    require_login();

    if (!can_access($module)) {
        http_response_code(403);
        echo '<!doctype html>
              <meta charset="utf-8">
              <title>Acceso denegado</title>
              <p>No tienes acceso al módulo solicitado.</p>';
        exit;
    }
}
