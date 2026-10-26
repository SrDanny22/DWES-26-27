<?php

declare(strict_types=1);

class Libro {
    private string $titulo;
    private int $paginas;
    private bool $disponible;

    public function __construct(string $titulo, int $paginas, bool $disponible)
    {
        $this->titulo = $titulo;
        $this->paginas = $paginas;
        $this->disponible = $disponible;
    }

    public function titulo(): string {
        return $this->titulo;
    }

    public function paginas(): int {
        return $this->paginas;
    }

    public function estaDisponible(): bool {
        return $this->disponible;
    }
}
