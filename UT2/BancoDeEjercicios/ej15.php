<?php

declare(strict_types=1);

$libros = [
10 => ['titulo' => 'Dune', 'paginas' => 412],
20 => ['titulo' => 'It', 'paginas' => 1504],
30 => ['titulo' => '1984', 'paginas' => 328],
];

uasort(
    $libros,
    fn (array $a, array $b): int =>
        $a['titulo'] <=> $b['titulo']
);

print_r($libros);

// La diferencia entre usort y uasort es que sort compara dos registros y decide su orden y uasort ordena sus dos registros pero conservan sus claves originales
