<?php

declare(strict_types=1);

class Libro {
    use TieneFechaCreacion;

    private string $titulo;

    public function __construct(string $titulo, string $fecha)
    {
        $this->titulo = $titulo;
        $this->inicializarFechaCreacion($fecha);
    }

    public function titulo(): string {
        return $this->titulo;
    }
}
