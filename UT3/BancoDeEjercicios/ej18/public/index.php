<?php

declare(strict_types=1);

require __DIR__ . '/../config/portadas.php';

$valores = ['titulo' => '', 'paginas' => ''];
$errores = [];
$portadaActual = null;
$datos = null;

$esPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if ($esPost) {
    $campos = validarCampos($_POST);
    $valores = $campos['valores'];
    $errores = $campos['errores'];

    $resultado = procesarPortada($_FILES, 'portada');
    if ($resultado['error'] !== null) {
        $errores['portada'] = $resultado['error'];
    }

    if ($errores === [] && $resultado['portada'] !== null) {
        $nueva = $resultado['portada'];
        if (move_uploaded_file($nueva['tmp_name'], $nueva['destino'])) {
            $portadaActual = $nueva['nombre'];
        } else {
            $errores['portada'] = 'No se ha podido guardar la portada.';
        }
    }

    if ($errores === []) {
        $datos = ['titulo' => $valores['titulo'], 'paginas' => $campos['paginas']];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 18</title>
</head>
<body>
    <?php if ($datos !== null): ?>
        <p>Libro guardado: <?= e($datos['titulo']) ?>, <?= $datos['paginas'] ?> páginas.</p>
        <?php if ($portadaActual !== null): ?>
            <img src="/portada.php?nombre=<?= e($portadaActual) ?>" alt="Portada de <?= e($datos['titulo']) ?>">
        <?php else: ?>
            <p>Sin portada</p>
        <?php endif; ?>
        <p><a href="index.php">Nuevo libro</a></p>
    <?php else: ?>
        <form method="post" enctype="multipart/form-data">
            <p>
                <label for="titulo">Título</label>
                <input id="titulo" name="titulo" type="text" value="<?= e($valores['titulo']) ?>">
                <?php if (isset($errores['titulo'])): ?>
                    <span><?= e($errores['titulo']) ?></span>
                <?php endif; ?>
            </p>
            <p>
                <label for="paginas">Páginas</label>
                <input id="paginas" name="paginas" type="text" value="<?= e($valores['paginas']) ?>">
                <?php if (isset($errores['paginas'])): ?>
                    <span><?= e($errores['paginas']) ?></span>
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
    <?php endif; ?>
</body>
</html>
