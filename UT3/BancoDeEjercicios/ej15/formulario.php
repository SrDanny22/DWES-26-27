<?php

declare(strict_types=1);

$esPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if ($esPost) {
    $titulo = $_POST['titulo'] ?? '';
    $archivo = $_FILES['portada'] ?? null;
    $estructuraValida = is_array($archivo)
        && isset($archivo['error'], $archivo['size'])
        && is_int($archivo['error'])
        && is_int($archivo['size'])
        && isset($archivo['tmp_name']);

    if ($archivo !== null && !$estructuraValida) {
        $errores['portada'] = 'Entrada no válida';
    }

    if ($archivo['error'] === UPLOAD_ERR_NO_FILE) {
        $errores['portada'] = null;
    }

    if ($archivo['error'] === UPLOAD_ERR_OK) {
        if ($archivo['error'] === UPLOAD_ERR_INI_SIZE) {
            $errores['portada'] = 'Supera el tamaño';
        }
        if ($archivo['error'] === UPLOAD_ERR_PARTIAL) {
            $errores['portada'] = 'Falló la recepción';
        }

        $tamMax = 2 * 1024 * 1024;
        if ($archivo['size'] <= 0 || $archivo['size'] > $tamMax) {
            $errores['portada'] = 'Entre 1byte y 2MB';
        } else {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->file($archivo['tmp_name']);

            $permitidos = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/webp' => 'webp',
            ];
            if ($mime === false || !isset($permitidos[$mime])) {
                $errores['portada'] = 'Formato no permitido.';
            } else {
                $extension = $permitidos[$mime];
            }
        }
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
        <input name="titulo">
        <input type="file" name="portada" accept="image/jpeg,image/png/image/webp">
        <button type="submit">Guardar</button>
    </form>
</body>

</html>