<?php

declare(strict_types=1);

require __DIR__ . '/../config/portadas.php';

$titulo = '';
$errores = [];
$mensaje = '';

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
    } elseif (!tamanoPortadaValido($_FILES['portada']['size'])) {
        $errores['portada'] = 'La portada debe ocupar entre 1 byte y 2 MiB.';
    } else {
        $mensaje = 'Tamaño correcto: ' . $_FILES['portada']['size'] . ' bytes.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 14</title>
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

    <?php if ($mensaje !== ''): ?>
        <p><?= e($mensaje) ?></p>
    <?php endif; ?>

    <p><a href="pruebas.php">Probar los tamaños límite</a></p>
</body>
</html>
