<?php

function e(string $texto): string {
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$valores = ['titulo' => '', 'paginas' => ''];
$errores = [];
$datos = null;

$esPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if ($esPost) {
    foreach ($valores as $campo => $inicial) {
        $entrada = $_POST[$campo] ?? '';
        if (!is_string($entrada)) {
            $errores[$campo] = 'Debe ser texto.';
            $entrada = '';
        }
        $valores[$campo] = trim($entrada);
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

    if ($errores === []) {
        $datos = ['titulo' => $valores['titulo'], 'paginas' => $paginas];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 11</title>
</head>
<body>
    <?php if ($datos !== null): ?>
        <p>Libro guardado: <?= e($datos['titulo']) ?>, <?= $datos['paginas'] ?> páginas.</p>
        <p><a href="ejemplo.php">Nuevo libro</a></p>
    <?php else: ?>
        <form action="ejemplo.php" method="post">
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
            <button type="submit">Guardar</button>
        </form>
    <?php endif; ?>
</body>
</html>
