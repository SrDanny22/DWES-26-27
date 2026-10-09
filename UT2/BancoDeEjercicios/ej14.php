<?php

declare(strict_types=1);

$libros = [
10 => ['titulo' => 'Dune', 'paginas' => 412],
20 => ['titulo' => 'It', 'paginas' => 1504],
30 => ['titulo' => '1984', 'paginas' => 328],
];

usort(
    $libros,
    fn (array $a, array $b):int =>
        $a['paginas'] <=> $b['paginas']
    );

foreach ($libros as $libro) {
    echo $libro['paginas'] . "<br>";
}

echo "<br>";

usort(
    $libros,
    fn (array $a, array $b):int =>
        $b['paginas'] <=> $a['paginas']
    );

foreach ($libros as $libro) {
    echo $libro['paginas'] . "<br>";
}