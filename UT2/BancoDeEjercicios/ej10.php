<?php

declare(strict_types=1);

$paginas = [412, 328, 1504, 115, 22, 999];

$libro1000Paginas = array_any(
    $paginas,
    fn (int $n): bool =>
        $n > 1000
);

echo $libro1000Paginas;

$libroConPaginas = array_all(
    $paginas,
    fn (int $n): bool =>
        $n > 0
);

echo "<br>" . $libroConPaginas;