<?php

declare(strict_types=1);

final class Libro
{
    public function __construct(public string $titulo) {}
}

$original = new Libro('Dune');

$alias = $original;

$otro = new Libro('Dune');

$alias->titulo = 'Solaris';

echo $original->titulo . PHP_EOL;

echo $otro->titulo . PHP_EOL;

var_dump($original === $alias);

var_dump($original === $otro);

// var_dump($original === $alias) aqui dará true y en var_dump($original === $otro) dará false, porque al hacer $alias = $original, los dos estan apuntando al mismo sitio, practicamente serían el mismo objeto, si cambias uno, se cambia el otro, en cambio al hacer $otro = new Libro('Dune'), estamos haciendo otro objeto totalmente nuevo, por eso al comparar el $original y $otro, sale false porque anteriormente habiamos cambiado $alias que apunta a $original y por eso $original seria Solarias y $otro sería Dune, por eso la comrpobación sale false