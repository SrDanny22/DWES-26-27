<?php

declare(strict_types=1);

// Terminado
function normalizarTexto(string $texto): string
{
    return trim(strtolower($texto)); // Mira ver socio
}

// Terminado
function buscarPorId(array $videojuegos, int $id): ?array
{
    // No sé bien qué pasa?¿
    foreach ($videojuegos as $videojuego) {
        if ($videojuego['id'] === $id) {
            return $videojuego;
        }
    }
        return null;
}

// Terminado
function filtrarPorGenero(array $videojuegos, string $genero): array
{
    // Foreach y qué más¿?
    if ($genero === 'todos') {
        return $videojuegos;
    }

    $resultado = [];
    foreach ($videojuegos as $videojuego) {
        // Cuidado con mayúsculas y mínusculas
        if ($videojuego['genero'] === $genero) {
            $resultado[] = $videojuego;
        }
    }

    return $resultado;
}

// Terminado
function filtrarPorPlataforma(array $videojuegos, string $plataforma): array
{
    if ($plataforma === 'todas') {
        return $videojuegos;
    }

    $resultado = [];
    foreach ($videojuegos as $videojuego) {
        // Cuidado con mayúsculas y mínusculas
        if ($videojuego['plataforma'] === $plataforma) {
            $resultado[] = $videojuego;
        }
    }

    return $resultado;
}

// Terminado
function buscarPorTexto(array $videojuegos, string $texto): array
{
    $resultado = [];
    $texto = normalizarTexto($texto);

    if ($texto === '') {
        return $videojuegos;
    }

    foreach ($videojuegos as $videojuego) {
        $titulo = normalizarTexto($videojuego['titulo']);
        $estudio = normalizarTexto($videojuego['estudio']);

        // Esta función está implementada, pero su lógica no produce todos los resultados esperados.
        if (str_contains($titulo, $texto) || str_contains($estudio, $texto)) {
            $resultado[] = $videojuego;
        }
    }

    return $resultado;
}

// Terminado
function ordenarVideojuegos(array $videojuegos, string $criterio): array
{
    $criterio = normalizarTexto($criterio);
    // $ordenados te lo complica, mejor todo con $videojuego
    $ordenados = $videojuegos;
    $cantidad = count($videojuegos);

    for ($i = 0; $i < $cantidad; $i++) {
        for ($j = 0; $j < $cantidad - 1; $j++) {
            $actual = $videojuegos[$j][$criterio];
            $siguiente = $videojuegos[$j + 1][$criterio];


            if ($actual > $siguiente) {
                $temporal = $ordenados[$j];
                $ordenados[$j] = $ordenados[$j + 1];
                $ordenados[$j + 1] = $temporal;
            }
        }
    }

    return $ordenados;
}
