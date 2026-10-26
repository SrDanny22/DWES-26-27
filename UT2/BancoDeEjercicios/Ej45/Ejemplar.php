<?php

declare(strict_types=1);

class Ejemplar {
    private string $codigo;
    private EstadoEjemplar $estado;

    public function __construct(string $codigo, EstadoEjemplar $estado = EstadoEjemplar::Disponible)
    {
        $this->codigo = $codigo;
        $this->estado = $estado;
    }

    public function codigo(): string {
        return $this->codigo;
    }

    public function estado(): EstadoEjemplar {
        return $this->estado;
    }

    public function cambiarEstado(EstadoEjemplar $estado): void {
        $this->estado = $estado;
    }
}
