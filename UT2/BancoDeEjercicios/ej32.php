<?php

declare(strict_types=1);

class Libro {

public function __construct(
    public string $titulo, public int $paginas
)
{}

function ficha(): string {
    return $this->titulo . " - " . $this->paginas . " páginas.";
}

function mostrarFicha(): void {
    echo $this->titulo . " - " . $this->paginas . " páginas.";
}

}

$libro = new Libro('Dune', 412);

$ficha = $libro->ficha();

echo $ficha . "<br>";

$libro->mostrarFicha();

// El return permite reutilizar el texto porque lo esta devolviendo y al usarlo en una varibale, estaríamos guardando ese texto el la variable y poder inprimirla con echo.