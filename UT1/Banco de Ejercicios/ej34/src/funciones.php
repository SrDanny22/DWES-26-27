<?php

declare(strict_types=1);

function filtrarPorGenero(array $libros, string $genero): array {
    
    if ($genero === 'todos') {
        return $libros;
    }

    $resultado = [];

    foreach ($libros as $libro) {
        if (strtolower($libro['genero']) === $genero) {
            $resultado[] = $libro;
        }
    }
    return $resultado;
}

function fechaRevisionCatalogo():void {
    $fechaRevision = new DateTimeImmutable();

    $fechaRevisionDias = $fechaRevision->modify('+30 days');
    
    echo "<p>Fecha de revisión: " . $fechaRevisionDias->format('d/m/Y') . "</p>";
}