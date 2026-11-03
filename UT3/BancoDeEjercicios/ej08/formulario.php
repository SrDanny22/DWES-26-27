<?php

function e(string $texto): string {
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$generos = ['ciencia' => 'Ciencia', 'fantasia' => 'Fantasía', 'terror' => 'Terror'];

$valores = ['genero' => '', 'destacado' => false, 'observaciones' => ''];
$errores = [];

$esPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if ($esPost) {
    $genero = $_POST['genero'] ?? '';
    if (is_string($genero) && in_array($genero, array_keys($generos), true)) {
        $valores['genero'] = $genero;
    } else {
        $errores['genero'] = 'Elige ciencia, fantasía o terror.';
    }

    if (isset($_POST['destacado'])) {
        if ($_POST['destacado'] === '1') {
            $valores['destacado'] = true;
        } else {
            $errores['destacado'] = 'Valor de destacado no válido.';
        }
    }

    $observaciones = $_POST['observaciones'] ?? '';
    if (is_string($observaciones)) {
        $valores['observaciones'] = $observaciones;
    } else {
        $errores['observaciones'] = 'Debe ser texto.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 8</title>
</head>
<body>
    <form action="formulario.php" method="post">
        <p>
            <label for="genero">Género</label>
            <select id="genero" name="genero">
                <option value=""></option>
                <?php foreach ($generos as $clave => $texto): ?>
                    <option value="<?= e($clave) ?>" <?= $valores['genero'] === $clave ? 'selected' : '' ?>><?= e($texto) ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errores['genero'])): ?>
                <span><?= e($errores['genero']) ?></span>
            <?php endif; ?>
        </p>
        <p>
            <label for="destacado">Destacado</label>
            <input id="destacado" name="destacado" type="checkbox" value="1" <?= $valores['destacado'] ? 'checked' : '' ?>>
            <?php if (isset($errores['destacado'])): ?>
                <span><?= e($errores['destacado']) ?></span>
            <?php endif; ?>
        </p>
        <p>
            <label for="observaciones">Observaciones</label>
            <textarea id="observaciones" name="observaciones"><?= e($valores['observaciones']) ?></textarea>
            <?php if (isset($errores['observaciones'])): ?>
                <span><?= e($errores['observaciones']) ?></span>
            <?php endif; ?>
        </p>
        <button type="submit">Enviar</button>
    </form>

    <?php if ($esPost && $errores === []): ?>
        <p>Datos correctos.</p>
    <?php endif; ?>
</body>
</html>
