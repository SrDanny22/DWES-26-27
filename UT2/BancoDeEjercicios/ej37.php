<?php

declare(strict_types=1);

final class Libro
{
 public function __construct(
 public string $titulo,
 public int $paginas,
 ) {
    if (trim($titulo) === '' || $paginas <= 0) {
        throw new InvalidArgumentException('Titulo o Pagians inválidos');
    }

    $this->titulo = trim($titulo);
    $this->paginas = $paginas;
 }
}

// new Libro('Dune', 412);

// new Libro('Solaris', 0);

new Libro('Solaris', -5);

// Al poner new no entrega ningun objeto

// No, no lo impide, al haber definido la propiedad $paginas con el modificador public