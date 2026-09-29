<?php

require_once __DIR__ . '/../src/datos.php';
require_once __DIR__ . '/../src/funciones.php';

$genero = $_GET['genero'] ?? 'todos';

$disponible = $_GET['disponible'] ?? '';

$tituloAutor = $_GET['q'] ?? 'todos';

$genero = strtolower(trim($genero));

$tituloAutor = strtolower(trim($tituloAutor));

$generoSeguro = htmlspecialchars($genero, ENT_QUOTES, 'UTF-8');
$disponibleSeguro = htmlspecialchars($disponible, ENT_QUOTES, 'UTF-8');
$tituloAutorSeguro = htmlspecialchars($tituloAutor, ENT_QUOTES, 'UTF-8');

$fecha = new DateTimeImmutable();


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica Final</title>
</head>
<body>
    <h1>Estadísticas</h1>

    <?php
    
    $filtroGenero = buscarPorTexto(filtrarPorGenero($catalogo, $generoSeguro), $tituloAutorSeguro);

    $totalDisponible = 0;

    $libroMayor = obtenerLibroMasLargo($filtroGenero);

    if ($disponibleSeguro) {
        $filtroGenero = filtrarDisponible($filtroGenero);
    }  
        foreach ($filtroGenero as $libro) {
            if ($libro['disponible'] === true) {
                $totalDisponible++;
            }
        }

        echo "Número total de libros: " . count($filtroGenero) . "<br>";
        echo "Numero total de disponibles: " . $totalDisponible . "<br>";
        echo "Media de páginas: " . calcularMedia($filtroGenero) . "<br><br>";
        echo "<h3>Libro con mayor número de paginas: </h3><br>";
        echo "Libro: " . $libroMayor['titulo'] . "<br>";
        echo "Páginas: " . $libroMayor['paginas'] . "<br><br>";

        echo "Fecha del informe: " . $fecha->format('d/m/Y h:i');
        ?>
</body>
</html>