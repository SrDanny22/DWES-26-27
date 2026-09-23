<?php

$generos = ["narrativo", "lírico", "dramático", "épico", "didáctico"];

$generos[] = "oratoria";

$generos[2] = "lírico-narrativo";

unset($generos[0]);

foreach ($generos as $genero) {
    echo $genero . "<br>";
}