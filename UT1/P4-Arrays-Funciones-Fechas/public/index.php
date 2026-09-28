<?php

require_once __DIR__ . '/../src/datos.php';
require_once __DIR__ . '/../src/funciones.php';

$genero = $_GET['genero'] ?? 'todos';
$disponible = $_GET['disponible'] ?? '';

$genero = strtolower(trim($genero));

$generoSeguro = htmlspecialchars($genero, ENT_QUOTES, 'UTF-8');
$disponibleSeguro = htmlspecialchars($disponible, ENT_QUOTES, 'UTF-8');

$fechaHoy = new DateTimeImmutable();

$fechaRevision = $fechaHoy->modify('+30 days');

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo</title>
</head>
<body>
    <h1>Catálogo</h1>

    <?php

    $catalogoFiltrado = filtrarPorGenero($catalogo, $generoSeguro);

    if ($disponibleSeguro) {
    $catalogoFiltrado = filtrarDisponibles($catalogoFiltrado);
    }
    
    foreach ($catalogoFiltrado as $libro) {
        $alta = new DateTimeImmutable($libro['fechaAlta']);
        $dias = $alta->diff($fechaHoy)->days;
        
        echo "ID: " . $libro['id'] . "<br>";
        echo "Título: " . $libro['titulo'] . "<br>";
        echo "Autor: " . $libro['autor'] . "<br>";
        echo "Genero: " . $libro['genero'] . "<br>";
        echo "Paginas: " . $libro['paginas'] . "<br>";
        echo "Disponible: " . ($libro['disponible'] ? "si" : "no") . "<br>";
        echo "FechaAlta: " . $alta->format(('d/m/Y')) . ". Hace " . $dias . " días<br><br>";
    }
    echo "<p>Total de resultados: " . count($catalogoFiltrado) . "</p>";

    $lirboConMasPaginas = obtenerLibroMasLargo($catalogoFiltrado);
    echo "<h2>Libro con más paginas</h2>";
    echo "<p>Titulo: " . $lirboConMasPaginas['titulo'] . "</p>"; 
    echo "<p>Páginas: " . $lirboConMasPaginas['paginas'] . "</p>";
    echo "<h3>Revision del catálogo: " . $fechaRevision->format('d/m/Y') . "</h3>";
    ?>

</body>
</html>