<?php

declare(strict_types=1);

$texto = "Desarrollo Web con PHP";

$contienePHP = str_contains($texto, 'PHP');

$posicion = strpos($texto, 'PHP');

var_dump($contienePHP);
echo "<br>";
var_dump($posicion);