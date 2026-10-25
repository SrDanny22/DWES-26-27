<?php

declare(strict_types=1);

namespace App\Repositorio;

use App\Contrato\RepositorioEnvios;
use App\Excepcion\EnvioException;
use App\Modelo\Envio;
use InvalidArgumentException;

final class RepositorioEnviosMemoria implements RepositorioEnvios
{
    private array $envios = [];

    public function registrar(Envio $envio): void
    {
        if ($this->buscar($envio->id()) !== null) {
            throw new EnvioException('Ya existe un envío con el id ' . $envio->id());
        }

        $this->envios[$envio->id()] = $envio;
    }

    public function todos(): array
    {
        return array_values($this->envios);
    }

    public function buscar(int $id): ?Envio
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('El id buscado debe ser positivo');
        }

        return $this->envios[$id] ?? null;
    }
}
