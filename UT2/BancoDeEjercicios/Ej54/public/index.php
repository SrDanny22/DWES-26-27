<?php

declare(strict_types=1);

use App\Model\Libro;
use App\Model\Revista;
use App\Service\ListadoService;

require __DIR__ . '/../vendor/autoload.php';

$recursos = [
    new Libro('Dune'),
    new Revista('Ciencia'),
    new Revista('Historia'),
];

$servicio = new ListadoService();

foreach ($servicio->lineas($recursos) as $linea) {
    echo $linea . PHP_EOL;
}
