<?php

declare(strict_types=1);

namespace Daniel\Biblioteca\Modelo;

use Override;

class LibroPapel extends Libro {
    #[Override]
    public function getTipo(): string
    {
        return 'papel';
    }

    #[Override]
    public function costeReposicionCentimos(): int
    {
        return $this->unidades() * $this->paginas() * 5;
    }
}