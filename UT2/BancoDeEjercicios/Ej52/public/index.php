<?php

declare(strict_types=1);

use App\Model\Personas\Autor;
use App\Model\Libro;
use App\Service\CatalogoService;

require __DIR__ . '/../vendor/autoload.php';

$libros = [
    new Libro('Dune', new Autor('Frank Herbert')),
    new Libro('Solaris', new Autor('Stanislaw Lem')),
];

$servicio = new CatalogoService($libros);

foreach ($servicio->fichas() as $ficha) {
    echo $ficha . PHP_EOL;
}

// Con un array vacío no se muestra ninguna ficha
$servicioVacio = new CatalogoService([]);

foreach ($servicioVacio->fichas() as $ficha) {
    echo $ficha . PHP_EOL;
}
