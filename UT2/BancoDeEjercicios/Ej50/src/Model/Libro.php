<?php

declare(strict_types=1);

namespace App\Model;

class Libro {
    private string $titulo;
    private Autor $autor;

    public function __construct(string $titulo, Autor $autor)
    {
        $this->titulo = $titulo;
        $this->autor = $autor;
    }

    public function ficha(): string {
        return $this->titulo . ' | ' . $this->autor->nombre();
    }
}
