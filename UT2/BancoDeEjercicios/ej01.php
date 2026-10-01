<?php

function doble(int $n): int {
    return $n * 2;
}

function cuadrado(int $n): int {
    return $n * $n;
}

function aplicar(int $n, callable $callback): int {
    return $callback($n);
}

$resultado = aplicar(3, 'doble'); // Aqui devolvería 6
$resultado = aplicar(3, 'cuadrado'); // Aqui devolvería 9