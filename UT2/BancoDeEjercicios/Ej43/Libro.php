<?php

declare(strict_types=1);

class Libro {
    private int $id;
    private string $titulo;
    private int $paginas;
    private bool $disponible;

    public function __construct(int $id, string $titulo, int $paginas)
    {
        if ($id < 0) {
            throw new InvalidArgumentException('Un id negativo no es válido.');
        }

        if (trim($titulo) === '') {
            throw new InvalidArgumentException('Titulo vacio.');
        }

        if ($paginas <= 0) {
            throw new InvalidArgumentException('Las paginas no pueden ser 0 o negativo.');
        }

        $this->id = $id;
        $this->titulo = trim($titulo);
        $this->paginas = $paginas;
        $this->disponible = true;
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
            throw new LogicException('Este libro ya está prestado.');
        }
        $this->disponible = false;
    }

    public function devolver(): void {
        $this->disponible = true;
    }

    public function ficha(): void {
        echo 'ID: ' . $this->id . " - Titulo: " . $this->titulo . " - Páginas: " . $this->paginas . " - Estado: " . ($this->disponible ? 'Disponible' : 'No disponible');
    }
}