<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/archivos.php';

$nombre = $_GET['nombre'] ?? null;
$mime = is_string($nombre) ? mimeCartel($nombre) : false;

if ($mime === false) {
    http_response_code(404);
    exit;
}

header('Content-Type: ' . $mime);
header('X-Content-Type-Options: nosniff');
readfile(rutaCartel($nombre));
exit;
