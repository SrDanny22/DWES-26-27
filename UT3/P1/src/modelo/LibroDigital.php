<?php

declare(strict_types=1);

namespace Daniel\Biblioteca\Modelo;

use Override;

class LibroDigital extends Libro {
    #[Override]
    public function getTipo(): string
    {
        return 'digital';
    }

    #[Override]
    public function costeReposicionCentimos(): int
    {
        return $this->unidades() * 400;
    }
}