<?php

declare(strict_types=1);

use App\Exception\LibroNoDisponibleException;
use App\Model\Libro;
use App\Repository\ArrayLibroRepository;
use App\Service\CatalogoService;

require __DIR__ . '/../vendor/autoload.php';

function mostrarLibros(array $libros): void {
    if (count($libros) === 0) {
        echo 'Sin resultados' . PHP_EOL;
    }

    foreach ($libros as $libro) {
        echo $libro->titulo() . ' - ' . $libro->paginas() . ' páginas' . PHP_EOL;
    }

    echo PHP_EOL;
}

$libros = [
    new Libro(10, 'Dune', 412, true),
    new Libro(20, 'Solaris', 216, false),
    new Libro(30, 'Drácula', 418, true),
    new Libro(40, 'El Hobbit', 310, true),
];

$servicio = new CatalogoService(new ArrayLibroRepository($libros));

echo 'Búsqueda vacía, máximo 500:' . PHP_EOL;
mostrarLibros($servicio->buscarDisponibles('', 500));

echo 'Búsqueda " DRÁ ", máximo 500:' . PHP_EOL;
mostrarLibros($servicio->buscarDisponibles(' DRÁ ', 500));

echo 'Búsqueda "xyz", máximo 500:' . PHP_EOL;
mostrarLibros($servicio->buscarDisponibles('xyz', 500));

$servicio->prestarPorId(10);
echo 'Préstamo del id 10 realizado' . PHP_EOL;

try {
    $servicio->prestarPorId(10);
} catch (LibroNoDisponibleException $e) {
    echo $e->getMessage() . PHP_EOL;
}

echo PHP_EOL . 'Disponibles tras el préstamo:' . PHP_EOL;
mostrarLibros($servicio->buscarDisponibles('', 500));

$servicio->devolverPorId(10);
echo 'Devolución del id 10 realizada' . PHP_EOL;

echo PHP_EOL . 'Disponibles tras la devolución:' . PHP_EOL;
mostrarLibros($servicio->buscarDisponibles('', 500));

try {
    $servicio->prestarPorId(99);
} catch (InvalidArgumentException $e) {
    echo $e->getMessage() . PHP_EOL;
}

try {
    $servicio->buscarDisponibles('', 0);
} catch (InvalidArgumentException $e) {
    echo $e->getMessage() . PHP_EOL;
}
