<?php
declare(strict_types=1);

const MIME_CARTELES = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/webp' => 'webp',
];

const PATRON_CARTEL = '/\A[a-f0-9]{32}\.(jpg|png|webp)\z/';

const TAMANO_MAXIMO_CARTEL = 2097152;

const LIMITE_POST = 8 * 1024 * 1024;

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function directorioCarteles(): string
{
    return __DIR__ . '/../storage/carteles';
}

function postExcesivo(): bool
{
    return (int) ($_SERVER['CONTENT_LENGTH'] ?? 0) > LIMITE_POST;
}

function recibirImagen(array $archivos): array
{
    if (!array_key_exists('imagen', $archivos)) {
        return ['archivo' => null, 'error' => null];
    }

    $a = $archivos['imagen'];
    if (!is_array($a) || !isset($a['error'], $a['size'], $a['tmp_name'])
        || !is_int($a['error']) || !is_int($a['size']) || !is_string($a['tmp_name'])) {
        return ['archivo' => null, 'error' => 'La entrada de la imagen no tiene la estructura esperada.'];
    }

    if ($a['error'] === UPLOAD_ERR_NO_FILE) {
        return ['archivo' => null, 'error' => null];
    }

    if ($a['error'] !== UPLOAD_ERR_OK) {
        $mensaje = match ($a['error']) {
            UPLOAD_ERR_INI_SIZE => 'La imagen supera el límite de recepción del servidor.',
            UPLOAD_ERR_PARTIAL => 'La imagen ha llegado incompleta. Vuelve a enviarla.',
            UPLOAD_ERR_CANT_WRITE => 'El servidor no ha podido escribir la imagen recibida.',
            default => 'Error de recepción de la imagen.',
        };
        return ['archivo' => null, 'error' => $mensaje];
    }

    return ['archivo' => $a, 'error' => null];
}

function tamanoValido(int $bytes): bool
{
    return $bytes >= 1 && $bytes <= TAMANO_MAXIMO_CARTEL;
}

function validarImagen(array $archivo): array
{
    if (!tamanoValido($archivo['size'])) {
        return ['extension' => null, 'error' => 'La imagen debe ocupar entre 1 y 2 097 152 bytes (2 MiB).'];
    }

    if (!is_file($archivo['tmp_name']) || !is_readable($archivo['tmp_name'])) {
        return ['extension' => null, 'error' => 'No se ha podido leer la imagen recibida.'];
    }

    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($archivo['tmp_name']);
    if ($mime === false || !isset(MIME_CARTELES[$mime])) {
        return ['extension' => null, 'error' => 'La imagen debe ser JPEG, PNG o WebP.'];
    }

    return ['extension' => MIME_CARTELES[$mime], 'error' => null];
}

function rutaCartel(string $nombre): string
{
    return directorioCarteles() . '/' . $nombre;
}

function mimeCartel(string $nombre): string|false
{
    if (preg_match(PATRON_CARTEL, $nombre) !== 1) {
        return false;
    }

    $ruta = rutaCartel($nombre);
    if (!is_file($ruta) || !is_readable($ruta)) {
        return false;
    }

    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($ruta);
    if ($mime === false || !isset(MIME_CARTELES[$mime])) {
        return false;
    }

    return $mime;
}

function listarCarteles(): ?array
{
    $rutas = glob(directorioCarteles() . '/*');
    if ($rutas === false) {
        return null;
    }

    $carteles = [];
    foreach ($rutas as $ruta) {
        $nombre = basename($ruta);
        if (mimeCartel($nombre) !== false) {
            $carteles[] = $nombre;
        }
    }

    return $carteles;
}

function prepararDestino(string $extension, ?string $anterior = null): array
{
    $directorio = directorioCarteles();
    if (!is_dir($directorio) || !is_writable($directorio)) {
        throw new RuntimeException('El almacenamiento de carteles no está disponible.');
    }

    try {
        $nombre = bin2hex(random_bytes(16)) . '.' . $extension;
    } catch (Random\RandomException) {
        throw new RuntimeException('No se ha podido preparar el archivo.');
    }

    $ruta = rutaCartel($nombre);
    if ($nombre === $anterior || file_exists($ruta)) {
        throw new RuntimeException('El nombre generado ya está ocupado. Vuelve a enviar la imagen.');
    }

    return ['nombre' => $nombre, 'ruta' => $ruta];
}

function retirarCartel(string $nombre): bool
{
    if (preg_match(PATRON_CARTEL, $nombre) !== 1) {
        return false;
    }

    $ruta = rutaCartel($nombre);
    if (!is_file($ruta)) {
        return false;
    }

    return unlink($ruta);
}
