<?php

declare(strict_types=1);

use App\Model\Autor;
use App\Model\Libro;
use App\Model\Categoria;
use App\Importacion\Libro as LibroImportado;

// Una sola carga: el autoload de Composer encuentra las clases por PSR-4
require __DIR__ . '/../vendor/autoload.php';

$autor = new Autor('Frank Herbert');
$libro = new Libro('Dune', $autor);

echo $libro->ficha() . PHP_EOL;

$importado = new LibroImportado('El Hobbit');

echo $importado->titulo() . PHP_EOL;

$categoria = new Categoria('Ciencia ficción');

echo $categoria->nombre() . PHP_EOL;
