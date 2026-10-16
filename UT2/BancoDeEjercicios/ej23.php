<?php

declare(strict_types=1);

function ficha(string $titulo, string $autor): string {
    return "$titulo / $autor";
}

$libro = ficha(
    autor: 'Miguel de Cervantes',
    titulo: 'EL Quijote'
);

echo $libro;