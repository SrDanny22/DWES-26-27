<?php

declare(strict_types=1);

$libros = [
    "Cien años de soledad" => 5,
    "Don Quijote de la Mancha" => 3,
    "El principito" => 8,
    "1984" => 4
];

$clave = array_find_key(
    $libros,
    fn (int $n): bool =>
    $n === 3,
    // $n === 17;
);

print_r($clave);