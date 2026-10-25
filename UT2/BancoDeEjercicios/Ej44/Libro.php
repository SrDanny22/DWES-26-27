<?php

declare(strict_types=1);

class Libro {
    private string $titulo;

    public function __construct(string $titulo, public readonly Autor $autor, public readonly Categoria $categoria)
    {
        $this->titulo = $titulo;
    }

    public function ficha(): string {
        return 'Titulo: ' . $this->titulo . ' - Autor: ' . $this->autor->nombre . ' - Categoría: ' . $this->categoria->nombre();
    }
}
