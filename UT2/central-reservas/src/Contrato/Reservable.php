<?php
declare(strict_types=1);

// M1. Contrato de las operaciones de reserva.
interface Reservable
{
    public function reservar(int $cantidad): void;

    public function cancelar(int $cantidad): void;

    public function plazasLibres(): int;
}
