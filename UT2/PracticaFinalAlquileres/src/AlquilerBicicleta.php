<?php

declare(strict_types=1);

class AlquilerBicicleta extends Alquiler {
    #[Override]
    public function modalidad(): string
    {
        return 'bicicleta';
    }

    #[Override]
    protected function tarifaDiaria(): int
    {
        return 500;
    }
}