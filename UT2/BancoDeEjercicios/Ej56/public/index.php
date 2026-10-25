<?php

declare(strict_types=1);

use App\Model\Libro;
use App\Repository\ArrayLibroRepository;
use App\Service\CatalogoService;

require __DIR__ . '/../vendor/autoload.php';

$libros = [
    new Libro(10, 'Dune', true),
    new Libro(20, 'Solaris', false),
    new Libro(30, 'Drácula', true),
];

$servicio = new CatalogoService(new ArrayLibroRepository($libros));

foreach ($servicio->titulosDisponibles() as $titulo) {
    echo $titulo . PHP_EOL;
}

echo PHP_EOL;

$servicioVacio = new CatalogoService(new ArrayLibroRepository([]));
$titulos = $servicioVacio->titulosDisponibles();

if (count($titulos) === 0) {
    echo 'Sin libros disponibles' . PHP_EOL;
}

foreach ($titulos as $titulo) {
    echo $titulo . PHP_EOL;
}
