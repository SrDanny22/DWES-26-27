<?php

declare(strict_types=1);

$titulos = ["EL Quijote", "EL Lazarillo", "Chunchunmaru", "Cronicas Vampiricas"];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 32</title>
</head>
<body>
    <h1>Lista de libros</h1>
    <ul>
        <?php foreach ($titulos as $titulo): ?>
            <li>
                <?= htmlspecialchars($titulo) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>