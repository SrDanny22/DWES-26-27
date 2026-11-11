<?php

declare(strict_types=1);

const DIRECTORIO_PORTADAS = __DIR__ . '/../storage/portadas';
const TAMANO_MAXIMO_PORTADA = 2 * 1024 * 1024;
const MIME_PORTADAS = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/webp' => 'webp',
];
const PATRON_PORTADA = '/\A[a-f0-9]{32}\.(jpg|png|webp)\z/';
const PNG_EJEMPLO = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function validarCampos(array $entrada): array
{
    $valores = ['titulo' => '', 'paginas' => ''];
    $errores = [];

    foreach ($valores as $campo => $inicial) {
        $valor = $entrada[$campo] ?? '';
        if (!is_string($valor)) {
            $errores[$campo] = 'Debe ser texto.';
            $valor = '';
        }
        $valores[$campo] = trim($valor);
    }

    if (!isset($errores['titulo'])) {
        if ($valores['titulo'] === '') {
            $errores['titulo'] = 'Escribe el título.';
        } elseif (mb_strlen($valores['titulo'], 'UTF-8') > 120) {
            $errores['titulo'] = 'El título admite hasta 120 caracteres.';
        }
    }

    $paginas = filter_var($valores['paginas'], FILTER_VALIDATE_INT);
    if (!isset($errores['paginas']) && ($paginas === false || $paginas < 1 || $paginas > 3000)) {
        $errores['paginas'] = 'Escribe un entero entre 1 y 3000.';
    }

    return [
        'valores' => $valores,
        'errores' => $errores,
        'paginas' => isset($errores['paginas']) ? null : $paginas,
    ];
}

function estructuraPortadaValida(mixed $archivo): bool
{
    return is_array($archivo)
        && isset($archivo['error'], $archivo['size'], $archivo['tmp_name'])
        && is_int($archivo['error'])
        && is_int($archivo['size'])
        && is_string($archivo['tmp_name']);
}

function estructuraMultipleValida(mixed $archivos): bool
{
    if (!is_array($archivos)) {
        return false;
    }

    foreach (['name', 'type', 'tmp_name', 'error', 'size'] as $clave) {
        if (!isset($archivos[$clave]) || !is_array($archivos[$clave])) {
            return false;
        }
    }

    $indices = array_keys($archivos['error']);
    foreach (['name', 'type', 'tmp_name', 'size'] as $clave) {
        if (array_keys($archivos[$clave]) !== $indices) {
            return false;
        }
    }

    foreach ($indices as $i) {
        if (!is_string($archivos['name'][$i])
            || !is_string($archivos['type'][$i])
            || !is_string($archivos['tmp_name'][$i])
            || !is_int($archivos['error'][$i])
            || !is_int($archivos['size'][$i])) {
            return false;
        }
    }

    return true;
}

function estadoRecepcion(array $archivos, string $campo): string
{
    if (!array_key_exists($campo, $archivos)) {
        return 'ausente';
    }

    if (!estructuraPortadaValida($archivos[$campo])) {
        return 'estructura';
    }

    return match ($archivos[$campo]['error']) {
        UPLOAD_ERR_NO_FILE => 'sin-archivo',
        UPLOAD_ERR_OK => 'ok',
        UPLOAD_ERR_INI_SIZE => 'demasiado-grande',
        UPLOAD_ERR_PARTIAL => 'parcial',
        default => 'error',
    };
}

function esErrorRecepcion(string $estado): bool
{
    return !in_array($estado, ['ausente', 'sin-archivo', 'ok'], true);
}

function mensajeRecepcion(string $estado): string
{
    return match ($estado) {
        'ausente' => 'No se ha enviado el campo portada; se continúa sin portada nueva.',
        'sin-archivo' => 'No se ha seleccionado ninguna portada; se continúa sin portada nueva.',
        'ok' => 'Portada recibida; se comprueban su tamaño y su formato.',
        'demasiado-grande' => 'La portada supera el tamaño máximo que admite el servidor.',
        'parcial' => 'La portada solo se ha recibido en parte; vuelve a enviarla.',
        'estructura' => 'La portada no tiene la estructura de un único archivo.',
        default => 'No se ha podido recibir la portada.',
    };
}

