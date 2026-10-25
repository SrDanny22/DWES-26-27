<?php

declare(strict_types=1);

class Categoria {
    private string $nombre;

    public function __construct(string $nombre)
    {
        if (trim($nombre) === '') {
            throw new InvalidArgumentException('El nombre de la categoría no puede estar vacío.');
        }

        $this->nombre = trim($nombre);
    }

    public function nombre(): string {
        return $this->nombre;
    }

    public function renombrar(string $nombre): void {
        if (trim($nombre) === '') {
            throw new InvalidArgumentException('El nombre de la categoría no puede estar vacío.');
        }

        $this->nombre = trim($nombre);
    }
}
