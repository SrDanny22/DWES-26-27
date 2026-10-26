<?php

declare(strict_types=1);

class Revista extends RecursoBiblioteca {
    private int $numero;

    public function __construct(int $id, string $titulo, int $numero)
    {
        if ($numero <= 0) {
            throw new InvalidArgumentException('El número debe ser positivo.');
        }

        parent::__construct($id, $titulo);
        $this->numero = $numero;
    }

    public function tipo(): string {
        return 'revista';
    }

    public function ficha(): string {
        return 'Revista: ' . $this->titulo . ' - Número: ' . $this->numero;
    }
}
