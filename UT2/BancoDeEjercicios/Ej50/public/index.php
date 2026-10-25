<?php

declare(strict_types=1);

use App\Model\Autor;
use App\Model\Libro;
use App\Importacion\Libro as LibroImportado;

require_once __DIR__ . '/../src/Model/Autor.php';
require_once __DIR__ . '/../src/Model/Libro.php';
require_once __DIR__ . '/../src/Importacion/Libro.php';

$autor = new Autor('Frank Herbert');
$libro = new Libro('Dune', $autor);

echo $libro->ficha() . PHP_EOL;

// Las dos clases Libro conviven porque están en namespaces distintos y usamos un alias
$importado = new LibroImportado('El Hobbit');

echo $importado->titulo() . PHP_EOL;
