<?php

declare(strict_types=1);

$factor = 2;

$resultado = fn(int $n): int => $n * $factor;

echo $resultado(2);