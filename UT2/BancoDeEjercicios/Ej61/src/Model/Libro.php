<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\LibroNoDisponibleException;

class Libro {
    private int $id;
    private string $titulo;
    private int $paginas;
    private bool $disponible;

    public function __construct(int $id, string $titulo, int $paginas, bool $disponible)
    {
        if ($id <= 0) {
            throw new \InvalidArgumentException('El id debe ser positivo.');
        }

        if (trim($titulo) === '') {
            throw new \InvalidArgumentException('Titulo vacio.');
        }

        if ($paginas <= 0) {
            throw new \InvalidArgumentException('Las paginas deben ser positivas.');
        }

        $this->id = $id;
        $this->titulo = trim($titulo);
        $this->paginas = $paginas;
        $this->disponible = $disponible;
    }

    public function id(): int {
        return $this->id;
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

    public function prestar(): void {
        if (!$this->disponible) {
            throw new LibroNoDisponibleException('El libro ' . $this->titulo . ' no está disponible.');
        }
        $this->disponible = false;
    }

    public function devolver(): void {
        $this->disponible = true;
    }
}
