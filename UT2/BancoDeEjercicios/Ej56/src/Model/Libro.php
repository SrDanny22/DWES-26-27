<?php

declare(strict_types=1);

namespace App\Model;

class Libro {
    private int $id;
    private string $titulo;
    private bool $disponible;

    public function __construct(int $id, string $titulo, bool $disponible)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->disponible = $disponible;
    }

    public function id(): int {
        return $this->id;
    }

    public function titulo(): string {
        return $this->titulo;
    }

    public function estaDisponible(): bool {
        return $this->disponible;
    }
}
