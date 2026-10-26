<?php

declare(strict_types=1);

require_once __DIR__ . '/Libro.php';
require_once __DIR__ . '/CatalogoService.php';

$datos = [
    ['titulo' => 'Dune', 'paginas' => 412, 'disponible' => true],
    ['titulo' => 'Solaris', 'paginas' => 216, 'disponible' => false],
    ['titulo' => 'Drácula', 'paginas' => 418, 'disponible' => true],
    ['titulo' => 'El Hobbit', 'paginas' => 310, 'disponible' => true],
];

// Versión 1: función que trabaja con los registros
function titulosDisponiblesHasta(array $datos, int $maximo): array {
    if ($maximo < 1) {
        throw new InvalidArgumentException('El máximo debe ser al menos 1.');
    }

    $seleccion = array_filter(
        $datos,
        fn (array $d): bool => $d['disponible'] && $d['paginas'] <= $maximo
    );

    return array_values(array_map(
        fn (array $d): string => $d['titulo'],
        $seleccion
    ));
}

// Versión 2: objetos y servicio
$libros = array_map(
    fn (array $d): Libro => new Libro($d['titulo'], $d['paginas'], $d['disponible']),
    $datos
);

$servicio = new CatalogoService($libros);

function mostrarTitulos(array $titulos): void {
    if (count($titulos) === 0) {
        echo 'Lista vacía<br>';
        return;
    }

    foreach ($titulos as $titulo) {
        echo $titulo . ' | ';
    }
    echo '<br>';
}

foreach ([400, 500, 100, 0] as $maximo) {
    echo '<br>Máximo ' . $maximo . '<br>';

    try {
        echo 'Función: ';
        mostrarTitulos(titulosDisponiblesHasta($datos, $maximo));
    } catch (InvalidArgumentException $e) {
        echo $e->getMessage() . '<br>';
    }

    try {
        echo 'Servicio: ';
        mostrarTitulos($servicio->titulosDisponiblesHasta($maximo));
    } catch (InvalidArgumentException $e) {
        echo $e->getMessage() . '<br>';
    }
}
