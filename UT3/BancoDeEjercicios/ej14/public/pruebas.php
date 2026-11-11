<?php

declare(strict_types=1);

require __DIR__ . '/../config/portadas.php';

$tamanos = [0, 1, 2097152, 2097153];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 14 - Pruebas</title>
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th>Tamaño (bytes)</th>
                <th>¿Aceptado?</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tamanos as $tamano): ?>
                <tr>
                    <td><?= $tamano ?></td>
                    <td><?= tamanoPortadaValido($tamano) ? 'Sí' : 'No' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p><a href="formulario.php">Volver</a></p>
</body>
</html>
