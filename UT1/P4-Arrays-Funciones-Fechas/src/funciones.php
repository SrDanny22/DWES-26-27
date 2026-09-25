<?php

declare(strict_types=1);

function buscarPorId(array $libros, int $id): ?array {
    foreach ($libros as $libro) {
        if ($libro['id'] === $id) {
            return $libro;
        }
    }
    return null;
}

function filtrarPorGenero(array $libros, string $genero): array {
    $libroGenero = [];

    foreach ($libros as $libro) {
        if ($libro['genero'] === $genero) {
            $libroGenero[] = $libro;
        }
    }
    return $libroGenero;
}

function filtrarDisponibles(array $libros): array {
    $disponibles = [];

    foreach ($libros as $libro) {
        if ($libro['disponible'] === true) {
            $disponibles[] = $libro;
        }
    }
    return $disponibles;
}

function calcularMediaPaginas(array $libros): float {
    $suma = 0;

    foreach ($libros as $libro) {
        $suma += $libro['paginas'];
    }

    return $suma / count($libros);
}

function obtenerLibroMasLargo(array $libros): ?array {
    sort($libros);

    return $libros[count($libros) -1];
}