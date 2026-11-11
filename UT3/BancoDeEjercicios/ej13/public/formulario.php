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
    } else {
        $mensaje = mensajeRecepcion($estado);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 13</title>
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
            <label for="portada">Portada (opcional)</label>
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

    <p><a href="pruebas.php">Probar las ramas con arrays preparados</a></p>
</body>
</html>
