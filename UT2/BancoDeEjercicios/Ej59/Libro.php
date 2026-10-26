<?php

declare(strict_types=1);

class Libro {
    private string $titulo;
    private bool $disponible;

    public function __construct(string $titulo, bool $disponible = true)
    {
        $this->titulo = $titulo;
        $this->disponible = $disponible;
    }

    public function titulo(): string {
        return $this->titulo;
    }

    public function estaDisponible(): bool {
        return $this->disponible;
    }

    public function prestar(): void {
        if (!$this->disponible) {
            throw new LibroNoDisponibleException('el libro ' . $this->titulo . ' ya está prestado');
        }
        $this->disponible = false;
    }
}
