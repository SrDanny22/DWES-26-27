<?php

declare(strict_types=1);

class AlquilerPatiente extends Alquiler {
    #[Override]
    public function modalidad(): string
    {
        return 'patinete';
    }

    #[Override]
    protected function tarifaDiaria(): int
    {
        return 1000;
    }
}