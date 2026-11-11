<?php

declare(strict_types=1);

require __DIR__ . '/../config/portadas.php';

$nombre = $_GET['nombre'] ?? '';

if (!is_string($nombre) || preg_match(PATRON_PORTADA, $nombre) !== 1) {
    http_response_code(404);
    exit;
}

$ruta = DIRECTORIO_PORTADAS . '/' . $nombre;

if (!is_file($ruta) || !is_readable($ruta)) {
    http_response_code(404);
    exit;
}

$mime = detectarMime($ruta);

if ($mime === false || !isset(MIME_PORTADAS[$mime])) {
    http_response_code(404);
    exit;
}

header('Content-Type: ' . $mime);
header('X-Content-Type-Options: nosniff');
readfile($ruta);
exit;
