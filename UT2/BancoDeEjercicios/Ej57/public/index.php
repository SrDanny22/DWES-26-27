<?php

declare(strict_types=1);

use App\Exception\LibroNoDisponibleException;
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

echo 'Disponibles:' . PHP_EOL;
foreach ($servicio->titulosDisponibles() as $titulo) {
    echo $titulo . PHP_EOL;
}

$servicio->prestarPorId(10);

echo PHP_EOL . 'Disponibles tras prestar el id 10:' . PHP_EOL;
foreach ($servicio->titulosDisponibles() as $titulo) {
    echo $titulo . PHP_EOL;
}

// El repositorio devolvió el mismo objeto, así que el Dune de la colección inicial también cambia
echo PHP_EOL . 'Dune disponible en la colección inicial: ';
var_dump($libros[0]->estaDisponible());

echo PHP_EOL;

try {
    $servicio->prestarPorId(10);
} catch (LibroNoDisponibleException $e) {
    echo $e->getMessage() . PHP_EOL;
}

try {
    $servicio->prestarPorId(99);
} catch (InvalidArgumentException $e) {
    echo $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . 'Disponibles tras los rechazos:' . PHP_EOL;
foreach ($servicio->titulosDisponibles() as $titulo) {
    echo $titulo . PHP_EOL;
}
