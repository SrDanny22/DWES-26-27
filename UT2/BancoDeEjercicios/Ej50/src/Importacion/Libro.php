<?php

declare(strict_types=1);

namespace App\Importacion;

class Libro {
    private string $titulo;

    public function __construct(string $titulo)
    {
        $this->titulo = $titulo;
    }

    public function titulo(): string {
        return $this->titulo;
    }
}
