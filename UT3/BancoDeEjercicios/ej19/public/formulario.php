<?php

declare(strict_types=1);

require __DIR__ . '/../config/portadas.php';

$portadaActual = asegurarPortadaEjemplo();
$portadaAnterior = $portadaActual;
$errores = [];
$mensaje = '';

$esPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if ($esPost) {
    $simularFallo = ($_POST['simularFallo'] ?? '') === '1';
    $otrasFichas = ($_POST['compartida'] ?? '') === '1' ? [$portadaAnterior] : [];

    $resultado = procesarPortada($_FILES, 'portada');

    if ($resultado['error'] !== null) {
        $errores['portada'] = $resultado['error'];
    } elseif ($resultado['portada'] === null) {
        $mensaje = 'No se ha recibido una portada nueva; se conserva la anterior.';
    } else {
        $nueva = $resultado['portada'];

        if (!move_uploaded_file($nueva['tmp_name'], $nueva['destino'])) {
            $errores['portada'] = 'No se ha podido guardar la portada.';
        } else {
            try {
                $portadaActual = $nueva['nombre'];

                if ($simularFallo) {
                    throw new RuntimeException('Fallo simulado al confirmar el cambio.');
                }

                $mensaje = 'Portada sustituida.';
            } catch (RuntimeException) {
                $portadaActual = $portadaAnterior;
                borrarPortada($nueva['nombre']);
                $errores['general'] = 'No se ha podido confirmar el cambio; se conserva la portada anterior.';
            }

            if ($portadaActual === $nueva['nombre'] && !in_array($portadaAnterior, $otrasFichas, true)) {
                borrarPortada($portadaAnterior);
            }
        }
    }
}

$archivosGuardados = listarPortadas();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 19</title>
</head>
<body>
    <?php if (isset($errores['general'])): ?>
        <p><strong><?= e($errores['general']) ?></strong></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <p>
            <label for="portada">Nueva portada (opcional, máximo 2 MiB)</label>
            <input id="portada" name="portada" type="file" accept="image/jpeg,image/png,image/webp">
            <?php if (isset($errores['portada'])): ?>
                <span><?= e($errores['portada']) ?></span>
            <?php endif; ?>
        </p>
        <p>
            <label for="simularFallo">Provocar un fallo antes de confirmar</label>
            <input id="simularFallo" name="simularFallo" type="checkbox" value="1">
        </p>
        <p>
            <label for="compartida">Otra ficha usa la portada anterior</label>
            <input id="compartida" name="compartida" type="checkbox" value="1">
        </p>
        <button type="submit">Sustituir</button>
    </form>

    <?php if ($mensaje !== ''): ?>
        <p><?= e($mensaje) ?></p>
    <?php endif; ?>

    <h2>Estado</h2>
    <p>Portada anterior: <?= e($portadaAnterior) ?></p>
    <p>$portadaActual: <?= e($portadaActual) ?></p>
    <p>Archivos en storage/portadas:</p>
    <ul>
        <?php foreach ($archivosGuardados as $archivo): ?>
            <li><?= e($archivo) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
