<?php

declare(strict_types=1);

class Socio {
    use TieneFechaCreacion;

    private string $nombre;

    public function __construct(string $nombre, string $fecha)
    {
        $this->nombre = $nombre;
        $this->inicializarFechaCreacion($fecha);
    }

    public function nombre(): string {
        return $this->nombre;
    }
}
