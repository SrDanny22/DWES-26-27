<?php

function e(string $texto): string {
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$valores = ['titulo' => '', 'autor' => ''];
$errores = [];

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

    if (!isset($errores['autor']) && $valores['autor'] === '') {
        $errores['autor'] = 'Escribe el autor.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 6</title>
</head>
<body>
    <form action="validar.php" method="post">
        <p>
            <label for="titulo">Título</label>
            <input id="titulo" name="titulo" type="text" value="<?= e($valores['titulo']) ?>">
            <?php if (isset($errores['titulo'])): ?>
                <span><?= e($errores['titulo']) ?></span>
            <?php endif; ?>
        </p>
        <p>
            <label for="autor">Autor</label>
            <input id="autor" name="autor" type="text" value="<?= e($valores['autor']) ?>">
            <?php if (isset($errores['autor'])): ?>
                <span><?= e($errores['autor']) ?></span>
            <?php endif; ?>
        </p>
        <button type="submit">Enviar</button>
    </form>

    <?php if ($esPost && $errores === []): ?>
        <p>Aceptado: "<?= e($valores['titulo']) ?>" de "<?= e($valores['autor']) ?>"</p>
    <?php endif; ?>
</body>
</html>


