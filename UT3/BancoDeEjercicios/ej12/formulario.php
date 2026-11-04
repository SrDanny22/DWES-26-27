<?php
declare(strict_types=1);

$archivo = $_FILES['portada'] ?? null;
$estructuraValida = is_array($archivo)
    && isset($archivo['error'], $archivo['size'])
    && is_int($archivo['error'])
    && is_int($archivo['size'])
    && isset($archivo['tmp_name']);
if ($archivo !== null && !$estructuraValida) {
    $errores['portada'] = 'Entrada no válida';
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
        <input name="titulo">
        <input type="file" name="portada" accept="image/jpeg,image/png/image/webp">
        <button type="submit">Guardar</button>
    </form>
</body>
</html>