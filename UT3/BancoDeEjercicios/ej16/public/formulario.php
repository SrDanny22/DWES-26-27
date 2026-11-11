<?php

declare(strict_types=1);

require __DIR__ . '/../config/portadas.php';

$titulo = '';
$errores = [];
$mensaje = '';
$preparado = null;

$esPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if ($esPost) {
    $entrada = $_POST['titulo'] ?? '';
    if (!is_string($entrada)) {
        $errores['titulo'] = 'Debe ser texto.';
        $entrada = '';
    }
    $titulo = trim($entrada);

    $estado = estadoRecepcion($_FILES, 'portada');
    if (esErrorRecepcion($estado)) {
        $errores['portada'] = mensajeRecepcion($estado);
    } elseif ($estado !== 'ok') {
        $mensaje = mensajeRecepcion($estado);
    } else {
        $archivo = $_FILES['portada'];
        $comprobacion = comprobarArchivo($archivo);

        if ($comprobacion['error'] !== null) {
            $errores['portada'] = $comprobacion['error'];
        } else {
            $destino = prepararDestino($comprobacion['extension']);

            if ($destino['error'] !== null) {
                $errores['portada'] = $destino['error'];
            } else {
                $original = is_string($archivo['name'] ?? null) ? pathinfo($archivo['name'], PATHINFO_FILENAME) : '';
                $base = pathinfo($destino['nombre'], PATHINFO_FILENAME);

                $preparado = [
                    'nombre' => $destino['nombre'],
                    'hexadecimal' => preg_match('/\A[a-f0-9]{32}\z/', $base) === 1,
                    'incluyeOriginal' => $original !== '' && str_contains($destino['nombre'], $original),
                ];
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 16</title>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <p>
            <label for="titulo">Título</label>
            <input id="titulo" name="titulo" type="text" value="<?= e($titulo) ?>">
            <?php if (isset($errores['titulo'])): ?>
                <span><?= e($errores['titulo']) ?></span>
            <?php endif; ?>
        </p>
        <p>
            <label for="portada">Portada (opcional, máximo 2 MiB)</label>
            <input id="portada" name="portada" type="file" accept="image/jpeg,image/png,image/webp">
            <?php if (isset($errores['portada'])): ?>
                <span><?= e($errores['portada']) ?></span>
            <?php endif; ?>
        </p>
        <button type="submit">Guardar</button>
    </form>

    <?php if ($preparado !== null): ?>
        <ul>
            <li>Nombre generado: <?= e($preparado['nombre']) ?></li>
            <li>32 caracteres hexadecimales antes de la extensión: <?= $preparado['hexadecimal'] ? 'Sí' : 'No' ?></li>
            <li>Incluye partes del nombre original: <?= $preparado['incluyeOriginal'] ? 'Sí' : 'No' ?></li>
        </ul>
    <?php endif; ?>

    <?php if ($mensaje !== ''): ?>
        <p><?= e($mensaje) ?></p>
    <?php endif; ?>
</body>
</html>
