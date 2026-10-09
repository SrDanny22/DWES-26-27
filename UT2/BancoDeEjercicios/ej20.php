<?php

declare(strict_types=1);

$texto = 'Dune      ciencia      ficcion';

$limpio = preg_replace(
'/\s+/',
' ',
$texto,
);

var_dump($limpio);