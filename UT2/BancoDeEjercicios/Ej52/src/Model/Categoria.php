<?php

declare(strict_types=1);

namespace App\Model;

class Categoria {
    private string $nombre;

    public function __construct(string $nombre)
    {
        $this->nombre = $nombre;
    }

    public function nombre(): string {
        return $this->nombre;
    }
}
