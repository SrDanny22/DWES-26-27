<?php

declare(strict_types=1);

class Libro {
    private string $titulo;
    private bool $disponible = true;

    public function __construct(string $titulo)
    {
        if (trim($titulo) === '') {
            throw new InvalidArgumentException('Titulo vacio.');
        }

        $this->titulo = trim($titulo);
    }

    public function titulo(): string {
        return $this->titulo;
    }

    public function estaDisponible(): bool {
        return $this->disponible;
    }

    public function prestar(): void {
        if (!$this->disponible) {
            throw new LibroNoDisponibleException('El libro ' . $this->titulo . ' ya está prestado.');
        }
        $this->disponible = false;
    }

    public function devolver(): void {
        $this->disponible = true;
    }
}
