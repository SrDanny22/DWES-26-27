<?php

declare(strict_types=1);

class Libro {
    private int $id;
    private string $titulo;

    public function __construct(int $id, string $titulo)
    {
        $this->id = $id;
        $this->titulo = $titulo;
    }

    public function id(): int {
        return $this->id;
    }

    public function titulo(): string {
        return $this->titulo;
    }
}
