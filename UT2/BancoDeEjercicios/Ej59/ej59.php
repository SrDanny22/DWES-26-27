<?php

declare(strict_types=1);

require_once __DIR__ . '/OperacionBibliotecaException.php';
require_once __DIR__ . '/LibroNoDisponibleException.php';
require_once __DIR__ . '/Libro.php';

$libros = [
    10 => new Libro('Dune'),
    20 => new Libro('Solaris', false),
];

// No captura nada: las excepciones llegan al código de ejecución
function prestarPorId(array $libros, int $id): void {
    if ($id <= 0) {
        throw new InvalidArgumentException('el id debe ser positivo');
    }

    $libro = $libros[$id] ?? null;

    if ($libro === null) {
        throw new OperacionBibliotecaException('no existe ningún libro con ese id');
    }

    $libro->prestar();
}

$ids = [10, 10, 20, 99, 0];

foreach ($ids as $id) {
    try {
        prestarPorId($libros, $id);
        echo 'Préstamo realizado (id ' . $id . ')<br>';
    } catch (LibroNoDisponibleException $e) {
        // Va primero porque es hija de OperacionBibliotecaException
        echo 'Id ' . $id . ' no disponible: ' . $e->getMessage() . '<br>';
    } catch (OperacionBibliotecaException $e) {
        echo 'Id ' . $id . ' rechazado: ' . $e->getMessage() . '<br>';
    } catch (InvalidArgumentException $e) {
        echo 'Id ' . $id . ' no válido: ' . $e->getMessage() . '<br>';
    } finally {
        echo 'Fin de operación ' . $id . '<br><br>';
    }
}

foreach ($libros as $libro) {
    echo $libro->titulo() . ' - Disponible: ' . ($libro->estaDisponible() ? 'sí' : 'no') . '<br>';
}
