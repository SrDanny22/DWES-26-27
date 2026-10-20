<?php

declare(strict_types=1);

class Autor {
    public string $nombre;

    public function __construct(string $nombre) {
        $this->nombre = $nombre;
    }
}

final class Libro
{
 public function __construct(
 public string $titulo,
 public  ?Autor $autor = null,
 ) {}
}
$conAutor = new Libro('Dune', new Autor('Frank Herbert'));
$sinAutor = new Libro('Relato anónimo');

echo $conAutor->autor?->nombre ?? 'Sin autor';
echo '<br>';
echo $sinAutor->autor?->nombre ?? 'Sin Autor';

// ?-> Devuelve NULL cuando sea null, y si no es null, devuelve el nombre