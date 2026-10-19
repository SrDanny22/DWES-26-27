<?php

declare(strict_types=1);

class Datos {
    public string $titulo;
    public string $autor;
    public int $paginas;
    public bool $disponible;

    public function __construct(string $titulo, string $autor, int $paginas, bool $disponible)
    {
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->paginas = $paginas;
        $this->disponible = $disponible;
    }

}

$libro = new datos('Dune', 'Frank Herbert', 412, true);

print_r($libro);