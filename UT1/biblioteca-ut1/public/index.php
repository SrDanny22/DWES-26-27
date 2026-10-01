<?php

require_once __DIR__ . '/../src/datos.php';
require_once __DIR__ . '/../src/funciones.php';

$genero = $_GET['genero'] ?? 'todos';

$disponible = $_GET['disponible'] ?? '';

$tituloAutor = $_GET['q'] ?? 'todos';

$orden = $_GET['orden'] ?? null;



$genero = strtolower(trim($genero));

$tituloAutor = strtolower(trim($tituloAutor));

date_default_timezone_set('Europe/Madrid');

$generoSeguro = htmlspecialchars($genero, ENT_QUOTES, 'UTF-8');
$disponibleSeguro = htmlspecialchars($disponible, ENT_QUOTES, 'UTF-8');
$tituloAutorSeguro = htmlspecialchars($tituloAutor, ENT_QUOTES, 'UTF-8');


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

    $filtroGenero = buscarPorTexto(filtrarPorGenero($catalogo, $generoSeguro), $tituloAutorSeguro);

    if ($disponibleSeguro) {
        $filtroGenero = filtrarDisponible($filtroGenero);
    }

    if ($orden === 'titulo') {
        $filtroGenero = ordenarPorTitulo($filtroGenero);
    } elseif ($orden === 'paginas') {
        $filtroGenero = ordenarPorPagina($filtroGenero);
    }

    foreach ($filtroGenero as $libro) {
        echo "ID: " . $libro['id'] . "<br>";
        echo "Titulo: " . $libro['titulo'] . "<br>";
        echo "Autor: " . $libro['autor'] . "<br>";
        echo "Genero: " . $libro['genero'] . "<br>";
        echo "Paginas: " . $libro['paginas'] . "<br>";
        echo "Disponible: " . ($libro['disponible'] ? 'si' : 'no') . "<br>";
        echo "Fecha Alta: " . $libro['fechaAlta'] . "<br>";
        echo "<a href=/public/libro.php?id=" . $libro['id'] . ">Ver libro</a><br><br>";
    }

    echo "Total de resultados: " . count($filtroGenero);
    ?>
</body>

</html>