<?php

declare(strict_types=1);

require __DIR__ . '/../config/portadas.php';

$portadaActual = asegurarPortadaEjemplo();
$portadaAnterior = $portadaActual;

$valores = ['titulo' => '', 'paginas' => ''];
$errores = [];
$errorPortada = null;
$erroresGenerales = [];
$confirmacion = null;

$esPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if ($esPost) {
    $campos = validarCampos($_POST);
    $valores = $campos['valores'];
    $errores = $campos['errores'];

    $resultado = procesarPortada($_FILES, 'portada');
    $errorPortada = $resultado['error'];

    if ($errores === [] && $errorPortada === null) {
        $nueva = $resultado['portada'];

        if ($nueva !== null && !move_uploaded_file($nueva['tmp_name'], $nueva['destino'])) {
            $erroresGenerales[] = 'No se ha podido guardar la portada.';
        } else {
            if ($nueva !== null) {
                $portadaActual = $nueva['nombre'];
                borrarPortada($portadaAnterior);
            }

            $confirmacion = [
                'titulo' => $valores['titulo'],
                'paginas' => $campos['paginas'],
                'portada' => $portadaActual,
            ];
        }
    }
}

$archivosGuardados = listarPortadas();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 21</title>
</head>
<body>
    <?php if ($confirmacion !== null): ?>
        <p>Libro guardado: <?= e($confirmacion['titulo']) ?>, <?= $confirmacion['paginas'] ?> páginas.</p>
        <p>Portada: <?= e($confirmacion['portada']) ?></p>
        <p><a href="formulario-portada.php">Nuevo libro</a></p>
    <?php else: ?>
        <?php foreach ($erroresGenerales as $error): ?>
            <p><strong><?= e($error) ?></strong></p>
        <?php endforeach; ?>

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
                <?php if ($errorPortada !== null): ?>
                    <span><?= e($errorPortada) ?></span>
                <?php endif; ?>
            </p>
            <button type="submit">Guardar</button>
        </form>
    <?php endif; ?>

    <h2>Estado</h2>
    <p>$portadaActual: <?= e($portadaActual) ?></p>
    <p>Archivos en storage/portadas:</p>
    <ul>
        <?php foreach ($archivosGuardados as $archivo): ?>
            <li><?= e($archivo) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
