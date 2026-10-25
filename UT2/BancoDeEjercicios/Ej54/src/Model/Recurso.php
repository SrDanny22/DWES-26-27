<?php

declare(strict_types=1);

namespace App\Model;

abstract class Recurso {
    protected string $titulo;

    public function __construct(string $titulo)
    {
        $this->titulo = $titulo;
    }

    public function titulo(): string {
        return $this->titulo;
    }

    abstract public function tipo(): string;
}
