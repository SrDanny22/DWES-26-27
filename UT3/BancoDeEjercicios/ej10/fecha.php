<?php

function e(string $texto): string {
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$valor = '';
$fechaAlta = null;
$errores = [];

$esPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if ($esPost) {
    $entrada = $_POST['fechaAlta'] ?? '';

    if (!is_string($entrada)) {
        $errores['fechaAlta'] = 'Debe ser texto.';
        $entrada = '';
    }

    $valor = trim($entrada);

    if ($valor !== '') {
        try {
            $fecha = DateTimeImmutable::createFromFormat('!Y-m-d', $valor);
        } catch (ValueError) {
            $fecha = false;
        }

        if ($fecha === false || $fecha->format('Y-m-d') !== $valor) {
            $errores['fechaAlta'] = 'Escribe una fecha válida con formato YYYY-MM-DD.';
        } else {
            $fechaAlta = $fecha;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 10</title>
</head>
<body>
    <form action="fecha.php" method="post">
        <p>
            <label for="fechaAlta">Fecha de alta</label>
            <input id="fechaAlta" name="fechaAlta" type="text" placeholder="YYYY-MM-DD" value="<?= e($valor) ?>">
            <?php if (isset($errores['fechaAlta'])): ?>
                <span><?= e($errores['fechaAlta']) ?></span>
            <?php endif; ?>
        </p>
        <button type="submit">Enviar</button>
    </form>

    <?php if ($esPost && $errores === []): ?>
        <p>Resultado: <?= $fechaAlta === null ? 'null' : 'DateTimeImmutable ' . e($fechaAlta->format('Y-m-d')) ?></p>
    <?php endif; ?>
</body>
</html>
