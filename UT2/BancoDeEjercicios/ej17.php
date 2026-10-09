<?php

declare(strict_types=1);

$codigo = "LIB-2026-0042";

$tipo = substr($codigo, 0, 3);
$numero = substr($codigo, 9, 13);

echo $tipo . "<br>";
echo $numero . "<br>";

$personaje = "Drácula";

$palabras = mb_substr($personaje, 0, 3, 'UTF-8');

echo $palabras;

// Se prefiere usar mb_substr porque trabaja mejor con textos UTF-8.