<?php
/**
 * Ruta base pública de la app (sin barra final).
 * Ejemplos: '' en local raíz, '/certificados_inaforp' en Fly con alias.
 */
function app_base_path(): string
{
    static $base = null;
    if ($base !== null) {
        return $base;
    }

    $configured = getenv('APP_BASE');
    if ($configured !== false && $configured !== '') {
        $base = rtrim(str_replace('\\', '/', $configured), '/');
        return $base;
    }

    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    if (str_ends_with($scriptDir, '/admin-verificador')) {
        $base = substr($scriptDir, 0, -strlen('/admin-verificador'));
    } elseif (str_ends_with($scriptDir, '/visor')) {
        $base = substr($scriptDir, 0, -strlen('/visor'));
    } elseif (str_ends_with($scriptDir, '/temp')) {
        $base = substr($scriptDir, 0, -strlen('/temp'));
    } else {
        $base = $scriptDir === '/' ? '' : $scriptDir;
    }

    return $base;
}

function app_url(string $path = ''): string
{
    $path = ltrim($path, '/');
    $base = app_base_path();

    return $base === '' ? '/' . $path : $base . '/' . $path;
}

/**
 * URL pública absoluta del visor de credenciales.
 */
function credential_url(string $keyHash): string
{
    $publicBase = getenv('APP_PUBLIC_URL');
    if ($publicBase === false || $publicBase === '') {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $publicBase = $scheme . '://' . $host . app_base_path();
    }

    return rtrim($publicBase, '/') . '/visor/?key=' . rawurlencode($keyHash);
}
