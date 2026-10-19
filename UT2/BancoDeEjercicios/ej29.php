<?php

declare(strict_types=1);

final class Libro
{
 public string $titulo;
 public int $paginas = 0; // La propiedad $paginas esta inicializada a 0.
 public bool $disponible = true; // La propiedad $disponible esta inicializada a true.
}
$libro = new Libro();

// Si leyera titulo inmediatamente despues de crear el objeto, daria error porque no esta inicializada y no tendría ningún valor.
$libro->titulo = 'Solaris';
$libro->paginas = 216;

echo $libro->titulo . '<br>';
echo $libro->paginas;

// Si una clase hija usa extends Libro, sería rechazada porque la clase Libro usa final que hace que esa misma clase no pueda tener herencia.