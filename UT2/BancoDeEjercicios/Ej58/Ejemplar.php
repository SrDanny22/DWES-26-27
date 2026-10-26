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

    public function prestar(): void {
        if ($this->estado !== EstadoEjemplar::Disponible) {
            throw new LogicException('No se puede prestar ' . $this->codigo . ': está ' . $this->estado->value . '.');
        }
        $this->estado = EstadoEjemplar::Prestado;
    }

    public function devolver(): void {
        if ($this->estado !== EstadoEjemplar::Prestado) {
            throw new LogicException('No se puede devolver ' . $this->codigo . ': está ' . $this->estado->value . '.');
        }
        $this->estado = EstadoEjemplar::Disponible;
    }

    public function marcarPerdido(): void {
        if ($this->estado === EstadoEjemplar::Perdido) {
            throw new LogicException('No se puede marcar como perdido ' . $this->codigo . ': ya está perdido.');
        }
        $this->estado = EstadoEjemplar::Perdido;
    }
}
