<?php

declare(strict_types=1);

require __DIR__ . '/../config/portadas.php';

$errores = [];
$aceptadas = [];
$nombresCliente = [];

$esPost = ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';

if ($esPost) {
    $simularFallo = ($_POST['simularFallo'] ?? '') === '1';
    $archivos = $_FILES['portadas'] ?? null;
    $candidatas = [];

    if (!estructuraMultipleValida($archivos)) {
        $errores['conjunto'] = 'Las portadas no tienen la estructura esperada.';
    } elseif (count($archivos['error']) > 3) {
        $errores['conjunto'] = 'Puedes enviar como máximo tres portadas.';
    } elseif (count($archivos['error']) === 1 && reset($archivos['error']) === UPLOAD_ERR_NO_FILE) {
        $errores['conjunto'] = 'No se ha seleccionado ninguna portada.';
    } else {
        $nombresCliente = $archivos['name'];

        foreach ($archivos['error'] as $i => $codigo) {
            $archivo = [
                'name' => $archivos['name'][$i],
                'type' => $archivos['type'][$i],
                'tmp_name' => $archivos['tmp_name'][$i],
                'error' => $codigo,
                'size' => $archivos['size'][$i],
            ];

            $estado = estadoRecepcion(['portada' => $archivo], 'portada');
            if ($estado === 'sin-archivo') {
                $errores[$i] = 'No se ha recibido este archivo.';
                continue;
            }
            if ($estado !== 'ok') {
                $errores[$i] = mensajeRecepcion($estado);
                continue;
            }

            $comprobacion = comprobarArchivo($archivo);
            if ($comprobacion['error'] !== null) {
                $errores[$i] = $comprobacion['error'];
                continue;
            }

            $destino = prepararDestino($comprobacion['extension']);
            if ($destino['error'] !== null) {
                $errores[$i] = $destino['error'];
                continue;
            }

            $candidatas[$i] = [
                'tmp_name' => $archivo['tmp_name'],
                'nombre' => $destino['nombre'],
                'destino' => $destino['destino'],
            ];
        }
    }

    if ($errores === []) {
        $movidas = [];

        foreach ($candidatas as $i => $candidata) {
            $fallo = $simularFallo && count($movidas) === 1;

            if ($fallo || !move_uploaded_file($candidata['tmp_name'], $candidata['destino'])) {
                $errores[$i] = 'No se ha podido guardar esta portada.';

                foreach ($movidas as $nombre) {
                    borrarPortada($nombre);
                }
                $movidas = [];
                break;
            }

            $movidas[] = $candidata['nombre'];
        }

        if ($errores === []) {
            $aceptadas = $movidas;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 20</title>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <p>
            <label for="portadas">Portadas (hasta tres, máximo 2 MiB cada una)</label>
            <input id="portadas" name="portadas[]" type="file" accept="image/jpeg,image/png,image/webp" multiple>
        </p>
        <p>
            <label for="simularFallo">Provocar un fallo en el segundo movimiento</label>
            <input id="simularFallo" name="simularFallo" type="checkbox" value="1">
        </p>
        <button type="submit">Subir</button>
    </form>

    <?php if (isset($errores['conjunto'])): ?>
        <p><?= e($errores['conjunto']) ?></p>
    <?php endif; ?>

    <?php if ($errores !== [] && !isset($errores['conjunto'])): ?>
        <p>No se ha aceptado ninguna portada:</p>
        <ul>
            <?php foreach ($errores as $i => $error): ?>
                <li>Archivo <?= $i + 1 ?> (<?= e($nombresCliente[$i] ?? '') ?>): <?= e($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if ($aceptadas !== []): ?>
        <p>Portadas aceptadas:</p>
        <ul>
            <?php foreach ($aceptadas as $nombre): ?>
                <li><?= e($nombre) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>
