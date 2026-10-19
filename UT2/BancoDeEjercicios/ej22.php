<?php

declare(strict_types=1);

function sumarPaginas (int ...$paginas): int {
    return array_sum($paginas);
}

$numeros = [22, 23, 20, 50];

echo sumarPaginas(...$numeros);