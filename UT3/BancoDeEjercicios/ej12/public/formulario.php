<?php

declare(strict_types=1);

require __DIR__ . '/../config/portadas.php';

$titulo = '';
$errores = [];
$datosCliente = null;

$esPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if ($esPost) {
    $entrada = $_POST['titulo'] ?? '';
    if (!is_string($entrada)) {
        $errores['titulo'] = 'Debe ser texto.';
        $entrada = '';
    }
    $titulo = trim($entrada);

    $archivo = $_FILES['portada'] ?? null;
    if (!estructuraPortadaValida($archivo)) {
        $errores['portada'] = 'La portada no tiene la estructura de un único archivo.';
    } else {
        $datosCliente = [
            'name' => is_string($archivo['name'] ?? null) ? $archivo['name'] : '',
            'type' => is_string($archivo['type'] ?? null) ? $archivo['type'] : '',
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 12</title>
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
            <label for="portada">Portada</label>
            <input id="portada" name="portada" type="file" accept="image/jpeg,image/png,image/webp">
            <?php if (isset($errores['portada'])): ?>
                <span><?= e($errores['portada']) ?></span>
            <?php endif; ?>
        </p>
        <button type="submit">Guardar</button>
    </form>

    <?php if ($datosCliente !== null): ?>
        <h2>Datos enviados por el cliente</h2>
        <p>No se usan para elegir el nombre de destino ni para aceptar el formato.</p>
        <ul>
            <li>name: <?= e($datosCliente['name']) ?></li>
            <li>type: <?= e($datosCliente['type']) ?></li>
        </ul>
    <?php endif; ?>
</body>
</html>
