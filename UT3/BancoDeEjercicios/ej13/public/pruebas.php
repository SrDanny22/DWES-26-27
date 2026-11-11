<?php

declare(strict_types=1);

require __DIR__ . '/../config/portadas.php';

function archivoPreparado(int $error, int $size): array
{
    return [
        'name' => 'portada.png',
        'type' => 'image/png',
        'tmp_name' => '/tmp/php1234',
        'error' => $error,
        'size' => $size,
    ];
}

$casos = [
    'Clave portada ausente' => [],
    'UPLOAD_ERR_NO_FILE' => ['portada' => archivoPreparado(UPLOAD_ERR_NO_FILE, 0)],
    'UPLOAD_ERR_OK' => ['portada' => archivoPreparado(UPLOAD_ERR_OK, 1500)],
    'UPLOAD_ERR_INI_SIZE' => ['portada' => archivoPreparado(UPLOAD_ERR_INI_SIZE, 0)],
    'UPLOAD_ERR_PARTIAL' => ['portada' => archivoPreparado(UPLOAD_ERR_PARTIAL, 0)],
    'Otro código de error' => ['portada' => archivoPreparado(UPLOAD_ERR_NO_TMP_DIR, 0)],
    'Estructura de portada[]' => ['portada' => [
        'name' => ['portada.png'],
        'type' => ['image/png'],
        'tmp_name' => ['/tmp/php1234'],
        'error' => [UPLOAD_ERR_OK],
        'size' => [1500],
    ]],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 13 - Pruebas</title>
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th>Caso</th>
                <th>Estado</th>
                <th>¿Error?</th>
                <th>Respuesta</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($casos as $caso => $archivos): ?>
                <?php $estado = estadoRecepcion($archivos, 'portada'); ?>
                <tr>
                    <td><?= e($caso) ?></td>
                    <td><?= e($estado) ?></td>
                    <td><?= esErrorRecepcion($estado) ? 'Sí' : 'No' ?></td>
                    <td><?= e(mensajeRecepcion($estado)) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p><a href="formulario.php">Volver</a></p>
</body>
</html>
