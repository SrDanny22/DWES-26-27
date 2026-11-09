<?php

function e(string $texto): string {
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$titulo = '';
$errores = [];

$metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$esPost = $metodo === 'POST';

if ($esPost) {
    $entrada = $_POST['titulo'] ?? '';
    if (!is_string($entrada)) {
        $errores['titulo'] = 'El título debe ser texto.';
        $entrada = '';
    }
    $titulo = trim($entrada);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 3</title>
</head>
<body>
    <form action="recibir.php" method="post">
        <p>
            <label for="titulo">Título</label>
            <input id="titulo" name="titulo" type="text" value="<?= e($titulo) ?>">
            <?php if (isset($errores['titulo'])): ?>
                <span><?= e($errores['titulo']) ?></span>
            <?php endif; ?>
        </p>
        <button type="submit">Enviar</button>
    </form>
</body>
</html>