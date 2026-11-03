<?php

function e(string $texto): string {
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// Con el fragmento original, (int) "12abc" produce 12: se pierde "abc" y el dato se acepta.

$valor = '';
$paginas = null;
$errores = [];

$esPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if ($esPost) {
    $entrada = $_POST['paginas'] ?? '';

    if (!is_string($entrada)) {
        $errores['paginas'] = 'Debe ser texto.';
    } else {
        $valor = $entrada;
        $numero = filter_var($entrada, FILTER_VALIDATE_INT);

        if ($numero === false || $numero < 1 || $numero > 3000) {
            $errores['paginas'] = 'Escribe un entero entre 1 y 3000.';
        }
    }

    if ($errores === []) {
        $paginas = $numero;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 7</title>
</head>
<body>
    <form action="paginas.php" method="post">
        <p>
            <label for="paginas">Páginas</label>
            <input id="paginas" name="paginas" type="text" value="<?= e($valor) ?>">
            <?php if (isset($errores['paginas'])): ?>
                <span><?= e($errores['paginas']) ?></span>
            <?php endif; ?>
        </p>
        <button type="submit">Enviar</button>
    </form>

    <?php if ($paginas !== null): ?>
        <p>Número aceptado: <?= $paginas ?></p>
    <?php endif; ?>
</body>
</html>
