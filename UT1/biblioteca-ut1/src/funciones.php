<?php

declare(strict_types=1);

function filtrarPorGenero(array $libros, string $genero): array {
    if ($genero === 'todos') {
        return $libros;
    }

    $generoLibros = [];

    foreach ($libros as $libro) {
        if ($libro['genero'] === $genero) {
            $generoLibros[] = $libro;
        }
    }

    return $generoLibros;
}

function buscarPorId(array $libros, int $id): ?array {
    foreach ($libros as $libro) {
        if ($libro['id'] === $id) {
            return $libro;
        }
    }
    return null;
}

function filtrarDisponible (array $libros): array {
    $librosDisponibles = [];

    foreach ($libros as $libro) {
        if ($libro['disponible'] === true) {
            $librosDisponibles[] = $libro;
        }
    }
    return $librosDisponibles;
}

function buscarPorTexto(array $libros, string $texto): array {
    if ($texto == 'todos') {
        return $libros;
    }

    $textoEncontrado = [];

    foreach ($libros as $libro) {
        if (strtolower($libro['titulo']) === $texto || strtolower($libro['autor']) === $texto) {
            $textoEncontrado[] = $libro;
        }
    }

    return $textoEncontrado;

}

function calcularMedia(array $libros): float {
    if (count($libros) === 0) {
        return 0.0;
    }

    $suma = 0;

    foreach ($libros as $libro) {
        $suma += $libro['paginas'];
    }

    return $suma/count($libros);
}

function obtenerLibroMasLargo(array $libros): ?array {
    $masLargo = null;

    foreach ($libros as $libro) {
        if ($masLargo === null || $masLargo['paginas'] < $libro['paginas']) {
            $masLargo = $libro;
        }
    }

    return $masLargo;
}

function ordenarPorTitulo(array $libros): array {
    $ordenados = $libros;

    $cantidad = count($ordenados);

    for ($i=0; $i < $cantidad; $i++) { 
        for ($j=0; $j < $cantidad - 1; $j++) { 
            $tituloActual = strtolower($ordenados[$j]['titulo']);
            $tituloSiguiente = strtolower($ordenados[$j + 1]['titulo']);

            if ($tituloActual > $tituloSiguiente) {
                $temporal = $ordenados[$j];
                $ordenados[$j] = $ordenados[$j + 1];
                $ordenados[$j + 1] = $temporal;
            }
        }
    }
    return $ordenados;
}

function ordenarPorPagina(array $libros): array {
    $ordenados = $libros;
    $cantidad = count($ordenados);

    for ($i=0; $i < $cantidad; $i++) { 
        for ($j=0; $j < $cantidad - 1; $j++) { 
            $paginaActual = $ordenados[$j]['paginas'];
            $paginaSiguiente = $ordenados[$j + 1]['paginas'];

            if ($paginaActual > $paginaSiguiente) {
                $temporal = $ordenados[$j];
                $ordenados[$j] = $ordenados[$j + 1];
                $ordenados[$j + 1] = $temporal;
            }
        }
    }
    return $ordenados;
}