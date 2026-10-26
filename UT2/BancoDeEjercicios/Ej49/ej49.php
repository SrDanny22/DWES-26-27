<?php

declare(strict_types=1);

require_once __DIR__ . '/LibroNoDisponibleException.php';
require_once __DIR__ . '/Libro.php';

$libro = new Libro('Dune');

try {
    $libro->prestar();
    echo 'Préstamo de ' . $libro->titulo() . ' realizado<br>';
} catch (LibroNoDisponibleException $e) {
    echo $e->getMessage() . '<br>';
}

try {
    $libro->prestar();
    echo 'Préstamo de ' . $libro->titulo() . ' realizado<br>';
} catch (LibroNoDisponibleException $e) {
    echo $e->getMessage() . '<br>';
}

var_dump($libro->estaDisponible());
echo '<br>';

$libro->devolver();

try {
    $libro->prestar();
    echo 'Préstamo de ' . $libro->titulo() . ' realizado de nuevo correctamente<br>';
} catch (LibroNoDisponibleException $e) {
    echo $e->getMessage() . '<br>';
}

try {
    $vacio = new Libro('   ');
} catch (InvalidArgumentException $e) {
    echo 'Rechazado: ' . $e->getMessage() . '<br>';
}
