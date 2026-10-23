<?php

declare(strict_types=1);

abstract class Alquiler {
    readonly private int $id;
    private string $cliente;
    private int $dias;
    private EstadoAlquiler $estado;

    public function __construct(int $id, string $cliente, int $dias, EstadoAlquiler $estado)
    {
        if (trim($cliente) === '') {
            throw new InvalidArgumentException('Nombre del cliente vacío.');
        }

        if ($id <= 0) {
            throw new InvalidArgumentException('El ID no puede ser 0 o menor que 0.');
        }

        if ($dias <= 0 || $dias > 7) {
            throw new InvalidArgumentException('Duración fuera de plazo.');
        }

        $this->id = $id;
        $this->cliente = trim($cliente);
        $this->dias = $dias;
        $this->estado = $estado;
    }

    public function id(): int {
        return $this->id;
    }

    public function cliente(): string {
        return $this->cliente;
    }

    public function dias(): int {
        return $this->dias;
    }

    public function estado(): EstadoAlquiler {
        return $this->estado;
    }

    public abstract function modalidad(): string;

    protected abstract function tarifaDiaria(): int;

    public function importe(): int {
            return $this->dias * $this->tarifaDiaria();
    }

    public function iniciar(): void {
        if ($this->estado === EstadoAlquiler:: Reservado) {
            $this->estado = EstadoAlquiler::Activo;
            }
        throw new AlquilerException('No se puede iniciar la operación porque ya esta iniciada.');
    }

    public function finalizar(): void {
        if ($this->estado === EstadoAlquiler:: Activo) {
            $this->estado = EstadoAlquiler::Finalizado;
            }
        throw new AlquilerException('No se puede finalizar la operacón porque no está iniciada.');
    }

}