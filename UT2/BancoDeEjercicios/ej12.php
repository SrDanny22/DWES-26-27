<?php

declare(strict_types=1);

$libros = [
    ['id' => 1, 'titulo' => 'Dune'],
    ['id' => 2, 'titulo' => 'Solaris'],
    ['id' => 3, 'titulo' => 'Fundación'],
    ['id' => 4, 'titulo' => 'Neuromante'],
    ['id' => 5, 'titulo' => 'Cita con Rama'],
    ['id' => 6, 'titulo' => 'Fahrenheit 451'],
    ['id' => 7, 'titulo' => 'Un mundo feliz'],
    ['id' => 8, 'titulo' => '1984'],
    ['id' => 9, 'titulo' => 'El problema de los tres cuerpos'],
    ['id' => 10, 'titulo' => 'Hyperion']
];


$arrayTitulos = array_column($libros, 'titulo');

print_r($arrayTitulos);

echo "<br>";

$arrayIndexado = array_column($libros, null, "id");

print_r($arrayIndexado);