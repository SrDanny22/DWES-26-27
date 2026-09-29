<?php

require_once __DIR__ . '/../src/datos.php';
require_once __DIR__ . '/../src/funciones.php';

$id = $_GET['id'] ?? 'todos';

$idSeguro = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica Final</title>
</head>
<body>
    <h1>Cátalogo</h1>

    <?php
    
    $filtroId = buscarPorId($catalogo, $idSeguro);

    if ($filtroId === null) {
        echo "ID no encontrado";
    } else {
        
            echo "ID: " . $filtroId['id'] . "<br>";
            echo "Titulo: " . $filtroId['titulo'] . "<br>";
            echo "Autor: " . $filtroId['autor'] . "<br>";
            echo "Genero: " . $filtroId['genero'] . "<br>";
            echo "Paginas: " . $filtroId['paginas'] . "<br>";
            echo "Disponible: " . ($filtroId['disponible'] ? 'si' : 'no') . "<br>";
            echo "Fecha Alta: " . $filtroId['fechaAlta'] . "<br><br>";
    }


        ?>
</body>
</html>