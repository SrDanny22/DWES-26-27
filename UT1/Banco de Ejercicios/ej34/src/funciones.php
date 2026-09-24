<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/datos.php';

function filtrarPorGenero(array $libros, string $genero): array {
    if ($genero === 'todos') {
        return $libros;
    }

    $resultado = [];

    foreach ($libros as $libro) {
        if ($libro['genero'] === $genero) {
            $resultado = [$libro];
        }
    }
    return $resultado;
}
