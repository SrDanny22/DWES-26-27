<?php

declare(strict_types=1);

abstract class RecursoBiblioteca {
    private int $id;
    protected string $titulo;

    public function __construct(int $id, string $titulo)
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('El id debe ser positivo.');
        }

        if (trim($titulo) === '') {
            throw new InvalidArgumentException('Titulo vacio.');
        }

        $this->id = $id;
        $this->titulo = trim($titulo);
    }

    public function id(): int {
        return $this->id;
    }

    public function titulo(): string {
        return $this->titulo;
    }

    abstract public function tipo(): string;

    final public function origen(): string {
        return 'Biblioteca';
    }
}
