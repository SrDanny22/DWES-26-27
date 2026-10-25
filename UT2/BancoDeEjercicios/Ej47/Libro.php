<?php

declare(strict_types=1);

class Libro extends RecursoBiblioteca {
    private int $paginas;

    public function __construct(int $id, string $titulo, int $paginas)
    {
        if ($paginas <= 0) {
            throw new InvalidArgumentException('Las paginas deben ser positivas.');
        }

        parent::__construct($id, $titulo);
        $this->paginas = $paginas;
    }

    public function tipo(): string {
        return 'libro';
    }

    public function ficha(): string {
        // titulo es protected, así que la hija puede usarlo directamente
        return 'Libro: ' . $this->titulo . ' - Páginas: ' . $this->paginas;
    }
}
