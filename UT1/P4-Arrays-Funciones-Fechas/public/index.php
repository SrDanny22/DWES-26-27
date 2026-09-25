<?php

require_once __DIR__ . '/../src/datos.php';
require_once __DIR__ . '/../src/funciones.php';

$genero = $_GET['genero'] ?? 'todos';
$disponible = $_GET['disponible'] ?? 0;

$genero = strtolower(trim($genero));

$generoSeguro = htmlspecialchars($genero, ENT_QUOTES, 'UTF-8');

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
</head>
<body>
    <h1>Catalogo completo</h1>

    <?php
    foreach ($catalogo as $libro) {
        echo "ID: " . $libro['id'] . "<br>";
        echo "titulo: " . $libro['titulo'] . "<br>";
        echo "autor: " . $libro['autor'] . "<br>";
        echo "genero: " . $libro['genero'] . "<br>";
        echo "paginas: " . $libro['paginas'] . "<br>";
        echo "disponible: " . $libro['disponible'] . "<br>";
        echo "fechaAlta: " . $libro['fechaAlta'] ;
    }
    ?>
</body>
</html>