<?php

declare(strict_types=1);

namespace App\Modelo;

use App\Excepcion\EnvioException;
use InvalidArgumentException;

abstract class Envio
{
    private readonly int $id;
    private string $cliente;
    private int $peso;
    private EstadoEnvio $estado;

    public function __construct(int $id, string $cliente, int $peso, EstadoEnvio $estado)
    {
        $cliente = trim($cliente);

        if ($id <= 0) {
            throw new InvalidArgumentException('El id del envío debe ser positivo');
        }

        if ($cliente === '') {
            throw new InvalidArgumentException('El cliente no puede estar vacío');
        }

        if ($peso < 1 || $peso > 20000) {
            throw new InvalidArgumentException('El peso debe estar entre 1 y 20000 g');
        }

        $this->id = $id;
        $this->cliente = $cliente;
        $this->peso = $peso;
        $this->estado = $estado;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function cliente(): string
    {
        return $this->cliente;
    }

    public function peso(): int
    {
        return $this->peso;
    }

    public function estado(): EstadoEnvio
    {
        return $this->estado;
    }

    abstract public function modalidad(): string;

    abstract protected function cuotaFija(): int;

    abstract protected function precioBloque(): int;

    public function tarifa(): int
    {
        $bloques = (int) (($this->peso + 999) / 1000);

        return $this->cuotaFija() + $bloques * $this->precioBloque();
    }

    public function enviar(): void
    {
        $this->cambiarEstado(EstadoEnvio::Pendiente, EstadoEnvio::Enviado);
    }

    public function entregar(): void
    {
        $this->cambiarEstado(EstadoEnvio::Enviado, EstadoEnvio::Entregado);
    }

    public function cancelar(): void
    {
        $this->cambiarEstado(EstadoEnvio::Pendiente, EstadoEnvio::Cancelado);
    }

    private function cambiarEstado(EstadoEnvio $origen, EstadoEnvio $destino): void
    {
        if ($this->estado !== $origen) {
            throw new EnvioException(
                'El envío ' . $this->id . ' está ' . $this->estado->value
                . ' y no puede pasar a ' . $destino->value
            );
        }

        $this->estado = $destino;
    }
}