function tamanoPortadaValido(int $tamano): bool
{
    return $tamano >= 1 && $tamano <= TAMANO_MAXIMO_PORTADA;
}

function detectarMime(string $ruta): string|false
{
    return (new finfo(FILEINFO_MIME_TYPE))->file($ruta);
}

function comprobarArchivo(array $archivo): array
{
    if (!tamanoPortadaValido($archivo['size'])) {
        return ['error' => 'La portada debe ocupar entre 1 byte y 2 MiB.', 'extension' => null];
    }

    $mime = detectarMime($archivo['tmp_name']);
    if ($mime === false) {
        return ['error' => 'No se ha podido comprobar el formato de la portada.', 'extension' => null];
    }

    if (!isset(MIME_PORTADAS[$mime])) {
        return ['error' => 'La portada debe ser una imagen JPEG, PNG o WebP.', 'extension' => null];
    }

    return ['error' => null, 'extension' => MIME_PORTADAS[$mime]];
}

function prepararDestino(string $extension): array
{
    try {
        $nombre = bin2hex(random_bytes(16)) . '.' . $extension;
    } catch (Random\RandomException) {
        return ['error' => 'No se ha podido preparar el archivo.', 'nombre' => null, 'destino' => null];
    }

    if (!is_dir(DIRECTORIO_PORTADAS) || !is_writable(DIRECTORIO_PORTADAS)) {
        return ['error' => 'El almacenamiento de portadas no está disponible.', 'nombre' => null, 'destino' => null];
    }

    $destino = DIRECTORIO_PORTADAS . '/' . $nombre;
    if (file_exists($destino)) {
        return ['error' => 'Nombre ocupado; vuelve a enviar la portada.', 'nombre' => null, 'destino' => null];
    }

    return ['error' => null, 'nombre' => $nombre, 'destino' => $destino];
}

function procesarPortada(array $archivos, string $campo): array
{
    $estado = estadoRecepcion($archivos, $campo);
    if ($estado === 'ausente' || $estado === 'sin-archivo') {
        return ['error' => null, 'portada' => null];
    }

    if ($estado !== 'ok') {
        return ['error' => mensajeRecepcion($estado), 'portada' => null];
    }

    $archivo = $archivos[$campo];
    $comprobacion = comprobarArchivo($archivo);
    if ($comprobacion['error'] !== null) {
        return ['error' => $comprobacion['error'], 'portada' => null];
    }

    $destino = prepararDestino($comprobacion['extension']);
    if ($destino['error'] !== null) {
        return ['error' => $destino['error'], 'portada' => null];
    }

    return [
        'error' => null,
        'portada' => [
            'tmp_name' => $archivo['tmp_name'],
            'nombre' => $destino['nombre'],
            'destino' => $destino['destino'],
        ],
    ];
}

function borrarPortada(string $nombre): bool
{
    if (preg_match(PATRON_PORTADA, $nombre) !== 1) {
        error_log('Nombre de portada no válido al intentar borrarla.');
        return false;
    }

    $ruta = DIRECTORIO_PORTADAS . '/' . $nombre;
    if (is_file($ruta) && !unlink($ruta)) {
        error_log('No se ha podido borrar la portada ' . $nombre . '.');
        return false;
    }

    return true;
}

function asegurarPortadaEjemplo(): string
{
    $nombre = '0123456789abcdef0123456789abcdef.png';
    $ruta = DIRECTORIO_PORTADAS . '/' . $nombre;

    if (is_dir(DIRECTORIO_PORTADAS) && !is_file($ruta)) {
        file_put_contents($ruta, base64_decode(PNG_EJEMPLO));
    }

    return $nombre;
}

function listarPortadas(): array
{
    if (!is_dir(DIRECTORIO_PORTADAS)) {
        return [];
    }

    return array_values(array_filter(
        scandir(DIRECTORIO_PORTADAS),
        fn (string $archivo): bool => preg_match(PATRON_PORTADA, $archivo) === 1
    ));
}
