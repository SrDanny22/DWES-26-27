<?php

declare(strict_types=1);

final class Libro
{
    public function __construct(
        public string $titulo,
        public bool $disponible = true,
    ) {}
    public function prestar(): void
    {
        if (!$this->disponible) {
            echo "Este libro no se puede prestar porque ya esta prestado!<br>";
        } else {
            $this->disponible = false;
            echo 'Libro prestado correctamente!<br>';
        }
    }
    public function devolver(): void
    {
        if ($this->disponible) {
            echo 'Este libro no se puede devolver porque no está prestado!<br>';
        } else {
            $this->disponible = true;
            echo 'Libro devuelto!<br>';
        }
    }
}

$libro1 = new Libro('Dune');
$libro2 = new Libro('Solaris');

$libro1->prestar();
$libro1->prestar();
$libro1->devolver();
$libro1->devolver();

echo $libro1->disponible . '<br>';
echo $libro2->disponible . "<br>";

// Cambiar un objeto no cambia al otro porque instanciamos dos objetos diferentes.