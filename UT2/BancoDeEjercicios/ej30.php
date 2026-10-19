<?php

declare(strict_types=1);

// final class Libro
// {
//  public string $titulo;
//  public bool $disponible;
//  public function __construct(
//  string $titulo, bool $disponible = true
//  ) {
//  $this->titulo = $titulo;
//  $this->disponible = $disponible;
//  }
// }

final class Libro
{
    public function __construct(
        public string $titulo,
        public bool $disponible = true
    ) {}
}

$libro1 = new Libro('Dune');
$libro2 = new Libro('Dune', false);

print_r($libro1);

print_r($libro2);

// Al hacer new Libro() y no poner el titulo, daría error porque hemos puesto en el constructor titulo sin ningun valor por defecto, si tuviera un valor por defecto, si se podría poner sin argumentos.