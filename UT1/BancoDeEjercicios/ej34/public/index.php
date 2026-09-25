<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/funciones.php';
require_once __DIR__ . '/../src/datos.php';

$genero = $_GET['genero'] ?? 'todos';
$genero = strtolower(trim($genero));

$librosFiltrados = ordenarArray(filtrarPorGenero($catalogo, $genero));

echo "<h1>Titulos</h1>";
foreach ($librosFiltrados as $libro) {
    echo "<h2>" . htmlspecialchars($libro['titulo']) . "</h2>";
    echo "<p>" . htmlspecialchars($libro['genero']) . "</p>";
}
echo "<br><p>Total de resultados: " . count($librosFiltrados) . "</p>";
fechaRevisionCatalogo();
