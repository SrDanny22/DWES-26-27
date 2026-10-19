<?php

declare(strict_types=1);

function normalizar(int|string $id): int {
    return (int) $id;
}

function etiqueta(?string $titulo): string {
    return $titulo ?? 'Sin título';
}

echo normalizar('12');
echo "<br>";
echo normalizar(22);
echo "<br>";
echo etiqueta("Dune");
echo "<br>";
echo etiqueta(null);